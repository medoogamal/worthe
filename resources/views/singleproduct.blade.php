@extends('layouts.layout')

@section('content')

  <main>
    <article>

      <!--
        - #PRODUCT
      -->

      <section class="section product" aria-label="product">
        <div class="container">

          <div class="product-slides">

            <div class="slider-banner" data-slider>
              <figure class="product-banner">
                <img src="{{$product->image_path}}" width="600" height="600" loading="lazy" alt="Nike Sneaker"
                  class="img-cover">
              </figure>
            </div>

          </div>

          <div class="product-content">

            <p class="product-subtitle">Worth Company</p>

            <h1 class="h1 product-title">{{$product->name}}</h1>

            <p class="product-text">
              {!! $product->description !!}
            </p>

            <div class="wrapper">

              <span class="price" data-total-price>{{$product->sale_price}} LE.</span>

              <span class="badge">available: {{$product->stock}}</span>


            </div>

            <form action="{{route('cart.store')}}" method="POST">
                @csrf
                <div class="btn-group">

                <div class="" style="display: flex; align-items:center; gap:10px;">


                    <input type="hidden" name="product_id" value="{{$product->id}}"  />
                    <span>quantity: </span>
                    <input type="number" name="quantity" min="1" max="{{$product->stock}}" value="1" />


                </div>

                <button class="cart-btn">
                    <ion-icon name="bag-handle-outline" aria-hidden="true"></ion-icon>

                    <span class="span">Add to cart</span>
                </button>


                </div>
            </form>

          </div>

        </div>
      </section>

    </article>
  </main>

@endsection
