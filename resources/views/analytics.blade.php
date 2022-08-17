@extends('layout')

@section('content')

    <div class="container">
        <div class="card mt-5">
            <div class="card-header">
                Search Tasks
            </div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="get" action="{{ route('todos.analytics') }}">
                    <div class="form-group">
                        <label for="start">Start Date</label>
                        <input type="date" class="form-control" name="start" value="{{$startDate}}" />
                    </div>
                    <div class="form-group">
                        <label for="end">End Date</label>
                        <input type="date" class="form-control" name="end" value="{{$endDate}}" />
                    </div>
                    <div class="form-group">
                        <label for="field">Search Date</label>
                        <select class="form-control" name="field">
                            <option value="created" @if($field == 'created') {{ 'selected' }} @endif>Created</option>
                            <option value="completed" @if($field == 'completed') {{'selected'}} @endif>Completed</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-block btn-danger">Search</button>
                </form>
            </div>
        </div>
        <div class="card mt-5">
            <div class="card-header">
                Analytics
            </div>

            <div class="card-body">
                <p>
                    Total : {{$tasksCount}}
                </p>
                <p>
                    Completed : {{$tasksCompleted}}
                </p>
            </div>
        </div>
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        <br>
        @if (count($tasks))
        <table class="table">
            <thead>
            <tr class="table-primary">
                <td># ID</td>
                <td>Name</td>
                <td>Status</td>
                <td>Completed At</td>
                <td>Created At</td>
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
                </tr>
            @endforeach
            </tbody>
        </table>
        @else
            <center>No Records Found...</center>
        @endif
        <div>
@endsection