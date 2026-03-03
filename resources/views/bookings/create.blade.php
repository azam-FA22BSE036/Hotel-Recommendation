<x-app-layout>
    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0" style="background-image: url({{ asset('img/carousel-1.jpg') }});">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Trip Cost Estimator</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Price Estimation</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8">
                    <div class="bg-white shadow rounded p-4 p-sm-5">
                        <h3 class="mb-4 text-primary">Estimate Your Stay</h3>
                        
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="hotel_name" value="{{ $hotelName }}" readonly>
                                    <label for="hotel_name">Hotel Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="check_in" min="{{ date('Y-m-d') }}">
                                    <label for="check_in">Check In</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="check_out" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                    <label for="check_out">Check Out</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="adults" value="1" min="1">
                                    <label for="adults">Adults</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="children" value="0" min="0">
                                    <label for="children">Children</label>
                                </div>
                            </div>
                            
                            <div class="col-12 mt-4">
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle me-2"></i>
                                    This is an estimated price based on the average nightly rate and room capacity (approx. 2 adults per room). Final pricing and availability will be confirmed on the booking site.
                                </div>
                                <a id="booking_link" href="{{ $url && $url !== '#' ? $url : '#' }}" target="_blank" class="btn btn-primary w-100 py-3">
                                    Proceed to Booking.com <i class="fa fa-external-link-alt ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="bg-white shadow rounded p-4">
                        <h4 class="mb-4">Cost Summary</h4>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Hotel</span>
                            <span class="fw-bold">{{ $hotelName }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Price per Night</span>
                            <span id="price_per_night" data-price="{{ $price ?? 150 }}">${{ $price ?? 150 }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Rooms Required</span>
                            <span id="rooms_count">1 Room</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Duration</span>
                            <span id="duration_display">0 Nights</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold">Total Estimate</span>
                            <span class="fw-bold text-primary" id="total_price_display">$0.00</span>
                        </div>
                        <small class="text-muted d-block mt-2">* Includes estimated taxes and fees.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkInInput = document.getElementById('check_in');
            const checkOutInput = document.getElementById('check_out');
            const adultsInput = document.getElementById('adults');
            const childrenInput = document.getElementById('children');
            const pricePerNight = parseFloat(document.getElementById('price_per_night').getAttribute('data-price'));
            const totalDisplay = document.getElementById('total_price_display');
            const durationDisplay = document.getElementById('duration_display');
            const roomsDisplay = document.getElementById('rooms_count');
            const bookingLink = document.getElementById('booking_link');
            
            // Base URL logic
            let baseUrl = "{{ $url ?? '' }}";
            if (!baseUrl || baseUrl === '#' || baseUrl === '') {
                // If no specific URL, construct a search URL
                const hotelName = "{{ $hotelName }}";
                baseUrl = `https://www.booking.com/searchresults.html?ss=${encodeURIComponent(hotelName)}`;
            }

            function updateEstimate() {
                const checkInDate = new Date(checkInInput.value);
                const checkOutDate = new Date(checkOutInput.value);
                const adults = parseInt(adultsInput.value) || 1;
                const children = parseInt(childrenInput.value) || 0;
                
                // Estimate rooms needed: 1 room per 2 adults (simplified logic)
                // Children can usually share, but let's say 2 adults + 1 child = 1 room, 2 adults + 2 children = 2 rooms maybe?
                // Let's stick to adult capacity for simplicity: ceil(adults / 2)
                let roomsNeeded = Math.ceil(adults / 2);
                if (roomsNeeded < 1) roomsNeeded = 1;
                
                roomsDisplay.innerText = roomsNeeded + (roomsNeeded === 1 ? ' Room' : ' Rooms');

                if (checkInInput.value && checkOutInput.value && checkOutDate > checkInDate) {
                    const diffTime = Math.abs(checkOutDate - checkInDate);
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    
                    const total = diffDays * pricePerNight * roomsNeeded;
                    
                    totalDisplay.innerText = '$' + total.toFixed(2);
                    durationDisplay.innerText = diffDays + ' Nights';
                    
                    // Update Booking Link with dates if possible (Booking.com parameters)
                    // checkin_year, checkin_month, checkin_monthday, checkout_year...
                    const ci = checkInInput.value.split('-');
                    const co = checkOutInput.value.split('-');
                    
                    let separator = baseUrl.includes('?') ? '&' : '?';
                    let dateParams = `checkin=${checkInInput.value}&checkout=${checkOutInput.value}&group_adults=${adults}&group_children=${children}&no_rooms=${roomsNeeded}`;
                    
                    // For Booking.com specific params if it's a search URL
                    if (baseUrl.includes('booking.com')) {
                        dateParams = `checkin_year=${ci[0]}&checkin_month=${ci[1]}&checkin_monthday=${ci[2]}&checkout_year=${co[0]}&checkout_month=${co[1]}&checkout_monthday=${co[2]}&group_adults=${adults}&group_children=${children}&no_rooms=${roomsNeeded}`;
                    }
                    
                    bookingLink.href = baseUrl + separator + dateParams;
                    
                } else {
                    totalDisplay.innerText = '$0.00';
                    durationDisplay.innerText = '0 Nights';
                    bookingLink.href = baseUrl;
                }
            }

            checkInInput.addEventListener('change', updateEstimate);
            checkOutInput.addEventListener('change', updateEstimate);
            adultsInput.addEventListener('input', updateEstimate);
            childrenInput.addEventListener('input', updateEstimate);
        });
    </script>
</x-app-layout>
