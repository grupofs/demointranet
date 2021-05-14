<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mconshallazgocalif extends CI_Model {
	function __construct() {
		parent:: __construct();	
		$this->load->library('session');
    }
    
   /** CONTROL DE PROVEEDORES **/ 
    
    public function getcboprovxclie($parametros) { // Visualizar Proveedor por cliente en CBO	
        
        $procedure = "call usp_at_ctrlprov_getcboprovxclie(?)";
		$query = $this->db-> query($procedure,$parametros);
        
        if ($query->num_rows() > 0) {

            $listas = '<option value="" selected="selected">::Elegir</option>';
            
            foreach ($query->result() as $row)
            {
                $listas .= '<option value="'.$row->IDPROV.'">'.$row->DESCRIPPROV.'</option>';  
            }
               return $listas;
        }{
            return false;
        }	
    }
    public function getcboareaclie($ccliente) { // Listar Ensayos	
        $sql = "select careacliente, dareacliente from mareacliente where ccliente  = '".$ccliente."' and ccompania = '1';";
        $query  = $this->db->query($sql);
        
        if ($query->num_rows() > 0) {

            $listas = '<option value="" selected="selected">::Elegir</option>';
            
            foreach ($query->result() as $row)
            {
                $listas .= '<option value="'.$row->careacliente.'">'.$row->dareacliente.'</option>';  
            }
               return $listas;
        }{
            return false;
        }		
    }
    public function getconshallazgocalif($parametros)
    {
        $procedure = "call usp_at_ctrlprov_conshallazgocalif(?,?,?,?,?,?,?,?)";
        $query = $this->db-> query($procedure,$parametros);

        if ($query->num_rows() > 0) { 
            return $query->result();
        }{
            return False;
        }		   
    }
    public function getdethallazgocalif($parametros)
    {
        $procedure = "call usp_at_ctrlprov_getdethallazgocalif(?,?,?,?,?,?,?,?)";
        $query = $this->db-> query($procedure,$parametros);

        if ($query->num_rows() > 0) { 
            return $query->result();
        }{
            return False;
        }		   
    }
    public function getresumeninspeccion($cauditoriainspeccion,$fservicio) { // Listar Ensayos	
        $sql = "select C.DRAZONSOCIAL AS 'EMPRESA', G.DDETALLECRITERIORESULTADO AS 'CALIFICACION', B.PRESULTADOCHECKLIST AS 'PUNTAJE', B.DINFORMEFINAL AS 'NROINFORME', L.DLINEACLIENTEE AS 'LINEA', B.DADICIONALLICENCIA AS 'OBSERVACION', 
                    (CASE B.SLICENCIAFUNCIONAMIENTO WHEN 'S' THEN 'SI' WHEN 'N' THEN 'NO' ELSE 'EN TRAMITE' END) AS 'ESTADOLICENCIA', B.DLICENCIAFUNCIONAMIENTO AS 'NROLICENCIA',
                    (SELECT TU.DDEPARTAMENTO + ' - ' + TU.DPROVINCIA + ' - ' + TU.DDISTRITO FROM TUBIGEO TU WHERE TU.CUBIGEO = B.CUBIGEOMUNICIPALIDAD) AS 'MUNICIPALIDAD',
                    IFNULL(A.CESTABLECIMIENTOPROV,(SELECT MEST.DDIRECCION+' ('+T.ddepartamento+'-'+T.dprovincia+'-'+T.DDISTRITO+')' FROM MESTABLECIMIENTOCLIENTE MEST JOIN TUBIGEO T ON T.CUBIGEO = MEST.CUBIGEO WHERE MEST.CESTABLECIMIENTO = A.CESTABLECIMIENTOMAQUILA),(SELECT MEST.DDIRECCION+' ('+T.ddepartamento+'-'+T.dprovincia+'-'+T.DDISTRITO+')' FROM MESTABLECIMIENTOCLIENTE MEST JOIN TUBIGEO T ON T.CUBIGEO = MEST.CUBIGEO WHERE MEST.CESTABLECIMIENTO = A.CESTABLECIMIENTOPROV)) as 'DIRINSPE'
                from PCAUDITORIAINSPECCION A
                    JOIN PDAUDITORIAINSPECCION B ON B.CAUDITORIAINSPECCION = A.CAUDITORIAINSPECCION
                    JOIN MCLIENTE C ON C.CCLIENTE = A.CPROVEEDORCLIENTE
                    JOIN MDETALLECRITERIORESULTADO G ON B.CCRITERIORESULTADO = G.CCRITERIORESULTADO AND B.CDETALLECRITERIORESULTADO = G.CDETALLECRITERIORESULTADO
                    LEFT OUTER JOIN MLINEAPROCESOCLIENTE L ON A.CLINEAPROCESOCLIENTE = L.CLINEAPROCESOCLIENTE  
                where B.CAUDITORIAINSPECCION = '".$cauditoriainspeccion."'
                    AND B.FSERVICIO = '".$fservicio."';";
        $query  = $this->db->query($sql);
        
        if ($query->num_rows() > 0) {
            return $query->result();
        }{
            return false;
        }		
    }
    public function getdetresumen($cauditoriainspeccion,$fservicio) { // Listar Ensayos	
        $sql = "select replace(a.dinfoadicional,'\r\n','<br>') as 'dinfoadicional', b.dregistro  
                from pinformacionadicional a
                    join ttabla b on a.zcinfoadicional = b.ctipo  
                where a.CAUDITORIAINSPECCION = '".$cauditoriainspeccion."'
                    AND a.FSERVICIO = '".$fservicio."';";
        $query  = $this->db->query($sql);
        
        if ($query->num_rows() > 0) {
            return $query->result();
        }{
            return false;
        }		
    }
    public function getreqexcluye($cauditoriainspeccion,$fservicio) { // Listar Ensayos	
        $sql = "select isnull(P.DHALLAZGOTEXT,'') as 'DHALLAZGOTEXT', isnull((M.DNUMERADOR+' : '+M.DREQUISITO),'') as 'TITULO'
                from MREQUISITOCHECKLIST M, PVALORCHECKLIST P
                where P.CCHECKLIST = M.CCHECKLIST 
                    and P.CREQUISITOCHECKLIST = M.CREQUISITOCHECKLIST 
                    and  M.SEXCLUYENTE ='S' AND P.NVALORREQUISITO = 0 
                    and P.CAUDITORIAINSPECCION = '".$cauditoriainspeccion."'
                    and P.FSERVICIO = '".$fservicio."'	
                    and P.CDETALLEVALORREQUISITO NOT IN ('004','005')
                order by DORDENLISTA;";
        $query  = $this->db->query($sql);
        
        if ($query->num_rows() > 0) {
            return $query->result();
        }{
            return false;
        }		
    }
    public function getproducto($cauditoriainspeccion,$fservicio) { // Listar Ensayos	
        $sql = "select dproducto, dpeligrocliente, dpeligroproveedor, dpeligroinspeccion, dobservacion
                from ppeligro  
                where cauditoriainspeccion = '".$cauditoriainspeccion."' 
                    and fservicio = '".$fservicio."';";
        $query  = $this->db->query($sql);
        
        if ($query->num_rows() > 0) {
            return $query->result();
        }{
            return false;
        }		
    }
    public function getcriterio($cauditoriainspeccion,$fservicio) { // Listar Ensayos	
        $sql = "select A.DDETALLEVALOR, A.CDETALLEVALOR,
                       (select COUNT(*)  
                        from PDAUDITORIAINSPECCION A,             
                            MDETALLEVALOR E,   
                            PVALORCHECKLIST F
                        where A.CAUDITORIAINSPECCION = F.CAUDITORIAINSPECCION 
                            and A.FSERVICIO = F.FSERVICIO
                            and A.CCHECKLIST = F.CCHECKLIST
                            and A.CVALORNOCONFORMIDAD = F.CVALORNOCONFORMIDAD 
                            and F.CVALORNOCONFORMIDAD = E.CVALOR  
                            and F.CDETALLEVALORNOCONFORMIDAD = E.CDETALLEVALOR
                            and A.ZCTIPOESTADOSERVICIO = '032'
                            and A.CAUDITORIAINSPECCION = '".$cauditoriainspeccion."' and A.FSERVICIO = '".$fservicio."' and E.CDETALLEVALOR = A.CDETALLEVALOR) AS 'NROHALLAZGOS'
                from MDETALLEVALOR A 
                where A.CVALOR IN (select CVALORNOCONFORMIDAD from PDAUDITORIAINSPECCION where CAUDITORIAINSPECCION = '".$cauditoriainspeccion."' and FSERVICIO = '".$fservicio."')
                    and NROHALLAZGOS > 0
                order by A.CDETALLEVALOR;";
        $query  = $this->db->query($sql);
        
        if ($query->num_rows() > 0) {
            return $query->result();
        }{
            return false;
        }		
    }

}
?>