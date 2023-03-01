<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// panggil autoload dompdf nya
require_once 'dompdf-master/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;
class Pdf{  
    public function generate($html, $filename='', $paper = '', $orientation = '', $stream=TRUE)
    {   
        // ob_start();
// require "template.php";

        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $pdf = new Dompdf($options);
        $pdf->loadHtml($html);
        $pdf->set_option("isPhpEnabled", true);
        $pdf->setPaper($paper, $orientation);
        $pdf->render();
        if ($stream) {
            $pdf->stream($filename.".pdf", array("Attachment" => 0));
        } else {
            return $pdf->output();
        }
        // $html = ob_get_clean();
    }
}