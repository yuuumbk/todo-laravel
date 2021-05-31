<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use App\Models\Folder;
use App\Models\User;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * 日付データを "Y/m/d H:i:s" 型式に整形する
     *
     * @return void
     */
    public function format_date() {
      $date = $this->due_date;
      $date = new DateTime($date);
      return $date->format('Y/m/d');
    }

    // 状態定義
    public static $status = [
      0 => ['label' => '未着手', 'class' => 'label-danger'],
      1 => ['label' => '着手中', 'class' => 'label-info'],
      2 => ['label' => '完了', 'class' => 'label-success'],
    ];

    /**
     * ステータスラベル
     *
     * @return void
     */
    public function status_label() {
      $status = $this->status;
      return self::$status[$status]['label'];
    }

    public function status_color() {
      $status = $this->status;
      return self::$status[$status]['class'];
    }

    /**
     * リレーション
     */
    // ユーザーテーブル
    public function users() {
      return $this->belongsTo(User::class);
    }

    // フォルダーテーブル
    public function folders() {
      return $this->belongsTo(Folder::class);
    }

    /**
     * タスクパーミッション
     *
     * @param [type] $user_id
     * @param [type] $folder_id
     * @return void
     */
    public static function permission($user_id, $task_id) {
      $permission = self::where('id', $task_id)->where('user_id', $user_id)->exists();
      return $permission;
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'due_date' => 'datetime:Y-m-d',
    ];

}
