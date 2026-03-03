<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Hotel Recommendation System - Our Rooms</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="keywords" />
    <meta content="" name="description" />

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap"
      rel="stylesheet"
    />

    <!-- Icon Font Stylesheet -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
      rel="stylesheet"
    />

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet" />
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />
    <link
      href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css"
      rel="stylesheet"
    />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet" />

    <!-- Template Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/responsive.css') }}" rel="stylesheet" />
  </head>

  <body>
    <div class="container-xxl bg-white p-0">
      <!-- Spinner Start -->
      <div
        id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center"
      >
        <div
          class="spinner-border text-primary"
          style="width: 3rem; height: 3rem"
          role="status"
        >
          <span class="sr-only">Loading...</span>
        </div>
      </div>
      <!-- Spinner End -->

      <!-- Header Start -->
      <div class="container-fluid bg-dark px-0">
        <div class="row gx-0">
          <div class="col-lg-3 bg-dark d-none d-lg-block">
            <a
              href="{{ url('/') }}"
              class="navbar-brand w-100 h-100 m-0 p-0 d-flex align-items-center justify-content-center"
            >
              <h1 class="m-0 text-primary text-uppercase" style="font-size: 15px;">Hotel Recommendation System</h1>
            </a>
          </div>
          <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-dark navbar-dark p-3 p-lg-0">
              <a href="{{ url('/') }}" class="navbar-brand d-block d-lg-none">
                <h1 class="m-0 text-primary text-uppercase" style="font-size: 15px;">Hotel Recommendation System</h1>
              </a>
              <button
                type="button"
                class="navbar-toggler"
                data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse"
              >
                <span class="navbar-toggler-icon"></span>
              </button>
              <div
                class="collapse navbar-collapse justify-content-between"
                id="navbarCollapse"
              >
                <div class="navbar-nav mr-auto py-0">
                  <a href="{{ url('/') }}" class="nav-item nav-link">Home</a>
                  <a href="{{ route('rooms') }}" class="nav-item nav-link active">Rooms</a>
                  <a href="{{ route('contact') }}" class="nav-item nav-link">Contact</a>
                </div>
                <div class="navbar-nav ms-auto py-0">
                    <div class="nav-item dropdown d-none d-lg-block">
                        @auth
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fa fa-user me-2"></i>{{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu rounded-0 m-0">
                                <a href="{{ route('dashboard') }}" class="dropdown-item">Dashboard</a>
                                <a href="{{ route('profile.edit') }}" class="dropdown-item">Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</a>
                                </form>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="nav-item nav-link">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="nav-item nav-link">Register</a>
                            @endif
                        @endauth
                    </div>
                    <div class="d-lg-none">
                        @auth
                            <a href="{{ route('dashboard') }}" class="nav-item nav-link">Dashboard</a>
                            <a href="{{ route('profile.edit') }}" class="nav-item nav-link">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" class="nav-item nav-link" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</a>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="nav-item nav-link">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="nav-item nav-link">Register</a>
                            @endif
                        @endauth
                    </div>
                </div>
              </div>
            </nav>
          </div>
        </div>
      </div>
      <!-- Header End -->

      <!-- Page Header Start -->
      <div
        class="container-fluid page-header mb-5 p-0"
        style="background-image: url({{ asset('img/carousel-1.jpg') }})"
      >
        <div class="container-fluid page-header-inner py-5">
          <div class="container text-center pb-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">
              Our Rooms
            </h1>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb justify-content-center text-uppercase">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Rooms</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
      <!-- Page Header End -->

      <!-- Filters Start -->
      <div class="container my-4">
        <form method="GET" action="{{ route('rooms') }}" class="row g-3">
          <div class="col-md-4">
            <label for="city" class="form-label">City</label>
            <select id="city" name="city" class="form-select">
              <option value="">All Cities</option>
              @isset($cities)
                @foreach($cities as $city)
                  <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                @endforeach
              @endisset
            </select>
          </div>
          <div class="col-md-6">
            <label for="location" class="form-label">Country/Area</label>
            <input id="location" name="location" type="text" value="{{ request('location') }}" class="form-control" placeholder="e.g., Pakistan, New York, Turkey" />
          </div>
          <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
          </div>
        </form>
        <div class="mt-2">
          <a href="{{ route('rooms') }}" class="btn btn-link">Clear filters</a>
        </div>
      </div>
      <!-- Filters End -->

      <!-- Room Start -->
      <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title text-center text-primary text-uppercase">Recommended Rooms</h6>
            <h1 class="mb-5">Explore <span class="text-primary text-uppercase">Recommended</span> Options</h1>
            </div>
            <div class="row g-4">
                @foreach($hotels as $hotel)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="room-item shadow rounded overflow-hidden">
                        <div class="position-relative">
                            <img class="img-fluid w-100" src="{{ $hotel->image ? $hotel->image : asset('img/room-1.jpg') }}" alt="{{ $hotel->name }}" style="height: 250px; object-fit: cover;">
                            <small class="position-absolute start-0 top-100 translate-middle-y bg-primary text-white rounded py-1 px-3 ms-4">
                                {{ $hotel->price ? 'PKR ' . number_format($hotel->price) . '/Night' : 'Check Price' }}
                            </small>
                            @auth
                            <button class="btn btn-sm btn-light position-absolute end-0 top-0 m-2 rounded-circle wishlist-btn" 
                                    data-hotel="{{ json_encode([
                                        'hotel_name' => $hotel->name,
                                        'image' => $hotel->image,
                                        'price' => $hotel->price,
                                        'avg_rating' => $hotel->rating,
                                        'nationality' => $hotel->city . ', ' . $hotel->country,
                                        'url' => $hotel->booking_url && $hotel->booking_url !== '#' ? $hotel->booking_url : ($hotel->url && $hotel->url !== '#' ? $hotel->url : route('rooms.detail', $hotel->id))
                                    ]) }}"
                                    onclick="addToWishlist(this)">
                                <i class="fa fa-heart text-danger"></i>
                            </button>
                            @endauth
                        </div>
                        <div class="p-4 mt-2">
                            <div class="d-flex justify-content-between mb-3">
                                <h5 class="mb-0 text-truncate" style="max-width: 70%;">{{ $hotel->name }}</h5>
                                <div class="ps-2">
                                    <small class="fa fa-star text-primary"></small>
                                    <small>{{ $hotel->rating ?? 'N/A' }}</small>
                                </div>
                            </div>
                            
                            <!-- Dynamic Badges/Amenities -->
                            <div class="d-flex mb-3 flex-wrap gap-2">
                                <small class="border-end me-3 pe-3"><i class="fa fa-map-marker-alt text-primary me-2"></i>{{ Str::limit($hotel->city, 15) }}</small>
                                @if($hotel->tags)
                                    @foreach(array_slice(explode(',', $hotel->tags), 0, 2) as $tag)
                                        <span class="badge bg-light text-dark border">{{ trim($tag) }}</span>
                                    @endforeach
                                @else
                                    <small class="border-end me-3 pe-3"><i class="fa fa-bed text-primary me-2"></i>Standard</small>
                                    <small><i class="fa fa-wifi text-primary me-2"></i>Wifi</small>
                                @endif
                            </div>

                            <p class="text-body mb-3 small">{{ Str::limit($hotel->description ?? 'Experience a comfortable stay with excellent amenities and service.', 80) }}</p>
                            
                            <div class="d-flex justify-content-between">
                                <a class="btn btn-sm btn-dark rounded py-2 px-4 w-100" href="{{ $hotel->booking_url && $hotel->booking_url !== '#' ? $hotel->booking_url : ($hotel->url && $hotel->url !== '#' ? $hotel->url : 'https://www.booking.com/searchresults.html?ss=' . urlencode($hotel->name . ' ' . $hotel->city . ' ' . ($hotel->address ?? ''))) }}" target="_blank">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="row mt-5">
                <div class="col-12">
                    {{ $hotels->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
      </div>
      <!-- Room End -->

      <!-- Footer Start -->
      <div
        class="container-fluid bg-dark text-light footer wow fadeIn"
        data-wow-delay="0.1s"
      >
        <div class="container pb-5">
          <div class="row g-5">
            <div class="col-md-6 col-lg-4">
              <div class="bg-primary rounded p-4">
                <a href="{{ url('/') }}"
                  ><h1 class="text-white text-uppercase mb-3" style="font-size: 20px;">Hotel Recommendation System</h1></a
                >
                <p class="text-white mb-0">
                  Experience the best hospitality with our curated selection of top-rated hotels. We provide personalized recommendations to ensure your stay is comfortable and memorable.
                </p>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <h6
                class="section-title text-start text-primary text-uppercase mb-4"
              >
                Contact
              </h6>
              <p class="mb-2">
                <i class="fa fa-map-marker-alt me-3"></i>123 Hotel Avenue, Global City
              </p>
              <p class="mb-2">
                <i class="fa fa-phone-alt me-3"></i>+1 234 567 8900
              </p>
              <p class="mb-2">
                <i class="fa fa-envelope me-3"></i>info@hotelrecsys.com
              </p>
              <div class="d-flex pt-2">
                <a class="btn btn-outline-light btn-social" href=""
                  ><i class="fab fa-twitter"></i
                ></a>
                <a class="btn btn-outline-light btn-social" href=""
                  ><i class="fab fa-facebook-f"></i
                ></a>
                <a class="btn btn-outline-light btn-social" href=""
                  ><i class="fab fa-youtube"></i
                ></a>
                <a class="btn btn-outline-light btn-social" href=""
                  ><i class="fab fa-linkedin-in"></i
                ></a>
              </div>
            </div>
            <div class="col-lg-5 col-md-12">
              <div class="row gy-5 g-4">
                <div class="col-md-6">
                  <h6
                    class="section-title text-start text-primary text-uppercase mb-4"
                  >
                    Services
                  </h6>
                  <a class="btn btn-link" href="{{ route('rooms') }}">Rooms & Apartment</a>
                  <a class="btn btn-link" href="{{ route('dashboard') }}">Food & Restaurant</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="container">
          <div class="copyright">
            <div class="row">
              <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                &copy; <a class="border-bottom" href="#">Hotel Recommendation System</a>, All
                Right Reserved.
              </div>
              <div class="col-md-6 text-center text-md-end">
                <div class="footer-menu">
                  <a href="{{ url('/') }}">Home</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Footer End -->

      <!-- Back to Top -->
      <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"
        ><i class="bi bi-arrow-up"></i
      ></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script>
        function addToWishlist(btn) {
            const hotel = JSON.parse(btn.getAttribute('data-hotel'));
            const button = $(btn);
            
            button.prop('disabled', true);
            
            fetch("{{ route('wishlist.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    hotel_name: hotel.hotel_name,
                    image: hotel.image,
                    price: hotel.price, 
                    rating: hotel.avg_rating,
                    location: hotel.nationality,
                    url: hotel.url
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
        }
    </script>
  </body>
</html>
