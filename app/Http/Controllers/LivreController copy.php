<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use App\Models\Forfait;
use App\Models\Type_publication;
use App\Models\Categorie;
use App\Models\Auteur;
use App\Models\Editeur;
use App\Models\Pays;
use App\Models\Langue;
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


class LivreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] ='Les livres';
        $data['menu'] ='livre';

        $data['user'] = Super::where([
            'id' => Auth::user()->id,
            'role' => 01
        ])->first();

        if (empty($data['user'])) {
            // Flash success message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue!');
        }

        $data["livres"] = Livre::orderBy('id', 'desc')->get();
        
        return view('livres.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title'] ='Les livres';
        $data['menu'] ='livre';

        $data['user'] = Super::where([
            'id' => Auth::user()->id,
            'role' => 01
        ])->first();

        if (empty($data['user'])) {
            // Flash success message
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue!');
        }

        $data["type_publications"] = Type_publication::orderBy('id', 'desc')->get();
        $data["categories"] = Categorie::orderBy('id', 'desc')->get();
        $data["editeurs"] = Editeur::orderBy('id', 'desc')->get();
        $data["pays"] = Pays::orderBy('id', 'desc')->get();
        $data["langues"] = Langue::orderBy('id', 'desc')->get();

        $data["auteurs"] = Auteur::withoutTrashed()->orderBy('id', 'desc')->get();

        return view('livres.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des champs
        $request->validate([
            'type_publication_id' => 'required|numeric|exists:type_publications,id',
            'titre' => 'required|string|unique:livres',
            'auteur_id' => 'required|numeric|exists:auteurs,id',
            'categorie_id' => 'required|numeric|exists:categories,id',
            'mot_cle' => 'required|string',
            'annee_publication' => 'required|numeric',
            'lecture_cible' => 'required|string',
            'acces_livre' => 'required|string',
            'editeur_id' => 'required|numeric|exists:editeurs,id',
            'amount' => 'required|numeric',
            'pays_id' => 'required|numeric|exists:pays,id',
            'langue_id' => 'required|numeric',
            'vedette' => 'required|numeric',
            'nombre_de_page' => 'required|numeric',
            'image_cover' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx|max:10240',
            'breve_description' => 'required|string',
            'description' => 'required|string',
            'file_type' => 'nullable|string',
            'path_extrait' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx|max:10240|unique:files',
            'paths' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx|max:10240|unique:files',
            'url' => 'nullable|string|unique:files',
    
            // Champs conditionnels pour Podcast
            'titre_episode' => $request->type_publication_id == 4 ? 'required|string' : 'nullable|string',
            'description_episode' => $request->type_publication_id == 4 ? 'required|string' : 'nullable|string',
            'file_type_episode' => $request->type_publication_id == 4 ? 'required|string' : 'nullable|string',
            'file_episode' => ($request->type_publication_id == 4 && $request->file_type_episode == 'upload') ? 'required|file|mimes:jpg,jpeg,png,pdf,docx|max:10240' : 'nullable|file',
            'url_episode' => ($request->type_publication_id == 4 && $request->file_type_episode == 'external_link') ? 'required|string' : 'nullable|string',

            // Champs conditionnels pour Audio Book
            'titre_chapitre' => $request->type_publication_id == 3 ? 'required|string' : 'nullable|string',
            'description_chapitre' => $request->type_publication_id == 3 ? 'required|string' : 'nullable|string',
            'file_type_chapitre' => $request->type_publication_id == 3 ? 'required|string' : 'nullable|string',
            'file_chapitre' => ($request->type_publication_id == 3 && $request->file_type_chapitre == 'upload') ? 'required|file|mimes:jpg,jpeg,png,pdf,docx|max:10240' : 'nullable|file',
            'url_chapitre' => ($request->type_publication_id == 3 && $request->file_type_chapitre == 'external_link') ? 'required|string' : 'nullable|string',
        ], [
            // Messages personnalisés pour les champs généraux
            'file_type.string' => 'Le type de fichier doit être une chaîne de caractères.',
            
            'path_extrait.file' => 'L\'extrait doit être un fichier valide.',
            'path_extrait.mimes' => 'L\'extrait doit être au format jpg, jpeg, png, pdf ou docx.',
            'path_extrait.max' => 'L\'extrait ne doit pas dépasser 10 Mo.',
            'path_extrait.unique' => 'Cet extrait est déjà enregistré.',
        
            'paths.file' => 'Le fichier doit être valide.',
            'paths.mimes' => 'Le fichier doit être au format jpg, jpeg, png, pdf ou docx.',
            'paths.max' => 'Le fichier ne doit pas dépasser 10 Mo.',
            'paths.unique' => 'Ce fichier est déjà utilisé.',
            
            'url.string' => 'L\'URL doit être une chaîne de caractères.',
            'url.unique' => 'Cette URL est déjà enregistrée.',
        
            // Messages pour les champs conditionnels pour Podcast
            'titre_episode.required' => 'Le titre de l\'épisode est requis pour un podcast.',
            'description_episode.required' => 'La description de l\'épisode est requise pour un podcast.',
            'file_type_episode.required' => 'Le type de fichier de l\'épisode est requis pour un podcast.',
            'file_episode.required' => 'Le fichier de l\'épisode est requis pour un podcast.',
            'file_episode.file' => 'Le fichier de l\'épisode doit être valide.',
            'file_episode.mimes' => 'Le fichier de l\'épisode doit être au format jpg, jpeg, png, pdf ou docx.',
            'file_episode.max' => 'Le fichier de l\'épisode ne doit pas dépasser 10 Mo.',
            'url_episode.required' => 'L\'URL de l\'épisode est requise si le type de fichier est un lien externe.',
        
            // Messages pour les champs conditionnels pour Audio Book
            'titre_chapitre.required' => 'Le titre du chapitre est requis pour un audio book.',
            'description_chapitre.required' => 'La description du chapitre est requise pour un audio book.',
            'file_type_chapitre.required' => 'Le type de fichier du chapitre est requis pour un audio book.',
            'file_chapitre.required' => 'Le fichier du chapitre est requis pour un audio book.',
            'file_chapitre.file' => 'Le fichier du chapitre doit être valide.',
            'file_chapitre.mimes' => 'Le fichier du chapitre doit être au format jpg, jpeg, png, pdf ou docx.',
            'file_chapitre.max' => 'Le fichier du chapitre ne doit pas dépasser 10 Mo.',
            'url_chapitre.required' => 'L\'URL du chapitre est requise si le type de fichier est un lien externe.',
        ]);
    
        // Vérification de l'utilisateur
        $user = Super::where(['id' => Auth::id(), 'role' => 1])->first();
        if (!$user) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue!');
            return back();
        }
    
        // Création du livre
        $livre = new Livre();
        $fields = [
            'type_publication_id', 'titre', 'auteur_id', 'categorie_id', 'mot_cle',
            'annee_publication', 'lecture_cible', 'acces_livre', 'editeur_id', 'amount',
            'pays_id', 'langue_id', 'vedette', 'nombre_de_page', 'breve_description',
            'description', 'file_type', 'edition_du_livre', 'image_cover'
            // , 'url', 'titre_episode', 'description_episode',
            // 'file_type_episode', 'url_episode', 'titre_chapitre', 'description_chapitre',
            // 'file_type_chapitre', 'url_chapitre'
        ];
    
        foreach ($fields as $field) {
            $livre->$field = html_entity_decode($request->$field);
        }
    
        if ($livre->save()) {

            $livreLastSave = Livre::where('id', $livre->id)->first();

            // Gestion des fichiers optionnels
            $this->handleFileUploadPathExtrait($request->file('path_extrait'), 'path_extrait', $livre, $request);
            $this->handleFileUploadPath($request->file('paths'), 'paths', $livre, $request);
    
            // Gestion des fichiers pour épisodes
            if ($request->file_type_episode === 'upload') {
                $this->handleFileUploadEpisode($request->file('file_episode'), 'file_episode', $livre, $request);
            }
    
            // Gestion des fichiers pour chapitres
            if ($request->file_type_chapitre === 'upload') {
                $this->handleFileUploadChapitre($request->file('file_chapitre'), 'file_chapitre', $livre, $request);
            }
    
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Livre créé avec succès');
            return back();
        } else {
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Une erreur est survenue');
            return back();
        }
    }
    
    protected function handleFileUploadPathExtrait($file, $directory, $livre, $request)
    {
        if ($file) {
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = Storage::disk('wasabi')->putFileAs($directory, $file, $filename);
            $fileUrl = Storage::disk('wasabi')->url($filePath);
    
            $fileRecord = new File();
            $fileRecord->titre = $request->titre;
            $fileRecord->description = $request->description;
            $fileRecord->filename = $filename;
            $fileRecord->disk = 'wasabi';
            $fileRecord->extension = $file->getClientOriginalExtension();
            $fileRecord->mime = $file->getMimeType();
            $fileRecord->size = $file->getSize();
            $fileRecord->download = 0;
            $fileRecord->path = $filePath;
            $fileRecord->path_extrait = $fileUrl;
            $fileRecord->livre_id = $livre->id;
            $fileRecord->auteur_id = $request->auteur_id;
            
            if ($fileRecord->save()) {

                $fileLastSave = File::where('filename', $filename)->first();

                $livreLastSave->file_id = $fileLastSave->id;
                $livreLastSave->save();
            }
            
        }
    }
    
    protected function handleFileUploadPath($file, $directory, $livre, $request)
    {
        if ($file) {
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = Storage::disk('wasabi')->putFileAs($directory, $file, $filename);
            $fileUrl = Storage::disk('wasabi')->url($filePath);
    
            $fileRecord = new File();
            $fileRecord->titre = $request->titre;
            $fileRecord->description = $request->description;
            $fileRecord->filename = $filename;
            $fileRecord->disk = 'wasabi';
            $fileRecord->extension = $file->getClientOriginalExtension();
            $fileRecord->mime = $file->getMimeType();
            $fileRecord->size = $file->getSize();
            $fileRecord->download = 0;
            $fileRecord->path = $filePath;
            $fileRecord->url = $fileUrl;
            $fileRecord->livre_id = $livre->id;
            $fileRecord->auteur_id = $request->auteur_id;
            
            if ($fileRecord->save()) {

                $fileLastSave = File::where('filename', $filename)->first();

                $livreLastSave->file_id = $fileLastSave->id;
                $livreLastSave->save();
            }
            
        }
    }
    
    protected function handleFileUploadEpisode($file, $directory, $livre, $request)
    {
        if ($file) {
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = Storage::disk('wasabi')->putFileAs($directory, $file, $filename);
            $fileUrl = Storage::disk('wasabi')->url($filePath);
    
            $fileRecord = new Episode();
            $fileRecord->titre = $request->titre_episode;
            $fileRecord->description = $request->description_episode;
            $fileRecord->filename = $filename;
            $fileRecord->disk = 'wasabi';
            $fileRecord->extension = $file->getClientOriginalExtension();
            $fileRecord->mime = $file->getMimeType();
            $fileRecord->size = $file->getSize();
            $fileRecord->download = 0;
            $fileRecord->path = $filePath;
            $fileRecord->url = $fileUrl;
            $fileRecord->livre_id = $livre->id;
            $fileRecord->auteur_id = $request->auteur_id;

            if ($fileRecord->save()) {

                $episodeLastSave = Episode::where('filename', $filename)->first();

                $livreLastSave->episode_id = $episodeLastSave->id;
                $livreLastSave->save();
            }
        }
    }
    
    protected function handleFileUploadChapitre($file, $directory, $livre, $request)
    {
        if ($file) {
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = Storage::disk('wasabi')->putFileAs($directory, $file, $filename);
            $fileUrl = Storage::disk('wasabi')->url($filePath);
    
            $fileRecord = new Chapitre();
            $fileRecord->titre = $request->titre_chapitre;
            $fileRecord->description = $request->description_chapitre;
            $fileRecord->filename = $filename;
            $fileRecord->disk = 'wasabi';
            $fileRecord->extension = $file->getClientOriginalExtension();
            $fileRecord->mime = $file->getMimeType();
            $fileRecord->size = $file->getSize();
            $fileRecord->download = 0;
            $fileRecord->path = $filePath;
            $fileRecord->url = $fileUrl;
            $fileRecord->livre_id = $livre->id;
            $fileRecord->auteur_id = $request->auteur_id;
            
            if ($fileRecord->save()) {

                $chapitreLastSave = Chapitre::where('filename', $filename)->first();

                $livreLastSave->chapitre_id = $chapitreLastSave->id;
                $livreLastSave->save();
            }
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Livre $livre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Livre $livre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Livre $livre)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Livre $livre)
    {
        //
    }
}