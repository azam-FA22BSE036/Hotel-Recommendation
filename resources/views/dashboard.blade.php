<x-app-layout>
    <div class="bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Header Start -->
        <div class="container-fluid bg-dark px-0">
            <div class="row gx-0">
                <div class="col-lg-3 bg-dark d-none d-lg-block">
                    <a href="{{ route('dashboard') }}"
                        class="navbar-brand w-100 h-100 m-0 p-0 d-flex align-items-center justify-content-center">
                        <h1 class="m-0 text-primary text-uppercase" style="font-size: 15px;">Hotel Recommendation System</h1>
                    </a>
                </div>
                <div class="col-lg-9">
                    <nav class="navbar navbar-expand-lg bg-dark navbar-dark p-3 p-lg-0">
                        <a href="{{ route('dashboard') }}" class="navbar-brand d-block d-lg-none">
                            <h1 class="m-0 text-primary text-uppercase" style="font-size: 15px;">Hotel Recommendation System</h1>
                        </a>
                        <button type="button" class="navbar-toggler" data-bs-toggle="collapse"
                            data-bs-target="#navbarCollapse">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                            <div class="navbar-nav mr-auto py-0">
                                <a href="{{ url('/') }}" class="nav-item nav-link">Home</a>
                                <a href="{{ route('rooms') }}" class="nav-item nav-link">Rooms</a>
                                <a href="{{ route('contact') }}" class="nav-item nav-link">Contact</a>
                            </div>
                            <div class="navbar-nav ms-auto py-0">
                                <div class="nav-item dropdown d-none d-lg-block">
                                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="fa fa-user me-2"></i>{{ Auth::user()->name }}
                                    </a>
                                    <div class="dropdown-menu rounded-0 m-0">
                                        <a href="{{ route('profile.edit') }}" class="dropdown-item">Profile</a>
                                        <a href="{{ route('wishlist.view') }}" class="dropdown-item">Wishlist</a>
                                        <a href="{{ route('history.view') }}" class="dropdown-item">Search History</a>
                                        <div class="dropdown-divider"></div>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a href="{{ route('logout') }}" class="dropdown-item"
                                               onclick="event.preventDefault(); this.closest('form').submit();">Log Out</a>
                                        </form>
                                    </div>
                                </div>
                                <div class="d-lg-none">
                                    <a href="{{ route('profile.edit') }}" class="nav-item nav-link">Profile</a>
                                    <a href="{{ route('wishlist.view') }}" class="nav-item nav-link">Wishlist</a>
                                    <a href="{{ route('history.view') }}" class="nav-item nav-link">Search History</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="{{ route('logout') }}" class="nav-item nav-link" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Header End -->


        <!-- Page Header Start -->
        <div class="container-fluid page-header mb-5 p-0" style="background-image: url(img/carousel-1.jpg);">
            <div class="container-fluid page-header-inner py-5">
                <div class="container text-center pb-5">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Dashboard</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Page Header End -->


        <!-- Booking Start -->
        <div
        class="container-fluid booking pb-5 wow fadeIn"
        data-wow-delay="0.1s"
      >
        <div class="container">
          <div class="bg-white shadow p-3 p-md-5">
            <div class="row g-2">
              <div class="col-md-10">
                <div class="row g-2">
                    <h3>Describe your requirements</h3>
                    <small>Example, I'm looking for a hotel on beach side</small>
                  <div class="col-12 position-relative">
                    <input
                    class="form-control form-control-lg"
                    style="height: 60px; padding-right: 60px; margin: 20px 0px;"
                    
                      type="text"
                      id="userPrompt"
                      placeholder="I'm looking for a clean hotel with good staff"
                    />
                    <button id="voiceBtn" class="btn btn-link position-absolute" style="right: 15px; top: 50%; transform: translateY(-50%); color: #666;">
                        <i class="fa fa-microphone fa-lg"></i>
                    </button>
                  </div>
                  <div class="mb-3">
                      <label for="budgetRange" class="form-label">Max Budget (PKR): <span id="budgetValue" class="fw-bold text-primary">500,000</span></label>
                      <input type="range" class="form-range w-100" id="budgetRange" min="5000" max="500000" step="5000" value="500000">
                  </div>
              </div>
              <div class="col-md-2">
                <button id="submitBtn" class="btn btn-primary w-100">
                  Submit
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Booking End -->

      <!-- Room Start -->
      <div class="container-xxl py-5">
        <div class="container">
          <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title text-center text-primary text-uppercase">
              Top Hotels
            </h6>
            <h1 class="mb-5">
              Recommended 
              <span class="text-primary text-uppercase">Hotels</span>
            </h1>
          </div>
          <div id="hotel-container" class="row g-4">
            
          </div>
        </div>
      </div>
      <!-- Room End -->

      <!-- Testimonial Start -->
      <div class="container-xxl testimonial my-5 py-5 bg-dark wow zoomIn" data-wow-delay="0.1s">
        <div class="container">
            <div class="owl-carousel testimonial-carousel py-5">
                <div class="testimonial-item position-relative bg-white rounded overflow-hidden">
                    <p>The hotel service was exceptional! The staff were friendly and the room was immaculate. I highly recommend this place for anyone visiting.</p>
                    <div class="d-flex align-items-center">
                        <img class="img-fluid flex-shrink-0 rounded" src="img/testimonial-1.jpg" style="width: 45px; height: 45px;">
                        <div class="ps-3">
                            <h6 class="fw-bold mb-1">Sarah Johnson</h6>
                            <small>Travel Blogger</small>
                        </div>
                    </div>
                    <i class="fa fa-quote-right fa-3x text-primary position-absolute end-0 bottom-0 me-4 mb-n1"></i>
                </div>
                <div class="testimonial-item position-relative bg-white rounded overflow-hidden">
                    <p>A truly wonderful experience. The amenities were top-notch and the location was perfect. Will definitely be coming back!</p>
                    <div class="d-flex align-items-center">
                        <img class="img-fluid flex-shrink-0 rounded" src="img/testimonial-2.jpg" style="width: 45px; height: 45px;">
                        <div class="ps-3">
                            <h6 class="fw-bold mb-1">Michael Brown</h6>
                            <small>Business Traveler</small>
                        </div>
                    </div>
                    <i class="fa fa-quote-right fa-3x text-primary position-absolute end-0 bottom-0 me-4 mb-n1"></i>
                </div>
                <div class="testimonial-item position-relative bg-white rounded overflow-hidden">
                    <p>I loved every moment of my stay. The recommendation system helped me find exactly what I was looking for. Five stars!</p>
                    <div class="d-flex align-items-center">
                        <img class="img-fluid flex-shrink-0 rounded" src="img/testimonial-3.jpg" style="width: 45px; height: 45px;">
                        <div class="ps-3">
                            <h6 class="fw-bold mb-1">Emily Davis</h6>
                            <small>Photographer</small>
                        </div>
                    </div>
                    <i class="fa fa-quote-right fa-3x text-primary position-absolute end-0 bottom-0 me-4 mb-n1"></i>
                </div>
            </div>
        </div>
      </div>
      <!-- Testimonial End -->

      <!-- Newsletter Start -->
      <div class="container newsletter mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="row justify-content-center">
            <div class="col-lg-10 border rounded p-1">
                <div class="border rounded text-center p-1">
                    <div class="bg-white rounded text-center p-5">
                        <h4 class="mb-4">Subscribe Our <span class="text-primary text-uppercase">Newsletter</span></h4>
                        <div class="position-relative mx-auto" style="max-width: 400px;">
                            <input id="newsletter-email" class="form-control w-100 py-3 ps-4 pe-5" type="text" placeholder="Enter your email">
                            <button id="newsletter-btn" type="button" class="btn btn-primary py-2 px-3 position-absolute top-0 end-0 mt-2 me-2">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <!-- Newsletter End -->


    </div>
        <!-- Booking End -->


        <!-- Room Start -->
    
        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>
</x-app-layout>

<script>
      $(document).ready(function () {
        // Check for 'prompt' query parameter
        const urlParams = new URLSearchParams(window.location.search);
        const promptParam = urlParams.get('prompt');
        if (promptParam) {
            $("#userPrompt").val(promptParam);
            // Trigger search automatically
            setTimeout(() => {
                $("#submitBtn").click();
            }, 500);
        }

        // Update Budget Label
        $("#budgetRange").on('input', function() {
            let val = parseInt($(this).val());
            $("#budgetValue").text(val.toLocaleString());
        });

        // Handle form submission
        $("#submitBtn").click(function () {
          const userPrompt = $("#userPrompt").val();
          const budget = $("#budgetRange").val();
          
          if (!userPrompt.trim()) {
            alert("Please enter a description of what you are looking for.");
            return;
          }

          // Disable button and show loading state
          const btn = $(this);
          const originalText = btn.text();
          btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
          
          // Clear previous results
          $("#hotel-container").html('<div class="col-12 text-center"><p class="text-muted">Searching for the best hotels for you...</p></div>');

          const data = {
            prompt: userPrompt,
            budget: budget,
            user_id: {{ Auth::id() }} // Pass current user ID for NCF personalization
          };
          
          fetchRecommendations(data, btn, originalText);
          
          // Save search history
          fetch("/history", {
              method: "POST",
              headers: {
                  "Content-Type": "application/json",
                  "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
              },
              body: JSON.stringify({ prompt: userPrompt })
          }).then(res => res.json()).then(data => console.log('History saved:', data));
        });

        // Voice Recognition Logic
        const voiceBtn = $("#voiceBtn");
        const userPromptInput = $("#userPrompt");

        if ('webkitSpeechRecognition' in window) {
            const recognition = new webkitSpeechRecognition();
            recognition.continuous = false;
            recognition.interimResults = false;
            recognition.lang = 'en-US';

            voiceBtn.click(function() {
                if (voiceBtn.hasClass('listening')) {
                    recognition.stop();
                } else {
                    recognition.start();
                }
            });

            recognition.onstart = function() {
                voiceBtn.addClass('listening');
                voiceBtn.css('color', 'red');
                userPromptInput.attr('placeholder', 'Listening...');
            };

            recognition.onend = function() {
                voiceBtn.removeClass('listening');
                voiceBtn.css('color', '#666');
                userPromptInput.attr('placeholder', "I'm looking for a clean hotel with good staff");
            };

            recognition.onresult = function(event) {
                const transcript = event.results[0][0].transcript;
                userPromptInput.val(transcript);
                // Optional: Auto-submit
                // $("#submitBtn").click();
            };
        } else {
            voiceBtn.hide();
            console.log("Web Speech API not supported in this browser.");
        }

        // Function to make API call and fetch recommendations (robust parsing)
        const fetchRecommendations = (data, btn, originalText) => {
        const fallbackImage = '{{ asset('img/room-1.jpg') }}';
        fetch("http://localhost:5001/recommend", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(data),
        })    
            .then((response) => response.text())
            .then((text) => {
              let payload = {};
              try { payload = JSON.parse(text); } catch (e) { payload = {}; }
              const hotels = payload.recommended_hotels || [];
              const hotelContainer = document.getElementById("hotel-container");
              hotelContainer.innerHTML = ""; 
              
              if (hotels.length === 0) {
                  hotelContainer.innerHTML = '<div class="col-12 text-center"><div class="alert alert-info">No hotels found matching your criteria. Try a different description.</div></div>';
                  return;
              }

              const mapHotelDetails = (hotel) => {
                let description = "Experience a comfortable stay.";
                let amenitiesHtml = '';
                
                if (hotel.tags) {
                    let tags = hotel.tags.split('~').filter(tag => !tag.includes('Submitted') && !tag.includes('Stayed') && !tag.includes('reviews'));
                    if (tags.length > 0) {
                        description = tags.slice(0, 3).join(', ') + "...";
                        
                        // Generate amenities badges
                        amenitiesHtml = '<div class="mb-3">';
                        tags.slice(0, 4).forEach(tag => {
                            let icon = 'fa-check';
                            if(tag.toLowerCase().includes('wifi')) icon = 'fa-wifi';
                            if(tag.toLowerCase().includes('pool')) icon = 'fa-swimming-pool';
                            if(tag.toLowerCase().includes('parking')) icon = 'fa-car';
                            if(tag.toLowerCase().includes('breakfast')) icon = 'fa-utensils';
                            if(tag.toLowerCase().includes('gym') || tag.toLowerCase().includes('fitness')) icon = 'fa-dumbbell';
                            if(tag.toLowerCase().includes('spa')) icon = 'fa-spa';
                            if(tag.toLowerCase().includes('bar')) icon = 'fa-cocktail';
                            
                            amenitiesHtml += `<small class="border-end me-3 pe-3"><i class="fa ${icon} text-primary me-2"></i>${tag}</small>`;
                        });
                        amenitiesHtml += '</div>';
                    }
                }
                
                // Ensure price is formatted
                const priceDisplay = hotel.price ? `PKR ${hotel.price.toLocaleString()}` : 'Check Price';

                return `
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
              <div class="room-item shadow rounded overflow-hidden h-100 transition-hover">
                <div class="position-relative">
                  <img class="img-fluid w-100" style="height: 200px; object-fit: cover;" src="${hotel.image || fallbackImage}" alt="" />
                  <small
                    class="position-absolute start-0 top-100 translate-middle-y bg-primary text-white rounded py-1 px-3 ms-4"
                    >${hotel.city || hotel.country || 'International'}</small
                  >
                  <div class="position-absolute end-0 top-100 translate-middle-y me-4">
                      <span class="bg-white text-primary rounded py-1 px-3 fw-bold shadow-sm">${priceDisplay}</span>
                  </div>
                  <button class="btn btn-sm btn-light position-absolute end-0 top-0 m-2 rounded-circle wishlist-btn" 
                          data-hotel='${JSON.stringify(hotel).replace(/'/g, "&#39;")}'
                          onclick="addToWishlist(this)">
                      <i class="fa fa-heart text-danger"></i>
                  </button>
                </div>
                <div class="p-4 mt-2 d-flex flex-column justify-content-between" style="min-height: 250px;">
                  <div>
                      <div class="d-flex justify-content-between mb-3">
                        <h5 class="mb-0 text-truncate" title="${hotel.hotel_name}">${hotel.hotel_name}</h5>
                        <div class="ps-2 text-nowrap">
                          <small class="fa fa-star text-primary"></small>
                          ${hotel.avg_rating}
                        </div>
                      </div>
                      ${amenitiesHtml}
                      <p class="text-body mb-3 small text-muted">${description}</p>
                  </div>
                  <div class="d-flex justify-content-between mt-3">
                    <a class="btn btn-sm btn-primary rounded py-2 px-4 shadow-sm w-100" 
                       href="${hotel.booking_url && hotel.booking_url !== '#' ? hotel.booking_url : (hotel.url && hotel.url !== '#' && !hotel.url.includes('booking.com') ? hotel.url : 'https://www.booking.com/searchresults.html?ss=' + encodeURIComponent(hotel.hotel_name + ' ' + (hotel.city || '') + ' ' + (hotel.country || '')))}"
                      >Book Now</a
                    >
                  </div>
                </div>
              </div>
            </div>
                  `;
              };

              const sortedHotels = hotels.sort((a, b) => Number(b.avg_rating) - Number(a.avg_rating));
              
              sortedHotels?.forEach((hotel) => {
                const hotelHtml = mapHotelDetails(hotel);
                hotelContainer.insertAdjacentHTML("beforeend", hotelHtml);
              });
            })
            .catch((error) => {
              console.error("Error:", error);
              const hotelContainer = document.getElementById("hotel-container");
              if (hotelContainer) {
                hotelContainer.innerHTML = '<div class="col-12 text-center"><div class="alert alert-danger">Recommendation service is currently unavailable. Please ensure the Python server is running (port 5001).</div></div>';
              }
            })
            .finally(() => {
                // Restore button state
                btn.prop('disabled', false).html(originalText);
            });
        };

        // Wishlist Function
        window.addToWishlist = function(btn) {
            const hotel = JSON.parse(btn.getAttribute('data-hotel'));
            const button = $(btn);
            
            button.prop('disabled', true);
            
            fetch("{{ route('wishlist.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    hotel_name: hotel.hotel_name || hotel.name,
                    image: hotel.image,
                    price: hotel.price || 0,
                    rating: hotel.avg_rating || hotel.rating || 0,
                    location: (hotel.city ? hotel.city + ', ' : '') + (hotel.country || ''),
                    url: hotel.booking_url || hotel.url
                })
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    alert('Added to wishlist!');
                    button.find('i').removeClass('text-danger').addClass('text-success');
                } else if (data.status === 'exists') {
                    alert('Already in wishlist!');
                }
            })
            .catch(err => console.error(err))
            .finally(() => button.prop('disabled', false));
        };
        // Newsletter Subscription
        $("#newsletter-btn").click(function() {
            const email = $("#newsletter-email").val();
            if (!email) {
                alert("Please enter your email address.");
                return;
            }

            const btn = $(this);
            const originalText = btn.text();
            btn.prop('disabled', true).text('...');

            fetch("{{ route('subscribe') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ email: email })
            })
            .then(res => {
                if (!res.ok) {
                    throw new Error('Subscription failed');
                }
                return res.json();
            })
            .then(data => {
                alert(data.message || "Subscribed successfully!");
                $("#newsletter-email").val('');
            })
            .catch(err => {
                console.error(err);
                alert("Subscription failed. You might already be subscribed.");
            })
            .finally(() => btn.prop('disabled', false).text(originalText));
        });

      });
    </script>
    <style>
        .wishlist-btn:hover {
            transform: scale(1.1);
            transition: transform 0.2s;
        }
        .transition-hover:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease;
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
        }
    </style>
