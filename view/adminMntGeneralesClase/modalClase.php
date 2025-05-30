<div class="modal modal-blur fade" id="modalClase" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3  id="lbltitulo" class="modal-title" style="color:rgb(255, 255, 255); display: flex; align-items: center; gap: 10px; padding: 5px 5px;">
                </h3>
                <button type="button"  class="btn-close btn-close-white"  data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="clase_form">
                    <div class="modal-body">
                        <input type="hidden" name="clase_id" id="clase_id"/>
                        <div class="row">
                            <div class="col-12">
                                <h4 class="text-orange">
                                DEFINA LOS DATOS DE LA CLASE A REGISTRAR:
                                </h4>
                            </div>  
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Nombre Clase:<span  style="color:red"> *</span></label>
                                    <input type="text" class="form-control" name="clase_nom" id="clase_nom"
                                        pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ ]{3,50}$"
                                        title="Solo letras y espacios. Mínimo 3 caracteres."
                                        maxlength="50">
                                    <div class="error-msg" id="errorNombre">Ingrese un nombre válido (solo letras y espacios).</div>  
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Codigo:<span  style="color:red"> *</span></label>
                                    <input type="number" class="form-control" name="clase_cod" id="clase_cod"
                                        pattern="^[0-9]{2,4}$"
                                        title="Solo números del catálogo (2 a 4 dígitos)."
                                        maxlength="4">
                                    <div class="error-msg" id="errorCodigo">Ingrese un código válido (solo números de 2 a 4 dígitos).</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="action" value="add" class="btn btn-orange">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-checks"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12l5 5l10 -10" /><path d="M2 12l5 5m5 -5l5 -5" /></svg>
                            Guardar
                        </button>
                        <button type="reset" class="btn btn-outline-secondary" aria-label="Close" aria-hidden="true" data-dismiss="modal">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>