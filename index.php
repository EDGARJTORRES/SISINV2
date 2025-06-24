<?php
require_once("config/conexion.php");
if (isset($_POST["enviar"]) and $_POST["enviar"] == "si") {
  require_once("models/Usuario.php");
  $usuario = new Usuario();
  $usuario->login();
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>Inicio de sesión - MPCH::Inventario</title>
        <link href="./public/css/tabler.min.css?1692870487" rel="stylesheet"/>
        <link href="./public/css/tabler-flags.min.css?1692870487" rel="stylesheet"/>
        <link href="./public/css/tabler-payments.min.css?1692870487" rel="stylesheet"/>
        <link href="./public/css/tabler-vendors.min.css?1692870487" rel="stylesheet"/>
        <link rel="icon" type="image/png" href="static/illustrations/logomuni3.png">
        <style>
            .system-title {
            text-align: center;
            margin-bottom: 20px;
            }

            .title-main {
            font-size: 20px;
            /* Ajusta según tu preferencia */
            font-weight: bold;
            color: #32393f;
            /* Color moderno */
            letter-spacing: 1px;
            /* Espaciado entre letras */
            margin-bottom: 5px;
            }

            .title-sub {
            font-size: 24px;
            font-weight: 800;
            color: #dd1c04;
            letter-spacing: 1px;
            text-transform: uppercase;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
            }

            body {
            position: relative;
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fa;
            /* Fondo base por si falla la imagen */
            }

            body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
             background-image: url('./static/illustrations/chiclayo.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            filter: brightness(50%);
            z-index: -1;
            /* Coloca el fondo detrás del contenido */
            }

            .card {
            position: relative;
            z-index: 1;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            }
        </style>
    </head>

    <body class=" d-flex flex-column">
        <div class="page page-center">
            <div class="container container-tight py-4">
                <div class="header-colors" style="width: 100%;height: 20px; display: flex">
                    <div style="background: #ac4033;width: 25%; height: 100%;">

                    </div>
                    <div style="background: #d59b2d;width: 25%; height: 100%;">

                    </div>
                    <div style="background: #61a0a5;width: 25%; height: 100%;">

                    </div>
                    <div style="background: #0054a6;width: 25%; height: 100%;">

                    </div>
                </div>
                <div class="card card-md" style="border-radius: 0 0 5px 5px; width: 400px;">
                    <div class="card-body" style="padding-top: 20px;">
                        <div style="display: flex;justify-content: flex-end;">
                            <img src="./static/illustrations/HeadChiclayo.png" width="110" height="32" alt="Tabler" class="navbar-brand-image">
                        </div>
                    
                        <div class="text-center mb-2">
                            <img src="./static/illustrations/cumplimiento-de-pedidos.png" height="120" alt="Logo">
                        </div>
    
                        <h2 class="h3 text-center mb-4">SOFTWARE DE GESTIÓN DE INVENTARIO <br> [ MUNICIPALIDAD DE CHICLAYO ]</h3>
                        <?php
                            if (isset($_GET["m"])) {
                            switch ($_GET["m"]) {
                                case "1":
                                    ?>
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>Error:</strong> ERROR
                                    </div>
                                    <?php
                                    break;

                                case "2":
                                    ?>
                                    <div class="alert alert-warning alert-dismissible" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>Error:</strong> CAMPOS VACIOS
                                    </div>
                                    <?php
                                    break;

                                case "3":
                                    ?>
                                    <div class="alert alert-info alert-dismissible" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>Error:</strong> NO SE ENCONTRARON DATOS
                                    </div>
                                    <?php
                                    break;

                                case "4":
                                    ?>
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>Error:</strong> IP NO REGISTRADA
                                    </div>
                                    <?php
                                    break;

                                case "5":
                                    ?>
                                    <div class="alert alert-warning alert-dismissible" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>Error:</strong> PERSONA INACTIVA
                                    </div>
                                    <?php
                                    break;

                                case "6":
                                    ?>
                                    <div class="alert alert-info alert-dismissible" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>Error:</strong> FUERA DE LA HORA DE ACCESO
                                    </div>
                                    <?php
                                    break;

                                case "7":
                                    ?>
                                    <div class="alert alert-warning alert-dismissible" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>Error:</strong> USUARIO NO VIGENTE
                                    </div>
                                    <?php
                                    break;

                                case "8":
                                    ?>
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>Error:</strong> DATOS INCORRECTOS
                                    </div>
                                    <?php
                                    break;
                                }
                            }
                        ?>
                       <form action="./" method="POST" autocomplete="off" novalidate>
                            <div class="mb-3">
                                <label class="form-label">Usuario</label>
                                <div class="input-icon mb-1">
                                    <input type="number" id="usu_dni" name="usu_dni" class="form-control" placeholder="Ingrese su dni" oninput="limitarADigitosDNI(this)">
                                    <span class="input-icon-addon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                    </svg>
                                    </span>
                                </div>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">
                                    Contraseña
                                    <span class="form-label-description">
                                        <a href="https://www.munichiclayo.gob.pe/sisSeguridad/view/USURecuperacionContra/index.php?sistema=Escalafon">¿Olvidó su contraseña?</a>
                                    </span>
                                </label>
                                <div class="input-group input-group-flat">
                        <input type="password" class="form-control" placeholder="Tu contraseña..." autocomplete="off" id="usu_pass" name="usu_pass">
                        <span class="input-group-text">
                          <a href="#" class="link-secondary" title="Mostrar contraseña" data-bs-toggle="tooltip" id="togglePassword">
                            <!-- Icono ojo visible -->
                            <svg id="icon-show" xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                              <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                              <path d="M21 12c-2.4 4 -5.4 6 -9 6
                                      c-3.6 0 -6.6 -2 -9 -6
                                      c2.4 -4 5.4 -6 9 -6
                                      c3.6 0 6.6 2 9 6" />
                            </svg>
                            <!-- Icono ojo tachado -->
                            <svg id="icon-hide" xmlns="http://www.w3.org/2000/svg" class="icon d-none" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                              <path d="M3 3l18 18" />
                              <path d="M10.6 10.6a2 2 0 0 0 2.8 2.8" />
                              <path d="M9.9 5.1c.7 -.1 1.4 -.1 2.1 0
                                      c3.6 0 6.6 2 9 6
                                      c-.8 1.3 -1.6 2.4 -2.5 3.2" />
                              <path d="M6.6 6.6c-1.7 1.2 -3.2 3 -4.6 5.4
                                      c2.4 4 5.4 6 9 6
                                      c1.5 0 2.9 -.3 4.2 -.9" />
                            </svg>
                          </a>
                        </span>
                      </div>
                            </div>
                            <div class="mb-1">
                                <label class="form-check">
                                    <input type="checkbox" class="form-check-input"/>
                                    <span class="form-check-label">Recuérdame en este dispositivo.</span>
                                </label>
                            </div>
    
                            <input type="hidden" name="enviar" value="si">
                            <div class="form-footer">
                        <button type="submit" class="btn btn-info w-100">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-login-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2" /><path d="M3 12h13l-3 -3" /><path d="M13 15l3 -3" /></svg>
                        Ingresar
                      </button>
                    </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="./public/js/tabler.min.js?1692870487" defer></script>
        <script src="./public/js/demo.min.js?1692870487" defer></script>
        <script>
            function limitarADigitosDNI(input) {
                let valor = input.value.replace(/\D/g, '');
                if (valor.length > 8) {
                    valor = valor.slice(0, 8);
                }
                input.value = valor;
            }
            document.querySelectorAll('.toggle-password').forEach(el => {
                el.addEventListener('click', e => {
                    e.preventDefault();
                    const input = el.closest('.input-group').querySelector('input');
                    input.type = input.type === 'password' ? 'text' : 'password';
                });
            });
        </script>
        <script type="text/javascript" src="js/index.js"></script>
    </body>
</html>