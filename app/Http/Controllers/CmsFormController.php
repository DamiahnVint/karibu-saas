<?php

namespace App\Http\Controllers;

use App\Models\CmsFormSubmission;
use Illuminate\Http\Request;

class CmsFormController extends Controller
{
    /**
     * Traite la soumission d'un formulaire public (contact ou démo).
     */
    public function store(Request $request, string $type)
    {
        $validated = match ($type) {
            'contact' => $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'message' => 'required|string|max:2000',
            ]),
            'demo' => $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'company' => 'nullable|string|max:255',
                'employees' => 'nullable|string|max:100',
                'phone' => 'nullable|string|max:50',
                'message' => 'nullable|string|max:2000',
            ]),
            default => abort(404),
        };

        CmsFormSubmission::create([
            'form_type' => $type,
            'data' => $validated,
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route("cms.form.{$type}.success")
            ->with('success', 'Merci ! Votre demande a bien été envoyée.');
    }

    public function contactSuccess()
    {
        return view('cms.form-success', [
            'title' => 'Message envoyé',
            'message' => 'Merci pour votre message. Notre équipe vous répondra sous 24h.',
        ]);
    }

    public function demoSuccess()
    {
        return view('cms.form-success', [
            'title' => 'Demande de démo envoyée',
            'message' => 'Merci pour votre intérêt. Notre équipe vous contactera pour planifier votre démo.',
        ]);
    }
}
