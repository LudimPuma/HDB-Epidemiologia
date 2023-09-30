<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="shortcut icon"
      href="{{asset('assets/images/favicon.svg')}}"
      type="image/x-icon"
    />
    <title>Principal</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/lineicons.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/materialdesignicons.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/fullcalendar.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/js/sweetalert2/dist/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/datatables.net/dataTables.bootstrap4.min.css') }}">
    @stack('style')
  </head>
  <body>
    <!-- ======== sidebar-nav start =========== -->
    @include('menu')
    <div class="overlay"></div>
    <!-- ======== sidebar-nav end =========== -->

    <!-- ======== main-wrapper start =========== -->
    <main class="main-wrapper">
      <!-- ========== header start ========== -->
      <header class="header">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-5 col-md-5 col-6">
              <div class="header-left d-flex align-items-center">
                <div class="menu-toggle-btn mr-20">
                  <button
                    id="menu-toggle"
                    class="main-btn primary-btn btn-hover"
                  >
                    <i class="lni lni-chevron-left me-2"></i> Menu
                  </button>
                </div>
              </div>
            </div>
            <div class="col-lg-7 col-md-7 col-6">
              <div class="header-right">
                <!-- profile start -->
                <div class="profile-box ml-15">
                  <button
                    class="dropdown-toggle bg-transparent border-0"
                    type="button"
                    id="profile"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                  >
                    <div class="profile-info">
                      <div class="info">
                        <h6>{{ Auth::user()->persona->nombres }}</h6>
                        <div class="image">
                          {{-- <img
                            src="assets/images/profile/profile-image.png"
                            alt=""
                          /> --}}
                          <span class="status"></span>
                        </div>
                      </div>
                    </div>
                    <i class="lni lni-chevron-down"></i>
                  </button>
                  <ul
                    class="dropdown-menu dropdown-menu-end"
                    aria-labelledby="profile"
                  >
                    <li>
                      <a href="#" data-bs-toggle="modal" data-bs-target="#modalPerfil">
                        <i class="lni lni-user"></i> Perfil
                      </a>
                    </li>

                    <li>
                      <a href="{{route('logout')}}"> <i class="lni lni-exit"></i> Cerrar Sesion </a>
                    </li>
                  </ul>
                </div>
                <!-- profile end -->
              </div>
            </div>
          </div>
        </div>
      </header>
      <!-- ========== header end ========== -->

      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                {{-- <h2 style="text-align: center">Bienvenido: {{ Auth::user()->persona->nombres }}</h2> --}}
              <!-- end col -->
            </div>
            <!-- end row -->
          </div>
          <!-- ========== title-wrapper end ========== -->
          <div class="row">
            @yield('content')
          </div>
          <!-- End Row -->
        </div>
        <!-- end container -->
      </section>
      <!-- ========== section end ========== -->

      <!-- ========== footer start =========== -->
      <footer class="footer">
        <div class="container-fluid">
          <div class="row">
            <div class="order-last order-md-first">
              <div class="copyright text-center text-md-start">
                <p class="text-sm" >
                  2023
                  <a
                    href="https://www.facebook.com/profile.php?id=100063500984665&locale=es_LA"
                    rel="nofollow"
                    target="_blank"
                  >
                  Hospital Daniel Bracamonte
                  </a>
                  - developed by:
                  <a href="mailto:ludimpuma1@gmail.com">ludimpuma1@gmail.com</a>
                  Contact us
                  <a href="https://wa.me/77474525">+591 77474525</a>

                </p>
              </div>
            </div>
            <!-- end col-->

          </div>
          <!-- end row -->
        </div>
        <!-- end container -->
      </footer>
      <!-- ========== footer end =========== -->
    </main>
    <!-- ======== main-wrapper end =========== -->

<!-- Modal de perfil -->
<div class="modal fade" id="modalPerfil" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Perfil de usuario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <!-- Agrega aquí el contenido del perfil -->
          <p>Nombres de usuario: {{ Auth::user()->persona->nombres }}</p>
          <p>Apellidos de usuario: {{ Auth::user()->persona->apellidos }}</p>
          <p>Correo electrónico: {{ Auth::user()->email }}</p>
          <p>Profesion: {{ Auth::user()->profesion }}</p>
          <!-- Puedes personalizar el contenido del perfil según tus necesidades -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
</div>





    <!-- ========= All Javascript files linkup ======== -->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/Chart.min.js"></script>
    <script src="assets/js/dynamic-pie-chart.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/fullcalendar.js"></script>
    <script src="assets/js/jvectormap.min.js"></script>
    <script src="assets/js/world-merc.js"></script>
    <script src="assets/js/polyfill.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="assets/js/datatables.net/jquery.dataTables.min.js"> </script>
    <script src="assets/js/datatables.net/dataTables.bootstrap4.min.js"> </script>
    @stack('script')
  </body>
</html>
