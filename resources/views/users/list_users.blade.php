@extends('layouts.app')

@section('title', 'Lista de utilizadores')
@section('path_route', 'Lista-utilizadores')

@section('content')

<main role="main">
    <div class="album py-5 bg-light">
      <div class="container">
        <div class="row mb-3">
            <form action="{{route('list')}}" method="GET">
                <input class="form-control rounded-pill" name="search" id="search" type="text" placeholder="Procurar..">
            </form>
        </div>
        @foreach ($users as $user)
        @if ($user->id != Auth::user()->id)
        
        <a class="" href="{{route('chat',[Crypt::encryptString($user->id)])}}">  
        <div class="row">
          <div class="card-group ">
            <div class="card mb-3 box-shadow">
              <div class="card-body text-center">
                <div class="d-flex mt-4">
                  <h6>{{$user->name}}</h6> 
                </div>
              </div>
            </div>
          </div>
        </div>
        </a>  
            
        @endif
        @endforeach
      </div>
        {{--@if (count($sell_phones) == 0 && $search)
          <div class="row">
            <div class="text-center">a
              <p style="font-size: 18px">Telemóvel não encontrado <a href="{{route('marketplace')}}"><b>Ver todos</b></></p>
            </div>
          </div>
        @endif--}}
    </div>
    <div class="d-flex">
        <div class="align-self-center mx-auto">
          {{--$sell_phones->appends(['search'=>isset($search)?$search:''])->links()--}}
        </div>
    </div>
</main>

@endsection