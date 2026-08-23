<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendAdminEmailRequest;
use App\Mail\AdminMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function index()
    {
        return view('admin.email.index');
    }

    public function searchUser(Request $request)
    {
        $term = $request->query('q');

        if (!$term || strlen($term) < 2) {
            return response()->json([]);
        }

        $users = User::where('email', 'like', "%{$term}%")
            ->select('id', 'name', 'email')
            ->limit(8)
            ->get();

        return response()->json($users);
    }

    public function send(SendAdminEmailRequest $request)
    {
        $validated = $request->validated();

        $user = User::findOrFail($validated['user_id']);

        Mail::to($user->email, $user->name)->send(
            new AdminMessage([
                'fromName' => $user->name,
                'fromSubject' => $validated['subject'],
                'fromEmail' => $user->email,
                'fromMessage' => $validated['message'],
            ])
        );

        return redirect()
            ->route('admin.email.index')
            ->with('success', 'Email enviado com sucesso!');
    }
}
