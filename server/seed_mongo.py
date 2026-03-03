import pandas as pd
from pymongo import MongoClient
import os

# Connect to MongoDB
try:
    mongo_uri = os.getenv('MONGO_URI', 'mongodb+srv://azam2004ch_db_user:4uCLYQa9cOuz6D0E@fyp.thvd8ca.mongodb.net/hotel_recommendation?retryWrites=true&w=majority')
    client = MongoClient(mongo_uri)
    db = client['hotel_recommendation']
    collection = db['hotels']
    
    # Check if data already exists
    # if collection.count_documents({}) > 0:
    #     print("Data already exists in MongoDB. Skipping import.")
    # else:
    
    # Always re-seed for now to ensure fresh data
    collection.delete_many({})
    print("Cleared existing MongoDB data.")
    
    # Load CSV
    csv_path = os.path.join(os.path.dirname(__file__), 'real_hotels.csv')
    df = pd.read_csv(csv_path)
    
    # Convert to dictionary records
    records = df.to_dict('records')
    
    # Insert into MongoDB
    collection.insert_many(records)
    print(f"Successfully inserted {len(records)} hotels into MongoDB.")
        
except Exception as e:
    print(f"Error connecting to MongoDB or inserting data: {e}")
