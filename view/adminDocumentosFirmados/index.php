<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usua_id_siin"])) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once("../html/mainHead.php"); ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="../../public/css/estiloselect.css" rel="stylesheet"/>
    <link href="../../public/css/Breadcrumb.css" rel="stylesheet"/>
    <link href="../../public/css/botones.css" rel="stylesheet" />
    <link href="../../public/css/alerta.css" rel="stylesheet"/>
    <title>MPCH::DocumentosFirmados</title>
    <style>
      body:not([data-bs-theme="dark"]) .dropdown-item:hover,
      body:not([data-bs-theme="dark"]) .nav-link:hover {
        background-color: rgba(0, 0, 0, 0.03);
        transition: all 0.2s ease-in-out;
      }
      div.dataTables_filter {
        display: none !important;
      }
      th {
        color: #0054a6 !important;
      }
  
      .swal2-container {
        background-color: rgba(0, 0, 0, 0.25) !important;
        backdrop-filter: blur(2px);
      }
      .swal2-popup {
        background: #fff !important;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px !important;
      }
      .form-text {
        font-size: 12px;
        color: #6c757d;
      }
      .modal-header{
        background-color: #252422;
      }
      th, td {
        max-width: 600px !important;     
        white-space: normal;      
        word-break: break-word;   
        overflow-wrap: break-word; 
        vertical-align: middle;   
      }
     #documento_data {
      border-collapse: collapse;
    }

    /* Encabezado con borde inferior */
    #documento_data thead th {
      background-color: #f8f9fa;
      border-top: 1px solid rgb(192, 192, 192);
      border-bottom: 1px solid rgb(192, 192, 192);
      border-left: 1px solid rgb(192, 192, 192);
      border-right: 1px solid rgb(192, 192, 192);
      vertical-align: middle;
      text-align: center;
    }

    /* Celdas del cuerpo: solo bordes laterales */
    #documento_data tbody td {
      border-top: none !important; /* asegúrate que no se herede */
      border-bottom: none;
      border-left: 1px solid rgb(192, 192, 192);
      border-right: 1px solid rgb(192, 192, 192);
      vertical-align: middle;
      text-align: center;
      font-size: 12px;
    }

.upload-area {
  margin-top: 1.25rem;
  background-color: transparent;
  padding: 1rem;
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  border: 1px dashed #6a6b76;
}

.upload-area:hover,
.upload-area:focus {
  cursor: pointer;
  border: 1px solid #6a6b76;
}

.upload-area:hover .upload-area-icon,
.upload-area:focus .upload-area-icon {
  transform: scale(1.3);
  transition-duration: 0.3s;
}

.upload-area-icon {
  display: block;
  width: 2.25rem;
  height: 2.25rem;
  fill: #1cc972;
  margin: 0 auto; /* Centrado horizontal */
}


.upload-area-title {
  margin-top: 1rem;
  display: block;
  font-weight: 700;
  color: #0d0f21;
}

.upload-area-description {
  display: block;
  color: #6a6b76;
}

.upload-area-description strong {
  color: #1cc972;
  font-weight: 700;
}
.upload-area.highlight {
  border: 2px dashed #28a745;
  background-color: rgba(40, 167, 69, 0.05);
  transition: all 0.2s ease-in-out;
}


    </style>
</head>
<body>
  <?php require_once("../html/mainProfile.php"); ?>
  <div class="page-wrapper">
    <div class="page-header d-print-none">
      <div class="container-xl">

        <!-- Breadcrumb -->
        <nav class="breadcrumb mb-3">
          <a href="../adminMain/">Inicio</a>
          <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
          <span class="breadcrumb-item active">Procesos</span>
          <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
          <span>Documentos Firmados</span>
        </nav>

        <!-- Título -->
        <div class="row g-2 mb-5 align-items-center">
          <div class="col">
            <h2 class="page-title">
              GESTIÓN DE DOCUMENTOS FIRMADOS
            </h2>
          </div>
          <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
              <button class="button2" id="add_button" 
              onclick=" nuevoregistro()">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-device-imac-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12.5 17h-8.5a1 1 0 0 1 -1 -1v-12a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v8.5" /><path d="M3 13h13.5" /><path d="M8 21h4.5" /><path d="M10 17l-.5 4" /><path d="M16 19h6" /><path d="M19 16v6" /></svg>
                  REGISTRAR BIEN
              </button>
            </div>
          </div>
        </div>
        <div class="row mb-3">
            <div class="col-12 mb-4">
                <div class="card border-0" style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
                <div class="card-status-start bg-primary"></div>
                <div class="card-header">
                    <h3 class="card-title">
                    <i class="fa-solid fa-folder-open text-primary me-2"></i> LISTADO DE DOCUMENTOS SUBIDOS
                    </h3>
                </div>
                <div class="table-responsive m-4">
                    <input type="text" id="buscar_documento" class="form-control mb-3" placeholder="Buscar documento...">
                    <table id="documento_data" class="table card-table table-vcenter text-nowrap datatable" style="width: 99%;">
                    <thead>
                      <tr>
                        <th>Tipo</th>
                        <th>Área</th>
                        <th>Usuario</th>
                        <th>Descripción</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>

                    <tbody>
                        <!-- Rellenado por JS -->
                    </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Alerta carga -->
  <div id="alerta-carga" class="alerta-top-end alert-container" style="display: none;">
    <div class="success-alert">
      <div class="content-left">
        <div class="icon-bg">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon-check" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.5 12.75l6 6 9-13.5" />
          </svg>
        </div>
        <div class="text-content">
          <p class="title">Cargando documentos...</p>
          <p class="description">Espere mientras se obtiene la información.</p>
        </div>
      </div>
    </div>
  </div>
  <?php require_once("modalVerDocumento.php"); ?>
   <?php require_once("modalregistrar.php"); ?>
  <?php require_once("../html/footer.php"); ?>
  <?php require_once("../html/mainjs.php"); ?>
  <script type="text/javascript" src="carga.js"></script>
  <script type="text/javascript" src="documento.js"></script>
  <script type="text/javascript" src="arrastrar.js"></script>
</body>
</html>
<?php
} else {
  header("Location:" . Conectar::ruta() . "view/404/");
}
?>
