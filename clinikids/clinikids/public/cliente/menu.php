<?php
// NOTA: Mantenemos la sesión para que el "Cerrar Sesión" funcione
// session_start(); 
?>
<header style="background-color: #B4CABD;">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            
            <a href="./indexCliente.php" class="navbar-brand">
                <i class="bi bi-person-wheelchair fs-3 me-2" style="color: #013970;"></i>
                <span class="fs-5 fw-bold" style="color: #013970;">MóvilAssistance</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    
                    <li class="nav-item">
                        <a class="nav-link text-dark fw-bold" href="./indexCliente.php">Inicio</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link text-dark fw-bold" href="./productos.php">Catálogo</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link text-danger fw-bold" href="../login.php">
                            <i class="bi bi-box-arrow-right fs-5 me-1"></i> Cerrar Sesión
                        </a>
                    </li>
                    
                </ul>
            </div>
        </nav>
    </div>
</header>