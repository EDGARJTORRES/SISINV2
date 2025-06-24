<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usua_id_siin"])) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once("../html/mainHead.php"); ?>
    <link href="../../public/css/Breadcrumb.css" rel="stylesheet"/>
    <title>MPCH::ManGenerales</title>
    <style>
      body:not([data-bs-theme="dark"]) .dropdown-item:hover,
      body:not([data-bs-theme="dark"]) .nav-link:hover {
          background-color: rgba(0, 0, 0, 0.03);
          transition: all 0.2s ease-in-out;
      }
      div.dataTables_filter {
        display: none !important;
      }
      th{
      color: #0054a6 !important;
      }
     th, td {
        max-width: 200px !important;     
        white-space: normal;      
        word-break: break-word;   
        overflow-wrap: break-word; 
        vertical-align: middle;   
      }
    </style>
  </head>
<body>
    <?php require_once("../html/mainProfile.php"); ?>
    <div class="page-wrapper">
      <div class="page-header d-print-none">
        <div class="container-xl">
           <nav class="breadcrumb mb-3">
            <a href="../adminMain/">Inicio</a>
            <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
            <span>Reportes</span>
          </nav>
          <div class="row g-2  mb-5 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    HISTORICO DE FORMATOS
                </h2>
              </div>
            </div>
            <div class="col-12 mb-3">
              <div class="card" style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
                <div class="card-header">
                  <h3 class="card-title">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-list-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 15m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M18.5 18.5l2.5 2.5" /><path d="M4 6h16" /><path d="M4 12h4" /><path d="M4 18h4" /></svg>
                      REGISTROS GENERALES DE FORMATOS
                  </h3>
                </div>
                <div class="card-body">
                  <div class="table-responsive mx-4">
                     <div class="row my-4">
                        <div class="col-lg-2">
                          <label for="cantidad_registros">Registros por página:</label>
                          <div class="input-icon">
                              <span class="input-icon-addon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                  <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                  <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                </svg>
                              </span>
                              <input type="number" id="cantidad_registros"   style="width: 75%;" class="form-control" min="1" max="100" value="10"> 
                          </div>
                        </div>
                        <div class="col-lg-3">
                          <label for="cantidad_registros">Filtrar Anexos:</label>
                          <select id="filtro_anexo" class="form-select" >
                            <option value="0">Todos</option>
                            <option value="Asignacion">Asignacion</option>
                            <option value="Asignacion">Desplazamiento</option>
                          </select> 
                        </div>
                        <div class="col-lg-3">
                          <label for="cantidad_registros">Buscar Formato:</label>
                          <div class="input-icon"style="width: 400px;">
                              <span class="input-icon-addon">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                              </span>
                                 <input type="text" id="buscar_registros" class="form-control"> 
                          </div>
                        </div>
                      </div>
                      <table id="formatos_data"  class="table card-table table-vcenter text-nowrap datatable">
                          <thead>
                              <tr>
                                  <th>Fecha</th>
                                  <th>Anexo</th>
                                  <th>Emisor</th>
                                  <th>Receptor</th>
                                  <th>Usuario</th>
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
    <?php require_once("../html/footer.php"); ?>
    <?php require_once("../html/mainjs.php"); ?>
    <script type="text/javascript" src="adminAltaBien.js"></script>
    <script type="text/javascript" src="formato.js"></script>
</body>
</body>
</html>
<?php
} else {
  header("Location:" . Conectar::ruta() . "view/404/");
}
?>