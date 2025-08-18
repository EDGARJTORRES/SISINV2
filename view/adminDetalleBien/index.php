<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usua_id_siin"])) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php require_once("../html/mainHead.php"); ?>
  <title>MPCH::AltaBienes</title>
  <link href="../../public/css/estiloselect.css" rel="stylesheet"/>
  <link href="../../public/css/botones.css" rel="stylesheet"/>
  <link href="../../public/css/Breadcrumb.css" rel="stylesheet"/>
  <link href="../../public/css/loader.css" rel="stylesheet"/>
  <link href="../../public/css/alta.css" rel="stylesheet"/>
  <link href="../../public/css/iconos.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
    <?php require_once("../html/mainProfile.php"); ?>
     <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
              <nav class="breadcrumb mb-2">
                    <a href="../adminMain/">Inicio</a>
                    <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
                    <span class="breadcrumb-item active">Procesos</span>
                    <a href="../adminAltaBien/">
                    <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
                    Alta de Bienes
                    </a>
                    <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
                    <span>Detalle de Bien Patrimonial</span>
                </nav>
                <div class="row align-items-center">
                    <div class="col-auto">
                        <a href="../adminAltaBien/" class="btn btn-ghost-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M5 12l14 0" />
                                <path d="M5 12l6 6" />
                                <path d="M5 12l6 -6" />
                            </svg>
                            Volver
                        </a>
                    </div>
                    <div class="col">
                        <h2 class="page-title" style="border-left: 1px solid #000; padding-left: 8px;">
                            DETALLE DE ALTA DE BIEN PATRIMONIAL
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none mb-2">
                        <div class="btn-list">
                            <button class="button2" id="add_button" onclick="actualizarDetalle()" title="Registrar baja de bien Patrimonial">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-device-imac-plus">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12.5 17h-8.5a1 1 0 0 1 -1 -1v-12a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v8.5" />
                                    <path d="M3 13h13.5" /><path d="M8 21h4.5" /><path d="M10 17l-.5 4" />
                                    <path d="M16 19h6" /><path d="M19 16v6" />
                                </svg>
                                    Actualizar Detalle
                            </button>
                        </div>
                    </div>
                </div>  
                <div class="col-12">
                  <div class="card border-0" style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
                    <div class="card-status-start bg-primary"></div>
                    <div class="card-header">
                      <h3 class="card-title">
                        <svg class="text-primary" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-list-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 15m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M18.5 18.5l2.5 2.5" /><path d="M4 6h16" /><path d="M4 12h4" /><path d="M4 18h4" /></svg>
                        REGISTRO POR TIPOS DE VEHÍCULOS<span class="text-secondary"> (OBJETOS EN INVENTARIO)</span>
                      </h3>
                    </div>
                    <div class="card_body my-2">
                        <form id="detalleBienForm" method="post" autocomplete="off">
                            <div class="row m-4">
                                <fieldset class="mb-4 border p-3 rounded"> 
                                    <legend class="badge bg-azure-lt fs-2 fw-bold px-3 py-2 text-primary" style="border-left: 4px solid #121db4ff; padding-left: 8px;">Identificación del Vehículo</legend>
                                    <div class="row">
                                        <div class="col-md-8 mb-3">
                                            <label for="bien_id" class="form-label">Vehículo: <span class="text-danger">*</span></label>
                                            <select class="form-select select2" id="combo_vehiculo" name="combo_vehiculo" data-placeholder=" -- Seleccione tipo de Vehículo --" style="width: 100%;">
                                                <option value="" disabled selected>-- Seleccione --</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="placa" class="form-label">Placa: <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-icon mb-1">
                                            <span class="input-icon-addon">
                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-git-fork"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 18m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M7 6m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M17 6m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M7 8v2a2 2 0 0 0 2 2h6a2 2 0 0 0 2 -2v-2" /><path d="M12 12l0 4" /></svg>
                                            </span>
                                            <input type="text" class="form-control" id="placa" name="placa"
                                                    placeholder="Ej: ABC-123" pattern="^[A-Za-z0-9]{1,10}$"
                                                    title="Solo letras y números. Máximo 10 caracteres.">
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
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
                                        <div class="col-md-4 mb-3">
                                            <label for="tipo_movilidad" class="form-label">Tipo Movilidad <span class="text-danger">*</span></label>
                                            <div class="input-icon mb-1">
                                                <span class="input-icon-addon">
                                                    <!-- Icono vehículo -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                                        class="icon icon-tabler icon-tabler-car">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M3 12l1 -5h16l1 5" />
                                                        <path d="M5 12v5h14v-5" />
                                                        <path d="M6 16a1 1 0 0 0 0 2" />
                                                        <path d="M18 16a1 1 0 0 0 0 2" />
                                                    </svg>
                                                </span>
                                                <input type="text" class="form-control" id="tipo_movilidad" name="tipo_movilidad" placeholder="Ej: Camión, Auto, Bus">
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
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
                                        <div class="col-md-4 mb-3">
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
                                        <div class="col-md-4 mb-3">
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
                                        <div class="col-md-4 mb-3">
                                            <label for="comb_id" class="form-label">Tipo de Combustible <span class="text-danger">*</span></label>
                                            <select class="form-select select2"  id="comb_nombre" name="comb_nombre" data-placeholder="Seleccione tipo de combustible" style="width: 100%;">
                                                <option value="" disabled selected>-- Seleccione tipo de combustible --</option>
                                            </select>
                                        </div>
                                    </div>     
                                </fieldset>
                                <fieldset class="mb-4 border p-3 rounded"> 
                                    <legend class="badge bg-azure-lt fs-2 fw-bold px-3 py-2 text-primary" style="border-left: 4px solid #121db4ff; padding-left: 8px;">Características Técnicas</legend>
                                    <div class="row">
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
                                        <label for="ejes" class="form-label">Ejes <span class="text-danger">*</span></label>
                                        <div class="input-icon mb-1">
                                            <span class="input-icon-addon">
                                                <!-- Icono ejes -->
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icon-tabler-arrows-diff">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M7 7h10v10h-10z" />
                                                </svg>
                                            </span>
                                            <input type="number" min="1" class="form-control" id="ejes" name="ejes" placeholder="Ej: 2">
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="mb-4 border p-3 rounded"> 
                                    <legend class="badge bg-azure-lt fs-2 fw-bold px-3 py-2 text-primary" style="border-left: 4px solid #121db4ff; padding-left: 8px;">Capacidades e Información Mecánica</legend>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="nro_motor" class="form-label">Nro. Motor <span class="text-danger">*</span></label>
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
                                            <label for="pasajeros" class="form-label">Pasajeros <span class="text-danger">*</span></label>
                                            <div class="input-icon mb-1">
                                                <span class="input-icon-addon">
                                                    <!-- Icono pasajeros -->
                                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-users"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
                                                </span>
                                                <input type="number" class="form-control"  min="1" id="pasajeros" name="pasajeros" placeholder="Ej: 5">
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
                                                <input type="number" min="1" class="form-control" id="asientos" name="asientos" placeholder="Ej: 5">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </form>
                    </div>
                  </div>
                </div>   
            </div>
        </div>  
    </div>
    <div id="page">
      <div id="container">
          <div id="ring"></div>
          <div id="ring"></div>
          <div id="ring"></div>
          <div id="ring"></div>
          <div style="display: flex; z-index:1000; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
            <img src="../../static/illustrations/logo_mpch.png" height="90" width="90" alt="Municipal logo " />
              <h3></h3>
            <h3 class="titulo">Generando Bien(es)...</h3>
          </div>
      </div>
    </div>
    <?php require_once("../html/footer.php"); ?>
    <?php require_once("../html/mainJs.php"); ?>
    <script type="text/javascript" src="detalle.js"></script>
</body>
</html>
<?php
} else {
  header("Location:" . Conectar::ruta() . "view/404/");
}
?>
