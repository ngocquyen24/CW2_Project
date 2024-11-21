<?php

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;

class CreateFormRequest extends FormRequest
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
            'name' => 'required',
            'description' => 'required',
            
            'thumb' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages() : array
    {
        return [
            'name.required' => 'Vui lòng nhập tên Danh Mục',
            'description.required' => 'Vui lòng nhập tên Danh Mục',
            'thumb.required' => 'Ảnh đại diện không được trống',
            'thumb.image' => 'Hình ảnh không hợp lệ.',
            'thumb.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif.',
            'thumb.max' => 'Hình ảnh không được vượt quá 2MB.',
        ];
    }
}
