<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usua_id_siin"])) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once("../html/mainHead.php"); ?>
    <title>MPCH::AsignacionBienes</title>
    <link href="../../public/css/estiloselect.css" rel="stylesheet"/>
    <style>
       .modal-header{
        background-color: #252422;
      }
      .select2-container--default .select2-selection--single .select2-selection__arrow b {
          border-color: #FF0000 transparent transparent transparent !important;
      }
    </style>
  </head>
<body data-bs-theme="light">
    <?php require_once("../html/mainProfile.php"); ?>
     <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2  mb-5 align-items-center">
                    <div class="col">
                        <div class="page-pretitle mb-3">
                           FORMATO ASIGNACIÓN DE BIENES EN USO 
                        </div>
                        <h2 class="page-title">
                          DESPLAZAMIENTO DE BIENES PARA EL SISTEMA DE INVENTARIO
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                      <div class="btn-list">
                        <button class="btn btn-6 btn-primary btn-pill w-100" id="add_button" onclick="nuevodesplazamiento()">
                          <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-device-imac-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12.5 17h-8.5a1 1 0 0 1 -1 -1v-12a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v8.5" /><path d="M3 13h13.5" /><path d="M8 21h4.5" /><path d="M10 17l-.5 4" /><path d="M16 19h6" /><path d="M19 16v6" /></svg>
                            Nuevo Registro
                        </button>
                      </div>
                    </div>
                </div>
                <div class="col-12 mb-3">
                  <div class="card" style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
                    <div class="card-header">
                      <h3 class="card-title">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-list-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 15m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M18.5 18.5l2.5 2.5" /><path d="M4 6h16" /><path d="M4 12h4" /><path d="M4 18h4" /></svg>
                       LISTADO DE ANEXOS
                      </h3>
                    </div>
                    <div class="table-responsive m-4">
                      <table id="area_data"  class="table card-table table-vcenter text-nowrap datatable">
                        <thead>
                          <tr>
                            <th>Codigo de Barras</th>
                            <th>Objeto denominación</th>
                            <th>Color</th>
                            <th>Estado</th>
                            <th>Comentario</th>
                            <th>ver</th>
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
    <?php require_once("../html/footer.php"); ?>
    <?php require_once("../html/mainjs.php"); ?>
    <?php require_once("modalDesplazamiento.php"); ?>
    <script type="text/javascript" src="desplazamiento.js"></script>
     <script type="text/javascript" src="nuevadesplazamiento.js"></script>
   <script>
    $(document).ready(function() {
      $('#area_destino_combo').select2({
        theme: 'bootstrap4',
        width: '100%'
      });
      $('#area_origen_combo').select2({
        theme: 'bootstrap4',
        width: '100%'
      });
    });
  </script>
  
    <script>
      function limitarADigitosDNI(input) {
        let valor = input.value.toString().replace(/\D/g, '');
        if (valor.length > 8) {
          valor = valor.slice(0, 8);
          $("#pers_origen_nom").val('');
        } else if (valor.length == 8) {
          buscarDNIOrigen();
        } else if (valor.length < 8) {
          $("#pers_origen_nom").val('');
        }
        input.value = valor;
      }

      function limitarADigitosDNIdestino(input) {
        let valor = input.value.toString().replace(/\D/g, '');
        if (valor.length > 8) {
          valor = valor.slice(0, 8);
          $("#pers_destino_nom").val('');
        } else if (valor.length == 8) {
          buscarDNIDestino();
        } else if (valor.length < 8) {
          $("#pers_destino_nom").val('');
        }
        input.value = valor;
      }
    </script>
</body>
</html>
<?php
} else {
  /* Si no a iniciado sesion se redireccionada a la ventana principal */
  header("Location:" . Conectar::ruta() . "view/404/");
}
?>