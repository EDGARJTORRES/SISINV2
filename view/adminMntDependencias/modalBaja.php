<div class="modal fade" id="modalBaja" tabindex="-1" aria-hidden="true">
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
            LISTADO DE BIENES CON DEPENDENCIAS
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="col-12">
            <div class="card"> 
              <div class="row">
                <div class="col-md-4">
                  <div class="list-group list-group-flush" id="lista-items">
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="p-2 position-relative text-center">
                    <h4 id="mensaje-inicial" class="mb-2 text-muted">Seleccione una dependencia</h4>
                    <p id="subtitulo-inicial" class="text-secondary">
                      Utilice el panel de navegación ubicado a la izquierda para explorar las diferentes dependencias. 
                      Una vez que seleccione una opción, la información correspondiente se mostrará en este espacio.
                    </p>
                    <div class="d-flex justify-content-center my-4">
                    </div>
                    <div id="detalle-contenido" class="position-relative">
                       <img id="cargando-detalle" 
                          src="../../public/logo_mpch2.png" 
                          alt="Cargando..." 
                          class="img-fluid"
                          style="max-width: 280px; height: auto; opacity: 0.2;">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>