<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <link href="/vendor/aos/aos.css" rel="stylesheet">
        <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
        <link href="/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
        <link href="/vendor/quill/quill.snow.css" rel="stylesheet">
        <link href="/vendor/quill/quill.bubble.css" rel="stylesheet">
        <link href="/vendor/remixicon/remixicon.css" rel="stylesheet">
        <link href="/vendor/simple-datatables/style.css" rel="stylesheet">

        <link href="/css/style.css" rel="stylesheet">
        <title>Baika Seguro - Marketplace Chat</title>
        <script src="/js/jquery.min.js"></script>
        <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
        
        @livewireStyles
        @livewireScripts
    </head>
    <body>
        <!-- ======= Header ======= -->
        <header id="header" class="header fixed-top d-flex align-items-center">

            <div class="d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">
                {{--<img src="/img/logo5.png" alt="">--}}
                <img src="/img/logo branco.png" alt="">
                {{--<span class="d-none d-lg-block" style="font-family: Georgia, serif">Baikaseguro</span>--}}
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
            </div><!-- End Logo -->



            <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-search"></i>
                </a>
                </li><!-- End Search Icon-->

                <li class="nav-item dropdown">

                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-chat-left-text"></i>
                    <span class="badge bg-success badge-number" id="notif-count1">{{count(App\Models\Notification::where('type','App\Notifications\NotifyMessage')->/*where('status',false)->*/where('read_at',null)->get()) - count(App\Models\StatusMessage::where('user_id',Auth::user()->id)->get())}}</span>
                </a><!-- End Messages Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
                    <li class="dropdown-header" id="notif-count2">
                    {{App\Models\Notification::where('type','App\Notifications\NotifyMessage')->/*where('status',false)->*/where('read_at',null)->count() - count(App\Models\StatusMessage::where('user_id',Auth::user()->id)->get())}} mensagens não lidas
                    </li>
                    <li>
                    <hr class="dropdown-divider">
                    </li>
                    @foreach (App\Models\Notification::where('type','App\Notifications\NotifyMessage')->where('read_at',null)->get() as $key=>$admin_message)
                    @if ($admin_message->type=='App\Notifications\NotifyMessage')
                    @php
                        $status = App\Models\StatusMessage::where('user_id',Auth::user()->id)->where('admin_message_id',json_decode($admin_message->data)->adminMessage->id)->first();
                    @endphp
                    <li class="message-item notification {{($status!==NULL)? 'notif-color-true':'notif-color'}}" id="notif-top{{$key}}" data-id="{{$key}}" data-notif="{{$admin_message->id}}">
                    <a  class="markAsRead" data-user="{{$admin_message->notifiable_id}}" data-notification="{{$admin_message->id}}" href="#">
                        <div>  
                        @if (strlen(json_decode($admin_message->data)->adminMessage->message)>30)
                        <p>{{substr(json_decode($admin_message->data)->adminMessage->message, 0, 30)}}...</p>
                        @else
                        <p>{{substr(json_decode($admin_message->data)->adminMessage->message, 0, strlen(json_decode($admin_message->data)->adminMessage->message))}}</p>
                        @endif
                        <p>{{date("Y-m-d H:i", strtotime(json_decode($admin_message->data)->adminMessage->created_at))}}</p>
                        </div>
                    </a>
                    </li>
                    <li>
                    <hr class="dropdown-divider">
                    </li>
                        
                    @endif 
                    @endforeach
                    <li>
                    <hr class="dropdown-divider">
                    </li>

                    <li class="dropdown-footer">
                    <a href="{{route('notificacoes')}}">Todas Notificações</a>
                    </li>

                </ul><!-- End Messages Dropdown Items -->

                </li><!-- End Messages Nav -->

                <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    @if (Auth::user()->class == 'nt' && Auth::user()->national_user!=NULL)
                    <img src="/img/profile/{{Auth::user()->national_user->photo}}" alt="Foto" class="rounded-circle">

                    @else
                    @if (Auth::user()->class == 'fg' && Auth::user()->foreign_user!=NULL)
                    <img src="/img/profile/{{Auth::user()->foreign_user->photo}}" alt="Foto" class="rounded-circle">
                    @else
                        @if (Auth::user()->class == 'cp' && Auth::user()->company_user!=NULL)
                        <img src="/img/profile/{{Auth::user()->company_user->photo}}" alt="Foto" class="rounded-circle">

                        @endif
                    @endif   
                    @endif
                    <span class="d-none d-md-block dropdown-toggle ps-2 text-white">{{Auth::user()->name}}</span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{Auth::user()->name}}</h6>
                        <span>
                            @if (Auth::user()->type == 'admin')
                                Admistrador
                                
                            @else
                                @if (Auth::user()->type == 'edit')
                                    Gestor de conteúdo
                                @else
                                    
                                @endif
                            @endif
                        </span>
                    </li>
                    <li>
                    <hr class="dropdown-divider">
                    </li>

                    <li>
                    <a class="dropdown-item d-flex align-items-center" style="cursor: pointer" onclick="photo_profile()">
                        <i class="bi bi-person"></i>
                        <span>Foto de perfil</span>
                    </a>
                    </li>
                    <li>
                    <hr class="dropdown-divider">
                    </li>
                    <li>
                    <a class="dropdown-item d-flex align-items-center" style="cursor: pointer" onclick="changePassword()">
                        <i class="bi bi-key"></i>
                        <span>Trocar Senha</span>
                    </a>
                    </li>
                    <li>
                    <hr class="dropdown-divider">
                    </li>
                    
                    <li>
                    <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                        <i class="bi bi-gear"></i>
                        <span>Configuração da conta</span>
                    </a>
                    </li>
                    <li>
                    <hr class="dropdown-divider">
                    </li>

                    <li>
                    <a class="dropdown-item d-flex align-items-center" style="cursor: pointer" 
                        href="{{route('logout')}}" 
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"
                    >
                        <i class="bi bi-box-arrow-right"></i>
                        <span 
                            >
                            sair
                        </span>
                    </a>
                    <form id="logout-form" action="{{route('logout')}}" method="post" style="display: none">@csrf</form>
                    </li>
                </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
            </nav><!-- End Icons Navigation -->

        </header><!-- End Header -->

        <!-- ======= Sidebar ======= -->
        <aside id="sidebar" class="sidebar">

            <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link collapsed" {{--id="nav-sider"--}}  href="{{route('minha-conta')}}">
                <i class="bi bi-person"></i><span>Página inicial</span>
                </a>
                
            </li><!-- End Components Nav -->
            <li class="nav-item">
                <a class="nav-link collapsed" {{--id="nav-sider"--}} style="cursor: pointer" onclick="modalUpdateProfile()">
                <i class="ri-user-settings-line"></i><span>Atualizar Perfil</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" {{--id="nav-sider"--}} style="cursor: pointer" onclick="modalAddPhone()">
                <i class="ri-shield-cross-fill"></i><span>Adicionar Telemóvel</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" {{--id="nav-sider"--}} style="cursor: pointer" href="{{route('meus-telemoveis')}}">
                <i class="ri-phone-fill"></i><span>Meus Telemóveis</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" {{--id="nav-sider"--}} style="cursor: pointer" href="{{route('minhas-denuncias')}}">
                <i class="ri-customer-service-fill"></i><span>Minhas Denúncias</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" {{--id="nav-sider"--}} style="cursor: pointer" href="{{route('minhas-publicacoes')}}">
                <i class="bi bi-book-half"></i><span>Minhas Publicações</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('mensagem-compra')}}">
                <i class="bi bi-chat-right-text"></i>
                <span>Mensagem</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" {{--id="nav-sider"--}} style="cursor: pointer" href="{{route('marketplace')}}" >
                <i class="bi bi-shop"></i><span>Marketplace</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" {{--id="nav-sider"--}} style="cursor: pointer" href="{{route('lista-planos')}}" >
                <i class="bi bi-pen"></i><span>Planos</span>
                </a>
            </li>
            @can ('is_agents')
            <li class="nav-item">
                <a class="nav-link collapsed" {{--id="nav-sider"--}} style="cursor: pointer" onclick="addUser()">
                <i class="bi bi-person-plus-fill"></i><span>Cadastrar clientes</span>
                </a>
            </li>   
            @endcan
            <li class="nav-item" >     
                <form action="/logout" method="post">
                    @csrf
                    <a href="/logout"
                        onclick="event.preventDefault();
                        this.closest('form').submit();"
                        class="nav-link collapsed"
                        {{--id="nav-sider2"--}}
                    >
                        <i class="ri-logout-box-r-line"></i>
                        <span>Sair</span>
                    </a>
                </form>      
            </li>
            
            </ul>

        </aside><!-- End Sidebar-->

        <main id="main" class="main" {{--style="background: rgb(235, 162, 190)"--}}>
            <section class="section dashboard">
                <div class="row">
                    @yield('content')
                </div>
            </section>  
        </main>
        
        <!-- Vendor JS Files -->
        <script src="/js/jquery.min.js"></script>
        <script src="/vendor/aos/aos.js"></script>

        <script src="/vendor/apexcharts/apexcharts.min.js"></script>
        <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/vendor/chart.js/chart.min.js"></script>
        <script src="/vendor/echarts/echarts.min.js"></script>
        <script src="/vendor/quill/quill.min.js"></script>
        <script src="/vendor/simple-datatables/simple-datatables.js"></script>
        <script src="/vendor/tinymce/tinymce.min.js"></script>
        <script src="/vendor/php-email-form/validate.js"></script>
        
        <script src="/vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>

        <!-- Template Main JS File -->
        <script src="/js/main.js"></script>
        <script src="/js/profile.js"></script>
        <script src="/js/jquery.mask.min.js"></script>

    </body>
</html>