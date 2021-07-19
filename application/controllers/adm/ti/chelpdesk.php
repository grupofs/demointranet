<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Conditional;
use PhpOffice\PhpSpreadsheet\Writer\IWriter;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Chelpdesk extends CI_Controller {
	function __construct() {
		parent:: __construct();	
		$this->load->model('adm/ti/mhelpdesk');
		$this->load->model('mglobales');
		$this->load->library('encryption');
		$this->load->helper(array('form','url','download','html','file'));
		$this->load->library('form_validation');
    }
    
    public function getempleados() { // Recupera empleado CBO	 
		$resultado = $this->mhelpdesk->getempleados();
		echo json_encode($resultado);
	}
    
    public function getlistarbanco() { // Recupera empleado CBO	 
		$resultado = $this->mhelpdesk->getlistarbanco();
		echo json_encode($resultado);
	}
    
	public function setactionbanco() { // Recupera empleado CBO	 
		if($_POST['action'] == 'edit')
		{
			$idbanco	= $_POST['idbanco'];
			$nombanco	= $_POST['nombanco'];
			$indvigencia	= $_POST['indvigencia'];
			
			$this->mhelpdesk->setactionbanco($idbanco,$nombanco,$indvigencia);
		}
		/*$resultado = $this->mhelpdesk->setactionbanco();
		echo json_encode($resultado);*/
	}
}
?>