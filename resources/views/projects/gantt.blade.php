@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Gantt Chart: {{ $project->name }}</h2>
    <hr>

    <div id="gantt"></div>
</div>

{{-- Import Frappe Gantt --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/frappe-gantt/0.6.1/frappe-gantt.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/frappe-gantt/0.6.1/frappe-gantt.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        
        let tasks = [
            @foreach($tasks as $task)
                {
                    id: "task-{{ $task->id }}",
                    name: "{{ $task->title }}",
                    start: "{{ $task->start_date }}",
                    end: "{{ $task->end_date }}",
                    progress: {{ $task->progress }},
                },
                @foreach($task->subtasks as $sub)
                    {
                        id: "subtask-{{ $sub->id }}",
                        name: "— {{ $sub->title }}",
                        start: "{{ $sub->start_date }}",
                        end: "{{ $sub->end_date }}",
                        progress: {{ $sub->progress }},
                    },
                @endforeach
            @endforeach
        ];

        new Gantt("#gantt", tasks, {
            view_mode: "Day",
            date_format: "YYYY-MM-DD",
            custom_popup_html: function(task) {
                return `
                    <div class="details-container">
                        <h5>${task.name}</h5>
                        <p>Start: ${task._start.format('YYYY-MM-DD')}</p>
                        <p>End: ${task._end.format('YYYY-MM-DD')}</p>
                        <p>Progress: ${task.progress}%</p>
                    </div>
                `;
            }
        });

    });
</script>

@endsection
