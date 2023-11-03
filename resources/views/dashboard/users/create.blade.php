@extends('layouts.dashboard.app')

@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <h1>
            @lang('site.users')
        </h1>

        <ol class="breadcrumb">
            <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard">@lang('site.dashboard')</i></a></li>
            <li><a href="{{route('users.index')}}">@lang('site.users')</a></li>
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

                <form action="{{route('users.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <div class="form-group">
                        <label for="">@lang('site.first_name')</label>
                        <input type="text" class="form-control" name="first_name" value="{{old('first_name')}}">
                    </div>
                    <div class="form-group">
                        <label for="">@lang('site.last_name')</label>
                        <input type="text" class="form-control" name="last_name" value="{{old('last_name')}}">
                    </div>
                    <div class="form-group">
                        <label for="">@lang('site.email')</label>
                        <input type="email" class="form-control" name="email" value="{{old('email')}}">
                    </div>
                    <div class="form-group" runat="server">
                        <label for="">@lang('site.image')</label>
                        <input type="file" class="form-control" name="image" accept="image/*" id="imgInp">
                    </div>
                    <div class="form-group">
                        <img id="blah" src="#" alt="your image" width="150" class="img-thumbnail" />
                    </div>
                    <div class="form-group">
                        <label for="">@lang('site.password')</label>
                        <input type="password" class="form-control" name="password" >
                    </div>
                    <div class="form-group">
                        <label for="">@lang('site.password_confirmation')</label>
                        <input type="password" class="form-control" name="password_confirmation" >
                    </div>

                    <div class="form-group">
            <!-- Custom Tabs -->
            <div class="card" style="border: 1px solid #ddd; margin:5px; padding:5px;">
                <div class="card-header d-flex p-0 " style="border-bottom: 1px solid #ddd; margin:5px; padding:5px; padding-bottom: 10px;">
                  <h3 class="card-title p-3">@lang('site.permissions')</h3>
                    @php
                        $models = ['users', 'products', 'categories','orders'];
                        $permissions = ['create','read','update','delete'];
                    @endphp

                    <ul class="nav nav-pills ml-auto p-2">
                        @foreach ($models as $index=>$model)
                            <li class="nav-item {{$index == 0 ? 'active': ''}}"><a class="nav-link active" href="#{{$model}}" data-toggle="tab">@lang('site.'.$model)</a></li>
                        @endforeach
                    </ul>

                </div><!-- /.card-header -->

                <div class="card-body">
                  <div class="tab-content">
                    @foreach ($models as $index=>$model)
                        <div class="tab-pane {{$index == 0 ? 'active': ''}}" id="{{$model}}">

                            @foreach ($permissions as $permission)
                            <label><input type="checkbox" name="permissions[]" value="{{$model}}-{{$permission}}">@lang('site.'.$permission)</label>
                            @endforeach

                        </div>
                    @endforeach
                  </div>

                  <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
              <!-- ./card -->
                    </div>



                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('site.add')</button>
                    </div>

                </form>

            </div> <!--end of box body-->
        </div>
    </section>



</div>
@endsection
