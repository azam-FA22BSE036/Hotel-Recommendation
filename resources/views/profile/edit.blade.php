<x-app-layout>
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
                                    <a href="{{ route('dashboard') }}" class="dropdown-item">Dashboard</a>
                                    <a href="{{ route('wishlist.view') }}" class="dropdown-item">Wishlist</a>
                                    <a href="{{ route('history.view') }}" class="dropdown-item">Search History</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="{{ route('logout') }}" class="dropdown-item"
                                            onclick="event.preventDefault(); this.closest('form').submit();">Log Out</a>
                                    </form>
                                </div>
                            </div>
                            <div class="d-lg-none">
                                <a href="{{ route('dashboard') }}" class="nav-item nav-link">Dashboard</a>
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
    <div class="container-fluid page-header mb-5 p-0" style="background-image: url({{ asset('img/carousel-1.jpg') }});">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Profile</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Profile</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5 justify-content-center">
                <div class="col-lg-8">
                    <div class="bg-white shadow rounded p-4 p-sm-5 mb-5">
                        <div class="border-bottom pb-4 mb-4">
                            <h3 class="mb-3 text-primary">Profile Information</h3>
                            <p class="text-muted mb-0">Update your account's profile information and email address.</p>
                        </div>
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <div class="bg-white shadow rounded p-4 p-sm-5">
                        <div class="border-bottom pb-4 mb-4">
                            <h3 class="mb-3 text-primary">Update Password</h3>
                            <p class="text-muted mb-0">Ensure your account is using a long, random password to stay secure.</p>
                        </div>
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>