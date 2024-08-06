<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>Pemesanan</title>

  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Poppins:400,700&display=swap" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
  <!-- responsive style -->
  <link href="{{ asset('css/responsive.css') }}" rel="stylesheet" />
  <!-- additional styles for search form -->
  <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
</head>

<body class="sub_page">
  <div class="hero_area">
    <!-- header section starts -->
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container pt-3">
          <a class="navbar-brand" href="/">
            <span>Travel</span>
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="d-flex ml-auto flex-column flex-lg-row align-items-center"></div>
          </div>
        </nav>
      </div>
    </header>
    <!-- end header section -->
  </div>

  <!-- booking section -->
  <section class="booking_section layout_padding">
    <div class="step-container">
      <div class="step">
        <div>Step 1</div>
        <div>Pilih Jadwal</div>
      </div>
      <div class="step">
        <div>Step 2</div>
        <div>Data Pemesan</div>
      </div>
      <div class="step active">
        <div>Step 3</div>
        <div>Pilih Kursi</div>
      </div>
      <div class="step">
        <div>Step 4</div>
        <div>Pembayaran</div>
      </div>
    </div>
    <br>
    <div class="container">
      <div class="heading_container">
        <h2>PEMESANAN TIKET</h2>
        <p>consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
      </div>
      <div class="seat-selection">
        <h2>Pilih Kursi</h2>
        <div class="seat-container">
          <div class="seat-grid" id="seatGrid">
            <!-- Kursi akan dihasilkan secara dinamis di sini -->
          </div>
          <div class="selected-seats">
            <h2>Kursi yang Dipilih</h2>
            <ul id="selectedSeatsList">
              <!-- Kursi yang dipilih akan ditampilkan di sini -->
            </ul>
          </div>
          <div>
            <div class="legend">
              <h3>Keterangan</h3>
              <div class="legend-item">
                <span class="legend-box booked"></span> Kursi yang Sudah Dibooking
              </div>
              <div class="legend-item">
                <span class="legend-box available"></span> Kursi yang Belum Dibooking
              </div>
              <div class="legend-item">
                <span class="legend-box selected"></span> Kursi yang Dipilih
              </div>
            </div>
            <br>
            <h3>Rincian</h3>
            <p id="totalPrice">Harga : Rp.{{ number_format($booking->schedule->price * $total_passengers, 0, ',', '.') }}</p>
            <p>Keberangkatan : {{ $booking->schedule->route->departure }}</p>
            <p>Tujuan : {{ $booking->schedule->route->destination }}</p>
          </div>
        </div>
      </div>
      <div class="actions">
        <form action="{{ route('store_seat_selection') }}" method="POST">
          @csrf
          <input type="hidden" name="booking_id" value="{{ $booking->id }}">
          <input type="hidden" name="selectedSeats" id="selectedSeatsInput">
          <div class="button-container">
            <button type="button" class="btn btn-secondary" onclick="goBack()">Sebelumnya</button>
            <button type="submit" class="btn btn-primary" id="nextButton" disabled>Selanjutnya</button>
          </div>
        </form>
      </div>
    </div>
  </section>

  <script>
    const maxSeats = {{ $total_passengers }};
    const seatGrid = document.getElementById('seatGrid');
    const selectedSeatsList = document.getElementById('selectedSeatsList');
    const selectedSeatsInput = document.getElementById('selectedSeatsInput');
    const totalPriceElement = document.getElementById('totalPrice');
    const seatPrice = {{ $booking->schedule->price }};
    const nextButton = document.getElementById('nextButton');

    // Tetap menggunakan array untuk mendefinisikan tata letak kursi
    const seats = [
        { type: 'seat', seat_number: 1 }, { type: 'gap' }, { type: 'gap' }, { type: 'driver-seat' }, 
        { type: 'gap' }, { type: 'gap' }, { type: 'seat', seat_number: 2 }, { type: 'seat', seat_number: 3 }, 
        { type: 'seat', seat_number: 4 }, { type: 'gap' }, { type: 'seat', seat_number: 5 }, { type: 'seat', seat_number: 6 }, 
        { type: 'seat', seat_number: 7 }, { type: 'gap' }, { type: 'seat', seat_number: 8 }, { type: 'seat', seat_number: 9 }, 
        { type: 'seat', seat_number: 10 }, { type: 'seat', seat_number: 11 }, { type: 'seat', seat_number: 12 }, { type: 'seat', seat_number: 13 }
    ];

    // Data kursi dari database
    const dbSeats = @json($seats);

    // Gabungkan informasi kursi dari database dengan tata letak kursi
    seats.forEach(seat => {
        if (seat.type === 'seat') {
            const dbSeat = dbSeats.find(s => s.seat_number === seat.seat_number);
            if (dbSeat) {
                seat.booked = dbSeat.status === 'booked';
            }
        }
    });

    // Generate kursi
    seats.forEach(seat => {
        let seatElement;

        if (seat.type === 'seat') {
            seatElement = document.createElement('div');
            seatElement.classList.add('seat');
            seatElement.textContent = seat.seat_number;
            seatElement.dataset.seatNumber = seat.seat_number;
            if (seat.booked) {
                seatElement.classList.add('booked');
            } else {
                seatElement.onclick = () => toggleSeat(seatElement, seat.seat_number);
            }
        } else if (seat.type === 'driver-seat') {
            seatElement = document.createElement('div');
            seatElement.classList.add('driver-seat');
            seatElement.textContent = 'SUPIR';
        } else if (seat.type === 'gap') {
            seatElement = document.createElement('div');
            seatElement.classList.add('gap');
        }

        seatGrid.appendChild(seatElement);
    });

    function toggleSeat(element, seatNumber) {
        const selectedSeats = document.querySelectorAll('.seat.selected').length;

        if (!element.classList.contains('selected') && selectedSeats < maxSeats) {
            element.classList.add('selected');
            updateSelectedSeats();
        } else if (element.classList.contains('selected')) {
            element.classList.remove('selected');
            updateSelectedSeats();
        }
    }

    function updateSelectedSeats() {
        const selectedSeats = Array.from(document.querySelectorAll('.seat.selected'))
                                  .map(seat => seat.dataset.seatNumber);

        selectedSeatsList.innerHTML = '';
        selectedSeats.forEach(seatNumber => {
            const li = document.createElement('li');
            li.textContent = 'Kursi ' + seatNumber;
            selectedSeatsList.appendChild(li);
        });

        selectedSeatsInput.value = selectedSeats.join(',');

        // Update total price
        const totalPrice = selectedSeats.length * seatPrice;
        totalPriceElement.textContent = 'Harga : Rp.' + totalPrice.toLocaleString('id-ID');

        // Enable or disable the next button based on selected seats
        nextButton.disabled = selectedSeats.length !== maxSeats;
    }

    // Adjust the size of the selected-seats element based on the number of selected seats
        const selectedSeatsCount = selectedSeats.length;
        const baseHeight = 100; // Base height in pixels
        const additionalHeight = 20; // Additional height per selected seat in pixels
        const newHeight = baseHeight + (selectedSeatsCount * additionalHeight);
        
        document.querySelector('.selected-seats').style.height = `${newHeight}px`;

    function goBack() {
        window.history.back();
    }

    function proceed() {
      const selectedSeats = Array.from(document.querySelectorAll('.seat.selected'))
                                .map(seat => seat.textContent);
      if (selectedSeats.length === 0) {
          alert('Silakan pilih kursi terlebih dahulu.');
          return;
      }

      const bookingId = '{{ $booking->id }}'; // Assuming you have booking data in your view

      fetch('{{ route("store_seat_selection") }}', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({
              selectedSeats: selectedSeats,
              booking_id: bookingId
          })
      })
      .then(response => response.json())
      .then(data => {
          window.location.href = `/pembayaran/${bookingId}`;
      });
    }
  </script>
</body>
</html>
