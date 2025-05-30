
<div class="modal modal-blur fade" id="modalAsignacion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 80%; margin: auto;">
        <div class="modal-content">
            <div class="modal-header">
                <h5  id="lbltitulo" class="modal-title" style="color:rgb(255, 255, 255); display: flex; align-items: center; gap: 10px; padding: 5px 5px;">
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post"  id="asignacion_form">
                <div class="modal-body">
                    <input type="hidden" name="bien_id" id="bien_id" />
                    <input type="hidden" name="obj_id" id="obj_id" />
                    <div class="card-body">
                        <h3 class="card-title">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-list-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 15m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M18.5 18.5l2.5 2.5" /><path d="M4 6h16" /><path d="M4 12h4" /><path d="M4 18h4" /></svg>
                            Registro por Anexos creado <span class="text-secondary">(Ordenados por fecha)</span>
                        </h3>
                        <hr class="w-3/5 mx-auto border-t border-gray-300" />
                        <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                            <label class="form-label">Área Destino:<span style="color:red"> *</span></label>
                            <select class="form-select select2" id="area_asignacion_combo" name="area_asignacion_combo"  data-placeholder="Seleccione Destino" style="width: 100%;">
                            <option value="" disabled selected>Seleccione</option>
                            </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                            <div class="row">
                                <div class="col-12">
                                <label class="form-label">Código de Barras:<span style="color:red"> *</span></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                <input type="text" class="form-control" id="cod_bar" name="cod_bar">
                                </div>
                                <div class="col-3 d-flex align-items-center">
                                <button type="button" class="btn btn-info w-100 bg-red  px-2 d-flex align-items-center justify-content-center gap-1" id="buscaObjeto" onclick="buscarBien()">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                    <path d="M12 21h-5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v4.5" />
                                    <path d="M16.5 17.5m-2.5 0a2.5 2.5 0 1 0 5 0a2.5 2.5 0 1 0 -5 0" />
                                    <path d="M18.5 19.5l2.5 2.5" />
                                    </svg>
                                    <span>Buscar</span>
                                </button>
                                </div>
                                <div class="col-3 d-flex align-items-center">
                                    <button type="button" class="btn btn-info w-100 bg-red  px-2 d-flex align-items-center justify-content-center gap-1"  id="btnCamara" onclick="activarCamara()">
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-camera-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M13.5 20h-8.5a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v4" /><path d="M9 13a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /><path d="M22 22l-5 -5" /><path d="M17 22l5 -5" /></svg>
                                    <span> Escanear</span>
                                </button>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">DNI Representante:<span  style="color:red"> *</span></label>
                                <input type="number" min="0" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Nombre del Representante:<span  style="color:red"> *</span></label>
                                <input type="text" id="pers_nom" name="pers_nom" disabled="" class="form-control">
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="action" value="add" class="btn btn-orange ">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-checks"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12l5 5l10 -10" /><path d="M2 12l5 5m5 -5l5 -5" /></svg>
                        Guardar
                    </button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                        Cancelar
                   </button>
                </div>
            </form>
        </div>
    </div>
</div>