<div class="modal modal-blur fade" id="modalUbicacion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-3 modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3  id="lbltitulo" class="modal-title" style="color:rgb(255, 255, 255); display: flex; align-items: center; gap: 10px; padding: 5px 5px;">
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="obj_form">
                    <div class="modal-body">
                       <input type="hidden" name="ubicacion_id" id="ubicacion_id"/>
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Nombre Ubicacion:<span  style="color:red"> *</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a type="submit" name="action" value="add" class="btn btn-primary " data-bs-dismiss="modal">
                           <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-checks"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12l5 5l10 -10" /><path d="M2 12l5 5m5 -5l5 -5" /></svg>
                            Guardar
                        </a>
                        <a type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>