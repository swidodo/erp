<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cpurchase extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
    }

    public function index() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $content = $CI->lpurchase->purchase_add_form();
        $this->template->full_admin_html_view($content);
    }

    //Manage purchase
    public function manage_purchase() {
        $this->load->library('lpurchase');
        $content = $this->lpurchase->purchase_list();
        $this->template->full_admin_html_view($content);
    }



    public function CheckPurchaseList(){
        // GET data
        $this->load->model('Purchases');
        $postData = $this->input->post();
        $data = $this->Purchases->getPurchaseList($postData);
        echo json_encode($data);
    } 


    public function CheckPurchaseGet(){
        // GET data
        $this->load->model('Purchases');
        $postData = $this->input->post();
        $data = $this->Purchases->getPurchaseData($postData);
        echo json_encode($data);
    } 

    public function SupPurchaseGet(){
        // GET data
        $this->load->model('Purchases');
        $postData = $this->input->post();
        $data = $this->Purchases->getPurchaseSupplier($postData);
        echo json_encode($data);
    } 


    // search purchase by supplier 
    public function purchase_search() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $CI->load->model('Purchases');
        $supplier_id = $this->input->get('supplier_id');
        #
        #pagination starts
        #
        $config["base_url"] = base_url('Cpurchase/purchase_search/');
        $config["total_rows"] = $this->Purchases->count_purchase_seach($supplier_id);
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config["num_links"] = 5;
        $config['suffix'] = '?' . http_build_query($_GET);
        $config['first_url'] = $config["base_url"] . $config['suffix'];
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $links = $this->pagination->create_links();
        #
        #pagination ends
        #  
        $content = $this->lpurchase->purchase_search_supplier($supplier_id, $links, $config["per_page"], $page);
        $this->template->full_admin_html_view($content);
    }

//purchase list by invoice no
    public function purchase_info_id() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $CI->load->model('Purchases');
        $invoice_no = $this->input->post('invoice_no',TRUE);
        $content = $this->lpurchase->purchase_list_invoice_no($invoice_no);
        $this->template->full_admin_html_view($content);
    }

    //Insert purchase
    public function insert_purchase() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Purchases');
        $CI->Purchases->purchase_entry();
        $this->session->set_userdata(array('message' => display('successfully_added')));
        if (isset($_POST['add-purchase'])) {
            redirect(base_url('Cpurchase/manage_purchase'));
            exit;
        } elseif (isset($_POST['add-purchase-another'])) {
            redirect(base_url('Cpurchase'));
            exit;
        }
    }

    //purchase Update Form
    public function purchase_update_form($purchase_id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $content = $CI->lpurchase->purchase_edit_data($purchase_id);
        $this->template->full_admin_html_view($content);
    }

    // purchase Update
    public function purchase_update() {

        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Purchases');
        $CI->Purchases->update_purchase();
        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect(base_url('Cpurchase/manage_purchase'));
        exit;
    }

    //Purchase item by search
    public function purchase_item_by_search() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $supplier_id = $this->input->post('supplier_id',TRUE);
        $content = $CI->lpurchase->purchase_by_search($supplier_id);
        $this->template->full_admin_html_view($content);
    }

    //Product search by supplier id
    public function product_search_by_supplier() {


        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $CI->load->model('Suppliers');
        $supplier_id = $this->input->post('supplier_id',TRUE);
        $product_name = $this->input->post('product_name',TRUE);
        $product_info = $CI->Suppliers->product_search_item($supplier_id, $product_name);
        if(!empty($product_info)){
        $list[''] = '';
        foreach ($product_info as $value) {
            $json_product[] = array('label'=>$value['product_name'].' '.$value['size'].' ('.$value['merek'].')','value'=>$value['product_id'],'unit'=>$value['unit']);
        } 
    }else{
        $json_product[] = 'No Product Found';
        }
        echo json_encode($json_product);
    }
    public function product_search() {


        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $CI->load->model('Invoices');
        // $supplier_id = $this->input->post('supplier_id',TRUE);
        $product_name = $this->input->post('product_name',TRUE);
        $product_info = $CI->Invoices->autocompletproductdata($product_name);
        if(!empty($product_info)){
        $list[''] = '';
        foreach ($product_info as $value) {
            $json_product[] = array('label'=>$value['product_name'].' '.$value['size'].' ('.$value['merek'].')','value'=>$value['product_id'],'unit'=>$value['unit']);
        } 
    }else{
        $json_product[] = 'No Product Found';
        }
        echo json_encode($json_product);
    }

    //Retrive right now inserted data to cretae html
    public function purchase_details_data($purchase_id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $content = $CI->lpurchase->purchase_details_data($purchase_id);
        $this->template->full_admin_html_view($content);
    }

    public function delete_purchase($purchase_id = null) {
        $this->load->model('Purchases');
        if ($this->Purchases->purchase_delete($purchase_id)) {
            #set success message
            $this->session->set_flashdata('message', display('delete_successfully'));
        } else {
            #set exception message
            $this->session->set_flashdata('exception', display('please_try_again'));
        }
        redirect(base_url('Cpurchase/manage_purchase'));
    }

    // purchase info date to date
    public function manage_purchase_date_to_date() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $CI->load->model('Purchases');
        $start = $this->input->post('from_date',TRUE);
        $end = $this->input->post('to_date',TRUE);

        $content = $this->lpurchase->purchase_list_date_to_date($start, $end);
        $this->template->full_admin_html_view($content);
    }
//purchase pdf download
      public function purchase_downloadpdf(){
        $CI = & get_instance();
        $CI->load->model('Purchases');
        $CI->load->model('Web_settings');
        $CI->load->model('Invoices');
        $CI->load->library('pdfgenerator'); 
        $purchase_list = $CI->Purchases->pdf_purchase_list();
        if (!empty($purchase_list)) {
            $i = 0;
            if (!empty($purchase_list)) {
                foreach ($purchase_list as $k => $v) {
                    $i++;
                    $purchase_list[$k]['sl'] = $i + $CI->uri->segment(3);
                }
            }
        }
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $company_info = $CI->Invoices->retrieve_company();
        $data = array(
            'title'         => display('manage_purchase'),
            'purchase_list' => $purchase_list,
            'currency'      => $currency_details[0]['currency'],
            'logo'          => $currency_details[0]['logo'],
            'position'      => $currency_details[0]['currency_position'],
            'company_info'  => $company_info
        );
            $this->load->helper('download');
            $content = $this->parser->parse('purchase/purchase_list_pdf', $data, true);
            $time = date('Ymdhi');
            $dompdf = new DOMPDF();
            $dompdf->load_html($content);
            $dompdf->render();
            $output = $dompdf->output();
            file_put_contents('assets/data/pdf/'.'purchase'.$time.'.pdf', $output);
            $file_path = 'assets/data/pdf/'.'purchase'.$time.'.pdf';
           $file_name = 'purchase'.$time.'.pdf';
            force_download(FCPATH.'assets/data/pdf/'.$file_name, null);
    }


    public function create_purchase_order() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $content = $CI->lpurchase->purchase_order_add_form();
        $this->template->full_admin_html_view($content);
    }

    //Manage purchase
    public function manage_purchase_order() {
        $this->load->library('lpurchase');
        $content = $this->lpurchase->purchase_order_list();
        $this->template->full_admin_html_view($content);
    }


    public function insert_purchase_order() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Purchases');
        $purchase_id = $CI->Purchases->purchase_order_entry();
        $this->session->set_userdata(array('message' => display('successfully_added')));
        redirect('cpurchase/cetakpo/'.$purchase_id);
    }


    public function cetakpo($id_po="",$target=null){
        if(empty($id_po)||!$id_po){
            redirect('cinvoice/manage_po');
        }
        $this->load->helper('aplikasi');
        $this->load->model(['Purchases','Web_settings']);
        $po                 = $this->Purchases->retrieve_po_data($id_po);
        $npwp               = $this->Purchases->getCompany($id_po);
        $currency_details   = $this->Web_settings->retrieve_setting_editdata();
        

        $data = [
            'query'             =>$po,
            'npwp'              =>$npwp,
            'target'            =>$target,
            'currency_details'  =>$currency_details
        ];

        
        $this->load->library('Pdf');
        
        // filename dari pdf ketika didownload
        $file_pdf = 'Preorder(PO)';
        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        $orientation = 'landscape';
        
		$html =  $this->load->view('purchase/purchase_order_cetak',$data,true);	    
       
        // run dompdf
        $this->pdf->generate($html, $file_pdf,$paper,$orientation,true);
        
    }
    public function cetakpurchase($id_purchase="",$target=null){
        if(empty($id_purchase)||!$id_purchase){
            redirect('cinvoice/manage_po');
        }
        $this->load->helper('aplikasi');
        $this->load->model(['Purchases','Web_settings']);
        $po                 = $this->Purchases->retrieve_purchase_data($id_purchase);
        $npwp               = $this->Purchases->getCompany($id_purchase);
        $currency_details   = $this->Web_settings->retrieve_setting_editdata();
        

        $data = [
            'query'             =>$po,
            'npwp'              =>$npwp,
            'target'            =>$target,
            'currency_details'  =>$currency_details
        ];

        
        $this->load->library('Pdf');
        
        // filename dari pdf ketika didownload
        $file_pdf = 'Purchase';
        // setting paper
        $paper = 'letter';
        //orientasi paper potrait / landscape
        $orientation = 'landscape';
        
		$html =  $this->load->view('purchase/purchase_cetak',$data,true);	    
       
        // run dompdf
        $this->pdf->generate($html, $file_pdf,$paper,$orientation,true);
        
    }

    public function CheckPurchaseOrderList(){
        // GET data
        $this->load->model('Purchases');
        $postData = $this->input->post();
        $data = $this->Purchases->getPurchaseOrderList($postData);
        echo json_encode($data);
    } 


    //purchase Update Form
    public function po_update_form($purchase_id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $content = $CI->lpurchase->po_edit_data($purchase_id);
        $this->template->full_admin_html_view($content);
    }

    public function purchase_do_details($purchaseID)
    {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Purchases');
        $data['do'] = $CI ->Purchases->getDoPurchase($purchaseID);
        $data['purid']   = $purchaseID;
        $content =  $CI->parser->parse('purchase/purchase_do_details', $data, true);
        $CI->template->full_admin_html_view($content);
    } 
    public function po_detail($poID)
    {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Purchases');
        $data['do']      = $CI ->Purchases->getDoPo($poID);
        $data['purid']   = $poID;
        $content =  $CI->parser->parse('purchase/purchase_order_do', $data, true);
        $CI->template->full_admin_html_view($content);
    }
    public function add_do_purchase($purchaseID){
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Purchases');
        $data['purchase'] = $CI->Purchases->chekdataPurchase($purchaseID);
        $content = $CI->parser->parse('purchase/add_do_purchase', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function add_do_po($poID){
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Purchases');
        $data['purchase'] = $CI->Purchases->chekdataPo($poID);
        $content = $CI->parser->parse('purchase/add_do_purchase_order', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function do_insert_purchase()
    {
        $date           = $this->input->post('date');
        $purchaseId     = $this->input->post('purchase_id');
        $doId           = $this->input->post('do_id');
        $dodate         = $this->input->post('dodate');
        $paydate        = $this->input->post('pay_date');
        $duedate        = $this->input->post('due_date');
        $do_details     = '';
        $do_type        = 'purchase';
        $user           = $this->session->userdata('user_id');
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Purchases');
        // var_dump($date,$purchaseId,$doId,$dodate,$paydate,$duedate,$do_details,$do_type,$user);exit;
        $CI->Purchases->InsertdataDO($date,$purchaseId,$doId,$dodate,$paydate,$duedate,$do_details,$do_type,'','','','',$user);
        redirect(base_url('Cpurchase/purchase_do_details/'.$purchaseId));
        exit;
    }
    public function do_insert_po()
    {
        $date           = $this->input->post('date');
        $purchaseId     = $this->input->post('po_id');
        $doId           = $this->input->post('do_id');
        $dodate         = $this->input->post('dodate');
        $paydate        = $this->input->post('pay_date');
        $duedate        = $this->input->post('due_date');
        $invoice_no     = $this->input->post('invoice_no');
        $tax_date       = $this->input->post('tax_date');
        $payment       = $this->input->post('payment');
        $inv_date       = $this->input->post('invoice_date');
        $do_details     = '';
        $do_type        = 'PO';
        $user           = $this->session->userdata('user_id');
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Purchases');
        $CI->Purchases->InsertdataDO($date,$purchaseId,$doId,$dodate,$paydate,$duedate,$do_details,$do_type,$invoice_no,$tax_date,$payment,$inv_date,$user);
        redirect(base_url('Cpurchase/po_detail/'.$purchaseId));
        exit;
    }
    public function edit_do_purchase($doID)
    {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Purchases');
        $data['do'] = $CI->Purchases->getDataById($doID);
        $content = $CI->parser->parse('purchase/edit_do_purchase', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function edit_purchase_order_do($doID)
    {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Purchases');
        $data['do'] = $CI->Purchases->getByIdPODO($doID);
        $content = $CI->parser->parse('purchase/edit_purchase_order_do', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function update_insert_purchase($id)
    {
        $date           = $this->input->post('date');
        $purchaseId     = $this->input->post('purchase_id');
        $doId           = $this->input->post('do_id');
        $dodate         = $this->input->post('dodate');
        $paydate        = $this->input->post('pay_date');
        $duedate        = $this->input->post('due_date');
        $invoice_no     = $this->input->post('invoice_no');
        $tax_date       = $this->input->post('tax_date');
        $payment         = $this->input->post('payment');
        $invoice_date       = $this->input->post('invoice_date');
        // var_dump( $invoice_date);exit;
        $do_details     = '';
        $user           = $this->session->userdata('user_id');
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Purchases');
        $CI->Purchases->updateDopurchase($id,$date,$doId,$dodate,$paydate,$duedate,$do_details,$invoice_no,$tax_date,$payment,$invoice_date,$user);
        $check = $CI->Purchases->Checked($id);
        if ($check !=null):
            if ($check[0]['do_type'] == "purchase" ):
                redirect(base_url('Cpurchase/purchase_do_details/'.$purchaseId));
            elseif ($check[0]['do_type'] == "PO" ):
                redirect(base_url('Cpurchase/po_detail/'.$check[0]['purchase_id']));
            endif;
        else :
            return false;
        endif;
        exit;
    }
    public function update_purchase_order() {

        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Purchases');
        $id = $this->uri->segment(3);
        $CI->Purchases->update_purchase_order($id);
        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect(base_url('Cpurchase/manage_purchase_order'));
        exit;
    }


    public function delete_po(){
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Purchases');
        $id = $this->uri->segment(3);
        $CI->Purchases->purchase_order_delete($id);
        $this->session->set_userdata(array('message' => 'Berhasil dihapus'));
        redirect(base_url('Cpurchase/manage_purchase_order'));
        exit;
    }


    //barangmasuk\
    public function barang_masuk() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $content = $CI->lpurchase->barangmasuk_add_form();
        $this->template->full_admin_html_view($content);
    }
    
    //Manage purchase
    public function manage_barang_masuk() {
        $this->load->library('lpurchase');
        $content = $this->lpurchase->barang_masuk_list();
        $this->template->full_admin_html_view($content);
    }


    public function insert_barang_masuk() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Purchases');
        $bm_id = $CI->Purchases->barang_masuk_entry();
        $this->session->set_userdata(array('message' => display('successfully_added')));
        redirect('cpurchase/cetakbarangmasuk/'.$bm_id);
    }


    public function cetakbarangmasuk($bm_id="",$target=null){
        if(empty($bm_id)||!$bm_id){
            redirect('cinvoice/manage_barangmasuk');
        }
        $this->load->helper('aplikasi');
        $this->load->model(['Purchases','Web_settings']);
        $bm = $this->Purchases->retrieve_barang_masuk_data($bm_id);
        $currency_details = $this->Web_settings->retrieve_setting_editdata();
        

        $data = [
            'query'=>$bm,
            'target'=>$target,
            'currency_details'=>$currency_details
        ];

        
        $this->load->library('Pdf');
        
        // filename dari pdf ketika didownload
        $file_pdf = 'Barang Masuk';
        // setting paper
        $paper = 'Letter';
        //orientasi paper potrait / landscape
        $orientation = 'potrait';
        
		$html =  $this->load->view('purchase/barang_masuk_cetak',$data,true);	    
       
        // run dompdf
        $this->pdf->generate($html, $file_pdf,$paper,$orientation,true);
        
    }

    public function CheckBarangMasukList(){
        // GET data
        $this->load->model('Purchases');
        $postData = $this->input->post();
        $data = $this->Purchases->getBarangMasukList($postData);
        echo json_encode($data);
    } 


    //purchase Update Form
    public function barangmasuk_update_form($purchase_id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $content = $CI->lpurchase->barang_masuk_edit_data($purchase_id);
        $this->template->full_admin_html_view($content);
    }

    public function getPO()
    {
        
    }

    public function update_barang_masuk() {

        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Purchases');
        $CI->Purchases->update_barang_masuk();
        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect(base_url('Cpurchase/manage_barang_masuk'));
        exit;
    }


    public function delete_barangmasuk(){
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Purchases');
        $id = $this->uri->segment(3);
        $CI->Purchases->barang_masuk_delete($id);
        $this->session->set_userdata(array('message' => 'Berhasil dihapus'));
        redirect(base_url('Cpurchase/manage_barang_masuk'));
        exit;
    }
    // barang keluar

    public function barang_keluar() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $content = $CI->lpurchase->barangkeluar_add_form();
        $this->template->full_admin_html_view($content);
    }
    
    //Manage purchase
    public function manage_barang_keluar() {
        $this->load->library('lpurchase');
        $content = $this->lpurchase->barang_keluar_list();
        $this->template->full_admin_html_view($content);
    }


    public function insert_barang_keluar() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Purchases');
        $bk_id = $CI->Purchases->barang_keluar_entry();
        $this->session->set_userdata(array('message' => display('successfully_added')));
        redirect('cpurchase/cetakbarangkeluar/'.$bk_id);
    }


    public function cetakbarangkeluar($bk_id="",$target=null){
        if(empty($bk_id)||!$bk_id){
            redirect('cinvoice/manage_barang_keluar');
        }
        $this->load->helper('aplikasi');
        $this->load->model(['Purchases','Web_settings']);
        $bk = $this->Purchases->retrieve_barang_keluar_data($bk_id);
        $currency_details = $this->Web_settings->retrieve_setting_editdata();
        

        $data = [
            'query'=>$bk,
            'target'=>$target,
            'currency_details'=>$currency_details
        ];

        
        $this->load->library('Pdf');
        
        // filename dari pdf ketika didownload
        $file_pdf = 'Barang Keluar';
        // setting paper
        $paper = 'Letter';
        //orientasi paper potrait / landscape
        $orientation = 'potrait';
        
		$html =  $this->load->view('purchase/barang_keluar_list_cetak',$data,true);	    
       
        // run dompdf
        $this->pdf->generate($html, $file_pdf,$paper,$orientation,true);
        
    }

    public function CheckBarangKeluarList(){
        // GET data
        $this->load->model('Purchases');
        $postData = $this->input->post();
        $data = $this->Purchases->getBarangKeluarList($postData);
        // print_r($data);
        echo json_encode($data);
    } 


    //purchase Update Form
    public function barangkeluar_update_form($purchase_id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $content = $CI->lpurchase->barang_keluar_edit_data($purchase_id);
        $this->template->full_admin_html_view($content);
    }

    

    public function update_barang_keluar() {

        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Purchases');
        $CI->Purchases->update_barang_keluar();
        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect(base_url('Cpurchase/manage_barang_keluar'));
        exit;
    }


    public function delete_barangkeluar(){
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Purchases');
        $id = $this->uri->segment(3);
        $CI->Purchases->barang_keluar_delete($id);
        $this->session->set_userdata(array('message' => 'Berhasil dihapus'));
        redirect(base_url('Cpurchase/manage_barang_keluar'));
        exit;
    }
    public function Manage_product() {
        $this->load->library('lpurchase');
        $content = $this->lpurchase->manage_product();
        $this->template->full_admin_html_view($content);
    }

    public function Manage_product_data(){
        $this->load->model('Purchases');
        $postData = $this->input->post();
        $data = $this->Purchases->get_list_products($postData);
        echo json_encode($data);
    }

    public function view_manage_product($prod_id) {
        $this->load->library('lpurchase');
        $content = $this->lpurchase->view_manage_product($prod_id);
        $this->template->full_admin_html_view($content);
    }
    public function get_product_purchase_view(){
        $this->load->model('Purchases');
        $postData = $this->input->post();
        $data = $this->Purchases->list_products_po_purchase($postData);
        echo json_encode($data);
    }
   
}
