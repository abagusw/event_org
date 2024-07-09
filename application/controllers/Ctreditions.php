<?php if(!defined('BASEPATH')) exit('Tidak Diperkenankan mengakses langsung'); 
    /* Class  Control : editions   *  By Diar */

      class Ctreditions extends CI_Controller { 
     function __construct()
     {
        parent::__construct();
     }

    
function index($xAwal=0,$xSearch=''){
       $idpegawai = $this->session->userdata('idpegawai');
        if (empty($idpegawai)) {
           redirect(site_url(), '');
       }
       if($xAwal <= -1){
           $xAwal = 0;
        }    
        $this->session->set_userdata('awal',$xAwal);
        $this->session->set_userdata('limit', 100); 
        $this->createformeditions('0',$xAwal);
 } 
    
function createformeditions($xidx, $xAwal = 0, $xSearch = '') {
    $this->load->helper('form');
    $this->load->helper('html');
    $this->load->model('modelgetmenu');
    $xAddJs = link_tag('resource/admin/vendor/toaster/toastr.css') . "\n" .
                '<script language="javascript" type="text/javascript" src="' . base_url() . 'resource/admin/vendor/toaster/toastr.min.js"></script>' . "\n" .
	'<script language="javascript" type="text/javascript" src="' . base_url() . 'resource/js/common/fileupload/jquery.ui.widget.js"></script>' . "\n" .
     '<script language="javascript" type="text/javascript" src="' . base_url() . 'resource/ajax/ajaxeditions.js"></script>';
    echo $this->modelgetmenu->SetViewAdmin($this->setDetailFormeditions($xidx), '', '', $xAddJs,'','editions' ); 

}
 
function setDetailFormeditions($xidx){
        $this->load->helper('form'); 
          $xBufResult = '';
           $xBufResult = '<div id="stylized" class="myform">'.form_open_multipart('ctreditions/inserttable',array('id'=>'form','name'=>'form'));
      $this->load->helper('common');
      	$xBufResult .= '<div id="form">';
        $xBufResult .= '<input type="hidden" name="edidx" id="edidx" value="0" />'; 
        
$xBufResult .= setForm('event_id','event_id',form_input_(getArrayObj('edevent_id','','200'),'',' placeholder="event_id" ')).'<div class="spacer"></div>';

$xBufResult .= setForm('name','name',form_input_(getArrayObj('edname','','200'),'',' placeholder="name" ')).'<div class="spacer"></div>';

$xBufResult .= setForm('started_at','started_at',form_input_(getArrayObj('edstarted_at','','200'),'',' placeholder="started_at" ')).'<div class="spacer"></div>';

$xBufResult .= setForm('ended_at','ended_at',form_input_(getArrayObj('edended_at','','200'),'',' placeholder="ended_at" ')).'<div class="spacer"></div>';

$xBufResult .= setForm('venue_address','venue_address',form_input_(getArrayObj('edvenue_address','','200'),'',' placeholder="venue_address" ')).'<div class="spacer"></div>';

$xBufResult .= setForm('venue_city','venue_city',form_input_(getArrayObj('edvenue_city','','200'),'',' placeholder="venue_city" ')).'<div class="spacer"></div>';

$xBufResult .= setForm('descriptions','descriptions',form_input_(getArrayObj('eddescriptions','','200'),'',' placeholder="descriptions" ')).'<div class="spacer"></div>';

$xBufResult .= setForm('quota','quota',form_input_(getArrayObj('edquota','','200'),'',' placeholder="quota" ')).'<div class="spacer"></div>';

$xBufResult .= setForm('coupon_price','coupon_price',form_input_(getArrayObj('edcoupon_price','','200'),'',' placeholder="coupon_price" ')).'<div class="spacer"></div>';

$xBufResult .= setForm('created_at','created_at',form_input_(getArrayObj('edcreated_at','','200'),'',' placeholder="created_at" ')).'<div class="spacer"></div>';

$xBufResult .= setForm('updated_at','updated_at',form_input_(getArrayObj('edupdated_at','','200'),'',' placeholder="updated_at" ')).'<div class="spacer"></div>';

$xBufResult .= '<div class="garis"></div></div></div>'.form_button('btNew','new','onclick="doCleareditions();"').form_button('btSimpan','Simpan','onclick="dosimpaneditions();"').form_button('btTabel','Tabel','onclick="dosearcheditions(0);"').'<div class="spacer"></div></div><div id="tabledataeditions">'.$this->getlisteditions(0, ''). '</div><div class="spacer"></div>'; 
       return $xBufResult;

  }
  
function getlisteditions($xAwal,$xSearch){ 
         $xLimit = $this->session->userdata('limit');
        $this->load->helper('form');
        $this->load->helper('common');
         $xbufResult1 =tbaddrow(         tbaddcellhead('idx','','data-field="idx" data-sortable="true" width=10%').
tbaddcellhead('event_id','','data-field="event_id" data-sortable="true" width=10%').
tbaddcellhead('name','','data-field="name" data-sortable="true" width=10%').
tbaddcellhead('started_at','','data-field="started_at" data-sortable="true" width=10%').
tbaddcellhead('ended_at','','data-field="ended_at" data-sortable="true" width=10%').
tbaddcellhead('venue_address','','data-field="venue_address" data-sortable="true" width=10%').
tbaddcellhead('venue_city','','data-field="venue_city" data-sortable="true" width=10%').
tbaddcellhead('descriptions','','data-field="descriptions" data-sortable="true" width=10%').
tbaddcellhead('quota','','data-field="quota" data-sortable="true" width=10%').
tbaddcellhead('coupon_price','','data-field="coupon_price" data-sortable="true" width=10%').
tbaddcellhead('created_at','','data-field="created_at" data-sortable="true" width=10%').
tbaddcellhead('updated_at','','data-field="updated_at" data-sortable="true" width=10%').

            tbaddcellhead('Action','padding:5px;width:10%;text-align:center;','col-md-2'),'',TRUE);
         $this->load->model('modeleditions');
         $xQuery = $this->modeleditions->getListeditions($xAwal,$xLimit,$xSearch);
          $xbufResult ='<thead>'.$xbufResult1.'</thead>';
        $xbufResult .='<tbody>';
              foreach ($xQuery->result() as $row)
            { 
                  $xButtonEdit = '<i class="fas fa-edit btn" aria-hidden="true"  onclick = "doediteditions(\''.$row->idx.'\');" ></i>';
            $xButtonHapus = '<i class="fas fa-trash-alt btn" aria-hidden="true" onclick = "dohapuseditions(\''.$row->idx.'\');"></i>';
            $xbufResult .= tbaddrow(         tbaddcell($row->idx).
tbaddcell($row->event_id).
tbaddcell($row->name).
tbaddcell($row->started_at).
tbaddcell($row->ended_at).
tbaddcell($row->venue_address).
tbaddcell($row->venue_city).
tbaddcell($row->descriptions).
tbaddcell($row->quota).
tbaddcell($row->coupon_price).
tbaddcell($row->created_at).
tbaddcell($row->updated_at).

            tbaddcell($xButtonEdit.$xButtonHapus));
            }
          $xInput      = form_input_(getArrayObj('edSearch','','200')); 
          $xButtonSearch = '<span class="input-group-btn">
                                                <button class="btn btn-default" type="button" onclick = "dosearcheditions(0);"><i class="fa fa-search"></i>
                                                </button>
                                            </span>';
          $xButtonPrev = '<a href="javascript:void(0)" onclick = "dosearcheditions('.($xAwal-$xLimit).');"><i class="fas fa-chevron-circle-left"></i></a>';
        $xButtonNext = '<a href="javascript:void(0)" onclick = "dosearcheditions('.($xAwal-$xLimit).');"><i class="fas fa-chevron-circle-right"></i></a>';
        $xButtonhalaman = '<button id="edHalaman" class="btn btn-default" disabled>'.$xAwal.' to '.$xLimit.'</button>';
        $xbuffoottable = '<div class="foottable row text-lg"><div class="col-md-6">'.setForm('','',$xInput . $xButtonSearch,'','').'</div>'.
                '<div class="col-md-6 text-right">'.$xButtonPrev . $xButtonhalaman . $xButtonNext.'</div></div>';
        
      $xbufResult = tablegrid($xbufResult . '</tbody>','','id="table" data-toggle="table" data-url="" data-query-params="queryParams" data-pagination="true"') . $xbuffoottable;
        $xbufResult .= '<script language="javascript" type="text/javascript" src="' . base_url() . 'resource/admin/vendor/bootstrap-table/bootstrap-table.js"></script>';
        
        return '<div class="tabledata table-responsive"  style="width:100%;left:-12px;">' . $xbufResult . '</div>' .
                '<div id="showmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                    <div   class="modal-content">
                    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="dialogtitle">Title Dialog</h4>
      </div>
      <div id="dialogdata" class="modal-body">Dialog Data</div></div></div></div>';

  }

  
         function editreceditions(){ 
        $xIdEdit  = $_POST['edidx']; 
        $this->load->model('modeleditions');  
         $row = $this->modeleditions->getDetaileditions($xIdEdit); 
        $this->load->helper('json'); 
      $this->json_data['idx'] = $row->idx;
$this->json_data['event_id'] = $row->event_id;
$this->json_data['name'] = $row->name;
$this->json_data['started_at'] = $row->started_at;
$this->json_data['ended_at'] = $row->ended_at;
$this->json_data['venue_address'] = $row->venue_address;
$this->json_data['venue_city'] = $row->venue_city;
$this->json_data['descriptions'] = $row->descriptions;
$this->json_data['quota'] = $row->quota;
$this->json_data['coupon_price'] = $row->coupon_price;
$this->json_data['created_at'] = $row->created_at;
$this->json_data['updated_at'] = $row->updated_at;

            echo json_encode($this->json_data);
   }
function deletetableeditions(){ 
    $edidx = $_POST['edidx']; 
    $this->load->model('modeleditions'); 
    $this->modeleditions->setDeleteeditions($edidx); 
    $this->load->helper('json');
    echo json_encode(null);
  }
function searcheditions(){ 
    $xAwal = $_POST['xAwal']; 
    $xSearch = $_POST['xSearch']; 
    $this->load->helper('json'); 
    $xhalaman=0;
    if($xAwal!=0){
    $xhalaman = @ceil($xAwal/($xAwal-$this->session->userdata('awal', $xAwal)));
    }
    $xlimit = $this->session->userdata('limit');
        $xHal=1;
        if($xAwal <= 0){
              $xHal = 1;
        }else{
            $xHal = ($xhalaman+1);
        }
        if($xhalaman < 0){
              $xHal = (($xhalaman-1)*-1);
        }
        if (($xAwal + 0) == -99) {
            $xAwal = $this->session->userdata('awal', $xAwal);
            $xHal = $this->session->userdata('halaman', $xHal);
        }
        if ($xAwal + 0 <= -1) {
            $xAwal = 0;
            $this->session->set_userdata('awal', $xAwal);
        } else {
            $this->session->set_userdata('awal', $xAwal);
        }
        $this->json_data['tabledataeditions'] = $this->getlisteditions($xAwal, $xSearch);
        $this->json_data['halaman'] = $xAwal.' to '.($xlimit*$xHal);
    echo json_encode($this->json_data); 
  } 

 function  simpaneditions(){ 
        $this->load->helper('json'); 
          if(!empty($_POST['edidx'])) 
        { 
         $xidx =  $_POST['edidx']; 
          } else{ 
         $xidx = '0'; 
         } 
$xevent_id = $_POST['edevent_id'];
$xname = $_POST['edname'];
$xstarted_at = $_POST['edstarted_at'];
$xended_at = $_POST['edended_at'];
$xvenue_address = $_POST['edvenue_address'];
$xvenue_city = $_POST['edvenue_city'];
$xdescriptions = $_POST['eddescriptions'];
$xquota = $_POST['edquota'];
$xcoupon_price = $_POST['edcoupon_price'];
$xcreated_at = $_POST['edcreated_at'];
$xupdated_at = $_POST['edupdated_at'];
          
             $this->load->model('modeleditions'); 
        $xidpegawai = $this->session->userdata('idpegawai'); 
        if(!empty($xidpegawai)){ 
        if($xidx!='0'){   $xStr =  $this->modeleditions->setUpdateeditions($xidx,$xevent_id,$xname,$xstarted_at,$xended_at,$xvenue_address,$xvenue_city,$xdescriptions,$xquota,$xcoupon_price,$xcreated_at,$xupdated_at); 
         } else 
         { 
           $xStr =  $this->modeleditions->setInserteditions($xidx,$xevent_id,$xname,$xstarted_at,$xended_at,$xvenue_address,$xvenue_city,$xdescriptions,$xquota,$xcoupon_price,$xcreated_at,$xupdated_at); 
         }} 
               echo json_encode(null);
    } }