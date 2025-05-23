<?php
require_once("../config/conexion.php");
require_once("../models/Stick.php");
require_once("../models/Bitacora.php");

// Verificar si la clase TCPDF existe
if (!class_exists('TCPDF')) {
    // Intentar incluir el archivo de la clase TCPDF
    require_once('../public/libs/TCPDF/tcpdf.php');
}
$bitacora = new Bitacora();
$stick = new Stick();

switch ($_GET["op"]) {
    case 'imprimir':
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
            $pdf = new MYPDF('L', 'mm', array(500, 250), true, 'UTF-8', false);
            $datos = $stick->get_nro_imprimir($_POST['bien_id']);
            // Establecer márgenes y agregar una nueva página
            $pdf->SetMargins(0, 0, 0);
            $pdf->SetAutoPageBreak(false);
            $pdf->AddPage();

            if (is_array($datos) == true && count($datos) <> 0) {
                foreach ($datos as $row) {
                    // Obtener la ruta base
                    $ruta = Conectar::ruta();

                    $url = $ruta . 'public/barcode.php?text=' . $row["bien_codbarras"] . '&size=20&orientation=horizontal&codetype=CODE128&print=true';
                    $logo = $ruta . 'public/LOGOMPCH.png';

                    // Obtener el contenido de la URL como una cadena
                    $image_data = file_get_contents($url);
                    $image_data2 = file_get_contents($logo);
                    $pdf->SetMargins(0, 0, 0);
                    if ($image_data !== false) {
                        // Obtener el ancho y alto de la imagen
                        $width = 450;
                        $height = 150;
                        // Calcular las coordenadas x e y para centrar la imagen
                        $x = (950 / 2) - $width; // Centrar la imagen horizontalmente
                        $y = (500 / 2) - $height; // Ajustar la posición vertical de la imagen
                        $x2 = 60;
                        $y2 = 10;
                        $pdf->Image('@' . $image_data2, $x2, $y2, 160, 80, '', '', '', false, 100, '', false, false, 0, false, false, false);
                        // Después de la imagen, mostrar el título
                        $pdf->SetFont('times', 'B', 70);
                        $pdf->SetTextColor(0, 0, 0); // Color negro
                        $pdf->setY(1);
                        $pdf->setX(230);
                        $pdf->Cell(0, 0, "Municipalidad", 0, 1, 'L');
                        $pdf->setX(230);
                        $pdf->Cell(0, 0, "Provincial", 0, 1, 'L');
                        $pdf->setX(230);
                        $pdf->Cell(0, 0, "De Chiclayo", 0, 1, 'L');
                        // Insertar la imagen desde los datos obtenidos
                        $pdf->Image('@' . $image_data, $x, $y, $width, $height, '', '', '', false, 100, '', false, false, 0, false, false, false);
                        $pdf->Ln(2);

                        // A continuación, mostrar el texto
                        $pdf->SetFont('times', '', 80);
                        $pdf->SetTextColor(0, 0, 0); // Color negro

                        $pdf->setY(200);
                        /*  $pdf-> setY(10); */
                        $pdf->Cell(0, 10, "Inventario 2024", 0, 1, 'C');
                    } else {
                        echo "No se pudo obtener la imagen desde la URL.";
                    }
                }
            }
            // Salida del PDF
            $pdf->Output('qrbien.pdf', 'I');
        } else {
            // La clase TCPDF no se ha cargado correctamente
            echo "Error: No se pudo cargar la clase TCPDF.";
        }
        break;
    case 'imprimir_barras':
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
            $pdf = new MYPDF('L', 'mm', array(500, 250), true, 'UTF-8', false);

            // Establecer márgenes y agregar una nueva página
            $pdf->SetMargins(0, 0, 0);
            $pdf->SetAutoPageBreak(false);
            $pdf->AddPage();

            $ruta = Conectar::ruta();

            $url = $ruta . 'public/barcode.php?text=' . $_POST['bien_codbarras'] . '&size=20&orientation=horizontal&codetype=CODE128&print=true';
            $logo = $ruta . 'public/LOGOMPCH.png';

            // Obtener el contenido de la URL como una cadena
            $image_data = file_get_contents($url);
            $image_data2 = file_get_contents($logo);
            $pdf->SetMargins(0, 0, 0);
            if ($image_data !== false) {
                // Obtener el ancho y alto de la imagen
                $width = 450;
                $height = 150;
                // Calcular las coordenadas x e y para centrar la imagen
                $x = (950 / 2) - $width; // Centrar la imagen horizontalmente
                $y = (500 / 2) - $height; // Ajustar la posición vertical de la imagen
                $x2 = 60;
                $y2 = 10;
                $pdf->Image('@' . $image_data2, $x2, $y2, 160, 80, '', '', '', false, 100, '', false, false, 0, false, false, false);
                // Después de la imagen, mostrar el título
                $pdf->SetFont('times', 'B', 70);
                $pdf->SetTextColor(0, 0, 0); // Color negro
                $pdf->setY(1);
                $pdf->setX(230);
                $pdf->Cell(0, 0, "Municipalidad", 0, 1, 'L');
                $pdf->setX(230);
                $pdf->Cell(0, 0, "Provincial", 0, 1, 'L');
                $pdf->setX(230);
                $pdf->Cell(0, 0, "De Chiclayo", 0, 1, 'L');
                // Insertar la imagen desde los datos obtenidos
                $pdf->Image('@' . $image_data, $x, $y, $width, $height, '', '', '', false, 100, '', false, false, 0, false, false, false);
                $pdf->Ln(2);

                // A continuación, mostrar el texto
                $pdf->SetFont('times', '', 80);
                $pdf->SetTextColor(0, 0, 0); // Color negro

                $pdf->setY(200);
                /*  $pdf-> setY(10); */
                $pdf->Cell(0, 10, "Inventario 2024", 0, 1, 'C');
            } else {
                echo "No se pudo obtener la imagen desde la URL.";
            }


            // Salida del PDF
            $pdf->Output('qrbien.pdf', 'I');
        } else {
            // La clase TCPDF no se ha cargado correctamente
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
}
