<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewPostRequest extends FormRequest
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
            'title'        => ['required', 'min:10', new \App\Rules\ValidPostTitle],
            'content'      => 'required|min:25',
            'published'    => 'boolean',
            'post_type'    => 'required|numeric',
            'categories'   => 'required|array',
            'tags'         => 'nullable|array',
            'thumbnail_id' => 'required|numeric|exists:files,id',
        ];
    }

    /**
     * @return mixed
     */
    public function validationData()
    {
        $array = $this->all();

        return $array;
    }

    public function attributes()
    {
        return [
            'title'        => 'عنوان پست',
            'content'      => 'متن پست',
            'published'    => 'قابلیت دید',
            'post_type'    => 'نوع پست',
            'categories'   => 'دسته بندی‌ها',
            'tags'         => 'تگ‌ها',
            'thumbnail_id' => 'تصویر شاخص',
        ];
    }

    /**
     * @return mixed
     */
    public function validated()
    {
        return $this->all() + ['slug' => str_slug($this->all()['title'])] + ['user_id' => auth()->id()];
    }

    public function messages()
    {
        return [
            'thumbnail_id.exists' => ':attribute ارسالی نامعتبر است.',
        ];
    }
}
