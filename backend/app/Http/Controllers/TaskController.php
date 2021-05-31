<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Folder;
use App\Models\Task;
use Illuminate\Http\Request;
use Symfony\Component\VarDumper\VarDumper;

class TaskController extends Controller {
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request, $folder_id = 0) {
    // ユーザーID
    $user_id = Auth::user()->id;
    // 現在のページ数
    $page = $request->page ?? 1;

    if($folders = Folder::where('user_id', $user_id)->exists()){
      // フォルダの操作権限があるかどうか
      $folder_permission = Folder::where('user_id', $user_id)->where('id', $folder_id)->exists();

      /**
       * フォルダIDが指定されていない、またはフォルダの権限がない場合再リダイレクト
       */
      if (empty($folder_id) || !$folder_permission) {
        // フォルダーIDが指定されていない際は一番最初のIDを、
        // フォルダー自体が作成されていない場合は0を
        $folder_id = Folder::where('user_id', $user_id)->first()->id ?? 0;
        return redirect()->route('tasks.index', ['folder_id' => $folder_id, 'page' => $page]);
      }
    }

    /**
     * フォルダーを取得
     */

    // フォルダーを10件ごとに取得
    $folders = Folder::where('user_id', $user_id)->paginate(10);

    /**
     * フォルダー数
     */
    $folders_array = $folders->toArray();
    $total_folder = $folders_array['total'];

		// per_page
		$per_page = $folders_array['per_page'] ?? 0;

    if ($total_folder > 0) { // フォルダが存在する;
      /**
       * タスクを取得
       */
      // ソート
      $sort = $request->sort;
			$sort_list = [];
			if(is_numeric($sort) && !is_float($sort) && is_int((int)$sort)){
				if ($sort < 0 || $sort > 7) {
					$sort = 2;
				}
			} else {
				$sort = 2;
			}
			/**
			 * ソート優先度
			 * 状態→期限日→タイトル
			 */
			// 状態
			if (($sort >> 1) & 0b001) {
				$sort_list['status'] = 1;
			}
			// 期限日
			if ($sort & 0b001) {
				$sort_list['due_date'] = 1;
			}
			// タイトル
			if (($sort >> 2) & 0b001) {
				$sort_list['title'] = 1;
			}

			$tasks = Task::where('user_id', $user_id)->where('folder_id', $folder_id);

			foreach($sort_list as $key => $value){
				$tasks = $tasks->orderBy($key);
			}

			$tasks = $tasks->get();
      // タスクの数を数える
      $total_task = count($tasks->toArray());

			// ぺじネーション
			$folders->appends(['sort' => $sort]);

      $params = [
				'tasks' => $tasks,
				'sort' => $sort,
			];
    } else { // フォルダが存在しない=タスクは表示しない
      $total_task = 0;
			$params = [];
    }

    // エラー文
    unset($params['errors']);
    if ($request->session()->has('folder_error')) {
      $params['errors']['folder'] = $request->session()->pull('folder_error');
    }

    if ($request->session()->has('task_error')) {
      $params['errors']['task'] = $request->session()->pull('task_error');
    }

		// ビューに渡す値（共通）
		$params += [
			'folders' => $folders,
			'id' => $folder_id,
			'page' => $page,
			'per_page' => $per_page,
			'total_folder' => $total_folder,
			'total_task' => $total_task,
		];

    return view('tasks.index', $params);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(CreateTaskRequest $request, $folder_id) {
    $user_id = Auth::user()->id;

    /**
     * フォルダの権限がない場合エラー
     */

    $permission = Folder::permission($user_id, $folder_id);

    if (!$permission) {
      $request->session()->put('task_error', 'フォルダが不正です。');
      return redirect()->route('tasks.index', ['folder_id' => $folder_id]);
    }

    /**
     * 同名のタスクがフォルダに存在する場合エラーを返す
     */

    $has_same_title_tasks = Task::where('folder_id', $folder_id)->where('title', $request->title)->exists();
    if ($has_same_title_tasks) {
      $request->session()->put('task_error', '同名のタスクがフォルダに存在します。');
      return redirect()->route('tasks.index');
    }
    // タスクを登録
    $task = new Task();
    $task->user_id = $user_id;
    $task->folder_id = $folder_id;
    $task->title = $request->title;
    $task->status = $request->status;
    $task->due_date = $request->due_date;
    $task->save();

    return redirect()->route('tasks.index', ['id' => $task->folder_id]);
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
   * @param  \App\Models\Task  $task
   * @return \Illuminate\Http\Response
   */
  public function show(Task $task) {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Task  $task
   * @return \Illuminate\Http\Response
   */
  public function edit(CreateTaskRequest $request, Task $task, $task_id) {
    // ユーザーID
    $user_id = Auth::user()->id;

    /**
     * タスクの権限がない場合エラー
     */

    $permission = Task::permission($user_id, $task_id);
    if (!$permission) {
      $request->session()->put('task_error', 'タスクが不正です。');
      return redirect()->route('tasks.index', ['task_id' => $task_id]);
    }

    // タスクを編集
    $task = Task::where('id', $task_id)->first();
    $task->title = $request->title;
    $task->status = $request->status;
    $task->due_date = $request->due_date;
    $task->update();

    return redirect()->route('tasks.index', ['id' => $task->folder_id]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Task  $task
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Task $task) {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Task  $task
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request, $task_id) {
		// ユーザーID
		$user_id = Auth::user()->id;

		/**
		 * タスクの権限がない場合エラー
		 */

		$permission = Task::permission($user_id, $task_id);
		if (!$permission) {
			$request->session()->put('task_error', 'タスクが不正です。');
			return redirect()->route('tasks.index', ['task_id' => $task_id]);
		}

    // タスクを削除
    Task::where('id', $task_id)->delete();
    return redirect()->route('tasks.index');
  }

  /**
   * Display the task create form.
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function display_create_form(Request $request, $folder_id) {
    return view('tasks.create', ['folder_id' => $folder_id]);
  }

  /**
   * Display the task edit form.
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function display_edit_form(Request $request, $task_id) {
    // ユーザーID
    $user_id = Auth::user()->id;

    /**
     * タスクの権限がない場合エラー
     */

    $permission = Task::permission($user_id, $task_id);
    if (!$permission) {
      $request->session()->put('task_error', 'タスクが不正です。');
      return redirect()->route('tasks.index', ['task_id' => $task_id]);
    }

    $task = Task::where('id', $task_id)->first();
    $title = $task->title;
    $status = $task->status;
    $due_date = $task->due_date;

    return view('tasks.edit', ['task_id' => $task_id, 'title' => $title, 'status' => $status, 'due_date' => $due_date]);
  }

  /**
   * Display the task deletion screen.
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function display_delete_form(Request $request, $task_id) {
    // ユーザーID
    $user_id = Auth::user()->id;

    /**
     * タスクの権限がない場合エラー
     */

    $permission = Task::permission($user_id, $task_id);
    if (!$permission) {
      $request->session()->put('task_error', 'タスクが不正です。');
      return redirect()->route('tasks.index', ['task_id' => $task_id]);
    }

    $task = Task::where('id', $task_id)->first();
    $title = $task->title;
    $status = Task::$status[$task->status]['label'];
    $due_date = $task->due_date;

    return view('tasks.delete', ['task_id' => $task_id, 'title' => $title, 'status' => $status, 'due_date' => $due_date]);
  }
}
