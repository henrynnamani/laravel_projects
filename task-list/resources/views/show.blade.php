@extends('layouts.app')

@section('title', $task->title)

@section('content')
    <p>{{ $task->description }}</p>

    @if($task->long_description)
        {{ $task->long_description }}
    @endif

    <p>{{ $task->created_at }}</p>
    <p>{{ $task->updated_at }}</p>

    <div>
        <form method="post" action="{{ route('tasks.destroy', [
        'task' => $task->id
    ]) }}">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
        </form>
    </div>
@endsection