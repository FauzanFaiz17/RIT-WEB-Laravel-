@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Project</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Project</th>
                <th>Deskripsi</th>
                <th>Periode</th>
                <th>Jumlah Task</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->description }}</td>
                    <td>
                        {{ $project->start_date }} - {{ $project->end_date }}
                    </td>
                    <td>{{ $project->tasks_count }}</td>
                    <td>
                        <a href="{{ route('projects.show', $project->id) }}" class="btn btn-primary btn-sm">
                            Lihat Detail
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
