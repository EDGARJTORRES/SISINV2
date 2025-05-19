<?php
require_once("config/conexion.php");
if (isset($_POST["enviar"]) and $_POST["enviar"] == "si") {
  require_once("models/Usuario.php");
  $usuario = new Usuario();
  $usuario->login();
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <link rel="icon" type="image/png" href="static/illustrations/logomuni3.png">
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <link href="./public/css/tabler.min.css?1692870487" rel="stylesheet"/>
    <link href="./public/css/tabler-flags.min.css?1692870487" rel="stylesheet"/>
    <link href="./public/css/tabler-payments.min.css?1692870487" rel="stylesheet"/>
    <link href="./public/css/tabler-vendors.min.css?1692870487" rel="stylesheet"/>
    <link href="./public/css/demo.min.css?1692870487" rel="stylesheet"/>
    <title>Municipalidad Provincial de Chiclayo.</title>
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
          overflow: hidden;
          background-image: url('./static/illustrations/chiclayo.jpg');
          background-size: cover;
          background-position: center;
          background-repeat: no-repeat;
      }
    </style>
  </head>
  <body  class=" d-flex flex-column">
    <div class="page page-center">
      <div class="container container-normal py-4">
        <div class="row align-items-center g-0">
          <div class="col-lg">
            <div class="container-tight">
              <div class="card card-md">
                <div class="card-body">
                  <h2 class="text-center mb-1">MUNICIPALIDAD PROVINCIAL DE CHICLAYO</h2>
                  <div class="text-center mb-2">
                    <img src="./static/illustrations/Escudo_de_Chiclayo.PNG" height="120" alt="">
                  </div>
                  <h2 class="text-center mb-2">¡Bienvenido al Sistema  de Inventario!</h2>
                  <p class="text-center mb-2">Ingresa tus datos para Iniciar sesión.</p>
                  <form action="./" method="POST" autocomplete="off" novalidate>
                    <?php
                    if (isset($_GET["m"])) {
                      switch ($_GET["m"]) {
                         case "1":
                            ?>
                            <div class="alert alert-danger alert-dismissible" role="alert">
                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              <strong>Error:</strong> Error
                            </div>
                            <?php
                            break;

                           case "2":
                            ?>
                            <div class="alert alert-warning alert-dismissible" role="alert">
                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              <strong>Error:</strong> Campos vacíos
                            </div>
                            <?php
                            break;

                          case "3":
                            ?>
                            <div class="alert alert-info alert-dismissible" role="alert">
                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              <strong>Error:</strong> No se encontraron datos
                            </div>
                            <?php
                            break;

                          case "4":
                            ?>
                            <div class="alert alert-danger alert-dismissible" role="alert">
                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              <strong>Error:</strong> IP Persona no registrada
                            </div>
                            <?php
                            break;

                          case "5":
                            ?>
                            <div class="alert alert-warning alert-dismissible" role="alert">
                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              <strong>Error:</strong> Persona inactiva
                            </div>
                            <?php
                            break;

                          case "6":
                            ?>
                            <div class="alert alert-info alert-dismissible" role="alert">
                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              <strong>Error:</strong> Fuera de la hora de acceso
                            </div>
                            <?php
                            break;

                          case "7":
                            ?>
                            <div class="alert alert-warning alert-dismissible" role="alert">
                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              <strong>Error:</strong> Usuario no vigente
                            </div>
                            <?php
                            break;

                          case "8":
                            ?>
                            <div class="alert alert-danger alert-dismissible" role="alert">
                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              <strong>Error:</strong> Datos incorrectos
                            </div>
                            <?php
                            break;
                        }
                      }
                    ?>
                    <div class="mb-2">
                      <label class="form-label">DNI</label>
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
                    <div>
                      <label class="form-label">Contraseña</label>
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
        </div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./public/js/tabler.min.js?1692870487" defer></script>
    <script src="./public/js/demo.min.js?1692870487" defer></script>
    <script>
      function limitarADigitosDNI(input) {
          let valor = input.value.toString().replace(/\D/g, '');
          if (valor.length > 8) {
          valor = valor.slice(0, 8);
          }
          input.value = valor;
      }
    </script> 
    <script type="text/javascript" src="js/index.js"></script>
  </body>
</html>