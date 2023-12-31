@extends('layouts.dashboard.app')

@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <h1>
            @lang('site.users')
        </h1>

        <ol class="breadcrumb">
            <li> <a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard">@lang('site.dashboard')</i></a></li>
            <li class="active">@lang('site.users')</i></li>
        </ol>

    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <div class="box-title">@lang('site.users')</div> (<small>{{$users->total()}}</small>)
            </div><!--end of box header-->

            <form action="{{route('users.index')}}" method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" id="" placeholder="@lang('site.search')" value="{{request()->search}}" />
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>@lang('site.search')</button>
                        <a href="{{route('users.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('site.add')</a>
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
                        @if ($users->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th style="width: 10px">#</th>
                                <th>@lang('site.first_name')</th>
                                <th>@lang('site.last_name')</th>
                                <th>@lang('site.email')</th>
                                <th>@lang('site.image')</th>
                                <th>@lang('site.action')</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $index=>$user)
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ $user->first_name }}</td>
                                        <td>{{ $user->last_name }}</td>
                                        <td>{{ $user->email}}</td>
                                        <td><img width="50" class="img-thumbnail" src="{{ $user->image_path}}" alt=""></td>
                                        <td>

                                            @if(auth()->user()->hasPermission('users-update'))
                                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info btn-sm">@lang('site.edit')</a>
                                            @else
                                                <button class="btn btn-info btn-sm" disabled>@lang('site.edit')</button>
                                            @endif

                                            @if (auth()->user()->hasPermission('users-delete'))
                                                <form action="{{ route('users.destroy', $user->id) }}" method="post" style="display: inline-block; padding-right:2px;">
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

                          {{ $users->appends(request()->query())->links() }}
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
