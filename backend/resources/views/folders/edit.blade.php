@extends('layouts.form')
@section('action')
    フォルダを編集する
@endsection
@section('form')
    <form action="{{ route('folders.edit_form', ['folder_id' => $folder_id]) }}" method="POST">
      @csrf
      <div class="form-group">
        <label for="title">タイトル</label>
        <input type="text" class="form-control" name="title" id="title" value="{{ old('title', $title) }}" required max="20">
      </div>
      <div class="text-right">
        <button type="submit" class="btn btn-primary">編集</button>
      </div>
    </form>
@endsection