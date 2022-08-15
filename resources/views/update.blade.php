@extends('layout')

@section('content')


    <div class="card mt-5">
        <div class="card-header">
            Update Task
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
            <form method="post" action="{{ route('todos.update', $task->id) }}">
                <div class="form-group">
                    @csrf
                    @method('PATCH')
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" value="{{ $task->name }}" />
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <input type="checkbox" name="status" value="{{ $task->status }}" @if($task->status) checked @endif/>
                </div>

                <button type="submit" class="btn btn-block btn-danger">Update</button>
            </form>
        </div>
    </div>
@endsection