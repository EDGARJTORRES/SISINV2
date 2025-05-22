<?php
require_once("../config/conexion.php");
require_once("../public/plantilla_reporte.php");
require_once("../models/Formato.php");
require_once("../models/Bitacora.php");
require_once("../models/Objeto.php");
$bitacora = new Bitacora();
$formato = new Formato();
$objeto = new Objeto();
switch ($_GET["op"]) {
    case "asignar":
        // Obtener datos enviados desde el frontend
        $dataDict = json_decode($_POST['dataDict'], true);
        $depe_receptor_depe = $formato->get_dependenciadatos($_POST['depe_receptor']);
        $depe_receptor = $formato->get_repe_datos($_POST['pers_id']);
        // Crear formato
        $formato->crear_formato(1, $_SESSION['usua_id_siin'], "", $_POST['depe_receptor'], '', $depe_receptor[0]['pers_id'], "", $depe_receptor_depe[0]['depe_denominacion'], "", $depe_receptor[0]['pers_dni'], "", $depe_receptor[0]['nombre_completo']);
        $bitacora->update_bitacora($_SESSION["usua_id_siin"]);
        // Obtener el último formato creado
        $formatos = $formato->ultimo_formatid();
        $idf = 1;
        foreach ($formatos as $id) {
            $idf = $id['form_id'];
        }
        // Iterar sobre los datos recibidos desde el frontend
        foreach ($dataDict as $codigoBarra => $item) {
            // Buscar bien_id utilizando buscar_obj_barras()
            $bien = $formato->buscar_obj_barras($codigoBarra);
            // Verificar si se encontró el bien y si bien_id está presente
            if ($bien && isset($bien[0]['bien_id'])) {
                $bien_id = $bien[0]['bien_id'];
                // Obtener el color y el estado específicos para este código de barras
                $color = $item['color'];
                $estado = $item['estado'];
                $comentarioBien = $item['comentario'];

                // Asignar bien al formato
                $formato->asigna_bienes(
                    $bien_id,
                    $idf,
                    $_POST["depe_receptor"],
                    $comentarioBien,
                    $color, // Asigna el color específico para este bien
                    $estado, // Asigna el estado específico para este bien
                    $_SESSION["usua_id_siin"],
                    $_POST['pers_id']

                );
                $bitacora->update_bitacora($_SESSION["usua_id_siin"]);
                $formato->actualizarbien(
                    $bien_id,
                    $estado
                );

                // Actualizar bitácora después de asignar bienes
                $bitacora->update_bitacora($_SESSION["usua_id_siin"]);
            }
        }
        break;
    case "desplazar":
        // Obtener datos enviados desde el frontend
        $dataDict = json_decode($_POST['dataDict'], true);
        $depe_receptor_depe = $formato->get_dependenciadatos($_POST['depe_receptor']);
        $depe_emisor_depe = $formato->get_dependenciadatos($_POST['depe_emisor']);
        $depe_emisor = $formato->get_repe_datos($_POST['pers_origen_id']);
        $depe_receptor = $formato->get_repe_datos($_POST['pers_destino_id']);


        // Crear formato
        $formato->crear_formato_desplaza(
            2,
            $_SESSION['usua_id_siin'],
            $_POST['depe_emisor'],
            $_POST['depe_receptor'],
            $depe_emisor[0]['pers_id'],
            $depe_receptor[0]['pers_id'],
            $depe_emisor_depe[0]['depe_denominacion'],
            $depe_receptor_depe[0]['depe_denominacion'],
            $depe_emisor[0]['pers_dni'],
            $depe_receptor[0]['pers_dni'],
            $depe_emisor[0]['nombre_completo'],
            $depe_receptor[0]['nombre_completo']
        );
        $bitacora->update_bitacora($_SESSION["usua_id_siin"]);

        // Obtener el último formato creado
        $formatos = $formato->ultimo_formatid();
        $idf = 1;
        foreach ($formatos as $id) {
            $idf = $id['form_id'];
        }

        // Iterar sobre los datos recibidos desde el frontend
        foreach ($dataDict as $codigoBarra => $item) {
            // Buscar bien_id utilizando buscar_obj_barras()
            $bien = $formato->buscar_obj_barras($codigoBarra);

            // Verificar si se encontró el bien y si bien_id está presente
            if ($bien && isset($bien[0]['bien_id'])) {
                $bien_id = $bien[0]['bien_id'];
                $formato->deleteBienDepe(
                    $bien_id
                );
                // Actualizar bitácora después de asignar bienes
                $bitacora->update_bitacora($_SESSION["usua_id_siin"]);

                // Obtener el color y el estado específicos para este código de barras
                $color = $item['color'];
                $estado = $item['estado'];
                $comentarioBien = $item['comentario'];

                // Asignar bien al formato
                $formato->asigna_bienes(
                    $bien_id,
                    $idf,
                    $_POST["depe_receptor"],
                    $comentarioBien,
                    $color, // Asigna el color específico para este bien
                    $estado, // Asigna el estado específico para este bien
                    $_SESSION["usua_id_siin"],
                    $_POST['pers_destino_id']

                );
                $bitacora->update_bitacora($_SESSION["usua_id_siin"]);
                $formato->actualizarbien(
                    $bien_id,
                    $estado
                );
                $bitacora->update_bitacora($_SESSION["usua_id_siin"]);
            }
        }
        break;


    case "mostrar":
        $datos = $formato->get_form_id($_POST["form_id"]);
        if (is_array($datos) == true and count($datos) <> 0) {
            foreach ($datos as $row) {
                $output["form_id"] = $row["form_id"];
                $output["tif_id"] = $row["tif_id"];
            }
            echo json_encode($output);
        }
        break;

    case "eliminar":
        $formato->delete_formato($_POST["form_id"]);
        $bitacora->update_bitacora($_SESSION["usua_id_siin"]);
        break;

    case "listar":
        $datos = $formato->get_formato();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["form_fechacrea"];
            $sub_array[] = $row["tif_nom"];
            $sub_array[] = $row["emisor"];
            $sub_array[] = $row["receptor"];
            $sub_array[] = $row["count"];
            $sub_array[] = $row["pers_nombre"];
            $sub_array[] = '
            <div class="dropdown">
            <a class="btn dropdown-toggle align-text-top" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
            Acciones
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#" onclick="imprimirFormato(' . $row["form_id"] . ')">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M17 17v4h-10v-4" />
                    <path d="M6 10v-5h12v5" />
                    <path d="M6 14h12" />
                    <path d="M9 17h6" />
                </svg>
                Imprimir
                </a>
                <a class="dropdown-item" href="#" onclick="eliminarformato(' . $row["form_id"] . ')">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M6 6l12 12" />
                    <path d="M6 18l12 -12" />
                </svg>
                Eliminar
                </a>
            </div>
            </div>';
            $data[] = $sub_array;
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);
        break;

    case "combo":
        $datos = $formato->get_tipoForm();
        if (is_array($datos) == true and count($datos) > 0) {
            $html = " <option label='Seleccione'></option>";
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['tif_id'] . "'>" . $row['tif_nom'] . "</option>";
            }
            echo $html;
        }
        break;
    case "eliminar_formato":
        $formato->delete_formato($_POST["form_id"]);
        $bitacora->update_bitacora($_SESSION["usua_id_siin"]);
        break;
    case "imprimir_formato":

        // Obtener los datos de la función get_formato_id()
        $datos = $formato->get_formato_id($_POST["form_id"]);
        $titulo = $datos[0]['tif_nom'];
        $datos_emisor = $formato->get_dependenciadatos($datos[0]['depe_emisor']);
        $datos_receptor = $formato->get_dependenciadatos($datos[0]['depe_receptor']);

        $Gerencia_emisor = "";
        $subgerencia_emisor = "";
        $area_emisor = "";

        $Gerencia_receptor = "";
        $subgerencia_receptor= "";
        $area_receptor = "";

        // Inicializa el nior_id con el nivel actual
        $nivel_actual_emisor = $datos_emisor[0]['nior_id'];
        $nivel_superior_emisor = $datos_emisor[0]['depe_id'];

        $nivel_actual_receptor = $datos_receptor[0]['nior_id'];
        $nivel_superior_receptor = $datos_receptor[0]['depe_id'];

  
        while ($nivel_actual_emisor >= 2) {
            // Obtén los datos del nivel superior
            $datos_superior_emisor = $formato->get_dependenciadatos($nivel_superior_emisor);
            
            // Actualiza el nivel actual
            $nivel_actual_emisor = $datos_superior_emisor[0]['nior_id'];
        
            // Verifica el nivel actual para asignar correctamente los valores de la jerarquía
            if ($nivel_actual_emisor == 2) {
                $Gerencia_emisor = $datos_superior_emisor[0]['depe_denominacion'];
                break;
            } elseif ($nivel_actual_emisor == 4) {
                $subgerencia_emisor = $datos_superior_emisor[0]['depe_denominacion'];
            } elseif ($nivel_actual_emisor == 5) {
                $area_emisor = $datos_superior_emisor[0]['depe_denominacion'];
            }
        
            // Actualiza el nivel superior para la próxima iteración
            $nivel_superior_emisor = $datos_superior_emisor[0]['depe_superior'];
        }
        
        while ($nivel_actual_receptor >= 2) {
            $datos_superior_receptor = $formato->get_dependenciadatos($nivel_superior_receptor);
            $nivel_actual_receptor = $datos_superior_receptor[0]['nior_id'];

            if ($nivel_actual_receptor == 2) {
                $Gerencia_receptor = $datos_superior_receptor[0]['depe_denominacion'];
                break;
            } elseif ($nivel_actual_receptor == 4) {
                $subgerencia_receptor = $datos_superior_receptor[0]['depe_denominacion'];
            } elseif ($nivel_actual_receptor == 5) {
                $area_receptor = $datos_superior_receptor[0]['depe_denominacion'];
            }

            // Actualiza el nivel superior para la próxima iteración
            $nivel_superior_receptor = $datos_superior_receptor[0]['depe_superior'];
        }


        // Crear un nuevo objeto PDF con orientación horizontal ("L")
        $pdf = new PDF("L", "mm", "A4");


        // Configura el documento PDF (agrega una nueva página)
        $pdf->AddPage();

        // Configura el estilo de fuente para el título
        $pdf->SetFont("Arial", "", 7);
        $pdf->SetX(30);
        $pdf->Image('../public/logo144.png', $pdf->GetX() - 5, $pdf->GetY() - 5, 0, 15);
        $pdf->SetXY(10, 20);
        $pdf->Cell(0, 5, utf8_decode('MUNICIPALIDAD PROVINCIAL DE CHICLAYO'), 0, 1, "L");
        // Título del documento


        // Convierte el título a UTF-8 usando mb_convert_encoding
        $t = mb_convert_encoding($titulo, 'UTF-8', 'ISO-8859-1');
        $pdf->SetFont("Arial", "B", 12);
        $pdf->SetTitle($t, true);
        $pdf->SetY(10);
        // Ahora puedes usar $t en tu PDF
        /*  $pdf->Cell(0, 10, $t, 0, 1, "C"); */
        $t_id = $datos[0]['tif_id'];
        if ($t_id == 1) {
            $pdf->Cell(0, 10, utf8_decode('ANEXO N°1: FORMATO ASIGNACIÓN DE BIENES EN USO'), 0, 1, "C");
        } else if ($t_id == 2) {
            $pdf->Cell(0, 10, utf8_decode('ANEXO N°2: FORMATO AUTORIZACIÓN DE DESPLAZAMIENTO EXTERNO DE BIENES PATRIMONIALES '), 0, 1, "C");
        }


        $pdf->Ln(1);
        $pdf->SetXY(20, 20);
        // Extraer solo el día, mes y año de la fecha
        $fecha = $datos[0]["form_fechacrea"];
        $fecha_formateada = substr($fecha, 0, 10);
        $pdf->SetFont("Arial", "B", 9);
        // Mostrar la fecha formateada
        $pdf->Cell(0, 10, utf8_decode('Fecha: ' . $fecha_formateada), 0, 1, 'R');
        $pdf->Ln(1);
        $pdf->SetXY(0, 0);
        // Configura el estilo de fuente para el contenido
        $pdf->SetFont("Arial", "", 10);

        // Dividir la página en dos columnas para los datos del emisor y del receptor
        $espaciado = 6;
        $espaciolin = 190;

        // Posición para los datos del emisor (columna izquierda)
        $pdf->SetXY(20, 25); // Ajusta las coordenadas según la ubicación deseada
        $pdf->SetFont("Arial", "B", 10);
        $pdf->Cell(100, $espaciado, "Datos del Emisor:", 0, 1);
        $pdf->SetFont("Arial", "", 8);


        // Imprime los datos del emisor
        $tletra =6  ;
        // Gerencia
        $pdf->SetX(20);
        $pdf->Cell(30, $espaciado, "Gerencia: ", 0, 0); // Imprime la etiqueta sin salto de línea
        $pdf->SetFont("Arial", "", $tletra );
        $pdf->Cell(100, $espaciado, utf8_encode($Gerencia_emisor), 0, 1); // Imprime el valor con salto de línea
        // Dibuja línea de separación justo debajo
        $pdf->Line(50, $pdf->GetY() - 1, 130, $pdf->GetY() - 1);
        $pdf->SetX(20);
        // Sub-Gerencia
        $pdf->SetFont("Arial", "", 8);
        $pdf->Cell(30, $espaciado, "Sub-Gerencia: ", 0, 0); // Imprime la etiqueta sin salto de línea
        $pdf->SetFont("Arial", "", $tletra );
        $pdf->Cell(100, $espaciado, utf8_encode( $subgerencia_emisor ), 0, 1); // Imprime el valor con salto de línea
        // Dibuja línea de separación justo debajo
        $pdf->Line(50, $pdf->GetY() - 1, 130, $pdf->GetY() - 1);
        $pdf->SetX(20);
        // Área
        $pdf->SetFont("Arial", "", 8);
        $pdf->Cell(30, $espaciado, utf8_decode("Área: "), 0, 0); // Imprime la etiqueta sin salto de línea
        $pdf->SetFont("Arial", "", $tletra );
        $pdf->Cell(100, $espaciado, utf8_encode( $area_emisor), 0, 1); // Imprime el valor con salto de línea
        // Dibuja línea de separación justo debajo
        $pdf->Line(50, $pdf->GetY() - 1, 130, $pdf->GetY() - 1);
        $pdf->SetX(20);
        // Representante
        $pdf->SetFont("Arial", "", 8);
        $pdf->Cell(30, $espaciado, "Representante: ", 0, 0); // Imprime la etiqueta sin salto de línea
        $pdf->SetFont("Arial", "", $tletra );
        $pdf->Cell(100, $espaciado, utf8_encode($datos[0]["form_repre_emisor_nom"]), 0, 1); // Imprime el valor con salto de línea
        // Dibuja línea de separación justo debajo
        $pdf->Line(50, $pdf->GetY() - 1, 130, $pdf->GetY() - 1);



        // Posición para los datos del receptor (columna derecha)
        $pdf->SetXY(160, 25); // Ajusta las coordenadas según la ubicación deseada
        $pdf->SetFont("Arial", "B", 10);
        $pdf->Cell(100, $espaciado, "Datos del Receptor:", 0, 1);
        $pdf->SetFont("Arial", "", 8);

        // Imprime los datos del receptor
        // Datos del receptor (columna derecha)
        $pdf->SetX(160); // Configura la posición inicial para la columna derecha

        // Gerencia
        $pdf->SetFont("Arial", "", 8);
        $pdf->Cell(30, $espaciado, "Gerencia: ", 0, 0); // Imprime la etiqueta sin salto de línea
        $pdf->SetFont("Arial", "", $tletra );
        $pdf->Cell(100, $espaciado, utf8_encode($Gerencia_receptor), 0, 1); // Imprime el valor con salto de línea
        $pdf->Line($espaciolin, $pdf->GetY() - 1, 270, $pdf->GetY() - 1); // Dibuja la línea justo debajo

        // Sub-Gerencia
        $pdf->SetX(160);
        $pdf->SetFont("Arial", "", 8);
        $pdf->Cell(30, $espaciado, "Sub-Gerencia: ", 0, 0); // Imprime la etiqueta sin salto de línea
        $pdf->SetFont("Arial", "", $tletra );
        $pdf->Cell(100, $espaciado, utf8_encode($subgerencia_receptor), 0, 1); // Imprime el valor con salto de línea
        $pdf->Line($espaciolin, $pdf->GetY() - 1, 270, $pdf->GetY() - 1);  // Dibuja la línea justo debajo

        // Área
        $pdf->SetX(160);
        $pdf->SetFont("Arial", "", 8);
        $pdf->Cell(30, $espaciado, utf8_decode("Área: "), 0, 0); // Imprime la etiqueta sin salto de línea
        $pdf->SetFont("Arial", "", $tletra );
        $pdf->Cell(100, $espaciado, utf8_encode($area_receptor), 0, 1); // Imprime el valor con salto de línea
        $pdf->Line($espaciolin, $pdf->GetY() - 1, 270, $pdf->GetY() - 1);  // Dibuja la línea justo debajo

        // Representante
        $pdf->SetX(160);
        $pdf->SetFont("Arial", "", 8);
        $pdf->Cell(30, $espaciado, "Representante: ", 0, 0); // Imprime la etiqueta sin salto de línea
        $pdf->SetFont("Arial", "", $tletra );
        $pdf->Cell(100, $espaciado, utf8_encode($datos[0]["form_repre_receptor_nom"]), 0, 1); // Imprime el valor con salto de línea
        $pdf->Line($espaciolin, $pdf->GetY() - 1, 270, $pdf->GetY() - 1); // Dibuja la línea justo debajo
        // Suponiendo que $data es un array de datos que contiene los objetos con `bien_id`

        // Configura la posición inicial para la tabla en el PDF
        $pdf->SetXY(10, $pdf->GetY() + 5);

        // Configura el estilo de fuente para el encabezado de la tabla
        $pdf->SetWidths([10, 30, 20, 70, 20, 20, 30, 25, 12, 38]);

        // Establece las alineaciones de las columnas
        $pdf->SetAligns(['C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C']);
        $pdf->SetFont('Helvetica', 'B', 8);
        // Encabezado de la tabla
        $header = [utf8_decode("N°"), utf8_decode("Código Patrimonial"), utf8_decode("Código Interno"), utf8_decode("Denominación"), "Marca", "Modelo", "Color", utf8_decode("Serie/Dimensión"), "Estado", utf8_decode("Observación")];
        $pdf->Row($header);
        $pdf->SetFont('Helvetica', '', 7.6);
        $count = 0;
        // Itera sobre cada objeto en `data` para obtener su `bien_id`
        $coun = 0; // Inicializa el contador de filas
        $maxFilas = 10; // Número máximo de filas que deseas en la tabla

        // Itera sobre los datos
        foreach ($datos as $indice) {
            // Obtén el `bien_id` del objeto actual
            $bien_id = $indice['bien_id'];

            // Llama a la función para obtener los datos del bien usando `bien_id`
            $datosBienes = $objeto->buscar_bien_id($bien_id);


            // Itera sobre los datos del bien y añádelos a la tabla en el PDF
            foreach ($datosBienes as $bien) {
                // Inicializa una variable para acumular los nombres de los colores
                // Supongamos que data['bien_color'] contiene la lista de IDs de colores en formato de cadena
                $bien_color = $bien['bien_color'];

                // Elimina los corchetes y divide la cadena en un array de IDs
                $color_ids = explode(",", str_replace(array("{", "}"), "", $bien_color));

                // Inicializa un array para almacenar los nombres de los colores
                $nombres_colores = [];

                // Inicializa un contador para rastrear cuántos IDs de color se han procesado
                $completed_requests = 0;

                // Itera sobre cada ID de color
                foreach ($color_ids as $color_id) {
                    // Usa la función get_color para obtener el nombre del color correspondiente al ID
                    $color_nom = $objeto->get_color($color_id);

                    // Si la función devuelve un nombre de color válido, agrégalo a nombres_colores
                    if (!empty($color_nom)) {
                        $nombres_colores[] = $color_nom[0]['color_nom'];
                    }

                    // Incrementa el contador de solicitudes completadas
                    $completed_requests++;
                }
                $colores_text = implode(', ', $nombres_colores);

                // Ahora $colores_text contiene los nombres de los colores separados por comas
                $codigo_interno_formateado = str_pad($bien["bien_id"], 4, '0', STR_PAD_LEFT);
                // Prepara la fila de datos para la tabla
                $fila = [
                    $coun + 1, // Número de fila (comienza desde 1)
                    $bien["codigo_cana"], // Código patrimonial
                    $codigo_interno_formateado, // Código interno
                    utf8_decode($bien["obj_nombre"]), // Denominación
                    utf8_decode($bien["marca_nom"]), // Marca
                    utf8_decode($bien["modelo_nom"]), // Modelo
                    $colores_text, // Color
                    $bien["bien_numserie"], // Serie/Dimensión
                    $bien["estadodepe"], // Estado
                    utf8_decode($bien["biendepe_obs"]) // Observación
                ];
                $pdf->Row($fila);
                $coun++; // Incrementa el contador de filas
            }
        }

        // Calcula el número de filas en blanco que se necesitan
        $filasRestantes = $maxFilas - $coun;

        // Añade las filas en blanco restantes si es necesario
        for ($i = 0; $i < $filasRestantes; $i++) {
            // Crea una fila llena de guiones ("-----")
            $filaEnBlanco = array_fill(0, 10, '--'); // 11 columnas llenas de guiones
            $pdf->Row($filaEnBlanco);
        }

        $pdf->ln(2);
        // Genera y muestra el PDF
        $pdf->SetFont('Helvetica', 'B', 8);
        $pdf->Cell(30, $espaciado, "LEYENDA ESTADO: (N) NUEVO   (B) BUENO   (R) REGULAR   (M) MALO ", 0, 0);
        $pdf->ln(5);
        $pdf->SetFont('Helvetica', '', 6);
        $pdf->Cell(30, $espaciado, " - EL USUARIO DECLARA HABER MOSTRADO TODOS LOS BIENES PATRIMONIALES QUE SE ENCUENTRAN BAJO SU RESPONSABILIDAD Y NO CONTAR CON MAS BIENES MATERIA DE INVENTARIO.", 0, 0);
        $pdf->ln(5);
        $pdf->Cell(30, $espaciado, utf8_decode(" - EL USUARIO ES RESPONSABLE DEL BUEN USO DE LOS BIENES PATRIMONIALES REGISTRADOS EN LA PRESENTE FICHA Y EN CASO DE PERDIDA O EXTRAVIO SERAN REPUESTOS O REEMBOLSADOS POR ÉL."), 0, 0);
        $pdf->ln(5);
        $pdf->Cell(30, $espaciado, utf8_decode(" - CUALQUIER MOVIMIENTO DE BIENES DENTRO O FUERA DE LAS INSTALACIONES DE LA MUNICIPALIAD DEBERÁ SER COMUNICADO AL RESPONSABLE DE CONTROL PATRIMONIAL BAJO RESPONSABILIDAD."), 0, 0);
        $pdf->ln(33);
        //FIRMAS
        // Configura la fuente en negrita para los títulos de firma
        $pdf->SetFont('Helvetica', 'B', 7);

        // Espaciado entre cada celda
        $espaciado = 5;

        // Posición inicial en la página (ajústala según tus necesidades)
        $posicionInicialX = 5;
        $posicionY = $pdf->GetY();

        // Ancho de cada celda (ajústalo según tus necesidades)
        $anchoCelda = 71;

        // Añade líneas de firma justo encima de los títulos
        // Establece el grosor de las líneas
        $pdf->SetLineWidth(0.1);

        // Dibuja una línea horizontal justo encima de cada título de firma
        for ($i = 0; $i < 4; $i++) {
            // Calcula la posición X para cada línea
            $posicionX = $posicionInicialX + $i * $anchoCelda;

            // Dibuja la línea
            $pdf->Line($posicionX + 10, $posicionY, $posicionX + 65, $posicionY);
        }

        // Incrementa la posición Y para los títulos de firma
        $posicionY += 1; // Ajusta el valor según necesites

        // Configura las celdas para los títulos de firma
        $pdf->SetXY($posicionInicialX, $posicionY + 2);
        $pdf->Cell($anchoCelda, $espaciado, "FIRMA DEL USUARIO", 0, 0, 'C');
        // Utiliza MultiCell para imprimir el texto con salto de línea automático
        $pdf->MultiCell($anchoCelda, 3, "V* B* FUNCIONARIO DEL AREA ORGANICA INVENTARIADA", 0, 'C');
        $pdf->SetXY(150,  $pdf->GetY() - 5);
        $pdf->Cell($anchoCelda, $espaciado, "INTEGRANTES DE B. PATRIMONIALES", 0, 0, 'C');
        $pdf->Cell($anchoCelda, $espaciado, "FIRMA DEL REPRESENTANTE", 0, 1, 'C');

        // Continúa con el resto de tu código para generar el PDF
        $pdf->Output();

        break;
}
