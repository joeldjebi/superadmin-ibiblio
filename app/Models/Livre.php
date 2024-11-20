<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livre extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_publication_id', 
        'titre', 
        'auteur_id', 
        'categorie_id', 
        'mot_cle', 
        'annee_publication', 
        'lecture_cible', 
        'acces_livre', 
        'editeur_id', 
        'amount', 
        'pays_id', 
        'episode_id', 
        'langue_id', 
        'vedette', 
        'nombre_de_page', 
        'breve_description', 
        'description'
    ];

    public function type_publication()
    {
        return $this->belongsTo(Type_publication::class);
    }

    public function auteur()
    {
        return $this->belongsTo(Auteur::class);
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function editeur()
    {
        return $this->belongsTo(Editeur::class);
    }

    public function episode()
    {
        return $this->belongsTo(Episode::class, 'livre_id');
    }

    public function chapitre()
    {
        return $this->belongsTo(Chapitre::class, 'livre_id');
    }

    public function langue()
    {
        return $this->belongsTo(Langue::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class, 'livre_id');
    }
}