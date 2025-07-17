<?php
require_once("../config/conexion.php");
require_once("../models/Stick.php");
require_once("../models/Bitacora.php");
if (!class_exists('TCPDF')) {
    require_once('../public/libs/TCPDF/tcpdf.php');
}
$bitacora = new Bitacora();
$stick = new Stick();
switch ($_GET["op"]) {
    case 'imprimir':
        if (class_exists('TCPDF')) {
            ob_clean();
            class MYPDF extends TCPDF {
                public function Header() {}
            }
            $pdf = new MYPDF('L', 'mm', array(50.8, 101.6), true, 'UTF-8', false);
            $pdf->SetMargins(0, 0, 0);
            $pdf->SetAutoPageBreak(false);
            $pdf->AddPage();

            $id = $_POST['bien_id'];
            $datos = $stick->get_nro_imprimir($id);

            if (is_array($datos) && count($datos) > 0) {
                foreach ($datos as $index => $row) {
                    $ruta = Conectar::ruta();
                    $barcode_url = $ruta . 'public/barcode.php?text=' . $row["bien_codbarras"] . '&size=20&orientation=horizontal&codetype=CODE128&print=true';
                    $logo = $ruta . 'public/logo_mpch2.png';
                    $logo2 = $ruta . 'public/LOGOMPCH.png';
                    $barcode_data = file_get_contents($barcode_url);
                    $logo_data = file_get_contents($logo);
                    $logo2_data = file_get_contents($logo2);

                    if ($barcode_data !== false && $logo_data !== false && $logo2_data !== false) {
                        $logo_width = 18;
                        $second_logo_width = 18;
                        $space_between = 2;
                        $total_width = $logo_width + $space_between + $second_logo_width;
                        $start_x = ((101.6 - $total_width) / 2);
                        $y_position = 6;

                        $pdf->Image('@' . $logo_data, $start_x, $y_position, $logo_width, 15, '', '', '', false, 100);
                        $second_logo_x = $start_x + $logo_width + $space_between;
                        $pdf->Image('@' . $logo2_data, $second_logo_x, $y_position, $second_logo_width, 15, '', '', '', false, 100);

                        $text_x = $second_logo_x + $second_logo_width + 2;
                        $text_y = $y_position + 1.5;
                        $pdf->SetFont('times', 'B', 14);
                        $pdf->SetTextColor(0, 0, 0);
                        $pdf->SetXY($text_x, $text_y);
                        $pdf->Cell(0, 4, "Inventario", 0, 1, 'L');

                        $pdf->SetFont('times', 'B', 22);
                        $pdf->SetXY($text_x, $text_y + 5);
                        $pdf->Cell(0, 4, "2025", 0, 1, 'L');

                        $barcode_width = 0;
                        $barcode_height = 20;
                        $barcode_x = ((101.6 - 70) / 2) + 7;
                        $barcode_y = 23;
                        $pdf->Image('@' . $barcode_data, $barcode_x, $barcode_y, 0, $barcode_height, '', '', '', false, 100);
                    } else {
                        echo "No se pudo obtener una o más imágenes.";
                        exit;
                    }
                }
                $pdf->Output('codigo_individual.pdf', 'I');
            } else {
                echo "No se encontraron datos.";
            }
        } else {
            echo "Error: No se pudo cargar la clase TCPDF.";
        }
        break;
    case 'imprimir_barras':
        if (class_exists('TCPDF')) {
            ob_clean();
            class MYPDF extends TCPDF {
                public function Header() {
                }
            }
            $pdf = new MYPDF('L', 'mm', array(50.8, 101.6), true, 'UTF-8', false);
            $pdf->SetMargins(0, 0, 0);
            $pdf->SetAutoPageBreak(false);
            $pdf->AddPage();
            $ruta = Conectar::ruta();
            $barcode_url = $ruta . 'public/barcode.php?text=' . $_POST['bien_codbarras'] . '&size=20&orientation=horizontal&codetype=CODE128&print=true';
            $logo = $ruta . 'public/logo_mpch2.png';
            $logo2 = $ruta . 'public/LOGOMPCH.png';
            $barcode_data = file_get_contents($barcode_url);
            $logo_data = file_get_contents($logo);
            $logo2_data = file_get_contents($logo2);
            if ($barcode_data !== false && $logo_data !== false && $logo2_data !== false) {
                // Posicionar y dibujar logos
                $logo_width = 18;
                $second_logo_width = 18;
                $space_between = 2;
                $total_width = $logo_width + $space_between + $second_logo_width;
                $start_x = ((101.6 - $total_width) / 2);
                $y_position = 6;
                $pdf->Image('@' . $logo_data, $start_x, $y_position, $logo_width, 15, '', '', '', false, 100);
                $second_logo_x = $start_x + $logo_width + $space_between;
                $pdf->Image('@' . $logo2_data, $second_logo_x, $y_position, $second_logo_width, 15, '', '', '', false, 100);
                $text_x = $second_logo_x + $second_logo_width + 2;
                $text_y = $y_position + 1.5;
                $pdf->SetFont('times', 'B', 14);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetXY($text_x, $text_y);
                $pdf->Cell(0, 4, "Inventario", 0, 1, 'L');
                $pdf->SetFont('times', 'B', 22);
                $pdf->SetXY($text_x, $text_y + 5);
                $pdf->Cell(0, 4, "2025", 0, 1, 'L');
                $barcode_height = 20;
                $barcode_x = ((101.6 - 70) / 2) + 7;
                $barcode_y = 23;
                $pdf->Image('@' . $barcode_data, $barcode_x, $barcode_y, 0, $barcode_height, '', '', '', false, 100);
            } else {
                echo "No se pudo obtener una o más imágenes.";
                exit;
            }

            // Mostrar el PDF generado en el navegador
            $pdf->Output('codigo_barras_individual.pdf', 'I');
        } else {
            echo "Error: No se pudo cargar la clase TCPDF.";
        }
        break;

    case 'imprimirDependencia':
        // Verificar si la clase TCPDF se ha cargado correctamente
        if (class_exists('TCPDF')) {
            // Limpiar cualquier salida previa
            ob_clean();

            // Definir la clase MYPDF que extiende TCPDF
            class MYPDF extends TCPDF
            {
                // Método para definir el encabezado
                public function Header()
                {
                    // No hacer nada en el encabezado para eliminar la línea
                }
            }

            // Crear una instancia de TCPDF con tamaño personalizado
            $pdf = new MYPDF('L', 'mm', array(25, 50), true, 'UTF-8', false);

            // Establecer márgenes y agregar una nueva página
            $pdf->SetMargins(0, 0, 0);
            $pdf->SetAutoPageBreak(false);
            $pdf->AddPage();

            // Obtener los datos de las imágenes a imprimir
            $datos = $stick->get_nros_imprimir_grupo($_POST['depe_id']);

            if (is_array($datos) && count($datos) > 0) {
                // Coordenadas iniciales para la primera imagen


                foreach ($datos as $row) {
                    // Obtener la ruta base
                    $ruta = Conectar::ruta();

                    // Construir la URL de la imagen
                    $url = $ruta . 'public/barcode.php?text=' . $row["objdepe_codbarras"] . '&size=20&orientation=horizontal&codetype=CODE128&print=true';

                    // Obtener el contenido de la URL como una cadena
                    $image_data = file_get_contents($url);
                    $y = 10;
                    if ($image_data !== false) {
                        // Obtener el ancho y alto de la imagen
                        list($width, $height) = getimagesizefromstring($image_data);
                        $x = 5;
                        $y += (($height) / 3) - 20;
                        // Insertar la imagen desde los datos obtenidos
                        $pdf->Image('@' . $image_data, $x, $y, $width / 5, $height / 5, '', '', '', false, 100, '', false, false, 0, false, false, false);
                        $y += 30;
                        // Si se alcanza el final de la página, agregar una nueva
                        if ($y > 31) {
                            $pdf->AddPage();
                            $y = ((100 - $height) / 2) - 20; // Reiniciar la posición Y
                        }
                    } else {
                        echo "No se pudo obtener la imagen desde la URL.";
                    }
                }

                // Salida del PDF
                $pdf->Output('example_008.pdf', 'I');
            } else {
                echo "No se encontraron datos para imprimir.";
            }
        } else {
            // La clase TCPDF no se ha cargado correctamente
            echo "Error: No se pudo cargar la clase TCPDF.";
        }
        break;
    case 'imprimir_multiple':
        if (class_exists('TCPDF')) {
            ob_clean();
            class MYPDF extends TCPDF {
                public function Header() {}
            }
            $pdf = new MYPDF('L', 'mm', array(50.8, 101.6), true, 'UTF-8', false);
            $pdf->SetMargins(0, 0, 0);
            $pdf->SetAutoPageBreak(false);
            $pdf->AddPage();
            $ids = $_POST['bien_id'];
            if (!is_array($ids)) {
                $ids = [$ids];
            }
            $datos = [];
            foreach ($ids as $id) {
                $tmp = $stick->get_nro_imprimir($id);
                if (is_array($tmp)) {
                    $datos = array_merge($datos, $tmp);
                }
            }
            if (count($datos) > 0) {
                foreach ($datos as $index => $row) {
                    $ruta = Conectar::ruta();
                    $barcode_url = $ruta . 'public/barcode.php?text=' . $row["bien_codbarras"] . '&size=20&orientation=horizontal&codetype=CODE128&print=true';
                    $logo = $ruta . 'public/logo_mpch2.png';
                    $logo2 = $ruta . 'public/LOGOMPCH.png';
                    $barcode_data = file_get_contents($barcode_url);
                    $logo_data = file_get_contents($logo);
                    $logo2_data = file_get_contents($logo2);
                    if ($barcode_data !== false && $logo_data !== false && $logo2_data !== false) {
                        $logo_width = 18;
                        $second_logo_width = 18;
                        $space_between = 2;
                        $total_width = $logo_width + $space_between + $second_logo_width;
                        $start_x = ((101.6 - $total_width) / 2); // Mueve todo el bloque más a la derecha
                        $y_position = 6;
                        $pdf->Image('@' . $logo_data, $start_x, $y_position, $logo_width, 15, '', '', '', false, 100);
                        $second_logo_x = $start_x + $logo_width + $space_between;
                        $pdf->Image('@' . $logo2_data, $second_logo_x, $y_position, $second_logo_width, 15, '', '', '', false, 100);
                        $text_x = $second_logo_x + $second_logo_width + 2;
                        $text_y = $y_position + 1.5; 
                        $pdf->SetFont('times', 'B', 14);
                        $pdf->SetTextColor(0, 0, 0);
                        $pdf->SetXY($text_x, $text_y);
                        $pdf->Cell(0, 4, "Inventario", 0, 1, 'L');
                        $pdf->SetFont('times', 'B', 22);
                        $pdf->SetXY($text_x, $text_y + 5);
                        $pdf->Cell(0, 4, "2025", 0, 1, 'L');
                        $barcode_width = 0;
                        $barcode_height = 20;
                        $barcode_x = ((101.6 - 70) / 2) + 7; // ajusta solo la posición horizontal
                        $barcode_y = 23;

                        $pdf->Image('@' . $barcode_data, $barcode_x, $barcode_y, 0, $barcode_height, '', '', '', false, 100);
                        if ($index < count($datos) - 1) {
                            $pdf->AddPage();
                        }
                    } else {
                        echo "No se pudo obtener una o más imágenes.";
                        exit;
                    }
                }
                $pdf->Output('codigos_seleccionados.pdf', 'I');
            } else {
                echo "No se encontraron datos.";
            }
        } else {
            echo "Error: No se pudo cargar la clase TCPDF.";
        }
        break;

}
