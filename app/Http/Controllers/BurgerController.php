<?php

namespace App\Http\Controllers;

use App\Models\Burger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BurgerController extends Controller
{
    /**
     * Vue client : liste des burgers (non archivés)
     */
    public function indexClient()
    {
        $burgers = Burger::where('archive', false)->get();
        return view('burger.index', compact('burgers'));
    }

    /**
     * Vue gestionnaire : liste complète avec archivage
     */
    public function index()
    {
        //$burgers = Burger::all();
        $burgers = Burger::where('archived', false)->get();
         $user = Auth::user();

    if ($user->role === 'gestionnaire') {
        return view('burger.burger', compact('burgers'));
    } elseif ($user->role === 'client') {
        return view('burger.menu', compact('burgers'));
    } else {
        abort(403, 'Accès interdit');
    }
       
        
    }

    /**
     * Afficher le formulaire d'ajout
     */
    public function create()
    {
        return view('burger.add');
    }

    /**
     * Enregistrer un nouveau burger
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|integer',
            'description' => 'nullable|string',
            'stock' => 'required|integer',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = $request->file('image') ? $request->file('image')->store('burgers', 'public') : null;

        Burger::create([
            'nom' => $request->nom,
            'prix' => $request->prix,
            'description' => $request->description,
            'stock' => $request->stock,
            'image' => $imagePath,
        ]);

        return redirect()->route('burgers.index')->with('success', 'Burger ajouté avec succès.');
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Burger $burger)
    {
        return view('burger.edit', compact('burger'));
    }

    /**
     * Mettre à jour un burger
     */
    public function update(Request $request, Burger $burger)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|integer',
            'description' => 'nullable|string',
            'stock' => 'required|integer',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($burger->image) {
                Storage::disk('public')->delete($burger->image);
            }
            $burger->image = $request->file('image')->store('burgers', 'public');
        }

        $burger->update($request->except('image'));

        return redirect()->route('burgers.index')->with('success', 'Burger mis à jour.');
    }

    /**
     * Archiver un burger (désactiver)
     */
    public function archive()
{
    $burgers = Burger::where('archived', true)->get();
    return view('burger.archive', compact('burgers'));
}

    public function archiveBurger($id)
{
    $burger = Burger::findOrFail($id);

    // Archive logique : on ajoute une colonne 'archived' (booléenne)
    $burger->archived = true;
    $burger->save();

    return redirect()->route('burgers.index')->with('messageDelete', 'Burger archivé avec succès.');
}
}
