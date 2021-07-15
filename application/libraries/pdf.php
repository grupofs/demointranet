<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Dompdf\Dompdf;

class Pdf extends DOMPDF {
    protected function ci()
    {
        return get_instance();
    }
    public function load_view($html){

        $dompdf = new Dompdf();
        //$html = $this->ci()->load->view($view, $data, TRUE);

        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('etiqueta', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();
        $time = time();

        // Output the generated PDF to Browser
        $dompdf->stream("welcome-". $time, array("Attachment" => 0));
    }
}
?>