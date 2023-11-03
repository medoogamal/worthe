@extends('layouts.dashboard.app')

@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <h1>
            @lang('site.categories')
        </h1>

        <ol class="breadcrumb">
            <li> <a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard">@lang('site.dashboard')</i></a></li>
            <li class="active">@lang('site.categories')</i></li>
        </ol>

    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <div class="box-title">@lang('site.categories')</div> (<small>{{$categories->total()}}</small>)
            </div><!--end of box header-->

            <form action="{{route('categories.index')}}" method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" id="" placeholder="@lang('site.search')" value="{{request()->search}}" />
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>@lang('site.search')</button>
                        <a href="{{route('categories.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('site.add')</a>
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
                        @if ($categories->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th style="width: 10px">#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.products_count')</th>
                                <th>@lang('site.related_products')</th>
                                <th>@lang('site.action')</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $index=>$category)
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->products->count() }}</td>
                                        <td><a href="{{route('products.index',['category_id' => $category->id])}}" class="btn btn-primary">@lang('site.related_products')</a></td>
                                        <td>

                                            @if(auth()->user()->hasPermission('categories-update'))
                                                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-info btn-sm">@lang('site.edit')</a>
                                            @else
                                                <button class="btn btn-info btn-sm" disabled>@lang('site.edit')</button>
                                            @endif

                                            @if (auth()->user()->hasPermission('categories-delete'))
                                                <form action="{{ route('categories.destroy', $category->id) }}" method="post" style="display: inline-block; padding-right:2px;">
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

                          {{ $categories->appends(request()->query())->links() }}
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
