<?php if(!defined('BASEPATH')) exit('Tidak Diperkenankan mengakses langsung'); 
/* Class  Model : shippers
 * di Buat oleh Diar PHP Generator*/

  class Modelshippers extends CI_Model {
  function __construct()
 {
    parent::__construct();
 }


    
function getArrayListshippers(){ /* spertinya perlu lock table*/ 
 $xBuffResul = array(); 
 $xStr =  "SELECT ".
      "idx".",name".
",shipper_price".
",created_at".
",updated_at".

" FROM shippers   order by idx ASC "; 
 $query = $this->db->query($xStr); 
 foreach ($query->result() as $row) 
 { 
   $xBuffResul[$row->idx] = $row->idx; 
   } 
return $xBuffResul;
}
    
function getListshippers($xAwal,$xLimit,$xSearch=''){
if(!empty($xSearch)){ 
     $xSearch = "Where idx like '%".$xSearch."%'" ;
 }   
 $xStr =   "SELECT ".
      "idx".
      ",name".
",shipper_price".
",created_at".
",updated_at".
" FROM shippers $xSearch order by idx DESC limit ".$xAwal.",".$xLimit;  
 $query = $this->db->query($xStr);
 return $query ;
}

 
function getDetailshippers($xidx){
 $xStr =   "SELECT ".
      "idx".
   ",name".
",shipper_price".
",created_at".
",updated_at".

" FROM shippers  WHERE idx = '".$xidx."'";

 $query = $this->db->query($xStr);
$row = $query->row();
 return $row;
}

  
function getLastIndexshippers(){ /* spertinya perlu lock table*/ 
 $xStr =   "SELECT ".
      "idx".
      ",name".
",shipper_price".
",created_at".
",updated_at".

" FROM shippers order by idx DESC limit 1 ";
 $query = $this->db->query($xStr);
$row = $query->row();
 return $row;
}


  
 Function setInsertshippers($xidx,$xname,$xshipper_price,$xcreated_at,$xupdated_at)
{
  $xStr =  " INSERT INTO shippers( ".
              "idx".
              ",name".
",shipper_price".
",created_at".
",updated_at".
") VALUES('".$xidx."','".$xname."','".$xshipper_price."','".$xcreated_at."','".$xupdated_at."')";
$query = $this->db->query($xStr);
 return $xidx;
}

Function setUpdateshippers($xidx,$xname,$xshipper_price,$xcreated_at,$xupdated_at)
{
  $xStr =  " UPDATE shippers SET ".
             "idx='".$xidx."'".
              ",name='".$xname."'".
 ",shipper_price='".$xshipper_price."'".
 ",created_at='".$xcreated_at."'".
 ",updated_at='".$xupdated_at."'".
 " WHERE idx = '".$xidx."'";
 $query = $this->db->query($xStr);
 return $xidx;
}

function setDeleteshippers($xidx)
{
 $xStr =  " DELETE FROM shippers WHERE shippers.idx = '".$xidx."'";

 $query = $this->db->query($xStr);
 $this->setInsertLogDeleteshippers($xidx);
}

function setInsertLogDeleteshippers($xidx)
{
 $xidpegawai = $this->session->userdata('idpegawai');    $xStr="insert into logdelrecord(idxhapus,nmtable,tgllog,ideksekusi) values($xidx,'shippers',now(),$xidpegawai)"; 
    $query = $this->db->query($xStr);
}

}