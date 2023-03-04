<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <link href="/img/favicon.png" rel="icon">
    <link href="/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

<!-- Vendor CSS Files -->
    <link href="/vendor/aos/aos.css" rel="stylesheet">
    <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="/vendor/simple-datatables/style.css" rel="stylesheet">

<!-- Template Main CSS File -->
    <link href="/css/style.css" rel="stylesheet">

    <script src="/js/jquery.min.js"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    
    @livewireStyles
    @livewireScripts
</head>

<body>
  <div class="container" id="load" style="display: none" >
    <div class="row d-flex justify-content-center" >
        <div class="col-md-3 col-sm-6" style="position: absolute;margin-top:20%">
            <div class="progress blue">
                <span class="progress-left">
                    <span class="progress-bar"></span>
                </span>
                <span class="progress-right">
                    <span class="progress-bar"></span>
                </span>
                <div class="inner-circle"></div>
                <div class="progress-value"><span>90</span>%</div>
            </div>
        </div> 
    </div>
  </div>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        {{--<img src="/img/logo5.png" alt="">--}}
        <h2 class="text-white">Chat</h2>
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
                $status = App\Models\StatusMessage::where('user_id',Auth::user()->id)->where('admin_message_id',json_decode($admin_message->data)->tradingMessage->id)->first();
            @endphp
            <li class="message-item notification {{($status!==NULL)? 'notif-color-true':'notif-color'}}" id="notif-top{{$key}}" data-id="{{$key}}" data-notif="{{$admin_message->id}}">
              <a  class="markAsRead" data-user="{{$admin_message->notifiable_id}}" data-notification="{{$admin_message->id}}" href="#">
                <div>  
                  @if (strlen(json_decode($admin_message->data)->tradingMessage->message)>30)
                  <p>{{substr(json_decode($admin_message->data)->tradingMessage->message, 0, 30)}}...</p>
                  @else
                  <p>{{substr(json_decode($admin_message->data)->tradingMessage->message, 0, strlen(json_decode($admin_message->data)->tradingMessage->message))}}</p>
                  @endif
                  <p>{{date("Y-m-d H:i", strtotime(json_decode($admin_message->data)->tradingMessage->created_at))}}</p>
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
              <a href="{{route('messages')}}">Todas mensagens</a>
            </li>

          </ul><!-- End Messages Dropdown Items -->

        </li><!-- End Messages Nav -->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="/img/profile/" alt="Foto" class="rounded-circle">
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
        <a class="nav-link collapsed" {{--id="nav-sider"--}}  href="{{route('home')}}">
          <i class="bi bi-person"></i><span>Página inicial</span>
        </a>
        
      </li><!-- End Components Nav -->

      <li class="nav-item">
        <a class="nav-link" href="{{route('messages')}}">
          <i class="bi bi-chat-right-text"></i>
          <span>Mensagens</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" {{--id="nav-sider"--}} style="cursor: pointer" href="{{route('list')}}" >
          <i class="bi bi-list"></i><span>Lista de utilizadores</span>
        </a>
      </li>

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

    <div class="pagetitle">
      <h1>Olá, {{Auth::user()->name}}</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a> \ @yield('path_route')</li>
         
        </ol>
      </nav>
    </div><!-- End Page Title -->


    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        @yield('content')
        <!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">         

        </div><!-- End Right side columns -->

      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>Baikaseguro</span></strong>.Todos direitos reservados
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="#">AppleWeb</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


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

  <script>
    
    function modalUpdateProfile() {
      var modal = document.getElementById('exampleModal2')
      let modalBox = new bootstrap.Modal(modal);
      modalBox.show();
    }
    
    function photo_profile(){
      var modal = document.getElementById('exampleModal4')
      let modalBox = new bootstrap.Modal(modal);
      modalBox.show();
    }

  </script>
  <script>
      $(document).ready(function(){
        $("#search").on("keyup", function() {
          var value = $(this).val().toLowerCase();
          $("#myTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
          });
        });
      });

      $("#myTabl").DataTable({
        //searching: false,
        language: {
            lengthMenu: 'Mostrando _MENU_ registros por página',
            zeroRecords: 'Nenhum dado encontrado',
            info: 'Mostrando página _PAGE_ de _PAGES_',
            infoEmpty: 'Nenhum registro disponível',
            infoFiltered: '(filtrado de _MAX_ registro total)',
            search: 'Pesquisar',
            paginate:{
              previous: 'Anterior',
              next: 'Próximo',
            }
        },
        initComplete: function () {
          $('.dataTables_filter input[type="search"]').css({ 'width': '400px', 'display': 'block','border-radius':'20px' });
        }
      });

      
  </script>
  <script>
    
    /*$(window).on('load',function() {
      let load = document.getElementById("load");
      load.style.display="block";
    });*/
  </script>
  <script>
    $(document).ready(function(){
      $('.progress-value > span').each(function(){
          $(this).prop('Counter',0).animate({
              Counter: $(this).text()
          },{
              duration: 3500,
              easing: 'swing',
              step: function (now){
                  $(this).text(Math.ceil(now));
              }
          });
      });
    });
  </script>
</body>

</html>