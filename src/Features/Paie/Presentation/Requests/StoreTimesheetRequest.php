<?php

namespace Src\Features\Paie\Presentation\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTimesheetRequest extends FormRequest
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
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
            'pause' => 'nullable|integer|min:0|max:480',
            'notes' => 'nullable|string|max:500',
        ];
    }
}
