@extends('layouts.dashboard.app')

@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <h1>
            @lang('site.products')
        </h1>

        <ol class="breadcrumb">
            <li> <a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard">@lang('site.dashboard')</i></a></li>
            <li class="active">@lang('site.products')</i></li>
        </ol>

    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <div class="box-title">@lang('site.products')</div> (<small>{{$products->total()}}</small>)
            </div><!--end of box header-->

            <form action="{{route('products.index')}}" method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" id="" placeholder="@lang('site.search')" value="{{request()->search}}" />
                    </div>
                    <div class="col-md-4">
                        <select name="category_id" class="form-control">
                            <option value="">@lang('site.categories')</option>
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}" {{request()->category_id == $category->id ? 'selected': ''}}>{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>@lang('site.search')</button>
                        <a href="{{route('products.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('site.add')</a>
                    </div>
                </div>
            </form>

            <div class="box-body">
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Bordered Table</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @if ($products->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th style="width: 10px">#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.description')</th>
                                <th>@lang('site.category')</th>
                                <th>@lang('site.image')</th>
                                <th>@lang('site.purchase_price')</th>
                                <th>@lang('site.sale_price')</th>
                                <th>@lang('site.profit_percent')</th>
                                <th>@lang('site.stock')</th>
                                <th>@lang('site.action')</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $index=>$product)

                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td class="description-column">{!! $product->description !!}</td>
                                        <td>{{ $product->category->name }}</td>
                                        <td><img width="50" class="img-thumbnail" src="{{$product->image_path}}" alt=""></td>
                                        <td>{{ $product->purchase_price }}</td>
                                        <td>{{ $product->sale_price }}</td>
                                        <td>{{ $product->sale_price - $product->purchase_price }}</td>
                                        <td>{{ $product->stock}}</td>
                                        <td>

                                            @if(auth()->user()->hasPermission('products-update'))
                                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-info btn-sm">@lang('site.edit')</a>
                                            @else
                                                <button class="btn btn-info btn-sm" disabled>@lang('site.edit')</button>
                                            @endif

                                            @if (auth()->user()->hasPermission('products-delete'))
                                                <form action="{{ route('products.destroy', $product->id) }}" method="post" style="display: inline-block; padding-right:2px;">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger delete btn-sm">@lang('site.delete')</button>
                                                </form>
                                            @else
                                                <button class="btn btn-danger btn-sm" disabled>@lang('site.delete')</button>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                          </table>
                        </div>

                          {{ $products->appends(request()->query())->links() }}
                          @else

                          <h1>@lang('site.no_data_found')</h1>
                        @endif

                    </div>

                  </div>
                  <!-- /.card -->
            </div> <!--end of box body-->
        </div><!--end of box -->
    </section>



</div>
@endsection
