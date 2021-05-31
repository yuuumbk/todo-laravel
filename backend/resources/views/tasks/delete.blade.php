@extends('layouts.form')
@section('action')
    タスクを削除する
@endsection
@section('form')
    <form action="{{ route('tasks.delete_form', ['task_id' => $task_id]) }}" method="POST">
      @csrf
      <div class="form-group">
        <label for="title">タイトル</label>
        <div>{{$title}}</div>
      </div>
      <div class="form-group">
        <label>状態</label><br>
        <div>{{$status}}</div>
      </div>
      <div class="form-group">
        <label for="due_date">期限日</label>
        <div>{{$due_date}}</div>
      </div>
      <div class="text-right">
        <button type="submit" class="btn btn-danger">削除</button>
      </div>
    </form>
@endsection