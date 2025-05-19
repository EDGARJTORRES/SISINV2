<div id="modalObjetoCate" class="modal fade" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document" style="min-width: 700px;">
        <div class="modal-content bd-20" style="border: 1px solid rgb(8 198 53);  box-shadow: 0 0 5px rgb(8 198 53);">
            <div class="modal-header pd-y-20 pd-x-25" style="background-color: rgb(8 198 53);">
                <h6 id="lbltituloObjcate" class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"> Nuevo Registro </h6>
            </div>
            <!-- Formulario Mantenimiento -->
            <form method="post" id="obj_depe_form">
                <div class="modal-body">
                    <input type="hidden" name="objdepe_id" id="objdepe_id" />

                    <div class="container">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-control-label">Grupo Generico: <span class="tx-danger">*</span></label>
                                <div class="form-group">
                                    <select class="form-control select2" style="width: 100%" id="combo_gg_depe_obj" name="combo_gg_depe_obj" required>

                                    </select>
                                </div>
                                <label class="form-control-label">Clase:<span class="tx-danger">*</span></label>
                                <div class="form-group">
                                    <select class="form-control select2" style="width: 100%" id="combo_clase_depe_obj" name="combo_clase_depe_obj" required>

                                    </select>
                                </div>
                                <div class="container">
                                    <div class="row" style="margin-left: -30px;  margin-right: -30px;">
                                        <div class="col-8">
                                            <label class="form-control-label">Objeto: <span class="tx-danger">*</span></label>
                                            <div class="form-group">
                                                <select class="form-control select2" style="width: 100%" id="combo_obj_depe" name="combo_obj_depe" required>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <label class="form-control-label" style="margin-top: 5px;">Color: <span class="tx-danger">*</span></label>
                                            <div class="form-group">
                                                <input type="text" id="showPaletteOnly" required>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="container">
                                    <div class="row" style="margin-left: -30px;  margin-right: -30px;">
                                        <div class="col-6">
                                            <label class="form-control-label">Marca: <span class="tx-danger">*</span></label>
                                            <div class="form-group">
                                                <select class="form-control select2" style="width: 100%" id="combo_marca_obj" name="combo_marca_obj" required>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-control-label">Modelo <span class="tx-danger">*</span></label>
                                            <div class="form-group">
                                                <input class="form-control tx-uppercase" style="width: 100%" id="obj_modelo" type="text" name="obj_modelo" required />
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <label class="form-control-label">N° Serie: <span class="tx-danger">*</span></label>
                                <div class="form-group">
                                    <input class="form-control tx-uppercase" style="width: 100%" id="objdepe_numserie" type="text" name="objdepe_numserie" required />
                                </div>


                            </div>
                            <div class="col-6">
                                <label class="form-control-label">Barras: <span class="tx-danger">*</span></label>
                                <div style="width: 100px;     min-height: 85px;">
                                    <canvas id="codigo_barras_canvas" style="max-width: 300px; border: 1px solid #ccc;"></canvas>
                                </div>
                                <div class="countiner">
                                    <div class="row">
                                        <div class="col-2">
                                        <button class="btn btn-primary" type="button" onclick="generarBarras()"><i class="fa fa-search text-white"></i></button>
                                        </div>
                                        <div class="col-10">
                                        <div class="form-group">
                                                <input class="form-control tx-uppercase" style="width: 100%" id="codigo_barras_input" type="text" name="codigo_barras_input" required />
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <label class="form-control-label">Fecha de Registro: <span class="tx-danger">*</span></label>
                                <div class="input-group" style="margin-bottom: 10px;">
                                    <span class="input-group-addon"><i class="fa fa-calendar tx-16 lh-0 op-6"></i></span>
                                    <input id="fecharegistro" type="text" class="form-control" placeholder="YYYY/MM/DD">
                                </div>
                                <label class="form-control-label" style="margin-top: 10px;">Código Interno: <span class="tx-danger">*</span></label>
                                <div class="form-group" style="margin-top: -3px;">
                                    <input class="form-control tx-uppercase" style="width: 100%" id="cod_interno" type="text" name="cod_interno" required />
                                </div>
                                <label class="form-control-label">Dimenciones <span class="tx-danger">*</span></label>
                                <div class="form-group">
                                    <input class="form-control tx-uppercase" style="width: 100%" id="obj_dim" type="text" name="obj_dim" required />
                                </div>


                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="action" value="add" class="btn btn-outline-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium"><i class="fa fa-check"></i> Guardar</button>
                        <button type="reset" class="btn btn-outline-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" aria-label="Close" aria-hidden="true" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
                    </div>
                </div>
            </form>
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
    // Obtener el elemento input de código de barras y el canvas
    var inputCodigoBarras = document.getElementById("codigo_barras_input");
    var canvas = document.getElementById("codigo_barras_canvas");
    var ctx = canvas.getContext("2d");
    // Establecer el tamaño fijo del canvas
    canvas.width = 250; // Ancho del casnvas
    canvas.height = 100; // Alto del canvas


    // Agregar un listener para el evento input
    inputCodigoBarras.addEventListener("input", function() {
        // Obtener el nuevo valor del input de código de barras
        var codigoBarras = inputCodigoBarras.value;

        // Limpiar el canvas
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Generar el código de barras usando JsBarcode
        JsBarcode(canvas, codigoBarras, {
            format: "CODE128",
            displayValue: true,
            fontOptions: "bold",
            textAlign: "center",
            textMargin: 10,
            fontSize: 14,
            width: 2,
            height: 30
        });

    });
</script>