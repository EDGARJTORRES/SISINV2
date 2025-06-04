<div class="modal modal-blur fade" id="modalClase" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-3 modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5  id="lbltituloObj" class="modal-title" style="color:rgb(255, 255, 255); display: flex; align-items: center; gap: 10px; padding: 5px 5px;">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-location ms-3"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" /></svg>
                    ACCIONES PARA CLASES:</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
              <form method="post" id="obj_form">
                <input type="hidden" name="obj_id" id="obj_id" />
                <div class="card-tabs m-4">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation"><a href="#tab-top-1" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">Tabla clase nueva</a></li>
                        <li class="nav-item" role="presentation"><a href="#tab-top-2" class="nav-link active" data-bs-toggle="tab" aria-selected="true" role="tab">Tabla clase actual</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-top-1" class="card tab-pane" role="tabpanel">
                            <div class="card-body">
                                <div class="row g-2  mb-5 align-items-center">
                                    <div class="col">
                                        <div class="card-title"> INGRESA NUEVA CLASE:</div>
                                    </div>     
                                    <div class="col-auto ms-auto d-print-none">
                                        <div class="btn-list">
                                            <a  class="btn btn-orange d-none d-sm-inline-block"  onclick="registrardetalle()"  name="action">
                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-checks"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12l5 5l10 -10" /><path d="M2 12l5 5m5 -5l5 -5" /></svg>
                                                Guardar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive my-4">
                                    <table id="gg_clase_data"  class="table card-table table-vcenter text-nowrap datatable">
                                        <thead >
                                            <tr>
                                                <th>Accion</th>
                                                <th>Clase</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="tab-top-2" class="card tab-pane active show" role="tabpanel">
                            <div class="card-body">
                                <div class="card-title">GESTIONA LA CLASE ACTUAL:</div>
                                <div class="table-responsive m-4">
                                    <table id="gg_clase_data_actual"  class="table card-table table-vcenter text-nowrap datatable">
                                        <thead>
                                            <tr>
                                                <th>Clase</th>
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
              </form>
        </div>
    </div>
</div>
    