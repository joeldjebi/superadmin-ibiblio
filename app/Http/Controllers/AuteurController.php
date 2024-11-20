<?php

namespace App\Http\Controllers;

use App\Models\Auteur;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Redirector; 
use Session;
use App\Models\Super;
use App\Models\Station;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AuteurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] ='Les auteurs';
        $data['menu'] ='auteur';

        $data['user'] = Super::where([
            'id' => Auth::user()->id,
            'role' => 01
        ])->first();

        if (empty($data['user'])) {
            // Flash success message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue!');
        }

        $data["auteurs"] = Auteur::orderBy('id', 'desc')->get();
        
        return view('donnees.auteur',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        // Validation des champs
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'mobile' => 'required|string|max:20|unique:auteurs',
            'email' => 'required|string|email|max:255|unique:auteurs',
        ]);

        $data['user'] = Super::where([
            'id' => Auth::user()->id,
            'role' => 01
        ])->first();

        if (empty($data['user'])) {
            // Flash success message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue!');
        }
    
        $auteur = new Auteur();
        $auteur->nom = html_entity_decode($request->nom);
        $auteur->prenoms = html_entity_decode($request->prenoms);
        $auteur->mobile = html_entity_decode($request->mobile);
        $auteur->email = html_entity_decode($request->email);
        $auteur->password = Hash::make($request->email);
    
        // Vérification si l'utilisateur a bien été créé
        if ($auteur->save()) {
            // Flash success message
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Auteur créer avec succès');
            return back();
            
        } else {
            // Flash error message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue');
            
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validation des champs
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'mobile' => [
                'required',
                'string',
                'max:20',
                Rule::unique('auteurs')->ignore($id), // Ignore l'enregistrement actuel
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('auteurs')->ignore($id), // Ignore l'enregistrement actuel
            ],
        ]);

        $data['user'] = Super::where([
            'id' => Auth::user()->id,
            'role' => 01
        ])->first();

        if (empty($data['user'])) {
            // Flash success message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue!');
        }

        $auteur = Auteur::find($id);

        if (empty($auteur)) {
            // Flash success message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Auteur introuvable');
            return back();
        }

        $auteur->nom = html_entity_decode($request->nom);
        $auteur->prenoms = html_entity_decode($request->prenoms);
        $auteur->mobile = html_entity_decode($request->mobile);
        $auteur->email = html_entity_decode($request->email);

        // Vérification si l'utilisateur a bien été mis à jour
        if ($auteur->save()) {
            // Flash success message
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Auteur mis à jour avec succès');
            
            return back();
        } else {
            // Flash error message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue');
            
            return back();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $data['user'] = Super::where([
            'id' => Auth::user()->id,
            'role' => 01
        ])->first();

        if (empty($data['user'])) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue!');
            return back();
        }

        $auteur = Auteur::find($id);

        if ($auteur) {
            $auteur->delete(); // Effectue une suppression logique
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Auteur supprimé avec succès');
        } else {
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Auteur introuvable');
        }

        return back();
    }

}