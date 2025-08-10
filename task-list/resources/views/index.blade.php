@extends('layouts.app')

@section('title', 'The List of Tasks')

@section('content')
    @forelse($tasks as $task)
        <a href="{{ route('tasks.show', ['id' => $task->id]) }}">{{ $task->title }}</a>
    @empty
        <div>There're no tasks</div>
    @endforelse
@endsection