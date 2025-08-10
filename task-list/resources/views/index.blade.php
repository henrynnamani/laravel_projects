@extends('layouts.app')

@section('title', 'The List of Tasks')

@section('content')
    @forelse($tasks as $task)
        <p>
            <a href="{{ route('tasks.show', ['task' => $task->id]) }}">{{ $task->title }}</a>
        </p>
    @empty
        <div>There're no tasks</div>
    @endforelse

    @if($tasks->count())
        <div>
            {{ $tasks->links() }}
        </div>
    @endif
@endsection