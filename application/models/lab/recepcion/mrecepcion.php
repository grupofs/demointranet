<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/** COTIZACION **/ 
class Mrecepcion extends CI_Model {
	function __construct() {
		parent:: __construct();	
		$this->load->library('session');
    }
    
   /** LISTADO **/ 

    public function getbuscarrecepcion($parametros) { // Buscar Cotizacion	
        $procedure = "call usp_lab_coti_getbuscarrecepcion(?,?,?,?,?,?,?)";
		$query = $this->db-> query($procedure,$parametros);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}		
    }
   /** REGISTRO **/ 

    public function getrecepcionmuestra($parametros) { // Buscar Cotizacion	
        $procedure = "call usp_lab_coti_getrecepcionmuestra(?,?)";
		$query = $this->db-> query($procedure,$parametros);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}		
    }

    public function setrecepcionmuestra($parametros) {  // Registrar evaluacion PT
        $this->db->trans_begin();

        $procedure = "call usp_lab_coti_setrecepcionmuestra(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
        $query = $this->db->query($procedure,$parametros);

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
        }
        else
        {
            $this->db->trans_commit();
            return $query->result(); 
        }   
    } 

    public function setordentrabajo($parametros) {  // Registrar evaluacion PT
        $this->db->trans_begin();

        $procedure = "call usp_lab_coti_setordentrabajo(?,?,?);";
        $query = $this->db->query($procedure,$parametros);

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
        }
        else
        {
            $this->db->trans_commit();
            return $query->result(); 
        }   
    } 

    public function setordentrabajoresult($parametros) {  // Registrar evaluacion PT
        $this->db->trans_begin();

        $procedure = "call usp_lab_coti_setordentrabajoresult(?,?,?,?,?,?,?);";
        $query = $this->db->query($procedure,$parametros);

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
        }
        else
        {
            $this->db->trans_commit();
            return $query->result(); 
        }   
    } 

    public function setupdateFechaOT($mhdncinternoordenservicio,$fordentrabajo,$nordentrabajo) { // Recuperar Password
		
        $data = array(
            "FORDENTRABAJO" => $fordentrabajo,
            "NORDENTRABAJO" => $nordentrabajo,
            "FORDENSERVICIO" => $fordentrabajo,
            "NORDENSERVICIO" => $nordentrabajo,
        );

        $this->db->where("cinternoordenservicio", $mhdncinternoordenservicio);
		if($this->db->update("pordenserviciotrabajo", $data)){
			return TRUE;
		}
    }
    
    public function getlistdetrecepcion($cinternocotizacion, $nversioncotizacion) { // Visualizar 
        $sql = "select nordentrabajo, DATEFORMAT(fordentrabajo, 'DD/MM/YYYY') as 'fordentrabajo', cinternoordenservicio from pordenserviciotrabajo 
                where cinternocotizacion = '".$cinternocotizacion."' and nversioncotizacion = ".$nversioncotizacion.";";
        $query  = $this->db->query($sql);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}			   
    }

    public function getpdfdatosot($idot) { // Listar Ensayos	
        $sql = "select A.cinternoordenservicio, A.cinternocotizacion, A.nversioncotizacion, 
                        DATEFORMAT(A.fordentrabajo, 'DD/MM/YYYY') as 'fordentrabajo', A.nordentrabajo, B.dobservacion2 as 'OBSERVACION' 
                from pordenserviciotrabajo A
                    join pcotizacionlaboratorio B on B.cinternocotizacion = A.cinternocotizacion and B.nversioncotizacion = A.nversioncotizacion
                where  A.cinternoordenservicio = ".$idot.";";
        $query  = $this->db->query($sql);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}		
    }

    public function getpdfdatosotprod($idot) { // Listar Ensayos	
        $sql = "select DISTINCT A.nordenservicio, A.fordentrabajo, E.cmuestra, E.drealproducto,
                        (TRIM(E.dcantidad) + ' ' + TRIM(E.dpresentacion) + 
                                CASE ISNULL(E.dlote, '') WHEN '' THEN 
                                        (CASE WHEN E.fenvase IS NULL THEN '' ELSE ' FE: '+CAST(E.fenvase AS VARCHAR(10)) END) + ' ' +
                                        (CASE WHEN E.produccion IS NULL THEN '' ELSE ' FP: '+E.produccion  END) + ' ' +
                                        (CASE WHEN E.fvencimiento IS NULL THEN '' ELSE ' FV: '+E.fvencimiento  END)+ ' ' +
                                        (CASE WHEN E.fingresoaccion IS NULL THEN '' ELSE ' FI: '+CAST(E.fingresoaccion AS VARCHAR(10)) END)+ ' ' +
                                        (CASE WHEN E.dlotemuestra IS NULL THEN '' ELSE ' LT: '+E.dlotemuestra END)
                                    ELSE ' / ' + TRIM(E.dlote) END ) AS 'DPRESENTACION',
                        E.dtemperatura
                from pordenserviciotrabajo A 
                    join presultado D on A.cinternocotizacion = D.cinternocotizacion and A.nversioncotizacion = D.nversioncotizacion and A.cinternoordenservicio = D.cinternoordenservicio
                    join precepcionmuestra E on D.cinternocotizacion = E.cinternocotizacion and D.nversioncotizacion = E.nversioncotizacion and D.cmuestra = E.cmuestra
                where A.cinternoordenservicio = ".$idot."
                    AND D.nviausado = 1 ;";
        $query  = $this->db->query($sql);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}		
    }

    public function getpdfdatosotensayo($idot) { // Listar Ensayos	
        $sql = "select A.CMUESTRA, B.CENSAYOFS, B.DENSAYO, B.DNORMA, B.SACNOAC,
                        (select count(*) from presultado x where x.cinternoordenservicio = A.cinternoordenservicio and x.cmuestra = A.cmuestra and x.censayo = A.censayo) as 'CANTIDAD'
                from PRESULTADO A
                    join MENSAYO B on A.CENSAYO = B.CENSAYO
                where A.NVIAUSADO = 1
                AND A.CINTERNOORDENSERVICIO =  ".$idot.";";
        $query  = $this->db->query($sql);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}		
    }

    public function getpdfdatosotblancov($idcoti) { // Listar Ensayos	
        $sql = "select bk, lote, cinternocotizacion  
                from plabblancoviajero  
                where cinternocotizacion = '".$idcoti."';";
        $query  = $this->db->query($sql);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}		
    }    

    public function getetiquetasmuestras($cinternoordenservicio) { // Listar Ensayos	
        $sql = "select a.CINTERNOORDENSERVICIO, b.NORDENTRABAJO as 'NORDENTRABAJO', a.CMUESTRA as 'CMUESTRA', 1 as 'COPIA', '' as 'SPACE' 
                from PRECEPCIONMUESTRA a join PORDENSERVICIOTRABAJO b on b.CINTERNOORDENSERVICIO = a.CINTERNOORDENSERVICIO 
                where a.CINTERNOORDENSERVICIO = ".$cinternoordenservicio.";";
        $query  = $this->db->query($sql);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}		
    }
    
    public function setgenerarconst($parametros) { //
        $this->db->trans_begin();

        $procedure = "call usp_lab_coti_setgenerarconst(?,?,?,?,?);";
        $query = $this->db->query($procedure,$parametros);

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
        }
        else
        {
            $this->db->trans_commit();
            return $query->result(); 
        }  
    }

    public function getpdfdatosconst($cinternoordenservicio) { // Listar Ensayos	
        $sql = "select a.fingreso, a.hingreso, a.nro_constancia, c.dcotizacion, d.drazonsocial as 'nombcliente', (e.dnombre+' '+isnull(e.dapepat,'')+' '+isnull(e.dapemat,'')) as 'nombcontacto', e.dmail, e.dtelefono
                from PCONSTRECEPCIONLAB a
                    join PORDENSERVICIOTRABAJO b on b.CINTERNOORDENSERVICIO = a.CINTERNOORDENSERVICIO
                    join PCOTIZACIONLABORATORIO c on c.CINTERNOCOTIZACION = b.CINTERNOCOTIZACION
                    join MCLIENTE d on d.ccliente = c.ccliente
                    left join MCONTACTO e on e.ccontacto = c.ccontacto
                where a.CINTERNOORDENSERVICIO = ".$cinternoordenservicio.";";
        $query  = $this->db->query($sql);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}		
    }

    public function getpdfdetalleconst($cinternoordenservicio) { // Listar Ensayos	
        $sql = "select b.drealproducto, b.dpresentacion, b.dobservacionesconst, b.dprecinto, b.dcantidad
                from PCONSTRECEPCIONLAB a
                    join PRECEPCIONMUESTRA b on b.CINTERNOORDENSERVICIO = a.CINTERNOORDENSERVICIO
                where a.CINTERNOORDENSERVICIO = ".$cinternoordenservicio.";";
        $query  = $this->db->query($sql);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}		
    }

    public function getlistblancoviajero($cinternoordenservicio) { // Listar Ensayos	
        $sql = "select a.CINTERNOCOTIZACION, a.IDBLANCOVIAJERO, a.BK, a.LOTE, a.RESULTADO, a.CINTERNOORDENSERVICIO, '' as 'BLANCO'
                from plabblancoviajero a
                where a.CINTERNOORDENSERVICIO = ".$cinternoordenservicio.";";
        $query  = $this->db->query($sql);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}		
    }

    public function setblancoviajero($parametros) {  // Registrar evaluacion PT
        $this->db->trans_begin();

        $procedure = "call usp_lab_coti_setblancoviajero(?,?,?,?,?);";
        $query = $this->db->query($procedure,$parametros);

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
        }
        else
        {
            $this->db->trans_commit();
            return $query->result(); 
        }   
    } 

	public function delblancoviajero($idblancoviajero) { //Eliminar Registro	
        $this->db->trans_begin();
        $this->db->delete('plabblancoviajero', array('idblancoviajero' => $idblancoviajero));
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
        }else{
            $this->db->trans_commit();
            return true; 
        } 
	}
}
?>