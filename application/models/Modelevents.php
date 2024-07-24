<?php if (!defined('BASEPATH')) exit('Tidak Diperkenankan mengakses langsung');
/* Class  Model : events
 * di Buat oleh Diar PHP Generator*/

class Modelevents extends CI_Model
{
   function __construct()
   {
      parent::__construct();
   }

   private $default_query = "select
	idx,
	name,
	long_name,
	is_active,
	descriptions,
	about_event,
	about1_event,
	about2_event,
	about3_event,
	poster_image,
	contact_phone,
	contact_email,
   agent_open_date,
   agent_close_date,
   agent_open_time,
   agent_close_time,
   agent_address,
   agent_gmap
from
	events";

   function getArrayListevents()
   { /* spertinya perlu lock table*/
      $xBuffResul = array();
      $xStr = $this->default_query ." order by idx ASC ";
      $query = $this->db->query($xStr);
      foreach ($query->result() as $row) {
         $xBuffResul[$row->idx] = $row->name;
      }
      return $xBuffResul;
   }

   function getListevents($xAwal, $xLimit, $xSearch = '')
   {
      if (!empty($xSearch)) {
         $xSearch = "Where name like '%" . $xSearch . "%' or long_name like '%" . $xSearch . "%' or descriptions like '%" . $xSearch . "%'";
      }
      $xStr = $this->default_query ." $xSearch order by idx DESC limit " . $xAwal . "," . $xLimit;
      $query = $this->db->query($xStr);
      return $query;
   }


   function getDetailevents($xidx)
   {
      $xStr = $this->default_query ." WHERE idx = '" . $xidx . "'";

      $query = $this->db->query($xStr);
      $row = $query->row();
      return $row;
   }


   function getLastIndexevents()
   { /* spertinya perlu lock table*/
      $xStr = $this->default_query ." order by idx DESC limit 1 ";
      $query = $this->db->query($xStr);
      $row = $query->row();
      return $row;
   }



   function setInsertevents($xidx, $xname, $xlong_name, $xis_active, $xdescriptions, $xabout_event, $xabout1_event, $xabout2_event, $xabout3_event, $xposter_image, $xcontact_phone, $xcontact_email,   
   $xagent_open_date,
   $xagent_close_date,
   $xagent_open_time,
   $xagent_close_time,
   $xagent_address,
   $xagent_gmap)
   {
      if ($xis_active==1) {
         $toinactivestr = "UPDATE event_org.events SET is_active=0 WHERE is_active=1;";
         $this->db->query($toinactivestr);
      }
      $xStr =  " INSERT INTO events( " .
         "idx" .
         ",name" .
         ",long_name" .
         ",is_active" .
         ",descriptions" .
         ",about_event" .
         ",about1_event" .
         ",about2_event" .
         ",about3_event" .
         ",poster_image" .
         ",contact_phone" .
         ",contact_email" .
         ",agent_open_date" .
         ",agent_close_date" .
         ",agent_open_time" .
         ",agent_close_time" .
         ",agent_address" .
         ",agent_gmap" .
         ",created_at" .
         ") VALUES('" . $xidx . "','" . $xname . "','" . $xlong_name . "','" . $xis_active . "','" . $xdescriptions . "','" . $xabout_event . "','" . $xabout1_event . "','" . $xabout2_event . "','" . $xabout3_event . "','" . $xposter_image . ",'" . $xcontact_phone . ",'" . $xcontact_email . "'
   ,'" . $xagent_open_date . "'
   ,'" . $xagent_close_date . "'
   ,'" . $xagent_open_time . "'
   ,'" . $xagent_close_time . "'
   ,'" . $xagent_address . "'
   ,'" . $xagent_gmap . "',NOW())";
      $query = $this->db->query($xStr);
      return $xidx;
   }

   function setUpdateevents($xidx, $xname, $xlong_name, $xis_active, $xdescriptions, $xabout_event, $xabout1_event, $xabout2_event, $xabout3_event, $xposter_image, $xcontact_phone, $xcontact_email,
   $xagent_open_date,
   $xagent_close_date,
   $xagent_open_time,
   $xagent_close_time,
   $xagent_address,
   $xagent_gmap)
   {
      if ($xis_active==1) {
         $toinactivestr = "UPDATE event_org.events SET is_active=0 WHERE is_active=1;";
         $this->db->query($toinactivestr);
      }
      $xStr =  " UPDATE events SET " .
         "idx='" . $xidx . "'" .
         ",name='" . $xname . "'" .
         ",long_name='" . $xlong_name . "'" .
         ",is_active='" . $xis_active . "'" .
         ",descriptions='" . $xdescriptions . "'" .
         ",about_event='" . $xabout_event . "'" .
         ",about1_event='" . $xabout1_event . "'" .
         ",about2_event='" . $xabout2_event . "'" .
         ",about3_event='" . $xabout3_event . "'" .
         ",poster_image='" . $xposter_image . "'" .
         ",contact_phone='" . $xcontact_phone . "'" .
         ",contact_email='" . $xcontact_email . "'" .
         ",agent_open_date='" . $xagent_open_date . "'" .
         ",agent_close_date='" . $xagent_close_date . "'" .
         ",agent_open_time='" . $xagent_open_time . "'" .
         ",agent_close_time='" . $xagent_close_time . "'" .
         ",agent_address='" . $xagent_address . "'" .
         ",agent_gmap='" . $xagent_gmap . "'" .
         ",updated_at=NOW()" .
         " WHERE idx = '" . $xidx . "'";
      $query = $this->db->query($xStr);
      return $xidx;
   }

   function setDeleteevents($xidx)
   {
      $xStr =  " DELETE FROM events WHERE events.idx = '" . $xidx . "'";

      $query = $this->db->query($xStr);
      $this->setInsertLogDeleteevents($xidx);
   }

   function setInsertLogDeleteevents($xidx)
   {
      $xidpegawai = $this->session->userdata('idpegawai');
      $xStr = "insert into logdelrecord(idxhapus,nmtable,tgllog,ideksekusi) values($xidx,'events',now(),$xidpegawai)";
      $query = $this->db->query($xStr);
   }

   function getActiveEvent() {
      $xStr = $this->default_query ." where is_active = 1 limit 1;";
      $query = $this->db->query($xStr);
      $row = $query->row();
      return $row;
   }
}
