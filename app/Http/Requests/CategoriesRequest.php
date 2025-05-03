<?php

namespace App\Http\Requests;

use App\Rules\Filter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class CategoriesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $id=$this->route('category');
        return [
            'name'=>['required','string','max:255','min:3',new Filter(['laravel','html','oop','css']),Rule::unique('categories','name')->ignore($id)],

            'department_id'=>['nullable','integer',Rule::exists('departments','id')],
            'image'=>['image','max:5242880','dimensions:min_width=100,min_height=100'],
            'status'=>'in:active,archived',
        ];
    }
    // public function messages()
    // {
    //     return[
    //         'required'=>'the :attribute is required',
    //         //'name.required'=>'the :attribute is required', if i want select input
    //     ];
    // }
}
