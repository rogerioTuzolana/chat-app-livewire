@extends('layouts.auth')

@section('title', 'Registrar')

@section('content')

    <div class="container">

        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-lg-9 col-md-6 d-flex flex-column align-items-center justify-content-center">
  
                <div class="card mb-3">
  
                  <div class="card-body mb-12">
  
                    <div class="pt-4 pb-2">
                      
                      <h5 class="card-title text-center pb-0 fs-4">Criar Conta</h5>
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

                    <form method="POST" action="{{ route('create') }}" class="row g-3 needs-validation" novalidate>
                        @csrf
                        <div class="row mt-3">
                            <div class="col-lg-6 col-xs-12 group-national">
                                <label for="bi" >{{ __('Bilhete de identidade') }}</label>
                                <input type="text" name="bi" class="form-control" size="14" minlength="14" maxlength="14" id="bi" placeholder="Número do Bilhete" value="{{old('bi')}}" required>
                                <div class="invalid-feedback">Porfavor digite o número do seu Bilhete</div>
                                {{--<span class="text-danger">@error('bi'){{$message}}@enderror</span>--}}
                            </div>
                            <div class="col-lg-6 col-xs-12 group-foreign">
                                <label for="passport_number" >{{ __('Passaporte') }}</label>
                                <input id="passport_number" class="form-control" placeholder="Passaporte" type="text" name="passport_number" value="{{old('passport_number')}}" required />
                                <div class="invalid-feedback">Porfavor digite o número do seu passaporte</div>
                            </div>
                            <div class="col-lg-6 col-xs-12">
                                <label for="name" >{{ __('Nome') }}</label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="Nome" required>
                                <div class="invalid-feedback">Por favor, digite o nome!</div>
                            </div>
                            <div class="col-lg-6 col-xs-12 group-foreign">
                                <label for="nationality" >{{ __('Nacionalidade') }}</label>
                                <input id="nationality" class="form-control" placeholder="Nacionalidade" type="text" name="nationality" value="{{old('nationality')}}" required />
                                <div class="invalid-feedback">Por favor, digite a nacionalidade!</div>
                            </div>
                            <div class="col-lg-6 col-xs-12 group-company">
                                <label for="nif">{{ __('NIF') }}</label>
                                <input id="nif" class="form-control" type="text" name="nif" value="{{old('nif')}}" required />
                                <span class="text-danger">@error('nif'){{$message}}@enderror</span>
                            </div>
                        </div>
        
                        <div class="row">
                            <div class="col-lg-6 col-xs-12">
                                <label for="enail" >{{ __('Email') }}</label>
                                <input type="email" name="email" class="form-control" id="email" placeholder="Email" required>
                                <div class="invalid-feedback">Por favor digite email válido!</div>
                            </div>
                            <div class="col-lg-6 col-xs-12">
                                <label for="class" >{{ __('Tipo de utilizador') }}</label>
                                <select class="form-control" name="class" id="class">
                                    <option value="nt">Nacional</option>
                                    <option value="fg">Estrangeiro</option>
                                    <option value="cp">Empresa</option>      
                                </select>
                            </div>
                        </div>
                      
                        <div class="row">
                            <div class="col-lg-6 col-xs-12 group-foreign_national">
                                <label for="gender" >{{ __('Gênero') }}</label>
                                <select name="gender" id="gender" class="form-control">
                                    <option value="F">Femenino</option>
                                    <option value="M">Masculino</option>
                                </select>
                            </div>
                            <div class="col-lg-6 col-xs-12 group-foreign_national">
                                <label for="date" >{{ __('Data de nascimento') }}</label>
                                <input type="date" name="birth_date" class="form-control datepicker" id="birth_date" required>
                                <div class="invalid-feedback">Por favor insirá a data!</div>
                            </div>
                        </div>
                      
                      
                      {{--<div class="col-6">
                       
                        <input type="numero" name="phone" class="form-control" id="yourEmail" placeholder="Telefone" required>
                        <div class="invalid-feedback">Please enter a valid Email adddress!</div>
                      </div>--}}
                      
                    <div class="row">
                        <div class="col-lg-6 col-xs-12">
                            <label for="password" >{{ __('Senha') }}</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="password" required>
                            <div class="invalid-feedback">Por favor insirá senha!</div>
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <label for="cpassword" >{{ __('Confirmar senha') }}</label>
                            <input type="password" name="cpassword" class="form-control" id="cpassword" placeholder="Confirmar senha" required>
                            <div class="invalid-feedback">Por favor insirá senha correta!</div>
                        </div>
                    </div>
                      
                    <div class="row">
                        
                        <div class="col-lg-6 col-xs-12">
                            <label for="location" class="form-label">Endereço actual</label>
                            <input type="text" name="location" class="form-control" id="location" required>
                            <div class="invalid-feedback">Por favor digite o endereço!</div>
                        </div>
                    </div> 
            
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" name="terms" type="checkbox" value="" id="acceptTerms" required>
                            <label class="form-check-label" for="acceptTerms">Eu aceito<a href="#"> Termos de serviço </a></label>
                            <div class="invalid-feedback">Eu aceito Termos de serviço.</div>
                        </div>
                        <div class="row">
                            <a href="{{route('login')}}" class="ml-4">Tenho conta </a>
                        </div>
                    </div>

                    <div class="col-12">
                        <button class="btn btn-primary w-100" type="submit">Cadastar</button>
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
