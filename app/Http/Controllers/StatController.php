<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\Facture;
use Carbon\Carbon;

class StatController extends Controller
{
    /**
     * Affiche le tableau de bord des statistiques.
     */
    public function stats()
    {
        // Total des commandes toutes dates confondues
        $totalCommandes = Commande::count();

        // Total des ventes issues des factures
        $totalMontant = Facture::sum('montant_total');

        // Nombre de commandes du jour
        $commandesJour = Commande::whereDate('created_at', Carbon::today())->count();

        // Statistiques journalières (7 derniers jours)
        $statsParJour = Facture::selectRaw('DATE(created_at) as jour, COUNT(*) as commandes, SUM(montant_total) as montant')
            ->groupBy('jour')
            ->orderBy('jour', 'desc')
            ->take(7)
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->jour => [
                    'commandes' => $item->commandes,
                    'montant' => $item->montant,
                ]];
            });

        // Affichage dans la vue Blade
        return view('dashboard.stats', [
            'totalCommandes' => $totalCommandes,
            'totalMontant' => $totalMontant,
            'commandesJour' => $commandesJour,
            'statsParJour' => $statsParJour,
        ]);
    }
}
