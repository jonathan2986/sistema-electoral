<div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                    <li @click="menu=0" class="nav-item">
                        <a class="nav-link active" href="#"><i class="icon-speedometer"></i> Escritorio</a>
                    </li>
                    <li class="nav-title">
                        Mantenimiento
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-bag"></i>Municipio</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=1" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i> Provincias</a>
                            </li>
                            <li @click="menu=2" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i>Circunscripcion</a>
                            </li>
                            <li @click="menu=3" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i> Municipios</a>
                            </li>
                            <li @click="menu='distritos'" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i> Distritos</a>
                            </li>
                            <li @click="menu='recintos'" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i> Recintos</a>
                            </li>
                            <li @click="menu='colegios-electorales'" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i> Colegios Electorales</a>
                            </li>
                            <li @click="menu='personas'" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i> Personas</a>
                            </li>
                            <li @click="menu='votantes'" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i> Votantes</a>
                            </li>
                            <li @click="menu='users'" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i> Usuarios</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-wallet"></i> Colegios Electorales</a>
                        <ul class="nav-dropdown-items">
{{--                            <li @click="menu=3" class="nav-item">--}}
{{--                                <a class="nav-link" href="#"><i class="icon-wallet"></i>Colegios</a>--}}
{{--                            </li>--}}
                            <li @click="menu=4" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-notebook"></i>Usuarios</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-people"></i> Acceso</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=5" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-user"></i> Usuarios</a>
                            </li>
                            <li @click="menu=6" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-user-following"></i> Roles</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-book-open"></i> Partidos y Candidatos</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=7" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-book-open"></i> Partidos</a>
                            </li>
                            <li @click="menu=8" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-book-open"></i> Candidatos</a>
                            </li>
                        </ul>
                    </li>
                    <li @click="menu=9" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-pie-chart"> </i>Resultados<span class="badge badge-danger">Reportes</span></a>
                    </li>
                    <li @click="menu=12" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-info"></i> Acerca de...<span class="badge badge-info">IT</span></a>
                    </li>
                </ul>
            </nav>
            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
        </div>