<div class="modal modal-blur fade" id="modalMarca" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-3 modal-dialog-centered" role="document">
        <div class="modal-content" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
            <div class="modal-header">
                <h3  id="lbltitulo" class="modal-title" style="color:rgb(255, 255, 255); display: flex; align-items: center; gap: 10px; padding: 5px 5px;">
                </h3>
                <button type="button" class="btn-close-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="marca_form">
                <div class="modal-body m-4">
                    <input type="hidden" name="marca_id" id="marca_id"/>
                    <div class="row">
                        <div class="col-lg-12">
                            <h5 id="lblsubtitulo" class="text-orange">
                                POR FAVOR, COMPLETE LOS DATOS DE LA MARCA A REGISTRAR
                            </h5>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-2">
                                <label class="form-label">Nombre Marca:<span style="color:red"> *</span></label>
                                <div class="input-icon mb-1">
                                    <span class="input-icon-addon">
                                        <!-- Icono Tabler: trademark -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-1">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M4.5 9h5" />
                                            <path d="M7 9v6" />
                                            <path d="M13 15v-6l3 4l3 -4v6" />
                                        </svg>
                                    </span>
                                    <input type="text" class="form-control" name="marca_nom" id="marca_nom" 
                                        pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ ]{2,50}$"
                                        title="Solo letras y espacios. Mínimo 2 caracteres."
                                        maxlength="50"
                                        placeholder="Ingrese nombre de la marca">
                                </div>
                                <div class="error-msg" id="errorNombre">Ingrese un nombre válido (solo letras y espacios).</div>  
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background-color: #f9fafb ;">
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