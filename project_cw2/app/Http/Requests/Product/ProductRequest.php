<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'content' => 'required',
            'price' => 'required',
            'price_sale' => 'required',
            'thumb' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',




        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên sản phẩm',
            'price.required' => 'Vui lòng nhập giá gốc sản phẩm',
            'price_sale.required' => 'Vui lòng nhập giá gốc sản phẩm',
            'description.required' => 'Vui lòng nhập mô tả sản phẩm',
            'content.required' => 'Vui lòng nhập mô tả chi tiết sản phẩm',
            'thumb.required' => 'Ảnh đại diện không được trống',
            'thumb.image' => 'Hình ảnh không hợp lệ.',
            'thumb.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif.',
            'thumb.max' => 'Hình ảnh không được vượt quá 2MB.',


        ];
    }
}
