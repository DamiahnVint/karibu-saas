<?php

namespace Src\Features\Paie\Presentation\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GeneratePayslipRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'employee_id' => 'required|integer|exists:paie_employees,id',
            'mois' => 'required|integer|min:1|max:12',
            'annee' => 'required|integer|min:2020|max:2030',
            'heures_sup_jour' => 'nullable|integer|min:0|max:240',
            'heures_sup_nuit' => 'nullable|integer|min:0|max:120',
            'prime_anciennete' => 'nullable|integer|min:0',
            'prime_rendement' => 'nullable|integer|min:0',
            'prime_risque' => 'nullable|integer|min:0',
            'prime_13eme' => 'nullable|integer|min:0',
            'indemnite_transport' => 'nullable|integer|min:0',
            'indemnite_logement' => 'nullable|integer|min:0',
            'indemnite_responsabilite' => 'nullable|integer|min:0',
            'avantages_nature' => 'nullable|integer|min:0',
            'notes' => 'nullable|string|max:1000',
        ];
    }
}
