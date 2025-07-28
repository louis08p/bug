<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Panier;
use App\Models\Facture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommandeController extends Controller
{
    /**
     * Affiche les commandes du client connecté.
     */
    public function index()
    {
        $user = Auth::user();
        $commandes = Commande::where('user_id', $user->id)->with('facture')->latest()->get();
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
            $commande = new Commande();
            $commande->user_id = $user->id;
            $commande->status = 'en attente';
            $commande->save();

            // Total pour la facture
            $total = 0;

            foreach ($paniers as $item) {
                $item->commande_id = $commande->id;
                $item->save();
                $total += $item->quantite * $item->burger->prix;
            }

            // Création de la facture
            $facture = new Facture();
            $facture->commande_id = $commande->id;
            $facture->montant = $total;
            $facture->save();

            // Vider le panier
            Panier::where('user_id', $user->id)->delete();

            DB::commit();

            return redirect()->route('commandes.index')->with('success', 'Commande passée avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de la commande : ' . $e->getMessage());
        }
    }

    /**
     * Affiche les détails d’une commande (y compris facture et contenu).
     */
    public function show(Commande $commande)
    {
        $this->authorize('view', $commande); // Facultatif si tu veux vérifier le propriétaire

        $paniers = Panier::where('commande_id', $commande->id)->with('burger')->get();
        $facture = $commande->facture;

        return view('commande.show', compact('commande', 'paniers', 'facture'));
    }
}
