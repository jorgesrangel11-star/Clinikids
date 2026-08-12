<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>MóvilAssistance - Sillas de Ruedas y Asistencia</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/bootstrap-icons.css">
    <style>
        /* Start Main Section styles */
        #client-main {
            background: #013970;
            /* Color base */
            background-image: radial-gradient(at left top, rgba(0, 35, 51, 0.85), rgba(1, 57, 112, 0.20)), url("../assets/img/main-section-movilidad.jpg");
            /* Nota: Reemplazar con una imagen de movilidad o asistencia */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            padding: 100px 0;
        }

        #client-benefits i {
            font-size: 8vw;
            color: #007bff; /* Color primario para íconos de beneficios */
        }

        h3 {
            font-size: 17px;
        }
    </style>
</head>

<body>

    <main>
        <section id="client-main">
            <div class="container text-center">
                <h1 class="text-white fw-bold">MóvilAssistance</h1>
                <p class="text-white fs-4 fw-bold">¡La tecnología y comodidad que necesitas para una movilidad sin límites!</p>
            </div>
        </section>

        <section class="py-5">
            <div class="container text-center">
                <h2 class="mb-4">Nuestros Productos Principales</h2>
                <div class="row g-4">
                    <div class="col-md-4">
                        <img src="../assets/img/silla-estandar.jpg"
                            class="img-fluid rounded" alt="Silla de Ruedas Estándar">
                        <p class="mt-4 mb-0">Sillas manuales ligeras y duraderas, ideales para uso diario en interiores y exteriores. Fáciles de plegar.</p>
                    </div>
                    <div class="col-md-4">
                        <img src="../assets/img/rueda.jpg"
                            class="img-fluid rounded" alt="Silla de Ruedas Eléctrica">
                        <p class="mt-4 mb-0">Rueda de respuesto en caso de que sea necesario tener que cambiar alguna.</p>
                    </div>
                    <div class="col-md-4">
                        <img src="../assets/img/soporte.jpg"
                            class="img-fluid rounded" alt="Accesorios y Soporte">
                        <p class="mt-4 mb-0">Todo tipo de accesorios, cojines ergonómicos, rampas portátiles y servicio de mantenimiento certificado.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="client-benefits" class="py-5 bg-light">
            <div class="container text-center">
                <h2>Por Qué Elegir MóvilAssistance</h2>
                <div class="row g-4">
                    <div class="col-md-4">
                        <i class="bi bi-person-lines-fill"></i>
                        <p>Asesoría personalizada para encontrar el modelo perfecto.</p>
                    </div>
                    <div class="col-md-4">
                        <i class="bi bi-tools"></i>
                        <p>Garantía extendida y servicio técnico a domicilio.</p>
                    </div>
                    <div class="col-md-4">
                        <i class="bi bi-globe"></i>
                        <p>Materiales ultraligeros y tecnología de navegación asistida.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5">
            <div class="container text-center">
                <h2 class="mb-4">Noticias y Consejos de Movilidad</h2>
                <div class="row g-3">
                    <div class="col-md-6 col-lg-3">
                        <article class="card h-100 shadow-sm">
                            <img src="../assets/img/mantenimiento.jpg" class="card-img-top" alt="Mantenimiento básico de sillas">
                            <div class="card-body">
                                <h3 class="card-title mb-3">Mantenimiento básico para prolongar la vida útil</h5>
                                    <p class="card-text small text-muted mb-2">
                                        <i class="bi bi-calendar-event"></i>
                                        <time datetime="2024-09-12">12 Sep 2024</time>
                                    </p>
                                    <p class="card-text">Consejos y revisión de rutina para el cuidado de tu silla manual o eléctrica.</p>
                                    <a href="#" class="btn btn-primary">Leer artículo</a>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <article class="card h-100 shadow-sm">
                            <img src="../assets/img/rampas.jpg" class="card-img-top" alt="Guía de rampas">
                            <div class="card-body">
                                <h3 class="card-title mb-3">Guía de rampas portátiles para el hogar</h5>
                                    <p class="card-text small text-muted mb-2">
                                        <i class="bi bi-calendar-event"></i>
                                        <time datetime="2024-08-28">28 Ago 2024</time>
                                    </p>
                                    <p class="card-text">Cómo elegir el ángulo y material correcto para una movilidad segura.</p>
                                    <a href="#" class="btn btn-primary">Leer artículo</a>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <article class="card h-100 shadow-sm">
                            <img src="../assets/img/seguro.jpg" class="card-img-top" alt="Cobertura de seguro">
                            <div class="card-body">
                                <h3 class="card-title mb-3">¿Cubre mi seguro mi silla de ruedas?</h5>
                                    <p class="card-text small text-muted mb-2">
                                        <i class="bi bi-calendar-event"></i>
                                        <time datetime="2024-07-05">5 Jul 2024</time>
                                    </p>
                                    <p class="card-text">Todo lo que debes saber sobre coberturas médicas y asistencia.</p>
                                    <a href="#" class="btn btn-primary">Leer artículo</a>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <article class="card h-100 shadow-sm">
                            <img src="../assets/img/cuidado-cojines.jpg" class="card-img-top" alt="Cuidado de cojines">
                            <div class="card-body">
                                <h3 class="card-title mb-3">Cuidado adecuado de cojines ergonómicos</h5>
                                    <p class="card-text small text-muted mb-2">
                                        <i class="bi bi-calendar-event"></i>
                                        <time datetime="2024-06-10">10 Jun 2024</time>
                                    </p>
                                    <p class="card-text">Tips para la higiene y prevención de úlceras por presión.</p>
                                    <a href="#" class="btn btn-primary">Leer artículo</a>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <div class="container d-flex justify-content-center my-4">
        <a href="./productos.php" class="btn btn-primary">Ver Catálogo Completo</a> </div>
    <footer class="py-4 bg-black">
        <div class="container d-flex justify-content-center">
            <a class="px-1 text-decoration-none text-white" href="mailto:contacto@movilassistance.com">
                <i class="bi bi-envelope-at-fill"></i>
                contacto@movilassistance.com
            </a>
            <a class="px-1 text-decoration-none text-white" text-white" href="tel:+52 4421234567">
                <i class="bi bi-telephone-outbound-fill"></i>
                4421234567
            </a>
        </div>
    </footer>
</body>

</html>