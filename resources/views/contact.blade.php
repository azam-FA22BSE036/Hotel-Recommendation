<x-app-layout>
    <!-- Header Start -->
    <div class="container-fluid bg-dark px-0">
        <div class="row gx-0">
            <div class="col-lg-3 bg-dark d-none d-lg-block">
                <a href="{{ url('/') }}"
                    class="navbar-brand w-100 h-100 m-0 p-0 d-flex align-items-center justify-content-center">
                    <h1 class="m-0 text-primary text-uppercase" style="font-size: 15px;">Hotel Recommendation System</h1>
                </a>
            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-dark navbar-dark p-3 p-lg-0">
                    <a href="{{ url('/') }}" class="navbar-brand d-block d-lg-none">
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
                            <a href="{{ route('contact') }}" class="nav-item nav-link active">Contact</a>
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
                                        <a href="{{ route('wishlist.view') }}" class="dropdown-item">Wishlist</a>
                                        <a href="{{ route('history.view') }}" class="dropdown-item">Search History</a>
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
                                    <a href="{{ route('wishlist.view') }}" class="nav-item nav-link">Wishlist</a>
                                    <a href="{{ route('history.view') }}" class="nav-item nav-link">Search History</a>
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
                <h1 class="display-3 text-white mb-3 animated slideInDown">Contact Us</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Contact</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Contact Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title text-center text-primary text-uppercase">Contact Us</h6>
                <h1 class="mb-5"><span class="text-primary text-uppercase">Contact</span> For Any Query</h1>
            </div>
            <div class="row g-4">
                <div class="col-12">
                    <div class="row gy-4">
                        <div class="col-md-4">
                            <h6 class="section-title text-start text-primary text-uppercase">Booking</h6>
                            <p><i class="fa fa-envelope-open text-primary me-2"></i>booking@hotelrecsys.com</p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="section-title text-start text-primary text-uppercase">General</h6>
                            <p><i class="fa fa-envelope-open text-primary me-2"></i>info@hotelrecsys.com</p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="section-title text-start text-primary text-uppercase">Technical</h6>
                            <p><i class="fa fa-envelope-open text-primary me-2"></i>tech@hotelrecsys.com</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 wow fadeIn" data-wow-delay="0.1s">
                    <iframe class="position-relative rounded w-100 h-100"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3001156.4288297426!2d-78.01371936852176!3d42.72876761954724!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4ccc4bf0f123a5a9%3A0xddcfc6c1de189567!2sNew%20York%2C%20USA!5e0!3m2!1sen!2sbd!4v1603794290143!5m2!1sen!2sbd"
                        frameborder="0" style="min-height: 350px; border:0;" allowfullscreen="" aria-hidden="false"
                        tabindex="0"></iframe>
                </div>
                <div class="col-md-6">
                    <div class="wow fadeInUp" data-wow-delay="0.2s">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form action="{{ route('contact.store') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" required>
                                        <label for="name">Your Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Your Email" required>
                                        <label for="email">Your Email</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" required>
                                        <label for="subject">Subject</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Leave a message here" id="message" name="message" style="height: 150px" required></textarea>
                                        <label for="message">Message</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->
</x-app-layout>
