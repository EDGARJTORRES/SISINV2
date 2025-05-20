<div id="modalobjgg" class="modal fade" data-backdrop="static" data-keyboard="false" style="overflow-y: scroll;">
    <div class="modal-dialog modal-lg" role="document" style="min-width: 768px;">
        <div class="modal-content bd-0">
            <div class="modal-header pd-y-20 pd-x-25">
                <h6 id="lbltituloDepe" class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"></h6>
                <button type="reset" class="btn btn-outline-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" aria-label="Close" aria-hidden="true" data-dismiss="modal"><i class="fa fa-close"></i></button>
            </div>
            <div class="modal-body" style="background: #d4d4d4;">
                <input type="hidden" name="depe_id" id="depe_id" />
                <div class="row row-sm mg-t-20">
                    <div class="col-12">
                        <div class="card pd-0 bd-0 shadow-base">
                            <div class="pd-x-10 pd-t-30 pd-b-15">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div>
                                                    <h6 class="tx-13 tx-uppercase tx-inverse tx-semibold tx-spacing-1" id="titulo">Total De objetos en la Dependencia.</h6>
                                                    <p class="mg-b-0">Bienes actuales en el Grupo: </p>
                                                </div>
                                            </div><!-- d-flex -->
                                        </div>
                                        <div class="col-6" style="text-align: right;     margin-bottom: 10px;">
                                            <button class="btn btn-primary" onclick="nuevoRegistroObjetoCate()">
                                                <i class="fa fa-plus-square mr-2"></i> Nuevo Registro
                                            </button>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                        <label class="form-control-label">Clase:<span class="tx-danger">*</span></label>
                                            <div class="form-group">
                                                <select class="form-control select2" style="width: 100%" id="combo_clase_depe_obj_tabla" name="combo_clase_depe_obj_tabla" required>

                                                </select>
                                            </div>
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                            <div class="pd-x-15 pd-b-15 shadow-base" style="overflow:auto;">

                                <table id="obj_depedata" class="table table-valign-middle mg-b-0" style="width:95%">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">Objeto</th>
                                            <th style="text-align: center;">Fecha Registro</th>
                                            <th style="text-align: center;">Cod. Barras</th>
                                            <th style="text-align: center;">Estado</th>
                                            <th style="text-align: center;"></th>
                                        </tr>
                                    </thead>
                                    <tbody style="text-align: center;">
                                    </tbody>
                                </table>

                            </div>
                        </div><!-- card -->

                        <div class="card bd-0 shadow-base pd-30 mg-t-20">
                            <div class="d-flex align-items-center justify-content-between mg-b-30">
                                <h6 class="tx-13 tx-uppercase tx-inverse tx-semibold tx-spacing-1">Acciones realizadas</h6>
                            </div><!-- d-flex -->
                            <!--  <div class="table-wrapper">
                                    <table id="accion_data" class="table display responsive nowrap">
                                        <thead>
                                            <tr>
                                            <th style="text-align: center;">Cod. Reg.</th>
                                            <th style="text-align: center;">Objeto</th>
                                            <th style="text-align: center;">Fecha Registro</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                </div> -->
                            <div class="pd-x-15 pd-b-15 shadow-base" style="overflow:auto;">

                                <canvas id="donut-tasasproced" width="200" height="200"></canvas>
                                <!-- <div id="members-tickets"></div> -->
                            </div>

                        </div><!-- card -->
                    </div><!-- col-9 -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-outline-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" aria-label="Close" aria-hidden="true" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>

</script>