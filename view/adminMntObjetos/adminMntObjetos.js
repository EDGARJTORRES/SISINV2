var usu_id = $("#usu_idx").val();

function mostrarAlertaCarga() {
  document.getElementById('alerta-carga').style.display = 'block';
}

// Ocultar alerta
function ocultarAlertaCarga() {
  document.getElementById('alerta-carga').style.display = 'none';
}

$(document).ready(function () {
    let inicioCarga;
    let tiempoMinimo = 3000; // 2 segundos

    $('#clase_grupo_id').on('preXhr.dt', function () {
        mostrarAlertaCarga();
        inicioCarga = new Date().getTime();
    });

    $('#clase_grupo_id').on('xhr.dt', function () {
        let finCarga = new Date().getTime();
        let duracion = finCarga - inicioCarga;
        let tiempoRestante = tiempoMinimo - duracion;

        if (tiempoRestante > 0) {
            setTimeout(function () {
                ocultarAlertaCarga();
            }, tiempoRestante);
        } else {
            ocultarAlertaCarga();
        }
    });
  $(".select2").select2();
  $.post("../../controller/grupogenerico.php?op=combo", function (data) {
    $("#combo_grupo_gen").html(data);
  });
  $("#combo_grupo_gen").change(function () {
    var gg_id = $(this).val();
    $.post(
      "../../controller/clase.php?op=combo",
      { gg_id: gg_id },
      function (data) {
        $("#combo_clase_gen").html(data);
        $("#combo_clase_gen").select2();
      }
    );
  });

  $("#clase_grupo_id").DataTable({
    aProcessing: true,
    aServerSide: true,
    dom: "Bfrtip",
    searching: true,
    buttons: [],
    ajax: {
      url: "../../controller/objeto.php?op=listar",
      type: "post",
    },
    bDestroy: true,
    responsive: false,
    bInfo: false,
    iDisplayLength: 5,
    ordering: false,
    language: {
      sProcessing: "Procesando...",
      sLengthMenu: "Mostrar _MENU_ registros",
      sZeroRecords: "No se encontraron resultados",
      sEmptyTable: "Ningún dato disponible en esta tabla",
      sInfo:
        "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
      sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
      sInfoPostFix: "",
      sSearch: "Buscar:",
      sUrl: "",
      sInfoThousands: ",",
      sLoadingRecords: "Cargando...",
      oPaginate: {
        sFirst: "Primero",
        sLast: "Último",
        sNext: "Siguiente",
        sPrevious: "Anterior",
      },
      oAria: {
        sSortAscending:
          ": Activar para ordenar la columna de manera ascendente",
        sSortDescending:
          ": Activar para ordenar la columna de manera descendente",
      },
    },
  });
});

function listar_clases(gg_id) {
  $("#gg_clase_data").DataTable({
    aProcessing: true,
    aServerSide: true,
    searching: true,
    dom: "Bfrtip",
    buttons: [],
    ajax: {
      url: "../../controller/grupogenerico.php?op=listar_gg_clase",
      type: "post",
      data: { gg_id: gg_id },
    },
    bDestroy: true,
    responsive: true,
    bInfo: false,
    iDisplayLength: 4,
    order: [[1, "asc"]],
    language: {
      sProcessing: "Procesando...",
      sLengthMenu: "Mostrar _MENU_ registros",
      sZeroRecords: "No se encontraron resultados",
      sEmptyTable: "Ningún dato disponible en esta tabla",
      sInfo:
        "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
      sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
      sInfoPostFix: "",
      sSearch: "Buscar:",
      sUrl: "",
      sInfoThousands: ",",
      sLoadingRecords: "Cargando...",
      oPaginate: {
        sFirst: "Primero",
        sLast: "Último",
        sNext: "Siguiente",
        sPrevious: "Anterior",
      },
      oAria: {
        sSortAscending:
          ": Activar para ordenar la columna de manera ascendente",
        sSortDescending:
          ": Activar para ordenar la columna de manera descendente",
      },
    },
  });
}
function listar_clases_actuales(gg_id) {
  $("#gg_clase_data_actual").DataTable({
    aProcessing: true,
    aServerSide: true,
    searching: true,
    dom: "Bfrtip",
    buttons: [],
    ajax: {
      url: "../../controller/clase.php?op=listar_gg_clase_actuales",
      type: "post",
      data: { gg_id: gg_id },
    },
    bDestroy: true,
    responsive: true,
    bInfo: false,
    iDisplayLength: 5,
    order: [[1, "asc"]],
    language: {
      sProcessing: "Procesando...",
      sLengthMenu: "Mostrar _MENU_ registros",
      sZeroRecords: "No se encontraron resultados",
      sEmptyTable: "Ningún dato disponible en esta tabla",
      sInfo:
        "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
      sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
      sInfoPostFix: "",
      sSearch: "Buscar:",
      sUrl: "",
      sInfoThousands: ",",
      sLoadingRecords: "Cargando...",
      oPaginate: {
        sFirst: "Primero",
        sLast: "Último",
        sNext: "Siguiente",
        sPrevious: "Anterior",
      },
      oAria: {
        sSortAscending:
          ": Activar para ordenar la columna de manera ascendente",
        sSortDescending:
          ": Activar para ordenar la columna de manera descendente",
      },
    },
  });
}
function nuevaclase() {
  if ($("#combo_grupo_gen").val() == "") {
    Swal.fire({
      title: "Error!",
      text: "Seleccionar Grupo Genérico",
      imageUrl: '../../static/gif/letra-x.gif',
      imageWidth: 100,
      imageHeight: 100,
      confirmButtonText: "Aceptar",
      confirmButtonColor: 'rgb(243, 18, 18)'
    });
  } else {
    var gg_id = $("#combo_grupo_gen").val();
    listar_clases(gg_id);
    listar_clases_actuales(gg_id);
    $("#modalClase").modal("show");
  }
}

function registrardetalle() {
  table = $("#gg_clase_data").DataTable();
  var gg_id = $("#combo_grupo_gen").val();
  var clase_id = [];

  table.rows().every(function (rowIdx, tableLoop, rowLoop) {
    cell1 = table.cell({ row: rowIdx, column: 0 }).node();
    if ($("input", cell1).prop("checked") == true) {
      id = $("input", cell1).val();
      clase_id.push([id]);
    }
  });

  if (clase_id == 0) {
    Swal.fire({
      title: "Error!",
      text: "Seleccionar Clases",
      imageUrl: '../../static/gif/letra-x.gif',
      imageWidth: 100,
      imageHeight: 100,
      confirmButtonText: "Aceptar",
      confirmButtonColor: 'rgb(243, 18, 18)'
    });
  } else {
    const formData = new FormData($("#form_detalle")[0]);
    formData.append("gg_id", gg_id);
    formData.append("clase_id", clase_id);
    console.log(gg_id);

    $.ajax({
      url: "../../controller/grupogenerico.php?op=insert_gg_clase",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {
        data = JSON.parse(data);
      },
    });
    $.post(
      "../../controller/clase.php?op=combo",
      { gg_id: gg_id },
      function (data) {
        $("#combo_clase_gen").html(data);
        $("#combo_clase_gen").select2();
      }
    );
    $("#gg_clase_data_actual").DataTable().ajax.reload();
    $("#gg_clase_data").DataTable().ajax.reload();
  }
}
function quitarClase(gc_id){
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡Esta acción no se puede deshacer!",
        imageUrl: '../../static/gif/advertencia.gif',
        imageWidth: 100,
        imageHeight: 100,
        showCancelButton: true,
         confirmButtonColor: 'rgb(243, 18, 18)', 
        cancelButtonColor: '#000', 
        confirmButtonText: 'Sí, eliminarlo',
        backdrop: true,
        didOpen: () => {
            const swalBox = Swal.getPopup();
            const topBar = document.createElement('div');
            topBar.id = 'top-progress-bar';
            topBar.style.cssText = `
                position: absolute;
                top: 0;
                left: 0;
                height: 5px;
                width: 0%;
                background-color:rgb(243, 18, 18);
                transition: width 0.4s ease;
            `;
            swalBox.appendChild(topBar);

            setTimeout(() => {
                topBar.style.width = '40%';
            }, 300);
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
              url: '../../controller/clase.php?op=quitarclase',
                type: 'POST',
               data: {gc_id : gc_id},
                success: function (response) {
                   $("#gg_clase_data_actual").DataTable().ajax.reload();
                   $("#gg_clase_data").DataTable().ajax.reload();
                    Swal.fire({
                        title: '¡Eliminado!',
                        html: `
                            <p>La clase ha sido eliminado correctamente.</p>
                            <div id="top-progress-bar-final" style="
                                position: absolute;
                                top: 0;
                                left: 0;
                                height: 5px;
                                width: 0%;
                                background-color:rgb(243, 18, 18);
                                transition: width 0.6s ease;
                            "></div>
                        `,
                        imageUrl: '../../static/gif/verified.gif',
                        imageWidth: 100,
                        imageHeight: 100,
                        showConfirmButton: true,
                        confirmButtonColor: 'rgb(243, 18, 18)',
                        backdrop: true,
                        didOpen: () => {
                            const bar = document.getElementById('top-progress-bar-final');
                            setTimeout(() => {
                                bar.style.width = '100%';
                            }, 100);
                        }
                    });
                },
                error: function () {
                    Swal.fire('Error', 'No se pudo eliminar el usuario.', 'error');
                }
            });
        }
    });
}