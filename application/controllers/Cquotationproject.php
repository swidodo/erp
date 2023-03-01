<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cquotationproject extends CI_Controller {

    public $menu;
    private $user_id;
    private $user_type;

    function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->library('session');
        $this->load->model('Quotation_model');
        $this->load->model('Web_settings');
        $this->load->model('Products');
        $this->load->helper('aplikasi');
        $this->auth->check_admin_auth();
        $this->user_id = $this->session->userdata('user_id');
        $this->user_type = $this->session->userdata('user_type');
    }


    public function index(){
        $this->load->model(['Web_settings','Hrm_model']);
        $data['title']    = display('add_quotation');
        $currency_details = $this->Web_settings->retrieve_setting_editdata();
        $taxfield = $this->db->select('tax_name,default_value')
                ->from('tax_settings')
                ->get()
                ->result_array();
        $blnromawi = romawi(intval(date('m')));
        $thn = date('Y');
        $data['quotation_no']    = $this->quot_number_generator();
        $data['idquot'] = $this->auth->generator(15);
        $data['taxes']           = $taxfield;
        $data['discount_type']   = $currency_details[0]['discount_type'];
        $data['customers']       = $this->Quotation_model->get_allcustomer();
        $data['get_productlist'] = $this->Quotation_model->get_allproduct();
        $data['employees'] = $this->Hrm_model->employee_list();
        $data['products'] = $this->db->get('product_information')->result();
       
        $content = $this->parser->parse('quotation_project/quotation_project_form', $data, true);
        $this->template->full_admin_html_view($content);
    }


    public function list(){
            $data['currency_details'] = $this->Web_settings->retrieve_setting_editdata();
            $data['title'] = display('manage_quotation');
            $config["base_url"] = base_url('Cquotation/manage_quotation/');
            $config["total_rows"] = $this->db->count_all('quotation');
            $config["per_page"] = 20;
            $config["uri_segment"] = 3;
            $config["last_link"] = "Last";
            $config["first_link"] = "First";
            $config['next_link'] = 'Next';
            $config['prev_link'] = 'Prev';
            $config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination">';
            $config['full_tag_close'] = '</ul></nav></div>';
            $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
            $config['num_tag_close'] = '</span></li>';
            $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
            $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
            $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
            $config['next_tagl_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
            $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
            $config['prev_tagl_close'] = '</span></li>';
            $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
            $config['first_tagl_close'] = '</span></li>';
            $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
            $config['last_tagl_close'] = '</span></li>';
            #Paggination end#
    
    
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $limit = $config["per_page"];
            $data['quotation_list'] = $this->db->select('a.*, b.customer_name, CONCAT(c.first_name, " ",c.last_name) as marketing')
            ->from('quotation_project a')
            ->join('customer_information b', 'b.customer_id = a.customer_id','left')
            ->join('employee_history c', 'c.id = a.marketing_id','left')
            ->order_by('a.id', 'desc')
            ->get()
            ->result();
            
            $data['links'] = $this->pagination->create_links();
            $data['pagenum'] = $page;
    
            $content = $this->parser->parse('quotation_project/quotation_project_list', $data, true);
            $this->template->full_admin_html_view($content);
    }

    public function store(){
        $idquot = $this->input->post('idquot');
        $qtotal = $this->db
        ->select('SUM(qty) as jumlah, (product_information.price * quotation_project_item.qty) as total')
        ->join('quotation_project_detail','quotation_project_detail.quot_project_detail_id = quotation_project_item.quot_project_detail_id','LEFT')
        ->join('product_information','quotation_project_detail.quot_project_detail_id = quotation_project_item.quot_project_detail_id','LEFT')
        ->get_where('quotation_project_item',['quotation_project_detail.quotation_id'=>$idquot])
        ->row();

        $data = array(
            'quotation_id'        => $idquot,
            'customer_id'         => $this->input->post('customer_id',TRUE),
            'quotdate'            => $this->input->post('qdate',TRUE),
            'item_total_amount'   => $qtotal->total,
            'item_total_dicount'  => 0,
            'item_total_tax'      => 0,
            'service_total_amount'=> 0,
            'service_total_discount'=> 0,
            'service_total_tax'   =>0,
            'quot_dis_item'       =>0,
            'quot_dis_service'    =>0,
            'quot_no'             => $this->input->post('quotation_no',TRUE),
            'create_by'           => $this->session->userdata('user_id'),
            'quot_description'    => $this->input->post('details',TRUE),
            'marketing_id'         => $this->input->post('marketing_id',TRUE),
            'delivery_time'    => $this->input->post('deliverytime',TRUE),
            'delivery_time_sat'    => $this->input->post('deliverytimesat',TRUE),
            'quotation_exp'    => $this->input->post('quotationexp',TRUE),
            'quotation_exp_sat'    => $this->input->post('quotationexpsat',TRUE),
            'status'              => 1,
            );

            $result = $this->db->insert('quotation_project',$data);
            $this->session->set_userdata(array('message' => 'Data Penawaran Proyek berhasil disimpan'));
            redirect(base_url('Cquotationproject/list')); 
    }

    public function edit($id){
        $this->load->model(['Web_settings','Hrm_model']);
        $data['title']    = 'Edit Penawaran Proyek';
        $currency_details = $this->Web_settings->retrieve_setting_editdata();
        $taxfield = $this->db->select('tax_name,default_value')
                ->from('tax_settings')
                ->get()
                ->result_array();
        $blnromawi = romawi(intval(date('m')));
        $thn = date('Y');
        $data['taxes']           = $taxfield;
        $data['discount_type']   = $currency_details[0]['discount_type'];
        $data['customers']       = $this->Quotation_model->get_allcustomer();
        $data['get_productlist'] = $this->Quotation_model->get_allproduct();
        $data['employees'] = $this->Hrm_model->employee_list();
        $data['products'] = $this->db->get('product_information')->result();
        $data['qedit'] = $this->db->select('a.*, b.customer_name, b.customer_address, b.phone')
        ->from('quotation_project a')
        ->join('customer_information b', 'b.customer_id = a.customer_id','left')
        ->where('a.quotation_id', $id)
        ->get()
        ->result_array();
       
        $content = $this->parser->parse('quotation_project/quotation_project_edit', $data, true);
        $this->template->full_admin_html_view($content);
    }

    public function update(){
        $idquot = $this->input->post('idquot');
        $qtotal = $this->db
        ->select('SUM(qty) as jumlah, (product_information.price * quotation_project_item.qty) as total')
        ->join('quotation_project_detail','quotation_project_detail.quot_project_detail_id = quotation_project_item.quot_project_detail_id','LEFT')
        ->join('product_information','quotation_project_detail.quot_project_detail_id = quotation_project_item.quot_project_detail_id','LEFT')
        ->get_where('quotation_project_item',['quotation_project_detail.quotation_id'=>$idquot])
        ->row();

        $data = array(
            'customer_id'         => $this->input->post('customer_id',TRUE),
            'quotdate'            => $this->input->post('qdate',TRUE),
            'item_total_amount'   => $qtotal->total,
            'item_total_dicount'  => 0,
            'item_total_tax'      => 0,
            'service_total_amount'=> 0,
            'service_total_discount'=> 0,
            'service_total_tax'   =>0,
            'quot_dis_item'       =>0,
            'quot_dis_service'    =>0,
            'quot_no'             => $this->input->post('quotation_no',TRUE),
            'create_by'           => $this->session->userdata('user_id'),
            'quot_description'    => $this->input->post('details',TRUE),
            'marketing_id'         => $this->session->userdata('user_id'),
            'delivery_time'    => $this->input->post('deliverytime',TRUE),
            'delivery_time_sat'    => $this->input->post('deliverytimesat',TRUE),
            'quotation_exp'    => $this->input->post('quotationexp',TRUE),
            'quotation_exp_sat'    => $this->input->post('quotationexpsat',TRUE),
            'status'              => 1,
            );

            $result = $this->db->where('quotation_id',$idquot)->update('quotation_project',$data);
            $this->session->set_userdata(array('message' => 'Data Penawaran Proyek berhasil diupdate'));
            redirect(base_url('Cquotationproject/list')); 
    }

    public function destroy($id){
        $query = $this->db->where('quotation_id',$id)->delete('quotation_id',$id);
        $this->session->set_userdata(array('message' => 'Data Penawaran Proyek berhasil dihapus'));
        redirect(base_url('Cquotationproject/list'));
    }


    public function cetak($id){
        $data['qedit'] = $this->db->select('a.*, b.customer_name, b.customer_address, b.phone as phonecomp, b.contact, b.fax, CONCAT(c.first_name, " ",c.last_name) as marketing, c.phone, c.email as emailmarketing')
        ->from('quotation_project a')
        ->join('customer_information b', 'b.customer_id = a.customer_id','left')
        ->join('employee_history c', 'c.id = a.marketing_id','left')
        ->where('a.quotation_id', $id)
        ->get()
        ->result_array();
        $data['query'] = $this->db->order_by('created_at','ASC')->get_where('quotation_project_detail',['quotation_id'=>$id,'parent_id'=>'0'])->result();
        $data['idquot'] = $id;
        $currency_details = $this->Web_settings->retrieve_setting_editdata();
        $data['currency_details'] = $this->Web_settings->retrieve_setting_editdata();
        

        $this->load->view('quotation_project/quotation_project_print',$data);
    }


    //======================
    public function pilihparent(){
        $id = $this->uri->segment(3);
        $data['item'] = $this->db->order_by('created_at','ASC')->get_where('quotation_project_detail',['quotation_id'=>$id,'parent_id'=>'0'])->result();
        echo '<select name="parentid" id="parentid" class="form-control"><option value="0">--Silahkan Pilih--</option>';

        foreach($data['item'] as $row){
            echo '<option value="'.$row->quot_project_detail_id.'">'.$row->quot_detail_title.'</option>';
        }

        echo '</select>';
    }
    public function projectlist(){
        $id = $this->uri->segment(3);
        $data['query'] = $this->db->order_by('created_at','ASC')->get_where('quotation_project_detail',['quotation_id'=>$id,'parent_id'=>'0'])->result();
        $data['idquot'] = $id;
        
        $this->load->view('quotation_project/detail_project_list',$data);
    }


    public function tambahproyek(){
        $idquot = $this->input->post('idquot');
        $descitem = $this->input->post('descitem');
        $parentid = $this->input->post('parentid');

        $data = [
            'quot_project_detail_id'=>$this->auth->generator(15),
            'quotation_id'=>$idquot,
            'quot_detail_title'=>$descitem,
            'parent_id'=>$parentid,
            'created_at'=>date('Y-m-d H:i:s')
        ];

        $this->db->insert('quotation_project_detail',$data);

        echo json_encode(['status'=>'OK']);
    }

    public function projectdestroy($id){
        $query = $this->db->where('quot_project_detail_id',$id)->delete('quotation_project_detail');
        echo json_encode(['status'=>'OK']);
    }


    public function tambahitem(){
        $detailid = $this->input->post('detailid');
        $product_id = $this->input->post('product_id');
        $quantity = $this->input->post('quantity');
        $price = $this->input->post('price');
        $totalprice = $quantity * $price;
    

        $data = ['quot_project_detail_id'=>$detailid,'product_id'=>$product_id,'qty'=>$quantity,'price'=>0,'total_price'=>0];
        $this->db->insert('quotation_project_item',$data);
        echo json_encode(['status'=>'OK']);
    }


    public function itemdestroy($id){
        $query = $this->db->where('quot_item_id',$id)->delete('quotation_project_item');
        echo json_encode(['status'=>'OK']);
    }


    public function quot_number_generator() {
        $this->db->select_max('quot_no', 'quot_no');
        $query   = $this->db->get('quotation_project');
        $result  = $query->result_array();
        $quot_no = $result[0]['quot_no'];
        if ($quot_no != '') {
            $quot_no = $quot_no + 1;
        } else {
            $quot_no = 1000;
        }
        return $quot_no;
    }
//end of class
}    