@extends('base')

@section('title', 'Ошибка')

@section('content')
    <div class="container">
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>
    </div>
@endsection
