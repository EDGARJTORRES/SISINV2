<div class="modal fade" id="modalHistorial" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
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
              HISTORIAL DE BIENES PATRIMONIALES
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="col-12">
            <div class="table-responsive">
              <div class="row">
                <div class="col-lg-4 mb-2">
                  <div class="input-icon" style="width: 390px;">
                      <span class="input-icon-addon">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                      </span>
                      <input type="text" id="buscar_bajas" class="form-control" placeholder="Buscar registro de  baja de bienes . . ."> 
                  </div>
                </div>
                <div class="col-lg-4 mb-2 mx-6">
                  <div class="input-icon" id="contenedor-excel"> 
                  </div>
                </div>
              </div>
              <table id="tblHistorial" class="table" style="width:100%">
                  <thead>
                  <tr>
                    <th>Fech. Baja</th>
                    <th>Usuario Eliminador</th>
                    <th>Cód. Barras</th>
                    <th>Nombre</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Serie</th>
                    <th>Valor</th>
                    <th>Motivo</th>
                    <th>Acciones</th> 
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