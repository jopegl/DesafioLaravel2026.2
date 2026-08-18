<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyRequest;
use App\Http\Requests\StoreContactRequest;
use App\Mail\AdminMessage;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{


    public function create()
    {
        return view('contact.create');
    }

    public function store(StoreContactRequest $request)
    {
        $validated = $request->validated();

        Contact::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'message' => $validated['message'],
        ]);

        return redirect()
            ->route('contact.create')
            ->with('success', 'Mensagem enviada com sucesso! Em breve entraremos em contato.');
    }

    public function indexAllMessages()
    {

        $this->authorize('indexAllMessages', Contact::class);
        $msgs = Contact::withDetails()->latest()->paginate(10);

        return view('admin.contacts.index', compact('msgs'));
    }

    public function reply(ReplyRequest $request, Contact $contact)
    {
        $this->authorize('reply', $contact);

        $validated = $request->validated();

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
