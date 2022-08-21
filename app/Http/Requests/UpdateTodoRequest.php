<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class UpdateTodoRequest extends JsonRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'is_done' => ['boolean', 'required']
        ];
    }
}
