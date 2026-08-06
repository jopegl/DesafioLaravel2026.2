<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        Mail::to($validated['email'], $validated['name'])->send(
            new Contact([
                'fromName' => $request['name'],
                'fromSubject' => $request['subject'],
                'fromEmail' => $request['email'],
                'fromMessage' => $request['message'],
            ])
        );
    }
}
