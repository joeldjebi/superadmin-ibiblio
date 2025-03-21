@include('layouts.header')
@include('layouts.menu')

@include('layouts.fileariane')

<div class="row show-livre-content">
    <div class="col-lg-12">
        <div class="card-title h5">{{ $livre->titre }}</div>
       <div class="row">
          <div class="col-md-2">
             <div class="card-icon-big mb-4 text-center card">
                <div class="card-body">
                   <i class="i-Data-Download"></i>
                   <p class="text-muted mt-2 mb-0 text-capitalize">Téléchargements</p>
                   <p class="lead text-18 mt-2 mb-0 text-capitalize">21</p>
                </div>
             </div>
          </div>
          <div class="col-md-2">
             <div class="card-icon-big mb-4 text-center card">
                <div class="card-body">
                   <i class="i-Add-User"></i>
                   <p class="text-muted mt-2 mb-0 text-capitalize">Utilisateurs</p>
                   <p class="lead text-18 mt-2 mb-0 text-capitalize">53</p>
                </div>
             </div>
          </div>
          <div class="col-md-2">
             <div class="card-icon-big mb-4 text-center card">
                <div class="card-body">
                   <i class="i-Money-2"></i>
                   <p class="text-muted mt-2 mb-0 text-capitalize">Achats</p>
                   <p class="lead text-18 mt-2 mb-0 text-capitalize">4031</p>
                </div>
             </div>
          </div>
          <div class="col-md-2">
             <div class="card-icon-big mb-4 text-center card">
                <div class="card-body">
                   <i class="i-Car-Coins"></i>
                   <p class="text-muted mt-2 mb-0 text-capitalize">Abonnement</p>
                   <p class="lead text-18 mt-2 mb-0 text-capitalize">4031</p>
                </div>
             </div>
          </div>
       </div>
    </div>
</div>



@if ($livre->file)
    
    @php
    $urlFile = !empty($livre->file->path) ? Storage::disk('wasabi')->temporaryUrl(
        $livre->file->path, now()->addMinutes(20)
    ) : null;
    @endphp

    <div class="container">
    <p><strong>Auteur:</strong> {{ $livre->auteur ? $livre->auteur->nom .' '. $livre->auteur->prenoms : 'Non spécifié' }}</p>
    <p><strong>Categorie:</strong> {{ $livre->categorie ? $livre->categorie->libelle : 'Non spécifié' }}</p>
    <p><strong>Éditeur:</strong> {{ $livre->editeur ? $livre->editeur->nom .' '. $livre->editeur->prenoms : 'Non spécifié' }}</p>
    <p><strong>Langue:</strong> {{ $livre->langue ? $livre->langue->libelle : 'Non spécifiée' }}</p>

    <h3>Description</h3>
    <p>{{ $livre->description }}</p>

    <h3>Fichier Associé</h3>
    <table class="table">
        <tr>
            <th>Fichier</th>
            <td>
                @if ($livre->file)
                    <a href="{{ $urlFile }}" target="_blank">Télécharger le fichier </a>
                @else
                    Pas de fichier associé
                @endif
            </td>
        </tr>
    </table>

    <h3>Informations Complémentaires</h3>
    <table class="table">
        <tr>
            <th>Type de Publication</th>
            <td>{{ $livre->type_publication ? $livre->type_publication->libelle : 'Non spécifié' }}</td>
        </tr>
        <tr>
            <th>Année de Publication</th>
            <td>{{ $livre->annee_publication }}</td>
        </tr>
        <tr>
            <th>Nombre de Pages</th>
            <td>{{ $livre->nombre_de_page }}</td>
        </tr>
        <tr>
            <th>Accès au Livre</th>
            <td>{{ $livre->acces_livre }}</td>
        </tr>
    </table>

    <h3>Autres informations</h3>
    <table class="table">
        <tr>
            <th>Mot Clé</th>
            <td>{{ $livre->mot_cle }}</td>
        </tr>
        <tr>
            <th>Lecture Cible</th>
            <td>{{ $livre->lecture_cible }}</td>
        </tr>
    </table>
    </div>
@endif

@if ($livre->episodes->isNotEmpty())
<div class="card text-left">
    <div class="card-body">
        <h4 class="card-title mb-3">Les episodes</h4>
        @if(!empty($livre) )
            <div class="table-responsive">
                <table class="display table table-striped table-bordered" id="language_option_table" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Couverture</th>
                            <th scope="col">Titre</th>
                            <th scope="col">Prix (F CFA)</th>
                            <th scope="col">Type de publication</th>
                            <th scope="col">Taille</th>
                            <th scope="col">Fichier</th>
                            <th scope="col">Téléchargement</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($livre->episodes as $key => $item)
                            @php
                                // Génération de l'URL temporaire si l'URL de l'image existe
                                $urlPath = !empty($item->path) ? Storage::disk('wasabi')->temporaryUrl(
                                    $item->path, now()->addMinutes(20)
                                ) : null;

                                $imgCover = !empty($livre->image_cover_url) ? Storage::disk('wasabi')->temporaryUrl(
                                    $livre->image_cover_url, now()->addMinutes(20)
                                ) : null;
                
                                // Formatage du montant
                                if ($item && isset($livre->amount)) {
                                    $nombre_formate = number_format((float) $livre->amount, 0, '', ' ');
                                } else {
                                    $nombre_formate = 'N/A';
                                }
                            @endphp
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    @if (!empty($imgCover))
                                        <img src="{{ $imgCover }}" alt="Image" style="width:50px; height:auto;">
                                    @else
                                        <span>Pas d'image</span>
                                    @endif
                                </td>
                                <td>{{ $item->titre }}</td>
                                <td>{{ $nombre_formate }}</td>
                                <td>{{ $livre->type_publication->libelle }}</td>
                                <td>{{ $item->size ?? 'N/A' }}</td>
                                <td><a href="{{ $urlPath }}" target="_blank">Écouter </a></td>
                                <td>{{ $item->download ?? 0 }}</td>
                                <td style="display: inline-flex; border: none;">
                                    <a class="text-danger mr-2" href="{{ route('livre.show', ['id' => $item->id]) }}">
                                        <i class="nav-icon i-Delete-File font-weight-bold"></i>
                                    </a>
                                    <a class="text-success mr-2" href="{{ route('livre.edit', ['id' => $item->id]) }}">
                                        <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                                                   
                </table>
            </div>
            @else
                <p>Aucun livre enregistrer !</p>
        @endif
    </div>
</div>
@endif

@if ($livre->chapitres->isNotEmpty())  <!-- Vérification plus explicite -->
<div class="card text-left">
    <div class="card-body">
        <h4 class="card-title mb-3">Les chapitres</h4>
        <div class="table-responsive">
            <table class="display table table-striped table-bordered" id="language_option_table" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Couverture</th>
                        <th scope="col">Titre</th>
                        <th scope="col">Prix (F CFA)</th>
                        <th scope="col">Type de publication</th>
                        <th scope="col">Taille</th>
                        <th scope="col">Fichier</th>
                        <th scope="col">Téléchargement</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($livre->chapitres as $key => $item)
                        @php
                            // Génération de l'URL temporaire si l'URL de l'image existe
                            $urlPath = !empty($item->path) ? Storage::disk('wasabi')->temporaryUrl($item->path, now()->addMinutes(20)) : null;
                            
                            $imgCover = !empty($livre->image_cover_url) ? Storage::disk('wasabi')->temporaryUrl($livre->image_cover_url, now()->addMinutes(20)) : null;
                            
                            // Formatage du montant
                            $nombre_formate = isset($livre->amount) ? number_format((float) $livre->amount, 0, '', ' ') : 'N/A';
                        @endphp
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                @if ($imgCover)
                                    <img src="{{ $imgCover }}" alt="Image" style="width:50px; height:auto;">
                                @else
                                    <span>Aucune couverture disponible</span>
                                @endif
                            </td>
                            <td>{{ $item->titre }}</td>
                            <td>{{ $nombre_formate }}</td>
                            <td>{{ $livre->type_publication->libelle }}</td>
                            <td>{{ $item->size ?? 'N/A' }}</td>
                            <td>
                                @if ($urlPath)
                                    <a href="{{ $urlPath }}" target="_blank">Écouter</a>
                                @else
                                    <span>Aucun fichier disponible</span>
                                @endif
                            </td>
                            <td>{{ $item->download ?? 0 }}</td>
                            <td style="display: inline-flex; border: none;">
                                <a class="text-danger mr-2" href="{{ route('livre.show', ['id' => $item->id]) }}">
                                    <i class="nav-icon i-Delete-File font-weight-bold"></i>
                                </a>
                                <a class="text-success mr-2" href="{{ route('livre.edit', ['id' => $item->id]) }}">
                                    <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif


@include('layouts.footer')