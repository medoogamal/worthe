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

                <form action="{{route('categories.store')}}" method="POST">
                    @csrf
                    @method('post')
                    <div class="form-group">
                        <label for="">@lang('site.name')</label>
                        <input type="text" class="form-control" name="name" value="{{old('name')}}">
                    </div>


        <div class="form-group">

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('site.add')</button>
                    </div>

                </form>

            </div> <!--end of box body-->
        </div>
    </section>



</div>
@endsection
