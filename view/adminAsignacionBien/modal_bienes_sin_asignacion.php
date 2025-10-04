<div class="modal fade" id="modalsinasignacion" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered  "  style="margin-left: 20px;">
    <div class="modal-content" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
        <div class="modal-header bg-black text-white">
            <h5 class="modal-title d-flex align-items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M21 12v3a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1v-10a1 1 0 0 1 1 -1h9" />
                <path d="M7 20l10 0" />
                <path d="M9 16l0 4" />
                <path d="M15 16l0 4" />
                <path d="M17 4h4v4" />
                <path d="M16 9l5 -5" />
            </svg>
              LISTADO DE BIENES NUEVOS Y SIN ASIGNACIÓN
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="col-12">
            <div class="table-responsive">
              <div class="row mb-3">
                <div class="col-lg-8">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                          viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                          stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                          class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                        <path d="M21 21l-6 -6" />
                      </svg>
                    </span>
                    <input type="text" id="buscar_registros" 
                          placeholder="Buscar registro ..." class="form-control">
                  </div>
                </div>
                <div class="col-4 d-flex align-items-center">
                  <button class="btn btn-6 btn-dark w-100" onclick="limpiarFiltros()">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                        width="24" height="24" viewBox="0 0 24 24"  
                        fill="none" stroke="currentColor" stroke-width="2"  
                        stroke-linecap="round" stroke-linejoin="round"  
                        class="icon icon-tabler icons-tabler-outline icon-tabler-eraser tex-light">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                      <path d="M19 20h-10.5l-4.21 -4.3a1 1 0 0 1 0 -1.41l10 -10a1 1 0 0 1 1.41 0l5 5a1 1 0 0 1 0 1.41l-9.2 9.3" />
                      <path d="M18 13.3l-6.3 -6.3" />
                    </svg>
                    <span clas="tex-light">Limpiar Filtros</span>
                  </button>
                </div>
              </div>
              <table id="bienes_data"  class="table card-table table-vcenter text-nowrap datatable" style="width: 99%;">
                <thead>
                    <tr>
                    <th><span title="Codigo de Barras">Cod Barras</span></th>
                    <th><span title="Fecha Registro">Nombre Objeto</span></th>
                    <th><span title="Estado del bien"></span>Estado</th>
                    <th><span title="Fecha de registro del Bien">Fecha</span></th>
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