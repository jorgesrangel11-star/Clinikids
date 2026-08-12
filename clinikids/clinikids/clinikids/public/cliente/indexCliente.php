<?php
session_start();
// Se incluye el menú que contiene la navegación y la 
include_once "./menu.php"; 
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinikids - Portal para Padres</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/bootstrap-icons.css">
    <style>
        /* Estilos de la sección principal */
        #client-main {
            background: #013970;
            background-image: radial-gradient(at left top, rgba(0, 35, 51, 0.85), rgba(1, 57, 112, 0.20)), url("../assets/img/hero-clinikids.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            padding: 100px 0;
        }

        #client-benefits i {
            font-size: 8vw;
            color: #013970;
        }

        h3 {
            font-size: 17px;
        }

        .btn-action {
            transition: transform 0.2s;
        }

        .btn-action:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body>

    <main>
        <section id="client-main">
            <div class="container text-center">
                <h1 class="text-white fw-bold display-4">Bienvenido al Portal Clinikids</h1>
                <p class="text-white fs-4 mb-4">La salud y bienestar de tus hijos en un solo lugar.</p>
                </div>
        </section>

        <section id="client-benefits" class="py-5 bg-light">
            <div class="container text-center">
                <h2 class="mb-5 fw-bold">Gestión Familiar</h2>
                <div class="row g-4">
                    <div class="col-md-4">
                        <i class="bi bi-person-heart"></i>
                        <p class="fw-bold mt-2">Información de los hijos para preparar la consulta.</p>
                    </div>
                    <div class="col-md-4">
                        <i class="bi bi-clock-history"></i>
                        <p class="fw-bold mt-2">Selección de pediatra, fecha y hora disponible.</p>
                    </div>
                    <div class="col-md-4">
                        <i class="bi bi-bell-fill"></i>
                        <p class="fw-bold mt-2">Recordatorios automáticos de citas agendadas.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5">
            <div class="container text-center">
                <h2 class="mb-5 fw-bold">Especialidades Pediatría</h2>
                <div class="row g-4 justify-content-center">
                    <div class="col-md-4">
                        <img src="../assets/img/pediatra.jpg" class="img-fluid rounded shadow-sm" alt="Pediatría General">
                        <p class="mt-4 mb-0">Atención integral para el crecimiento y desarrollo de los más pequeños.</p>
                    </div>
                    <div class="col-md-4">
                        <img src="../assets/img/neonatologia.jpg" class="img-fluid rounded shadow-sm" alt="Neonatología">
                        <p class="mt-4 mb-0">Cuidados especializados para recién nacidos y bebés prematuros.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5 bg-white border-top">
            <div class="container text-center">
                <h2 class="mb-5 fw-bold">Noticias y Consejos de Salud</h2>
                <div class="row g-3">
                    <div class="col-md-6 col-lg-3">
                        <article class="card h-100 shadow-sm border-0">
                            <img src="../assets/img/vacunas.jpg" class="card-img-top" alt="Esquema de vacunación">
                            <div class="card-body">
                                <h3 class="card-title mb-3 fw-bold">Importancia del esquema de vacunación</h3>
                                <p class="card-text small text-muted mb-2">
                                    <i class="bi bi-calendar-event"></i> <time datetime="2026-04-15">15 Abr 2026</time>
                                </p>
                                <p class="card-text">Mantén al día las vacunas para proteger la salud de tus hijos.</p>
                                <a href="#" class="btn btn-primary btn-sm mt-2">Leer artículo</a>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="py-4 bg-dark">
        <div class="container text-center">
            <p class="text-white mb-2">© 2026 Clinikids - Cuidado Pediátrico Profesional</p>
            <div class="d-flex justify-content-center gap-3">
                <a class="text-decoration-none text-white small" href="mailto:contacto@clinikids.com">
                    <i class="bi bi-envelope-at-fill me-1"></i> contacto@clinikids.com
                </a>
                <span class="text-secondary">|</span>
                <a class="text-decoration-none text-white small" href="tel:+524420000000">
                    <i class="bi bi-telephone-outbound-fill me-1"></i> Ayuda al Cliente
                </a>
            </div>
        </div>
    </footer>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>