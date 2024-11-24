<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    
	public function index()
	{
        $data['konten'] = 'user/index_user';
        $data['users'] = $this->db->get('user')->result();
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
        $this->load->view('index',$data);
    }

    public function ttd(){
        $data['konten'] = 'user/ttd';
        $this->load->view('index',$data);
    }
}