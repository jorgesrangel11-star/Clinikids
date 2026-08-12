<?php
// session_start(); 
?>
<header style="background-color: #013970; border-bottom: 2px solid rgba(255,255,255,0.1);">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark py-3">
            <a href="./indexCliente.php" class="navbar-brand d-flex align-items-center">
                <i class="bi bi-person-wheelchair fs-3 me-2 text-white"></i>
                <span class="fs-4 fw-bold text-white">CliniKids</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    
                    <li class="nav-item ms-lg-3">
                        <a class="nav-link text-white fw-semibold" href="./indexCliente.php">Inicio</a>
                    </li>
                    
                    <li class="nav-item ms-lg-3">
                        <a class="nav-link text-white fw-semibold" href="./agendar_cita.php">
                            <i class="bi bi-calendar-plus me-1"></i> Agendar
                        </a>
                    </li>

                    <li class="nav-item ms-lg-3">
                        <a class="nav-link text-white fw-semibold" href="./mis_citas.php">
                            <i class="bi bi-journal-bookmark-fill me-1"></i> Mis Citas
                        </a>
                    </li>

                    <li class="nav-item ms-lg-3">
                        <a class="nav-link text-white fw-semibold" href="./perfil.php">
                            <i class="bi bi-person-circle me-1"></i> Mi Perfil
                        </a>
                    </li>
                    
                    <li class="nav-item ms-lg-4">
                        <a class="nav-link text-danger fw-bold bg-white rounded px-3 py-1 mt-2 mt-lg-0 shadow-sm" href="../login.php">
                            <i class="bi bi-box-arrow-right me-1"></i> Cerrar Sesión
                        </a>
                    </li>
                    
                </ul>
            </div>
        </nav>
    </div>
</header>