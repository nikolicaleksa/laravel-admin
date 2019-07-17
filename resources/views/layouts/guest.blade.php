@extends('layouts.app')

@prepend('css')
    <link href="{{ asset('css/guest-app.css') }}" rel="stylesheet">
@endprepend

@prepend('js')
    <script src="{{ asset('js/guest-app.js') }}"></script>
@endprepend