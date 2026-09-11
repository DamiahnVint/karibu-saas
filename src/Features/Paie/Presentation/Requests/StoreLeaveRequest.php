<?php

namespace Src\Features\Paie\Presentation\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeaveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'employee_id' => 'required|integer|exists:paie_employees,id',
            'type' => 'required|in:paye,maladie,maternite,paternite,sans_solde,deces,mariage,naissance',
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'nb_jours' => 'required|integer|min:1|max:365',
            'motif' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:500',
        ];
    }
}
