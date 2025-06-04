<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usua_id_siin"])) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once("../html/mainHead.php"); ?>
    <link href="../../public/css/Breadcrumb.css" rel="stylesheet"/>
    <title>MPCH::AsignacionBienes</title>
  </head>
<body>
    <?php require_once("../html/mainProfile.php"); ?>
     <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
              <nav class="breadcrumb mb-3">
                <a href="../adminMain/">Inicio</a>
                <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
                <span>Procesos</span>
                <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
                <span>Baja de Bien</span>
              </nav>
              <div class="row g-2  mb-5 align-items-center">
                  <div class="col">
                      <h2 class="page-title">
                        BAJA DE BIEN PATRIMONIAL
                      </h2>
                  </div>
              </div>
                <div class="col-12 mb-3">
                  <div class="card" style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
                    <div class="card-header">
                      <h3 class="card-title">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-list-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 15m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M18.5 18.5l2.5 2.5" /><path d="M4 6h16" /><path d="M4 12h4" /><path d="M4 18h4" /></svg>
                        REGISTRO POR DEPENDENCIA <span class="text-secondary">(OBJETOS EN INVENTARIO)</span>
                      </h3>
                    </div>
                    <div class="col-12">
                      <div class="table-responsive m-4">
                        <table id="dependencias_objetos"  class="table card-table table-vcenter text-nowrap datatable">
                          <thead>
                            <tr>
                              <th>Area</th>
                              <th>Total de objetos</th>
                              <th>Objetos retirados</th>
                              <th>Objetos Rotados</th>
                              <th>ver</th>
                              <th>Imprimir</th>
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
     <?php require_once("../html/footer.php"); ?>
    <?php require_once("../html/mainjs.php"); ?>
    <script type="text/javascript" src="adminMntDedendencias.js"></script>
    <script type="text/javascript" src="dependencias.js"></script>
</body>
</html>
<?php
} else {
  header("Location:" . Conectar::ruta() . "view/404/");
}
?>