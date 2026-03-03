<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js']);

    <!-- Hotel <script></script> -->

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <!-- #region -->


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />



    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('lib/animate/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('lib/owlcarousel/assets/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/responsive.css')}}">





</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Page Heading -->
        @if (isset($header))
            <!-- <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header> -->
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-light footer wow fadeIn" data-wow-delay="0.1s">
            <div class="container pb-5">
                <div class="row g-5">
                    <div class="col-md-6 col-lg-3">
                        <div class="bg-primary rounded p-4">
                            <a href="{{ url('/') }}">
                                <h1 class="text-white text-uppercase mb-3" style="font-size: 20px;">Hotel Recommendation System</h1>
                            </a>
                            <p class="text-white mb-0">
                                Experience the best hospitality with our curated selection of top-rated hotels.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <h6 class="section-title text-start text-primary text-uppercase mb-4">Contact</h6>
                        <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Hotel Avenue, Global City</p>
                        <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+1 234 567 8900</p>
                        <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@hotelrecsys.com</p>
                        <div class="d-flex pt-2">
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h6 class="section-title text-start text-primary text-uppercase mb-4">Links</h6>
                        <a class="btn btn-link" href="{{ route('rooms') }}">Rooms</a>
                        <a class="btn btn-link" href="{{ route('dashboard') }}">Dashboard</a>
                        <a class="btn btn-link" href="{{ route('contact') }}">Contact Us</a>
                        <a class="btn btn-link" href="">Privacy Policy</a>
                        <a class="btn btn-link" href="">Terms & Condition</a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h6 class="section-title text-start text-primary text-uppercase mb-4">Newsletter</h6>
                        <p>Subscribe to our newsletter for latest updates.</p>
                        <form action="{{ route('subscribe') }}" method="POST">
                            @csrf
                            <div class="position-relative mx-auto" style="max-width: 400px;">
                                <input class="form-control border-0 w-100 py-3 ps-4 pe-5" type="text" name="email" placeholder="Your email" required>
                                <button type="submit" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            &copy; <a class="border-bottom" href="#">Hotel Recommendation System</a>, All Right Reserved.
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <div class="footer-menu">
                                <a href="{{ url('/') }}">Home</a>
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->
    </div>



    <!-- Chatbot Widget -->
    <div id="chatbot-container" style="position: fixed; bottom: 30px; right: 30px; z-index: 9999;">
        <!-- Chat Button -->
        <button id="chatbot-toggle" class="btn btn-primary rounded-circle shadow-lg d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; font-size: 24px;">
            <i class="fa fa-robot text-white"></i>
        </button>

        <!-- Chat Window -->
        <div id="chatbot-window" class="card shadow-lg d-none" style="position: absolute; bottom: 80px; right: 0; width: 350px; max-width: 90vw; height: 500px; max-height: 80vh; display: flex; flex-direction: column; border-radius: 15px; overflow: hidden;">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                <h6 class="mb-0 text-white"><i class="fa fa-robot me-2"></i>AI Concierge</h6>
                <button id="chatbot-close" class="btn btn-sm btn-link text-white p-0"><i class="fa fa-times"></i></button>
            </div>
            <div class="card-body overflow-auto bg-light" id="chatbot-messages" style="flex: 1; padding: 15px;">
                <div class="d-flex mb-3">
                    <div class="bg-white text-dark rounded p-3 shadow-sm" style="max-width: 85%; border-top-left-radius: 0;">
                        Hello! I'm your AI Concierge. How can I help you find a hotel today?
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white p-3 border-top">
                <div class="input-group">
                    <input type="text" id="chatbot-input" class="form-control border-end-0" placeholder="Type a message..." aria-label="Type a message...">
                    <button class="btn btn-primary" id="chatbot-send"><i class="fa fa-paper-plane"></i></button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('chatbot-toggle');
            const closeBtn = document.getElementById('chatbot-close');
            const chatWindow = document.getElementById('chatbot-window');
            const sendBtn = document.getElementById('chatbot-send');
            const input = document.getElementById('chatbot-input');
            const messagesContainer = document.getElementById('chatbot-messages');

            // Toggle Chat Window
            toggleBtn.addEventListener('click', () => {
                chatWindow.classList.toggle('d-none');
                if (!chatWindow.classList.contains('d-none')) {
                    input.focus();
                }
            });

            closeBtn.addEventListener('click', () => {
                chatWindow.classList.add('d-none');
            });

            // Send Message
            function sendMessage() {
                const message = input.value.trim();
                if (!message) return;

                // Add User Message
                appendMessage(message, 'user');
                input.value = '';

                // Show typing indicator
                const typingId = appendTypingIndicator();

                // Call Backend API
                fetch('http://localhost:5001/recommend', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        user_id: {{ Auth::check() ? Auth::id() : 1 }}, // Default to 1 if guest
                        prompt: message
                    })
                })
                .then(response => response.json())
                .then(data => {
                    removeMessage(typingId);
                    
                    // Display Sentiment Analysis
                    if (data.sentiment) {
                        let sentimentMsg = "";
                        if (data.sentiment === 'positive') {
                            sentimentMsg = "I'm glad to hear that! 😊 Let me find something great for you.";
                        } else if (data.sentiment === 'negative') {
                            sentimentMsg = "I'm sorry about that. 😔 I'll prioritize highly-rated places for a better experience.";
                        }
                        if (sentimentMsg) appendMessage(sentimentMsg, 'bot');
                    }

                    // Display Extracted Intent (Optional, for transparency)
                    if (data.debug_intent) {
                        let intentMsg = "Searching for: ";
                        let criteria = [];
                        if (data.debug_intent.locations && data.debug_intent.locations.length > 0) criteria.push(`Location: <b>${data.debug_intent.locations.join(', ')}</b>`);
                        if (data.debug_intent.cuisines && data.debug_intent.cuisines.length > 0) criteria.push(`Cuisine: <b>${data.debug_intent.cuisines.join(', ')}</b>`);
                        if (data.debug_intent.budget) criteria.push(`Budget: <b>PKR ${data.debug_intent.budget}</b>`);
                        
                        if (criteria.length > 0) {
                            // appendMessage(intentMsg + criteria.join(' | '), 'bot', true);
                        }
                    }

                    if (data.recommended_hotels && data.recommended_hotels.length > 0) {
                        let responseText = "Here are my top recommendations:<br>";
                        // Take top 3
                        data.recommended_hotels.slice(0, 3).forEach(hotel => {
                            responseText += `<div class='mt-2 border-bottom pb-2'>
                                <strong>${hotel.hotel_name}</strong><br>
                                <small>${hotel.city || ''}, ${hotel.country || ''}</small><br>
                                <span class='text-primary'>PKR ${hotel.price}</span> | <i class='fa fa-star text-warning'></i> ${hotel.avg_rating ? hotel.avg_rating.toFixed(1) : 'N/A'}
                            </div>`;
                        });
                        responseText += `<div class='mt-2'><a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-primary w-100">View All Results</a></div>`;
                        appendMessage(responseText, 'bot', true);
                    } else {
                        // Fallback logic if truly no hotels found (should be rare with relaxed filters)
                        let fallbackMsg = "I couldn't find exact matches.";
                        if (data.debug_intent && (!data.debug_intent.locations || data.debug_intent.locations.length === 0)) {
                            fallbackMsg += " Try specifying a location, e.g., 'Hotels in Lahore'.";
                        } else {
                            fallbackMsg += " Try adjusting your criteria.";
                        }
                        appendMessage(fallbackMsg, 'bot');
                    }
                })
                .catch(error => {
                    removeMessage(typingId);
                    console.error('Error:', error);
                    appendMessage("Sorry, I'm having trouble connecting to the recommendation engine. Please ensure the Python backend is running.", 'bot');
                });
            }

            sendBtn.addEventListener('click', sendMessage);
            input.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') sendMessage();
            });

            function appendMessage(text, sender, isHtml = false) {
                const div = document.createElement('div');
                div.className = `d-flex mb-3 ${sender === 'user' ? 'justify-content-end' : ''}`;
                
                const content = document.createElement('div');
                content.className = `rounded p-3 shadow-sm ${sender === 'user' ? 'bg-primary text-white' : 'bg-white text-dark'}`;
                content.style.maxWidth = '85%';
                if (sender === 'user') {
                    content.style.borderTopRightRadius = '0';
                } else {
                    content.style.borderTopLeftRadius = '0';
                }
                
                if (isHtml) {
                    content.innerHTML = text;
                } else {
                    content.textContent = text;
                }
                
                div.appendChild(content);
                messagesContainer.appendChild(div);
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }

            function appendTypingIndicator() {
                const div = document.createElement('div');
                div.className = 'd-flex mb-3';
                const id = 'typing-' + Date.now();
                div.id = id;
                div.innerHTML = `
                    <div class="bg-white text-dark rounded p-3 shadow-sm" style="max-width: 85%; border-top-left-radius: 0;">
                        <i class="fa fa-ellipsis-h text-muted"></i>
                    </div>
                `;
                messagesContainer.appendChild(div);
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
                return id;
            }

            function removeMessage(id) {
                const el = document.getElementById(id);
                if (el) el.remove();
            }
        });
    </script>

</body>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('lib/wow/wow.min.js')}}"></script>
    <script src="{{asset('lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{asset('lib/counterup/counterup.min.js')}}"></script>
    <script src="{{asset('lib/owlcarousel/owl.carousel.min.js')}}"></script>
    <script src="{{asset('lib/tempusdominus/js/moment.min.js')}}"></script>
    <script src="{{asset('lib/tempusdominus/js/moment-timezone.min.js')}}"></script>
    <script src="{{asset('lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>

</html>