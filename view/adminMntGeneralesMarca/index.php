<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usua_id_siin"])) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once("../html/mainHead.php"); ?>
    <title>MPCH::MantGenerales</title>
  </head>
<body>
    <?php require_once("../html/mainProfile2.php"); ?>
    <div class="page-wrapper">
      <div class="page-header d-print-none">
        <div class="container-xl">
          <div class="row g-2  mb-5 align-items-center">
            <div class="col">
              <div class="page-pretitle mb-3">
                  Mantenimientos Para el Sistema de Inventario
              </div>
                <h2 class="page-title">
                    MANTENIMIENTOS GENERALES
                </h2>
              </div>
            </div>
            <div class="col-12 mb-3">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-list-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 15m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M18.5 18.5l2.5 2.5" /><path d="M4 6h16" /><path d="M4 12h4" /><path d="M4 18h4" /></svg>
                      MARCA
                  </h3>
                  <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                      <a href="#"  class="btn bg-teal text-teal-fg d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modalMarca">
                      <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-device-imac-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12.5 17h-8.5a1 1 0 0 1 -1 -1v-12a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v8.5" /><path d="M3 13h13.5" /><path d="M8 21h4.5" /><path d="M10 17l-.5 4" /><path d="M16 19h6" /><path d="M19 16v6" /></svg>
                        Nuevo Registro
                        </a>
                    </div>
                </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive m-4">
                      <table id="marca_data"  class="table card-table table-vcenter text-nowrap datatable">
                          <thead>
                              <tr>
                                <th>N°</th>
                                <th>MARCA</th>
                                <th>EDITAR</th>
                                <th>ELIMINAR</th>
                              </tr>
                          </thead>
                          <tbody>
                          </tbody>
                      </table>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>  
    </div>
    <?php require_once("../html/mainjs.php"); ?>
    <?php require_once("modalMarca.php"); ?>
    <script type="text/javascript" src="marca.js"></script>
</body>
</body>
</html>
<?php
} else {
  header("Location:" . Conectar::ruta() . "view/404/");
}
?>