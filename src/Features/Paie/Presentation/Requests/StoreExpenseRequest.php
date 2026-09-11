<?php

namespace Src\Features\Paie\Presentation\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'employee_id' => 'required|integer|exists:paie_employees,id',
            'date' => 'required|date|before_or_equal:today',
            'categorie' => 'required|in:transport,hebergement,repas,fournitures,autre',
            'montant' => 'required|integer|min:1',
            'description' => 'nullable|string|max:500',
            'justificatif' => 'nullable|file|max:5120',
            'notes' => 'nullable|string|max:500',
        ];
    }
}
