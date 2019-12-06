@extends('layouts.app')

@prepend('css')
    <link href="{{ asset('css/admin-app.css') }}" rel="stylesheet">
@endprepend

@section('header')
    @include('layouts.header')
@endsection

@section('nav')
    @include('layouts.nav')
@endsection

@prepend('js')
    <script>
        window.CKEDITOR_BASEPATH = '/ckeditor/';
    </script>
    <script src="{{ asset('js/admin-app.js') }}"></script>
@endprepend
