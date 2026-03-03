<x-app-layout>
    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0" style="background-image: url({{ asset('img/carousel-1.jpg') }});">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown">My Bookings</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Bookings</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <div class="container-xxl py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="bg-white shadow rounded p-4 p-sm-5">
                        @if(session('success'))
                            <div class="alert alert-success mb-4">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($bookings->isEmpty())
                            <div class="text-center py-5">
                                <i class="fa fa-suitcase fa-3x text-muted mb-3"></i>
                                <p class="text-muted">You haven't made any bookings yet.</p>
                                <a href="{{ route('dashboard') }}" class="btn btn-primary">Find a Hotel</a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="py-3">Hotel</th>
                                            <th class="py-3">Check In</th>
                                            <th class="py-3">Check Out</th>
                                            <th class="py-3">Guests</th>
                                            <th class="py-3">Total</th>
                                            <th class="py-3">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bookings as $booking)
                                            <tr>
                                                <td class="fw-bold text-primary">{{ $booking->hotel_name }}</td>
                                                <td>{{ $booking->check_in->format('M d, Y') }}</td>
                                                <td>{{ $booking->check_out->format('M d, Y') }}</td>
                                                <td>
                                                    {{ $booking->adults }} Adults
                                                    @if($booking->children > 0), {{ $booking->children }} Kids @endif
                                                </td>
                                                <td class="fw-bold">${{ number_format($booking->total_price, 2) }}</td>
                                                <td>
                                                    <span class="badge bg-success rounded-pill px-3">{{ ucfirst($booking->status) }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
