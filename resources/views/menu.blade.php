<aside class="sidebar-nav-wrapper ">
    <div class="navbar-logo">
      <a href="{{route('principal')}}">
        {{-- <img src="assets/images/logo/logo.svg" alt="logo" /> --}}
        {{-- <img src="{{ asset('img/prueba.png')}}" alt="" height="50"> --}}
        <img src="{{ asset('img/logohdb.png')}}" alt="" height="90">
        {{-- <p ><strong class="text-danger">EPIDEMIOLOGÍA - HDB</strong></p> --}}
      </a>
    </div>
    <nav class="sidebar-nav">
      <ul>
        {{-- USUARIOS  --}}
        @can('admin')
            <li class="nav-item nav-item-has-children">
                <a
                href="#0"
                class="collapsed"
                data-bs-toggle="collapse"
                data-bs-target="#ddmenu_1"
                aria-controls="ddmenu_1"
                aria-expanded="false"
                aria-label="Toggle navigation"
                >
                <span class="icon">
                    <svg width="22" height="22" viewBox="0 0 22 22">
                      <path
                        d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z"
                      />
                    </svg>
                </span>
                <span class="text"> Administracion </span>
                </a>
                <ul id="ddmenu_1" class="collapse dropdown-nav">
                    <li>
                        <a class="nav-link {{ request()->is('usuarios*') ? 'active' : '' }}" href="{{ route('usuarios.index') }}">Users</a>
                        {{-- <a class="nav-link" href="{{route('usuarios.index')}}">Users</a> --}}
                    </li>
                    <li>
                        <a class="nav-link {{ request()->is('roles*') ? 'active' : '' }}" href="{{ route('roles.index') }}">Rol</a>
                        {{-- <a class="nav-link" href="{{route('roles.index')}}">Rol</a> --}}
                    </li>
                    <li>
                        {{-- <a class="nav-link" href="{{route('permissions.index')}}">Permissions</a> --}}
                        <a class="nav-link {{ request()->is('permissions*') ? 'active' : '' }}" href="{{ route('permissions.index') }}">Permissions</a>
                    </li>
                </ul>
            </li>
        @endcan
        {{-- FORMULARIOS --}}
        @can('button-forms')
            <li class="nav-item nav-item-has-children">
                <a href="#0" class="collapsed" data-bs-toggle="collapse" data-bs-target="#ddmenu_2" aria-controls="ddmenu_2" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon">
                        <svg
                            width="22"
                            height="22"
                            viewBox="0 0 22 22"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M13.75 4.58325H16.5L15.125 6.41659L13.75 4.58325ZM4.58333 1.83325H17.4167C18.4342 1.83325 19.25 2.65825 19.25 3.66659V18.3333C19.25 19.3508 18.4342 20.1666 17.4167 20.1666H4.58333C3.575 20.1666 2.75 19.3508 2.75 18.3333V3.66659C2.75 2.65825 3.575 1.83325 4.58333 1.83325ZM4.58333 3.66659V7.33325H17.4167V3.66659H4.58333ZM4.58333 18.3333H17.4167V9.16659H4.58333V18.3333ZM6.41667 10.9999H15.5833V12.8333H6.41667V10.9999ZM6.41667 14.6666H15.5833V16.4999H6.41667V14.6666Z"/>
                        </svg>
                    </span>
                        <span class="text">Formularios</span>
                </a>
                    <ul id="ddmenu_2" class="collapse dropdown-nav">
                        @can('create-form-iaas')
                            <li>
                                <a href="{{ route('view_form_1') }}"> IAAS </a>
                            </li>
                        @endcan
                        @can('create-form-eni')
                            <li>
                                <a href="{{ route('view_form_2') }}"> Enfermedades de Notificación Inmediata </a>
                            </li>
                        @endcan
                    </ul>
            </li>
        @endcan
        {{-- TABLAS --}}
        @can('button-tables')
            <li class="nav-item nav-item-has-children">
                <a
                href="#0"
                class="collapsed"
                data-bs-toggle="collapse"
                data-bs-target="#ddmenu_3"
                aria-controls="ddmenu_3"
                aria-expanded="false"
                aria-label="Toggle navigation"
                >
                <span class="icon">
                    <svg
                    width="22"
                    height="22"
                    viewBox="0 0 22 22"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                    >
                    <path
                        d="M4.58333 3.66675H17.4167C17.9029 3.66675 18.3692 3.8599 18.713 4.20372C19.0568 4.54754 19.25 5.01385 19.25 5.50008V16.5001C19.25 16.9863 19.0568 17.4526 18.713 17.7964C18.3692 18.1403 17.9029 18.3334 17.4167 18.3334H4.58333C4.0971 18.3334 3.63079 18.1403 3.28697 17.7964C2.94315 17.4526 2.75 16.9863 2.75 16.5001V5.50008C2.75 5.01385 2.94315 4.54754 3.28697 4.20372C3.63079 3.8599 4.0971 3.66675 4.58333 3.66675ZM4.58333 7.33341V11.0001H10.0833V7.33341H4.58333ZM11.9167 7.33341V11.0001H17.4167V7.33341H11.9167ZM4.58333 12.8334V16.5001H10.0833V12.8334H4.58333ZM11.9167 12.8334V16.5001H17.4167V12.8334H11.9167Z"
                    />
                    </svg>
                </span>
                <span class="text"> Tablas </span>
                </a>
                <ul id="ddmenu_3" class="collapse dropdown-nav">
                    @can('crud-index-tipoInfeccion')
                        <li>
                            <a href="{{ route('tipoInfeccion.index') }}"> Tipos de infeccion</a>
                        </li>
                    @endcan
                    @can('crud-index-bacteria')
                        <li>
                            <a href="{{ route('bacteria.index') }}"> Bacterias</a>
                        </li>
                    @endcan
                    @can('crud-index-medicamento')
                        <li>
                            <a href="{{ route('medicamento.index') }}"> Antibioticos</a>
                        </li>
                    @endcan
                    @can('crud-index-hongo')
                        <li>
                            <a href="{{ route('hongo.index') }}"> Hongos</a>
                        </li>
                    @endcan
                    @can('crud-index-patologia')
                        <li>
                            <a href="{{ route('patologia.index') }}"> Patologías</a>
                        </li>
                    @endcan
                    @can('button-form-iaas-table')
                        <li>
                            <a href="{{ route('TablaIAAS') }}"> Formulario IAAS</a>
                        </li>
                    @endcan
                    @can('button-form-eni-table')
                        <li>
                            <a href="{{ route('TablaE_N_I') }}"> Formulario Enf. Not. Inm.</a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        {{-- REPORTES  --}}
        @can('button-reports')
            <li class="nav-item nav-item-has-children">
                <a
                href="#0"
                class="collapsed"
                data-bs-toggle="collapse"
                data-bs-target="#ddmenu_4"
                aria-controls="ddmenu_4"
                aria-expanded="false"
                aria-label="Toggle navigation"
                >
                <span class="icon">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.8334 1.83325H5.50008C5.01385 1.83325 4.54754 2.02641 4.20372 2.37022C3.8599 2.71404 3.66675 3.18036 3.66675 3.66659V18.3333C3.66675 18.8195 3.8599 19.2858 4.20372 19.6296C4.54754 19.9734 5.01385 20.1666 5.50008 20.1666H16.5001C16.9863 20.1666 17.4526 19.9734 17.7964 19.6296C18.1403 19.2858 18.3334 18.8195 18.3334 18.3333V7.33325L12.8334 1.83325ZM16.5001 18.3333H5.50008V3.66659H11.9167V8.24992H16.5001V18.3333Z"></path>
                    </svg>
                </span>
                <span class="text"> Reportes </span>
                </a>
                <ul id="ddmenu_4" class="collapse dropdown-nav">
                    <li>
                        <a href="{{ route('Por.Servicio') }}"> Por Servcios</a>
                    </li>
                    <li>
                        <a href="{{ route('Por.Gestion') }}"> Por Gestión </a>
                    </li>
                    <li>
                        <a href="{{ route('Por.Mes') }}"> Por Mes</a>
                    </li>
                    <li>
                        <a href="{{ route('Por.Rango_fecha') }}"> Por Rango de Fechas</a>
                    </li>
                    <li>
                        <a href="{{ route('Trimestral.Por.Servicio') }}">Por Trimestre</a>
                    </li>
                    <li>
                        <a href="{{ route('Semestral.Por.Servicio') }}">Por Semestre</a>
                    </li>
                </ul>
            </li>
        @endcan
        {{-- InFORMES --}}
        @can('button-informes')
            <li class="nav-item nav-item-has-children">
                <a
                    href="#0"
                    class="collapsed"
                    data-bs-toggle="collapse"
                    data-bs-target="#ddmenu_5"
                    aria-controls="ddmenu_5"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                    >
                    <span class="icon">
                        <svg
                          width="22"
                          height="22"
                          viewBox="0 0 22 22"
                          fill="none"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <path
                            d="M3.66675 4.58325V16.4999H19.2501V4.58325H3.66675ZM5.50008 14.6666V6.41659H8.25008V14.6666H5.50008ZM10.0834 14.6666V11.4583H12.8334V14.6666H10.0834ZM17.4167 14.6666H14.6667V11.4583H17.4167V14.6666ZM10.0834 9.62492V6.41659H17.4167V9.62492H10.0834Z"
                          />
                        </svg>
                      </span>
                    <span class="text"> Informes </span>
                    </a>
                    <ul id="ddmenu_5" class="collapse dropdown-nav">
                        <li>
                            <a href="{{ route('Inf.Informe_Gestion')}}">Por Gestión</a>
                        </li>
                        <li>
                            <a href="{{ route('Inf.Informe_Semestral') }}">Por Semestre</a>
                        </li>
                        <li>
                            <a href="{{ route('Inf.Informe_Trimestral') }}">Por Trimestre</a>
                        </li>


                    </ul>
            </li>
        @endcan
        {{-- <span class="divider"><hr /></span> --}}

      </ul>
    </nav>
  </aside>

  {{-- <script>
    // Obtener la ruta actual del navegador
    const currentPath = window.location.pathname;

    // Obtener todos los elementos de enlace del menú
    const menuLinks = document.querySelectorAll('.sidebar-nav a');

    // Iterar sobre los enlaces y agregar la clase "active" al enlace cuya ruta coincida con la parte relevante de la ruta actual
    menuLinks.forEach(link => {
      if (currentPath.startsWith(link.getAttribute('href'))) {
        link.classList.add('active');
        // Si el enlace tiene un padre con la clase "collapse", asegúrate de que también esté abierto
        const parentCollapse = link.closest('.collapse');
        if (parentCollapse) {
          parentCollapse.classList.add('show');
        }
      }
    });
  </script> --}}

<style>
    /* Estilos para el enlace activo en el menú */
.sidebar-nav a.active {
  background-color: #f8f9fa; /* Cambia el color de fondo a tu gusto */
  color: #007bff; /* Cambia el color del texto a tu gusto */
}
</style>
