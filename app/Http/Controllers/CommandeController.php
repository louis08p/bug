<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Panier;
use App\Models\Facture;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\FactureReadyMail;

class CommandeController extends Controller
{
    /**
     * Lister toutes les commandes (Gestionnaire ou Client selon rôle).
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'gestionnaire') {
            $commandes = Commande::with('facture', 'user')->latest()->get();
        } else {
            $commandes = Commande::where('user_id', $user->id)->with('facture')->latest()->get();
        }

        return view('commande.index', compact('commandes'));
    }

    /**
     * Affiche le formulaire de validation du panier → commande.
     */
    public function create()
    {
        $user = Auth::user();
        $paniers = Panier::where('user_id', $user->id)->get();
    return view('commande.create', compact('paniers'));
        
    }

    /**
     * Enregistre la commande et génère une facture.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $paniers = Panier::where('user_id', $user->id)->get();

        if ($paniers->isEmpty()) {
            return redirect()->back()->with('error', 'Votre panier est vide.');
        }

        DB::beginTransaction();
        try {
            // Création de la commande
            $commande = Commande::create([
                'user_id' => $user->id,
                'statut' => 'en_attente',
            ]);

            // Total pour la facture
            $total = 0;

            foreach ($paniers as $item) {
                $item->commande_id = $commande->id;
                $item->save();
                $total += $item->quantite * $item->burger->prix;
            }

            // Création de la facture
            Facture::create([
                'user_id' => $user->id,
                'commande_id' => $commande->id,
                'montant_total' => $total,
                'date_facture' => null
            ]);

            // Vider le panier
           // Panier::where('user_id', $user->id)->whereNull('commande_id')->delete();

            DB::commit();

            return redirect()->route('commandes.index')->with('success', 'Commande passée avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de la commande : ' . $e->getMessage());
        }
    }

    /**
     * Affiche les détails d’une commande.
     */
        public function show(Commande $commande)
    {
        $commande->load('facture', 'panier.burger', 'user');
        return view('commande.show', compact('commande'));
    }

    /**
     * Modifier le statut de la commande.
     */
    public function updatestatut(Request $request, $id)
{
     $request->validate([
        'statut' => 'required|in:en_attente,en_preparation,prete,payee',
    ]);
    
    $commande = Commande::with('facture', 'panier.burger', 'user')->findOrFail($id);
    $statut = $request->input('statut');

    $commande->statut = $statut; // ← Changé de 'statut' à 'statut'
    $commande->save();

    // Si commande devient prête → envoyer email avec facture PDF
    if ($statut === 'prete') { // ← Changé de 'Prête' à 'Prete'
        $facture = $commande->facture;
        $paniers = $commande->panier;

        Mail::to($commande->user->email)->send(new FactureReadyMail($facture, $commande, $paniers));
    }

    // Si commande devient payée → enregistrer la date de paiement
    if ($statut === 'payee') { // ← Changé de 'Payée' à 'Payee'
        $commande->facture->update([
            'date_facture' => now(),
        ]);
    }

    return back()->with('success', 'Statut mis à jour.');
}


    /**
     * Enregistrer le paiement de la commande.
     */
    public function payer(Request $request, $id)
    {
        $commande = Commande::with('facture')->findOrFail($id);

        if ($commande->facture->date_facture != null) {
            return back()->with('error', 'Cette commande a déjà été payée.');
        }

        $commande->facture->update([
            'date_facture' => now()
        ]);

        $commande->statut = 'payee';
        $commande->save();

        return back()->with('success', 'Paiement enregistré.');
    }

    /**
     * Annuler la commande.
     */
    public function annuler($id)
    {
        $commande = Commande::findOrFail($id);
        $commande->statut = 'annulée';
        $commande->save();

        return back()->with('success', 'Commande annulée.');
    }
    public function enregistrerPaiement($id)
{
    $commande = Commande::with('facture')->findOrFail($id);

    // Vérifie si déjà payé
    if ($commande->facture->date_paiement !== null) {
        return back()->with('error', 'La commande a déjà été payée.');
    }

    // Marquer la facture comme payée (espèces)
    $commande->facture->update([
        'date_paiement' => now(),
    ]);

    return back()->with('success', 'Paiement enregistré avec succès.');
}

}
