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
  </head>
<body data-bs-theme="light">
    <?php require_once("../html/mainProfile2.php"); ?>
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
                          <a  type="button" class="btn btn-outline-dark  d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#">
                               <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-cancel"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M18.364 5.636l-12.728 12.728" /></svg>
                               Cancelar
                            </a>
                        </div>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                          <a href="#" class="btn btn-info d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modalObjetoCate">
                          <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-checks"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12l5 5l10 -10" /><path d="M2 12l5 5m5 -5l5 -5" /></svg>
                            Guardar Formato
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-3">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-list-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 15m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M18.5 18.5l2.5 2.5" /><path d="M4 6h16" /><path d="M4 12h4" /><path d="M4 18h4" /></svg>
                        Registro por Anexos creado <span class="text-secondary">(Ordenados por fecha)</span>
                      </h3>
                    </div>
                    <div class="card-body">
                      <input type="hidden" name="pers_origen_id" id="pers_origen_id" />
                      <input type="hidden" name="pers_destino_id" id="pers_destino_id" />
                      <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Área Origen:<span  style="color:red"> *</span></label>
                                <select class="form-select select2" id="area_origen_combo" name="area_origen_combo"data-placeholder="Seleccione Origen" style="width: 100%;">
                                  <option value="" disabled selected>Seleccione Origen</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="mb-3">
                            <label class="form-label">Área Destino:<span style="color:red"> *</span></label>
                            <select class="form-select select2" id="area_destino_combo" name="area_destino_combo" data-placeholder="Seleccione Destino" style="width: 100%;">
                              <option value="" disabled selected>Seleccione</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="mb-3">
                            <label class="form-label">DNI Representante:<span  style="color:red"> *</span></label>
                            <input type="number" min="0"  id="pers_origen_dni" name="pers_origen_dni" class="form-control">
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="mb-3">
                            <label class="form-label">DNI Representante:<span  style="color:red"> *</span></label>
                            <input type="number" min="0" id="pers_destino_dni" name="pers_destino_dni" class="form-control">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="mb-3">
                              <label class="form-label">Nombre del Representante:<span  style="color:red"> *</span></label>
                              <input type="text" id="pers_origen_nom" name="pers_origen_nom" disabled=""  class="form-control">
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="mb-3">
                            <label class="form-label">Nombre del Representante:<span  style="color:red"> *</span></label>
                            <input type="text" disabled=""  id="pers_destino_nom" name="pers_destino_nom"  class="form-control">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>   
                <div class="col-12">
                  <div class="card">
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
    <?php require_once("../html/mainjs.php"); ?>
    <script type="text/javascript" src="desplazamiento.js"></script>
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