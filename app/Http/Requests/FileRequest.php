<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileRequest extends FormRequest
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
            'file'     => 'required|file|mimes:png,jpg,jpeg,svg,zip,pdf,rar|max:4096',
            'title'    => 'required|regex:/^[^\_\:\#\$]+$/i|min:5',
            'desc'     => 'nullable|regex:/^[^\_\:\#\$]+$/i|min:5',
            'name'     => 'required|regex:/^[\w\d\_\-\.\(\)]+\.[\w]{2,}$/i',
            'keywords' => 'nullable|array',
        ];
    }

    public function validated()
    {
        return array_filter($this->all(), function ($key) {
            if ($key == 'file') {
                return false;
            }

            return true;
        }, ARRAY_FILTER_USE_KEY);
    }

    public function attributes()
    {
        return [
            'title'    => 'عنوان تصویر',
            'file'     => 'فایل',
            'desc'     => 'توضیحات',
            'name'     => 'عنوان اصلی فایل',
            'keywords' => 'کلید واژه‌ها',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'فیلد :attribute وارد نشده است.',
            'regex'    => ':attribute حاوی کاراکترهای غیرمجاز است.',
            'min'      => 'تعداد کاراکتر وارد شده برای :attribute کافی نیست.',
            'mimes'    => 'فرمت تصویر ارسال شده برای :attribute صحیح نیست.',
            'array'    => 'ساختار ارسالی باری :attribute ناصحیح است.',
        ];
    }
}
