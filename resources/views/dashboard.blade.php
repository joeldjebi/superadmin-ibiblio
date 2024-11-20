@include('layouts.header')
@include('layouts.menu')

@include('layouts.fileariane')

      <div class="row">
         <!-- ICON BG-->
         <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
               <div class="card-body text-center">
                  <i class="i-Add-User"></i>
                  <div class="content">
                     <p class="text-muted mt-2 mb-0">Utilisateurs</p>
                     <p class="text-primary text-24 line-height-1 mb-2">205</p>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
               <div class="card-body text-center">
                  <i class="i-Financial"></i>
                  <div class="content">
                     <p class="text-muted mt-2 mb-0">Les livres achetés</p>
                     <p class="text-primary text-24 line-height-1 mb-2">4021</p>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
               <div class="card-body text-center">
                  <i class="i-Checkout-Basket"></i>
                  <div class="content">
                     <p class="text-muted mt-2 mb-0">Livres</p>
                     <p class="text-primary text-24 line-height-1 mb-2">80</p>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
               <div class="card-body text-center">
                  <i class="i-Money-2"></i>
                  <div class="content">
                     <p class="text-muted mt-2 mb-0">Abonnements</p>
                     <p class="text-primary text-24 line-height-1 mb-2">1200</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-lg-8 col-md-12">
            <div class="card mb-4">
               <div class="card-body">
                  <div class="card-title">Ventes de cette année</div>
                  <div id="echartBar" style="height: 300px"></div>
               </div>
            </div>
         </div>
         <div class="col-lg-4 col-sm-12">
            <div class="card mb-4">
               <div class="card-body">
                  <div class="card-title">Ventes par pays</div>
                  <div id="echartPie" style="height: 300px"></div>
               </div>
            </div>
         </div>
      </div>


@include('layouts.footer')