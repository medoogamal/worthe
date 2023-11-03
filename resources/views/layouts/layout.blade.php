<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--
    - favicon
  -->
  <title>WORTH | Fashion & products</title>
  <link rel="icon" type="image/x-icon" href="{{ asset('uploads/logo.png') }}">

  <!--
    - custom css link
  -->
  <link rel="stylesheet" href=" {{ asset('css/style-prefix.css') }}">

  <!--
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">

</head>

<body>
  <div class="overlay" data-overlay></div>

  <!--
    - MODAL
  -->

  @if (Route::has('login'))

  @auth

  @else
  <div class="modal" data-modal>

    <div class="modal-close-overlay" data-modal-overlay></div>

    <div class="modal-content">

      <button class="modal-close-btn" data-modal-close>
        <ion-icon name="close-outline"></ion-icon>
      </button>

      <div class="newsletter-img">
        <img src="{{ asset('/images/newsletter.png') }}" alt="subscribe newsletter" width="400" height="400">
      </div>

      <div class="newsletter">

        {{-- <form action="#">

          <div class="newsletter-header">

            <h3 class="newsletter-title">Subscribe Newsletter.</h3>

            <p class="newsletter-desc">
              Subscribe the <b>Anon</b> to get latest products and discount update.
            </p>

          </div>

          <input type="email" name="email" class="email-field" placeholder="Email Address" required> --}}

        <a href="{{route('login')}}"><button class="btn-newsletter">Subscribe</button></a>

        {{-- </form> --}}

      </div>

    </div>

  </div>
  @endauth

@endif









    <!--
    - HEADER
  -->

  <header>

    <div class="header-top">

      <div class="container">

        <ul class="header-social-container">

          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-facebook"></ion-icon>
            </a>
          </li>

          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-twitter"></ion-icon>
            </a>
          </li>

          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-instagram"></ion-icon>
            </a>
          </li>

          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-linkedin"></ion-icon>
            </a>
          </li>

        </ul>

        <div class="header-alert-news">
          <p>
            <b>worth</b>
            fasion & products
          </p>
        </div>

        <div class="header-top-actions">

            @if (Route::has('login'))

                @auth
                <div class="header-alert-news" style="display: flex; align-items:center; gap:10px;">
                    <p style="margin-top: 2px">
                        <b>{{auth()->user()->first_name}} {{auth()->user()->last_name}}</b>
                    </p>
                    <img src="{{auth()->user()->image_path}}" style="border-radius: 50%" width="30" height="30" alt="">
                    <a href="{{ route('logout') }}" class="btn btn-default btn-flat" onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">@lang('site.logout')</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super_admin'))
                <a href="{{ route('dashboard.index') }}">Dashboard</a>
                @endif

                @else
                    <a href="{{ route('login') }}">Login</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @endauth

            @endif

        </div>

      </div>

    </div>

    <div class="header-main">

      <div class="container">

        <a href="{{route('index')}}" class="header-logo">
          <img src="{{ asset('uploads/logo.png') }}" alt="Anon's logo" width="65" style="margin-top: -5px">
        </a>

        <div class="header-search-container">
        <form action="{{route('multi.product')}}" method="GET">
          <input type="search" name="search" class="search-field" placeholder="Enter your product name...">
        </form>
          <button class="search-btn">
            <ion-icon name="search-outline"></ion-icon>
          </button>

        </div>

        <div class="header-user-actions">
        <a href="{{route('cart.index')}}">
          <button class="action-btn">
            <ion-icon name="bag-handle-outline"></ion-icon>
            <span class="count">{{$count}}</span>
          </button>
        </a>
        </div>

      </div>

    </div>



{{-- ============= content ============ --}}
@yield('content')
{{-- ============= content ============ --}}
@include('partials._session')


 <!--
    - FOOTER
  -->

  <footer>

    <div class="footer-category">

      <div class="container">

        <h2 class="footer-category-title">Brand directory</h2>

        <div class="footer-category-box">

          <h3 class="category-box-title">Fashion :</h3>

          <a href="#" class="footer-category-link">T-shirt</a>
          <a href="#" class="footer-category-link">Shirts</a>
          <a href="#" class="footer-category-link">shorts & jeans</a>
          <a href="#" class="footer-category-link">jacket</a>
          <a href="#" class="footer-category-link">dress & frock</a>
          <a href="#" class="footer-category-link">innerwear</a>
          <a href="#" class="footer-category-link">hosiery</a>

        </div>
        <div class="footer-category-box">

          <h3 class="category-box-title">Electronics :</h3>

          <a href="#" class="footer-category-link">Watches</a>
          <a href="#" class="footer-category-link">head phone</a>
          <a href="#" class="footer-category-link">speakers</a>
          <a href="#" class="footer-category-link">air pods</a>

        </div>



      </div>

    </div>

    <div class="footer-nav">

      <div class="container">


        <ul class="footer-nav-list">

          <li class="footer-nav-item">
            <h2 class="nav-title">Our Company</h2>
          </li>

          <li class="footer-nav-item">
            <a href="#" class="footer-nav-link">Delivery</a>
          </li>


          <li class="footer-nav-item">
            <a href="#" class="footer-nav-link">About us</a>
          </li>

        </ul>

        <ul class="footer-nav-list">

          <li class="footer-nav-item">
            <h2 class="nav-title">Services</h2>
          </li>

          <li class="footer-nav-item">
            <a href="#" class="footer-nav-link">Prices drop</a>
          </li>

          <li class="footer-nav-item">
            <a href="#" class="footer-nav-link">New products</a>
          </li>

          <li class="footer-nav-item">
            <a href="#" class="footer-nav-link">Best sales</a>
          </li>

          <li class="footer-nav-item">
            <a href="#" class="footer-nav-link">Contact us</a>
          </li>

          <li class="footer-nav-item">
            <a href="#" class="footer-nav-link">Sitemap</a>
          </li>

        </ul>

        <ul class="footer-nav-list">

          <li class="footer-nav-item">
            <h2 class="nav-title">Contact</h2>
          </li>

          <li class="footer-nav-item flex">
            <div class="icon-box">
              <ion-icon name="location-outline"></ion-icon>
            </div>

            <address class="content">
              419 State 414 Rte
              Beaver Dams, New York(NY), 14812, USA
            </address>
          </li>

          <li class="footer-nav-item flex">
            <div class="icon-box">
              <ion-icon name="call-outline"></ion-icon>
            </div>

            <a href="tel:+607936-8058" class="footer-nav-link">(607) 936-8058</a>
          </li>

          <li class="footer-nav-item flex">
            <div class="icon-box">
              <ion-icon name="mail-outline"></ion-icon>
            </div>

            <a href="mailto:example@gmail.com" class="footer-nav-link">example@gmail.com</a>
          </li>

        </ul>

        <ul class="footer-nav-list">

          <li class="footer-nav-item">
            <h2 class="nav-title">Follow Us</h2>
          </li>

          <li>
            <ul class="social-link">

              <li class="footer-nav-item">
                <a href="#" class="footer-nav-link">
                  <ion-icon name="logo-facebook"></ion-icon>
                </a>
              </li>

              <li class="footer-nav-item">
                <a href="#" class="footer-nav-link">
                  <ion-icon name="logo-twitter"></ion-icon>
                </a>
              </li>

              <li class="footer-nav-item">
                <a href="#" class="footer-nav-link">
                  <ion-icon name="logo-linkedin"></ion-icon>
                </a>
              </li>

              <li class="footer-nav-item">
                <a href="#" class="footer-nav-link">
                  <ion-icon name="logo-instagram"></ion-icon>
                </a>
              </li>

            </ul>
          </li>

        </ul>

      </div>

    </div>

    <div class="footer-bottom">

      <div class="container">

        <img src="{{ asset('/images/payment.png') }}" alt="payment method" class="payment-img">

        <p class="copyright">
          Copyright &copy; <a href="#">Altneen</a> all rights reserved.
        </p>

      </div>

    </div>

  </footer>






  <!--
    - custom js link
  -->
  <script src="{{ asset('js/script.js') }}"></script>


  <!--
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


</body>

</html>


