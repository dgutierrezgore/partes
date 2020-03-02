<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <center>
            <a href="/home"><img src="img/logo.png" alt="Logo Gobierno Regional del Biobío"></a>
        </center>
        <ul class="sidebar-menu">
            <li class="active"><a href="{{ url('home') }}"><i class='fa fa-home'></i> <span>Inicio</span></a></li>
            <li class="header">- DOCUMENTACIÓN INTERNA -</li>
            <li class="treeview">
                <a href="#"><i class='fa fa-book'></i> <span>Documentos Internos</span> <i
                        class="fa fa-angle-down pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="/IngresoDocumento"><i class="fa fa-plus"></i> Ingresar Documento</a></li>
                    <li><a href="/GestionDocsInt"><i class="fa fa-edit"></i> Gestión Documentos</a></li>
                    <li><a href="/Mantenedores"><i class="fa fa-tasks"></i> Mantenedores</a></li>
                </ul>
            </li>
            <li class="header">- DOCUMENTACIÓN EXTERNA -</li>
            <li><a href="#"><i class='fa fa-cubes'></i> <span>Próximamente</span></a></li>

            <li class="header">- OPCIONES DEL SISTEMA -</li>
            <li><a href="{{ url('/logout') }}"
                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out"></i> Cerrar Sesión
                </a></li>
            <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                  style="display: none;">
                {{ csrf_field() }}
                <input type="submit" value="logout" style="display: none;">
            </form>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
