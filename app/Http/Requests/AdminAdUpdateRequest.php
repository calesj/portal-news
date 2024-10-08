<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminAdUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'home_top_bar_ad' => ['nullable', 'image', 'max:3000'],
            'home_middle_ad' => ['nullable', 'image', 'max:3000'],
            'view_page_ad' => ['nullable', 'image', 'max:3000'],
            'news_page_ad' => ['nullable', 'image', 'max:3000'],
            'side_bar_ad' => ['nullable', 'image', 'max:3000'],
            'home_top_bar_ad_url' => ['url', 'nullable'],
            'home_middle_ad_url' => ['url', 'nullable'],
            'view_page_ad_url' => ['url', 'nullable'],
            'news_page_ad_url' => ['url', 'nullable'],
            'side_bar_ad_url' => ['url', 'nullable'],
        ];
    }
}
