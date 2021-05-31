<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if($this->is('tasks/create/*') || $this->is('tasks/edit/*')) {
          return true;
        }else {
          return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:20',
            'due_date' => 'required|date|after_or_equal:today',
            'status' => 'required|between:0,2',
        ];
    }

    public function messages() {
      return [
        'status.message' => '状態には、未着手、着手中、完了のいずれかを指定してください。',
      ];
    }

    public function attributes()
    {
      return [
        'title' => 'タイトル',
        'due_date' => '期限',
        'status' => '状態',
      ];
    }
}
