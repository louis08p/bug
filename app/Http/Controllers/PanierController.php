<?php

namespace App\Http\Controllers;

use App\Models\Panier;
use App\Models\Burger;
use App\Models\Commande;
use App\Models\Facture;
use App\Models\DetailsFacture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PanierController extends Controller
{
    public function index()
    {
       
    $userId = Auth::id();
    $paniers = \App\Models\Panier::where('user_id', $userId)->with('burger')->get();
    return view('panier.index', compact('paniers'));
    }

    public function store(Request $request, $burger_id)
    {
        $panier = Panier::where('user_id', Auth::id())
                        ->where('burger_id', $burger_id)
                        ->first();

        if ($panier) {
            $panier->quantite += 1;
            $panier->save();
        } else {
            $burger = Burger::findOrFail($burger_id);

            Panier::create([
                'user_id' => Auth::id(),
                'burger_id' => $burger_id,
                'quantite' => 1,
                'prix_unitaire' => $burger->prix, // <= ici on récupère le prix du burger
            ]);
        }

        return redirect()->back()->with('success', 'Burger ajouté au panier');
    }



    public function destroy($id)
    {
        $item = \App\Models\Panier::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $item->delete();

        return redirect()->back()->with('success', 'Item supprimé du panier');
    }

    public function validerPanier()
    {
        $userId = Auth::id();
        $paniers = Panier::where('user_id', $userId)->get();

        if ($paniers->isEmpty()) {
            return redirect()->back()->with('error', 'Votre panier est vide.');
        }

        DB::beginTransaction();

        try {
            $facture = Facture::create([
                'user_id' => $userId,
                'date_facture' => now(),
            ]);

            $commande = Commande::create([
                'user_id' => $userId,
                'facture_id' => $facture->id,
                'status' => 'En attente',
            ]);

            foreach ($paniers as $item) {
                DetailsFacture::create([
                    'facture_id' => $facture->id,
                    'burger_id' => $item->burger_id,
                    'quantite' => $item->quantite,
                    'prix_unitaire' => $item->burger->prix,
                ]);
            }

            // Vider le panier
            Panier::where('user_id', $userId)->delete();

            DB::commit();

            return redirect()->route('commande.index')->with('success', 'Commande validée avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de la validation de la commande.');
        }
    }
}
