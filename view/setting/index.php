<?php
/* Llamamos al archivo de conexion.php */
require_once("../../config/conexion.php");
require_once("../../auth/middleware.php");

// echo json_encode($GLOBALS['data']);
// return;

if(isset($_COOKIE['message'])){
  $warn = json_decode($_COOKIE['message'], true);
  if (is_array($warn)) {
      $alert = $warn['type'];
      if($alert == 'success'){
        $text = 'Correcto!';
        $icon = '<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icon-tabler-check alert-icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>';
      }
      else{
        $text = 'Error!';
        $icon = '<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-x alert-icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>';
      }
      $message = $warn['message'];
      $jwt->setCookie("message", "", -3600, "/".$_ENV["APP_NAME"]."/");
  }
}

?>
  <!DOCTYPE html>
  <html lang="es">

  <head>
    <?php require_once("../html/mainHead.php"); ?>
    <title>Configuración</title>
  </head>

  <body>
    <div class="page">
      <?php require_once("../html/mainProfile.php"); ?>
      <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <h2 class="page-title">
                  Ajustes de Cuenta
                </h2>
              </div>
            </div>
          </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
            <div class="card">
              <div class="row g-0">
                <div class="col-12 col-md-3 border-end">
                  <div class="card-body">
                    <h4 class="subheader">Configuración</h4>
                    <div class="list-group list-group-transparent">
                      <a href="../setting/"
                        class="list-group-item list-group-item-action d-flex align-items-center active">Mi Perfil</a>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-9 d-flex flex-column">
                  <div class="card-body">
                    <h2 class="mb-4">Mi Perfil</h2>
                    <!-- <h3 class="card-title mt-4">Perfil Personal</h3> -->
                    <div class="row g-3 mb-3">
                      <div class="col-md">
                        <div class="form-label required">Nombre</div>
                        <div class="input-group">
                          <span class="input-group-text"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg></span>
                          <input type="text" class="form-control" value="<?php echo $GLOBALS['data']->data->usu_nom ?>" disabled>
                        </div>
                      </div>
                      <div class="col-md">
                        <div class="form-label required">Apellido Paterno</div>
                        <div class="input-group">
                          <span class="input-group-text"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg></span>
                          <input type="text" class="form-control" value="<?php echo $GLOBALS['data']->data->usu_apep ?>" disabled>
                        </div>
                      </div>
                      <div class="col-md">
                        <div class="form-label required">Apellido Materno</div>
                        <div class="input-group">
                          <span class="input-group-text"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg></span>
                          <input type="text" class="form-control" value="<?php echo $GLOBALS['data']->data->usu_apem ?>" disabled>
                        </div>
                      </div>
                    </div>

                    <div class="row g-3 mb-3">
                      <div class="col-md-6">
                        <div class="form-label required">Teléfono</div>
                        <div class="input-group is-tooltip mb-2">
                          <span class="input-group-text"> +51 </span>
                          <input type="number" id="telefono" class="form-control" oninput="limitarDigitosTlf(this)">
                          <button class="btn btn-primary" type="button" id="cambiar-tlf">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="me-0 icon icon-tabler icons-tabler-outline icon-tabler-device-floppy"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>
                          </button>
                        </div>
                        <div class="tooltip-feedback card-subtitle"><a class="input-group-link" id="txt-telefono"></a></div>
                        </div>
                      <!-- <div class="col-md-3">
                        <a href="https://www.munichiclayo.gob.pe/sigur/view/USURecuperacionContra/cambiarclave.php?sistema=Intranet" target="_blank" class="btn">
                          Cambiar Contraseña
                        </a>
                      </div> -->
                        <?php
                          if($GLOBALS["data"]->data->usu_tipo == 'P'){
                        ?>
                        <div class="col-md-6">
                          <div class="form-label required">Cargo</div>
                          <div class="input-group is-tooltip mb-2">
                            <span class="input-group-text"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-carambola"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17.286 21.09q -1.69 .001 -5.288 -2.615q -3.596 2.617 -5.288 2.616q -2.726 0 -.495 -6.8q -9.389 -6.775 2.135 -6.775h.076q 1.785 -5.516 3.574 -5.516q 1.785 0 3.574 5.516h.076q 11.525 0 2.133 6.774q 2.23 6.802 -.497 6.8" /></svg></span>
                            <input type="text" class="form-control" disabled>
                          </div>
                        </div>
                        <?php
                          }
                        ?>

                        <?php
                          if($GLOBALS["data"]->data->usu_tipo == 'P'){
                        ?>
                        <div class="col-md-6">
                          <div class="form-label required">Correo Institucional</div>
                          <div class="input-group is-tooltip mb-2">
                            <span class="input-group-text"> @ </span>
                            <input type="text" class="form-control" disabled>
                            <button class="btn btn-primary" type="button" onclick="window.open('https://correo.munichiclayo.gob.pe/', '_blank');">
                              <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="me-0 icon icon-tabler icons-tabler-outline icon-tabler-arrow-right"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M13 18l6 -6" /><path d="M13 6l6 6" /></svg>
                            </button>
                          </div>
                          <div class="tooltip-feedback card-subtitle"><a class="input-group-link" onclick="verTip()">¿Olvidó su contraseña?</a></div>
                        </div>
                        <?php
                          }
                        ?>

                        <div class="col-md-6">
                          <div class="form-label">Correo Personal</div>
                          <div class="input-group is-tooltip mb-2">
                            <span class="input-group-text"> @ </span>
                            <input type="text" id="emailp" class="form-control">
                            <button class="btn btn-primary" type="button" id="cambiar-emailp">
                              <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="me-0 icon icon-tabler icons-tabler-outline icon-tabler-device-floppy"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>
                            </button>
                          </div>
                          <div class="tooltip-feedback card-subtitle"><a class="input-group-link" id="txt-emailp"></a></div>
                          </div>
                        </div>
                        <!-- <div class="col-auto">
                          <a href="#" class="btn">
                            Cambiar
                          </a>
                        </div> -->

                      <h3 class="card-title mt-4">Contraseña</h3>
                      <p class="card-subtitle">Puedes cambiar la contraseña de manera permanente, pero no te olvides de
                        cambiarla con frecuencia.</p>
                      <div>
                        <a id="cambiar-clave" class="btn">
                          Cambiar Contraseña
                        </a>
                      </div>

                      <?php
                        if(isset($message)){
                      ?>
                          <div class="col-md-12 mt-3" id="setting_data">
                            <div class="alert alert-<?= $alert ?>" role="alert" style="margin-top:18px;margin-bottom:-6px;">
                              <div class="d-flex">
                                <div>
                                  <?= $icon ?>
                                </div>
                                <div>
                                  <h4 class="alert-title"><?= $text ?></h4>
                                  <div class="text-secondary"><?= htmlspecialchars($message); ?></div>
                                </div>
                              </div>
                            </div>
                          </div>
                      <?php
                        }
                      ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php require_once("../html/footer.php"); ?>
    </div>
    <?php require_once("../html/mainJs.php"); ?>
    <script src="settings.js"></script>
    <script>
      $(document).ready(function () {
        cargarDatos();
      });
    </script>
    <script>
      function cargarDatos(){
        $.post('../../auth/proxy.php', {api: 'usuario.php?op=mostrar_datos', usu_doc: "<?= $GLOBALS['data']->data->usu_doc ?>", usu_tipo: "<?= $GLOBALS['data']->data->usu_tipo ?>"},  function (data){
            if(data.success){
              if(data.data.usu_celu01){
                $('#telefono').val(data.data.usu_celu01);
                $('#txt-telefono').html('<span style="color:green;">Su número de teléfono es válido: <b>' + data.data.usu_celu01 + '</b></span>');
              }
              else{
                $('#telefono').val('');
                $('#txt-telefono').html('<span style="color:red;">No cuenta con número de teléfono registrado</span>');
              }

              if(data.data.usu_emailp){
                $('#emailp').val(data.data.usu_emailp);
                $('#txt-emailp').html('<span style="color:green;">Su correo electrónico personal es válido: <b>' + data.data.usu_emailp + '</b></span>');
              }
              else{
                $('#emailp').val('');
                $('#txt-emailp').html('<span style="color:red;">No cuenta con correo electrónico personal registrado</span>');
              }
            }
            else{
              mostrarModal('error', 'Error', "Se produjo un error al cargar la información", null, null,null,null,2000);
            }
        }, 'json');
      }
    </script>
    <script>
      $("#cambiar-tlf").click(function(e) {
          e.preventDefault();
          const usu_doc = "<?= $GLOBALS['data']->data->usu_doc ?>";
          const usu_tipo = "<?= $GLOBALS['data']->data->usu_tipo ?>";

          if($('#telefono').val() != '' && $('#telefono').val().length == 9){
            $.post('../../auth/proxy.php', {api: 'usuario.php?op=update_telefono', usu_doc: usu_doc, usu_tipo: usu_tipo, dato: $('#telefono').val()},  function (data){
                if(data.success){
                  $('#txt-telefono').html('<span style="color:green;">Su número de teléfono es válido: <b>' + data.data.usu_celu01 + '</b></span>');
                  mostrarModal('success', 'Actualización de datos', "Se actualizó el número de teléfono correctamente", null, null,null,null,2000);
                  cargarDatos();
                }
                else{
                  mostrarModal('error', 'Actualización de datos', data.message, null, null,null,null,2000);
                }
            }, 'json');
          }
          else{
              mostrarModal('error', 'Actualización de datos', "El número de teléfono no es válido", null, null,null,null,2000);
          }
      });

      $("#cambiar-emailp").click(function(e) {
          e.preventDefault();
          const usu_doc = "<?= $GLOBALS['data']->data->usu_doc ?>";
          const usu_tipo = "<?= $GLOBALS['data']->data->usu_tipo ?>";

          if($('#emailp').val() != ''){
            $.post('../../auth/proxy.php', {api: 'usuario.php?op=update_emailp', usu_doc: usu_doc, usu_tipo: usu_tipo, dato: $('#emailp').val()},  function (data){
                if(data.success){
                  $('#txt-emailp').html('<span style="color:green;">Su correo electrónico personal es válido: <b>' + data.data.usu_emailp + '</b></span>');
                  mostrarModal('success', 'Actualización de datos', "Se cambió el correo electrónico personal correctamente", null, null,null,null,2000);
                  cargarDatos();
                }
                else{
                  mostrarModal('error', 'Actualización de datos', data.message, null, null,null,null,2000);
                }
            }, 'json');
          }
          else{
              mostrarModal('error', 'Actualización de datos', "El número de teléfono no es válido", null, null,null,null,2000);
          }
      });

      $("#cambiar-clave").click(function(e) {
          e.preventDefault();

          $.post('../../auth/proxy.php', {api: 'usuario.php?op=cambiar_clave', enlace: window.location.href},  function (data){
              if(data.success){
                  window.location.href = data.data.enlace;
              }
          }, 'json');
      });
    </script>
    <script>
        function limitarDigitosTlf(input) {
          let valor = input.value.toString().replace(/\D/g, '');
          if (valor.length > 9) {
            valor = valor.slice(0, 9);
          }
          input.value = valor;
        }
    </script>

    <script>
        function redirect_by_post(purl, pparameters, in_new_tab) {
            pparameters = typeof pparameters == "undefined" ? {} : pparameters;
            in_new_tab = typeof in_new_tab == "undefined" ? true : in_new_tab;
        
            var form = document.createElement("form");
            $(form)
            .attr("id", "reg-form")
            .attr("name", "reg-form")
            .attr("action", purl)
            .attr("method", "post")
            .attr("enctype", "multipart/form-data");
            // if (in_new_tab) {
            // $(form).attr("target", "_blank");
            // }
            $.each(pparameters, function (key) {
            $(form).append(
                '<input type="text" name="' + key + '" value="' + this + '" />'
            );
            });
            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        
            return false;
        }
    </script>
  </body>

  </html>