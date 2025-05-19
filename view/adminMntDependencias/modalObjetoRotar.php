<div id="modalObjetoRotar" class="modal fade" data-backdrop="static" data-keyboard="false" style="overflow-y: scroll;">
    <div class="modal-dialog modal-lg" role="document" style="min-width: 600px;">
        <div class="modal-content bd-20" style="border: 1px solid rgb(8 198 53);  box-shadow: 0 0 5px rgb(8 198 53);">
            <div class="modal-header pd-y-20 pd-x-25" style="background-color: rgb(8 198 53);">
                <h6 id="" class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"> Nuevo Registro</h6>
            </div>
            <!-- Formulario Mantenimiento -->
            <form method="post" id="obj_depe_form">
                <div class="modal-body">
                    <input type="hidden" name="objmov_id" id="objmov_id" />

                    <div class="container">
                        <div class="row">
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-12">
                                        <label class="form-control-label">Cod, Barras: <span class="tx-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-10" style="margin-right: -22px;">
                                        <input type="text" name="cod_bar" id="cod_bar" class="form-control" placeholder="Ingresa el codido de barras..." required>
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-info" id="" style="height: 40px;">
                                            <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 20 20" width="18" height="18">
                                                <path fill="currentColor" d="M21.71 20.29l-4.53-4.53A7.95 7.95 0 0 0 18 10a8 8 0 1 0-8 8c1.88 0 3.61-.65 4.96-1.74l4.53 4.53a1 1 0 1 0 1.42-1.42zM4 10a6 6 0 1 1 6 6 6 6 0 0 1-6-6z" />
                                            </svg>
                                        </button>

                                    </div>
                                </div>
                                <label class="form-control-label">Objeto: <span class="tx-danger">*</span></label>
                                <div class="form-group">
                                    <select class="form-control select2" style="width: 100%" id="" name="" required>
                                        <option value="" label="Seleccione"></option>
                                    </select>
                                </div>
                                <label class="form-control-label">Marca: <span class="tx-danger">*</span></label>
                                <div class="form-group">
                                    <select class="form-control select2" style="width: 100%" id="" name="" required>
                                        <option value="" label="Seleccione"></option>
                                    </select>
                                </div>
                                <label class="form-control-label">N° Serie: <span class="tx-danger">*</span></label>
                                <div class="form-group">
                                    <input class="form-control tx-uppercase" style="width: 100%" id="objdepe_numserie" type="text" name="objdepe_numserie" required />
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-control-label">Origen: <span class="tx-danger">*</span></label>
                                <select class="form-control select2" style="width: 100%" id="" name="" required>

                                </select>
                                <label class="form-control-label">Destino: <span class="tx-danger">*</span></label>
                                <select class="form-control select2" style="width: 100%" id="" name="" required>

                                </select>

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