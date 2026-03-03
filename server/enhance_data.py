
import random
from pymongo import MongoClient
import pandas as pd
import numpy as np

# Connect to MongoDB
try:
    client = MongoClient('mongodb://localhost:27017/')
    db = client['hotel_recommendation']
    collection = db['hotels']
    ratings_collection = db['ratings']
    
    # Clear existing data to avoid duplicates/inconsistencies with new structure
    collection.delete_many({}) 
    ratings_collection.delete_many({})
    print("Connected to MongoDB and cleared existing data.")
except Exception as e:
    print(f"Error connecting to MongoDB: {e}")
    exit()

# Synthetic Data Generation
countries = [
    {"country": "USA", "cities": ["New York", "Los Angeles", "Miami", "Las Vegas", "Chicago"]},
    {"country": "UK", "cities": ["London", "Manchester", "Edinburgh", "Liverpool", "Birmingham"]},
    {"country": "France", "cities": ["Paris", "Nice", "Lyon", "Marseille", "Bordeaux"]},
    {"country": "UAE", "cities": ["Dubai", "Abu Dhabi", "Sharjah", "Ajman", "Fujairah"]},
    {"country": "Japan", "cities": ["Tokyo", "Kyoto", "Osaka", "Sapporo", "Yokohama"]},
    {"country": "Thailand", "cities": ["Bangkok", "Phuket", "Chiang Mai", "Pattaya", "Krabi"]},
    {"country": "Turkey", "cities": ["Istanbul", "Antalya", "Cappadocia", "Bodrum", "Izmir"]},
    {"country": "Italy", "cities": ["Rome", "Venice", "Florence", "Milan", "Naples"]},
    {"country": "Spain", "cities": ["Barcelona", "Madrid", "Seville", "Valencia", "Ibiza"]},
    {"country": "Pakistan", "cities": ["Lahore", "Karachi", "Islamabad", "Murree", "Hunza", "Peshawar", "Quetta", "Multan", "Faisalabad", "Sialkot", "Abbottabad", "Swat", "Skardu", "Gilgit"]},
    {"country": "China", "cities": ["Beijing", "Shanghai", "Guangzhou", "Shenzhen", "Chengdu", "Xi'an"]},
    {"country": "Germany", "cities": ["Berlin", "Munich", "Hamburg", "Frankfurt", "Cologne"]},
    {"country": "Canada", "cities": ["Toronto", "Vancouver", "Montreal", "Calgary", "Ottawa"]},
    {"country": "Australia", "cities": ["Sydney", "Melbourne", "Brisbane", "Perth", "Adelaide"]},
    {"country": "Switzerland", "cities": ["Zurich", "Geneva", "Basel", "Bern", "Lucerne"]}
]

hotel_prefixes = ["Grand", "Royal", "Luxury", "Cozy", "City", "Ocean", "Mountain", "Heritage", "Pearl", "Elite", "Sunshine", "Golden", "Silver", "Diamond", "Imperial", "Dragon", "Lotus", "Emperor"]
hotel_suffixes = ["Hotel", "Resort", "Suites", "Inn", "Lodge", "Palace", "Plaza", "Residency", "Manor", "Villas", "Retreat", "Haven", "Court"]

amenities_tags = [
    "Free WiFi", "Swimming Pool", "Spa", "Gym", "Breakfast Included", "Near Beach", "City Center", "Airport Shuttle", 
    "Family Friendly", "Couples", "Honeymoon", "Luxury", "Budget", "Business Center", "Pet Friendly", "Ocean View", 
    "Mountain View", "Historic", "Modern", "Boutique", "All Inclusive", "5 Star", "4 Star", "3 Star"
]

# Explicit Room Capacity Tags
room_types = [
    "1 Bed", "2 Beds", "3 Beds", "4 Beds", "5 Beds", 
    "Single Room", "Double Room", "Family Room", "Penthouse", "King Suite"
]

# Views / Preferences for Strict Filtering
views = ["Mountain View", "Ocean View", "City View", "Garden View", "Pool View", "Sea View", "Lake View"]

trip_types = ["Leisure trip", "Business trip", "Solo traveller", "Family with young children", "Couple", "Group", "People with friends"]

new_hotels = []
hotel_id_counter = 1

for country_info in countries:
    country = country_info["country"]
    for city in country_info["cities"]:
        # Generate 20 hotels per city
        for _ in range(20):
            name = f"{random.choice(hotel_prefixes)} {random.choice(hotel_suffixes)} {city}"
            
            # Generate tags
            city_tag = city
            country_tag = country
            selected_amenities = random.sample(amenities_tags, k=random.randint(4, 8))
            selected_trip_types = random.sample(trip_types, k=random.randint(1, 3))
            
            # Select 1-2 room types to tag this hotel with
            selected_room_types = random.sample(room_types, k=random.randint(1, 2))
            
            # Select a view
            selected_view = random.choice(views)
            
            # Combine tags into a string like the CSV format
            tags_list = [city_tag, country_tag, selected_view] + selected_amenities + selected_trip_types + selected_room_types
            tags_str = "~".join(tags_list)
            
            # Rating
            rating = round(random.uniform(7.0, 9.8), 1)
            
            hotel = {
                "hotel_id": hotel_id_counter, # Numeric ID for Embedding
                "hotel_name": name,
                "url": "https://www.booking.com", # Placeholder
                "hotel_url": "https://www.booking.com", # Placeholder
                "avg_rating": rating,
                "tags": tags_str,
                "total_positive": random.randint(10, 100),
                "total_negative": random.randint(0, 10),
                "total_neutral": random.randint(5, 20),
                "total_reviews": random.randint(20, 150),
                "city": city,
                "country": country,
                "price": random.randint(3000, 50000), # PKR Range
                "room_capacity": selected_room_types, # List
                "view": selected_view # Explicit field
            }
            new_hotels.append(hotel)
            hotel_id_counter += 1

# Insert hotels into MongoDB
if new_hotels:
    collection.insert_many(new_hotels)
    print(f"Successfully added {len(new_hotels)} new international hotels (including China & Room Types) to MongoDB.")
else:
    print("No hotels generated.")

# --- GENERATE USER INTERACTION DATA FOR NCF ---
# We simulate users rating hotels to train the NCF model
num_users = 100
num_interactions = 5000
ratings_data = []

# Assuming hotel_ids range from 1 to len(new_hotels)
max_hotel_id = len(new_hotels)

for _ in range(num_interactions):
    user_id = random.randint(1, num_users)
    hotel_id = random.randint(1, max_hotel_id)
    # Generate a rating, biased towards higher ratings to simulate positive interactions usually captured
    rating = np.random.choice([3, 4, 5, 1, 2], p=[0.1, 0.3, 0.4, 0.1, 0.1])
    
    ratings_data.append({
        "user_id": user_id,
        "hotel_id": hotel_id,
        "rating": int(rating)
    })

if ratings_data:
    ratings_collection.insert_many(ratings_data)
    print(f"Successfully added {len(ratings_data)} user ratings to MongoDB.")
