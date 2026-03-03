import requests
import json

def test_recommendation(prompt):
    url = "http://localhost:5001/recommend"
    payload = {
        "user_id": 1,
        "prompt": prompt
    }
    
    try:
        response = requests.post(url, json=payload)
        response.raise_for_status()
        data = response.json()
        
        print(f"\nPrompt: {prompt}")
        print("-" * 30)
        
        hotels = data.get('recommended_hotels', [])
        if not hotels:
            print("No recommendations found.")
            print(f"Response keys: {data.keys()}")
            return

        # Print top 3
        for i, hotel in enumerate(hotels[:3]):
            print(f"{i+1}. {hotel['hotel_name']} ({hotel['city']})")
            print(f"   Price: {hotel.get('price', 'N/A')} PKR")
            print(f"   View: {hotel.get('view', 'N/A')}")
            print(f"   Score: {hotel.get('match_score', 'N/A')}")
            
    except Exception as e:
        print(f"Error: {e}")

if __name__ == "__main__":
    # Test 1: Explicit Budget + View
    test_recommendation("I want a hotel with mountain view under 5000 PKR")
    
    # Test 2: Just Budget
    test_recommendation("Find me a cheap hotel budget 4000")
    
    # Test 3: No Budget (Should use NCF)
    test_recommendation("Best hotel in Paris")

    # Test 4: Explicit Budget Payload (Simulating Slider)
    print("\nTest 4: Explicit Budget Payload (Slider at 10000)")
    payload = {
        "user_id": 1,
        "prompt": "I want a hotel",
        "budget": 10000
    }
    try:
        response = requests.post("http://localhost:5001/recommend", json=payload)
        data = response.json()
        hotels = data.get('recommended_hotels', [])
        if hotels:
            print(f"Top Result: {hotels[0]['hotel_name']} - Price: {hotels[0].get('price')} PKR")
        else:
            print("No hotels found.")
    except Exception as e:
        print(f"Error: {e}")
