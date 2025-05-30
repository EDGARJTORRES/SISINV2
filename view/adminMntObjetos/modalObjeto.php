<div class="modal modal-blur fade" id="modalObjeto" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3  id="lbltituloObj" class="modal-title" style="color:rgb(255, 255, 255); display: flex; align-items: center; gap: 10px; padding: 5px 5px;">
                </h3>
                <button type="button" class="btn-close-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="obj_form">
                    <div class="modal-body">
                        <input type="hidden" name="obj_id" id="obj_id" />
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="text-orange">
                                        DEFINA LOS DATOS DEL OBJETO
                                    </h4>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Denominación:<span  style="color:red"> *</span></label>
                                        <input type="text" class="form-control" id="obj_nombre" name="obj_nombre"  pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ ]{3,50}$"
                                        title="Solo letras y espacios. Mínimo 3 caracteres."
                                        maxlength="50">
                                        <div class="error-msg" id="errorNombre">Ingrese un nombre válido (solo letras y espacios).
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Catálogo Nacional:<span  style="color:red"> *</span></label>
                                        <input type="text" class="form-control" id="codigo_cana" name="codigo_cana" 
                                        pattern="^[0-9]{8,20}$"
                                        title="Ingrese un código válido: solo números, entre 8 y 20 dígitos."
                                        maxlength="20">
                                        <div class="error-msg" id="errorCodigo">
                                            Ten en cuenta los codigos de Grupo Generico y Clase  (8 a mas dígitos).
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="action" value="add" class="btn btn-orange tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" >
                           <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-checks"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12l5 5l10 -10" /><path d="M2 12l5 5m5 -5l5 -5" /></svg>
                             Guardar
                        </button>
                        <button type="reset" class="btn btn-outline-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" aria-label="Close" aria-hidden="true" data-dismiss="modal">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    