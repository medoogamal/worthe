@extends('layouts.dashboard.app')

@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <h1>
            @lang('site.clients')
        </h1>

        <ol class="breadcrumb">
            <li> <a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard">@lang('site.dashboard')</i></a></li>
            <li class="active">@lang('site.clients')</i></li>
        </ol>

    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <div class="box-title">@lang('site.clients')</div> (<small>{{$clients->total()}}</small>)
            </div><!--end of box header-->

            <form action="{{route('clients.index')}}" method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" id="" placeholder="@lang('site.search')" value="{{request()->search}}" />
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>@lang('site.search')</button>
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
                        @if ($clients->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th style="width: 10px">#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.address')</th>
                                <th>@lang('site.phone')</th>
                                <th>@lang('site.add_order')</th>
                                <th>@lang('site.action')</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $index=>$client)
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ $client->first_name }} {{ $client->last_name }}</td>
                                        <td>{{ $client->address_city . ' , ' . $client->city . ' , ' . $client->street }}</td>
                                        <td>{{$client->phone}}</td>
                                        @if (auth()->user()->hasPermission('orders-create'))
                                        <td> <a href="{{ route('users.orders.create', $client->id) }}" class="btn btn-info btn-sm">@lang('site.add_order')</a></td>
                                        @else
                                        <td> <button class="btn btn-info btn-sm" disabled>@lang('site.add_order')</button></td>
                                        @endif
                                        <td>
                                            {{-- @if(auth()->user()->hasPermission('clients-update'))
                                                <a href="{{ route('clients.edit', $client ->id) }}" class="btn btn-info btn-sm">@lang('site.edit')</a>
                                            @else
                                                <button class="btn btn-info btn-sm" disabled>@lang('site.edit')</button>
                                            @endif --}}

                                            @if (auth()->user()->hasPermission('users-delete'))
                                                <form action="{{ route('clients.destroy', $client->id) }}" method="post" style="display: inline-block; padding-right:2px;">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger delete btn-sm">@lang('site.delete')</button>
                                                </form>
                                            @else
                                                <button class="btn btn-danger delete btn-sm" disabled>@lang('site.delete')</button>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                          </table>
                    </div>

                          {{ $clients->appends(request()->query())->links() }}
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
