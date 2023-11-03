@extends('layouts.dashboard.app')

@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <h1>
            @lang('site.products')
        </h1>

        <ol class="breadcrumb">
            <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard">@lang('site.dashboard')</i></a></li>
            <li><a href="{{route('products.index')}}">@lang('site.products')</a></li>
            <li class="active">@lang('site.add')</i></li>
        </ol>

    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <div class="box-title">@lang('site.add')</div>
            </div>
            <div class="box-body">
                @include('partials._errors')

                <form action="{{route('products.update',$product->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{method_field('put')}}
                    <div class="form-group">
                        <label for="">@lang('site.categories')</label>
                        <select name="category_id" class="form-control">
                            <option value="">@lang('site.all_categories')</option>
                            @foreach ($categories as $category)
                            <option value="{{$category->id}}" {{$product->category_id == $category->id ? 'selected': ''}}>{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">@lang('site.name')</label>
                        <input type="text" class="form-control" name="name" value="{{$product->name}}" required>
                    </div>
                    <div class="form-group">
                        <label for="">@lang('site.description')</label>
                        <textarea  class="form-control ckeditor" name="description"  required>{!!$product->description!!}</textarea>
                    </div>
                    <div class="form-group" runat="server">
                        <label for="">@lang('site.image')</label>
                        <input type="file" class="form-control" name="image" accept="image/*" id="imgInp">
                    </div>
                    <div class="form-group">
                        <img id="blah" src="{{$product->image_path}}" alt="your image" width="150" class="img-thumbnail" />
                    </div>
                    <div class="form-group">
                        <label for="">@lang('site.purchase_price')</label>
                        <input type="number" class="form-control" name="purchase_price" value="{{$product->purchase_price}}" required>
                    </div>
                    <div class="form-group">
                        <label for="">@lang('site.sale_price')</label>
                        <input type="number" class="form-control" name="sale_price" value="{{$product->sale_price}}" required>
                    </div>
                    <div class="form-group">
                        <label for="">@lang('site.stock')</label>
                        <input type="number" class="form-control" name="stock" value="{{$product->stock}}" required>
                    </div>


            <div class="form-group">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('site.update')</button>
                    </div>
                </form>
            </div> <!--end of box body-->
        </div>
    </section>



</div>
@endsection
