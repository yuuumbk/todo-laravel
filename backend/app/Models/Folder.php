<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;

    /**
     * リレーション
     */
    // ユーザーテーブル
    public function users() {
      return $this->belongsTo(User::class);
    }

    /**
     * フォルダパーミッション
     *
     * @param [type] $user_id
     * @param [type] $task_id
     * @return void
     */
    public static function permission($user_id, $folder_id) {
      $permission = self::where('id', $folder_id)->where('user_id', $user_id)->exists();
      return $permission;
    }

}
