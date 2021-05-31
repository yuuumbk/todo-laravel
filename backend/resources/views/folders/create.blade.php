@extends('layouts.form')
@section('action')
    フォルダを作成する
@endsection
@section('form')
    <form action="{{ route('folders.create_form') }}" method="post">
      @csrf
      <div class="form-group">
        <label for="title">フォルダ名</label>
        <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required autofocus /><br>
        <span class="text-danger">
          @error('title')
              {{ $message }}
          @enderror
        </span>
      </div>
      <div class="text-right">
        <button type="submit" class="btn btn-primary">作成</button>
      </div>
    </form>
@endsection