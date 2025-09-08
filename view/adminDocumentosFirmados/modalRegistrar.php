<div class="modal modal-blur fade" id="modalRegistrar" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
            <div class="modal-header">
                <h3  id="lbltitulo" class="modal-title" style="color:rgb(255, 255, 255); display: flex; align-items: center; gap: 10px; padding: 5px 5px;"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-screen-share ms-3"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M21 12v3a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1v-10a1 1 0 0 1 1 -1h9" /><path d="M7 20l10 0" /><path d="M9 16l0 4" /><path d="M15 16l0 4" /><path d="M17 4h4v4" /><path d="M16 9l5 -5" /></svg> SUBIR NUEVO DOCUMENTO FIRMADO
                </h3>
                <button type="button" class="btn-close-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="documento_form" enctype="multipart/form-data">
                <div class="modal-body mx-4 my-2">
                    <input type="hidden" name="doc_ruta" id="doc_ruta" />
                    <input type="hidden" name="doc_id" id="doc_id"/>
                    <div class="row">
                        <div class="row mt-2">
                          <div class="col-12 col-md-2">
                            <label class="form-label">Documento <span class="text-danger">*</span></label>
                            <select class="form-select" name="doc_tipo" id="doc_tipo" required>
                                <option value="">Seleccione</option>
                                <option value="Asignacion">Asignación</option>
                                <option value="Desplazamiento">Desplazamiento</option>
                                <option value="Baja">Baja</option>
                            </select>
                          </div>
                          <div class="col-12 col-md-5">
                            <label class="form-label">Área / Dependencia <span class="text-danger">*</span></label>
                            <select class="form-select select2" id="area_asignacion_combo" name="depe_id"  data-placeholder="Seleccione Dependencia" style="width: 100%;">
                            <option value="" disabled selected>Seleccione</option>
                            </select>
                          </div>
                          <div class="col-12 col-md-5">
                            <label class="form-label">DNI/ Usuario <span class="text-danger">*</span></label>
                            <select class="form-select select2" id="usuario_combo" name="pers_id" data-placeholder="Seleccione Usuario" style="width: 100%;">
                            <option value="" disabled selected>Seleccione</option>
                            </select>
                          </div>

                          <!-- Descripción -->
                          <div class="col-12 mt-2">
                          <label class="form-label">Código Patrimoniales <span class="text-danger">*</span></label>
                          <textarea class="form-control" name="doc_desc" id="doc_desc" placeholder="Ej. 53220652-0011 , 78515535-0020 "></textarea>
                          </div>
                          <div class="col-12 mt-2">
                            <label class="form-label">Archivo PDF <span class="text-danger">*</span></label>

                            <!-- Botón visual -->
                            <button type="button" class="upload-area" id="upload_button" onclick="document.getElementById('archivo_pdf').click()">
                              <span id="upload_content">
                                <span class="upload-area-icon">
                                <svg
                                  xmlns="http://www.w3.org/2000/svg"
                                  xmlns:xlink="http://www.w3.org/1999/xlink"
                                  width="35"
                                  height="35"
                                  viewBox="0 0 340.531 419.116"
                                 >
                                  <g id="files-new" clip-path="url(#clip-files-new)">
                                    <path
                                      id="Union_2"
                                      data-name="Union 2"
                                      d="M-2904.708-8.885A39.292,39.292,0,0,1-2944-48.177V-388.708A39.292,39.292,0,0,1-2904.708-428h209.558a13.1,13.1,0,0,1,9.3,3.8l78.584,78.584a13.1,13.1,0,0,1,3.8,9.3V-48.177a39.292,39.292,0,0,1-39.292,39.292Zm-13.1-379.823V-48.177a13.1,13.1,0,0,0,13.1,13.1h261.947a13.1,13.1,0,0,0,13.1-13.1V-323.221h-52.39a26.2,26.2,0,0,1-26.194-26.195v-52.39h-196.46A13.1,13.1,0,0,0-2917.805-388.708Zm146.5,241.621a14.269,14.269,0,0,1-7.883-12.758v-19.113h-68.841c-7.869,0-7.87-47.619,0-47.619h68.842v-18.8a14.271,14.271,0,0,1,7.882-12.758,14.239,14.239,0,0,1,14.925,1.354l57.019,42.764c.242.185.328.485.555.671a13.9,13.9,0,0,1,2.751,3.292,14.57,14.57,0,0,1,.984,1.454,14.114,14.114,0,0,1,1.411,5.987,14.006,14.006,0,0,1-1.411,5.973,14.653,14.653,0,0,1-.984,1.468,13.9,13.9,0,0,1-2.751,3.293c-.228.2-.313.485-.555.671l-57.019,42.764a14.26,14.26,0,0,1-8.558,2.847A14.326,14.326,0,0,1-2771.3-147.087Z"
                                      transform="translate(2944 428)"
                                      fill="var(--c-action-primary)"
                                    ></path>
                                  </g>
                                </svg>
                              </span>
                                <span class="upload-area-title">Arrastre el archivo aquí o haga clic</span>
                                <span class="upload-area-description">
                                  Solo se permiten archivos PDF firmados.<br /><strong>Clic Aqui</strong>
                                </span>
                              </span>
                            </button>

                            <!-- Input real de archivo (oculto) -->
                            <input type="file" name="archivo_pdf" id="archivo_pdf" accept="application/pdf" style="display: none;">
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