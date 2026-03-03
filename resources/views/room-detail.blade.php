<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Hotel Recommendation System - Room Detail</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="{{ asset('img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/responsive.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Header Start -->
        <div class="container-fluid bg-dark px-0">
            <div class="row gx-0">
                <div class="col-lg-3 bg-dark d-none d-lg-block">
                    <a href="{{ route('dashboard') }}" class="navbar-brand w-100 h-100 m-0 p-0 d-flex align-items-center justify-content-center">
                        <h1 class="m-0 text-primary text-uppercase" style="font-size: 15px;">Hotel Recommendation System</h1>
                    </a>
                </div>
                <div class="col-lg-9">
                    <nav class="navbar navbar-expand-lg bg-dark navbar-dark p-3 p-lg-0">
                        <a href="{{ route('dashboard') }}" class="navbar-brand d-block d-lg-none">
                            <h1 class="m-0 text-primary text-uppercase" style="font-size: 15px;">Hotel Recommendation System</h1>
                        </a>
                        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
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
        <div class="container-fluid page-header mb-5 p-0" style="background-image: url({{ asset('img/carousel-1.jpg') }});">
            <div class="container-fluid page-header-inner py-5">
                <div class="container text-center pb-5">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Room Detail</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('rooms') }}">Rooms</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Detail</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Page Header End -->

        <!-- Room Detail Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="row g-5">
                    <div class="col-lg-8 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="room-item shadow rounded overflow-hidden mb-5">
                            <div class="position-relative">
                                <img class="img-fluid w-100" src="{{ $hotel->image ? $hotel->image : asset('img/room-1.jpg') }}" alt="{{ $hotel->name }}">
                                <small class="position-absolute start-0 top-100 translate-middle-y bg-primary text-white rounded py-1 px-3 ms-4">
                                    {{ $hotel->price ? 'PKR ' . number_format($hotel->price) . '/Night' : 'Check Price' }}
                                </small>
                            </div>
                        </div>
                        <h1 class="mb-4">{{ $hotel->name }}</h1>
                        <div class="d-flex mb-3">
                            <div class="me-3">
                                @for($i = 0; $i < 5; $i++)
                                    @if($i < round($hotel->rating))
                                        <small class="fa fa-star text-primary"></small>
                                    @else
                                        <small class="fa fa-star text-secondary"></small>
                                    @endif
                                @endfor
                            </div>
                            <small class="border-start ps-3"><i class="fa fa-map-marker-alt text-primary me-2"></i>{{ $hotel->address }}, {{ $hotel->city }}</small>
                        </div>
                        
                        <p class="mb-4">{{ $hotel->description ?? 'Experience a comfortable stay with excellent amenities and service.' }}</p>
                        
                        <div class="row g-3 mb-4">
                            <div class="col-sm-4 wow fadeIn" data-wow-delay="0.1s">
                                <div class="border rounded p-1">
                                    <div class="border rounded text-center p-4">
                                        <i class="fa fa-bed fa-2x text-primary mb-2"></i>
                                        <h2 class="mb-1" data-toggle="counter-up">3</h2>
                                        <p class="mb-0">Beds</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 wow fadeIn" data-wow-delay="0.3s">
                                <div class="border rounded p-1">
                                    <div class="border rounded text-center p-4">
                                        <i class="fa fa-bath fa-2x text-primary mb-2"></i>
                                        <h2 class="mb-1" data-toggle="counter-up">2</h2>
                                        <p class="mb-0">Baths</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 wow fadeIn" data-wow-delay="0.5s">
                                <div class="border rounded p-1">
                                    <div class="border rounded text-center p-4">
                                        <i class="fa fa-wifi fa-2x text-primary mb-2"></i>
                                        <h2 class="mb-1" data-toggle="counter-up">Free</h2>
                                        <p class="mb-0">Wifi</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a class="btn btn-primary rounded py-3 px-5" href="{{ route('rooms') }}">Back to Rooms</a>
                            <a class="btn btn-dark rounded py-3 px-5" href="{{ $hotel->booking_url && $hotel->booking_url !== '#' ? $hotel->booking_url : ($hotel->url && $hotel->url !== '#' && !str_contains($hotel->url, 'booking.com') ? $hotel->url : 'https://www.booking.com/searchresults.html?ss=' . urlencode($hotel->name . ' ' . $hotel->city . ' ' . ($hotel->address ?? ''))) }}" target="_blank">Book Now</a>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="bg-light p-4 mb-5 wow fadeInUp" data-wow-delay="0.1s">
                            <h4 class="section-title text-start text-primary text-uppercase mb-4">Contact</h4>
                            <p><i class="fa fa-map-marker-alt me-2"></i>123 Hotel Avenue, Global City</p>
                            <p><i class="fa fa-phone-alt me-2"></i>+1 234 567 8900</p>
                            <p><i class="fa fa-envelope me-2"></i>info@hotelrecsys.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Room Detail End -->

        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-light footer wow fadeIn" data-wow-delay="0.1s">
            <div class="container pb-5">
                <div class="row g-5">
                    <div class="col-md-6 col-lg-4">
                        <div class="bg-primary rounded p-4">
                            <a href="{{ url('/') }}"><h1 class="text-white text-uppercase mb-3" style="font-size: 20px;">Hotel Recommendation System</h1></a>
                            <p class="text-white mb-0">
                                Experience the best hospitality with our curated selection of top-rated hotels. We provide personalized recommendations to ensure your stay is comfortable and memorable.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <h6 class="section-title text-start text-primary text-uppercase mb-4">Contact</h6>
                        <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Hotel Avenue, Global City</p>
                        <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+1 234 567 8900</p>
                        <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@hotelrecsys.com</p>
                    </div>
                    <div class="col-lg-5 col-md-12">
                        <div class="row gy-5 g-4">
                            <div class="col-md-6">
                                <h6 class="section-title text-start text-primary text-uppercase mb-4">Services</h6>
                            <a class="btn btn-link" href="{{ route('rooms') }}">Rooms & Apartment</a>
                            <a class="btn btn-link" href="{{ route('dashboard') }}">Food & Restaurant</a>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('lib/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>
