<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->model('Penjualan_model','penjualan');
        if(!$_SESSION['username']){
            redirect('Auth');
        }
    }
    
	public function index()
	{
        $data['konten'] = 'penjualan/index_penjualan';
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
        $data['custom_js'] = 'penjualan.js';
        $data['total1'] = $this->penjualan->total('Hari');
        $data['total2'] = $this->penjualan->total('Bulan');
        $data['total3'] = $this->penjualan->total('Tahun');
        $data['total4'] = $this->penjualan->total('Selama');
        $this->load->view('index',$data);
    }

    public function show(){
        $data = array();
        $xBegin = $this->input->post('xBegin');
        $xEnd = $this->input->post('xEnd');
        $column_order = array('tgl_keluar', 'id_nota','nama_pembeli','total');
        $query = $this->penjualan->get_datatables($column_order,$xBegin,$xEnd);
        foreach ($query->result() as $key) {
            $row = array();
            $row['tgl_keluar'] = date('Y-m-d H:i:s',strtotime($key->tgl_keluar));
            $row['id_nota'] = $key->id_nota;
            $row['nama_pembeli'] = $key->nama_pembeli;
            $row['total'] = number_format($key->total);
            $data[] = $row;
        }

        $output = array(
            'draw' => $_POST['draw'],
            'recordsFiltered' => $query->num_rows(),
            'recordsTotal' => $this->penjualan->total_entri($xBegin,$xEnd),
            'data' => $data,
            'periode' => date('d F Y',strtotime($xBegin)).' - '.date('d F Y',strtotime($xEnd)),
        );

        echo json_encode($output);
    }

    public function update(){
        $status = 0;
        $pesan = 'Data Gagal Diubah';
        $id_nota = $this->input->post('id_nota',TRUE);
        $set = [
            'nama_pembeli' => $this->input->post('nama_pembeli',TRUE),
            'total' => intval($this->input->post('total',TRUE)),
            'bayar' => intval($this->input->post('bayar',TRUE)),
            'kembalian' => intval($this->input->post('kembalian',TRUE)),
            'username' => $_SESSION['username'],
        ];
        $update_nota = $this->db->where('id_nota',$id_nota)->update('nota',$set);
        if($update_nota){
            $delete_pk = $this->db->where('id_nota',$id_nota)->delete('pengeluaran');
            if($delete_pk){
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
                        $pesan = 'Data berhasil diubah';
                        $status =1;
                    }else{
                        $status=0;
                        break;
                    }
                }
            }else{
                $pesan = 'Data nota berhasil di ubah, item gagal diubah';
                $status=0;
            }
        }

        $output = [
            'status' => $status,
            'pesan' => $pesan,
        ];
        echo json_encode($output);
    }

    public function detail(){
        $status = 0;
        $item = '';
        $id_nota = $this->input->post('id_nota',TRUE);
        $nota = $this->db->get_where('nota',['id_nota'=>$id_nota]);
        if($nota){
            $nota = $nota->row();
            $penjualan = $this->db->select('p.*,nama_barang,(jml_pm-jml_pk)+p.jml_keluar as jml_stok')
                        ->from('pengeluaran as p')
                        ->join('barang as b','b.id_barang=p.id_barang','INNER')
                        ->join('(SELECT SUM(jml_pemasukan) as jml_pm, id_barang FROM pemasukan GROUP BY id_barang) as pm',
                            'pm.id_barang=p.id_barang','LEFT')
                        ->join('(SELECT SUM(jml_keluar) as jml_pk, id_barang 
                                FROM pengeluaran 
                                GROUP BY id_barang) as pk',
                                'pk.id_barang=p.id_barang','LEFT')
                        ->where('id_nota',$id_nota)
                        ->order_by('nama_barang','ASC')->get();
            if($penjualan){
                foreach($penjualan->result() as $key){
                    $item .= '<tr data-id="'.$key->id_barang.'">
                        <td class="text-center">'.$key->id_barang.'</td>
                        <td>'.$key->nama_barang.'</td>
                        <td class="text-center">'.number_format($key->harga_jual).'</td>
                        <td class="text-center" data-stok="'.$key->jml_stok.'">'.number_format($key->jml_keluar).'</td>
                        <td class="text-right">'.number_format($key->total_harga).'</td>
                    </tr>';
                }
                $status=1;
            }else{
                $status=0;
            }
        }
        
        $output = [
            'status' => $status,
            'nota' => $nota,
            'item' => $item
        ];
        echo json_encode($output);
    }

    public function delete(){
        $status = 0;
        $pesan = 'Data gagal dihapus';
        $id_nota = $this->input->post('id_nota');
        $delete_nota = $this->db->where('id_nota',$id_nota)->delete('nota');
        if($delete_nota){
            $delete_pengeluaran = $this->db->where('id_nota',$id_nota)->delete('pengeluaran');
            if($delete_pengeluaran){
                $status = 1;
                $pesan = 'Data berhasil dihapus';
            }else{
                $status = 0;
            }
        }
        $output = [
            'status'=>$status,
            'pesan'=>$pesan,
        ];
        echo json_encode($output);
    }

    public function print($jenis=null,$id_nota=null){
        if($id_nota==null || $jenis==null){
            redirect(base_url('Penjualan'));
        }else{
            $item=$item_nota='';
            $nota = $this->db->get_where('nota',['id_nota'=>$id_nota]);
            $penjualan = $this->db->select('p.*,nama_barang')
            ->from('pengeluaran as p')
            ->join('barang as b','b.id_barang=p.id_barang','INNER')
            ->where('id_nota',$id_nota)
            ->order_by('nama_barang','ASC')->get();
            $no=1;
            foreach($penjualan->result() as $key){
                $item .= '<tr>
                    <td class="text-center">'.$no.'</td>
                    <td>'.$key->nama_barang.'</td>
                    <td class="">'.number_format($key->jml_keluar).'</td>
                    <td class="">'.number_format($key->harga_jual).'</td>
                    <td class="text-right">'.number_format($key->total_harga).'</td>
                </tr>';

                $item_nota .= '<tr><td colspan="2">'.$key->nama_barang.'</td></tr>
                                    <tr>
                                        <td>'.number_format($key->jml_keluar).' x '.number_format($key->harga_jual).'</td>
                                        <td align="right">'.number_format($key->total_harga).'</td>
                                    </tr>';
                $no++;
            }
            
            if($jenis=='faktur'){
                $view = 'print_faktur';
            }else{
                $view = 'print_nota';
            }
            $this->load->view('dashboard/'.$view,[
                'nota' => $nota->row(),
                'item' => $item,
                'item_nota' => $item_nota,
            ]);
        }
    }
}