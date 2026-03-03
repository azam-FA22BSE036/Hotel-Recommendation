# Hotel Recommendation System

## Project Overview
The **Hotel Recommendation System** is a hybrid web application that combines a robust **Laravel** frontend with an intelligent **Python (Flask)** recommendation engine. It helps users find the perfect hotel based on natural language prompts (e.g., "I want a luxury hotel near the beach with a spa").

## Key Features

### 1. Intelligent Recommendation Engine
*   **Natural Language Processing**: Users can type requests in plain English.
*   **Machine Learning**: Uses **TF-IDF** (Term Frequency-Inverse Document Frequency) and **Random Forest** classifiers to analyze hotel tags and user sentiment.
*   **MongoDB Integration**: Stores extensive hotel profiles, including tags, ratings, and descriptions, in a NoSQL database for fast retrieval.
*   **Deterministic Results**: Tuned to provide consistent, high-quality recommendations based on similarity scores.

### 2. User Management
*   **Authentication**: Secure Registration and Login system.
*   **Profile Management**: Users can update their name, email, and password via a polished, user-friendly interface.
*   **Search History**: The system saves every search prompt, allowing users to revisit their past preferences.

### 3. Hotel Browsing & Booking
*   **Rooms Catalog**: A paginated list of available hotels with filtering options (City, Country).
*   **Hotel Details**: Rich detail pages showing amenities, pricing, ratings, and descriptions.
*   **Booking Redirection**: Direct links to booking platforms (simulated).

### 4. Robust Backend
*   **Dual-Database Architecture**:
    *   **SQLite**: Manages user data, sessions, and core relational data (Laravel).
    *   **MongoDB**: Handles large datasets of hotel profiles for the recommendation engine (Python).
*   **Microservice Design**: The Python Flask server runs independently on port `5001`, communicating with the Laravel app (port `8000`) via a JSON API.

---

## Technical Architecture

### Frontend (Laravel 10/11)
*   **Blade Templates**: Responsive UI using Bootstrap 5 and Tailwind CSS.
*   **AJAX Integration**: Asynchronous calls to the Python recommendation API for a smooth user experience without page reloads.
*   **Controllers**:
    *   `HotelController`: Manages room listings and details.
    *   `HistoryController`: Handles saving and viewing user search history.
    *   `ProfileController`: Manages user account settings.

### Backend (Python Flask)
*   **Libraries**: `pandas`, `scikit-learn`, `nltk`, `pymongo`, `flask-cors`.
*   **Logic**:
    1.  Receives user prompt.
    2.  Preprocesses text (tokenization, stop-word removal).
    3.  Vectorizes text using a pre-trained TF-IDF model.
    4.  Calculates Cosine Similarity against hotel tags.
    5.  Returns top matching hotels as JSON.

---

## Installation & Setup

### Prerequisites
*   PHP >= 8.1
*   Composer
*   Python 3.x
*   MongoDB (running locally on port 27017)

### Step-by-Step Guide

1.  **Database Setup**:
    *   Ensure MongoDB is running.
    *   The project uses `database/database.sqlite` for SQL data.

2.  **Install Dependencies**:
    ```bash
    # Laravel
    composer install
    npm install && npm run build

    # Python
    pip install -r server/requirements.txt
    ```

3.  **Seed Data**:
    *   **SQL Data**: `php artisan migrate:fresh --seed` (Populates users and basic hotel info).
    *   **NoSQL Data**: `python server/enhance_data.py` (Generates and inserts rich hotel data into MongoDB).

4.  **Run the Application**:
    *   Simply double-click the **`start.bat`** file in the root directory.
    *   This script automatically launches:
        1.  The Python Flask Server (Port 5001)
        2.  The Laravel Development Server (Port 8000)

5.  **Access**:
    *   Open your browser and visit: `http://localhost:8000`

---

## Usage Guide

1.  **Sign Up/Login**: Create an account to access the dashboard.
2.  **Get Recommendations**:
    *   Go to the **Dashboard**.
    *   Enter a prompt like: *"Cozy resort in Paris with breakfast included"*.
    *   Click **Submit**. The system will display a list of hotels matching your description.
3.  **View History**:
    *   Click your name in the top navigation bar.
    *   Select **Search History** to see your previous queries.
4.  **Update Profile**:
    *   Go to **Profile** to change your name, email, or password.

---

## Directory Structure

*   `app/`: Laravel core code (Models, Controllers).
*   `database/`: Migrations and SQLite database file.
*   `resources/views/`: Blade templates (Dashboard, Profile, Rooms).
*   `server/`: Python microservice code.
    *   `app.py`: Main Flask application.
    *   `enhance_data.py`: Script to generate and seed MongoDB data.
    *   `requirements.txt`: Python dependencies.
*   `public/`: Static assets (CSS, JS, Images).
*   `start.bat`: Automation script to run the project.
