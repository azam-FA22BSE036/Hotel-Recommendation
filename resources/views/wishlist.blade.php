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
                                    <a href="{{ route('profile.edit') }}" class="dropdown-item">Profile</a>
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
    <div class="container-fluid page-header mb-5 p-0" style="background-image: url({{ asset('img/carousel-1.jpg') }});">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown">My Wishlist</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Wishlist</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4">
                @if($wishlists->isEmpty())
                    <div class="col-12 text-center">
                        <div class="bg-white shadow rounded p-5">
                            <i class="fa fa-heart text-muted fa-3x mb-3"></i>
                            <p class="text-muted">Your wishlist is empty.</p>
                            <a href="{{ route('dashboard') }}" class="btn btn-primary">Browse Hotels</a>
                        </div>
                    </div>
                @else
                    @foreach($wishlists as $item)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="room-item shadow rounded overflow-hidden h-100">
                            <div class="position-relative">
                                <img class="img-fluid w-100" style="height: 200px; object-fit: cover;" src="{{ $item->image ?? asset('img/room-1.jpg') }}" alt="">
                                <small class="position-absolute start-0 top-100 translate-middle-y bg-primary text-white rounded py-1 px-3 ms-4">
                                    {{ $item->price > 0 ? 'PKR ' . number_format($item->price) . '/Night' : 'Check Price' }}
                                </small>
                                <form action="{{ route('wishlist.destroy', $item->id) }}" method="POST" class="position-absolute end-0 top-0 m-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light rounded-circle text-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="p-4 mt-2 d-flex flex-column justify-content-between" style="min-height: 200px;">
                                <div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <h5 class="mb-0 text-truncate" title="{{ $item->hotel_name }}">{{ $item->hotel_name }}</h5>
                                        <div class="ps-2 text-nowrap">
                                            <small class="fa fa-star text-primary"></small>
                                            {{ $item->rating }}
                                        </div>
                                    </div>
                                    <p class="text-body mb-3 small"><i class="fa fa-map-marker-alt text-primary me-2"></i>{{ $item->location ?? 'Unknown Location' }}</p>
                                </div>
                                <div class="d-flex justify-content-between mt-3">
                                    <a class="btn btn-sm btn-dark rounded py-2 px-4 w-100" href="{{ $item->url && $item->url !== '#' ? $item->url : 'https://www.booking.com/searchresults.html?ss=' . urlencode($item->hotel_name . ' ' . ($item->location ?? '')) }}" target="_blank">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</x-app-layout>