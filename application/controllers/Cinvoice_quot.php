<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cinvoice_quot extends CI_Controller {

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
    // managemant invoice qoutation
    public function manage_invoice_list()
    {
        $this->load->model('Quotation_model');
        $data['quot'] = $this->Quotation_model->list_Invoice_qoutation();
        foreach($data['quot'] as &$inv):
          $invoice = $this->Quotation_model->getInv($inv['quotation_id']);
          $inv['Tot'] = $invoice;
        endforeach;
        $content = $this->parser->parse('invoice_quotation/manage_invoice_list', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function add_invoice($quot_id)
    {
        $this->load->model('Quotation_model');
        $data['isinv']      = $this->Quotation_model->CheckIsInv($quot_id);
        $data['noInv']      = $this->Quotation_model->InvNo();
        $taxfield = $this->db->select('tax_name,default_value')
                ->from('tax_settings')
                ->get()
                ->result_array();
            
        $tablecolumn              = $this->db->list_fields('tax_collection');
        $num_column               = count($tablecolumn)-4;       
        $currency_details         = $this->Web_settings->retrieve_setting_editdata();
        $data['currency_details'] = $this->Web_settings->retrieve_setting_editdata();
        $data['title']            = display('quotation_details');
        $data['quot_main']        = $this->Quotation_model->quot_main_edit($quot_id);
        $data['quot_product']     = $this->Quotation_model->quot_product_detail($quot_id);
        $data['quot_service']     = $this->Quotation_model->quot_service_detail($quot_id);
        $data['customer_info']    = $this->Quotation_model->customerinfo($data['quot_main'][0]['customer_id']);
        $data['itemtaxin']        = $this->Quotation_model->itemtaxdetails($data['quot_main'][0]['quot_no']);
        $data['servicetaxin']     = $this->Quotation_model->servicetaxdetails($data['quot_main'][0]['quot_no']);
        $data['taxes']            = $taxfield;
        $data['taxnumber']        = $num_column;
        $data['bank_list']        = $this->Quotation_model->bank_list();
        $data['customers']        = $this->Quotation_model->get_allcustomer();
        $data['get_productlist']  = $this->Quotation_model->get_allproduct();
        $data['discount_type']    = $currency_details[0]['discount_type'];
        $data['company_info']     = $this->Quotation_model->retrieve_company();
        foreach($data['quot_main'] as &$inv):
          $invoice = $this->Quotation_model->getInv($inv['quotation_id']);
          $inv['Tot'] = $invoice;
        endforeach;
        $content = $this->parser->parse('invoice_quotation/new_invoice_form', $data, true);
        $this->template->full_admin_html_view($content);
    }
    
   public function save_invoice()
    {
      $checked = $this->Quotation_model->moreInv($this->input->post('quotation_id',TRUE));
        if ($checked !=null)
        {
            if ($checked[0]['type_top']=="DP" && $this->input->post('type_top',true)=="Pelunasan" || $checked[0]['type_top']=="T1" && substr($this->input->post('type_top',true),0,1)=="T"){

                $cekqtt = $this->Quotation_model->checkQtt($this->input->post('quotation_id',TRUE));
                // $cekjasa = $this->Quotation_model->checkjasa($this->input->post('quotation_id',TRUE));
                if ($cekqtt[0]['tot_inv'] !=null){
                    $Avalabel= $cekqtt[0]['tot_quot']+$cekqtt[0]['tot_service']-$cekqtt[0]['tot_inv'];
                }else{
                     $Avalabel= $cekqtt[0]['tot_quot'];
                }

                if ($Avalabel >= $this->input->post('grand_total_price',TRUE)){
                    $mailsetting  = $this->db->select('*')->from('email_config')->get()->result_array(); 
                    $quotation_id = $this->input->post('quotation_id',TRUE);
                    $due_date     = $this->input->post('due_date',TRUE);
                    $customer_id  = $this->input->post('customer_id',TRUE);
                    $product_id   = $this->input->post('product_id',TRUE);
                    $invoice_id   = $this->generator(10);
                    $invoice_id   = strtoupper($invoice_id);
                    $createby     = $this->session->userdata('user_id');
                    $createdate   = date('Y-m-d H:i:s');
                    $quantity     = $this->input->post('product_quantity',TRUE);
                    $squantity    = $this->input->post('service_quantity',TRUE);
                    $typetop      = $this->input->post('type_top',true);
                    $persent      = $this->input->post('persent',true);
                    $ppn          = $this->input->post('ppn',true);
                    $tablecolumn  = $this->db->list_fields('tax_collection');
                    $num_column   = count($tablecolumn)-4;

                    $cusifo  = $this->db->select('*')->from('customer_information')->where('customer_id',$customer_id)->get()->row();
                    $headn   = $customer_id.'-'.$cusifo->customer_name;
                    $coainfo = $this->db->select('*')->from('acc_coa')->where('HeadName',$headn)->get()->row();
                    $customer_headcode = $coainfo->HeadCode;
                    $bank_id = $this->input->post('bank_id',TRUE);
                    if(!empty($bank_id)){
                        $bankname = $this->db->select('bank_name')->from('bank_add')->where('bank_id',$bank_id)->get()->row()->bank_name;

                        $bankcoaid = $this->db->select('HeadCode')->from('acc_coa')->where('HeadName',$bankname)->get()->row()->HeadCode;
                    }else{
                      $bankcoaid='';
                    }
                    $quotdata = array(
                        'status'  => 2,
                      );
                    $this->db->where('quotation_id', $quotation_id);
                    $this->db->update('quotation',$quotdata);

                    $transection_id = $this->auth->generator(15);

                    $checkInv      = $this->db->from('invoice')->where('quotation_id',$quotation_id)->get()->result_array();
                    $taxend      = $this->input->post('grand_total_price',TRUE) * $ppn/100;
                    $datainvmain = array(
                      'invoice_id'        => $invoice_id,
                      'customer_id'       => $customer_id,
                      'quotation_id'      => $quotation_id,
                      'date'              => (!empty($this->input->post('qdate',TRUE))?$this->input->post('qdate',TRUE):date('Y-m-d')),
                      'total_amount'      => $this->input->post('grand_total_price',TRUE),
                      'total_tax'         => $taxend,
                      // 'total_tax'         => $this->input->post('total_tax',TRUE),
                      'invoice'           => $this->number_generator(),
                      'invoice_details'   => (!empty($this->input->post('details',TRUE))?$this->input->post('details',TRUE):''),
                      'invoice_discount'  => $this->input->post('invoice_discount',TRUE),
                      'total_discount'    => $this->input->post('total_discount',TRUE),
                      'prevous_due'       => '',
                      'shipping_cost'     => '',
                      'sales_by'          => $this->session->userdata('user_id'),
                      'status'            => 1,
                      'payment_type'      =>  $this->input->post('paytype',TRUE),
                      'bank_id'           =>  $this->input->post('bank_id',TRUE),
                      'duedate'           => $due_date,
                      'type_top'          => $typetop,
                      'persent'           => $persent,
                      'ppn'               => $ppn,
                      'perusahaan'        => $this->input->post('perusahaan',TRUE),
                    );

                    $prinfo  = $this->db->select('product_id,Avg(rate) as product_rate')->from('product_purchase_details')->where_in('product_id',$product_id)->group_by('product_id')->get()->result(); 
                    $purchase_ave = [];
                    $i=0;
                    foreach ($prinfo as $avg) {
                      $purchase_ave [] =  $avg->product_rate*$quantity[$i];
                      $i++;
                    }
                    $sumval = array_sum($purchase_ave);

                    $cc = array(
                      'VNo'            =>  $invoice_id,
                      'Vtype'          =>  'INVOICE',
                      'VDate'          =>  $createdate,
                      'COAID'          =>  1020101,
                      'Narration'      =>  'Cash in Hand in Sale for '.$cusifo->customer_name,
                      'Debit'          =>  $this->input->post('grand_total_price',TRUE),
                      'Credit'         =>  0,
                      'IsPosted'       =>  1,
                      'CreateBy'       =>  $createby,
                      'CreateDate'     =>  $createdate,
                      'IsAppove'       =>  1
                    ); 

                    // bank ledger
                    $bankc = array(
                      'VNo'            =>  $invoice_id,
                      'Vtype'          =>  'INVOICE',
                      'VDate'          =>  $createdate,
                      'COAID'          =>  $bankcoaid,
                      'Narration'      =>  'Paid amount for customer  '.$cusifo->customer_name,
                      'Debit'          =>  $this->input->post('grand_total_price',TRUE),
                      'Credit'         =>  0,
                      'IsPosted'       =>  1,
                      'CreateBy'       =>  $createby,
                      'CreateDate'     =>  $createdate,
                      'IsAppove'       =>  1
                    ); 

                    $banksummary = array(
                      'date'          =>  $createdate,
                      'ac_type'       => 'Debit(+)',
                      'bank_id'       =>  $this->input->post('bank_id',TRUE),
                      'description'   => 'product sale',
                      'deposite_id'   =>  $invoice_id,
                      'dr'            =>  $this->input->post('grand_total_price',TRUE),
                      'cr'            =>  null,
                      'ammount'       =>  $this->input->post('grand_total_price',TRUE),
                      'status'        =>  1
                    
                    );
                    //Inventory credit
                    $coscr = array(
                      'VNo'            => $invoice_id,
                      'Vtype'          => 'INVOICE',
                      'VDate'          => $createdate,
                      'COAID'          => 10107,
                      'Narration'      => 'Inventory credit For Invoice No'.$invoice_id,
                      'Debit'          => 0,
                      'Credit'         => $sumval,//purchase price asbe
                      'IsPosted'       => 1,
                      'CreateBy'       => $createby,
                      'CreateDate'     => $createdate,
                      'IsAppove'       => 1
                    ); 

                    //Customer debit for Product Value
                    $cosdr = array(
                      'VNo'            => $invoice_id,
                      'Vtype'          => 'INVOICE',
                      'VDate'          => $createdate,
                      'COAID'          => $customer_headcode,
                      'Narration'      => 'Customer debit For  '.$cusifo->customer_name,
                      'Debit'          => $this->input->post('grand_total_price',TRUE),
                      'Credit'         => 0,
                      'IsPosted'       => 1,
                      'CreateBy'       => $createby,
                      'CreateDate'     => $createdate,
                      'IsAppove'       => 1
                    ); 

                    $pro_sale_income = array(
                      'VNo'            => $invoice_id,
                      'Vtype'          => 'INVOICE',
                      'VDate'          => $createdate,
                      'COAID'          => 303,
                      'Narration'      => 'Sale Income For '.$cusifo->customer_name,
                      'Debit'          => 0,
                      'Credit'         => $this->input->post('grand_total_price',TRUE),
                      'IsPosted'       => 1,
                      'CreateBy'       => $createby,
                      'CreateDate'     => $createdate,
                      'IsAppove'       => 1
                    ); 

                    ///Customer credit for Paid Amount
                    $cuscredit = array(
                      'VNo'            =>  $invoice_id,
                      'Vtype'          =>  'INVOICE',
                      'VDate'          =>  $createdate,
                      'COAID'          =>  $customer_headcode,
                      'Narration'      =>  'Customer credit for Paid Amount For Customer '.$cusifo->customer_name,
                      'Debit'          =>  0,
                      'Credit'         =>  $this->input->post('grand_total_price',TRUE),
                      'IsPosted'       => 1,
                      'CreateBy'       => $createby,
                      'CreateDate'     => $createdate,
                      'IsAppove'       => 1
                    ); 

                    // for($j=0;$j<$num_column;$j++){
                    //   $taxfield = 'tax'.$j;
                    //   $taxvalue = 'total_tax'.$j;
                    //   $taxdata[$taxfield]=$this->input->post($taxvalue);
                    // }
                    $taxdata['customer_id'] = $customer_id;
                    $taxdata['date']        = (!empty($this->input->post('qdate',TRUE))?$this->input->post('qdate',TRUE):date('Y-m-d'));
                    $taxdata['relation_id'] = $invoice_id;
                    $taxdata['tax0'] = $taxend;
                            

                    if (!empty($quantity)) {
                        $this->db->insert('invoice', $datainvmain);
                        $this->db->insert('acc_transaction',$coscr);
                        $this->db->insert('acc_transaction',$cosdr);  
                        $this->db->insert('acc_transaction',$pro_sale_income);
                        $this->db->insert('acc_transaction',$cuscredit);
                        $this->db->insert('tax_collection',$taxdata);
                        if($this->input->post('paytype',TRUE) == 2){
                            $this->db->insert('acc_transaction',$bankc);
                            $this->db->insert('bank_summary',$banksummary); 
                        }
                        if($this->input->post('paytype',TRUE) == 1){
                            $this->db->insert('acc_transaction',$cc);
                        }
                    }
                        
                    $rate                = $this->input->post('product_rate',TRUE);
                    $p_id                = $this->input->post('product_id',TRUE);
                    $total_amount        = $this->input->post('total_price',TRUE);
                    $discount_rate       = $this->input->post('discount_amount',TRUE);
                    $discount_per        = $this->input->post('discount',TRUE);
                    $tax_amount          = $this->input->post('tax',TRUE);
                    $invoice_description = $this->input->post('desc',TRUE);
                    $serial_n            = $this->input->post('serial_no',TRUE);
                    $supplier_price      = $this->input->post('supplier_price',TRUE);

                    for ($i = 0, $n = count($p_id); $i < $n; $i++) {
                        $product_quantity = $quantity[$i];
                        $product_rate = $rate[$i];
                        $product_id = $p_id[$i];
                        $serial_no  = (!empty($serial_n[$i])?$serial_n[$i]:null);
                        $total_price = $total_amount[$i];
                        $supplier_rate = $supplier_price[$i];
                        $disper = $discount_per[$i];
                        $discount = is_numeric($product_quantity) * is_numeric($product_rate) * is_numeric($disper) / 100;
                        $tax = $tax_amount[$i];
                        $description = '';
                        // $description = $invoice_description[$i];
                        $invoiceDetails = array(
                            'invoice_details_id' => $this->generator(15),
                            'invoice_id'         => $invoice_id,
                            'product_id'         => $product_id,
                            'serial_no'          => $serial_no,
                            'quantity'           => $product_quantity,
                            'rate'               => $product_rate,
                            'discount'           => $discount,
                            'description'        => $description,
                            'discount_per'       => $disper,
                            'tax'                => $tax,
                            'paid_amount'        => $this->input->post('grand_total_price',TRUE),
                            'due_amount'         => '',
                            'supplier_rate'      => $supplier_rate,
                            'total_price'        => $total_price,
                            'status'             => 1
                        );
                        if (!empty($product_quantity)) {
                            $this->db->insert('invoice_details', $invoiceDetails);
                        }
                    }
                        if (!empty($quantity)) {
                        
                            if($mailsetting[0]['isinvoice']==1){
                                $mail = $this->invoice_pdf_generate($invoice_id);
                                if($mail == 0){
                                  $data['message2'] = $this->session->set_userdata(array('error_message' => display('please_config_your_mail_setting')));
                                }
                            }
                        }
                          ##==== SERVICE PART START ====###
                          //service invoice
                        $serviceinvoice = array(
                          'employee_id'     => '',
                          'customer_id'     => $customer_id,
                          'date'            => (!empty($this->input->post('qdate',TRUE))?$this->input->post('qdate',TRUE):date('Y-m-d')),
                          'total_amount'    => $this->input->post('grand_total_service_amount',TRUE),
                          // 'total_tax'       => $this->input->post('total_service_tax',TRUE),
                          'voucher_no'      => $invoice_id,
                          'details'         => (!empty($this->input->post('details',TRUE))?$this->input->post('details',TRUE):'Service From Quotation'),
                          'invoice_discount'=> $this->input->post('service_discount',TRUE),
                          'total_discount'  => $this->input->post('totalServiceDicount',TRUE),
                          'shipping_cost'   => '',
                          'paid_amount'     => $this->input->post('grand_total_service_amount',TRUE),
                          'due_amount'      => 0,
                          'previous'        => '',   
                          );
                
                        $cashinhandforservicedebit = array(
                          'VNo'            =>  $invoice_id,
                          'Vtype'          =>  'SERVICE',
                          'VDate'          =>  $createdate,
                          'COAID'          =>  1020101,
                          'Narration'      =>  'Cash in Hand For SERVICE No'.$invoice_id,
                          'Debit'          =>  $this->input->post('grand_total_service_amount',TRUE),
                          'Credit'         =>  0,
                          'IsPosted'       =>  1,
                          'CreateBy'       =>  $createby,
                          'CreateDate'     =>  $createdate,
                          'IsAppove'       =>  1
                        );

                        $service_income = array(
                          'VNo'            =>  $invoice_id,
                          'Vtype'          =>  'SERVICE',
                          'VDate'          =>  $createdate,
                          'COAID'          =>  304,
                          'Narration'      =>  'Service Income For SERVICE No'.$invoice_id,
                          'Debit'          =>  0,
                          'Credit'         =>  $this->input->post('grand_total_service_amount',TRUE),
                          'IsPosted'       =>  1,
                          'CreateBy'       =>  $createby,
                          'CreateDate'     =>  $createdate,
                          'IsAppove'       =>  1
                        );

                        $cosdr_service = array(
                          'VNo'            =>  $invoice_id,
                          'Vtype'          =>  'SERVICE',
                          'VDate'          =>  $createdate,
                          'COAID'          =>  $customer_headcode,
                          'Narration'      =>  'Customer debit For service No'.$invoice_id,
                          'Debit'          =>  $this->input->post('grand_total_service_amount',TRUE),
                          'Credit'         =>  0,
                          'IsPosted'       => 1,
                          'CreateBy'       => $createby,
                          'CreateDate'     => $createdate,
                          'IsAppove'       => 1
                        ); 
                        
                        //Customer credit for Paid Amount
                        $coscr_service = array(
                          'VNo'            =>  $invoice_id,
                          'Vtype'          =>  'SERVICE',
                          'VDate'          =>  $createdate,
                          'COAID'          =>  $customer_headcode,
                          'Narration'      =>  'Customer credit for Paid Amount For Service No'.$invoice_id,
                          'Debit'          =>  0,
                          'Credit'         =>  $this->input->post('grand_total_service_amount',TRUE),
                          'IsPosted'       => 1,
                          'CreateBy'       => $createby,
                          'CreateDate'     => $createdate,
                          'IsAppove'       => 1
                        ); 

                        $bankdebitforservice = array(
                          'VNo'            =>  $invoice_id,
                          'Vtype'          =>  'INVOICE',
                          'VDate'          =>  $createdate,
                          'COAID'          =>  $bankcoaid,
                          'Narration'      =>  'Paid amount for customer  '.$cusifo->customer_name,
                          'Debit'          =>  $this->input->post('grand_total_service_amount',TRUE),
                          'Credit'         =>  0,
                          'IsPosted'       =>  1,
                          'CreateBy'       =>  $createby,
                          'CreateDate'     =>  $createdate,
                          'IsAppove'       =>  1
                        ); 


                        $banksummaryservice = array(
                          'date'          =>  $createdate,
                          'ac_type'       =>  'Debit(+)',
                          'bank_id'       =>  $this->input->post('bank_id',TRUE),
                          'description'   =>  'product sale',
                          'deposite_id'   =>  $invoice_id,
                          'dr'            =>  $this->input->post('grand_total_service_amount',TRUE),
                          'cr'            =>  null,
                          'ammount'       =>  $this->input->post('grand_total_service_amount',TRUE),
                          'status'        =>  1
                        );
                            if (!empty($squantity)) {
                                $this->db->insert('service_invoice', $serviceinvoice);
                                $this->db->insert('acc_transaction', $service_income);
                                $this->db->insert('acc_transaction',$cosdr_service);
                                $this->db->insert('acc_transaction', $coscr_service);
                                if($this->input->post('paytype',TRUE) == 1){
                                    $this->db->insert('acc_transaction', $cashinhandforservicedebit);
                                } 
                                if($this->input->post('paytype',TRUE) == 2){
                                    $this->db->insert('acc_transaction', $bankdebitforservice);
                                    $this->db->insert('bank_summary', $banksummaryservice);
                                }
                            }
  
                             if (!empty($squantity)) {
                                $this->db->insert('service_invoice', $serviceinvoice);
                            }
                            $qty                 = $this->input->post('service_quantity',TRUE);
                            $srate               = $this->input->post('service_rate',TRUE);
                            $serv_id             = $this->input->post('service_id',TRUE);
                            $total_serviceamount = $this->input->post('total_service_amount',TRUE);
                            $sdiscount_rate      = $this->input->post('sdiscount_amount',TRUE);
                            $sdiscount_per       = $this->input->post('sdiscount',TRUE);
                            $tax_amount          = $this->input->post('stax',TRUE);
                            $invoice_description = $this->input->post('details',TRUE);

                            for ($i = 0, $n   = count($serv_id); $i < $n; $i++) {
                                $service_qty  = $qty[$i];
                                $service_rate = $srate[$i];
                                $service_id   = $serv_id[$i];
                                $total_amount = $total_serviceamount[$i];
                                $disper       = $sdiscount_per[$i];
                                $disamnt      = $sdiscount_rate[$i];
                                
                                $service_details = array(
                                  'service_inv_id'     => $invoice_id,
                                  'service_id'         => $service_id,
                                  'qty'                => $service_qty,
                                  'charge'             => $service_rate,
                                  'discount'           => $disper,
                                  'discount_amount'    => $disamnt,
                                  'total'              => $total_amount,
                                );
                                if (!empty($service_qty)) {
                                    $this->db->insert('service_invoice_details', $service_details);
                                }
                            }
                            if (!empty($squantity)) {
                                if($mailsetting[0]['isservice']==1){
                                    $mail = $this->service_pdf_generate($invoice_id);
                                    if($mail == 0){
                                        $this->session->set_userdata(array('error_message' => display('please_config_your_mail_setting')));
                                    }
                                }
                            }

                            // for($j=0;$j<$num_column;$j++){
                            //   $taxfield = 'tax'.$j;
                            //   $taxvalue = 'total_service_tax'.$j;
                            //   $taxdata[$taxfield] = $this->input->post($taxvalue);
                            // }
                            // $taxdata['customer_id'] = $customer_id;
                            // $taxdata['date']        = (!empty($this->input->post('qdate',TRUE))?$this->input->post('qdate',TRUE):date('Y-m-d'));
                            // $taxdata['relation_id'] = $invoice_id;
                            // $this->db->insert('tax_collection',$taxdata);
                        $this->session->set_userdata(array('message' => display('successfully_added')));
                        redirect(base_url('Cinvoice_quot/manage_invoice_list'));
                }else{
                    $this->session->set_userdata('inv',"Value Invoice don't more big from value Invoice Avalable");
                    redirect(base_url('Cinvoice_quot/manage_invoice_list'));
                }
                
            }
            else{
                    $this->session->set_userdata('inv',"Sorry Your Type TOP FALSE! Please Checked Your Type Invoice And Try Again.");
                    redirect(base_url('Cinvoice_quot/manage_invoice_list'));
            } 
        }else{
            if ($this->input->post('type_top',true)=="DP" || $this->input->post('type_top',true)=="T1" || $this->input->post('type_top',true)=="full"){
                
                $cekqtt = $this->Quotation_model->checkQtt($this->input->post('quotation_id',TRUE));
                if ($cekqtt[0]['tot_inv'] !=null){
                    $Avalabel= $cekqtt[0]['tot_quot']-$cekqtt[0]['tot_inv'];
                }else{
                     $Avalabel= $cekqtt[0]['tot_quot'];
                }

                if ($Avalabel >= $this->input->post('grand_total_price',TRUE)){
                    $mailsetting  = $this->db->select('*')->from('email_config')->get()->result_array(); 
                    $quotation_id = $this->input->post('quotation_id',TRUE);
                    $due_date     = $this->input->post('due_date',TRUE);
                    $customer_id  = $this->input->post('customer_id',TRUE);
                    $product_id   = $this->input->post('product_id',TRUE);
                    $invoice_id   = $this->generator(10);
                    $invoice_id   = strtoupper($invoice_id);
                    $createby     = $this->session->userdata('user_id');
                    $createdate   = date('Y-m-d H:i:s');
                    $quantity     = $this->input->post('product_quantity',TRUE);
                    $squantity    = $this->input->post('service_quantity',TRUE);
                    $typetop      = $this->input->post('type_top',true);
                    $persent      = $this->input->post('persent',true);
                    $ppn          = $this->input->post('ppn',true);
                    $tablecolumn  = $this->db->list_fields('tax_collection');
                    $num_column   = count($tablecolumn)-4;

                    $cusifo  = $this->db->select('*')->from('customer_information')->where('customer_id',$customer_id)->get()->row();
                    $headn   = $customer_id.'-'.$cusifo->customer_name;
                    $coainfo = $this->db->select('*')->from('acc_coa')->where('HeadName',$headn)->get()->row();
                    $customer_headcode = $coainfo->HeadCode;
                    $bank_id = $this->input->post('bank_id',TRUE);
                    if(!empty($bank_id)){
                        $bankname = $this->db->select('bank_name')->from('bank_add')->where('bank_id',$bank_id)->get()->row()->bank_name;

                        $bankcoaid = $this->db->select('HeadCode')->from('acc_coa')->where('HeadName',$bankname)->get()->row()->HeadCode;
                    }else{
                      $bankcoaid='';
                    }
                    $quotdata = array(
                        'status'  => 2,
                      );
                    $this->db->where('quotation_id', $quotation_id);
                    $this->db->update('quotation',$quotdata);

                    $transection_id = $this->auth->generator(15);

                    $checkInv      = $this->db->from('invoice')->where('quotation_id',$quotation_id)->get()->result_array();
                    $taxend      = $this->input->post('grand_total_price',TRUE) * $ppn/100;
                    $datainvmain = array(
                      'invoice_id'        => $invoice_id,
                      'customer_id'       => $customer_id,
                      'quotation_id'      => $quotation_id,
                      'date'              => (!empty($this->input->post('qdate',TRUE))?$this->input->post('qdate',TRUE):date('Y-m-d')),
                      'total_amount'      => $this->input->post('grand_total_price',TRUE),
                      'total_tax'         => $taxend,
                      // 'total_tax'         => $this->input->post('total_tax',TRUE),
                      'invoice'           => $this->number_generator(),
                      'invoice_details'   => (!empty($this->input->post('details',TRUE))?$this->input->post('details',TRUE):''),
                      'invoice_discount'  => $this->input->post('invoice_discount',TRUE),
                      'total_discount'    => $this->input->post('total_discount',TRUE),
                      'prevous_due'       => '',
                      'shipping_cost'     => '',
                      'sales_by'          => $this->session->userdata('user_id'),
                      'status'            => 1,
                      'payment_type'      =>  $this->input->post('paytype',TRUE),
                      'bank_id'           =>  $this->input->post('bank_id',TRUE),
                      'duedate'           => $due_date,
                      'type_top'          => $typetop,
                      'persent'           => $persent,
                      'ppn'           => $ppn,
                    );

                    $prinfo  = $this->db->select('product_id,Avg(rate) as product_rate')->from('product_purchase_details')->where_in('product_id',$product_id)->group_by('product_id')->get()->result(); 
                    $purchase_ave = [];
                    $i=0;
                    foreach ($prinfo as $avg) {
                      $purchase_ave [] =  $avg->product_rate*$quantity[$i];
                      $i++;
                    }
                    $sumval = array_sum($purchase_ave);

                    $cc = array(
                      'VNo'            =>  $invoice_id,
                      'Vtype'          =>  'INVOICE',
                      'VDate'          =>  $createdate,
                      'COAID'          =>  1020101,
                      'Narration'      =>  'Cash in Hand in Sale for '.$cusifo->customer_name,
                      'Debit'          =>  $this->input->post('grand_total_price',TRUE),
                      'Credit'         =>  0,
                      'IsPosted'       =>  1,
                      'CreateBy'       =>  $createby,
                      'CreateDate'     =>  $createdate,
                      'IsAppove'       =>  1
                    ); 

                    // bank ledger
                    $bankc = array(
                      'VNo'            =>  $invoice_id,
                      'Vtype'          =>  'INVOICE',
                      'VDate'          =>  $createdate,
                      'COAID'          =>  $bankcoaid,
                      'Narration'      =>  'Paid amount for customer  '.$cusifo->customer_name,
                      'Debit'          =>  $this->input->post('grand_total_price',TRUE),
                      'Credit'         =>  0,
                      'IsPosted'       =>  1,
                      'CreateBy'       =>  $createby,
                      'CreateDate'     =>  $createdate,
                      'IsAppove'       =>  1
                    ); 

                    $banksummary = array(
                      'date'          =>  $createdate,
                      'ac_type'       => 'Debit(+)',
                      'bank_id'       =>  $this->input->post('bank_id',TRUE),
                      'description'   => 'product sale',
                      'deposite_id'   =>  $invoice_id,
                      'dr'            =>  $this->input->post('grand_total_price',TRUE),
                      'cr'            =>  null,
                      'ammount'       =>  $this->input->post('grand_total_price',TRUE),
                      'status'        =>  1
                    
                    );
                    //Inventory credit
                    $coscr = array(
                      'VNo'            => $invoice_id,
                      'Vtype'          => 'INVOICE',
                      'VDate'          => $createdate,
                      'COAID'          => 10107,
                      'Narration'      => 'Inventory credit For Invoice No'.$invoice_id,
                      'Debit'          => 0,
                      'Credit'         => $sumval,//purchase price asbe
                      'IsPosted'       => 1,
                      'CreateBy'       => $createby,
                      'CreateDate'     => $createdate,
                      'IsAppove'       => 1
                    ); 

                    //Customer debit for Product Value
                    $cosdr = array(
                      'VNo'            => $invoice_id,
                      'Vtype'          => 'INVOICE',
                      'VDate'          => $createdate,
                      'COAID'          => $customer_headcode,
                      'Narration'      => 'Customer debit For  '.$cusifo->customer_name,
                      'Debit'          => $this->input->post('grand_total_price',TRUE),
                      'Credit'         => 0,
                      'IsPosted'       => 1,
                      'CreateBy'       => $createby,
                      'CreateDate'     => $createdate,
                      'IsAppove'       => 1
                    ); 

                    $pro_sale_income = array(
                      'VNo'            => $invoice_id,
                      'Vtype'          => 'INVOICE',
                      'VDate'          => $createdate,
                      'COAID'          => 303,
                      'Narration'      => 'Sale Income For '.$cusifo->customer_name,
                      'Debit'          => 0,
                      'Credit'         => $this->input->post('grand_total_price',TRUE),
                      'IsPosted'       => 1,
                      'CreateBy'       => $createby,
                      'CreateDate'     => $createdate,
                      'IsAppove'       => 1
                    ); 

                    ///Customer credit for Paid Amount
                    $cuscredit = array(
                      'VNo'            =>  $invoice_id,
                      'Vtype'          =>  'INVOICE',
                      'VDate'          =>  $createdate,
                      'COAID'          =>  $customer_headcode,
                      'Narration'      =>  'Customer credit for Paid Amount For Customer '.$cusifo->customer_name,
                      'Debit'          =>  0,
                      'Credit'         =>  $this->input->post('grand_total_price',TRUE),
                      'IsPosted'       => 1,
                      'CreateBy'       => $createby,
                      'CreateDate'     => $createdate,
                      'IsAppove'       => 1
                    ); 

                    // for($j=0;$j<$num_column;$j++){
                    //   $taxfield = 'tax'.$j;
                    //   $taxvalue = 'total_tax'.$j;
                    //   $taxdata[$taxfield]=$this->input->post($taxvalue);
                    // }
                    $taxdata['customer_id'] = $customer_id;
                    $taxdata['date']        = (!empty($this->input->post('qdate',TRUE))?$this->input->post('qdate',TRUE):date('Y-m-d'));
                    $taxdata['relation_id'] = $invoice_id;
                    $taxdata['tax0'] = $taxend;
                            

                    if (!empty($quantity)) {
                        $this->db->insert('invoice', $datainvmain);
                        $this->db->insert('acc_transaction',$coscr);
                        $this->db->insert('acc_transaction',$cosdr);  
                        $this->db->insert('acc_transaction',$pro_sale_income);
                        $this->db->insert('acc_transaction',$cuscredit);
                        $this->db->insert('tax_collection',$taxdata);
                        if($this->input->post('paytype',TRUE) == 2){
                            $this->db->insert('acc_transaction',$bankc);
                            $this->db->insert('bank_summary',$banksummary); 
                        }
                        if($this->input->post('paytype',TRUE) == 1){
                            $this->db->insert('acc_transaction',$cc);
                        }
                    }
                        
                    $rate                = $this->input->post('product_rate',TRUE);
                    $p_id                = $this->input->post('product_id',TRUE);
                    $total_amount        = $this->input->post('total_price',TRUE);
                    $discount_rate       = $this->input->post('discount_amount',TRUE);
                    $discount_per        = $this->input->post('discount',TRUE);
                    $tax_amount          = $this->input->post('tax',TRUE);
                    $invoice_description = $this->input->post('desc',TRUE);
                    $serial_n            = $this->input->post('serial_no',TRUE);
                    $supplier_price      = $this->input->post('supplier_price',TRUE);

                    for ($i = 0, $n = count($p_id); $i < $n; $i++) {
                        $product_quantity = $quantity[$i];
                        $product_rate = $rate[$i];
                        $product_id = $p_id[$i];
                        $serial_no  = (!empty($serial_n[$i])?$serial_n[$i]:null);
                        $total_price = $total_amount[$i];
                        $supplier_rate = $supplier_price[$i];
                        $disper = $discount_per[$i];
                        $discount = is_numeric($product_quantity) * is_numeric($product_rate) * is_numeric($disper) / 100;
                        $tax = 0;
                        // $description = $invoice_description[$i];
                        $invoiceDetails = array(
                            'invoice_details_id' => $this->generator(15),
                            'invoice_id'         => $invoice_id,
                            'product_id'         => $product_id,
                            'serial_no'          => $serial_no,
                            'quantity'           => $product_quantity,
                            'rate'               => $product_rate,
                            'discount'           => $discount,
                            // 'description'        => $description,
                            'discount_per'       => $disper,
                            'tax'                => $tax,
                            'paid_amount'        => $this->input->post('grand_total_price',TRUE),
                            'due_amount'         => '',
                            'supplier_rate'      => $supplier_rate,
                            'total_price'        => $total_price,
                            'status'             => 1
                        );
                        if (!empty($product_quantity)) {
                            $this->db->insert('invoice_details', $invoiceDetails);
                        }
                    }
                    if (!empty($quantity)) {
                    
                        if($mailsetting[0]['isinvoice']==1){
                            $mail = $this->invoice_pdf_generate($invoice_id);
                            if($mail == 0){
                              $data['message2'] = $this->session->set_userdata(array('error_message' => display('please_config_your_mail_setting')));
                            }
                        }
                    }
                          ##==== SERVICE PART START ====###
                          //service invoice
                        $serviceinvoice = array(
                          'employee_id'     => '',
                          'customer_id'     => $customer_id,
                          'date'            => (!empty($this->input->post('qdate',TRUE))?$this->input->post('qdate',TRUE):date('Y-m-d')),
                          'total_amount'    => $this->input->post('grand_total_service_amount',TRUE),
                          'total_tax'       => $this->input->post('total_service_tax',TRUE),
                          'voucher_no'      => $invoice_id,
                          'details'         => (!empty($this->input->post('details',TRUE))?$this->input->post('details',TRUE):'Service From Quotation'),
                          'invoice_discount'=> $this->input->post('service_discount',TRUE),
                          'total_discount'  => $this->input->post('totalServiceDicount',TRUE),
                          'shipping_cost'   => '',
                          'paid_amount'     => $this->input->post('grand_total_service_amount',TRUE),
                          'due_amount'      => 0,
                          'previous'        => '',   
                          );
                
                        $cashinhandforservicedebit = array(
                          'VNo'            =>  $invoice_id,
                          'Vtype'          =>  'SERVICE',
                          'VDate'          =>  $createdate,
                          'COAID'          =>  1020101,
                          'Narration'      =>  'Cash in Hand For SERVICE No'.$invoice_id,
                          'Debit'          =>  $this->input->post('grand_total_service_amount',TRUE),
                          'Credit'         =>  0,
                          'IsPosted'       =>  1,
                          'CreateBy'       =>  $createby,
                          'CreateDate'     =>  $createdate,
                          'IsAppove'       =>  1
                        );

                        $service_income = array(
                          'VNo'            =>  $invoice_id,
                          'Vtype'          =>  'SERVICE',
                          'VDate'          =>  $createdate,
                          'COAID'          =>  304,
                          'Narration'      =>  'Service Income For SERVICE No'.$invoice_id,
                          'Debit'          =>  0,
                          'Credit'         =>  $this->input->post('grand_total_service_amount',TRUE),
                          'IsPosted'       =>  1,
                          'CreateBy'       =>  $createby,
                          'CreateDate'     =>  $createdate,
                          'IsAppove'       =>  1
                        );

                        $cosdr_service = array(
                          'VNo'            =>  $invoice_id,
                          'Vtype'          =>  'SERVICE',
                          'VDate'          =>  $createdate,
                          'COAID'          =>  $customer_headcode,
                          'Narration'      =>  'Customer debit For service No'.$invoice_id,
                          'Debit'          =>  $this->input->post('grand_total_service_amount',TRUE),
                          'Credit'         =>  0,
                          'IsPosted'       => 1,
                          'CreateBy'       => $createby,
                          'CreateDate'     => $createdate,
                          'IsAppove'       => 1
                        ); 
                        
                        //Customer credit for Paid Amount
                        $coscr_service = array(
                          'VNo'            =>  $invoice_id,
                          'Vtype'          =>  'SERVICE',
                          'VDate'          =>  $createdate,
                          'COAID'          =>  $customer_headcode,
                          'Narration'      =>  'Customer credit for Paid Amount For Service No'.$invoice_id,
                          'Debit'          =>  0,
                          'Credit'         =>  $this->input->post('grand_total_service_amount',TRUE),
                          'IsPosted'       => 1,
                          'CreateBy'       => $createby,
                          'CreateDate'     => $createdate,
                          'IsAppove'       => 1
                        ); 

                        $bankdebitforservice = array(
                          'VNo'            =>  $invoice_id,
                          'Vtype'          =>  'INVOICE',
                          'VDate'          =>  $createdate,
                          'COAID'          =>  $bankcoaid,
                          'Narration'      =>  'Paid amount for customer  '.$cusifo->customer_name,
                          'Debit'          =>  $this->input->post('grand_total_service_amount',TRUE),
                          'Credit'         =>  0,
                          'IsPosted'       =>  1,
                          'CreateBy'       =>  $createby,
                          'CreateDate'     =>  $createdate,
                          'IsAppove'       =>  1
                        ); 


                        $banksummaryservice = array(
                          'date'          =>  $createdate,
                          'ac_type'       =>  'Debit(+)',
                          'bank_id'       =>  $this->input->post('bank_id',TRUE),
                          'description'   =>  'product sale',
                          'deposite_id'   =>  $invoice_id,
                          'dr'            =>  $this->input->post('grand_total_service_amount',TRUE),
                          'cr'            =>  null,
                          'ammount'       =>  $this->input->post('grand_total_service_amount',TRUE),
                          'status'        =>  1
                        );
                        if ($checkInv ==null):
                             if (!empty($squantity)) {
                                $this->db->insert('acc_transaction', $service_income);
                                $this->db->insert('acc_transaction',$cosdr_service);
                                $this->db->insert('acc_transaction', $coscr_service);
                                if($this->input->post('paytype',TRUE) == 1){
                                    $this->db->insert('acc_transaction', $cashinhandforservicedebit);
                                } 
                                if($this->input->post('paytype',TRUE) == 2){
                                    $this->db->insert('acc_transaction', $bankdebitforservice);
                                    $this->db->insert('bank_summary', $banksummaryservice);
                                }
                            }
                        endif;
                        if (!empty($squantity)) {
                            $this->db->insert('service_invoice', $serviceinvoice);
                        }
                            $qty                 = $this->input->post('service_quantity',TRUE);
                            $srate               = $this->input->post('service_rate',TRUE);
                            $serv_id             = $this->input->post('service_id',TRUE);
                            $total_serviceamount = $this->input->post('total_service_amount',TRUE);
                            $sdiscount_rate      = $this->input->post('sdiscount_amount',TRUE);
                            $sdiscount_per       = $this->input->post('sdiscount',TRUE);
                            $tax_amount          = $this->input->post('stax',TRUE);
                            $invoice_description = $this->input->post('details',TRUE);

                        for ($i = 0, $n   = count($serv_id); $i < $n; $i++) {
                            $service_qty  = $qty[$i];
                            $service_rate = $srate[$i];
                            $service_id   = $serv_id[$i];
                            $total_amount = $total_serviceamount[$i];
                            $disper       = $sdiscount_per[$i];
                            $disamnt      = $sdiscount_rate[$i];
                            
                            $service_details = array(
                              'service_inv_id'     => $invoice_id,
                              'service_id'         => $service_id,
                              'qty'                => $service_qty,
                              'charge'             => $service_rate,
                              'discount'           => $disper,
                              'discount_amount'    => $disamnt,
                              'total'              => $total_amount,
                            );
                            if (!empty($service_qty)) {
                                $this->db->insert('service_invoice_details', $service_details);
                            }
                        }
                        if (!empty($squantity)) {
                            if($mailsetting[0]['isservice']==1){
                                $mail = $this->service_pdf_generate($invoice_id);
                                if($mail == 0){
                                    $this->session->set_userdata(array('error_message' => display('please_config_your_mail_setting')));
                                }
                            }
                        }

                        // for($j=0;$j<$num_column;$j++){
                        //   $taxfield = 'tax'.$j;
                        //   $taxvalue = 'total_service_tax'.$j;
                        //   $taxdata[$taxfield] = $this->input->post($taxvalue);
                        // }
                        // $taxdata['customer_id'] = $customer_id;
                        // $taxdata['date']        = (!empty($this->input->post('qdate',TRUE))?$this->input->post('qdate',TRUE):date('Y-m-d'));
                        // $taxdata['relation_id'] = $invoice_id;
                        // $this->db->insert('tax_collection',$taxdata);
                        $this->session->set_userdata(array('message' => display('successfully_added')));
                        redirect(base_url('Cinvoice_quot/manage_invoice_list'));
                    }else{
                        $this->session->set_userdata('inv',"Value Invoice don't more big from value Invoice Avalable");
                        redirect(base_url('Cinvoice_quot/manage_invoice_list'));
                    }

            }else{
                $this->session->set_userdata('inv',"Your First ORDER Type TOP FALSE!, Please Checked Your ORDER Type Invoice");
                redirect(base_url('Cinvoice_quot/manage_invoice_list'));
            }
        }
       
  }
  public function editIvoice($inv)
  {
      $this->load->model();
  }
  //  public function update_invoice()
  //  {
  //    $dp = $this->input->post('');
  //    $dp = $this->input->post();
  //    $dp = $this->input->post();
  //  }
   public function view_invoice_Quotation($quotID)
   {
     $this->load->model('Quotation_model');
     $data['listInv'] = $this->Quotation_model->DataListInv($quotID);
     $content = $this->parser->parse('invoice_quotation/invoice_quot_list', $data, true);
     $this->template->full_admin_html_view($content);
   }
   public function detailInvoice($invID)
   {
        $this->load->model('Quotation_model');
        // $check        = $this->Quotation_model->checkInvPrint($invID);
        $data['vinv']       = $this->Quotation_model->DetailInv($invID);
        $data['DP']         = $this->Quotation_model->checkDP($invID);
        $data['serv']       = $this->Quotation_model->dtlService($invID);
        $data['amount']     = $this->Quotation_model->getTotinv($invID);
        $data['amoutserv']  = $this->Quotation_model->mstService($invID);
        $data['isinv']      = $this->Quotation_model->CheckIsInv($data['vinv'][0]['quotation_id']); 
        $data['count']      = $this->Quotation_model->CountIsInv($data['vinv'][0]['quotation_id']);
        $count = COUNT($data['vinv']); 
        $cktype = $this->Quotation_model->getTypeTop($invID);
        if($cktype['type_top']=="DP"|| $cktype['type_top'] =="Pelunasan"||$cktype['type_top'] =="full")
            {
              if ($data['serv'] ==null){
                // $this->load->view('invoice_quotation/print_invoice',$data);
                 $this->print('invoice_quotation/print_invoice',$data);
                
              }else{
                //  $this->load->view('invoice_quotation/print_invoice_onservice',$data);
                 $this->print('invoice_quotation/print_invoice_onservice',$data);
              }
            }
        elseif(substr($cktype['type_top'],0,1)=="T"){
            if ($count <= 1){
                // $this->load->view('invoice_quotation/print_invoice_term_single',$data);
                 $this->print('invoice_quotation/print_invoice_term_single',$data);
            }else{
                // $this->load->view('invoice_quotation/print_invoice_term_multi',$data);
                $this->print('invoice_quotation/print_invoice_term_multi',$data);
            }
        }else{
            return false;
        }
    
   }
   function print($view,$data){
     $this->load->library('pdf');
        
        // filename dari pdf ketika didownload
        $file_pdf = 'INVOICE';
        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        $orientation = 'portrait';
        
        
		$html =  $this->load->view($view, $data,true);	    
       
        // run dompdf
        $this->pdf->generate($html, $file_pdf,$paper,$orientation,true);
   }
   public function getListBank()
   {
       $this->load->model('Quotation_model');
       $data = $this->Quotation_model->getBankList();
       return json_encode($data);
   }
   public function generator($lenth) {
    $number = array("1", "2", "3", "4", "5", "6", "7", "8", "9");

    for ($i = 0; $i < $lenth; $i++) {
        $rand_value = rand(0, 8);
        $rand_number = $number["$rand_value"];

        if (empty($con)) {
            $con = $rand_number;
        } else {
            $con = "$con" . "$rand_number";
        }
      }
      return $con;
  }
  public function number_generator() {
    $this->db->select_max('invoice', 'invoice_no');
    $query = $this->db->get('invoice');
    $result = $query->result_array();
    $invoice_no = $result[0]['invoice_no'];
    if ($invoice_no != '') {
        $invoice_no = $invoice_no + 1;
    } else {
        $invoice_no = 1000;
    }
    return $invoice_no;
  }
  public function reportPeriodeInvoice()
  {
      $this->load->model('Invoices');
      $data['listInv'] = $this->Invoices->listinvreport();
      $data['company'] = $this->Invoices->Companyprofile();
      $data['logo'] = $this->Invoices->getLogo();
      $content = $this->parser->parse('report/periode_invoice',$data,true);
      $this->template->full_admin_html_view($content);
  }
  public function periodInv()
  {
    $this->load->model('Invoices');
    $start  = $this->input->post('start');
    $end    = $this->input->post('end');
    $data   = $this->Invoices->getPeriodeInv($start,$end);
    echo json_encode($data);
  }
}

