@extends('layouts.app')

@section('title', 'Dashboard User')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>
    <p>Selamat datang, {{ Auth::guard('user')->user()->name }}!</p>

    <form method="POST" action="{{ route('user.logout') }}">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>
@endsection
