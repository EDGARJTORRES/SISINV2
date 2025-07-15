<div class="modal fade" id="modalObjetoCate" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
        <div class="modal-header bg-black text-white">
            <h5 class="modal-title d-flex align-items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M21 12v3a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1v-10a1 1 0 0 1 1 -1h9" />
                <path d="M7 20l10 0" />
                <path d="M9 16l0 4" />
                <path d="M15 16l0 4" />
                <path d="M17 4h4v4" />
                <path d="M16 9l5 -5" />
            </svg>
            NUEVO REGISTRO DE ALTA DE BIENES
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <ul class="nav nav-tabs  p-3" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#step1" type="button">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-folder mx-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" /></svg>
                    CLASIFICACION
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#step2" type="button">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-ruler-off mx-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 4h11a1 1 0 0 1 1 1v5a1 1 0 0 1 -1 1h-4m-3.713 .299a1 1 0 0 0 -.287 .701v7a1 1 0 0 1 -1 1h-5a1 1 0 0 1 -1 -1v-14c0 -.284 .118 -.54 .308 -.722" /><path d="M4 8h2" /><path d="M4 12h3" /><path d="M4 16h2" /><path d="M12 4v3" /><path d="M16 4v2" /><path d="M3 3l18 18" /></svg>
                    IDENTIFICACION TECNICA
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#step3" type="button">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-camera-dollar mx-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M13 20h-8a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v1.5" /><path d="M14.935 12.375a3.001 3.001 0 1 0 -1.902 3.442" /><path d="M21 15h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5" /><path d="M19 21v1m0 -8v1" /></svg>
                    CARACTERISTICAS
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#step4" type="button">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-progress-help mx-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 16v.01" /><path d="M12 13a2 2 0 0 0 .914 -3.782a1.98 1.98 0 0 0 -2.414 .483" /><path d="M10 20.777a8.942 8.942 0 0 1 -2.48 -.969" /><path d="M14 3.223a9.003 9.003 0 0 1 0 17.554" /><path d="M4.579 17.093a8.961 8.961 0 0 1 -1.227 -2.592" /><path d="M3.124 10.5c.16 -.95 .468 -1.85 .9 -2.675l.169 -.305" /><path d="M6.907 4.579a8.954 8.954 0 0 1 3.093 -1.356" /></svg>
                    DATOS DE ADQUISICIÓN 
                </button>
            </li>

        </ul>
        <form method="post" id="bien_form">
            <div class="modal-body tab-content p-4">
                <input type="hidden" name="bien_id" id="bien_id" />
                <input type="hidden" name="obj_id" id="obj_id" />
                <input type="hidden" id="modelo_id" name="modelo_id">
                <input type="hidden" id="codigo_barras_input" name="codigo_barras_input" />
                <div class="row mb-3 justify-content-center">
                    <div class="col-lg-6 text-center">
                        <canvas id="codigo_barras_canvas" style="border: 1px solid #ccc;"></canvas>
                    </div>
                </div>
                <div class="tab-pane fade show active" id="step1" role="tabpanel">
                    <div class="row g-3" >
                        <div class="hr-text hr-text-center hr-text-spaceless my-4 fs-4">Clasificación Patrimonial</div>
                        <div class="col-lg-9">
                            <label class="form-label">Objeto <span class="text-danger">*</span></label>
                            <select class="form-select select2 required" id="combo_obj_bien" name="obj_id" data-placeholder="Seleccione el Objeto">
                                <option></option> 
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Cantidad:<span style="color:red"> *</span></label>
                            <div class="form-group" >
                                <input type="number" id="cantidad_bienes" class="form-control" value="1" min="1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="step2" role="tabpanel">
                    <div class="row g-3" id="contenedor_ident_tecnica">
                        <div class="hr-text hr-text-center hr-text-spaceless my-4 fs-4"> Identificación Técnica del Bien</div>
                        <div class="col-lg-3">
                            <label class="form-label">Marca <span class="text-danger">*</span></label>
                            <select class="form-select select2 required" id="combo_marca_obj" name="marca_id" data-placeholder="Seleccione la marca">
                                <option></option> <!-- Obligatorio para Select2 mostrar placeholder -->
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Modelo <span class="text-danger">*</span></label>
                            <select class="form-select select2 required" id="combo_modelo_obj" name="modelo_id" data-placeholder="Seleccione el modelo">
                                <option></option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Dimensiones <span class="text-danger">*</span></label>
                            <input type="text" class="form-control required" id="obj_dim" name="obj_dim" placeholder="Ej: 40x30x20 cm">
                        </div>

                        <!-- N° Serie -->
                        <div class="col-lg-3">
                            <label class="form-label">N° Serie <span class="text-danger">*</span></label>
                            <input type="text" class="form-control required" id="bien_numserie" name="bien_numserie" placeholder="Ingrese el N° de serie">
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="step3" role="tabpanel">
                    <div class="hr-text hr-text-center hr-text-spaceless my-5 fs-4">  Características Generales del Bien</div>
                    <div class="row g-3"  id="contenedor_caracteristicas">
                        <div class="col-lg-3">
                            <label class="form-label">Características <span class="text-danger">*</span></label>
                            <textarea class="form-control required" name="bien_obs" id="bien_obs" rows="1" placeholder="Describa las características..." style="resize: none;"></textarea>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">N° Cuenta Contable <span class="text-danger"> *</span></label>
                            <input type="text" class="form-control" id="bien_cuenta" name="bien_cuenta" placeholder="Ej: 9105.0301">
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Color <span class="text-danger">*</span></label>
                            <select class="form-select select2 required" id="combo_color_bien" name="bien_color" data-placeholder="Seleccione uno o más colores" multiple>
                            <option></option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Procedencia:<span style="color:red"> *</span></label>
                            <select class="form-select select2 required" id="procedencia"  name="procedencia" data-placeholder="Seleccione la procedencia">
                                <option value="NACIONAL">Nacional</option>
                                <option value="DONADO">Donado</option>
                            </select>  
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="step4" role="tabpanel">
                        <div class="hr-text hr-text-center hr-text-spaceless my-5 fs-4"> Datos de Adquision del Bien</div>
                    <div class="row g-3" id="contenedor_adquisicion">
                        <div class="col-lg-3">
                            <label class="form-label">Fecha de Adquisición <span class="text-danger">*</span></label>
                            <div class="input-group" >
                                <input id="fecharegistro" name ="fecharegistro" type="text" class="form-control" placeholder="Año/Mes/Dia">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Valor de Adquisición <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="val_adq" name="val_adq" placeholder="Ej: S/ 1,200.00" required>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">N° Doc. Adquisición <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="doc_adq" name="doc_adq" placeholder="Ej: NEA 2001, O/C 716" required>

                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Codigo Interno:<span style="color:red"> *</span></label>
                            <div class="form-group">
                                <input class="form-control tx-uppercase" id="cod_interno" type="text" name="cod_interno" readonly />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"  style="background-color: #f9fafb ;">
                <button type="submit" name="action" value="add" class="btn btn-orange">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M17 3v4h-10v-4a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2" />
                        <path d="M7 8h10v13h-10z" />
                        <path d="M10 12h4" />
                    </svg>
                    Guardar
                </button>
            </div>
        </form>
    </div>
  </div>
</div>