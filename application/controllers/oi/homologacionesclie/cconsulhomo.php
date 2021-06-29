<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cconsulhomo extends CI_Controller { 
    function __construct() {
		parent:: __construct();	
		$this->load->model('oi/homologacionesclie/mconsulhomo');
		$this->load->helper(array('form','url','download','html','file'));
        $this->load->library(array('form_validation','session','encryption'));
    }

    /** RECUPERAR TABLAS - HOMOLOGACIONES **/ 
		// Lista de homologaciones
		public function getbuscarhomologaciones(){	
			$varnull 			= 	'';
			$celestado			= 	'';

			$estado = $this->input->post('estado');

			foreach($estado as $destado)
			{
				$celestado = $destado.','.$celestado;
			}
			$countestado =strlen($celestado) ;
			$celestado = substr($celestado,0,$countestado-1);

			$fregini = $this->input->post('fregini');
			$fregfin = $this->input->post('fregfin');
			$finiini = $this->input->post('finiini');
			$finifin = $this->input->post('finifin');
			$ftermini = $this->input->post('ftermini');
			$ftermfin = $this->input->post('ftermfin');

			$parametros = array(
				'@CCIA' 	        =>	$this->input->post('ccia'),
				'@CLIENTE' 	        =>	$this->input->post('ccliente'),
				'@PROVEEDOR' 	    =>	$this->input->post('proveedor'),
				'@ESTADOEVAL' 		=>  $celestado, 
				'@TIPOPROVEEDOR' 	=>  $this->input->post('tipoproveedor'),
				'@PRODUCTO' 		=>  ($this->input->post('producto') == $varnull) ? '%' : '%'.$this->input->post('producto').'%', 
				'@MARCA' 			=>  ($this->input->post('marca') == $varnull) ? '%' : '%'.$this->input->post('marca').'%', 
				'@FREGINI' 		    =>  ($this->input->post('fregini') == '%') ? NULL : substr($fregini, 6, 4).'-'.substr($fregini,3 , 2).'-'.substr($fregini, 0, 2), 
				'@FREGFIN' 		    =>  ($this->input->post('fregfin') == '%') ? NULL : substr($fregfin, 6, 4).'-'.substr($fregfin,3 , 2).'-'.substr($fregfin, 0, 2),  
				'@FINIINI' 			=>  ($this->input->post('finiini') == '%') ? NULL : substr($finiini, 6, 4).'-'.substr($finiini,3 , 2).'-'.substr($finiini, 0, 2),
				'@FINIFIN' 			=>  ($this->input->post('finifin') == '%') ? NULL : substr($finifin, 6, 4).'-'.substr($finifin,3 , 2).'-'.substr($finifin, 0, 2),
				'@FTERMINI' 		=>  ($this->input->post('ftermini') == '%') ? NULL : substr($ftermini, 6, 4).'-'.substr($ftermini,3 , 2).'-'.substr($ftermini, 0, 2),			
				'@FTERMFIN' 	    =>	($this->input->post('ftermfin') == '%') ? NULL : substr($ftermfin, 6, 4).'-'.substr($ftermfin,3 , 2).'-'.substr($ftermfin, 0, 2),
			);
			$resultado = $this->mconsulhomo->getbuscarhomologaciones($parametros);
			echo json_encode($resultado);
		}
		
		// Lista de alertas por fecha
		public function getalertasfecha(){	
			$fvence = $this->input->post('vence');

			$parametros = array(
				'@CCIA' 	        =>	$this->input->post('ccia'),
				'@CLIENTE' 	        =>	$this->input->post('ccliente'),
				'@PROVEEDOR' 	    =>	$this->input->post('proveedor'),			
				'@FVENCE' 	    	=>	substr($fvence, 6, 4).'-'.substr($fvence,3 , 2).'-'.substr($fvence, 0, 2),
			);
			$resultado = $this->mconsulhomo->getalertasfecha($parametros);
			echo json_encode($resultado);
        }
		
		// Recupera lista del detalle
		public function getlistarrequisitos(){	
			$parametros = array(
				'@CEVAL' 	        =>	$this->input->post('ceval'),
				'@CPRODUCTO' 	    =>	$this->input->post('cproducto'),
			);
			$resultado = $this->mconsulhomo->getlistarrequisitos($parametros);
			echo json_encode($resultado);
		}


		/** LLENAR LISTAS - HOMOLOGACIONES **/ 
		// Lista de proveedores
		public function getproveedoreshomo(){		
			$ccliente = $this->input->post('ccliente');		
			$resultado = $this->mconsulhomo->getproveedoreshomo($ccliente);
			echo json_encode($resultado);
		}	

		// Lista de estados
		public function getestadoshomo(){		
			$ccliente = $this->input->post('ccliente');		
			$resultado = $this->mconsulhomo->getestadoshomo($ccliente);
			echo json_encode($resultado);
		}	

		// Lista de tipo de proveedores
		public function gettipoprovedorhomo(){		
			$ccliente = $this->input->post('ccliente');		
			$resultado = $this->mconsulhomo->gettipoprovedorhomo($ccliente);
			echo json_encode($resultado);
		}	
		
}