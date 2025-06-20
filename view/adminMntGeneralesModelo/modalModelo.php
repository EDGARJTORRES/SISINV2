<div class="modal modal-blur fade" id="modalModelo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
            <div class="modal-header">
                <h3  id="lbltitulo" class="modal-title"style="color:rgb(255, 255, 255); display: flex; align-items: center; gap: 10px; padding: 5px 5px;">
                </h3>
                <button type="button" class="btn-close-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="modelo_form">
                <div class="modal-body m-4">
                    <input type="hidden" name="modelo_id" id="modelo_id"/>
                    <div class="row">
                        <div class="col-12">
                            <h5 id="lblsubtitulo" class="text-orange">
                            </h5>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Marca<span style="color:red"> *</span></label>
                                <div class="input-icon mb-1">
                                    <span class="input-icon-addon">
                                        <!-- Icono Tabler: tag -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-tag" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M5 7v-2a2 2 0 0 1 2 -2h2" />
                                            <path d="M15 3h4a2 2 0 0 1 2 2v4l-10 10a2 2 0 0 1 -2 0l-6 -6a2 2 0 0 1 0 -2l10 -10z" />
                                            <path d="M16 7l-1.5 -1.5" />
                                        </svg>
                                    </span>
                                    <select class="form-select select2" id="combo_marca_obj" name="combo_marca_obj">
                                        <option value="">Seleccione Marca</option>
                                    </select>
                                </div>
                                <div class="error-msg" id="errorCombo">Por favor, seleccione una marca válida.</div>  
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Modelo:<span style="color:red"> *</span></label>
                                <div class="input-icon mb-1">
                                    <span class="input-icon-addon">
                                        <!-- Icono Tabler: settings -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-settings" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M12 9a3 3 0 1 0 3 3a3 3 0 0 0 -3 -3" />
                                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06 .06a2 2 0 1 1 -2.83 2.83l-.06 -.06a1.65 1.65 0 0 0 -1.82 -.33a1.65 1.65 0 0 0 -1 1.51v.12a2 2 0 1 1 -4 0v-.12a1.65 1.65 0 0 0 -1 -1.51a1.65 1.65 0 0 0 -1.82 .33l-.06 .06a2 2 0 1 1 -2.83 -2.83l.06 -.06a1.65 1.65 0 0 0 .33 -1.82a1.65 1.65 0 0 0 -1.51 -1h-.12a2 2 0 1 1 0 -4h.12a1.65 1.65 0 0 0 1.51 -1a1.65 1.65 0 0 0 -.33 -1.82l-.06 -.06a2 2 0 0 1 2.83 -2.83l.06 .06a1.65 1.65 0 0 0 1.82 .33h.06a1.65 1.65 0 0 0 1 -1.51v-.12a2 2 0 1 1 4 0v.12a1.65 1.65 0 0 0 1 1.51h.06a1.65 1.65 0 0 0 1.82 -.33l.06 -.06a2 2 0 1 1 2.83 2.83l-.06 .06a1.65 1.65 0 0 0 -.33 1.82v.06a1.65 1.65 0 0 0 1.51 1h.12a2 2 0 1 1 0 4h-.12a1.65 1.65 0 0 0 -1.51 1z" />
                                        </svg>
                                    </span>
                                    <input type="text" class="form-control" id="modelo_nom" name="modelo_nom"
                                        pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9 ]{3,50}$"
                                        title="Solo letras, números y espacios. Mínimo 3 caracteres."
                                        maxlength="50"
                                        placeholder="Ingrese modelo">
                                </div>
                                <div class="error-msg" id="errorNombre">Ingrese un nombre válido (solo letras, números y espacios).</div>  
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background-color: #f9fafb ;">
                    <button type="submit" name="action" value="add" class="btn btn-orange">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-checks"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12l5 5l10 -10" /><path d="M2 12l5 5m5 -5l5 -5" /></svg>
                        Guardar
                    </button>
                    <button type="reset" id="btnCancelar" class="btn btn-outline-secondary" aria-label="Close" aria-hidden="true" data-dismiss="modal">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>