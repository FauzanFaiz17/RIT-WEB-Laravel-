@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $project->name }}</h2>
    <p>{{ $project->description }}</p>

    <hr>

    <h4>Task</h4>

    @forelse($project->tasks as $task)
        <div class="card mb-3">
            <div class="card-body">
                <h5>{{ $task->title }}</h5>
                <p>{{ $task->description }}</p>

                <p>
                    <strong>Periode:</strong> 
                    {{ $task->start_date }} - {{ $task->end_date }}
                </p>

                <p><strong>Progress:</strong> {{ $task->progress }}%</p>

                <p><strong>Anggota yang mengerjakan:</strong></p>
                <ul>
                    @forelse($task->users as $user)
                        <li>{{ $user->name }}</li>
                    @empty
                        <li><i>Belum ada yang ditugaskan</i></li>
                    @endforelse
                </ul>

                {{-- Subtask --}}
                @if ($task->subtasks->count())
                    <h6>Subtask:</h6>
                    <ul class="list-group">
                        @foreach ($task->subtasks as $sub)
                            <li class="list-group-item">
                                <strong>{{ $sub->title }}</strong><br>
                                {{ $sub->description }}<br>

                                <small>
                                    {{ $sub->start_date }} - {{ $sub->end_date }}
                                    | Progress: {{ $sub->progress }}%
                                </small>
                            </li>
                        @endforeach
                    </ul>
                @endif

            </div>
        </div>

    @empty
        <p>Belum ada task.</p>
    @endforelse

</div>
@endsection
