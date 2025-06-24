<div class="modal modal-blur fade" id="modalObjeto" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
            <div class="modal-header">
                <h3  id="lbltituloObj" class="modal-title" style="color:rgb(255, 255, 255); display: flex; align-items: center; gap: 10px; padding: 5px 5px;">
                </h3>
                <button type="button" class="btn-close-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="obj_form">
                <div class="modal-body m-4 ">
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
                                    <label class="form-label">Denominación:<span style="color:red"> *</span></label>
                                    <div class="input-icon mb-1">
                                        <span class="input-icon-addon">
                                            <!-- Icono Tabler: tag -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-tag" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M20 12v-2a2 2 0 0 0 -2 -2h-2" />
                                                <path d="M12 20l-8-8a2 2 0 0 1 0 -2.828l3-3a2 2 0 0 1 2.828 0l8 8a2 2 0 0 1 0 2.828l-3 3a2 2 0 0 1 -2.828 0z" />
                                                <circle cx="9" cy="9" r="1" />
                                            </svg>
                                        </span>
                                        <input type="text" class="form-control" id="obj_nombre" name="obj_nombre"
                                            pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ ]{3,50}$"
                                            title="Solo letras y espacios. Mínimo 3 caracteres."
                                            maxlength="50"
                                            placeholder="Ingrese denominación">
                                    </div>
                                    <div class="error-msg" id="errorNombre">Ingrese un nombre válido (solo letras y espacios).</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Catálogo Nacional:<span style="color:red"> *</span></label>
                                    <div class="input-icon mb-1">
                                        <span class="input-icon-addon">
                                            <!-- Icono Tabler: barcode -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-barcode" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <rect x="2" y="5" width="1" height="14" rx="0.5" />
                                                <rect x="5" y="5" width="1" height="14" rx="0.5" />
                                                <rect x="8" y="5" width="1" height="14" rx="0.5" />
                                                <rect x="11" y="5" width="1" height="14" rx="0.5" />
                                                <rect x="14" y="5" width="1" height="14" rx="0.5" />
                                                <rect x="17" y="5" width="1" height="14" rx="0.5" />
                                                <rect x="20" y="5" width="1" height="14" rx="0.5" />
                                            </svg>
                                        </span>
                                        <input type="text" class="form-control" id="codigo_cana" name="codigo_cana"
                                            pattern="^[0-9]{8,20}$"
                                            title="Ingrese un código válido: solo números, entre 8 y 20 dígitos."
                                            maxlength="20"
                                            placeholder="Ingrese código del catálogo nacional">
                                    </div>
                                    <div class="error-msg" id="errorCodigo">
                                        Ten en cuenta los códigos de Grupo Genérico y Clase (8 a más dígitos).
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"  style="background-color: #f9fafb ;">
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
    