
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once("../html/mainHead.php"); ?>
    <title>MPCH::AsignacionBienes</title>
  </head>
<body>
    <?php require_once("../html/mainProfile2.php"); ?>
     <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2  mb-5 align-items-center">
                    <div class="col">
                        <div class="page-pretitle mb-3">
                           Baja de Objetos Para el Sistema de Inventario
                        </div>
                        <h2 class="page-title">
                          ADMINISTRADROR DE OBJETOS
                        </h2>
                    </div>
                </div>
                <div class="col-12 mb-3">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-list-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 15m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M18.5 18.5l2.5 2.5" /><path d="M4 6h16" /><path d="M4 12h4" /><path d="M4 18h4" /></svg>
                        Registro por Dependencias <span class="text-secondary">(Objetos en Inventario)</span>
                      </h3>
                    </div>
                    <div class="col-12">
                      <div class="table-responsive m-4">
                        <table id="area_data"  class="table card-table table-vcenter text-nowrap datatable">
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
    <?php require_once("../html/mainjs.php"); ?>
</body>
</html>
