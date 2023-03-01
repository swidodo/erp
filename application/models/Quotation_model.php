<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Quotation_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

//    ========== its for quotation_list ==============
    public function quotation_list($offset, $limit) {
        $this->db->select('a.*, b.customer_name, CONCAT(c.first_name, " ",c.last_name) as marketing');
        $this->db->from('quotation a');
        $this->db->join('customer_information b', 'b.customer_id = a.customer_id','left');
        $this->db->join('users c', 'c.id = a.marketing_id','left');
        $this->db->order_by('a.id', 'desc');
        $this->db->limit($offset, $limit);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

   

    //quotation insert
    public function quotation_entry($data) {
        $this->db->select('*');
        $this->db->from('quotation');
        $this->db->where('quot_no', $data['quot_no']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            $this->db->insert('quotation', $data);
            return TRUE;
        }
    }

// Delete Quotation 
    public function quotation_delete($quot_id) {
        //quotation
        $this->db->where('quotation_id', $quot_id);
        $this->db->delete('quotation');
        //used product
        $this->db->where('quot_id', $quot_id);
        $this->db->delete('quot_products_used');
        // used labour
        $this->db->where('quot_id', $quot_id);
        $this->db->delete('quotation_service_used');
        return true;
    }

    // ================  Quotation edit information ===================
    public function quot_main_edit($quot_id) {
        
        return  $this->db->select('a.*,b.customer_id, b.customer_name,b.customer_email, e.first_name,CONCAT(e.first_name, " ",e.last_name) as marketing, e.phone, d.username as emailmarketing')
                        ->from('quotation a')
                        ->join('customer_information b', 'b.customer_id = a.customer_id','left')
                        // ->join('employee_history c', 'c.id = a.marketing_id','left')
                        ->join('user_login d', 'd.id = a.marketing_id','left')
                        ->join('users e', 'e.user_id = d.user_id','left')
                        ->where('a.quotation_id', $quot_id)
                        ->get()
                        ->result_array();
    }
    public function CountRevisiquot($quotID)
    {
        return $this->db->SELECT('COUNT(quotation_id) as jml')
                        ->from('history_quotation')
                        ->where('quotation_id', $quotID)
                        ->get()
                        ->result_array();
    }
    //Item tax details 
    public function itemtaxdetails($quot_no){
        $taxdetector = 'item'.$quot_no;
          return $this->db->select('*')
                        ->from('quotation_taxinfo')
                        ->where('relation_id', $taxdetector)
                        ->get()
                        ->result_array();
    }
     //Service tax details 
    public function servicetaxdetails($quot_no){
        $taxdetector = 'serv'.$quot_no;
          return $this->db->select('*')
                        ->from('quotation_taxinfo')
                        ->where('relation_id', $taxdetector)
                        ->get()
                        ->result_array();
    }

    public function bank_list(){
        
        return $this->db->select('*')
                        ->from('bank_add')
                        ->get()
                        ->result_array();
    }


    public function quot_product_edit($quot_id) {
        return $this->db->select('*')
                        ->from('quot_products_used')
                        ->where('quot_id', $quot_id)
                        ->order_by('id', 'asc')
                        ->get()
                        ->result_array();
    }

    public function customerinfo($customer_id) {
        return $this->db->select('*')
                        ->from('customer_information')
                        ->where('customer_id', $customer_id)
                        ->get()
                        ->result_array();
    }

    // quotation update
    public function quotation_update($data) {
        $this->db->select('*');
        $this->db->from('quotation');
        $this->db->where('quotation_id', $data['quotation_id']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $this->db->where('quotation_id', $data['quotation_id']);
            $this->db->update('quotation', $data);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //Retrieve company Edit Data
    public function retrieve_company() {
        $this->db->select('*');
        $this->db->from('company_information');
        $this->db->limit('1');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }



    public function quot_service_detail($quot_id)
    {
          $result = $this->db->select('a.*,b.*')
                        ->from('quotation_service_used a')
                        ->join('product_service b', 'a.service_id=b.service_id')
                        ->where('a.quot_id', $quot_id)
                        ->order_by('a.id', 'asc')
                        ->get()
                        ->result_array();
                        if(!empty($result)){
                            return $result;
                        }else{
                            return false;
                        }
    }

       


    public function quot_product_detail($quot_id) {
        return $this->db->select('a.*,b.*')
                        ->from('quot_products_used a')
                        ->join('product_information b', 'a.product_id=b.product_id','left')
                        ->where('a.quot_id', $quot_id)
                        ->order_by('a.id', 'asc')
                        ->get()
                        ->result_array();
    }



//    ========= its for quotation onkeyup search ============
    public function quotationonkeyup_search($keyword) {
        $this->db->select('a.*, b.customer_name');
        $this->db->from('quotation a');
        $this->db->join('customer_information b', 'b.customer_id = a.customer_id');
        if ($this->session->userdata('user_type') == 3) {
            $this->db->where('a.customer_id', $this->session->userdata('user_id'));
            $this->db->where('a.cust_show', 1);
        }
        $this->db->like('b.customer_name', $keyword, 'both');
        $this->db->or_like('a.quot_no', $keyword, 'both');
        $this->db->order_by('a.id', 'desc');
        $this->db->limit(100);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    public function get_allproduct()
    {
       return $this->db->select('*')->from('product_information')->get()->result();
    }


    public function get_allcustomer(){
          return $this->db->select('*')
                        ->from('customer_information')
                        ->order_by('customer_name', 'asc')
                        ->get()
                        ->result_array();
    }
    // info registrasi pajak
    public function retrieve_tax_reg()
    {
       return $this->db->select()
                ->from('tax_settings')
                ->get()
                ->result_array();
    }

    public function list_Invoice_qoutation()
    {
        $data = $this->db->query('SELECT a.quotation_id,
                                        a.quot_no,
                                        a.perusahaan,
                                        a.quotdate,
                                        a.expire_date,
                                        (a.item_total_amount + a.service_total_amount) as item_total_amount,
                                        c.customer_name,
                                        u.first_name
                        FROM quotation as a 
                        LEFT JOIN invoice as b ON a.quotation_id=b.quotation_id
                        LEFT JOIN customer_information as c ON a.customer_id=c.customer_id
                        LEFT JOIN users as u ON u.id=a.marketing_id
                        -- WHERE b.total_amount <= a.item_total_amount or b.total_amount is null
                        GROUP BY a.quotation_id,b.quotation_id');
        return $data->result_array();
    }
    public function getInv($quot)
    {
        return $this->db->SELECT('SUM(total_amount) as total_amount')
                        ->FROM('invoice')
                        ->WHERE('quotation_id',$quot)
                        ->get()
                        ->result_array();
    }
    public function DataListInv($quotID)
    {
        return $this->db->SELECT("a.invoice,
                                a.date,
                                a.total_amount,
                                a.perusahaan,
                                a.duedate,
                                b.quot_no,
                                b.top,
                                b.type,
                                b.quotdate,
                                b.quot_description,
                                b.perusahaan,
                                c.customer_name,
                                c.customer_address,
                                c.customer_mobile")
                        ->from('invoice a')
                        ->join('quotation b','a.quotation_id=b.quotation_id','left')
                        ->join('customer_information c','c.customer_id=a.customer_id','left')
                        ->where('b.quotation_id',$quotID)
                        ->get()
                        ->result_array();
    }
    public function getTypeTop($invID)
    {
        return $this->db->SELECT("type_top")
                        ->FROM('invoice')
                        ->WHERE('invoice',$invID)
                        ->get()
                        ->row_array();
    }
    public function moreInv($quotID)
    {
        return $this->db->SELECT ('type_top,quotation_id')
                              ->from('invoice')
                              ->Where('quotation_id',$quotID)
                              ->Order_by('invoice','ASC')
                              ->Limit(1)
                              ->get()
                              ->result_array();
        
        
    }
    public function CheckIsInv($quotID)
    {
        return $this->db->SELECT('quotation_id')
                        ->from('invoice')
                        ->where('quotation_id',$quotID)
                        ->order_by('invoice','ASC')
                        ->limit('1')
                        ->get()
                        ->result_array();
    }
    public function CountIsInv($quotID)
    {
        return $this->db->SELECT('COUNT(quotation_id) as jml')
                        ->from('invoice')
                        ->where('quotation_id',$quotID)
                        ->get()
                        ->result_array();
    }
    public function checkQtt($quotID)
    {
        $data = $this->db->query("SELECT a.item_total_amount as tot_quot,a.service_total_amount as tot_service,SUM(b.total_amount) as tot_inv
                                 FROM quotation as a
                                 LEFT JOIN invoice as b 
                                 ON a.quotation_id=b.quotation_id
                                 WHERE a.quotation_id='$quotID'");
        return $data->result_array();
    }
    public function checkjasa($quotID)
    {
         $data = $this->db->query("SELECT service_total_amount
                                    FROM quotation
                                    WHERE quotation_id='$quotID'");
        return $data->result_array();
    }
    public function DetailInv($invID)
    {
         $data = $this->db->SELECT('a.quotation_id')
                        ->from ('invoice a')
                        ->join('invoice_details b','b.invoice_id=a.invoice_id')
                        ->where('a.invoice',$invID)
                        ->get()
                        ->result_array();
        if ($data !=null):
            return $this->db->SELECT('a.invoice,
                                    a.date,
                                    a.duedate,
                                    a.perusahaan,
                                    a.total_amount,
                                    a.total_tax,
                                    a.type_top,
                                    a.persent,
                                    a.invoice_details,
                                    a.ppn,
                                    a.po_id as po,
                                    a.po_date,
                                    b.quantity,
                                    b.total_price as totPrice,
                                    b.discount_per as disper,
                                    b.rate as ratedtl,
                                    c.customer_name,
                                    c.customer_address,
                                    c.customer_mobile,
                                    c.phone,
                                    c.fax,
                                    d.product_id,
                                    d.product_name,
                                    d.size,
                                    d.merek,
                                    d.unit,
                                    e.bank_name,
                                    e.ac_name,
                                    e.ac_number,
                                    e.branch,
                                    f.quot_no,
                                    f.quotdate,
                                    f.quotation_id,
                                    f.item_total_amount,
                                    f.item_total_tax,
                                    f.perusahaan,
                                    g.rate,
                                    g.used_qty,
                                    g.total_price

                                    ')
                        ->from('invoice a')
                        ->join('invoice_details b','a.invoice_id=b.invoice_id','left')
                        ->join('customer_information c','c.customer_id=a.customer_id','left')
                        ->join('product_information d','d.product_id=b.product_id','left')
                        ->join('bank_add e','e.bank_id=a.bank_id','left')
                        ->join('quotation f','f.quotation_id=a.quotation_id','left')
                        ->join('quot_products_used g','g.quot_id=f.quotation_id','left')
                        ->order_by('g.id','ASC')
                        ->group_by('b.invoice_details_id')
                        ->where('a.invoice',$invID)
                        ->get()
                        ->result_array();
        
        else :
            return $this->db->SELECT('a.invoice,
                                    a.date,
                                    a.duedate,
                                    a.perusahaan,
                                    a.total_amount,
                                    a.total_tax,
                                    a.type_top,
                                    a.persent,
                                    a.ppn,
                                    a.po_id as po,
                                    a.po_date,
                                    a.invoice_details,
                                    g.used_qty as quantity,
                                    g.rate as ratedtl,
                                    g.total_price as totPrice,
                                    g.total_price,
                                    g.discount_per,
                                    c.customer_name,
                                    c.customer_address,
                                    c.customer_mobile,
                                    c.phone,
                                    c.fax,
                                    d.product_id,
                                    d.product_name,
                                    d.size,
                                    d.merek,
                                    d.unit,
                                    e.bank_name,
                                    e.ac_name,
                                    e.ac_number,
                                    e.branch,
                                    f.quot_no,
                                    f.quotdate,
                                    f.quotation_id,
                                    f.item_total_amount,
                                    f.item_total_tax,
                                    f.perusahaan
                                    ')
                    ->from('invoice a')
                    ->join('quotation f','f.quotation_id=a.quotation_id','left')
                    ->join('quot_products_used g','g.quot_id=f.quotation_id','left')
                    // ->join('invoice_details b','a.invoice_id=b.invoice_id','left')
                    ->join('customer_information c','c.customer_id=a.customer_id','left')
                    ->join('product_information d','d.product_id=g.product_id','left')
                    ->join('bank_add e','e.bank_id=a.bank_id','left')
                    ->where('a.invoice',$invID)
                    ->get()
                    ->result_array();
        endif;

    }
    public function checkDP($invID)
    {
        $query=$this->db->QUERY("SELECT `persent` 
                          FROM `invoice` 
                          WHERE quotation_id in(SELECT quotation_id FROM invoice WHERE invoice='$invID') 
                          AND `type_top` = 'DP'" );
        return $query->result_array();
                 
    }
    public function dtlService($invID){
        $data = $this->db->SELECT("*")
                        ->FROM('invoice a')
                        ->WHERE('invoice',$invID)
                        ->get()
                        ->result_array();
        if ($data !=null)
        {
            return $this->db->SELECT('*')
                            ->FROM('quotation_service_used a')
                            ->JOIN('product_service b','a.service_id=b.service_id')
                            ->JOIN('quotation as c','c.quotation_id=a.quot_id')
                            ->WHERE('a.quot_id',$data[0]['quotation_id'])
                            ->get()
                            ->result_array();
        }
    }
    public function mstService($invID)
    {
         $data = $this->db->SELECT("*")
                        ->FROM('invoice a')
                        ->WHERE('invoice',$invID)
                        ->get()
                        ->result_array();
        if ($data !=null)
        {
            return $this->db->SELECT('*')
                            ->FROM('service_invoice a')
                            ->WHERE('a.voucher_no',$data[0]['invoice_id'])
                            ->get()
                            ->result_array();
        }
    }
    public function getTotinv($invID)
    {
         $data = $this->db->SELECT("*")
                        ->FROM('invoice a')
                        ->WHERE('invoice',$invID)
                        ->get()
                        ->result_array();
        return $this->db->SELECT('SUM(a.total_amount) as tot_inv')
                        ->FROM('invoice a')
                        ->JOIN('quotation b','b.quotation_id=a.quotation_id')
                        ->WHERE('b.quotation_id',$data[0]['quotation_id'])
                        ->get()
                        ->result_array();
    }
    public function checkInvPrint($invID)
    {
        $data = $this->db->SELECT('a.quotation_id')
                        ->from ('invoice a')
                        ->join('invoice_details b','b.invoice_id=a.invoice_id')
                        ->get
                        ->row();
    }
    public function getDataHistorical()
    {
        return $this->db->SELECT("  a.quotation_id,
                                    a.quot_no,
                                    a.item_total_amount,
                                    a.item_total_tax,
                                    a.service_total_amount,
                                    a.perusahaan,
                                    a.quotdate,
                                    CONCAT(b.first_name,' ',b.last_name) as name,
                                    c.customer_name")
                        ->FROM('history_quotation a')
                        ->JOIN('users b', 'b.id=a.marketing_id','left')
                        ->JOIN('customer_information c','a.customer_id=c.customer_id','left')
                        ->GROUP_BY('a.quotation_id')
                        ->get()
                        ->result_array();
    }
    public function CountRevisi($jml)
    {
        return $this->db->SELECT("COUNT(quotation_id) as count")
                        ->FROM("history_quotation")
                        ->WHERE('Quotation_id',$jml)
                        ->get()
                        ->result_array();
    }
    public function ListRevisi($quotID)
    {
        return $this->db->SELECT('a.quot_no,
                                a.quotdate,
                                a.type,
                                a.top,
                                a.perusahaan,
                                a.delivery_time,
                                a.quotation_exp,
                                a.quotation_exp_sat,
                                a.delivery_time_sat,
                                a.item_total_amount,
                                a.item_total_dicount,
                                a.service_total_amount,
                                a.item_total_tax,
                                GROUP_CONCAT(DISTINCT b.product_id,,"~^",e.product_name,"~^",e.unit,"~^",b.used_qty,"~^",b.rate,"~^",b.discount_per,"~^",b.discount,"~^",b.total_price ORDER BY b.id_history ASC SEPARATOR "&") as products,
                                GROUP_CONCAT(DISTINCT f.service_name,"~^",c.qty,"~^",c.charge,"~^",c.discount,"~^",c.discount_amount,"~^",c.total) as services,
                                d.customer_name,
                                d.customer_mobile,
                                d.customer_address,
                                u.first_name
                                ')
                        ->from('history_quot_products_used b')
                        ->join('history_quotation a','b.quot_id=a.quotation_id and b.count_revisi=a.count_revisi','left')
                        ->join('history_quotation_service_used c','c.quot_id=a.quotation_id','left')
                        ->join('customer_information d','d.customer_id=a.customer_id','left')
                        ->join('product_information e','e.product_id=b.product_id','left')
                        ->join('product_service f','f.service_id=c.service_id','left')
                        ->join('users u','u.user_id=a.marketing_id','left')
                        ->where('a.quotation_id',$quotID)
                        ->group_by('b.count_revisi')
                        ->get()
                        ->result_array();
    }
    public function get_quotation($id)
    {
        $quotation = $this->db->query("SELECT a.quotation_id,
                                            a.quot_no,
                                            a.quotdate,
                                            a.item_total_amount,
                                            a.item_total_dicount,
                                            a.item_total_tax,
                                            a.service_total_amount,
                                            a.service_total_discount,
                                            b.customer_name,
                                            b.customer_address,
                                            b.customer_mobile,
                                            b.customer_id,
                                            date(now()) as datenow
                                        FROM quotation as a 
                                        LEFT JOIN customer_information as b
                                        ON a.customer_id=b.customer_id
                                        WHERE a.quotation_id = '$id'");
        return $quotation->result_array();
    }
    public function get_product($id)
    {
        $product  = $this->db->query("SELECT a.quot_id,
                                            a.used_qty,
                                            a.rate,
                                            a.total_price,
                                            a.discount,
                                            a.discount_per,
                                            a.tax,
                                            c.product_name,
                                            c.unit
                                    FROM quot_products_used as a
                                    LEFT JOIN quotation as b
                                    ON b.quotation_id=a.quot_id
                                    LEFT JOIN product_information as c
                                    ON a.product_id=c.product_id
                                    Where b.quotation_id= '$id' ");
        return $product->result_array();
    }
    public function InvNo()
    {
        $inv = $this->db->query('SELECT invoice +1 as InvNo FROM invoice ORDER BY invoice DESC limit 1');
        $ck_inv = $inv->result_array();
        if ($ck_inv){
            $no_inv= $ck_inv[0]['InvNo'];
        }else{
            $no_inv= '1000';
        }
        return $no_inv;
    }
    public function get_service($id)
    {
        return $this->db->SELECT('a.charge,a.qty,a.discount,a.total,c.service_name')
                        ->from('quotation b')
                        ->JOIN('quotation_service_used a','a.quot_id=b.quotation_id')
                        ->JOIN('product_service c','c.service_id=a.service_id')
                        ->WHERE('b.quotation_id',$id)
                        ->get()
                        ->result_array();
    }
    public function getQuotReplace($quotID)
    {
        return $this->db->SELECT('*')
                        ->FROM('quotation')
                        ->WHERE('quotation_id',$quotID)
                        ->get()
                        ->result_array();
    }
    public function getProdReplace($quotID)
    {
        return $this->db->SELECT('*')
                        ->FROM('quot_products_used')
                        ->WHERE('quot_id',$quotID)
                        ->get()
                        ->result_array();
    }
    public function getTaxReplace($quotID)
    {
        $data = $this->db->SELECT('quot_no')
                        ->FROM('quotation')
                        ->WHERE('quotation_id',$quotID)
                        ->get()
                        ->result_array();
        $item = 'item'.$data[0]['quot_no'];
        $serv = 'serv'.$data[0]['quot_no'];
        $query = $this->db->query("SELECT * FROM quotation_taxinfo WHERE relation_id IN('$item','$item')");
        return $query->result_array();
    }
    public function getServiceReplace($quotID)
    {
        return $this->db->SELECT('*')
                        ->FROM('quotation_service_used')
                        ->WHERE('quot_id',$quotID)
                        ->get()
                        ->result_array();
    }
    public function ReplaceQuot($quotData,$user)
    {
        $check = $this->db->SELECT('quotation_id')
                        ->FROM ('history_quotation') 
                        ->WHERE ('quotation_id',$quotData['quotation_id']);
        $checked=$check->get();
        $query = $this->db->query('SELECT now() as tgl');
        $date  = $query->result_array();
       
        if ($checked->num_rows()<='0')
        {
            $this->db->Insert('history_quotation',$quotData);
            $data =[
                'count_revisi'  =>'1',
                'daterev'       =>$date[0]['tgl'],
                'revisi_by'     =>$user,
            ];
            $this->db->WHERE('quotation_id',$quotData['quotation_id']);
            $this->db->Update('history_quotation',$data);
        }
        elseif ($checked->num_rows()>'0')
        {   
            $this->db->Insert('history_quotation',$quotData); 
            
            $checkhis = $this->db->SELECT('id_history')
                            ->FROM ('history_quotation') 
                            ->WHERE ('quotation_id',$quotData['quotation_id'])
                            ->ORDER_BY('id_history','DESC')
                            ->limit('1')
                            ->get()
                            ->result_array();
            
            
            $count =$checked->num_rows()+1;
            $data =[
                'count_revisi'  =>$count,
                'daterev'       =>$date[0]['tgl'],
                'revisi_by'     =>$user,
            ];
            $this->db->WHERE('id_history', $checkhis[0]['id_history']);
            $this->db->Update('history_quotation',$data);
        }
    }
    public function ReplaceProd($ProdData,$user, $checkhis)
    {
        $query = $this->db->query('SELECT now() as tgl');
        $date  = $query->result_array();
        
        if ($checkhis ==null)
        {
            $this->db->Insert('history_quot_products_used',$ProdData);
            $data =[
                'count_revisi'  =>'1',
                'daterev'       =>$date[0]['tgl'],
            ];
            $this->db->Where('quot_id',$ProdData['quot_id']);
            $this->db->WHERE('count_revisi IS NULL');
            $this->db->Update('history_quot_products_used',$data);
        }
        elseif ($checkhis !=null)
        {   
            $count =$checkhis[0]['count_revisi']+1;
            $this->db->Insert('history_quot_products_used',$ProdData);
            $data =[
                'count_revisi'  =>$count,
                'daterev'       =>$date[0]['tgl'],
            ];
            $this->db->Where('quot_id',$ProdData['quot_id']);
            $this->db->WHERE('count_revisi IS NULL');
            $this->db->Update('history_quot_products_used',$data);
        }
    }
    public function ReplaceTax($TaxData,$user, $cktax,$data)
    {
        $item = 'item'.$data[0]['quot_no'];
        $serv = 'serv'.$data[0]['quot_no'];
        $query = $this->db->query('SELECT now() as tgl');
        $date  = $query->result_array();
        $now   = $date[0]['tgl'];

        if ($cktax ==null)
        {
            $this->db->Insert('history_quotation_taxinfo',$TaxData);
            $update = $this->db->query("UPDATE history_quotation_taxinfo 
                                        SET count_revisi='1', daterev='".$now."' 
                                        WHERE relation_id IN('$item','$serv')
                                        AND daterev IS NULL");
        }
        elseif ($cktax !=null)
        {   
            $count  = $cktax[0]['count_revisi']+1;
            $item   = 'item'.$data[0]['quot_no'];
            $serv   = 'serv'.$data[0]['quot_no'];
            $query  = $this->db->query('SELECT now() as tgl');
            $date   = $query->result_array();
            $now    = $date[0]['tgl'];

            $this->db->Insert('history_quotation_taxinfo',$TaxData);
            $update = $this->db->query("UPDATE history_quotation_taxinfo 
                                        SET count_revisi='$count',daterev='".$now."'
                                        WHERE relation_id IN('$item','$serv')
                                        AND daterev IS NULL
                                        ");
        }
       
    }
    public function ReplaceService($ServiceData,$user,$checkserv)
    {
        $query = $this->db->query('SELECT now() as tgl');
        $date  = $query->result_array();
       if($checkserv == null)
       {
            $this->db->Insert('history_quotation_service_used',$ServiceData);
            $data =[
                'count_revisi'  =>'1',
                'daterev'       =>$date[0]['tgl'],
            ];
            $this->db->Where('quot_id',$ServiceData['quot_id']);
            $this->db->WHERE('count_revisi IS NULL');
            $this->db->Update('history_quotation_service_used',$data);
       }
       elseif ($checkserv !=null)
        {   
            $count =$checkserv[0]['count_revisi']+1;
            $this->db->Insert('history_quotation_service_used',$ServiceData);
            $data =[
                'count_revisi'  =>$count,
                'daterev'       =>$date[0]['tgl'],
            ];
            $this->db->Where('quot_id',$ServiceData['quot_id']);
            $this->db->WHERE('count_revisi IS NULL');
            $this->db->Update('history_quotation_service_used',$data);
        } 
    }
    public function getBankList()
    {
        return $this->db->SELECT('*')
                        ->from ('bank_add')
                        ->get()
                        ->result_array();
    }
    public function getQuotList($postData=null)
    {
        $this->load->library('occational');
         $response = array();
         $usertype = $this->session->userdata('user_type');
         $fromdate = $this->input->post('fromdate',TRUE);
         $todate   = $this->input->post('todate',TRUE);
         if(!empty($fromdate)){
            $datbetween = "(a.date BETWEEN '$fromdate' AND '$todate')";
         }else{
            $datbetween = "";
         }
         ## Read value
         $draw = $postData['draw'];
         $start = $postData['start'];
         $rowperpage = $postData['length']; // Rows display per page
         $columnIndex = $postData['order'][0]['column']; // Column index
         $columnName = $postData['columns'][$columnIndex]['data']; // Column name
         $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
         $searchValue = $postData['search']['value']; // Search value

         ## Search 
         $searchQuery = "";
         if($searchValue != ''){
            $searchQuery = " (b.customer_name like '%".$searchValue."%' or a.quot_no like '%".$searchValue."%' or a.quotdate like'%".$searchValue."%' or u.first_name like'%".$searchValue."%'or u.last_name like'%".$searchValue."%')";
         }

         ## Total number of records without filtering
         $this->db->select('count(*) as allcount');
         $this->db->from('quotation a');
         $this->db->join('customer_information b', 'b.customer_id = a.customer_id','left');
         $this->db->join('users u', 'u.user_id = a.create_by','left');
         if($usertype == 2){
          $this->db->where('a.create_by',$this->session->userdata('user_id'));
         }
          if(!empty($fromdate) && !empty($todate)){
             $this->db->where($datbetween);
         }
          if($searchValue != '')
          $this->db->where($searchQuery);
          
         $records = $this->db->get()->result();
         $totalRecords = $records[0]->allcount;

         ## Total number of record with filtering
         $this->db->select('count(*) as allcount');
         $this->db->from('quotation a');
         $this->db->join('customer_information b', 'b.customer_id = a.customer_id','left');
         $this->db->join('users u', 'u.user_id = a.create_by','left');
         if($usertype == 2){
          $this->db->where('a.create_by',$this->session->userdata('user_id'));
         }
         if(!empty($fromdate) && !empty($todate)){
             $this->db->where($datbetween);
         }
         if($searchValue != '')
            $this->db->where($searchQuery);
          
         $records = $this->db->get()->result();
         $totalRecordwithFilter = $records[0]->allcount;

         ## Fetch records
         $this->db->select("a.*,b.customer_name,u.first_name,u.last_name");
         $this->db->from('quotation a');
         $this->db->join('customer_information b', 'b.customer_id = a.customer_id','left');
         $this->db->join('users u', 'u.user_id = a.create_by','left');
        //  $this->db->order_by('a.quotdate','DESC');
         if($usertype == 2){
          $this->db->where('a.create_by',$this->session->userdata('user_id'));
         }
          if(!empty($fromdate) && !empty($todate)){
             $this->db->where($datbetween);
         }
         if($searchValue != '')
         $this->db->where($searchQuery);
       
         $this->db->order_by($columnName, $columnSortOrder);
         $this->db->limit($rowperpage, $start);
         $records = $this->db->get()->result();
         $data = array();
         $sl =1;
         
         foreach($records as $record ){
            $button = '';
            $base_url = base_url();
            $jsaction = "return confirm('Are You Sure ?')";
  
          $button .= '<a href="'.$base_url.'Cquotation/quotation_details_data/' . $record->quotation_id.'" class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>';
         
       if ($record->status == 1) {
            if($this->permission1->method('manage_quotation','update')->access()){
                $button .= '<a href="'.$base_url. 'Cquotation/quotation_edit/' . $record->quotation_id.'" class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i></a>';
            }
       }
       if ($record->status == 2) {
            if($this->permission1->method('manage_quotation','update')->access()){ 
                $button .= '<a href="'.$base_url.'Cquotation/add_revisi_quotation/' . $record->quotation_id.'" class="btn btn-primary btn-sm">Revisi</a>';
            }
        }
          
        if($this->permission1->method('manage_quotation','delete')->access()){
           $button .= '<a href="'.$base_url. 'Cquotation/delete_quotation/' . $record->quotation_id.'" class="btn btn-danger btn-sm" onclick="'.$jsaction.'"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
        }
    //    end
 
            $details ='  <a href="'.$base_url.'Cinvoice/invoice_inserted_data/'.$record->quotation_id.'" class="" >'.$record->quotation_id.'</a>';
            
              $data[] = array( 
                  'sl'               =>$sl,
                  'customer_name'    =>$record->customer_name,
                  'quotno'           =>$record->quot_no.".".substr($record->first_name,0,2)."/".$record->perusahaan."/".romawi(intval(date('m',strtotime($record->quotdate))))."/".date('Y',strtotime($record->quotdate)),
                  'quotdate'         =>$record->quotdate,
                  'user'             =>$record->first_name." ".$record->last_name,
                  'price'            =>$record->item_total_amount,
                  'service'          =>$record->service_total_amount,
                  'button'           =>$button,
                  'temp'             =>''
                  
              ); 
              $sl++;
           }
           $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecordwithFilter,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" => $data
         );

         return $response; 
    }
}
