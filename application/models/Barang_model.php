<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang_model extends CI_Model{

    var $query = "SELECT 
            a.id_barang, nama_barang, harga_barang, harga_jual, 
            IFNULL(jml_pemasukan,0) AS jml_pemasukan, 
            IFNULL(jml_pengeluaran,0) AS jml_pengeluaran,
            IFNULL(jml_pemasukan,0) - IFNULL(jml_pengeluaran,0)  AS jml_stok
            FROM barang AS a
            LEFT JOIN (SELECT sum(jml_pemasukan) AS jml_pemasukan,id_barang FROM pemasukan GROUP BY id_barang) AS pm ON pm.id_barang=a.id_barang
            LEFT JOIN (SELECT sum(jml_keluar) AS jml_pengeluaran,id_barang FROM pengeluaran GROUP BY id_barang) AS pk ON pk.id_barang=a.id_barang
            ";

    public function get_datatables($column_order)
    {
        $column_search = $column_order;
        
        $this->db->select("*");
        $this->db->from("(".$this->query.") as stok_barang");
        // $this->db->where(['jml_stok >'=>0]);
 
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

    public function total_entri()
    {
        $this->db->select("*");
        $this->db->from("(".$this->query.") as s");
        
        return $this->db->count_all_results();
    }

    public function get_pemasukan($id_barang){
        return $this->db->query("SELECT pm.harga_beli,pm.harga_jual,pm.jml_pemasukan,pm.tgl_masuk,b.nama_barang,id_pemasukan 
                FROM pemasukan as pm
                INNER JOIN barang as b ON pm.id_barang=b.id_barang
                WHERE pm.id_barang={$id_barang}
                ORDER BY pm.tgl_masuk ASC");
    }    

}