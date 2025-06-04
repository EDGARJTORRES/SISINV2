<div class="modal modal-blur fade" id="modalObjetoCate" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 80%; margin: auto;">
        <div class="modal-content">
            <div class="modal-header">
                <h5  id="lbltituloObjcate" class="modal-title"style="color:rgb(255, 255, 255); display: flex; align-items: center; gap: 10px; padding: 5px 5px;" >
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-screen-share ms-3"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M21 12v3a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1v-10a1 1 0 0 1 1 -1h9" /><path d="M7 20l10 0" /><path d="M9 16l0 4" /><path d="M15 16l0 4" /><path d="M17 4h4v4" /><path d="M16 9l5 -5" /></svg>
                      NUEVO REGISTRO DE ALTA DE BIENES
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="bien_form">
            <input type="hidden" name="bien_id" id="bien_id" />
            <input type="hidden" name="obj_id" id="obj_id" />

            <div class="row m-4 justify-content-center">
                <div class="col-lg-6 text-center">
                    <canvas id="codigo_barras_canvas" style="border: 1px solid #ccc;"></canvas>
                </div>
            </div>eyui
            <div class="card-body">
                <ul class="steps steps-orange steps-counter my-2">
                <li class="step-item active" id="step-indicator-1">CLASIFICACIÓN</li>
                <li class="step-item" id="step-indicator-2">IDENTIFICACION TÉCNICA</li>
                <li class="step-item" id="step-indicator-3">CARACTÉRISTICAS</li>
                </ul>
            </div>
            <div class=" mb-3 p-3 step-form" id="step-1">
                <div class="row">
                    <div class="col-lg-4">
                        <label class="form-label">Grupo Genérico:<span style="color:red">*</span></label>
                        <select class="form-select select2 required" id="combo_gg_bien_obj" name="combo_gg_bien_obj">
                        <option value="" disabled selected>Seleccione</option>
                        </select>
                        <div class="error-msg text-danger d-none" id="errorGrupo">Seleccione un grupo genérico válido.</div>
                    </div>
                    <div class="col-lg-4">
                        <label class="form-label">Clase:<span style="color:red">*</span></label>
                        <select class="form-select select2 required" id="combo_clase_bien_obj" name="combo_clase_bien_obj">
                        <option value="" disabled selected>Seleccione</option>
                        </select>
                        <div class="error-msg text-danger d-none" id="errorClase">Seleccione una clase válida.</div>
                    </div>
                    <div class="col-lg-4">
                        <label class="form-label">Objeto:<span style="color:red">*</span></label>
                        <select class="form-select select2 required" id="combo_obj_bien" name="combo_obj_bien">
                        <option value="" disabled selected>Seleccione</option>
                        </select>
                        <div class="error-msg text-danger d-none" id="errorObjeto">Seleccione un objeto válido.</div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                <button type="button" class="btn btn-orange" onclick="avanzarPaso(1)">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-right-dashed"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12h.5m3 0h1.5m3 0h6" /><path d="M13 18l6 -6" /><path d="M13 6l6 6" /></svg>
                    avanzar
                </button>
                </div>
            </div>

            <!-- Paso 2 -->
            <div class=" mb-3 p-3 step-form d-none" id="step-2">
                <div class="row">
                    <div class="col-lg-3">
                        <label class="form-label">Marca:<span style="color:red">*</span></label>
                        <select class="form-select select2 required" id="combo_marca_obj" name="combo_marca_obj">
                        <option value="" disabled selected>Seleccione</option>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label class="form-label">Modelo:<span style="color:red">*</span></label>
                        <select class="form-select select2 required" id="combo_modelo_obj" name="combo_modelo_obj">
                        <option value="" disabled selected>Seleccione</option>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label class="form-label">Dimensiones:<span style="color:red">*</span></label>
                        <input type="text" class="form-control required" id="obj_dim" name="obj_dim">
                    </div>
                    <div class="col-lg-3">
                        <label class="form-label">N° Serie:<span style="color:red">*</span></label>
                        <input type="text" class="form-control required" id="bien_numserie" name="bien_numserie">
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-secondary" onclick="retrocederPaso(2)">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left-dashed"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12h6m3 0h1.5m3 0h.5" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
                    Regresar
                </button>
                <button type="button" class="btn btn-orange" onclick="avanzarPaso(2)">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-right-dashed"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12h.5m3 0h1.5m3 0h6" /><path d="M13 18l6 -6" /><path d="M13 6l6 6" /></svg>
                    Avanzar
                </button>
                </div>
            </div>

            <!-- Paso 3 -->
            <div class="mb-3 p-3 step-form d-none" id="step-3">
                <div class="row">
                <div class="col-lg-3">
                   <label class="form-label">Fecha de Registro:<span style="color:red">*</span></label>
                   <input type="date" class="form-control" id="fecha_registro" name="fecha_registro" value="<?php  date_default_timezone_set('America/Lima');echo date('Y-m-d');?>" required>
                </div>
                <div class="col-lg-3">
                    <label class="form-label">Color:<span style="color:red">*</span></label>
                    <select class="form-control select2 required" id="combo_color_bien" name="combo_color_bien" multiple></select>
                </div>
                <div class="col-lg-3">
                    <label class="form-label">Procedencia:<span style="color:red">*</span></label>
                     <input type="text" class="form-control" id="cod_interno" name="cod_interno" style="display: none;" disabled>
                    <select class="form-select select2 required" id="procedencia" name="procedencia">
                        <option value="NACIONAL">NACIONAL</option>
                        <option value="DONADO">DONADO</option>
                    </select>  
                </div>
                <div class="col-lg-3">
                    <label class="form-label">Valor Adquisión:<span style="color:red">*</span></label>
                    <input type="text" class="form-control" id="val_adq" name="val_adq" required>
                </div>
                </div>
                <div class="modal-footer mt-4 d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" onclick="retrocederPaso(3)">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left-dashed"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12h6m3 0h1.5m3 0h.5" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
                        Regresar
                    </button>
                    <button type="submit" name="action" value="add" class="btn btn-orange">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-world-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20.946 12.99a9 9 0 1 0 -9.46 7.995" /><path d="M3.6 9h16.8" /><path d="M3.6 15h13.9" /><path d="M11.5 3a17 17 0 0 0 0 18" /><path d="M12.5 3a16.997 16.997 0 0 1 2.311 12.001" /><path d="M15 19l2 2l4 -4" /></svg>
                        Guardar
                    </button>
                </div>
            </div>
            </form>

        </div>
    </div>
</div>