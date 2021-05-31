@extends('layouts.app')
@section('content')
  <div class="container-fluid">
    @foreach ($errors as $error)
      <div class="alert alert-danger">{{ $error }}</div>
    @endforeach
    <div class="row">
      <div class="col col-md-4 my-col-4-left">
        <nav class="panel panel-default">
          <div class="panel-heading">
            フォルダ
          </div>
          <div class="panel-body">
            <a href="{{ route('folders.create_form') }}" class="btn btn-default btn-block">
              フォルダを作成する
            </a>
          </div>
          @if ($total_folder)
            <table class="list-group folder-table">
              @foreach($folders as $folder)
                <tr class="list-group-item row" style="{{$id == $folder->id ? 'background-color: #f2f2f2;' : ''}}">
                  <td class="col col-md-8"><a href="{{ route('tasks.index', ['folder_id' => $folder->id, 'page' => $page]) }}" class="folder-title">{{ $folder->title }}</a></td>
                  <td class="col col-md-2"><a href="{{ route('folders.edit_form', ['folder_id' => $folder->id]) }}" class="folder-edit">編集</a></td>
                  <td class="col col-md-2"><a href="{{ route('folders.delete_form', ['folder_id' => $folder->id]) }}" class="folder-delete text-danger">削除</a></td>
                </tr>
              @endforeach
            </table>
          @endif
        </nav>
        @if ($total_folder > 10 && $per_page * $page - $total_folder > 0)
          @for ($i = 0; $i < $per_page * $page - $total_folder; $i++)
            <div class="over-list"></div>
          @endfor
        @endif
        {{$folders->links('vendor.pagination.default')}}
      </div>
      <div class="column col-md-8 my-col-8-right">
        <div class="panel panel-default">
          <div class="panel-heading">
            タスク
          </div>
          <div class="panel-body">
            <div class="text-right">
              <a href="{{ route('tasks.create_form', ['folder_id' => $id]) }}" class="btn btn-default btn-block">
                タスクを作成する
              </a>
            </div>
          </div>
            @if ($total_task)
              <table class="table">
                <thead>
                  <tr>
                    <th><a href="{{ route('tasks.index', ['sort' => $sort ^ 0b100, 'page' => $page, 'folder_id' => $id]) }}" style="{{$sort & 0b100 ? 'color: rgb(55, 26, 139);' : '' }}">タイトル</th>
                    <th><a href="{{ route('tasks.index', ['sort' => $sort ^ 0b010, 'page' => $page, 'folder_id' => $id]) }}" style="{{$sort & 0b010 ? 'color: rgb(55, 26, 139);' : '' }}">状態</th>
                    <th><a href="{{ route('tasks.index', ['sort' => $sort ^ 0b001, 'page' => $page, 'folder_id' => $id]) }}" style="{{$sort & 0b001 ? 'color: rgb(55, 26, 139);' : '' }}">期限日</th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($tasks as $task)
                    <tr>
                      <td>{{ $task->title }}</td>
                      <td>
                        <span class="label text-center {{ $task->status_color() }}">{{ $task->status_label() }}</span>
                      </td>
                      <td>{{ $task->format_date() }}</td>
                      <td><a href="{{ route('tasks.edit_form', ['task_id' => $task->id]) }}">編集</a></td>
                      <td><a href="{{ route('tasks.delete_form', ['task_id' => $task->id]) }}" class="text-danger">削除</a></td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            @else
            @endif
        </div>
      </div>
    </div>
  </div>
@endsection