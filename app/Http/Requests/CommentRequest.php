<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => ['required', 'min:5', 'max:30', new \App\Rules\validAlpha],
            'body'      => ['required', 'min:10', 'max:500',new \App\Rules\validString],
            'email'     => 'nullable|email',
            'post_id'   => 'required|exists:posts,id|numeric',
            'parent_id' => 'nullable|numeric|exists:comments,id',
            'verified'  => 'nullable|numeric',
        ];
    }

    /**
     * @return mixed
     */
    public function validated()
    {
        return $this->all() + ['ip' => $this->ip()];
    }

    public function attributes()
    {
        return [
            'name'      => 'نام کاربر',
            'body'      => 'متن دیدگاه',
            'email'     => 'ایمیل کاربر',
            'post_id'   => 'پست',
            'parent_id' => 'دیدگاه پاسخ داده شده',
            'verified'  => 'تائیدیه',
        ];
    }

    public function messages()
    {
        return [
            //
        ];
    }
}
