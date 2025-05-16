<style>
    #lock {
        display: none;
    }

    .lock-label {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgb(80, 80, 80);
        border-radius: 15px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .lock-wrapper {
        width: fit-content;
        height: fit-content;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transform: rotate(-10deg);
    }

    .shackle {
        background-color: transparent;
        height: 9px;
        width: 14px;
        border-top-right-radius: 10px;
        border-top-left-radius: 10px;
        border-top: 3px solid white;
        border-left: 3px solid white;
        border-right: 3px solid white;
        transition: all 0.3s;
    }

    .lock-body {
        width: 15px;
    }

    #lock:checked+.lock-label .lock-wrapper .shackle {
        transform: rotateY(150deg) translateX(3px);
        transform-origin: right;
    }

    #lock:checked+.lock-label {
        background-color: rgb(167, 71, 245);
    }

    .lock-label:active {
        transform: scale(0.9);
    }
</style>


<div class="modal modal-blur fade" id="modalObjetoCate" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 80%; margin: auto;">
        <div class="modal-content">
            <div class="modal-header">
                <h5  id="lbltituloObjcate" class="modal-title" style="color: #004085; display: flex; align-items: center; gap: 10px; background-color: rgb(247, 249, 250); padding: 8px 8px; border-left: 5px solid #17a2b8; border-radius: 6px; width:100%;">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-screen-share ms-3"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M21 12v3a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1v-10a1 1 0 0 1 1 -1h9" /><path d="M7 20l10 0" /><path d="M9 16l0 4" /><path d="M15 16l0 4" /><path d="M17 4h4v4" /><path d="M16 9l5 -5" /></svg>
                      Nuevo Registro
                </h5>
                <div id="edit_block" style="display: none">
                    <input type="checkbox" id="lock" checked />
                    <label for="lock" class="lock-label">
                        <span class="lock-wrapper">
                            <span class="shackle"></span>
                            <svg class="lock-body" width="" height="" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0 5C0 2.23858 2.23858 0 5 0H23C25.7614 0 28 2.23858 28 5V23C28 25.7614 25.7614 28 23 28H5C2.23858 28 0 25.7614 0 23V5ZM16 13.2361C16.6137 12.6868 17 11.8885 17 11C17 9.34315 15.6569 8 14 8C12.3431 8 11 9.34315 11 11C11 11.8885 11.3863 12.6868 12 13.2361V18C12 19.1046 12.8954 20 14 20C15.1046 20 16 19.1046 16 18V13.2361Z" fill="#ccc"></path>
                            </svg>
                        </span>
                    </label>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post"  id="bien_form">
                    <div class="modal-body">
                        <input type="hidden" name="bien_id" id="bien_id" />
                        <input type="hidden" name="obj_id" id="obj_id" />
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label">Grupo Generico:<span  style="color:red"> *</span></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label">Clase:<span  style="color:red"> *</span></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label">Objeto:<span  style="color:red"> *</span></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Marca:<span  style="color:red"> *</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Modelo:<span  style="color:red"> *</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Dimensiones:<span  style="color:red"> *</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">N° Serie:<span  style="color:red"> *</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Fecha de Registro:<span  style="color:red"> *</span></label>
                                        <input type="date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Codigo Interno:<span  style="color:red"> *</span></label>
                                        <input type="text" class="form-control" disabled="" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Color:<span style="color:red"> *</span></label>
                                        <select class="form-select" id="select-color" multiple>
                                        <option value="R">Rojo</option>
                                        <option value="V">Verde</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Muestra de barra:<span  style="color:red"> *</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Codigo Generado:<span  style="color:red"> *</span></label>
                                        <input type="text" class="form-control" disabled="" >
                                    </div>
                                </div>
                            </div>    
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a type="submit" name="action" value="add" class="btn btn-primary " data-bs-dismiss="modal">
                           <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-checks"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12l5 5l10 -10" /><path d="M2 12l5 5m5 -5l5 -5" /></svg>
                            Guardar
                        </a>
                        <a type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    // Obtener la fecha actual
    var fecha = new Date();
    var opcionesFecha = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    };
    var fechaFormateada = fecha.toLocaleDateString('es-ES', opcionesFecha);

    // Actualizar el contenido del elemento con el id "fecha"
    document.getElementById('lbltituloObjcate').innerHTML += fechaFormateada;
</script>
<script>
    // Escuchar el cambio en el estado del checkbox
    // Deshabilitar los campos al cargar la página
    $("#combo_gg_bien_obj, #combo_clase_bien_obj, #combo_obj_bien").prop("disabled", true);

    // Escuchar el cambio en el estado del checkbox
    $("#lock").change(function() {
        // Verificar si el checkbox está marcado
        var isLocked = $(this).prop("checked");

        // Habilitar o deshabilitar los selects según el estado del checkbox
        $("#combo_gg_bien_obj, #combo_clase_bien_obj, #combo_obj_bien").prop("disabled", isLocked);

        // Actualizar el color del icono de bloqueo de acuerdo al estado del checkbox
        if (isLocked) {
            $(".lock-label .lock-body").attr("fill", "#ccc");
        } else {
            $(".lock-label .lock-body").attr("fill", "white");
        }
    });
</script>