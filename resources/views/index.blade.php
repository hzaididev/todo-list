@extends('layout')

@section('content')

    <div class="container">
        <div class="p-2"><a href="{{ route('todos.create') }}" title="Add New Task"><i class="fa fa-plus-circle fa-2x"></i></a></div>
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        @if (count($tasks))
        <table class="table">
            <thead>
            <tr class="table-primary">
                <td># ID</td>
                <td>Name</td>
                <td>Status</td>
                <td>Completed At</td>
                <td>Created At</td>
                <td class="text-center">Action</td>
            </tr>
            </thead>
            <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td>{{$task->id}}</td>
                    <td>{{$task->name}}</td>
                    <td>@if($task->status) Completed @endif</td>
                    <td>@if($task->completed_at) {{ $task->completed_at->toFormattedDateString() }} @endif</td>
                    <td>{{ $task->created_at->toFormattedDateString() }}</td>
                    <td class="text-center">
                        <a href="{{ route('todos.edit', $task->id)}}" class="btn btn-success btn-sm">Edit</a>
                        <form action="{{ route('todos.destroy', $task->id)}}" method="post" style="display: inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @else
            <center>No Records Found...</center>
        @endif
        <div>
@endsection