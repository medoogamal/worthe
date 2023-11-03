@extends('layouts.layout')

@section('content')

    <!--
      - PRODUCT
    -->

    <div class="product-container" style="margin-top: 20px">

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
              - PRODUCT GRID
            -->

            <div class="product-main">

              <h2 class="title">Products you may like</h2>

              <div class="product-grid">
                  @foreach ($products as $product)
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
@endsection
