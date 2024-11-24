<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Stok_model extends CI_Model{

    var $query = "  SELECT *, (masuk-keluar) as stok FROM (
                    SELECT b.id_barang, nama_barang, harga_barang, b.harga_jual, 
                        CASE WHEN sum(jml_pemasukan) IS NULL THEN 0 ELSE sum(jml_pemasukan) END as masuk,
                        CASE WHEN (SELECT id_barang FROM pengeluaran WHERE id_barang=b.id_barang GROUP BY id_barang) IS NULL 
                            THEN 0 
                        ELSE 
                            (SELECT sum(jml_keluar) FROM pengeluaran WHERE id_barang=b.id_barang GROUP BY id_barang)
                        END as keluar
                    FROM barang b
                    LEFT JOIN pemasukan pm ON b.id_barang=pm.id_barang 
                    GROUP BY b.id_barang) as s";
                    
    public function get_datatables($column_order)
    {
        $column_search = $column_order;
        
        $this->db->select("*");
        $this->db->from("(".$this->query.") as saldo_akhir");
        $this->db->where(['stok >'=>0]);
 
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

    public function stok_barang(){
        return $this->db->query("SELECT 
            b.id_barang, nama_barang, harga_barang, b.harga_jual, 
            CASE WHEN sum(jml_pemasukan) IS NULL THEN 0 ELSE sum(jml_pemasukan) END as masuk,
            CASE WHEN (SELECT id_barang FROM pengeluaran WHERE id_barang=b.id_barang GROUP BY id_barang) IS NULL 
                THEN 0 ELSE 
                (SELECT sum(jml_keluar) FROM pengeluaran WHERE id_barang=b.id_barang GROUP BY id_barang)
                END as keluar
        FROM  barang b
        LEFT JOIN pemasukan pm ON b.id_barang=pm.id_barang 
        GROUP BY b.id_barang");
    }

}

?>