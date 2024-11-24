<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->model('Stok_model','stok');
        if(!$_SESSION['username']){
            redirect('Auth');
        }
    }
    
	public function index()
	{
        $data['konten'] = 'dashboard/home';
        $data['template_js'] = [
            'datatables/jquery.dataTables.min.js',
            'datatables-bs4/js/dataTables.bootstrap4.min.js',
            'datatables-responsive/js/dataTables.responsive.min.js',
            'datatables-responsive/js/responsive.bootstrap4.min.js',
            'datatables-buttons/js/dataTables.buttons.min.js',
        ];
        $data['custom_js'] = 'home.js';
        $this->load->view('index',$data);
    }

    public function stok(){
        $data = array();
        $column_order = array('nama_barang', 'harga_jual', 'stok');
        $query = $this->stok->get_datatables($column_order);
        foreach ($query->result() as $key) {
            $row = array();
            $row['id_barang'] = $key->id_barang;
            $row['nama_barang'] = $key->nama_barang;
            $row['harga_jual'] = $key->harga_jual;
            $row['stok'] = $key->stok;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsFiltered" => $query->num_rows(),
            "recordsTotal" => $this->stok->total_entri(),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function insert(){
        $status = 0;
        $id_nota = date('YmdHis');
        $values1 = [
            'id_nota' => $id_nota,
            'tgl_keluar' => date('Y-m-d H:i:s'),
            'nama_pembeli' => $this->input->post('nama_pembeli',TRUE),
            'total' => intval($this->input->post('total',TRUE)),
            'bayar' => intval($this->input->post('bayar',TRUE)),
            'kembalian' => intval($this->input->post('kembalian',TRUE)),
            'username' => $_SESSION['username'],
        ];
        $insert1 = $this->db->insert('nota',$values1);

        if($insert1){
            foreach($this->input->post('arr_barang',TRUE) as $key){ 
                $harga = intval($key['harga']);
                $qty = intval($key['qty']);
                $values2 = [
                    'id_nota' => $id_nota,
                    'id_barang' => intval($key['id_barang']),
                    'harga_jual' => $harga,
                    'jml_keluar' => $qty,
                    'total_harga' => $harga*$qty,
                ];
                $insert2 = $this->db->insert('pengeluaran',$values2);
                if($insert2){
                    $status =1;
                }else{
                    $status=0;
                    break;
                }
            }
        }

        echo json_encode([
            'status'=>$status,
            'data1'=>$values1,
            'data2'=>$values2,
            'id_nota'=>$id_nota
        ]);
    }
}