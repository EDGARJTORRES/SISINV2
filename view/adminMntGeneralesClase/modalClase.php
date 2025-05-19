<div class="modal modal-blur fade" id="modalClase" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5  id="lbltitulo" class="modal-title" style="color: #004085; display: flex; align-items: center; gap: 10px; background-color: rgb(247, 249, 250); padding: 8px 8px; border-left: 5px solid #17a2b8; border-radius: 6px; width:100%;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-screen-share ms-3">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M21 12v3a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1v-10a1 1 0 0 1 1 -1h9" />
                    <path d="M7 20l10 0" />
                    <path d="M9 16l0 4" />
                    <path d="M15 16l0 4" />
                    <path d="M17 4h4v4" />
                    <path d="M16 9l5 -5" />
                </svg>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="obj_form">
                    <div class="modal-body">
                        <input type="hidden" name="clase_id" id="clase_id"/>
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nombre Clase:<span  style="color:red"> *</span></label>
                                        <input type="text" class="form-control" name="clase_nom" id="clase_nom">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Codigo:<span  style="color:red"> *</span></label>
                                        <input type="text" class="form-control" name="clase_cod" id="clase_cod">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="submit" name="action" value="add" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium"><i class="fa fa-check"></i> Guardar</button>
                    <button type="reset" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" aria-label="Close" aria-hidden="true" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>