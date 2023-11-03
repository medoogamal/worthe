@extends('layouts.layout')

@section('content')

<div class="container2">


    <table class="table table-hover">
        <thead>
        <tr>
            <th>@lang('site.product')</th>
            <th>@lang('site.quantity')</th>
            <th>@lang('site.action')</th>
            {{-- <th>@lang('site.price')</th> --}}
        </tr>
        {{$cartCollection }}
        </thead>
        <tbody class="order-list">
            @foreach ($cartCollection as $cart)
                <tr>
                    <td>{{preg_replace('/\\\u([0-9a-z]{4})/i', '&#x$1;', $cart->name)}}</td>
                    <td>{{$cart->quantity}}</td>
                    {{-- <td class="product-price">{{$cart->unit_price}}</td> --}}
                    <td><form action="{{route('cart.destroy',$cart->id)}}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('post') }}
                        <button type="submit" class="span" style="background-color: red;border-radius:8px; padding:3px 15px;color:white;margin-right:5px;">×</span>
                    </form></td>


                </tr>
            @endforeach

        </tbody>

    </table><!-- end of table -->
    <form action="{{ route('cart.checkout') }}" method="post">
        {{ csrf_field() }}
        {{ method_field('post') }}

        @include('partials._errors')
        @foreach ($cartCollection as $cart)
        <input type="hidden" name="product_ids[]" value="{{$cart->id}}">
        <input type="hidden" name="quantities[]"  class="form-control input-sm product-quantity"  value="{{$cart->quantity}}">
        @endforeach
<div class="pr">
    <h4 class="total-price">@lang('site.total') : <span >{{$total_price}} LE.</span></h4>

    <button class="btn btn-primary btn-block disabled" id="add-order-form-btn"><i class="fa fa-plus"></i> @lang('site.add_order')</button>
</div>
</form>
</div>

@endsection


