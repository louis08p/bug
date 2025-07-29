<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\Facture;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Commandes en cours (non payées)
        // Nouveau code (corrigé)
        $commandesEnCours = Commande::where('statut', '!=', 'payée')->whereDate('created_at', $today)->count();
        $commandesValidees = Commande::where('statut', '!=', 'en attente')->whereDate('created_at', $today)->count();


        // Recettes journalières (factures payées aujourd'hui)
        $recettesJour = Facture::whereDate('date_facture', $today)->sum('montant_total');

        // Statistiques pour le graphique (commandes par jour dans le mois courant)
        $commandesParJour = Commande::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->whereMonth('created_at', $today->month)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = $commandesParJour->pluck('date')->map(fn($date) => Carbon::parse($date)->format('d M'))->toArray();
        $data = $commandesParJour->pluck('total')->toArray();

        return view('dashboard', compact('commandesEnCours', 'commandesValidees', 'recettesJour', 'labels', 'data'));
    }
}
