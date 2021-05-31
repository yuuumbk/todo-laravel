<?php

use App\Http\Controllers\FolderController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * ログイン認証機能
 */
Auth::routes();

Route::get('/', function () {
  return redirect('home');
});

Route::middleware(['auth'])->group(function () {
  Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
  /**
   * タスク一覧（ホーム）
   */
  Route::get('/folders/tasks/{folder_id?}', [TaskController::class, 'index'])
    ->name('tasks.index');
  /**
   * タスク作成
   */
  Route::get('/tasks/create/{folder_id}', [TaskController::class, 'display_create_form'])
    ->name('tasks.create_form');
  Route::post('/tasks/create/{folder_id}', [TaskController::class, 'create']);
  /**
   * タスク編集
   */
  Route::get('/tasks/edit/{task_id}', [TaskController::class, 'display_edit_form'])
    ->name('tasks.edit_form');
  Route::post('/tasks/edit/{task_id}', [TaskController::class, 'edit']);
  /**
   * タスク削除
   */
  Route::get('/tasks/delete/{task_id}', [TaskController::class, 'display_delete_form'])
    ->name('tasks.delete_form');
  Route::post('/tasks/delete/{task_id}', [TaskController::class, 'destroy']);

  /**
   * フォルダ作成
   */
  Route::get('/folders/create', [FolderController::class, 'display_create_form'])
  ->name('folders.create_form');
  Route::post('/folders/create', [FolderController::class, 'create']);
  /**
   * フォルダ編集
   */
  Route::get('/folders/edit/{folder_id}', [FolderController::class, 'display_edit_form'])
  ->name('folders.edit_form');
  Route::post('/folders/edit/{folder_id}', [FolderController::class, 'edit']);
  /**
   * フォルダ削除
   */
  Route::get('/folders/delete/{folder_id}', [FolderController::class, 'display_delete_form'])
  ->name('folders.delete_form');
  Route::post('/folders/delete/{folder_id}', [FolderController::class, 'destroy']);
});
