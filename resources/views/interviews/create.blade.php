@extends('layouts.app')

@section('title', 'New Interview')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-gray-800">New Interview</h1>
</div>

<form action="{{ route('interviews.store') }}" method="POST">
    @csrf
    @include('interviews.partials.form')
</form>
@endsection
