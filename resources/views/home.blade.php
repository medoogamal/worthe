@extends('layouts.layout')

@section('content')

  <!--
    - MAIN
  -->


  <main>
  <!--
    - NOTIFICATION TOAST
  -->

    <div class="notification-toast" data-toast>

      <button class="toast-close-btn data-toast-close" data-toast-close>
        <ion-icon name="close-outline"></ion-icon>
      </button>
      <a href="{{route('single.product',$randomProduct->id)}}">
      <div class="toast-banner">
        <img src="{{ $randomProduct->image_path }}" alt="Rose Gold Earrings" width="80" height="70">
      </div>
    </a>

      <div class="toast-detail">

        <p class="toast-message">
          something may be like it!
        </p>

        <p class="toast-title">
          {{$randomProduct->name}}
        </p>

      </div>

    </div>

    <!--
      - BANNER
    -->
    <nav class="desktop-navigation-menu">

        <div class="container">

          <ul class="desktop-menu-category-list">

            <li class="menu-category">
              <a href="{{route('index')}}" class="menu-title">Home</a>
            </li>

            <li class="menu-category">
              <p  class="menu-title" style="cursor: pointer">Categories</p>

              <div class="dropdown-panel">

                  @foreach ($categories as $category)
                  <ul class="dropdown-panel-list">

                      <li class="menu-title">
                        <a href="{{route('multi.product',["category_id"=>$category->id])}}">{{$category->name}}</a>
                      </li>
                    </ul>
                  @endforeach
                    {{-- end of categories --}}
              </div>
            </li>

            <li class="menu-category">
              <a href="#" class="menu-title">Products</a>
            </li>


            <li class="menu-category">
              <a href="#" class="menu-title">About Us</a>
            </li>

            <li class="menu-category">
              <a href="#" class="menu-title">Contact Us</a>
            </li>

          </ul>

        </div>

      </nav>

      <div class="mobile-bottom-navigation">

        <button class="action-btn" data-mobile-menu-open-btn>
          <ion-icon name="menu-outline"></ion-icon>
        </button>

        <button class="action-btn">
          <ion-icon name="bag-handle-outline"></ion-icon>

          <span class="count">0</span>
        </button>

        <button class="action-btn">
          <a href="{{route('dashboard.index')}}" style="color: black"><ion-icon name="home-outline"></ion-icon></a>
        </button>

        <button class="action-btn" data-mobile-menu-open-btn>
          <ion-icon name="grid-outline"></ion-icon>
        </button>

      </div>

      <nav class="mobile-navigation-menu  has-scrollbar" data-mobile-menu>

        <div class="menu-top">
          <h2 class="menu-title">Menu</h2>

          <button class="menu-close-btn" data-mobile-menu-close-btn>
            <ion-icon name="close-outline"></ion-icon>
          </button>
        </div>

        <ul class="mobile-menu-category-list">

          <li class="menu-category">
            <a href="{{route('index')}}" class="menu-title">Home</a>
          </li>


          <li class="menu-category">
            <a href="#" class="menu-title">About Us</a>
          </li>

          <li class="menu-category">
            <a href="#" class="menu-title">Contact Us</a>
          </li>

        </ul>

        <div class="menu-bottom">


          <ul class="menu-social-container">

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

        </div>

      </nav>

    </header>
    <div class="banner">

      <div class="container">

        <div class="slider-container has-scrollbar">

          <div class="slider-item">

            <img src="{{asset('/images/banner-1.jpg')}}" alt="women's latest fashion sale" class="banner-img">

            <div class="banner-content">

              <p class="banner-subtitle">Trending item</p>

              <h2 class="banner-title">Women's latest fashion sale</h2>

              <p class="banner-text">
                starting at &dollar; <b>20</b>.00
              </p>

              <a href="#" class="banner-btn">Shop now</a>

            </div>

          </div>

          <div class="slider-item">

            <img src="{{asset('/images/banner-2.jpg')}}" alt="modern sunglasses" class="banner-img">

            <div class="banner-content">

              <p class="banner-subtitle">Trending accessories</p>

              <h2 class="banner-title">Modern sunglasses</h2>

              <p class="banner-text">
                starting at &dollar; <b>15</b>.00
              </p>

              <a href="#" class="banner-btn">Shop now</a>

            </div>

          </div>

          <div class="slider-item">

            <img src="{{asset('/images/banner-3.jpg')}}" alt="new fashion summer sale" class="banner-img">

            <div class="banner-content">

              <p class="banner-subtitle">Sale Offer</p>

              <h2 class="banner-title">New fashion summer sale</h2>

              <p class="banner-text">
                starting at &dollar; <b>29</b>.99
              </p>

              <a href="#" class="banner-btn">Shop now</a>

            </div>

          </div>

        </div>

      </div>

    </div>





    <!--
      - CATEGORY
    -->

    <div class="category">

      <div class="container">

        <div class="category-item-container has-scrollbar">
            @foreach ($categories as $category)
            <div class="category-item">

                <div class="category-content-box">

                <div class="category-content-flex">
                    <h3 class="category-item-title">{{$category->name}}</h3>

                    <p class="category-item-amount">({{$category->products()->count()}})</p>
                </div>

                <a href="{{route('multi.product',["category_id"=>$category->id])}}" class="category-btn">Show all</a>   {{-- show all categories --}}

                </div>

            </div>
          @endforeach

        </div>

      </div>

    </div>





    <!--
      - PRODUCT
    -->

    <div class="product-container">

      <div class="container">


        <!--
          - SIDEBAR
        -->

        <div class="sidebar  has-scrollbar" data-mobile-menu>

          <div class="sidebar-category">

            <div class="sidebar-top">
              <h2 class="sidebar-title">Category</h2>

              <button class="sidebar-close-btn" data-mobile-menu-close-btn>
                <ion-icon name="close-outline"></ion-icon>
              </button>
            </div>

            <ul class="sidebar-menu-category-list">

              <li class="sidebar-menu-category">

                @foreach ($categories as $category)
                    <button class="sidebar-accordion-menu" data-accordion-btn>

                        <div class="menu-title-flex">
                            <a href="{{route('multi.product',["category_id"=>$category->id])}}" class="menu-title" >{{$category->name}}</a>
                        </div>

                    </button>
                @endforeach

              </li>

            </ul>

          </div>

        </div>



        <div class="product-box">




          <!--
            - PRODUCT FEATURED
          -->

          <div class="product-featured">

            <h2 class="title">Deal of the day</h2>

            <div class="showcase-wrapper has-scrollbar">

                @foreach ($latest_two_products as $product)
                <a href="{{route('single.product',$product->id)}}">
                <div class="showcase-container">

                    <div class="showcase">

                      <div class="showcase-banner">
                        <img src="{{$product->image_path}}" alt="shampoo, conditioner & facewash packs" class="showcase-img">
                      </div>

                      <div class="showcase-content">


                        <a href="#">
                          <h3 class="showcase-title">{{$product->name}}</h3>
                        </a>

                        <p class="showcase-desc">
                            {!! $product->description !!}
                        </p>

                        <div class="price-box">
                          <p class="price">{{$product->sale_price}} LE.</p>
                        </div>

                        <button class="add-cart-btn">add to cart</button>

                        <div class="showcase-status">
                          <div class="wrapper">

                            <p>
                              available: <b>{{$product->stock}}</b>
                            </p>
                          </div>
                        </div>


                      </div>

                    </div>

                  </div>
                </a>
                  @endforeach


            </div>

          </div>



          <!--
            - PRODUCT GRID
          -->

          <div class="product-main">

            <h2 class="title">Products you may like</h2>

            <div class="product-grid">
                @foreach ($new_products as $product)
                <div class="showcase">
                    <a href="{{route('single.product',$product->id)}}">

                    <div class="showcase-banner">

                      <img src="{{$product->image_path}}" alt="Mens Winter Leathers Jackets" width="300" class="product-img default">
                      <img src="{{$product->image_path}}" alt="Mens Winter Leathers Jackets" width="300" class="product-img hover">

                      <p class="showcase-badge">{{$product->stock}}</p>

                      <div class="showcase-actions">


                        <button class="btn-action">
                          <ion-icon name="eye-outline"></ion-icon>
                        </button>

                        <button class="btn-action">
                          <ion-icon name="bag-add-outline"></ion-icon>
                        </button>

                      </div>

                    </div>

                    <div class="showcase-content">

                      <a href="#" class="showcase-category">{{$product->name}}</a>

                      <a href="#">
                        <h3 class="showcase-title">{!! $product->description !!}</h3>
                      </a>


                      <div class="price-box">
                        <p class="price">{{$product->sale_price}} LE.</p>

                      </div>

                    </div>

                </a>
                  </div>

                  @endforeach


            </div>

          </div>

        </div>

      </div>

    </div>


  </main>

@endsection
