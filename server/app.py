
import os
import re
import random
import json
import numpy as np
import pandas as pd
import requests
from flask import Flask, request, jsonify
from flask_cors import CORS
from pymongo import MongoClient

# NLP & ML Libraries
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity
from sklearn.neural_network import MLPRegressor
from sklearn.preprocessing import LabelEncoder, MinMaxScaler, OneHotEncoder, MultiLabelBinarizer
from sklearn.model_selection import train_test_split
import numpy as np
import nltk
from nltk.sentiment import SentimentIntensityAnalyzer

# Initialize NLTK VADER
try:
    sia = SentimentIntensityAnalyzer()
except LookupError:
    nltk.download('vader_lexicon')
    sia = SentimentIntensityAnalyzer()
except Exception as e:
    print(f"NLTK VADER Init Error: {e}")
    sia = None

# Initialize Flask
app = Flask(__name__)
CORS(app)

import os

# --- CONFIGURATION ---
# Replace <YOUR_CLUSTER_ADDRESS> with your actual Atlas cluster address (e.g., cluster0.xxxxx.mongodb.net)
MONGO_URI = os.getenv('MONGO_URI', 'mongodb+srv://azam2004ch_db_user:4uCLYQa9cOuz6D0E@<YOUR_CLUSTER_ADDRESS>/hotel_recommendation?retryWrites=true&w=majority')
DB_NAME = 'hotel_recommendation'
HOTEL_COLLECTION = 'hotels'
RATING_COLLECTION = 'ratings'

# --- MONGODB CONNECTION & DATA LOADING ---
try:
    client = MongoClient(MONGO_URI)
    db = client[DB_NAME]
    
    # Load Hotels
    hotels_cursor = db[HOTEL_COLLECTION].find({})
    hotels_df = pd.DataFrame(list(hotels_cursor))
    if '_id' in hotels_df.columns:
        # hotels_df.drop('_id', axis=1, inplace=True) # DON'T DROP, RENAME
        hotels_df.rename(columns={'_id': 'hotel_id'}, inplace=True)
        hotels_df['hotel_id'] = hotels_df['hotel_id'].astype(str)
        
    # --- SIMULATE CUISINES (For Food & Restaurant Service) ---
    def assign_cuisine(row):
        cuisines = set()
        # Default random assignment for variety
        all_cuisines = ['Asian', 'Continental', 'Chinese', 'French', 'Desi']
        
        # Location based logic
        loc_text = (str(row.get('city', '')) + " " + str(row.get('country', ''))).lower()
        if 'china' in loc_text or 'beijing' in loc_text or 'shanghai' in loc_text:
            cuisines.add('Chinese')
            cuisines.add('Asian')
        if 'france' in loc_text or 'paris' in loc_text:
            cuisines.add('French')
            cuisines.add('Continental')
        if 'pakistan' in loc_text or 'india' in loc_text or 'lahore' in loc_text or 'delhi' in loc_text:
            cuisines.add('Desi')
            cuisines.add('Asian')
        if 'japan' in loc_text or 'tokyo' in loc_text:
             cuisines.add('Asian')
        
        # Add random if empty or just to enrich
        if not cuisines:
            cuisines.update(random.sample(all_cuisines, k=random.randint(1, 3)))
        else:
             # Chance to add 'Continental' or others
             if random.random() > 0.7:
                 cuisines.add('Continental')
        
        return list(cuisines)

    if not hotels_df.empty:
        hotels_df['cuisines'] = hotels_df.apply(assign_cuisine, axis=1)
        print("Cuisines assigned to hotels.")
        
    print(f"Loaded {len(hotels_df)} hotels.")
    print(f"Hotel Columns: {hotels_df.columns.tolist()}")
    
    # Load Ratings
    ratings_cursor = db[RATING_COLLECTION].find({})
    ratings_df = pd.DataFrame(list(ratings_cursor))
    if '_id' in ratings_df.columns:
        ratings_df.drop('_id', axis=1, inplace=True)
    
    print(f"Loaded {len(ratings_df)} ratings.")
    print(f"Rating Columns: {ratings_df.columns.tolist()}")

    # Calculate Average Rating per Hotel
    try:
        if not ratings_df.empty and 'hotel_id' in ratings_df.columns and 'rating' in ratings_df.columns:
            # Ensure hotel_id types match (str)
            ratings_df['hotel_id'] = ratings_df['hotel_id'].astype(str)
            hotels_df['hotel_id'] = hotels_df['hotel_id'].astype(str)
            
            avg_ratings = ratings_df.groupby('hotel_id')['rating'].mean().reset_index()
            avg_ratings.rename(columns={'rating': 'avg_rating'}, inplace=True)
            # Merge into hotels_df
            if not hotels_df.empty and 'hotel_id' in hotels_df.columns:
                hotels_df = hotels_df.merge(avg_ratings, on='hotel_id', how='left')
                hotels_df['avg_rating'] = hotels_df['avg_rating'].fillna(3.0) # Default neutral
                print("Average ratings calculated and merged.")
        elif not hotels_df.empty:
            print("Ratings data missing required columns or empty. Using default rating 3.0")
            hotels_df['avg_rating'] = 3.0
    except Exception as e:
        print(f"Error calculating average ratings: {e}")
        if not hotels_df.empty:
            hotels_df['avg_rating'] = 3.0

except Exception as e:
    print(f"Error connecting to MongoDB or loading initial data: {e}")
    hotels_df = pd.DataFrame()
    ratings_df = pd.DataFrame()

# --- PREPROCESSING FOR LOCATION MATCHING ---
unique_locations = set()
if not hotels_df.empty:
    if 'city' in hotels_df.columns:
        unique_locations.update(hotels_df['city'].dropna().str.lower().unique())
    if 'country' in hotels_df.columns:
        unique_locations.update(hotels_df['country'].dropna().str.lower().unique())
    print(f"Loaded {len(unique_locations)} unique locations for matching.")

# --- PREPROCESSING FOR SMART MATCH (COSINE SIMILARITY) ---
# We need to vectorize Price, View, and Room Type
scaler_price = MinMaxScaler()
encoder_view = OneHotEncoder(sparse_output=False, handle_unknown='ignore')
mlb_room = MultiLabelBinarizer()

if not hotels_df.empty:
    # 1. Fit Price Scaler
    # We first scale price to 0-1
    hotels_df['price_scaled'] = scaler_price.fit_transform(hotels_df[['price']])
    
    # NEW: Embed Price as 2D Vector (cos, sin) to make Cosine Similarity meaningful
    # 0 -> (1, 0) (Low Price)
    # 1 -> (0, 1) (High Price)
    # This ensures max similarity between similar prices and min similarity between opposite prices.
    # Angle varies from 0 to 90 degrees (pi/2)
    hotels_df['price_vec_1'] = np.cos(hotels_df['price_scaled'] * np.pi / 2)
    hotels_df['price_vec_2'] = np.sin(hotels_df['price_scaled'] * np.pi / 2)
    
    # 2. Fit View Encoder
    # Ensure view exists, if not create default
    if 'view' not in hotels_df.columns:
        hotels_df['view'] = 'City View' # Default for real data
        
    # Ensure view is string and fillna
    hotels_df['view'] = hotels_df['view'].fillna('No View')
    view_features = encoder_view.fit_transform(hotels_df[['view']])
    
    # 3. Fit Room Type Binarizer
    # Ensure room_capacity exists
    if 'room_capacity' not in hotels_df.columns:
         # Try to extract from tags if available, else default
         if 'tags' in hotels_df.columns:
             def extract_rooms(tags):
                 if not isinstance(tags, str): return ['Double']
                 rooms = []
                 keywords = ['Double', 'Single', 'Twin', 'Suite', 'Family', 'Studio']
                 for k in keywords:
                     if k in tags:
                         rooms.append(k)
                 return rooms if rooms else ['Double']
             hotels_df['room_capacity'] = hotels_df['tags'].apply(extract_rooms)
         else:
             hotels_df['room_capacity'] = [['Double']] * len(hotels_df)

    # Ensure room_capacity is list
    hotels_df['room_capacity'] = hotels_df['room_capacity'].apply(lambda x: x if isinstance(x, list) else [])
    room_features = mlb_room.fit_transform(hotels_df['room_capacity'])
    
    # 4. Combine into Feature Matrix
    # Shape: (n_hotels, 2 + n_views + n_rooms)
    # We use this for Cosine Similarity
    smart_features_matrix = np.hstack([
        hotels_df[['price_vec_1', 'price_vec_2']].values,
        view_features,
        room_features
    ])
    print("Smart Match Feature Matrix computed.")
else:
    smart_features_matrix = None

# --- PREPROCESSING FOR CONTENT-BASED FILTERING ---
# Create a combined string for TF-IDF
if not hotels_df.empty:
    hotels_df['combined_features'] = hotels_df.apply(
        lambda x: f"{x['hotel_name']} {x['city']} {x['country']} {x['tags']} {x.get('view', '')} {' '.join(x.get('cuisines', []))}".strip(), axis=1
    )
    
    # Initialize TF-IDF Vectorizer
    tfidf_vectorizer = TfidfVectorizer(stop_words='english')
    tfidf_matrix = tfidf_vectorizer.fit_transform(hotels_df['combined_features'])
    print("TF-IDF matrix computed.")
else:
    tfidf_vectorizer = None
    tfidf_matrix = None

# --- NCF / DEEP LEARNING MODEL (MLPRegressor) ---
ncf_model = None
user_encoder = LabelEncoder()
hotel_encoder = LabelEncoder()

if not ratings_df.empty:
    print("Training NCF Model (MLPRegressor)...")
    try:
        # Encode User and Hotel IDs
        ratings_df['user_encoded'] = user_encoder.fit_transform(ratings_df['user_id'])
        ratings_df['hotel_encoded'] = hotel_encoder.fit_transform(ratings_df['hotel_id'])
        
        # Prepare Features (User, Hotel) -> Rating
        X = ratings_df[['user_encoded', 'hotel_encoded']].values
        y = ratings_df['rating'].values
        
        # Scale Ratings to 0-1 for better convergence (optional but good for neural nets)
        scaler = MinMaxScaler()
        y_scaled = scaler.fit_transform(y.reshape(-1, 1)).flatten()
        
        # Train MLP (Neural Network)
        # Architecture: Input(2) -> Dense(64, relu) -> Dense(32, relu) -> Output(1)
        ncf_model = MLPRegressor(hidden_layer_sizes=(64, 32), activation='relu', solver='adam', max_iter=500, random_state=42)
        ncf_model.fit(X, y_scaled)
        
        print("NCF Model trained successfully.")
    except Exception as e:
        print(f"Error training NCF model: {e}")
        ncf_model = None
else:
    print("No ratings data found. NCF Model skipped.")


# --- SENTIMENT ANALYSIS HELPER ---
def analyze_sentiment(text):
    """
    Analyzes the sentiment of the text using NLTK VADER.
    Returns a compound score between -1 (Negative) and +1 (Positive).
    """
    if not sia:
        return 0.0
    try:
        scores = sia.polarity_scores(text)
        return scores['compound']
    except Exception as e:
        print(f"Sentiment Analysis Error: {e}")
        return 0.0

# --- INTENT EXTRACTION HELPER ---
def extract_intent_regex(prompt):
    """
    Fallback regex extraction if Ollama fails.
    """
    intent = {
        "locations": [],
        "room_type": None,
        "view": None,
        "budget": None
    }
    
    prompt_lower = prompt.lower()
    
    # 1. Extract Location (Improved: Check against DB locations + Regex)
    # Check known locations from DB
    for loc in unique_locations:
        # Check for whole word match to avoid partials like 'male' in 'female'
        if re.search(r'\b' + re.escape(loc) + r'\b', prompt_lower):
            intent["locations"].append(loc.title()) # Store as Title Case
            
    # Fallback Regex for unknown locations (e.g. "in Beijing")
    # Look for "in [Location]" where Location is a word
    if not intent["locations"]:
        loc_matches = re.findall(r'\b(?:in|at|near|to)\s+([a-zA-Z]+)', prompt_lower)
        for loc in loc_matches:
            if loc not in ["the", "a", "an", "my", "our"]: # Ignore stop words
                intent["locations"].append(loc.title())

    # 2. Extract Room Type
    prompt_lower = prompt.lower()
    if 'single' in prompt_lower: intent["room_type"] = 'single'
    elif 'double' in prompt_lower: intent["room_type"] = 'double'
    elif 'triple' in prompt_lower or 'family' in prompt_lower: intent["room_type"] = 'family'
    
    # 3. Extract View
    views = ["mountain", "ocean", "sea", "city", "lake", "pool", "garden", "beach"]
    for v in views:
        if v in prompt_lower:
            intent["view"] = v.capitalize()
            break
            
    # 4. Extract Budget
    # Look for "under 5000", "5000 pkr", "budget 5000"
    budget_match = re.search(r'(?:under|budget|cost|price)\s*(?:is|of)?\s*(\d+)', prompt_lower)
    if not budget_match:
        budget_match = re.search(r'(\d+)\s*(?:pkr|rs)', prompt_lower)
        
    if budget_match:
        try:
            intent["budget"] = int(budget_match.group(1))
        except:
            pass
            
    # 5. Extract Cuisine
    cuisines_list = ['asian', 'continental', 'chinese', 'french', 'desi']
    intent['cuisines'] = []
    for c in cuisines_list:
        if c in prompt_lower:
            intent['cuisines'].append(c.title()) # Store as Title Case
            
    return intent

def extract_intent_ollama(prompt):
    """
    Uses local Ollama (Llama 3) to extract intent from user query.
    Returns JSON with Location, Room Type, and View.
    """
    url = "http://localhost:11434/api/generate"
    
    system_prompt = (
        "You are a hotel concierge. Extract the Location, Room Type (Single/Double/Triple), "
        "and View (Mountain/Beach) from this text: "
        f"'{prompt}'. Return only JSON with keys: 'location', 'room_type', 'view'. "
        "If a field is not mentioned, use null."
    )
    
    payload = {
        "model": "llama3",
        "prompt": system_prompt,
        "stream": False,
        "format": "json"
    }
    
    try:
        print(f"Querying Ollama with prompt: {prompt}")
        response = requests.post(url, json=payload, timeout=10)
        response.raise_for_status()
        result = response.json()
        
        extracted_text = result.get('response', '{}')
        print(f"Ollama Raw Response: {extracted_text}")
        
        # Try to find JSON object in the response
        json_match = re.search(r'\{.*\}', extracted_text, re.DOTALL)
        if json_match:
            data = json.loads(json_match.group(0))
        else:
            data = json.loads(extracted_text)
        
        # Normalize keys to match our internal schema
        normalized = {
            "locations": [],
            "room_type": None,
            "view": None
        }
        
        if data.get('location'):
            # Ensure it's a list or string, we want list
            loc = data['location']
            if isinstance(loc, list):
                normalized["locations"] = loc
            elif isinstance(loc, str):
                normalized["locations"] = [loc]
                
        if data.get('room_type'):
            rt = str(data['room_type']).lower()
            if 'single' in rt: normalized["room_type"] = 'single'
            elif 'double' in rt: normalized["room_type"] = 'double'
            elif 'triple' in rt or 'family' in rt: normalized["room_type"] = 'family'
            elif 'suite' in rt: normalized["room_type"] = 'suite'
            
        if data.get('view'):
            v = str(data['view']).lower()
            # Map back to our capitalized views
            view_map = {
                "mountain": "Mountain", "ocean": "Ocean", "sea": "Sea", 
                "city": "City", "lake": "Lake", "pool": "Pool", 
                "garden": "Garden", "beach": "Beach"
            }
            for key, val in view_map.items():
                if key in v:
                    normalized["view"] = val
                    break
        
        return normalized
        
    except Exception as e:
        print(f"Ollama Intent Extraction Failed: {e}")
        return None

# --- RECOMMENDATION ENDPOINT ---
@app.route('/recommend', methods=['POST'])
def recommend():
    try:
        data = request.get_json()
        prompt = data.get('prompt', '')
        explicit_budget = data.get('budget')
        user_id_input = data.get('user_id', 1) 
        
        if not prompt and not explicit_budget:
            return jsonify({'recommended_hotels': []})
            
        print(f"Processing prompt: {prompt}, Budget: {explicit_budget}")
        
        # 1. SENTIMENT ANALYSIS
        sentiment_score = analyze_sentiment(prompt)
        sentiment_label = 'neutral'
        if sentiment_score >= 0.05: sentiment_label = 'positive'
        elif sentiment_score <= -0.05: sentiment_label = 'negative'
        
        print(f"Sentiment: {sentiment_label} (Score: {sentiment_score})")

        # 2. INTENT EXTRACTION
        intent = None
        
        # Try Ollama first
        try:
            intent = extract_intent_ollama(prompt)
        except Exception as e:
            print(f"Ollama extraction skipped/failed: {e}")
        
        # Always run Regex for Budget (since Ollama prompt doesn't ask for it) and fallback
        regex_intent = extract_intent_regex(prompt)
        
        if not intent:
            print("Using Regex Intent Extraction")
            intent = regex_intent
        else:
            # Merge Budget from Regex if not present in Ollama result
            if not intent.get('budget') and regex_intent.get('budget'):
                intent['budget'] = regex_intent['budget']
                print(f"Added Budget from Regex: {intent['budget']}")
            
            # Merge Cuisines from Regex
            if not intent.get('cuisines') and regex_intent.get('cuisines'):
                intent['cuisines'] = regex_intent['cuisines']
                print(f"Added Cuisines from Regex: {intent['cuisines']}")
                
        # Override/Augment with Explicit Budget from Slider
        if explicit_budget:
            try:
                intent['budget'] = int(explicit_budget)
                print(f"Using Explicit Budget from Slider: {intent['budget']}")
            except:
                pass

        print(f"Final Extracted Intent: {intent}")
        
        # 2. FILTERING
        print(f"Initial Hotels Count: {len(hotels_df)}")
        
        # Start with all hotels
        filtered_df = hotels_df.copy()
        
        # Location Filtering (Strict) - We keep this Strict because Location is physical
        if intent.get('locations'):
            locs = [l.lower() for l in intent['locations']]
            print(f"Filtering by Location: {locs}")
            # Check if city or country matches
            mask = filtered_df.apply(lambda x: any(l in str(x.get('city', '')).lower() or l in str(x.get('country', '')).lower() for l in locs), axis=1)
            loc_filtered_df = filtered_df[mask]
            
            if loc_filtered_df.empty:
                print("Location filter returned 0 results. Suggesting generic popular hotels instead.")
                # We don't overwrite filtered_df, so we effectively ignore the location filter but maybe add a flag?
                # Or we can just return empty and let the frontend handle it?
                # User wants "recommendations shows according hotels".
                # Let's return results but maybe flag that location wasn't found?
                # For now, let's keep strict but maybe add fuzzy matching?
                pass 
            else:
                filtered_df = loc_filtered_df
            print(f"Hotels after Location Filter: {len(filtered_df)}")

        # Cuisine Filtering
        if intent.get('cuisines'):
            req_cuisines = [c.lower() for c in intent['cuisines']]
            print(f"Filtering by Cuisine: {req_cuisines}")
            # Check if hotel has ANY of the requested cuisines
            # hotel['cuisines'] is a list of strings
            cuisine_filtered_df = filtered_df[filtered_df['cuisines'].apply(
                lambda x: any(rc in [hc.lower() for hc in x] for rc in req_cuisines) if isinstance(x, list) else False
            )]
            
            if cuisine_filtered_df.empty:
                 print("Cuisine filter returned 0 results. Relaxing.")
            else:
                 filtered_df = cuisine_filtered_df
            print(f"Hotels after Cuisine Filter: {len(filtered_df)}")

        # --- SENTIMENT-BASED FILTERING/BOOSTING ---
        # If user expresses negative sentiment (e.g., complaining about bad hotels), 
        # we strictly filter for high-rated hotels (Avg Rating >= 4.0)
        if sentiment_score < -0.2:
            if 'avg_rating' in filtered_df.columns:
                print("Negative Sentiment Detected: Applying Strict Quality Filter (Rating >= 4.0)")
                
                # Try strict filter first
                strict_filtered = filtered_df[filtered_df['avg_rating'] >= 4.0]
                
                if strict_filtered.empty:
                     print("Strict filter returned 0 results. Relaxing constraint to avoid empty results.")
                     # Fallback: Try >= 3.5
                     mid_filtered = filtered_df[filtered_df['avg_rating'] >= 3.5]
                     if mid_filtered.empty:
                         print("Mid filter also returned 0 results. Keeping original list.")
                         # Don't filter if it removes everything
                     else:
                         filtered_df = mid_filtered
                else:
                     filtered_df = strict_filtered
                
                print(f"Hotels after Sentiment Quality Filter: {len(filtered_df)}")
        
        # If user is very positive, we can boost the 'match_score' later, 
        # or pre-filter for >= 3.0 to avoid killing the vibe.
        if sentiment_score > 0.5:
             if 'avg_rating' in filtered_df.columns:
                print("Positive Sentiment Detected: Removing very low rated hotels (< 3.0)")
                filtered_df = filtered_df[filtered_df['avg_rating'] >= 3.0]

        # Budget Filtering (Strict) - As requested by user ("actual hotels of that price cost")
        if intent.get('budget'):
            budget_val = intent['budget']
            print(f"Filtering by Budget: <= {budget_val}")
            # Ensure price column is numeric
            filtered_df['price'] = pd.to_numeric(filtered_df['price'], errors='coerce').fillna(999999)
            filtered_df = filtered_df[filtered_df['price'] <= budget_val]
            print(f"Hotels after Budget Filter: {len(filtered_df)}")
        
        # Smart Match Logic Check
        # If Budget is present, OR if we want to allow "Smart Match" for View/RoomType even without Budget
        use_smart_match = intent.get('budget') is not None
        
        if use_smart_match:
            print("Using Smart Match (Cosine Similarity) Logic")
            
            # Construct User Query Vector
            # 1. Price
            budget = intent.get('budget', 50000) # Default to high if not set but smart match triggered? 
            # Actually, if budget is None, we shouldn't penalize price. But here we know budget IS set.
            user_price_scaled = scaler_price.transform([[budget]])[0][0]
            # Clip to 0-1 just in case
            user_price_scaled = max(0.0, min(1.0, user_price_scaled))
            
            user_price_vec_1 = np.cos(user_price_scaled * np.pi / 2)
            user_price_vec_2 = np.sin(user_price_scaled * np.pi / 2)
            
            # 2. View
            user_view = intent.get('view', 'No View') # If not specified, maybe 'No View' or neutral?
            # Ideally if user doesn't care about view, we shouldn't filter by it.
            # But Cosine Similarity needs fixed dimensions.
            # If user didn't specify view, we can set all view features to 0?
            if intent.get('view'):
                user_view_vec = encoder_view.transform([[intent['view']]])[0]
            else:
                user_view_vec = np.zeros(len(encoder_view.categories_[0]))
                
            # 3. Room Type
            if intent.get('room_type'):
                # MultiLabelBinarizer expects a list of lists/sets for transform
                # But here we just want to match ONE type.
                # If user wants "Double", we want hotels that HAVE "Double".
                # MLB transform expects input like [['Double']]
                user_room_vec = mlb_room.transform([[intent['room_type']]])[0]
            else:
                user_room_vec = np.zeros(len(mlb_room.classes_))
                
            # Combine into User Vector
            user_vector = np.hstack([
                [user_price_vec_1, user_price_vec_2],
                user_view_vec,
                user_room_vec
            ]).reshape(1, -1)
            
            # Get Feature Matrix for Filtered Hotels
            # We need to subset the precomputed matrix based on the filtered_df indices
            # filtered_df might have different index than original hotels_df
            # We can use the index to map back
            
            # Get indices of filtered hotels
            indices = filtered_df.index
            
            if not indices.empty:
                filtered_features = smart_features_matrix[indices]
                
                # Compute Cosine Similarity
                # Result shape: (1, n_filtered_hotels)
                similarity_scores = cosine_similarity(user_vector, filtered_features).flatten()
                
                # Assign scores
                filtered_df['match_score'] = similarity_scores
                
                # Sort
                filtered_df = filtered_df.sort_values(by='match_score', ascending=False)
                
                # Add Debug Info
                print(f"Smart Match Top Score: {filtered_df['match_score'].max()}")
                
                # We skip the NCF/TF-IDF step if we used Smart Match, 
                # OR we can combine them? User asked for "Smart Match... return list sorted by this score"
                # So we use this score primarily.
                top_results = filtered_df.head(12)
            else:
                top_results = pd.DataFrame()
                
        else:
            # Traditional Strict Filtering for Room Type & View
            if intent['room_type']:
                # Room capacity is a list, check if intent['room_type'] is in it
                # Using string containment for safety
                rt = intent['room_type'].lower()
                # Assuming 'room_capacity' column contains lists of strings
                if 'room_capacity' in filtered_df.columns:
                     filtered_df = filtered_df[filtered_df['room_capacity'].apply(
                        lambda x: any(rt in r.lower() for r in x) if isinstance(x, list) else False
                     )]
                else:
                    print("Warning: room_capacity column missing in filtered_df, skipping room type filter.")

                
            if intent['view']:
                # Exact or partial match for View
                v = intent['view'].lower()
                filtered_df = filtered_df[filtered_df['view'].apply(lambda x: v in str(x).lower())]
            
            # 3. RANKING (NCF Hybrid or Content-Based Fallback)
            if not filtered_df.empty:
                # Check if User ID is known to the NCF model
                can_use_ncf = False
                if ncf_model and user_id_input in user_encoder.classes_:
                    try:
                        user_encoded = user_encoder.transform([user_id_input])[0]
                        # Filter hotels that are also known to the encoder
                        known_hotels_mask = filtered_df['hotel_id'].isin(hotel_encoder.classes_)
                        known_hotels_df = filtered_df[known_hotels_mask].copy()
                        
                        if not known_hotels_df.empty:
                            # Prepare input for prediction
                            hotel_encoded = hotel_encoder.transform(known_hotels_df['hotel_id'])
                            # Create input array: [user_encoded, hotel_encoded] pairs
                            X_pred = np.column_stack((np.full(len(hotel_encoded), user_encoded), hotel_encoded))
                            
                            # Predict Scores
                            predicted_scores = ncf_model.predict(X_pred)
                            known_hotels_df['match_score'] = predicted_scores
                            
                            # Use these scores
                            filtered_df = known_hotels_df.sort_values(by='match_score', ascending=False)
                            can_use_ncf = True
                            print(f"Used NCF Model for ranking. Top score: {filtered_df['match_score'].max()}")
                    except Exception as e:
                        print(f"NCF Prediction failed: {e}")
                        can_use_ncf = False
                
                if not can_use_ncf and tfidf_vectorizer:
                    # Fallback to TF-IDF
                    print("Using TF-IDF (Content-Based) ranking.")
                    try:
                        prompt_vec = tfidf_vectorizer.transform([prompt])
                        
                        # Map scores to hotel_id directly
                        # We need to map from original index to hotel_id then to current filtered_df
                        # But simpler: we have scores for ALL hotels in tfidf_matrix
                        # We need to assign them to filtered_df
                        
                        # Get indices of filtered hotels in the original df
                        # This is tricky if indices changed. 
                        # Best way: create a mapping of hotel_id -> score
                        all_scores = cosine_similarity(prompt_vec, tfidf_matrix).flatten()
                        score_map = dict(zip(hotels_df['hotel_id'], all_scores))
                        
                        filtered_df['match_score'] = filtered_df['hotel_id'].map(score_map).fillna(0)
                        
                        # Sort by Score -> Rating -> Price
                        filtered_df = filtered_df.sort_values(by=['match_score', 'avg_rating', 'price'], ascending=[False, False, True])
                    except Exception as e:
                        print(f"TF-IDF Ranking Failed: {e}")
                        # If failed, sort by Rating -> Price
                        filtered_df = filtered_df.sort_values(by=['avg_rating', 'price'], ascending=[False, True])
                elif not can_use_ncf:
                    # Sort by Rating -> Price if no ML model available
                    filtered_df = filtered_df.sort_values(by=['avg_rating', 'price'], ascending=[False, True])
                    
                top_results = filtered_df.head(12)
            else:
                top_results = pd.DataFrame()
        
        # Format for Frontend
        recommended_hotels = []
        for _, row in top_results.iterrows():
            hotel_dict = row.to_dict()
            if '_id' in hotel_dict: del hotel_dict['_id']
            # Clean up temporary columns
            if 'combined_features' in hotel_dict: del hotel_dict['combined_features']
            
            # Ensure Image
            hotel_dict['image'] = f'img/room-{random.randint(1, 3)}.jpg'
            
            recommended_hotels.append(hotel_dict)
            
        return jsonify({
            'sentiment': sentiment_label, 
            'sentiment_score': sentiment_score,
            'recommended_hotels': recommended_hotels,
            'debug_intent': intent
        })

    except Exception as e:
        print(f"Error in recommendation: {e}")
        import traceback
        traceback.print_exc()
        return jsonify({'error': str(e), 'recommended_hotels': []}), 500

if __name__ == '__main__':
    app.run(debug=True, port=5001)
