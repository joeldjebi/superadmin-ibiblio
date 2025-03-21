@include('layouts.header')
@include('layouts.menu')

@include('layouts.fileariane')


<section class="ul-product-detail">
    <div class="row">
       <div class="col-12">
          <div class="card">
             <div class="card-body">
                <div class="row">
                    @if (!empty($user->avatar))
                    @php
                        $avatarUrl = asset('storage/' . $user->avatar);
                    @endphp
                        <div class="col-lg-3">
                            <img src="http://192.168.1.11:8000/storage/{{ $user->avatar }}" alt="" class="w-100 p-4">
                        </div>
                    @endif
                   <div class="col-lg-9">
                      <div class="mb-4">
                         <h5 class="heading">{{ $user->nom }} {{ $user->prenoms }}</h5>
                         <span class="text-mute">Membre depuis: {{ (new DateTime($user->created_at))->format('d-m-Y à H:i:s') }}</span>
                      </div>
                      <div class="d-flex align-items-baseline">
                         <h3 class="font-weight-700 text-primary mb-0 me-2">{{ $user->wallet }} </h3>
                         <span class="text-mute font-weight-800 me-2"> Pièce(s)</span>
                      </div>
                      <div class="ul-product-detail__features mt-3">
                         <ul class="m-0 p-0">
                            <li class="d-flex align-items-center gap-1"><i class="i-Telephone text-primary text-15 align-middle font-weight-700"></i><span> {{ $user->indicatif }} {{ $user->mobile }}</span></li>
                            @if (!empty($user->email))
                                <li class="d-flex align-items-center gap-1"><i class="i-Email text-primary text-15 align-middle font-weight-700"></i> <span style="margin-left: 5px"> {{ $user->email }}</span></li>
                            @endif
                         </ul>
                      </div>
                      <button type="button" class="mt-3 btn btn-danger">Desactiver</button>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </section>

 <section>
    <div class="row">
       <div class="mt-4 text-center col-lg-3 col-md-6">
          <div class="card">
             <div class="card-body">
                <div class="ul-product-detail--icon mb-2">
                    <i class="i-Book text-success text-25 font-weight-500"></i>
                </div>
                <h5 class="heading">12</h5>
                <p class="text-muted text-13">Livre acheté</p>
             </div>
          </div>
       </div>
       <div class="mt-4 text-center col-lg-3 col-md-6">
          <div class="card">
             <div class="card-body">
                <div class="ul-product-detail--icon mb-2"><i class="i-Book text-danger text-25 font-weight-500"></i></div>
                <h5 class="heading">24</h5>
                <p class="text-muted text-13">Magazine acheté</p>
             </div>
          </div>
       </div>
       <div class="mt-4 text-center col-lg-3 col-md-6">
          <div class="card">
             <div class="card-body">
                <div class="ul-product-detail--icon mb-2"><i class="i-Music-Note-2 text-info text-25 font-weight-500"></i></div>
                <h5 class="heading">55</h5>
                <p class="text-muted text-13">Podcast acheté</p>
             </div>
          </div>
       </div>
       <div class="mt-4 text-center col-lg-3 col-md-6">
          <div class="card">
             <div class="card-body">
                <div class="ul-product-detail--icon mb-2"><i class="i-Next-Music text-warning text-25 font-weight-500"></i></div>
                <h5 class="heading">78</h5>
                <p class="text-muted text-13">Audio Book acheté</p>
             </div>
          </div>
       </div>
    </div>
 </section>

 


@include('layouts.footer')