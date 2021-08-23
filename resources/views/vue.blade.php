@extends('layouts.app')
@section('content')
<div id="app">
    <app :user="{{ auth()->user() }}" />
</div>
@endsection
@section('script')
<link rel="stylesheet" href="{{ asset('fonts/fontawesome.css') }}">
<link rel="stylesheet" href="{{ asset('fonts/ionicons.css') }}">
<link rel="stylesheet" href="{{ asset('fonts/linearicons.css') }}">
<link rel="stylesheet" href="{{ asset('fonts/open-iconic.css') }}">
<link rel="stylesheet" href="{{ asset('fonts/pe-icon-7-stroke.css') }}">

<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" defer></script>
@endsection