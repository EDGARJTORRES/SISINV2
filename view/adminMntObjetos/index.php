<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once("../html/mainHead.php"); ?>
    <title>MPCH::AltaBienes</title>
    <style>
      .titulo {
          color: #004085;
          display: flex;
          align-items: center;
          gap: 10px;
          background-color: rgb(247, 249, 250);
          padding: 10px 10px;
          border-left: 5px solid #17a2b8;
          border-radius: 6px;
        }
    </style>
  </head>
<body>
    <?php require_once("../html/mainProfile.php"); ?>
     <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2  mb-5 align-items-center">
                    <div class="col">
                        <div class="page-pretitle mb-3">
                           Mantenimiento de Objetos Para el Sistema de Inventario
                        </div>
                        <h2 class="page-title" style="color:white;">
                          ADMINISTRADOR DE OBJETOS
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                          <a href="#" class="btn btn-btn-outline-info d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modalClase">
                         <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                            Editar Clases
                            </a>
                        </div>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                          <a href="#" class="btn btn-info d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modalObjeto">
                          <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-device-imac-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12.5 17h-8.5a1 1 0 0 1 -1 -1v-12a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v8.5" /><path d="M3 13h13.5" /><path d="M8 21h4.5" /><path d="M10 17l-.5 4" /><path d="M16 19h6" /><path d="M19 16v6" /></svg>
                            Registrar Objeto
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-3">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-list-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 15m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M18.5 18.5l2.5 2.5" /><path d="M4 6h16" /><path d="M4 12h4" /><path d="M4 18h4" /></svg>
                        Registro por Grupo y categorias <span class="text-secondary">(Objetos en Inventario)</span>
                      </h3>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Grupo Generico:<span  style="color:red"> *</span></label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Clase:<span  style="color:red"> *</span></label>
                                <input type="text" class="form-control">
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
                            <th>ID</th>
                            <th>Denominación</th>
                            <th>Objeto Codigo CANA</th>
                            <th>Editar</th>
                            <th>Quitar</th>
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
    <?php require_once("modalObjeto.php"); ?>
    <?php require_once("modalClase.php"); ?>
</body>
</html>