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
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}" />
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
            <span>
              Travel
            </span>
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="d-flex ml-auto flex-column flex-lg-row align-items-center">
            </div>
          </div>
        </nav>
      </div>
    </header>
    <!-- end header section -->
  </div>

  <!-- booking section -->
  <section class="booking_section layout_padding">
    <div class="step-container">
      <div class="step active">
        <div>Step 1</div>
        <div>Pilih Jadwal</div>
      </div>
      <div class="step">
        <div>Step 2</div>
        <div>Data Pemesan</div>
      </div>
      <div class="step">
        <div>Step 3</div>
        <div>Pilih Kursi</div>
      </div>
      <div class="step">
        <div>Step 4</div>
        <div>Pembayaran</div>
      </div>
    </div>
    </br>
    <div class="container">
      <div class="heading_container">
        <h2>
          PEMESANAN TIKET
        </h2>
        <p>
          Silakan cari bus yang sesuai dengan titik keberangkatan dan tujuan anda.
        </p>
      </div>
      </br>
      <div class="booking-container">
        <div class="search-form">
          <form id="searchForm" method="GET" action="{{ route('search') }}">
            <label for="departure">Keberangkatan</label>
            <select id="departure" name="departure" class="form-control" onchange="updateDestination()">
              <optgroup label="SERANG">
                <option value="CICERI">CICERI, SERANG</option>
              </optgroup>
              <optgroup label="CILEGON">
                <option value="CILEGON">BTM CILEGON</option>
              </optgroup>
              <optgroup label="BANDUNG">
                <option value="PASTEUR">KUNAFE PASTEUR</option>
                <option value="BUAH BATU">BUAH BATU</option>
              </optgroup>
            </select>

            <label for="destination">Tujuan</label>
            <select id="destination" name="destination" class="form-control">
              <optgroup label="SERANG">
                <option value="CICERI">CICERI, SERANG</option>
              </optgroup>
              <optgroup label="CILEGON">
                <option value="CILEGON">BTM CILEGON</option>
              </optgroup>
              <optgroup label="BANDUNG">
                <option value="PASTEUR">KUNAFE PASTEUR</option>
                <option value="BUAH BATU">BUAH BATU</option>
              </optgroup>
            </select>

            <label for="date">Tanggal Berangkat</label>
            <input type="date" id="date" name="date">

            <label for="passenger">Penumpang</label>
            <select id="passenger" name="passenger">
              <option value="1">1 Orang</option>
              <option value="2">2 Orang</option>
              <option value="3">3 Orang</option>
              <option value="4">4 Orang</option>
              <option value="5">5 Orang</option>
              <option value="6">6 Orang</option>
            </select>

            <button type="submit">Cari</button>
          </form>
        </div>
        <div class="search-results" id="searchResults">
          @if(isset($schedules) && $schedules->count() > 0)
            @foreach($schedules as $schedule)
              <div class="result">
                <div>
                  <strong>jam berangkat:   {{ $schedule->departure_time }}</strong> 
                </div>
                <div>
                  Tersedia {{ $schedule->available_seats }} kursi
                </div>
                <div>
                  Rp {{ number_format($schedule->price, 0, ',', '.') }}
                </div>
                <button type="button">
                  <a href="{{ route('data_pemesan', ['schedule_id' => $schedule->id, 'total_passengers' => $total_passengers]) }}">
                  Pilih
                  </a>
                </button>
              </div>
            @endforeach
          @else
            <p>Tidak ada hasil ditemukan.</p>
          @endif
        </div>
      </div>

    </div>
  </section>

  <!-- end work section -->

  <!-- info section -->
  <section class="info_section ">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <div class="info_contact">
            <h5>
              About Shop
            </h5>
            <div>
              <div class="img-box">
                <img src="images/location-white.png" width="18px" alt="">
              </div>
              <p>
                Address
              </p>
            </div>
            <div>
              <div class="img-box">
                <img src="images/telephone-white.png" width="12px" alt="">
              </div>
              <p>
                +01 1234567890
              </p>
            </div>
            <div>
              <div class="img-box">
                <img src="images/envelope-white.png" width="18px" alt="">
              </div>
              <p>
                demo@gmail.com
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="info_info">
            <h5>
              Informations
            </h5>
            <p>
              ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end info_section -->


  <!-- footer section -->
  <section class="container-fluid footer_section">

  </section>
  <!-- footer section -->

  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
  </script>
  <!-- owl carousel script 
    -->
  <script type="text/javascript">
    $(".owl-carousel").owlCarousel({
      loop: true,
      margin: 0,
      navText: [],
      center: true,
      autoplay: true,
      autoplayHoverPause: true,
      responsive: {
        0: {
          items: 1
        },
        1000: {
          items: 3
        }
      }
    });
    $(document).ready(function() {
      $('#departure').select2();
      $('#destination').select2();
    });

    function updateDestination() {
      const departureValue = $('#departure').val();
      const $destination = $('#destination');
      $destination.find('option').prop('disabled', false); // Enable all options
      $destination.find(`option[value="${departureValue}"]`).prop('disabled', true); // Disable selected departure option
      $destination.val(null).trigger('change'); // Reset the value and trigger change event
    }

  </script>
  <!-- end custom script -->

</body>

</html>
