@extends('adminlte::page')

@section('title', 'Alterar Cargo')

@section('content_header')
    <h1 class="m-0 text-dark">Alterar Cargo</h1>
@stop

@section('content')
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('roles.update', $role->id) }}" class="form" method="POST">
                        @csrf
                        @method('PUT')
                        @include('admin.pages.roles._partials.form')
                    </form>
                </div>
                <!--card-body-->
            </div>
            <!--card-->
        </div>

    @endsection