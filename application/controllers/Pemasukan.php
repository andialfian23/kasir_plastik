<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemasukan extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('Barang_model','barang');

        if(!$_SESSION['username']){
            redirect('Auth');
        }
    }
    
    public function show(){
        $id_barang = $this->input->post('id_barang',TRUE);
        $data = $nama_barang = null;
        $status = $total_row = 0;
        $query = $this->barang->get_pemasukan($id_barang);
        if($query->num_rows() > 0){
            $total_row = $query->num_rows();
            foreach($query->result() as $key){
                $nama_barang = $key->nama_barang;
                $data .= '<div class="card bg-gradient-primary shadow">
                            <div class="card-body p-1">
                                <div class="timeline mb-0">
                                    <div class="time-label d-flex justify-content-between">
                                        <span class="bg-green">'.$key->tgl_masuk.'</span>
                                        <button type="button" class="ml-auto btn bg-gradient-danger btn-sm btn-del-pm" data-id="'.$key->id_pemasukan.'">Hapus Pemasukan</button>
                                    </div>
                                    <div class="p-0">
                                        <div class="timeline-item">
                                            <div class="timeline-body">
                                                <h6 class="font-weight-bold mb-0">Harga Beli : Rp '.$key->harga_beli.'</h6>
                                                <h6 class="font-weight-bold mb-0">Harga Jual : Rp '.$key->harga_jual.'</h6>
                                                <h6 class="font-weight-bold mb-0">Jumlah : '.$key->jml_pemasukan.'</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
            }
        }
        
        $output = [
            'status' => $status,
            'total_row' => $total_row,
            'data' => $data,
            'nama_barang' => $nama_barang,
        ];
        echo json_encode($output);
    }
    
    public function insert(){
        $status=0;
        $pesan='Stok gagal ditambahkan';

        $set = [
            'harga_barang' => $this->input->post('harga_beli',TRUE),  
            'harga_jual' => $this->input->post('harga_jual',TRUE),   
        ];
        $where = ['id_barang'=>$this->input->post('id_barang',TRUE)];
        $update = $this->db->where($where)->update('barang',$set);

        if($update){
            $values2 = [
                'id_barang' => $this->input->post('id_barang',TRUE),  
                'jml_pemasukan' => $this->input->post('jml_stok',TRUE),  
                'harga_beli' => $this->input->post('harga_beli',TRUE),  
                'harga_jual' => $this->input->post('harga_jual',TRUE),  
                'tgl_masuk' => $this->input->post('tgl_masuk',TRUE),
                'username' => $_SESSION['username']  
            ];
            $insert = $this->db->insert('pemasukan',$values2);
            if($insert){
                $status=1;
                $pesan='Stok berhasil ditambahkan';
            }else{
                $pesan='Gagal Insert Pemasukan';
            }
        }else{
            $pesan='Gagal Update Barang';
        }


        $output = [
            'status' => $status,
            'pesan' => $pesan,
        ];
        echo json_encode($output);
    }

    public function delete(){
        $status=0;
        $pesan='Data pemasukan gagal dihapus';
        $where = ['id_pemasukan'=>$this->input->post('id_pemasukan',TRUE)];
        $delete = $this->db->delete('pemasukan',$where);
        if($delete){
            $status=1;
            $pesan='Data Pemasukan berhasil dihapus';
        }

        $output = [
            'status'=>$status,
            'pesan'=>$pesan
        ];
        echo json_encode($output);
    }
}