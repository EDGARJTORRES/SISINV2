<?php
require_once("../public/fpdf/fpdf.php");

class PDF extends FPDF
{


protected $widths;
protected $aligns;

function SetWidths($w)
{
    // Set the array of column widths
    $this->widths = $w;
}

function SetAligns($a)
{
    // Set the array of column alignments
    $this->aligns = $a;
}
function Row($data)
{
    // Calcula la altura de la fila
    $nb = 0;
    for ($i = 0; $i < count($data); $i++)
        $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
    $h = 5 * $nb;

    // Verifica si es necesario agregar una nueva página
    $this->CheckPageBreak($h);

    // Dibuja las celdas de la fila
    for ($i = 0; $i < count($data); $i++) {
        $w = $this->widths[$i];
        $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

        // Guarda la posición actual
        $x = $this->GetX();
        $y = $this->GetY();
        
        // Calcula la altura del texto usando GetStringHeight
        $textHeight = $this->GetStringHeight($i, $data[$i]);
        
        // Calcula la posición y del texto para centrar verticalmente
        $yCentered = $y + ($h - $textHeight) / 2;

        // Dibuja el borde de la celda
        $this->Rect($x, $y, $w, $h);

        // Establece la posición centrada verticalmente
        $this->SetXY($x, $yCentered);
        
        // Imprime el texto centrado verticalmente
        $this->MultiCell($w, 5, $data[$i], 0, $a);

        // Restablece la posición de la celda
        $this->SetXY($x + $w, $y);
    }

    // Avanza a la siguiente línea
    $this->Ln($h);
}

function GetStringHeight($index, $text)
{
    // Utiliza el método NbLines para calcular la cantidad de líneas necesarias
    $nbLines = $this->NbLines($this->widths[$index], $text);
    // Calcula la altura del texto multiplicando el número de líneas por la altura de la línea (5)
    return 5 * $nbLines;
}



function Row2($data)
{
    // Calculate the height of the row
    $nb = 0;
    for($i = 0; $i < count($data); $i++)
        $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
    $h = 5 * $nb;
    // Issue a page break first if needed
    $this->CheckPageBreak($h);
    // Draw the cells of the row
    for($i = 0; $i < count($data); $i++)
    {
        $w = $this->widths[$i];
        $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        // Save the current position
        $x = $this->GetX();
        $y = $this->GetY();
        // Do not draw the border
        // Print the text
        $this->MultiCell($w, 5, $data[$i], 0, $a);
        // Put the position to the right of the cell
        $this->SetXY($x + $w, $y);
    }
    // Go to the next line
    $this->Ln($h);
}


function CheckPageBreak($h)
{
    // If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w, $txt)
{
    // Compute the number of lines a MultiCell of width w will take
    if(!isset($this->CurrentFont))
        $this->Error('No font has been set');
    $cw = $this->CurrentFont['cw'];
    if($w==0)
        $w = $this->w-$this->rMargin-$this->x;
    $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
    $s = str_replace("\r",'',(string)$txt);
    $nb = strlen($s);
    if($nb>0 && $s[$nb-1]=="\n")
        $nb--;
    $sep = -1;
    $i = 0;
    $j = 0;
    $l = 0;
    $nl = 1;
    while($i<$nb)
    {
        $c = $s[$i];
        if($c=="\n")
        {
            $i++;
            $sep = -1;
            $j = $i;
            $l = 0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep = $i;
        $l += $cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i = $sep+1;
            $sep = -1;
            $j = $i;
            $l = 0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}

}