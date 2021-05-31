<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateFolderRequest;
use App\Models\Folder;
use CreateFoldersTable;
use Illuminate\Http\Request;

class FolderController extends Controller {
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index() {
    //
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(CreateFolderRequest $request) {
    // ユーザーID
    $user_id = Auth::user()->id;

    // 同名のフォルダがフォルダに存在する場合エラーを返す
    $has_same_title_folders = Folder::where('user_id', $user_id)->where('title', $request->title)->exists();
    if ($has_same_title_folders) {
      $request->session()->put('folder_error', '同名のフォルダが存在します。');
      return redirect()->route('tasks.index');
    }

    $folder = new Folder();
    $folder->user_id = $user_id;
    $folder->title = $request->title;
    $folder->save();
    return redirect()->route('tasks.index', ['id' => $folder->id]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request) {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Folder  $folder
   * @return \Illuminate\Http\Response
   */
  public function show(Folder $folder) {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Folder  $folder
   * @return \Illuminate\Http\Response
   */
  public function edit(CreateFolderRequest $request,Folder $folder, $folder_id) {
    // ユーザーID
    $user_id = Auth::user()->id;

    /**
     * フォルダの権限がない場合エラー
     */

    $permission = Folder::permission($user_id, $folder_id);
    if (!$permission) {
      $request->session()->put('task_error', 'フォルダが不正です。');
      return redirect()->route('tasks.index', ['task_id' => $folder_id]);
    }

    // フォルダを編集
    $folder = Folder::where('id', $folder_id)->first();
    $folder->title = $request->title;
    $folder->update();

    return redirect()->route('tasks.index', ['id' => $folder_id]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Folder  $folder
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Folder $folder) {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Folder  $folder
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request, $folder_id) {
    // ユーザーID
    $user_id = Auth::user()->id;

    /**
     * フォルダの権限がない場合エラー
     */

    $permission = Folder::permission($user_id, $folder_id);
    if (!$permission) {
      $request->session()->put('task_error', 'フォルダが不正です。');
      return redirect()->route('tasks.index', ['task_id' => $folder_id]);
    }

    // フォルダを削除
    Folder::where('id', $folder_id)->delete();
    return redirect()->route('tasks.index');
  }

  public function display_create_form(Request $request) {
    return view('folders.create');
  }

  public function display_edit_form(Request $request, $folder_id) {
    // ユーザーID
    $user_id = Auth::user()->id;

    /**
     * フォルダの権限がない場合エラー
     */

    $permission = Folder::permission($user_id, $folder_id);
    if (!$permission) {
      $request->session()->put('folder_error', 'フォルダが不正です。');
      return redirect()->route('tasks.index', ['folder_id' => $folder_id]);
    }

    $folder = Folder::where('id', $folder_id)->first();
    $title = $folder->title;

    return view('folders.edit', ['folder_id' => $folder_id, 'title' => $title]);
  }

  /**
   * Display the Folder deletion screen.
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function display_delete_form(Request $request, $folder_id) {
    // ユーザーID
    $user_id = Auth::user()->id;

    /**
     * フォルダの権限がない場合エラー
     */

    $permission = Folder::permission($user_id, $folder_id);
    if (!$permission) {
      $request->session()->put('folder_error', 'フォルダが不正です。');
      return redirect()->route('tasks.index', ['folder_id' => $folder_id]);
    }

    $folder = Folder::where('id', $folder_id)->first();
    $title = $folder->title;

    return view('folders.delete', ['folder_id' => $folder_id, 'title' => $title]);
  }
}
