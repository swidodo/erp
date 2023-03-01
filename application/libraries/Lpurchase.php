<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lpurchase {

    //Purchase add form
    public function purchase_add_form() {
        $CI = & get_instance();
        $CI->load->model('Purchases');
        $CI->load->model('Web_settings');
        $all_supplier = $CI->Purchases->select_all_supplier();
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $bank_list        = $CI->Web_settings->bank_list();
        $data = array(
            'title'         => display('add_purchase'),
            'all_supplier'  => $all_supplier,
            'invoice_no'    => $CI->auth->generator(10),
            'discount_type' => $currency_details[0]['discount_type'],
            'bank_list'     => $bank_list,
        );
        $purchaseForm = $CI->parser->parse('purchase/add_purchase_form', $data, true);
        return $purchaseForm;
    }


    public function purchase_order_add_form() {
        $CI = & get_instance();
        $CI->load->model('Purchases');
        $CI->load->model('Web_settings');
        $all_supplier = $CI->Purchases->select_all_supplier();
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data = array(
            'title'         => 'Tambah Purchase Order',
            'all_supplier'  => $all_supplier,
            'invoice_no'    => $CI->auth->generator(10),
            'discount_type' => $currency_details[0]['discount_type'],
        );
        $purchaseForm = $CI->parser->parse('purchase/add_po_form', $data, true);
        return $purchaseForm;
    }


    public function barangmasuk_add_form() {
        $CI = & get_instance();
        $CI->load->model('Purchases');
        $CI->load->model('Web_settings');
        $all_supplier = $CI->Purchases->select_all_supplier();
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data = array(
            'title'         => 'Tambah Barang Masuk',
            'all_supplier'  => $all_supplier,
            'invoice_no'    => $CI->auth->generator(10),
            'discount_type' => $currency_details[0]['discount_type'],
        );
        $purchaseForm = $CI->parser->parse('purchase/barangmasuk_add_form', $data, true);
        return $purchaseForm;
    }

    public function barangkeluar_add_form() {
            $CI = & get_instance();
            $CI->load->model('Purchases');
            $CI->load->model('Web_settings');
            $all_customer = $CI->Purchases->select_all_Customer();
            $currency_details = $CI->Web_settings->retrieve_setting_editdata();
            $data = array(
                'title'         => 'Add Product Out',
                'all_customer'  => $all_customer,
                'invoice_no'    => $CI->auth->generator(10),
                'discount_type' => $currency_details[0]['discount_type'],
            );
            $purchaseForm = $CI->parser->parse('purchase/barang_keluar_add_form', $data, true);
            return $purchaseForm;
        }

    // Retrieve Purchase List
    public function purchase_list() {
        $CI = & get_instance();
        $CI->load->model('Purchases');
        $CI->load->model('Web_settings');
        $CI->load->library('occational');
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $company_info = $CI->Purchases->retrieve_company();
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data = array(
            'title'          => display('manage_purchase'),
            'company_info'   => $company_info,
            'currency'       => $currency_details[0]['currency'],
            'total_purhcase' => $CI->Purchases->count_purchase(),
        );

        $purchaseList = $CI->parser->parse('purchase/purchase', $data, true);
        return $purchaseList;
    }


    // Retrieve Purchase List
    public function barang_masuk_list() {
        $CI = & get_instance();
        $CI->load->model('Purchases');
        $CI->load->model('Web_settings');
        $CI->load->library('occational');
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $company_info = $CI->Purchases->retrieve_company();
        $data = array(
            'title'          => 'Kelola Bukti Barang Masuk',
            'company_info'   => $company_info,
            'currency'       => $currency_details[0]['currency'],
            'total_purhcase' => $CI->Purchases->count_barang_masuk(),
        );

        $purchaseList = $CI->parser->parse('purchase/barang_masuk', $data, true);
        return $purchaseList;
    }
    public function barang_keluar_list() {
        $CI = & get_instance();
        $CI->load->model('Purchases');
        $CI->load->model('Web_settings');
        $CI->load->library('occational');
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $company_info = $CI->Purchases->retrieve_company();
        $data = array(
            'title'          => 'Kelola Bukti Barang Keluar',
            'company_info'   => $company_info,
            'currency'       => $currency_details[0]['currency'],
            'total_purhcase' => $CI->Purchases->count_barang_keluar(),
        );

        $purchaseList = $CI->parser->parse('purchase/barang_keluar_list', $data, true);
        return $purchaseList;
    }

    //purchase search by supplier
    public function purchase_search_supplier($supplier_id, $links, $per_page, $page) {
        $CI = & get_instance();
        $CI->load->model('Purchases');
        $CI->load->model('Web_settings');
        $CI->load->library('occational');
        $purchases_list = $CI->Purchases->purchase_search($supplier_id, $per_page, $page);
        if (!empty($purchases_list)) {
            $j = 0;
            foreach ($purchases_list as $k => $v) {
                $purchases_list[$k]['final_date'] = $CI->occational->dateConvert($purchases_list[$j]['purchase_date']);
                $j++;
            }

            $i = 0;
            foreach ($purchases_list as $k => $v) {
                $i++;
                $purchases_list[$k]['sl'] = $i + $CI->uri->segment(3);
            }
        }
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data = array(
            'title'          => display('manage_purchase'),
            'purchases_list' => $purchases_list,
            'links'          => $links,
            'currency'       => $currency_details[0]['currency'],
            'position'       => $currency_details[0]['currency_position'],
        );

        $purchaseList = $CI->parser->parse('purchase/purchase', $data, true);
        return $purchaseList;
    }

// purchase info by invoice no
    public function purchase_list_invoice_no($invoice_no) {
        $CI = & get_instance();
        $CI->load->model('Purchases');
        $CI->load->model('Web_settings');
        $CI->load->library('occational');
        $purchases_list = $CI->Purchases->purchase_list_invoice_id($invoice_no);
        if (!empty($purchases_list)) {
            $j = 0;
            foreach ($purchases_list as $k => $v) {
                $purchases_list[$k]['final_date'] = $CI->occational->dateConvert($purchases_list[$j]['purchase_date']);
                $j++;
            }

            $i = 0;
            foreach ($purchases_list as $k => $v) {
                $i++;
                $purchases_list[$k]['sl'] = $i + $CI->uri->segment(3);
            }
        }
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data = array(
            'title'          => display('manage_purchase'),
            'purchases_list' => $purchases_list,
            'links'          => '',
            'currency'       => $currency_details[0]['currency'],
            'position'       => $currency_details[0]['currency_position'],
        );

        $purchaseList = $CI->parser->parse('purchase/purchase', $data, true);
        return $purchaseList;
    }

    //Purchase Item By Search
    public function purchase_by_search($supplier_id) {
        $CI = & get_instance();
        $CI->load->model('Purchases');
        $CI->load->library('occational');
        $purchases_list = $CI->Purchases->purchase_by_search($supplier_id);
        $j = 0;
        if (!empty($purchases_list)) {
            foreach ($purchases_list as $k => $v) {
                $purchases_list[$k]['final_date'] = $CI->occational->dateConvert($purchases_list[$j]['purchase_date']);
                $j++;
            }
            $i = 0;
            foreach ($purchases_list as $k => $v) {
                $i++;
                $purchases_list[$k]['sl'] = $i;
            }
        }
        $data = array(
            'title' => display('manage_purchase'),
            'purchases_list' => $purchases_list
        );
        $purchaseList = $CI->parser->parse('purchase/purchase', $data, true);
        return $purchaseList;
    }

    //Insert Purchase
    public function insert_purchase($data) {
        $CI = & get_instance();
        $CI->load->model('Purchases');
        $CI->Purchases->purchase_entry($data);
        return true;
    }

    //purchase Edit Data
    public function purchase_edit_data($purchase_id) {
        $CI = & get_instance();
        $CI->load->model('Purchases');
        $CI->load->model('Suppliers');
        $CI->load->model('Web_settings');
        $bank_list        = $CI->Web_settings->bank_list();
        $purchase_detail = $CI->Purchases->retrieve_purchase_editdata($purchase_id);
        $avalueable = $CI->Purchases->avalable_value($purchase_id);
        $supplier_id = $purchase_detail[0]['supplier_id'];
        $supplier_list = $CI->Suppliers->supplier_list("110", "0");
        $supplier_selected = $CI->Suppliers->supplier_search_item($supplier_id);

        if (!empty($purchase_detail)) {
            $i = 0;
            foreach ($purchase_detail as $k => $v) {
                $i++;
                $purchase_detail[$k]['sl'] = $i;
                $$avalueable[$k]['sl'] = $i;
            }
        }

        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data = array(
            'title'         => display('purchase_edit'),
            'perusahaan'    => $purchase_detail[0]['perusahaan'],
            'purchase_id'   => $purchase_detail[0]['purchase_id'],
            'chalan_no'     => $purchase_detail[0]['chalan_no'],
            'supplier_name' => $purchase_detail[0]['supplier_name'],
            'supplier_id'   => $purchase_detail[0]['supplier_id'],
            'grand_total'   => $purchase_detail[0]['grand_total_amount'],
            'ppn'           => $purchase_detail[0]['ppn'],
            'value_ppn'     => $purchase_detail[0]['value_ppn'],
            'purchase_details' => $purchase_detail[0]['purchase_details'],
            'purchase_date' => $purchase_detail[0]['purchase_date'],
            'total_discount'=> $purchase_detail[0]['total_discount'],
            'total'         => number_format($purchase_detail[0]['grand_total_amount'] + (!empty($purchase_detail[0]['total_discount'])?$purchase_detail[0]['total_discount']:0),2),
            'bank_id'       =>  $purchase_detail[0]['bank_id'],
            'purchase_info' => $purchase_detail,
            'supplier_list' => $supplier_list,
            'paid_amount'   => $purchase_detail[0]['paid_amount'],
            'due_amount'    => $purchase_detail[0]['due_amount'],
            'bank_list'     => $bank_list,
            'supplier_selected' => $supplier_selected,
            'discount_type' => $currency_details[0]['discount_type'],
            'paytype'       => $purchase_detail[0]['payment_type'],
            'duedate'       => $purchase_detail[0]['duedate'],
            'avaluable'     => $avalueable,
        );
        $chapterList = $CI->parser->parse('purchase/edit_purchase_form', $data, true);
        return $chapterList;
    }


    public function po_edit_data($po_id) {
        $CI = & get_instance();
        $CI->load->model('Purchases');
        $CI->load->model('Suppliers');
        $CI->load->model('Web_settings');
        $purchase_detail = $CI->Purchases->retrieve_po_data($po_id);
        $supplier_id = $purchase_detail[0]['supplier_id'];
        $supplier_list = $CI->Suppliers->supplier_list("110", "0");
        $supplier_selected = $CI->Suppliers->supplier_search_item($supplier_id);

        if (!empty($purchase_detail)) {
            $i = 0;
            foreach ($purchase_detail as $k => $v) {
                $i++;
                $purchase_detail[$k]['sl'] = $i;
            }
        }

        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data = array(
            'title'             => display('purchase_edit'),
            'perusahaan'        => $purchase_detail[0]['perusahaan'],
            'po_id'             => $purchase_detail[0]['po_id'],
            'purchase_order'    => $purchase_detail[0]['purchase_order'],
            'po_date'           => $purchase_detail[0]['po_date'],
            'supplier_name'     => $purchase_detail[0]['supplier_name'],
            'supplier_id'       => $purchase_detail[0]['supplier_id'],
            'total_amount'      => $purchase_detail[0]['total_amount'],
            'total_price'      => $purchase_detail[0]['total_price'],
            'quot_id'           => $purchase_detail[0]['quot_id'],
            'quot_date'         => $purchase_detail[0]['quot_date'],
            'note_delivery_therm' => $purchase_detail[0]['note_delivery_therm'],
            'note_delivery_address' => $purchase_detail[0]['note_delivery_address'],
            'payment_therm'         => $purchase_detail[0]['payment_therm'],
            'purchase_info'         => $purchase_detail,
            'supplier_list'         => $supplier_list,
            'supplier_selected'     => $supplier_selected,
            'ppn'                   => $purchase_detail[0]['tax'],
            'remark'                => $purchase_detail[0]['remark'],
            'project'               => $purchase_detail[0]['project'],
            'ttd1'                  => $purchase_detail[0]['ttd_1'],
            'ttd2'                  => $purchase_detail[0]['ttd_2'],
            'ttd3'                  => $purchase_detail[0]['ttd_3'],
            'ttd4'                  => $purchase_detail[0]['ttd_4'],
            'ttd5'                  => $purchase_detail[0]['ttd_5'],
            'receiver'              => $purchase_detail[0]['receiver'],
            'note'                  => $purchase_detail[0]['note'],
        );

        $chapterList = $CI->parser->parse('purchase/edit_po_form', $data, true);
        return $chapterList;
    }


    public function barang_masuk_edit_data($po_id) {
        $CI = & get_instance();
        $CI->load->model('Purchases');
        $CI->load->model('Suppliers');
        $CI->load->model('Web_settings');
        $purchase_detail = $CI->Purchases->retrieve_barang_masuk_data($po_id);
        $supplier_id = $purchase_detail[0]['supplier_id'];
        $supplier_list = $CI->Suppliers->supplier_list("110", "0");
        $supplier_selected = $CI->Suppliers->supplier_search_item($supplier_id);

        if (!empty($purchase_detail)) {
            $i = 0;
            foreach ($purchase_detail as $k => $v) {
                $i++;
                $purchase_detail[$k]['sl'] = $i;
            }
        }

        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data = array(
            'title'         => '',
            'bm_id'   => $purchase_detail[0]['bm_id'],
            'barang_masuk'   => $purchase_detail[0]['barang_masuk'],
            'supplier_name' => $purchase_detail[0]['supplier_name'],
            'supplier_id'   => $purchase_detail[0]['supplier_id'],
            'po_id'   => $purchase_detail[0]['po_id'],
            'bm_date'   => $purchase_detail[0]['bm_date'],
            'bm_details'=>$purchase_detail[0]['bm_details'],
            'purchase_info' => $purchase_detail,
            'supplier_list' => $supplier_list,
            'supplier_selected' => $supplier_selected
        );

        $chapterList = $CI->parser->parse('purchase/barang_masuk_edit_form', $data, true);
        return $chapterList;
    }
public function barang_keluar_edit_data($po_id) {
        $CI = & get_instance();
        $CI->load->model('Purchases');
        $CI->load->model('Customers');
        $CI->load->model('Web_settings');
        $purchase_detail = $CI->Purchases->retrieve_barang_keluar_data($po_id);
        $customer_id = $purchase_detail[0]['customer_id'];
        $customer_list = $CI->Customers->customer_list("110", "0");
        $customer_selected = $CI->Customers->customer_search($customer_id);

        if (!empty($purchase_detail)) {
            $i = 0;
            foreach ($purchase_detail as $k => $v) {
                $i++;
                $purchase_detail[$k]['sl'] = $i;
            }
        }

        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data = array(
            'title'             => '',
            'bk_id'             => $purchase_detail[0]['bk_id'],
            'barang_keluar'     => $purchase_detail[0]['barang_keluar'],
            'customer_name'     => $purchase_detail[0]['customer_name'],
            'customer_id'       => $purchase_detail[0]['customer_id'],
            'po_id'             => $purchase_detail[0]['po_id'],
            'bk_date'           => $purchase_detail[0]['bk_date'],
            'bk_details'        => $purchase_detail[0]['bk_details'],
            'purchase_info'     => $purchase_detail,
            'customer_list'     => $customer_list,
            'customer_selected' => $customer_selected
        );

        $chapterList = $CI->parser->parse('purchase/barang_keluar_edit_form', $data, true);
        return $chapterList;
    }

    //Search purchase
    public function purchase_search_list($cat_id, $company_id) {
        $CI = & get_instance();
        $CI->load->model('Purchases');
        $category_list = $CI->Purchases->retrieve_category_list();
        $purchases_list = $CI->Purchases->purchase_search_list($cat_id, $company_id);
        $data = array(
            'title'          => display('manage_purchase'),
            'purchases_list' => $purchases_list,
            'category_list'  => $category_list
        );
        $purchaseList = $CI->parser->parse('purchase/purchase', $data, true);
        return $purchaseList;
    }

    //Purchase details data
    public function purchase_details_data($purchase_id) {

        $CI = & get_instance();
        $CI->load->model('Purchases');
        $CI->load->model('Web_settings');
        $CI->load->library('occational');

        $purchase_detail = $CI->Purchases->purchase_details_data($purchase_id);

        if (!empty($purchase_detail)) {
            $i = 0;
            foreach ($purchase_detail as $k => $v) {
                $i++;
                $purchase_detail[$k]['sl'] = $i;
            }

            foreach ($purchase_detail as $k => $v) {
                $purchase_detail[$k]['convert_date'] = $CI->occational->dateConvert($purchase_detail[$k]['purchase_date']);
            }
        }

        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $company_info = $CI->Purchases->retrieve_company();
        $data = array(
            'title'            => display('purchase_details'),
            'purchase_id'      => $purchase_detail[0]['purchase_id'],
            'purchase_details' => $purchase_detail[0]['purchase_details'],
            'supplier_name'    => $purchase_detail[0]['supplier_name'],
            'final_date'       => $purchase_detail[0]['convert_date'],
            'sub_total_amount' => number_format($purchase_detail[0]['grand_total_amount'], 2, '.', ','),
            'chalan_no'        => $purchase_detail[0]['chalan_no'],
            'total'            =>  number_format($purchase_detail[0]['grand_total_amount']+(!empty($purchase_detail[0]['total_discount'])?$purchase_detail[0]['total_discount']:0), 2),
            'discount'         => number_format((!empty($purchase_detail[0]['total_discount'])?$purchase_detail[0]['total_discount']:0),2),
            'paid_amount'      => number_format($purchase_detail[0]['paid_amount'],2),
            'due_amount'      => number_format($purchase_detail[0]['due_amount'],2),
            'purchase_all_data'=> $purchase_detail,
            'company_info'     => $company_info,
            'currency'         => $currency_details[0]['currency'],
            'position'         => $currency_details[0]['currency_position'],
            'Web_settings'     => $currency_details,
        );

        $chapterList = $CI->parser->parse('purchase/purchase_detail', $data, true);
        return $chapterList;
    }

    // purchase list date to date
    public function purchase_list_date_to_date($start, $end) {
        $CI = & get_instance();
        $CI->load->model('Purchases');
        $CI->load->model('Web_settings');
        $CI->load->library('occational');
        $purchases_list = $CI->Purchases->purchase_list_date_to_date($start, $end);
        if (!empty($purchases_list)) {
            $j = 0;
            foreach ($purchases_list as $k => $v) {
                $purchases_list[$k]['final_date'] = $CI->occational->dateConvert($purchases_list[$j]['purchase_date']);
                $j++;
            }

            $i = 0;
            foreach ($purchases_list as $k => $v) {
                $i++;
                $purchases_list[$k]['sl'] = $i + $CI->uri->segment(3);
            }
        }
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data = array(
            'title'          => display('manage_purchase'),
            'purchases_list' => $purchases_list,
            'links'          => '',
            'currency'       => $currency_details[0]['currency'],
            'position'       => $currency_details[0]['currency_position'],
        );

        $purchaseList = $CI->parser->parse('purchase/purchase', $data, true);
        return $purchaseList;
    }


    public function purchase_order_list() {
        $CI = & get_instance();
        $CI->load->model('Purchases');
        $CI->load->model('Web_settings');
        $CI->load->library('occational');
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $company_info = $CI->Purchases->retrieve_po_datalist();
        $data = array(
            'title'          => display('manage_purchase'),
            'company_info'   => $company_info,
            'currency'       => $currency_details[0]['currency'],
            'total_purhcase' => $CI->Purchases->count_purchase_order(),
        );

        $purchaseList = $CI->parser->parse('purchase/purchase_order_view', $data, true);
        return $purchaseList;
    }

    public function manage_product(){
        $CI = & get_instance();
        $CI->load->model('Purchases');
        $CI->load->model('Web_settings');
        $CI->load->library('occational');
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $company_info = $CI->Purchases->retrieve_company();
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data = array(
            'title'          => display('manage_purchase'),
            'company_info'   => $company_info,
            'currency'       => $currency_details[0]['currency'],
            'total_purhcase' => $CI->Purchases->count_final_purchases(),
        );

        $purchaseList = $CI->parser->parse('purchase/purchase_all_view', $data, true);
        return $purchaseList;
    }
    public function view_manage_product($prod_id){
        $CI = & get_instance();
        $CI->load->model('Purchases');
        $CI->load->model('Web_settings');
        $CI->load->library('occational');
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $company_info = $CI->Purchases->retrieve_company();
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data = array(
            'title'          => display('manage_purchase'),
            'company_info'   => $company_info,
            'currency'       => $currency_details[0]['currency'],
            'total_purhcase' => $CI->Purchases->count_final_view(),
            'prod_id' => $prod_id,
        );

        $purchaseList = $CI->parser->parse('purchase/view_detail_final_popurchase', $data, true);
        return $purchaseList;
    }

}

?>