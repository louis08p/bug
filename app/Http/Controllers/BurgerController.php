<?php

namespace App\Http\Controllers;

use App\Models\Burger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BurgerController extends Controller
{
    /**
     * Affiche la liste des burgers (gestionnaire ou client).
     */
    public function index()
    {
        $burgers = Burger::all(); // Client filtrera dans la vue
        return view('burger.burger', compact('burgers'));
    }

    /**
     * Formulaire d'ajout d'un burger.
     */
    public function create()
    {
        $burger = new Burger();
        return view('burger.add', compact('burger'));
    }

    /**
     * Enregistrer un nouveau burger.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('burgers', 'public');
        }

        Burger::create([
            'nom' => $request->nom,
            'prix' => $request->prix,
            'description' => $request->description,
            'stock' => $request->stock,
            'image' => $imagePath,
            'archive' => false,
        ]);

        return redirect()->route('burgers.index')->with('message', 'Burger ajouté avec succès.');
    }

    /**
     * Formulaire de modification.
     */
    public function edit(Burger $burger)
    {
       // return view('gestionnaire.burgers.addBurger', compact('burger'));
    }

    /**
     * Modifier un burger existant.
     */
    public function update(Request $request, Burger $burger)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric',
            'description' => 'nullable|string',
            'stock' => 'required|integer',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si présente
            if ($burger->image) {
                Storage::disk('public')->delete($burger->image);
            }
            $burger->image = $request->file('image')->store('burgers', 'public');
        }

        $burger->update([
            'nom' => $request->nom,
            'prix' => $request->prix,
            'description' => $request->description,
            'stock' => $request->stock,
        ]);

        return redirect()->route('burgers.index')->with('message', 'Burger modifié avec succès.');
    }

    /**
     * Archiver un burger.
     */
    public function archiveBurger($id)
    {
        $burger = Burger::findOrFail($id);
        $burger->archive = true;
        $burger->save();

        return redirect()->route('burgers.index')->with('messageDelete', 'Burger archivé avec succès.');
    }

    /**
     * Afficher la liste des burgers archivés.
     */
    public function archive()
    {
        $burgers = Burger::where('archive', true)->get();
        //return view('gestionnaire.burgers.archiveBurger', compact('burgers'));
    }
}
