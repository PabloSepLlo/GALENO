<div>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="./menu.php">
                <img src="../images/9ded914031de73173d19cf30839fef76-hospital-surgery-logo.webp" alt="Logo" width="50" height="50" class="d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php
                        if ($datos["administrador"] == "SÍ") {
                            echo " 
                            <li class='nav-item mx-3'><a class='nav-link fs-5 fw-bold' href='../controlador/cargar_usuarios.php'>GESTIÓN USUARIOS</a></li>
                            ";
                        }
                    ?>
                    <li class="nav-item mx-3">
                        <a class="nav-link fs-5 fw-bold" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                            CONSULTAS
                        </a>
                    </li>
                    <li class="nav-item dropdown mx-3">
                        <a class="nav-link dropdown-toggle fs-5 fw-bold" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            GESTIÓN PACIENTE
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg-end">
                            <li><a class="dropdown-item" href="../controlador/cargar_datos_form_pacientes.php">Añadir paciente</a></li>
                            <li><a class="dropdown-item" href="./aniadir_ingreso_generales.php?ingresando">Añadir ingreso</a></li>
                            <li><a class="dropdown-item" href="./aniadir_paciente_demograficos.php?editando">Editar paciente</a></li>
                        </ul>
                    </li>
                    <?php
                        echo " 
                        <span class='navbar-text fs-5 fw-bold text-primary-subtle mx-4'>
                            Bienvenido, <span>{$datos["nombre"]}</span>
                        </span>";
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fs-5 px-2" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle ms-5 fs-5"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../vista/mis_datos.php">Mis datos</a></li>
                            <li><a class="dropdown-item" href="../controlador/cerrar_sesion.php">Cerrar sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
        <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
            <div class="offcanvas-header d-flex flex-column p-3">
                <div class="d-flex justify-content-end w-100 mb-3">
                    <button 
                        type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                    </button>
                </div>
                <div class="d-flex align-items-center">
                    <a class="navbar-brand me-2" href="./menu.php">
                        <img src="../images/9ded914031de73173d19cf30839fef76-hospital-surgery-logo.webp" alt="Logo" width="50" height="50" class="d-inline-block align-text-top mb-2">
                    </a>
                    <h5 class="offcanvas-title fw-bold m-0">CONSULTAS</h5>
                </div>
            </div>
        <div class="offcanvas-body">
            <div class="accordion" id="accordionPanelsStayOpenExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                            CONSULTAS PREDEFINIDAS
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                            <div class="list-group">
                                <a href="../controlador/cargar_datos_cs.php" class="list-group-item list-group-item-action">
                                    Pacientes por centro de salud
                                </a>
                                <a href="../controlador/cargar_datos_migr.php" class="list-group-item list-group-item-action">
                                    Pacientes por motivo de ingreso
                                </a>
                                <a href="../controlador/cargar_datos_tr.php" class="list-group-item list-group-item-action">
                                    Pacientes por tratamiento
                                </a>
                                <a href="../vista/visor_consultas_nhc.php?filtroNHC" class="list-group-item list-group-item-action">
                                    Paciente por N.H.C.
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                            GENERACIÓN DE INFORME
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <div class="list-group">
                                <a href="../vista/visor_consultas_informe.php?fechas_informe" class="list-group-item list-group-item-action">
                                    Generación de informe básico
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>