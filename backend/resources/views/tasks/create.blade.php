@extends('layouts.form')
@section('action')
    タスクを作成する
@endsection
@section('form')
    <form action="{{ route('tasks.create_form', ['folder_id' => $folder_id]) }}" method="POST">
      @csrf
      <div class="form-group">
        <label for="title">タイトル</label>
        <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required autofocus max="20">
      </div>
      <div class="form-group">
        <label>状態</label><br>
        <div class="radio-inline">
          <label><input type="radio" name="status" id="status" value="0" required {{ old('status') != null ? (old('status') == 0 ? 'checked' : '') : 'checked' }}>未着手</label>
        </div>
        <div class="radio-inline">
          <label><input type="radio" name="status" id="status" value="1" {{ old('status') != null ? (old('status') == 1 ? 'checked' : '') : '' }}>着手中</label>
        </div>
        <div class="radio-inline">
          <label><input type="radio" name="status" id="status" value="2" {{ old('status') != null ? (old('status') == 2 ? 'checked' : '') : '' }}>完了</label>
        </div>
      </div>
      <div class="form-group">
        <label for="due_date">期限日</label>
        <input type="text" class="form-control" name="due_date" id="due_date" value="{{ old('due_date') }}" required>
      </div>
      <div class="text-right">
        <button type="submit" class="btn btn-primary">作成</button>
      </div>
    </form>
@endsection