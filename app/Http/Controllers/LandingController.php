<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LandingController extends Controller
{
    /**
     * Display the landing page
     */
    public function index()
    {
        return view('landing.index');
    }

    /**
     * Handle trial signup form submission
     */
    public function trialSignup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'clinic_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'city' => 'required|string|max:100',
            'clinic_size' => 'required|in:small,medium,large',
            'accept_emails' => 'boolean'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // TODO: Process trial signup
        // - Create user account
        // - Send welcome email
        // - Set up trial period
        // - Redirect to onboarding

        return redirect()->route('landing')
            ->with('success', 'Cadastro realizado com sucesso! Verifique seu email para continuar.');
    }
}
