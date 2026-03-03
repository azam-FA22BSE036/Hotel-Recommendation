<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Hotel Recommendation System - @yield('title')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="keywords" />
    <meta content="" name="description" />

    <!-- Favicon -->
    <link href="{{ asset('img/favicon.ico') }}" rel="icon" />

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
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet" />
    <link
      href="{{ asset('lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}"
      rel="stylesheet"
    />

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
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
                  <a href="{{ route('rooms') }}" class="nav-item nav-link">Rooms</a>
                </div>
                
                <div class="navbar-nav d-lg-none">
                    @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="nav-item nav-link">Logout</a>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="nav-item nav-link">Login</a>
                        <a href="{{ route('register') }}" class="nav-item nav-link">Register</a>
                    @endauth
                </div>

                <div class="row gx-0 bg-white d-none d-lg-flex">
                    <div class="col-lg-7 px-5 text-start">
                        @auth
                        <div class="h-100 d-inline-flex align-items-center py-2 me-4">
                            <i class="fa fa-sign-out text-primary me-2"></i>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                    <p class="mb-0">Logout</p>
                                </a>
                            </form>
                        </div>
                        @else
                        <div class="h-100 d-inline-flex align-items-center py-2 me-4">
                            <i class="fa fa-lock text-primary me-2"></i>
                            <a href="{{ route('login') }}">
                                <p class="mb-0">Login</p>
                            </a>
                        </div>
                        <div class="h-100 d-inline-flex align-items-center py-2">
                            <i class="fa fa-user text-primary me-2"></i>
                            <a href="{{ route('register') }}">
                                <p class="mb-0">Register</p>
                            </a>
                        </div>
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
              @yield('title')
            </h1>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb justify-content-center text-uppercase">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">@yield('title')</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
      <!-- Page Header End -->

      <!-- Content Start -->
      <div class="container-xxl py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="bg-white p-5 rounded shadow">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
      </div>
      <!-- Content End -->

      <!-- Footer Start -->
      <div
        class="container-fluid bg-dark text-light footer wow fadeIn"
        data-wow-delay="0.1s"
      >
        <div class="container pb-5">
          <div class="row g-5">
            <div class="col-md-6 col-lg-4">
              <div class="bg-primary rounded p-4">
                <a href="{{ route('dashboard') }}"
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
                <i class="fa fa-map-marker-alt me-3"></i>123 Street, New York,
                USA
              </p>
              <p class="mb-2">
                <i class="fa fa-phone-alt me-3"></i>+012 345 67890
              </p>
              <p class="mb-2">
                <i class="fa fa-envelope me-3"></i>info@example.com
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
