<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\Commande;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Panier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FactureController extends Controller
{
    /**
     * Affiche toutes les factures du client connecté.
     */
    public function index()
    {
        $factures = Facture::where('user_id', Auth::id())->latest()->get();
        return view('facture.index', compact('factures'));
    }

    /**
     * Crée une facture à partir du panier du client.
     */
    public function store(Request $request)
    {
        $userId = Auth::id();
        $paniers = Panier::where('user_id', $userId)->with('burger')->get();

        if ($paniers->isEmpty()) {
            return redirect()->back()->with('error', 'Votre panier est vide.');
        }

        DB::beginTransaction();
        try {
            // Création de la commande
            $commande = Commande::create([
                'user_id' => $userId,
                'status' => 'en attente',
            ]);

            // Calcul du montant total
            $total = 0;
            foreach ($paniers as $item) {
                $total += $item->quantite * $item->burger->prix;

                // Associer panier à la commande (si tu as un champ commande_id dans panier)
                $item->commande_id = $commande->id;
                $item->save();
            }

            // Création de la facture liée à la commande
            $facture = Facture::create([
                'user_id' => $userId,
                'commande_id' => $commande->id,
                'montant_total' => $total,
                'date_facture' => now(),
            ]);

            // Vider le panier
            Panier::where('user_id', $userId)->whereNull('commande_id')->delete();

            DB::commit();

            return redirect()->route('facture.show', $facture->id)->with('success', 'Commande validée avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de la validation : ' . $e->getMessage());
        }
    }

    /**
     * Affiche une facture avec détails depuis commande + paniers.
     */
    public function show($id)
    {
        $facture = Facture::with('commande.panier.burger')->findOrFail($id);

        if ($facture->user_id !== Auth::id()) {
            abort(403);
        }

        $commande = $facture->commande;
        $paniers = $commande->panier;

        return view('facture.show', compact('facture', 'commande', 'paniers'));
    }
  

public function generatePdf($id)
{
    $facture = Facture::with('commande.panier.burger')->findOrFail($id);
    if ($facture->user_id !== Auth::id()) abort(403);
    
    $commande = $facture->commande;
    $paniers = $commande->panier;

    $pdf = Pdf::loadView('facture.pdf', compact('facture', 'commande', 'paniers'));
    return $pdf->download('facture_'.$facture->id.'.pdf');
}

}
