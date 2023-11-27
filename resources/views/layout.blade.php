<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    {{-- <link
      rel="shortcut icon"
      href="{{asset('assets/images/favicon.svg')}}"
      type="image/x-icon"
    /> --}}
    <link
      rel="shortcut icon"
      href="{{asset('img/logo.png')}}"
      type="image/x-icon"
    />
    <title>@yield('title', 'Principal')</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/lineicons.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/materialdesignicons.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/fullcalendar.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/js/sweetalert2/dist/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/datatables.net/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/select2-bootstrap-5-theme.rtl.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/select2-bootstrap-5-theme.min.css')}}" />
    {{-- <link rel="stylesheet" href="{{asset('css/report.scss')}}" /> --}}

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
        <header class="header shadow-lg">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-5 col-md-5 col-6">
                    <div class="header-left d-flex align-items-center">
                        <div class="menu-toggle-btn mr-20">
                        <button
                            id="menu-toggle"
                            {{-- class="main-btn success-btn btn-hover" --}}
                            class="main-btn btn btn-success"
                        >
                            <i class="lni lni-chevron-left me-2"></i> Menu
                        </button>

                        </div>
                    </div>
                    </div>
                    {{-- <div class="col-lg-7 col-md-7 col-6">
                    <div class="header-right">
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
                                <div style="display: flex; flex-direction: column; align-items: center;">
                                    <p class="text-muted"><strong>{{ Auth::user()->persona->nombres}} {{ Auth::user()->persona->apellidos}}</strong></p>
                                    <h6 class="text-muted"> <small><em>({{ Auth::user()->roles->first()->name }})</em></small></strong></h6>
                                </div>
                                <div class="image">
                                <img src="{{ asset('storage/' . Auth::user()->imagen) }}" alt="Foto de perfil" >
                                <span class="status"></span>
                                </div>
                            </div>
                            </div>
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
                    </div>
                    </div> --}}
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
                                <div style="display: flex; flex-direction: column; align-items: center;">
                                    <!-- Nombre y apellido para pantallas grandes -->
                                    <p class="text-muted d-none d-md-block"><strong>{{ Auth::user()->persona->nombres}} {{ Auth::user()->persona->apellidos}}</strong></p>
                                    <!-- Rol para pantallas grandes -->
                                    <h6 class="text-muted d-none d-md-block"> <small><em>({{ Auth::user()->roles->first()->name }})</em></small></h6>
                                </div>
                                <div class="image">
                                    <img src="{{ asset('storage/' . Auth::user()->imagen) }}" alt="Foto de perfil">
                                    <span class="status"></span>
                                </div>
                                </div>
                            </div>
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
                                <a href="{{route('logout')}}"> <i class="lni lni-exit"></i> Cerrar Sesión </a>
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
      <section class="section ">
        <div class="container-fluid ">
            <!-- ========== title-wrapper start ========== -->
            <div class="row">
                <div class="title-wrapper pt-20 ">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="title mb-20">
                                <h4 class="text-muted d-none d-md-block">@yield('guide', 'Principal/')</h4>
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class="breadcrumb-wrapper mb-20 ">
                                <nav aria-label="breadcrumb">
                                    <input type="date" value="{{ date('Y-m-d') }}" class="form-control bg-success ml-3 shadow-lg">
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

          <!-- ========== title-wrapper end ========== -->
          <div class="row ">
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
                            <p class="text-sm">
                                2023
                                <a href="https://www.facebook.com/profile.php?id=100063500984665&locale=es_LA" rel="nofollow" target="_blank">
                                    Hospital Daniel Bracamonte
                                </a>
                                - Unidad de Informatica y Sistemas.
                                <span class="float-end text-end"> <!-- Alinea a la derecha -->
                                    Developed by:
                                    <svg width="14" height="14" fill="#D14836" class="bi bi-envelope" viewBox="0 0 16 16" style="position: relative; top: -2px;">
                                        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
                                    </svg>
                                    <a href="mailto:ludimpuma1@gmail.com" target="_blank">ludimpuma1@gmail.com</a>
                                    Contact us:
                                    <svg width="14" height="14" fill="#25D366" class="bi bi-whatsapp" viewBox="0 0 16 16" style="position: relative; top: -3px;">
                                        <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.920l-.240-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.480 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                                    </svg>
                                    <a href="https://wa.me/77474525" target="_blank">77474525</a>
                                </span>
                            </p>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </footer>
      {{-- <footer class="footer">
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
                  - Unidad de Informatica y Sistemas.
                  Developed by:
                  <a href="mailto:ludimpuma1@gmail.com">ludimpuma1@gmail.com</a>
                  Contact us
                  <a href="https://wa.me/">+591 </a>

                </p>
              </div>
            </div>
            <!-- end col-->

          </div>
          <!-- end row -->
        </div>
        <!-- end container -->
      </footer> --}}
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
                <div class="text-center">
                    <img src="{{ asset('storage/' . Auth::user()->imagen) }}" alt="Foto de perfil" class="rounded-circle border border-dark" style="width: 100px; height: 100px;">
                </div>
                <br>
                <ul class="list-group">
                    <li class="list-group-item"><strong>Nombre(s):</strong> {{ Auth::user()->persona->nombres }}</li>
                    <li class="list-group-item"><strong>Apellido(s):</strong> {{ Auth::user()->persona->apellidos }}</li>
                    <li class="list-group-item"><strong>Correo electrónico:</strong> {{ Auth::user()->email }}</li>
                    <li class="list-group-item"><strong>Grado Academico:</strong> {{ Auth::user()->profesion }}</li>
                    <li class="list-group-item"><strong>Rol:</strong> {{ Auth::user()->roles->first()->name }}</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>






    <!-- ========= All Javascript files linkup ======== -->

    <script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/js/Chart.min.js')}}"></script>
    <script src="{{asset('assets/js/dynamic-pie-chart.js')}}"></script>
    <script src="{{asset('assets/js/moment.min.js')}}"></script>
    <script src="{{asset('assets/js/fullcalendar.js')}}"></script>
    <script src="{{asset('assets/js/jvectormap.min.js')}}"></script>
    <script src="{{asset('assets/js/world-merc.js')}}"></script>
    <script src="{{asset('assets/js/polyfill.js')}}"></script>
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script src="{{asset('assets/js/sweetalert2/dist/sweetalert2.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables.net/jquery.dataTables.min.js')}}"> </script>
    <script src="{{asset('assets/js/datatables.net/dataTables.bootstrap4.min.js')}}"> </script>

    <script src="{{ asset('js/select2.min.js') }}"></script>
    {{-- DATA TABLE CONFIG --}}
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable({
                "paging": true, // Activar paginación
                "searching": true, // Activar búsqueda
                "lengthChange": true, // Cambiar cantidad de resultados por página
                "pageLength": 10, // Cantidad de resultados por página
                "ordering": false // Desactivar la ordenación de la tabla
            });
        });
    </script>
    {{-- VALIDACIONES --}}
    {{-- <script>
        $(document).ready(function() {
            var errorMessage = "Caracteres no permitidos.";
            var patternRegex = /^[A-Za-zÀ-ÖØ-öø-ÿ\s.\-()\d]+$/;

            $("input, textarea").on("input", function() {
                var hasError = !patternRegex.test($(this).val());

                if (typeof this.setCustomValidity === "function") {
                    this.setCustomValidity(hasError ? errorMessage : "");
                } else {
                    $(this).toggleClass("error", hasError);
                    $(this).toggleClass("ok", !hasError);

                    if (hasError) {
                        $(this).attr("title", errorMessage);
                    } else {
                        $(this).removeAttr("title");
                    }
                }
            });
        });
    </script> --}}
    {{-- MENU --}}

    {{-- <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Recuperar el estado del menú desde la cookie
            var menuState = getCookie("menuState");

            // Si hay un estado en la cookie, aplicarlo al menú
            if (menuState) {
                $(menuState).collapse("show");
            }

            // Manejar eventos de clic para guardar el estado en la cookie
            $(".collapsed").on("click", function () {
                var menuId = $(this).data("bs-target");
                setCookie("menuState", menuId);
            });
        });

        // Funciones para gestionar cookies
        function setCookie(name, value) {
            document.cookie = name + "=" + value + "; path=/";
        }

        function getCookie(name) {
            var match = document.cookie.match(new RegExp(name + "=([^;]+)"));
            return match ? match[1] : null;
        }
    </script> --}}

    @stack('script')
  </body>
</html>
