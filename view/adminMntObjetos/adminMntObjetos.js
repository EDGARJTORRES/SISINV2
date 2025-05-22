var usu_id = $("#usu_idx").val();

$(document).ready(function () {
  $(".select2").select2();
  $.post("../../controller/grupogenerico.php?op=combo", function (data) {
    $("#combo_grupo_gen").html(data);
  });

  $("#combo_grupo_gen").change(function () {
    var gg_id = $(this).val();

    // Realizar la petición POST para obtener las clases asociadas al grupo genérico seleccionado
    $.post(
      "../../controller/clase.php?op=combo",
      { gg_id: gg_id },
      function (data) {
        // Colocar la respuesta en el combo de clase
        $("#combo_clase_gen").html(data);

        // Activar select2 para el nuevo contenido del combo de clase
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
      icon: "error",
      confirmButtonText: "Aceptar",
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
      icon: "error",
      confirmButtonText: "Aceptar",
    });
  } else {
    /* Creando formulario */
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
        console.log(data);
        data = JSON.parse(data);
      },
    });

    $.post(
      "../../controller/clase.php?op=combo",
      { gg_id: gg_id },
      function (data) {
        // Colocar la respuesta en el combo de clase
        $("#combo_clase_gen").html(data);

        // Activar select2 para el nuevo contenido del combo de clase
        $("#combo_clase_gen").select2();
      }
    );
    $("#gg_clase_data_actual").DataTable().ajax.reload();

    $("#gg_clase_data").DataTable().ajax.reload();
  }
}

function quitarClase(gc_id){
    swal.fire({
        title: "Eliminar!",
        text: "Desea Quitar La Clase?",
        icon: "error",
        confirmButtonText: "Si",
        showCancelButton: true,
        cancelButtonText: "No",
    }).then((result) => {
        if (result.value) {
            $.post("../../controller/clase.php?op=quitarclase",{gc_id : gc_id}, function (data) {
                $("#gg_clase_data_actual").DataTable().ajax.reload();

                $("#gg_clase_data").DataTable().ajax.reload();

                Swal.fire({
                    title: 'Correcto!',
                    text: 'Se Quitó Correctamente',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                })
            });
        }
    });
}
