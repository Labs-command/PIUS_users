@php use Ramsey\Uuid\Uuid; @endphp
@extends('base')

@section('title', 'Создание задачи')

@section('content')
    <div class="container">
        <h1>Создание задачи</h1>
        <form action="{{ route('users.tasks.create') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="subject" class="form-label">Тема задачи:</label>
                <input type="text" class="form-control" id="subject" name="subject" required>
            </div>
            <div class="mb-3">
                <label for="text" class="form-label">Содержание задачи:</label>
                <textarea class="form-control" id="text" name="text" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="answer" class="form-label">Развернутый ответ на задачу:</label>
                <textarea class="form-control" id="answer" name="answer" rows="3" required></textarea>
            </div>
            <input type="hidden" name="author_id" id="author_id" value="{{ Uuid::uuid4()->toString() }}">
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="createAnother" name="createAnother">
                <label class="form-check-label" for="createAnother">Создать ещё</label>
            </div>
            <button type="submit" class="btn btn-primary">Создать задачу</button>
        </form>
    </div>
@endsection
