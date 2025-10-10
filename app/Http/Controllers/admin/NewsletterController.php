<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    /**
     * Affiche la liste des abonnés à la newsletter
     */
    public function index(Request $request)
    {
        $search = $request->input('search_query', '');

        $query = Newsletter::query();

        if ($search) {
            $query->where('email', 'like', "%{$search}%");
        }

        $emails = $query->latest()->paginate(10);

        return view('admin.newsletters.index', compact('emails'));
    }

    /**
     * Affiche le formulaire d'envoi d'une newsletter
     */
    public function create()
    {
        return view('admin.newsletters.create');
    }

    /**
     * Envoie une newsletter à tous les abonnés ou à une sélection d'emails
     */
    public function send(Request $request)
    {
        $data = $request->validate([
            'rich_active' => 'nullable|boolean',
            'subject' => 'required|string|max:255',
            'rich_content' => 'nullable|required_with:rich_active|string',
            'basic_content' => 'nullable|required_without:rich_active|string',
            'recipients' => 'nullable|string', // ✅ maintenant une chaîne, pas un tableau
        ], [
            'subject.required' => 'Le sujet est obligatoire.',
            //'content.required' => 'Le contenu du message est obligatoire.',
        ]);

        // ✅ Transformer la chaîne en tableau d’emails
        $emails = [];

        if (isset($data['rich_active']) && $data['rich_active']) {
          $data['content'] = $data['rich_content'];
        }else {
          $data['content'] = $data['basic_content'];
        }

        if (!empty($data['recipients'])) {
            // Supprime les espaces et transforme en tableau
            $emails = array_filter(array_map('trim', explode(',', $data['recipients'])), function ($email) {
                return filter_var($email, FILTER_VALIDATE_EMAIL); // garde seulement les adresses valides
            });
        } else {
            $emails = Newsletter::pluck('email')->toArray();
        }

        foreach ($emails as $email) {
            Mail::send([], [], function ($message) use ($email, $data) {
                $message->to($email)
                        ->subject($data['subject'])
                        ->html($data['content']); // <-- Ici on envoie le contenu HTML
            });
        }

        return redirect()->route('admin.newsletters.index')
          ->with('success', 'Newsletter envoyée avec succès à ' . count($emails) . ' destinataire(s).');
    }

    /**
     * Supprimer un abonné
     */
    public function destroy(Newsletter $newsletter)
    {
        $newsletter->delete();
        return redirect()->route('admin.newsletters.index')->with('success', 'Abonné supprimé avec succès.');
    }
}
