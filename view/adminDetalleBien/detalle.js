$('#combo_vehiculo').select2({
    width: '100%',
    dropdownParent: $('#combo_vehiculo').closest('.input-group'),
    theme: 'bootstrap-5'
});
$('#tipo_servicio').select2({
    width: '100%',
    dropdownParent: $('#tipo_servicio').closest('.input-group'),
    theme: 'bootstrap-5'
});


$(function () {
    $.post("../../controller/bien.php?op=combo_detalle_bien", function (data) {
        $("#combo_vehiculo").html(data).select2({ width: '100%' });
        $("#combo_vehiculo").html('<option value="" disabled selected>-- Seleccione Vehículo --</option>' + data);
    });

    $("#combo_vehiculo").on("change", function () {
        const selectedOption = $(this).find('option:selected');
        const bien_id = selectedOption.val();
        const bien_placa = selectedOption.data('placa'); 
        $("#bien_placa").text(bien_placa || "SIN PLACA");

        const ribbon = $("#ribbon-estado");
        ribbon.removeClass().addClass("ribbon");

        if (!bien_id) {
            limpiarFormulario();
            ribbon.removeClass().addClass("ribbon bg-gray").text("Sin seleccionar");
            return;
        }

        $.post("../../controller/detallebien.php?op=mostrar_estado_bien", { bien_id: bien_id }, function (data) {
            try {
                const estado = JSON.parse(data);
                let icon = '';
                let texto = '';
                let color = '';

                switch (estado.bien_est) {
                    case "N":
                        color = 'bg-purple';
                        icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-circle-check "><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"/><path d="M9 12l2 2l4 -4"/></svg>';
                        texto = 'Nuevo';
                        break;
                    case "M":
                        color = 'bg-red';
                        icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-alert-triangle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v4"/><path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636-2.87l-8.106-13.536a1.914 1.914 0 0 0-3.274 0z"/><path d="M12 16h.01"/></svg>';
                        texto = 'Malo';
                        break;
                    case "R":
                        color = 'bg-yellow';
                        icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-carambola "><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17.286 21.09q-1.69 .001 -5.288 -2.615q-3.596 2.617 -5.288 2.616q-2.726 0 -.495 -6.8q-9.389 -6.775 2.135 -6.775h.076q1.785 -5.516 3.574 -5.516q1.785 0 3.574 5.516h.076q11.525 0 2.133 6.774q2.23 6.802 -.497 6.8"/></svg>';
                        texto = 'Regular';
                        break;
                    case "B":
                        color = 'bg-green';
                        icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10"/></svg>';
                        texto = 'Bueno';
                        break;
                    default:
                        color = 'bg-gray';
                        icon = '<i class="ti ti-help me-1"></i>';
                        texto = 'Desconocido';
                }

                ribbon.removeClass().addClass(`ribbon ${color}`).html(`${icon} ${texto}`);
            } catch (e) {
                console.error("Error al parsear JSON:", e, data);
                ribbon.removeClass().addClass("ribbon bg-gray").text("Error");
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.error("Error AJAX:", textStatus, errorThrown);
            ribbon.removeClass().addClass("ribbon bg-gray").text("Error AJAX");
        });
    });

});


$("#btnBuscarPlaca").on("click", function () {
    let placa = $("#combo_vehiculo option:selected").data("placa");

    if (!placa) {
       Swal.fire({
        title: 'Aviso',
        text: "Seleccione un vehículo válido con placa.",
        imageUrl: '../../static/gif/advertencia.gif',
        imageWidth: 100,
        imageHeight: 100,
        confirmButtonColor: 'rgba(243, 97, 0, 1)', 
        confirmButtonText: 'Aceptar',
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
                background-color: rgba(243, 97, 0, 1)';
                transition: width 0.4s ease;
            `;
            swalBox.appendChild(topBar);

            setTimeout(() => {
                topBar.style.width = '40%';
            }, 300);
        }
    });
    return; 
    }
    $.ajax({
        url: "../../controller/detallebien.php?op=consultar_placa",
        type: "POST",
        data: { bien_placa: placa },
        dataType: "json",
        success: function (response) {
            if (response.status) {
                let data = response.data || {};
                $("#tipo_movilidad").val(data.tipo_movilidad || "");
                $("#categoria").val(data.categoria || "");
                $("#anio_fabricacion").val(data.anio_fabricacion || "");
                $("#peso_neto").val(data.peso_neto || "");
                $("#carga_util").val(data.carga_util || "");
                $("#peso_bruto").val(data.peso_bruto || "");
                $("#ruedas").val(data.ruedas || "");
                $("#cilindros").val(data.cilindros || "");
                $("#ejes").val(data.ejes || "");
                $("#nro_motor").val(data.nro_motor || "");
                $("#pasajeros").val(data.pasajeros || "");
                $("#asientos").val(data.asientos || "");
                $("#carroceria").val(data.carroceria || "");
                $("#comb_id").val(data.comb_id || "");

                Swal.fire("Éxito", response.message || "Datos cargados desde la API.", "success");

            } else {
                let topBar;

                Swal.fire({
                    title: response.detail === "warning" ? "Aviso" : "Error en la búsqueda",
                    text: response.text || response.message || "¿Desea ingresar los datos manualmente?",
                    icon: null,
                    showCancelButton: true,
                    confirmButtonText: "Aceptar",
                    cancelButtonText: "Cancelar",
                    imageUrl: '../../static/gif/busqueda.gif',
                    imageWidth: 100,
                    imageHeight: 100,
                    confirmButtonColor: 'rgb(243, 18, 18)', 
                    cancelButtonColor: '#000', 
                    confirmButtonText: 'Aceptar',
                    backdrop: true,
                    didOpen: () => {
                        const swalBox = Swal.getPopup();
                        topBar = document.createElement('div');
                        topBar.id = 'top-progress-bar';
                        topBar.style.cssText = `
                            position: absolute;
                            top: 0;
                            left: 0;
                            height: 6px;
                            width: 0%;
                            background-color: ${response.detail === "warning" ? 'orange' : 'red'};
                            transition: width 0.4s ease;
                        `;
                        swalBox.appendChild(topBar);
                        // Llenar hasta 60%
                        setTimeout(() => {
                            topBar.style.width = '60%';
                        }, 300);
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        topBar.style.width = '100%';
                        $("#tipo_movilidad, #categoria, #anio_fabricacion, #peso_neto, #carga_util, #peso_bruto, #ruedas, #cilindros, #ejes, #nro_motor, #pasajeros, #asientos, #carroceria, #comb_id").val("");
                        mostrarContenido('identificacion');
                    }
                });
            }
        },
        error: function (xhr, status, error) {
            Swal.fire("Error", "No se pudo conectar con el servidor: " + error, "error");
        }
    });
});


function limpiarFormulario() {
  const $form = $("#detalleBienForm");
  if ($form.length) $form[0].reset();
  $("#comb_nombre").val(null).trigger("change");
}
function nullIfEmpty(value) {
  return value === "" ? null : value;
}

document.addEventListener("DOMContentLoaded", () => {
    // Asigna evento a cada link del menú
    document.querySelectorAll("#menuSecciones a").forEach(link => {
        link.addEventListener("click", e => {
            e.preventDefault();
            let destino = link.getAttribute("href").substring(1); // ej: identificacion, caracteristicas...
            mostrarContenido(destino);
        });
    });
});

function mostrarContenido(seccion) {
    const contenedor = document.getElementById("contenidoDinamico");
    contenedor.innerHTML = "";
    let contenidoHTML = "";
    switch (seccion) {
        case 'identificacion':
            contenidoHTML = `
    <form id="formIdentificacion" method="post"  enctype="multipart/form-data">
        <div id="plantilla-identificacion">
            <div class="hr-text mx-4"><h4 class="text-primary"> >> Datos Generales del Vehículo << </h4> </div>
            <div class="row my-4 mx-3">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="ruta" class="form-label">Ruta: <span class="text-danger">*</span></label>
                        <div class="input-icon mb-1">
                            <span class="input-icon-addon">
                                <!-- Icono de ruta -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                    class="icon icon-tabler icon-tabler-road">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M4 19l4 -14" />
                                    <path d="M16 5l4 14" />
                                    <path d="M12 8v-2" />
                                    <path d="M12 13v-2" />
                                    <path d="M12 18v-2" />
                                </svg>
                            </span>
                            <input type="text" class="form-control" id="ruta" name="ruta" placeholder="Ej: Chiclayo-Pimentel">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tipo_movilidad" class="form-label">Tipo de Servicio <span class="text-danger">*</span></label>
                        <div class="input-icon mb-1">
                            <select class="form-select select2" id="tipo_servicio" name="tipo_servicio" style="width: 100%;" placeholder= "-- Seleccione tipo de servicio -- ">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="Vin" class="form-label">Número de Vin <span class="text-danger">*</span></label>
                        <div class="input-icon mb-1">
                            <span class="input-icon-addon">
                                <!-- Icono asiento -->
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-navigation-top"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16.54 19.977a.34 .34 0 0 0 .357 -.07a.33 .33 0 0 0 .084 -.35l-4.981 -10.557l-4.982 10.557a.33 .33 0 0 0 .084 .35a.34 .34 0 0 0 .357 .07l4.541 -1.477l4.54 1.477z" /><path d="M12 3v2" /></svg>
                            </span>
                            <input type="text" min="1" class="form-control" id="vin" name="vin" placeholder="Ej: 8A1H52A3XJ12345">
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="categoria" class="form-label">Categoría <span class="text-danger">*</span></label>
                        <div class="input-icon mb-1">
                            <span class="input-icon-addon">
                                <!-- Icono etiqueta -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                    class="icon icon-tabler icon-tabler-tag">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M4 4h4l10 10a2 2 0 0 1 -4 4l-10 -10v-4z" />
                                    <path d="M4 8l4 -4" />
                                </svg>
                            </span>
                            <input type="text" class="form-control" id="categoria" name="categoria" placeholder="Ej: M1, N2, L3">
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="anio_fabricacion" class="form-label">Año Fabricación <span class="text-danger">*</span></label>
                        <div class="input-icon mb-1">
                            <span class="input-icon-addon">
                                <!-- Icono calendario -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                    class="icon icon-tabler icon-tabler-calendar">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <rect x="4" y="5" width="16" height="16" rx="2" />
                                    <line x1="16" y1="3" x2="16" y2="7" />
                                    <line x1="8" y1="3" x2="8" y2="7" />
                                    <line x1="4" y1="11" x2="20" y2="11" />
                                </svg>
                            </span>
                            <input type="number" class="form-control" id="anio_fabricacion" name="anio_fabricacion" min="1900" max="2100" placeholder="Ej: 2020">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="carroceria" class="form-label">Carrocería <span class="text-danger">*</span></label>
                        <div class="input-icon mb-1">
                            <span class="input-icon-addon">
                                <!-- Icono carrocería -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icon-tabler-truck">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <rect x="1" y="5" width="15" height="10" rx="2" />
                                    <path d="M16 9h4l3 3v3h-7z" />
                                    <circle cx="5.5" cy="15.5" r="2.5" />
                                    <circle cx="18.5" cy="15.5" r="2.5" />
                                </svg>
                            </span>
                            <input type="text" class="form-control" id="carroceria" name="carroceria" placeholder="Ej: Furgón, Pick-up, Minibús">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="version" class="form-label">Versión <span class="text-danger">*</span></label>
                        <div class="input-icon mb-1">
                            <span class="input-icon-addon">
                                <!-- Icono version -->
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-versions"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 5m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" /><path d="M7 7l0 10" /><path d="M4 8l0 8" /></svg>
                            </span>
                            <input type="text" class="form-control" id="version" name="version" placeholder="Ej: 4X2 D/C 2GD SR">
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="comb_id" class="form-label">Tipo de Combustible <span class="text-danger">*</span></label>
                        <div id="combustibles_container" class="form-selectgroup justify-content-center">
                            <!-- Aquí se llenan los checkboxes dinámicamente -->
                        </div>
                    </div>
                </div>     
            </div>
            <div class="row footer-form bg-transparent border-top py-3 px-4 d-flex justify-content-between align-items-center">
                <div class="col d-flex justify-content-start">
                    <button type="reset" id="btnCancelar" class="btn btn-outline-dark tx-11 pd-y-12 pd-x-25 tx-mont tx-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M18 6l-12 12" />
                            <path d="M6 6l12 12" />
                        </svg>
                        Cancelar
                    </button>
                </div>
                <div class="col d-flex justify-content-end">
                    <button type="submit" name="action"  value="add" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-100 tx-mont tx-medium">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>
                        Guardar Datos
                    </button>
                </div>
            </div>
        </div>
    </form>
            `;
            contenedor.innerHTML = contenidoHTML;
            mostrarIdentificacion();
            break;
        case 'caracteristicas':
            contenidoHTML = `
    <form id="formCaracteristicas" method="post"  enctype="multipart/form-data">
        <div id="plantilla-caracteristicas">
            <div class="hr-text mx-4"><h4 class="text-primary"> >> Caracteristicas del Vehículo << </h4> </div>
            <div class="row mx-4">
                <div class="col-md-4 mb-3">
                    <label for="nro_motor" class="form-label">Número de Motor <span class="text-danger">*</span></label>
                    <div class="input-icon mb-1">
                        <span class="input-icon-addon">
                            <!-- Icono código -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icon-tabler-barcode">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M4 6h1v12h-1z" />
                                <path d="M7 6h1v12h-1z" />
                                <path d="M12 6h1v12h-1z" />
                                <path d="M16 6h1v12h-1z" />
                                <path d="M19 6h1v12h-1z" />
                            </svg>
                        </span>
                        <input type="text" class="form-control" id="nro_motor" name="nro_motor" placeholder="Ej: XYZ1234567">
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="ruedas" class="form-label">Ruedas <span class="text-danger">*</span></label>
                    <div class="input-icon mb-1">
                        <span class="input-icon-addon">
                            <!-- Icono ruedas -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icon-tabler-tire">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <circle cx="12" cy="12" r="9" />
                                <circle cx="12" cy="12" r="4" />
                            </svg>
                        </span>
                        <input type="number" min="2" class="form-control" id="ruedas" name="ruedas" placeholder="Ej: 4">
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="cilindros" class="form-label">Cilindros <span class="text-danger">*</span></label>
                    <div class="input-icon mb-1">
                        <span class="input-icon-addon">
                            <!-- Icono motor -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icon-tabler-engine">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <rect x="4" y="4" width="16" height="16" rx="2" />
                                <path d="M4 10h16" />
                                <path d="M10 4v16" />
                            </svg>
                        </span>
                        <input type="number" class="form-control" id="cilindros" name="cilindros" placeholder="Ej: 6">
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="cilindrada" class="form-label">Cilindrada <span class="text-danger">*</span></label>
                    <div class="input-icon mb-1">
                        <span class="input-icon-addon">
                            <!-- Icono asiento -->
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-progress"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 20.777a8.942 8.942 0 0 1 -2.48 -.969" /><path d="M14 3.223a9.003 9.003 0 0 1 0 17.554" /><path d="M4.579 17.093a8.961 8.961 0 0 1 -1.227 -2.592" /><path d="M3.124 10.5c.16 -.95 .468 -1.85 .9 -2.675l.169 -.305" /><path d="M6.907 4.579a8.954 8.954 0 0 1 3.093 -1.356" /></svg>
                        </span>
                        <input type="number" step="0.001" min="0" class="form-control" id="cilindrada" name="cilindrada" placeholder="Ej: 2.393">
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="potencia" class="form-label">Potencia <span class="text-danger">*</span></label>
                    <div class="input-icon mb-1">
                        <span class="input-icon-addon">
                            <!-- Icono asiento -->
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-car-4wd"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 3m0 2a2 2 0 0 1 2 -2h0a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h0a2 2 0 0 1 -2 -2z" /><path d="M5 15m0 2a2 2 0 0 1 2 -2h0a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h0a2 2 0 0 1 -2 -2z" /><path d="M15 3m0 2a2 2 0 0 1 2 -2h0a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h0a2 2 0 0 1 -2 -2z" /><path d="M15 15m0 2a2 2 0 0 1 2 -2h0a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h0a2 2 0 0 1 -2 -2z" /><path d="M9 18h6" /><path d="M9 6h6" /><path d="M12 6.5v-.5v12" /></svg>
                        </span>
                        <input type="text" min="1" class="form-control" id="potencia" name="potencia" placeholder="Ej: 120 @ 64">
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="form_rodaje" class="form-label">Forma de rodaje <span class="text-danger">*</span></label>
                    <div class="input-icon mb-1">
                        <span class="input-icon-addon">
                            <!-- Icono rodaje -->
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-rotate-dot"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.95 11a8 8 0 1 0 -.5 4m.5 5v-5h-5" /><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg>
                        </span>
                        <input type="text" min="1" class="form-control" id="form_rodaje" name="form_rodaje" placeholder="Ej: 2 x 4 ">
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="ejes" class="form-label mt-1">Ejes <span class="text-danger">*</span></label>
                    <div class="d-flex flex-wrap gap-2 ">
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="ejes" id="ejes1" value="1">
                        <label class="form-check-label" for="ejes1">1</label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="ejes" id="ejes2" value="2">
                        <label class="form-check-label" for="ejes2">2</label>
                        </div>
                        <!-- Repite hasta el 10 -->
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="ejes" id="ejes3" value="3">
                        <label class="form-check-label" for="ejes3">3</label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="ejes" id="ejes4" value="4">
                        <label class="form-check-label" for="ejes4">4</label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="ejes" id="ejes5" value="5">
                        <label class="form-check-label" for="ejes5">5</label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="ejes" id="ejes6" value="6">
                        <label class="form-check-label" for="ejes6">6</label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="ejes" id="ejes7" value="7">
                        <label class="form-check-label" for="ejes7">7</label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="ejes" id="ejes8" value="8">
                        <label class="form-check-label" for="ejes8">8</label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="ejes" id="ejes9" value="9">
                        <label class="form-check-label" for="ejes9">9</label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="ejes" id="ejes10" value="10">
                        <label class="form-check-label" for="ejes10">10</label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="ejes" id="ejes11" value="11">
                        <label class="form-check-label" for="ejes11">11</label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="ejes" id="ejes12" value="12">
                        <label class="form-check-label" for="ejes12">12</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row footer-form bg-transparent border-top py-3 px-4 d-flex justify-content-between align-items-center">
                <div class="col d-flex justify-content-start">
                    <button type="reset" class="btn btn-outline-dark tx-11 pd-y-12 pd-x-25 tx-mont tx-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M18 6l-12 12" />
                            <path d="M6 6l12 12" />
                        </svg>
                        Cancelar
                    </button>
                </div>
                <div class="col d-flex justify-content-end">
                    <button type="submit"  name="action" value="add" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>
                        Guardar Datos
                    </button>
                </div>
            </div>
        </div>  
    </form>
            `;
            contenedor.innerHTML = contenidoHTML;
            mostrarCaracteristicas();
            break;
        case 'capacidades':
            contenidoHTML = `
    <form id="formCapacidades" method="post"  enctype="multipart/form-data">
        <div id="plantilla-capacidades">
            <div class="hr-text mx-4"><h4 class="text-primary"> >> Capacidades del Vehículo << </h4> </div>
            <div class="row mx-4 mb-4">
                <div class="col-md-4 mb-3">
                    <label for="pasajeros" class="form-label">Pasajeros <span class="text-danger">*</span></label>
                    <div class="input-icon mb-1">
                        <span class="input-icon-addon">
                            <!-- Icono pasajeros -->
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-users"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
                        </span>
                        <input type="number" class="form-control" min="1" step="1" id="pasajero" name="pasajero" placeholder="Ej: 5">
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="asientos" class="form-label">Asientos <span class="text-danger">*</span></label>
                    <div class="input-icon mb-1">
                        <span class="input-icon-addon">
                            <!-- Icono asiento -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icon-tabler-armchair">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <rect x="4" y="8" width="16" height="8" rx="2" />
                                <path d="M4 12v4a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-4" />
                            </svg>
                        </span>
                        <input type="number" min="1" class="form-control" id="asiento"  step="1" name="asiento" placeholder="Ej: 5">
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="peso_neto" class="form-label">Peso Neto <span class="text-danger">*</span></label>
                    <div class="input-icon mb-1">
                        <span class="input-icon-addon">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-weight"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 6m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M6.835 9h10.33a1 1 0 0 1 .984 .821l1.637 9a1 1 0 0 1 -.984 1.179h-13.604a1 1 0 0 1 -.984 -1.179l1.637 -9a1 1 0 0 1 .984 -.821z" /></svg>
                        </span>
                        <input type="number" step="0.01" min="0.01" class="form-control" id="peso_neto" name="peso_neto" placeholder="Ej: 1500.50 kg">
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="carga_util" class="form-label">Carga Útil</label>
                    <div class="input-icon mb-1">
                        <span class="input-icon-addon">
                            <!-- Icono carga -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                class="icon icon-tabler icon-tabler-package">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M3 7l9 5l9 -5l-9 -5z" />
                                <path d="M3 17l9 5l9 -5" />
                                <path d="M3 7v10" />
                                <path d="M21 7v10" />
                                <path d="M12 12v10" />
                            </svg>
                        </span>
                        <input type="number" step="0.01" min="0.01" class="form-control" id="carga_util" name="carga_util" placeholder="Ej: 750.00 kg" required>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="peso_bruto" class="form-label">Peso Bruto <span class="text-danger">*</span></label>
                    <div class="input-icon mb-1">
                        <span class="input-icon-addon">
                            <!-- Icono balanza llena -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                class="icon icon-tabler icon-tabler-weight">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <rect x="5" y="5" width="14" height="14" rx="2" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </span>
                        <input type="number" step="0.01" class="form-control" id="peso_bruto" name="peso_bruto" placeholder="Ej: 2250.75 kg">
                    </div>
                </div>
            </div>  
            <div class="row footer-form bg-transparent border-top py-3 px-4 d-flex justify-content-between align-items-center">
                <div class="col d-flex justify-content-start">
                    <button type="reset" class="btn btn-outline-dark tx-11 pd-y-12 pd-x-25 tx-mont tx-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M18 6l-12 12" />
                            <path d="M6 6l12 12" />
                        </svg>
                        Cancelar
                    </button>
                </div>
                <div class="col d-flex justify-content-end">
                    <button type="submit"  name="action" value="add" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>
                        Guardar Datos
                    </button>
                </div>
            </div> 
        </div>
    </form>
            `;
            contenedor.innerHTML = contenidoHTML;
            mostrarCapacidades();
            break;
        default:
            contenedor.innerHTML = "<p>Sección no encontrada</p>";
            return;
    }

    contenedor.innerHTML = contenidoHTML;
    if (seccion === 'identificacion') {
        cargarCombustibles();
    }
    if (seccion === 'identificacion') {
        cargarTipoServicio();
    }
}
function cargarTipoServicio(selectedValue = '') {
    $.post("../../controller/tiposervicio.php?op=listar_tipo_servicio", function (data) {
        let options = '<option value="" disabled>-- Seleccione tipo de servicio --</option>' + data;
        $("#tipo_servicio").html(options);
        $("#tipo_servicio").select2({ width: '100%' });
        if (selectedValue) {
            $("#tipo_servicio").val(selectedValue).trigger('change');
        }
    }, "html");
}


function cargarCombustibles(seleccionados = []) {
    $.post("../../controller/combustible.php?op=combo_detalle_combustible", function (data) {
        let checkboxes = '';
        try {
            const items = JSON.parse(data);
            items.forEach(item => {
                let checked = seleccionados.includes(item.id.toString()) ? 'checked' : '';
                checkboxes += `
                    <label class="form-selectgroup-item flex-fill">
                        <input type="checkbox" name="combustibles[]" value="${item.id}" class="form-selectgroup-input" ${checked}>
                        <div class="form-selectgroup-label d-flex align-items-center p-3">
                            <div class="me-3">
                                <span class="form-selectgroup-check"></span>
                            </div>
                            <div class="form-selectgroup-label-content d-flex align-items-center">
                                <div>
                                    <div class="font-weight-medium">${item.nombre}</div>
                                </div>
                            </div>
                        </div>
                    </label>
                `;
            });
        } catch (e) {
            console.error("Error al parsear JSON de combustibles", e, data);
        }
        document.getElementById("combustibles_container").innerHTML = checkboxes;
    });
}
