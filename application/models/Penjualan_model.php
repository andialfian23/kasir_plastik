<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan_model extends CI_Model{

    var $query = "SELECT * FROM nota";
                    
    public function get_datatables($column_order,$xBegin,$xEnd)
    {
        $column_search = $column_order;
        
        $this->db->select("*");
        $this->db->from("(".$this->query.") as penjualan");
        $this->db->where('tgl_keluar >=',$xBegin.' 00:00:00');
        $this->db->where('tgl_keluar <=',$xEnd.' 23:59:59');
        
        $i = 0;
        foreach ($column_search as $item) 
        {
            if ($_POST['search']['value']) 
            {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        
        if (isset($_POST['order'])) {
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('nama_barang','ASC');
        }
        
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        } 

        $query = $this->db->get();
        if ($query) {
            return $query;
        }else{
            return false;
        }
    }

    public function total_entri($xBegin,$xEnd)
    {
        $this->db->select("*");
        $this->db->from("(".$this->query.") as s");
        $this->db->where('tgl_keluar >=',$xBegin);
        $this->db->where('tgl_keluar <=',$xEnd);
        
        return $this->db->count_all_results();
    }

    public function total($jenis){
        $qry1 = "SELECT CASE WHEN sum(total) IS NULL THEN 0 ELSE sum(total) END as total FROM nota ";
        $ayna = date('Y-m-d');
        if($jenis == 'Tahun'){
            $tgl1 = date('Y');
            $query = $qry1." WHERE tgl_keluar >= '$tgl1-01-01 00:00:00' AND tgl_keluar <= '$ayna 23:59:59'";
        }
        else if($jenis=='Bulan'){
            $tgl1 = ('Y-m');
            $query = $qry1." WHERE tgl_keluar >= '$tgl1-01 00:00:00' AND tgl_keluar <= '$ayna 23:59:59'";
        }
        
        else if($jenis=='Hari'){
            $query = $qry1." WHERE tgl_keluar >= '$ayna 00:00:00' AND tgl_keluar <= '$ayna 23:59:59'";
        }else{
            $query = $qry1;
        }
        
        return $this->db->query($query)->row_array()['total'];
    }
}

?>