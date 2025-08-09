Hello I am finally working!!

<div>
    Task List
</div>

<div>
    <!-- @if(count($tasks))
        @foreach ($tasks as $task)
            <div>{{ $task->title }}</div>
        @endforeach
    @else
        <div>There're no tasks!</div>
    @endif -->

    @forelse($tasks as $task)
        <a href="{{ route('tasks.show', ['id' => $task->id]) }}">{{ $task->title }}</a>
    @empty
        <div>There're no tasks</div>
    @endforelse
</div>