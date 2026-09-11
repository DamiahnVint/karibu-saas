<?php

namespace Src\Features\Paie\Presentation\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'date_naissance' => 'nullable|date|before:today',
            'sexe' => 'nullable|in:M,F',
            'situation_familiale' => 'required|in:celibataire,marie,divorce,veuf',
            'nb_enfants' => 'nullable|integer|min:0|max:20',
            'poste' => 'nullable|string|max:255',
            'department_id' => 'nullable|integer|exists:paie_departments,id',
            'date_embauche' => 'required|date|before_or_equal:today',
            'type_contrat' => 'required|in:cdi,cdd,saisonnier,stage',
            'duree_contrat' => 'nullable|required_if:type_contrat,cdd|date|after:date_embauche',
            'salaire_base' => 'required|integer|min:1',
            'mode_paiement' => 'required|in:virement,cheque,especes,mobile_money',
            'banque' => 'nullable|string|max:255',
            'rib' => 'nullable|string|max:30',
            'cnps_numero' => 'nullable|string|max:20',
            'statut' => 'required|in:actif,inactif,suspendu,radie',
            'notes' => 'nullable|string|max:1000',
        ];
    }
}
