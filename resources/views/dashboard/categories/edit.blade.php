@extends('layouts.dashboard.app')

@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <h1>
            @lang('site.categories')
        </h1>

        <ol class="breadcrumb">
            <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard">@lang('site.dashboard')</i></a></li>
            <li><a href="{{route('categories.index')}}">@lang('site.categories')</a></li>
            <li class="active">@lang('site.edit')</i></li>
        </ol>

    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <div class="box-title">@lang('site.edit')</div>
            </div>
            <div class="box-body">
                @include('partials._errors')

                <form action="{{route('categories.update',$category->id)}}" method="post">
                    @csrf
                    {{method_field('put')}}
                    <div class="form-group">
                        <label for="">@lang('site.name')</label>
                        <input type="text" class="form-control" name="name" value="{{$category->name}}">
                    </div>

                    <div class="form-group">
            <!-- Custom Tabs -->
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i>@lang('site.edit')</button>
                    </div>

                </form>

            </div> <!--end of box body-->
        </div>
    </section>



</div>
@endsection
