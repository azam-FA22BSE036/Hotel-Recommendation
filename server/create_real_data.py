
import pandas as pd
import random
import re

# Helper to format price
def get_price(rating, country, tags):
    base = 15000
    if country in ['USA', 'UK', 'UAE', 'France', 'Switzerland', 'Japan']:
        base = 30000
    elif country in ['Pakistan', 'India', 'Thailand']:
        base = 10000
    
    # Rating multiplier
    multiplier = 1 + ((rating - 7.0) / 3.0) # 7.0 -> 1x, 10.0 -> 2x
    
    # Luxury tag
    if 'Luxury' in tags or '5 Star' in tags:
        multiplier *= 1.5
    
    price = base * multiplier
    return int(price // 100 * 100) # Round to nearest 100

# Helper to extract name and country from URL
def parse_url(url):
    # url format: https://www.booking.com/hotel/be/chimay-b-and-b.en-gb.html
    try:
        match = re.search(r'/hotel/([a-z]+)/([^.]+)', url)
        if match:
            country_code = match.group(1)
            slug = match.group(2)
            name = slug.replace('-', ' ').title()
            
            # Fix common artifacts
            name = name.replace('Quot', '"').replace('Ndeg', '#')
            
            # Map country code
            country_map = {
                'be': 'Belgium', 'fr': 'France', 'gb': 'UK', 'us': 'USA', 'ae': 'UAE', 
                'pk': 'Pakistan', 'in': 'India', 'cn': 'China', 'jp': 'Japan', 
                'th': 'Thailand', 'tr': 'Turkey', 'it': 'Italy', 'es': 'Spain',
                'de': 'Germany', 'ca': 'Canada', 'au': 'Australia', 'ch': 'Switzerland',
                'nl': 'Netherlands', 'by': 'Belarus'
            }
            country = country_map.get(country_code, 'International')
            
            return name, country
    except:
        pass
    return "Unknown Hotel", "International"

# Load existing CSV
try:
    df = pd.read_csv('server/hotels_profile.csv')
    print(f"Loaded {len(df)} rows from existing CSV.")
except FileNotFoundError:
    print("CSV not found, creating new.")
    df = pd.DataFrame(columns=['hotel_name', 'url', 'hotel_url', 'avg_rating', 'tags', 'total_reviews'])

# Process existing data
new_rows = []
for index, row in df.iterrows():
    url = row['hotel_url']
    if pd.isna(url): continue
    
    real_name, country = parse_url(url)
    
    # Use existing rating or random
    rating = row.get('avg_rating', 8.0)
    if pd.isna(rating): rating = 8.0
    rating = float(rating)
    
    tags = row.get('tags', '')
    if pd.isna(tags): tags = ''
    
    # Clean tags
    tags_list = tags.split('~')
    clean_tags = [t for t in tags_list if 'Stayed' not in t and 'Submitted' not in t and 'review' not in t]
    
    # Add location tags
    clean_tags.append(country)
    
    price = get_price(rating, country, clean_tags)
    
    new_rows.append({
        'hotel_name': real_name,
        'city': country, # Default city to country for now if unknown
        'country': country,
        'price': price,
        'rating': rating,
        'tags': '~'.join(clean_tags),
        'image': f'img/room-{random.randint(1,3)}.jpg',
        'url': url,
        'booking_url': url,
        'description': f"Experience a wonderful stay at {real_name} in {country}. {row.get('description', '')}"
    })

# Add Manual Real Hotels
manual_hotels = [
    # Pakistan
    ("Pearl Continental Lahore", "Lahore", "Pakistan", 35000, 8.5, "https://www.booking.com/hotel/pk/pearl-continental-lahore.en-gb.html", "Luxury~Pool~Gym~City Center"),
    ("Avari Hotel Lahore", "Lahore", "Pakistan", 28000, 8.2, "https://www.booking.com/hotel/pk/avari-lahore.en-gb.html", "Luxury~Pool~Spa"),
    ("Serena Hotel Islamabad", "Islamabad", "Pakistan", 45000, 9.0, "https://www.booking.com/hotel/pk/islamabad-serena.en-gb.html", "Luxury~Mountain View~5 Star"),
    ("Movenpick Hotel Karachi", "Karachi", "Pakistan", 32000, 8.4, "https://www.booking.com/hotel/pk/moevenpick-karachi.en-gb.html", "Luxury~City Center~Business"),
    ("PC Bhurban", "Murree", "Pakistan", 40000, 8.8, "https://www.booking.com/hotel/pk/pearl-continental-bhurban.en-gb.html", "Mountain View~Resort~Family"),
    
    # UK
    ("The Ritz London", "London", "UK", 250000, 9.5, "https://www.booking.com/hotel/gb/the-ritz-london.en-gb.html", "Luxury~Historic~5 Star~City Center"),
    ("The Savoy", "London", "UK", 200000, 9.4, "https://www.booking.com/hotel/gb/the-savoy.en-gb.html", "Luxury~River View~5 Star"),
    ("Hilton London Metropole", "London", "UK", 60000, 7.9, "https://www.booking.com/hotel/gb/hilton-london-metropole.en-gb.html", "Business~City Center~Gym"),
    
    # UAE
    ("Burj Al Arab Jumeirah", "Dubai", "UAE", 500000, 9.8, "https://www.booking.com/hotel/ae/burj-al-arab.en-gb.html", "Luxury~Ocean View~7 Star~Beach"),
    ("Atlantis The Palm", "Dubai", "UAE", 150000, 9.2, "https://www.booking.com/hotel/ae/atlantis-the-palm.en-gb.html", "Resort~Water Park~Family~Beach"),
    ("JW Marriott Marquis Dubai", "Dubai", "UAE", 80000, 9.0, "https://www.booking.com/hotel/ae/jw-marriott-marquis-dubai.en-gb.html", "Luxury~City View~Business"),
    
    # USA
    ("The Plaza", "New York", "USA", 180000, 9.1, "https://www.booking.com/hotel/us/the-plaza.en-gb.html", "Luxury~Historic~City Center"),
    ("Bellagio", "Las Vegas", "USA", 90000, 8.9, "https://www.booking.com/hotel/us/bellagio.en-gb.html", "Casino~Resort~Luxury"),
    
    # France
    ("Hôtel Ritz Paris", "Paris", "France", 300000, 9.7, "https://www.booking.com/hotel/fr/ritz-paris.en-gb.html", "Luxury~Historic~City Center"),
    ("Pullman Paris Tour Eiffel", "Paris", "France", 70000, 8.5, "https://www.booking.com/hotel/fr/pullman-paris-tour-eiffel.en-gb.html", "Eiffel Tower View~Modern"),
    
    # Turkey
    ("Swissôtel The Bosphorus", "Istanbul", "Turkey", 60000, 9.1, "https://www.booking.com/hotel/tr/swissotel-the-bosphorus-istanbul.en-gb.html", "Bosphorus View~Luxury~Spa"),
    ("Cappadocia Cave Suites", "Cappadocia", "Turkey", 40000, 9.3, "https://www.booking.com/hotel/tr/cappadocia-cave-suites.en-gb.html", "Cave Hotel~Historic~Unique"),
]

for name, city, country, price, rating, url, tags in manual_hotels:
    new_rows.append({
        'hotel_name': name,
        'city': city,
        'country': country,
        'price': price,
        'rating': rating,
        'tags': tags + f"~{city}~{country}",
        'image': f'img/room-{random.randint(1,3)}.jpg',
        'url': url,
        'booking_url': url,
        'description': f"Stay at the world-renowned {name} in {city}, {country}."
    })

# Create DataFrame
final_df = pd.DataFrame(new_rows)

# Save
final_df.to_csv('server/real_hotels.csv', index=False)
print(f"Saved {len(final_df)} hotels to server/real_hotels.csv")
