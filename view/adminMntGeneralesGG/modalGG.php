<div class="modal modal-blur fade" id="modalGG" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
            <div class="modal-header">
                <h3  id="lbltitulo" class="modal-title" style="color:rgb(255, 255, 255); display: flex; align-items: center; gap: 10px; padding: 5px 5px;">
                </h3>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="GG_form" >
                <div class="modal-body m-4">
                    <input type="hidden" name="ggidgene" id="ggidgene"/>
                    <div class="row">
                        <div class="col-12">
                            <h4 class="text-orange">
                                DEFINA LOS DATOS DEL GRUPO GENERICO
                            </h4>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Nombre Grupo Genérico:<span style="color:red"> *</span></label>
                                <div class="input-icon mb-1">
                                    <span class="input-icon-addon">
                                        <!-- Icono Tabler: layers -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-layers" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <polyline points="12 3 20 7 12 11 4 7 12 3" />
                                            <polyline points="4 13 12 17 20 13" />
                                            <polyline points="4 17 12 21 20 17" />
                                        </svg>
                                    </span>
                                    <input type="text" class="form-control" id="ggnomgene" name="ggnomgene"
                                        pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ ]{3,50}$"
                                        title="Solo letras y espacios. Mínimo 3 caracteres."
                                        maxlength="50"
                                        placeholder="Ingrese nombre del grupo">
                                </div>
                                <div class="error-msg" id="errorNombre">Ingrese un nombre válido (solo letras y espacios).</div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Código Grupo Genérico:<span style="color:red"> *</span></label>
                                <div class="input-icon mb-1">
                                    <span class="input-icon-addon">
                                        <!-- Icono Tabler: hash -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-hash" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <line x1="4" y1="9" x2="20" y2="9" />
                                            <line x1="4" y1="15" x2="20" y2="15" />
                                            <line x1="10" y1="4" x2="8" y2="20" />
                                            <line x1="16" y1="4" x2="14" y2="20" />
                                        </svg>
                                    </span>
                                    <input type="text" class="form-control" id="ggcodgene" name="ggcodgene"
                                        pattern="^[0-9]{2,4}$"
                                        title="Solo números del catálogo (2 a 4 dígitos)."
                                        maxlength="4"
                                        placeholder="Ingrese código del grupo">
                                </div>
                                <div class="error-msg" id="errorCodigo">Ingrese un código válido (solo números de 2 a 4 dígitos).</div>
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