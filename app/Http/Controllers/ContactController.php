<?php

namespace App\Http\Controllers;

use App\Mail\AdminMessage;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function indexAllMessages()
    {

        $this->authorize('indexAllMessages', Contact::class);
        $msgs = Contact::withDetails()->latest()->paginate(10);

        return view('admin.contacts.index', compact('msgs'));
    }

    public function reply(Request $request, Contact $contact)
    {
        $this->authorize('reply', $contact);

        $validated = $request->validate([
            'reply' => 'required|string',
        ]);

        $contact->update([
            'reply' => $validated['reply'],
            'replied_by' => Auth::id(),
            'replied_at' => now(),
        ]);

        Mail::to($contact->email, $contact->name)->send(
            new AdminMessage([
                'fromName' => $contact->name,
                'fromSubject' => 'Resposta à sua mensagem',
                'fromEmail' => $contact->email,
                'fromMessage' => $validated['reply'],
            ])
        );

        return redirect()
            ->route('admin.contacts.index')
            ->with('success', 'Resposta enviada com sucesso!');
    }
}
