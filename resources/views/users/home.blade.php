@extends('layouts.app')

@section('title', 'Pagina Inicial')
@section('path_route', '')

@section('content')
<div class="col-lg-12">
    <div class="row">

      <!-- Sales Card -->
      
      <div class="col-xxl-4 col-md-6">
        <a style="cursor: pointer" onclick="modalUpdateProfile()">
        <div class="card info-card sales-card card-back-color" >

          <div class="filter"> 
          </div>

          <div class="card-body">
            <h5 class="card-title"></h5>

            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="ri-user-settings-line"></i>
              </div>
              <div class="ps-3">
                <h6 class="text-white">Atualizar Perfil</h6>
                
              </div>
            </div>
          </div>

        </div>
        </a>
      </div><!-- End Sales Card -->

<div class="col-xxl-4 col-md-6">
  <form action="/logout" method="post">
    @csrf
    <a href="/logout"
      onclick="event.preventDefault();
      this.closest('form').submit();"
    >
    <div class="card info-card revenue-card card-back-color">

      <div class="filter">
      </div>

      <div class="card-body">
        <h5 class="card-title"></span></h5>

        <div class="d-flex align-items-center">
          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
            <i class="ri-share-forward-2-fill"></i>
            
          </div>
          <div class="ps-3">
            <h6 class="text-white">Sair</h6>
          </div>
        </div>
      </div>
    </div>
    </a>
  </form>
</div><!-- End Revenue Card -->

@can('is_agents')
<!-- Revenue Card -->
<div class="col-xxl-4 col-md-6">
  <a style="cursor: pointer" id="addPhone" onclick="addUser()">
  <div class="card info-card revenue-card card-back-color">

    <div class="filter">

    </div>

    <div class="card-body">
      <h5 class="card-title"></span></h5>

      <div class="d-flex align-items-center">
        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
          <i class="ri-shield-cross-fill"></i>
          
        </div>
        <div class="ps-3">
          <h6 class="text-white">Cadastrar clientes</h6>
        </div>
      </div>
    </div>

  </div>
  </a>
</div><!-- End Revenue Card -->   
@endcan
 
    </div>
  </div>

@endsection