@extends('layouts.auth')

@section('title', 'Login')

@section('content') 

    <div class="container">

        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
  
                <div class="card mb-3">
  
                  <div class="card-body">
  
                    <div class="pt-4 pb-2">
                      <h5 class="card-title text-center pb-0 fs-4">Login</h5>
                    </div>

                    @if (Session::get('success'))
                        <div class="mb-4 font-medium text-white text-center text-green-600 bg-success rounded">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    @if (Session::get('fail'))
                        <div class="mb-4 font-medium text-white text-center bg-danger rounded p-2">
                            {{ Session::get('fail') }}
                        </div>
                    @endif
  
                    <form class="row g-3 needs-validation" method="POST" action="{{ route('auth') }}" novalidate>
                        @csrf
                      <div class="col-12">
                       
                        <div class="input-group has-validation">
                          
                          <input type="text" name="email" placeholder="Email" class="form-control" value="{{old('email')}}" id="email" required />
                          <div class="invalid-feedback">Email inválido</div>
                        {{--<span class="text-danger">@error('email'){{$message}}@enderror</span>--}}
                        </div>
                      </div>
  
                      <div class="col-12">
                        
                        <input type="password" name="password" placeholder="Palavra passe" class="form-control" value="{{old('password')}}" id="password" required />
                        <div class="invalid-feedback">Por favor insira a senha!</div>
                        {{--<span class="text-danger">@error('password'){{$message}}@enderror</span>--}}
                      </div>

  
                      <div class="col-12">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                          <label class="form-check-label" for="rememberMe">Lembrar senha</label>
                        </div>
                      </div>
                      <div class="col-12">
                        <button class="btn btn-primary w-100" type="submit">Entrar</button>
                      </div>
                      <div class="col-12">
                        <p class="small mb-0">Não tem uma conta? <a href="{{route('register')}}">Criar conta</a></p>
                      </div>
                    </form>
  
                  </div>
                </div>

              </div>
            </div>
          </div>
  
        </section>
  
    </div>
@endsection