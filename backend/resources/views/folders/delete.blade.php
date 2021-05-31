@extends('layouts.form')
@section('action')
    フォルダを削除する
@endsection
@section('form')
    <form action="{{ route('folders.delete_form', ['folder_id' => $folder_id]) }}" method="POST">
      @csrf
      <div class="form-group">
        <label for="title">タイトル</label>
        <div>{{$title}}</div>
      </div>
      <div class="text-right">
        <button type="submit" class="btn btn-danger">削除</button>
      </div>
    </form>
@endsection