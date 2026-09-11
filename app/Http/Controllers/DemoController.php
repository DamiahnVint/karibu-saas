<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DemoController extends Controller
{
    public function index()
    {
        return view('demo.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'company' => 'required|string|max:255',
            'employees' => 'required|string|max:100',
            'phone' => 'nullable|string|max:30',
            'message' => 'nullable|string|max:1000',
        ]);

        // TODO: Send email notification to admin
        // TODO: Store in demo_requests table

        return redirect()->route('demo.success')
            ->with('success', 'Votre demande de démo a été enregistrée. Nous vous contacterons sous 24h.');
    }

    public function success()
    {
        return view('demo.success');
    }
}
