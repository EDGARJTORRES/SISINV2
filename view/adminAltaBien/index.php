<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usua_id_siin"])) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once("../html/mainHead.php"); ?>
    <title>MPCH::AltaBienes</title>
    <link href="../../public/css/estiloselect.css" rel="stylesheet"/>
    <style>
     th{
      background-color: skyblue !important;
      color:white !important;
     }

     th, td {
        max-width: 170px !important;     
        white-space: normal;      
        word-break: break-word;   
        overflow-wrap: break-word; 
        vertical-align: middle;  
      }
    </style>
  </head>
<body>
    <?php require_once("../html/mainProfile2.php"); ?>
     <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2  mb-5 align-items-center">
                    <div class="col">
                        <div class="page-pretitle mb-3">
                          Mantenimiento de Bienes Para el Sistema de Inventario
                        </div>
                        <h2 class="page-title">
                          ALTA DE BIENES
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                          <a href="#" class="btn btn-info d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modalObjetoCate">
                          <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-device-imac-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12.5 17h-8.5a1 1 0 0 1 -1 -1v-12a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v8.5" /><path d="M3 13h13.5" /><path d="M8 21h4.5" /><path d="M10 17l-.5 4" /><path d="M16 19h6" /><path d="M19 16v6" /></svg>
                            Nuevo Bien
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-3">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-list-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 15m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M18.5 18.5l2.5 2.5" /><path d="M4 6h16" /><path d="M4 12h4" /><path d="M4 18h4" /></svg>
                        Registro por Grupo Generico <span class="text-secondary">(Objetos en Inventario)</span>
                      </h3>
                      <div class="text-end col-auto ms-auto d-print-none">
                        <span class="d-inline-block rounded-circle bg-primary mx-1" style="width: 12px; height: 12px;" aria-label="Activo" title="Activo"></span> Activo
                        <span class="d-inline-block rounded-circle bg-purple mx-1" style="width: 12px; height: 12px;" aria-label="Bienes Nuevos" title="Bienes Nuevos"></span> Nuevo
                        <span class="d-inline-block rounded-circle bg-danger mx-1" style="width: 12px; height: 12px;" aria-label="Baja Definitiva" title="Baja Definitiva"></span> Malo
                        <span class="d-inline-block rounded-circle bg-warning mx-1" style="width: 12px; height: 12px;" aria-label="Bienes Regular" title="Bienes Regular"></span>Regular
                        <span class="d-inline-block rounded-circle bg-success mx-1" style="width: 12px; height: 12px;" aria-label="Bienes Bueno" title="Bienes en Proceso"></span> Bueno
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="table-responsive m-4">
                        <div class="row my-4">
                          <div class="col-lg-3">
                            <label for="filtro_estado">Filtrar por estado:</label>
                            <select id="filtro_estado" class="form-select" style="width: 75%;">
                              <option value="">Todos</option>
                              <option value="Activo">Activo</option>
                              <option value="Nuevo">Nuevo</option>
                              <option value="Bueno">Bueno</option>
                              <option value="Regular">Regular</option>
                              <option value="Malo">Malo</option>
                            </select>
                          </div>
                          <div class="col-lg-3">
                            <label for="cantidad_registros">Cantidad de Registros:</label>
                            <input type="number" id="cantidad_registros" class="form-control" min="1" max="100" value="10"> 
                          </div>
                          <div class="col-lg-3">
                            <label for="cantidad_registros">Buscar Bien:</label>
                            <input type="text" id="buscar_registros" class="form-control"> 
                          </div>
                        </div>
                        <table id="bienes_data"  class="table card-table table-vcenter text-nowrap datatable ">
                          <thead>
                            <tr>
                              <th>Cod Interno</th>
                              <th>Cod Barras</th>
                              <th>Denominacion</th>
                              <th>Fecha Registro</th>
                              <th>Cod Grupo</th>
                              <th>Cod Clase</th>
                              <th>Estado</th>
                              <th></th>
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
    <?php require_once("modalobjgg.php"); ?>
    <?php require_once("modalObjetoCate.php"); ?>
    <script type="text/javascript" src="adminAltaBien.js"></script>
    <script type="text/javascript" src="bienes.js"></script>
</body>
</html>
<?php
} else {
  /* Si no a iniciado sesion se redireccionada a la ventana principal */
  header("Location:" . Conectar::ruta() . "view/404/");
}
?>
