<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->model('Barang_model','barang');

        if(!$_SESSION['username']){
            redirect('Auth');
        }
    }
    
	public function index()
	{
        $data['konten'] = 'barang/index_barang';
        $data['template_js'] = [
            'datatables/jquery.dataTables.min.js',
            'datatables-bs4/js/dataTables.bootstrap4.min.js',
            'datatables-responsive/js/dataTables.responsive.min.js',
            'datatables-responsive/js/responsive.bootstrap4.min.js',
            'datatables-buttons/js/dataTables.buttons.min.js',
            'datatables-buttons/js/buttons.bootstrap4.min.js',
            'pdfmake/pdfmake.min.js',
            'pdfmake/vfs_fonts.js',
            'datatables-buttons/js/buttons.html5.min.js',
            'datatables-buttons/js/buttons.print.min.js',
        ];
        $data['custom_js'] = 'barang.js';
        $this->load->view('index',$data);
    }

    public function show(){
        $data = array();
        $column_order = array('nama_barang', 'harga_barang','harga_jual','pemasukan','pengeluaran', 'stok');
        $query = $this->barang->get_datatables($column_order);
        foreach ($query->result() as $key) {
            $data[] = [
                'id_barang'       => $key->id_barang,
                'nama_barang'     => $key->nama_barang,
                'harga_barang'    => number_format($key->harga_barang),
                'harga_jual'      => number_format($key->harga_jual),
                'pemasukan'       => number_format($key->jml_pemasukan),
                'pengeluaran'     => number_format($key->jml_pengeluaran),
                'stok'            => number_format($key->jml_stok),
            ];
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsFiltered" => $query->num_rows(),
            "recordsTotal" => $this->barang->total_entri(),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function insert(){
        $output = [];
        $status = 0;
        $pesan = 'Data gagal disimpan';
        $values = [
            'nama_barang' => $this->input->post('nama_barang',TRUE),  
            'harga_barang' => $this->input->post('harga_beli',TRUE),  
            'harga_jual' => $this->input->post('harga_jual',TRUE),  
        ];
        $this->db->insert('barang',$values);
        $id_barang = $this->db->insert_id();

        if($id_barang){
            $status = 1;
            $pesan = 'Data Barang Berhasil Disimpan';
            $values2 = [
                'id_barang' => $id_barang,  
                'harga_beli' => $this->input->post('harga_beli',TRUE),  
                'harga_jual' => $this->input->post('harga_jual',TRUE),  
                'jml_pemasukan' => $this->input->post('jml_stok',TRUE),  
                'tgl_masuk' => $this->input->post('tgl_masuk',TRUE),
                'username' => $_SESSION['username']  
            ];
            $this->db->insert('pemasukan',$values2);
        }
        
        $output = [
            'status'  => $status,
            'pesan' => $pesan, 
        ];
        echo json_encode($output);
    }

    public function update(){
        $output = [];
        $status = 0; 
        $pesan = 'Data gagal diubah';
        $set = [
            'nama_barang' => $this->input->post('nama_barang',TRUE),  
            'harga_barang' => $this->input->post('harga_beli',TRUE),  
            'harga_jual' => $this->input->post('harga_jual',TRUE),   
        ];
        $where = ['id_barang'=>$this->input->post('id_barang',TRUE)];
        $update = $this->db->where($where)->update('barang',$set);
        if($update){
            $status=1;
            $pesan='Data berhasil diubah';
        }
        $output = [
            'status'  => $status,
            'pesan' => $pesan, 
        ];
        echo json_encode($output);
    }

    public function delete(){
        $status = 0;
        $pesan = 'Data gagal dihapus';
        $id_barang=$this->input->post('id_barang',TRUE);
        $query=$this->db->delete('barang',['id_barang'=>$id_barang]);
        if($query){
            $status=1;
            $pesan='Data berhasil dihapus';
        }
        $output = [
            'status'  => $status,
            'pesan' => $pesan, 
        ];
        echo json_encode($output);
    }

    public function detail(){
        $output = [];
        $status = 0;
        $data=null;
        $pesan = 'Data gagal dibaca';
        $id_barang = $this->input->post('id_barang',TRUE);
        $query = $this->db->get_where('barang',['id_barang'=>$id_barang]);
        if($query->num_rows() > 0){
            $status=1;
            $pesan='Data berhasil ditemukan';
            $data=$query->row();
        }
        $output = [
            'status'  => $status,
            'pesan' => $pesan, 
            'data'=>$data,
        ];
        echo json_encode($output);
    }
}