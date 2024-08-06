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
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />
  <!-- additional styles for search form -->
  <link href="css/form.css" rel="stylesheet" />
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
      <div class="step">
        <div>Step 1</div>
        <div>Pilih Jadwal</div>
      </div>
      <div class="step active">
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
    <div class="container_center">
      <div class="container_data">
        <form action="{{ route('save_pemesan') }}" method="POST">
            @csrf
            <input type="hidden" name="schedule_id" value="{{ $schedule_id }}">
            <input type="hidden" name="total_passengers" value="{{ $total_passengers }}">

            <div class="form-group">
                <label for="customer_name"><i class="fas fa-user"></i> Nama Pemesan</label>
                <input type="text" id="customer_name" name="customer_name" placeholder="Masukkan nama pemesan">
            </div>
            <div class="form-group">
                <label for="customer_email"><i class="fas fa-envelope"></i> E-mail</label>
                <input type="email" id="customer_email" name="customer_email" placeholder="Masukkan Email">
            </div>
            <div class="form-group">
                <label for="customer_address"><i class="fas fa-map-marker-alt"></i> Alamat</label>
                <input type="text" id="customer_address" name="customer_address" placeholder="Masukkan Alamat">
            </div>
            <div class="form-group">
                <label for="customer_phone"><i class="fas fa-phone"></i> Telepon</label>
                <input type="text" id="customer_phone" name="customer_phone" placeholder="Masukkan No. Telpon">
            </div>

            @for ($i = 1; $i <= $total_passengers; $i++)
                <div class="form-group">
                    <label for="passenger{{ $i }}">Nama Penumpang {{ $i }}</label>
                    <input type="text" id="passenger{{ $i }}" name="passenger{{ $i }}" class="form-control" placeholder="Masukkan nama penumpang {{ $i }}">
                </div>
            @endfor

            <div class="form-buttons">
                <button type="button" class="btn btn-primary">
                  <a href="{{ route('pilih_jadwal') }}">Sebelumnya</a>
                </button>
                <button type="submit" class="btn btn-secondary">Selanjutnya</button>
            </div>
        </form>
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
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
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
  </script>
  <!-- end owl carousel script -->
</body>

</html>