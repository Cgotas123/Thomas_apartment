<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTenantRequest extends FormRequest
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
            'full_name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:tenants,email',
            'phone_number' => 'nullable|string|max:20',
            'emergency_contact' => 'nullable|string|max:255',
            'category' => 'required|in:Student,Employee,Family',
            'unit_id' => 'required|exists:units,id',
            'monthly_rent' => 'required|numeric',
            'security_deposit' => 'nullable|numeric',
            'advance_payment' => 'nullable|numeric',
            'move_in_date' => 'required|date',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
