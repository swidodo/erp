<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Purchases extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    //Count purchase
    public function count_purchase() {
        $this->db->select('a.*,b.supplier_name');
        $this->db->from('product_purchase a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id');
        $this->db->order_by('a.purchase_date', 'desc');
        $this->db->order_by('purchase_id', 'desc');
        $query = $this->db->get();

        $last_query = $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;
    }


    public function count_barang_masuk(){
        $query = $this->db->get('barang_masuk');
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;
    }


     public function getPurchaseList($postData=null){
         $this->load->library('occational');
         $this->load->model('Web_settings');
         $currency_details = $this->Web_settings->retrieve_setting_editdata();
         $response = array();
         $fromdate = $this->input->post('fromdate');
         $todate   = $this->input->post('todate');
         if(!empty($fromdate)){
            $datbetween = "(a.purchase_date BETWEEN '$fromdate' AND '$todate')";
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
            $searchQuery = " (b.supplier_name like '%".$searchValue."%' or a.chalan_no like '%".$searchValue."%' or a.purchase_date like'%".$searchValue."%')";
         }

         ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('product_purchase a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id','left');
          if(!empty($fromdate) && !empty($todate)){
             $this->db->where($datbetween);
         }
          if($searchValue != '')
          $this->db->where($searchQuery);
          
         $records = $this->db->get()->result();
         $totalRecords = $records[0]->allcount;

         ## Total number of record with filtering
         $this->db->select('count(*) as allcount');
        $this->db->from('product_purchase a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id','left');
         if(!empty($fromdate) && !empty($todate)){
             $this->db->where($datbetween);
         }
         if($searchValue != '')
            $this->db->where($searchQuery);
          
         $records = $this->db->get()->result();
         $totalRecordwithFilter = $records[0]->allcount;

         ## Fetch records
        $this->db->select('a.*,b.supplier_name');
        $this->db->from('product_purchase a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id','left');
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

           $button .='  <a href="'.$base_url.'Cpurchase/purchase_details_data/'.$record->purchase_id.'" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="'.display('purchase_details').'"><i class="fa fa-window-restore" aria-hidden="true"></i></a>';
      if($this->permission1->method('manage_purchase','update')->access()){
         $button .=' <a href="'.$base_url.'Cpurchase/purchase_update_form/'.$record->purchase_id.'" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="'. display('update').'"><i class="fa fa-pencil" aria-hidden="true"></i></a> ';
         $button .=' <a href="'.$base_url.'Cpurchase/purchase_do_details/'.$record->purchase_id.'" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="left" title="view DO">view DO</i></a> ';
     }

        if($this->permission1->method('manage_purchase','delete')->access()){
                                  
           $button .= '<a href="'.$base_url.'Cpurchase/delete_purchase/'.$record->purchase_id.'" class="btn btn-danger btn-sm"  data-toggle="tooltip" data-placement="left" title="'.display('delete').'"  onclick="'.$jsaction.'"><i class="fa fa-trash"></i></a>';
         }

         $purchase_ids ='<a href="'.$base_url.'Cpurchase/purchase_details_data/'.$record->purchase_id.'">'.$record->purchase_id.'</a>';
               
            $data[] = array( 
                'sl'               =>$sl,
                'chalan_no'        =>$record->chalan_no,
                'purchase_id'      =>$purchase_ids,
                'supplier_name'    =>$record->supplier_name,
                'purchase_date'    =>$this->occational->dateConvert($record->purchase_date),
                'duedate'          =>$record->duedate,
                'total_amount'     =>$record->grand_total_amount,
                'button'           =>$button,
                
            ); 
            $sl++;
         }

         ## Response
         $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecordwithFilter,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" => $data
         );

         return $response; 
    }



    public function getPurchaseOrderList($postData=null){
        $this->load->library('occational');
        $this->load->model('Web_settings');
        $currency_details = $this->Web_settings->retrieve_setting_editdata();
        $response = array();
        $fromdate = $this->input->post('fromdate');
        $todate   = $this->input->post('todate');
        if(!empty($fromdate)){
           $datbetween = "(a.po_date BETWEEN '$fromdate' AND '$todate')";
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
           $searchQuery = " (b.supplier_name like '%".$searchValue."%' or a.purchase_order like '%".$searchValue."%' or a.po_date like'%".$searchValue."%')";
        }

        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('purchase_order a');
        $this->db->join('purchase_order_details b', 'b.po_id = a.po_id');
        $this->db->join('product_information c', 'c.product_id =b.product_id');
        $this->db->join('supplier_information d', 'd.supplier_id =a.supplier_id');
         if(!empty($fromdate) && !empty($todate)){
            $this->db->where($datbetween);
        }
         if($searchValue != '')
         $this->db->where($searchQuery);
         
        $records = $this->db->get()->result();
        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        
        $this->db->from('purchase_order a');
        $this->db->join('purchase_order_details b', 'b.po_id = a.po_id');
        $this->db->join('product_information c', 'c.product_id =b.product_id');
        $this->db->join('supplier_information d', 'd.supplier_id =a.supplier_id');
        if(!empty($fromdate) && !empty($todate)){
            $this->db->where($datbetween);
        }
        if($searchValue != '')
           $this->db->where($searchQuery);
         
        $records = $this->db->get()->result();
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select('a.*,
        b.*,
        c.product_id,
        c.product_name,
        c.size,
        c.merek,
        c.unit,
        d.supplier_name,
        d.contact,
        d.phone,
        d.fax,
        d.email_address'
        
);
$this->db->from('purchase_order a');
$this->db->join('purchase_order_details b', 'b.po_id = a.po_id');
$this->db->join('product_information c', 'c.product_id =b.product_id');
$this->db->join('supplier_information d', 'd.supplier_id =a.supplier_id');
         if(!empty($fromdate) && !empty($todate)){
            $this->db->where($datbetween);
        }
        if($searchValue != '')
        $this->db->where($searchQuery);
      
        $this->db->order_by('purchase_order', $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result();
        $data = array();
        $sl =1;
        foreach($records as $record ){
         $button = '';
         $base_url = base_url();
         $jsaction = "return confirm('Are You Sure ?')";

        $button .='  <a href="'.$base_url.'Cpurchase/cetakpo/'.$record->po_id.'" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="Cetak PO"><i class="fa fa-print" aria-hidden="true"></i></a>';
        $button .=' <a href="'.$base_url.'Cpurchase/po_update_form/'.$record->po_id.'" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="left" title="'. display('update').'"><i class="fa fa-pencil" aria-hidden="true"></i></a> ';                      
        $button .=' <a href="'.$base_url.'Cpurchase/po_detail/'.$record->po_id.'" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="view"><i class="fa fa-eye" aria-hidden="true"></i></a> ';                      
        $button .= '<a href="'.$base_url.'Cpurchase/delete_po/'.$record->po_id.'" class="btn btn-danger btn-sm"  data-toggle="tooltip" data-placement="left" title="'.display('delete').'"  onclick="'.$jsaction.'"><i class="fa fa-trash"></i></a>';
        

      
              
           $data[] = array( 
               'sl'                 =>$sl,
               'purchase_order'     =>$record->purchase_order.'/'.$record->perusahaan,
               'po_date'            =>$record->po_date,
               'supplier_name'      =>$record->supplier_name,
               'quot_date'          =>$this->occational->dateConvert($record->quot_date),
               'quot_id'            =>$record->quot_id,
               'total_amount'       =>$record->total_amount,
               'button'             =>$button,
               
           ); 
           $sl++;
        }

        ## Response
        $response = array(
           "draw" => intval($draw),
           "iTotalRecords" => $totalRecordwithFilter,
           "iTotalDisplayRecords" => $totalRecords,
           "aaData" => $data
        );

        return $response; 
   }
public function getCompany($idpo)
{
    return  $this->db->select('b.npwp')
                     ->from('purchase_order a')
                     ->join('company_information b','b.company_code=a.perusahaan','left')
                     ->where('a.po_id',$idpo)
                     ->get()
                     ->result_array();
}
public function getDoPurchase($purchaseID)
{
    return $this->db->select('*')
                    ->from('product_purchase a')
                    ->join('purchase_do b','a.purchase_id=b.purchase_id')
                    ->where('a.purchase_id',$purchaseID)
                    ->order_by('b.date','DESC')
                    ->get()
                    ->result_array();
}
public function getDoPo($poID)
{
    return $this->db->select('*')
                    ->from('purchase_order a')
                    ->join('purchase_do b','a.po_id=b.purchase_id')
                    ->where('a.po_id',$poID)
                    ->order_by('b.date','DESC')
                    ->get()
                    ->result_array();
}
public function InsertdataDO($date,$purchaseId,$doId,$dodate,$paydate,$duedate,$do_details,$do_type,$user)
{
    $Cdate = $this->db->SELECT('now() as tgl')
                     ->get()
                     ->result_array();
    $data = [
        'id_do'         =>$this->generator(15),
        'date'          =>$date,
        'purchase_id'   =>$purchaseId,
        'do_number'     =>$doId,
        'do_date'       =>$dodate,
        'pay_date'      =>$paydate,
        'pay_duedate'   =>$duedate,
        'do_detail'     =>$do_details,
        'do_type'       =>$do_type,
        'input_by'      =>$user,
        'created_at'    =>$Cdate[0]['tgl'],
    ];
   return $this->db->INSERT('purchase_do',$data);
}
public function getDataById($doid){
 return $this->db->select('*')
                ->from('purchase_do a')
                ->join('product_purchase b','a.purchase_id=b.purchase_id')
                ->join('supplier_information c','c.supplier_id=b.supplier_id')
                ->Where('a.id_do',$doid)
                ->get()
                ->result_array();
}
public function getByIdPODO($doid){
 return $this->db->select('*')
                ->from('purchase_do a')
                ->join('purchase_order b','a.purchase_id=b.po_id')
                ->join('supplier_information c','c.supplier_id=b.supplier_id')
                ->Where('a.id_do',$doid)
                ->get()
                ->result_array();
}
public function Checked($id)
{
    return $this->db->SELECT('purchase_id,do_type')
                    ->from('purchase_do')
                    ->WHERE('id_do',$id)
                    ->get()
                    ->result_array();
} 
public function updateDopurchase($id,$date,$doId,$dodate,$paydate,$duedate,$do_details,$user)
{
    $data =[
        'date'          => $date,
        'do_number'     => $doId,
        'do_date'       => $dodate,
        'pay_date'      => $paydate,
        'pay_duedate'   => $duedate,
        'do_detail'     => $do_details,
        'update_by'     => $user,
    ];
    $this->db->where('id_do',$id);
    return $this->db->Update('purchase_do',$data);
}
    public function chekdataPurchase($purchaseID)
    {
        return $this->db->Select('*')
                        ->from('product_purchase a')
                        ->join('supplier_information b','a.supplier_id=b.supplier_id','left')
                        ->join('product_purchase_details c','c.purchase_id=a.purchase_id','left')
                        ->join('product_information d','d.product_id=c.product_id','left')
                        ->where('a.purchase_id',$purchaseID)
                        ->get()
                        ->result_array();

    }
    public function chekdataPo($poID)
    {
        return $this->db->Select('*')
                        ->from('purchase_order a')
                        ->join('supplier_information b','a.supplier_id=b.supplier_id','left')
                        ->join('purchase_order_details c','c.po_id=a.po_id','left')
                        ->join('product_information d','d.product_id=c.product_id','left')
                        ->where('a.po_id',$poID)
                        ->get()
                        ->result_array();
    }
   public function getBarangmasukList($postData=null){
    $this->load->library('occational');
    $this->load->model('Web_settings');
    $currency_details = $this->Web_settings->retrieve_setting_editdata();
    $response = array();
    $fromdate = $this->input->post('fromdate');
    $todate   = $this->input->post('todate');
    if(!empty($fromdate)){
       $datbetween = "(a.bm_date BETWEEN '$fromdate' AND '$todate')";
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
       $searchQuery = " (d.supplier_name like '%".$searchValue."%' or a.barang_masuk like '%".$searchValue."%' or a.bm_date like'%".$searchValue."%')";
    }

    ## Total number of records without filtering
   $this->db->select('count(*) as allcount');
   $this->db->from('barang_masuk a');
    $this->db->join('barang_masuk_details b', 'b.bm_id = a.bm_id');
    $this->db->join('product_information c', 'c.product_id =b.product_id');
    $this->db->join('supplier_information d', 'd.supplier_id =a.supplier_id');

     if(!empty($fromdate) && !empty($todate)){
        $this->db->where($datbetween);
    }
     if($searchValue != '')
     $this->db->where($searchQuery);
     
    $records = $this->db->get()->result();
    $totalRecords = $records[0]->allcount;

    ## Total number of record with filtering
    $this->db->select('count(*) as allcount');
   $this->db->from('barang_masuk a');
   $this->db->join('barang_masuk_details b', 'b.bm_id = a.bm_id');
   $this->db->join('product_information c', 'c.product_id =b.product_id');
   $this->db->join('supplier_information d', 'd.supplier_id =a.supplier_id');

    if(!empty($fromdate) && !empty($todate)){
        $this->db->where($datbetween);
    }
    if($searchValue != '')
       $this->db->where($searchQuery);
     
    $records = $this->db->get()->result();
    $totalRecordwithFilter = $records[0]->allcount;

    ## Fetch records
    $this->db->select('a.*,
    b.*,
    c.product_id,
    c.product_name,
    c.size,
    c.merek,
    c.unit,
    d.supplier_name,
    d.contact,
    d.phone,
    d.fax,
    d.email_address'
    
    );
    $this->db->from('barang_masuk a');
    $this->db->join('barang_masuk_details b', 'b.bm_id = a.bm_id');
    $this->db->join('product_information c', 'c.product_id =b.product_id');
    $this->db->join('supplier_information d', 'd.supplier_id =a.supplier_id');

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

      $button .='  <a href="'.$base_url.'Cpurchase/cetakbarangmasuk/'.$record->bm_id.'" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="Cetak Surat Bukti Barang Masuk"><i class="fa fa-print" aria-hidden="true"></i></a>';
//  if($this->permission1->method('manage_purchase','update')->access()){
    $button .=' <a href="'.$base_url.'Cpurchase/barangmasuk_update_form/'.$record->bm_id.'" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="'. display('update').'"><i class="fa fa-pencil" aria-hidden="true"></i></a> ';
// }

//    if($this->permission1->method('manage_purchase','delete')->access()){
                             
      $button .= '<a href="'.$base_url.'Cpurchase/delete_barangmasuk/'.$record->bm_id.'" class="btn btn-danger btn-sm"  data-toggle="tooltip" data-placement="left" title="'.display('delete').'"  onclick="'.$jsaction.'"><i class="fa fa-trash"></i></a>';
    // }

          
       $data[] = array( 
           'sl'               =>$sl,
           'po_id'        =>$record->po_id,
           'supplier_name'    =>$record->supplier_name,
           'bm_date'    =>$this->occational->dateConvert($record->bm_date),
           'keterangan'     =>$record->bm_details,
           'button'           =>$button,
           
       ); 
       $sl++;
    }

    ## Response
    $response = array(
       "draw" => intval($draw),
       "iTotalRecords" => $totalRecordwithFilter,
       "iTotalDisplayRecords" => $totalRecords,
       "aaData" => $data
    );

    return $response; 
}


    //purchase List
    public function purchase_list($per_page, $page) {
        $this->db->select('a.*,b.supplier_name');
        $this->db->from('product_purchase a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id');
        $this->db->order_by('a.purchase_date', 'desc');
        $this->db->order_by('purchase_id', 'desc');
        $this->db->limit($per_page, $page);
        $query = $this->db->get();

        $last_query = $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    // purchase search by suppplier
    public function purchase_search($supplier_id, $per_page, $page) {
        $this->db->select('a.*,b.supplier_name');
        $this->db->from('product_purchase a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id');
        $this->db->where('a.supplier_id', $supplier_id);
        $this->db->order_by('a.purchase_date', 'desc');
        $this->db->limit($per_page, $page);
        $query = $this->db->get();

        $last_query = $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    // purchase search count
    public function count_purchase_seach($supplier_id) {
        $this->db->select('a.*,b.supplier_name');
        $this->db->from('product_purchase a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id');
        $this->db->where('a.supplier_id', $supplier_id);
        $query = $this->db->get();

        $last_query = $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;
    }

//purchase info by invoice id
    public function purchase_list_invoice_id($invoice_no) {
        $this->db->select('a.*,b.supplier_name');
        $this->db->from('product_purchase a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id');
        $this->db->where('a.chalan_no', $invoice_no);
        $this->db->order_by('a.purchase_date', 'desc');
        $this->db->order_by('purchase_id', 'desc');
        $query = $this->db->get();

        $last_query = $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Select All Supplier List
    public function select_all_supplier() {
        $query = $this->db->select('*')
                ->from('supplier_information')
                ->where('status', '1')
                ->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //purchase Search  List
    public function purchase_by_search($supplier_id) {
        $this->db->select('a.*,b.supplier_name');
        $this->db->from('product_purchase a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id');
        $this->db->where('b.supplier_id', $supplier_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Count purchase
    public function purchase_entry() {
        $purchase_id = date('YmdHis');

        $p_id           = $this->input->post('product_id',TRUE);
        $supplier_id    = $this->input->post('supplier_id',TRUE);
        $supinfo        = $this->db->select('*')->from('supplier_information')->where('supplier_id',$supplier_id)->get()->row();
        $sup_head       = $supinfo->supplier_id.'-'.$supinfo->supplier_name;
        $sup_coa        = $this->db->select('*')->from('acc_coa')->where('HeadName',$sup_head)->get()->row();
        $receive_by     = $this->session->userdata('user_id');
        $receive_date   = date('Y-m-d');
        $createdate     = date('Y-m-d H:i:s');
        $paid_amount    = $this->input->post('paid_amount',TRUE);
        $due_amount     = $this->input->post('due_amount',TRUE);
        $discount       = $this->input->post('discount',TRUE);
        $bank_id        = $this->input->post('bank_id',TRUE);
        $duedate        = $this->input->post('duedate',TRUE);
        $company        = $this->input->post('perusahaan',TRUE);
        if(!empty($bank_id)){
       $bankname = $this->db->select('bank_name')->from('bank_add')->where('bank_id',$bank_id)->get()->row()->bank_name;
    
       $bankcoaid = $this->db->select('HeadCode')->from('acc_coa')->where('HeadName',$bankname)->get()->row()->HeadCode;
   }else{
       $bankcoaid = '';
   }

        //supplier & product id relation ship checker.
        for ($i = 0, $n = count($p_id); $i < $n; $i++) {
            $product_id = $p_id[$i];
            $value = $this->product_supplier_check($product_id, $supplier_id);
            if ($value == 0) {
                $this->session->set_flashdata('error_message', display('product_and_supplier_did_not_match'));
                redirect(base_url('Cpurchase'));
                exit();
            }
        }

        $data = array(
            'purchase_id'        => $purchase_id,
            'chalan_no'          => $this->input->post('chalan_no',TRUE),
            'supplier_id'        => $this->input->post('supplier_id',TRUE),
            'grand_total_amount' => $this->input->post('grand_total_price',TRUE),
            'total_discount'     => $this->input->post('discount',TRUE),
            'purchase_date'      => $this->input->post('purchase_date',TRUE),
            'purchase_details'   => $this->input->post('purchase_details',TRUE),
            'paid_amount'        => $paid_amount,
            'due_amount'         => $due_amount,
            'status'             => 1,
            'bank_id'            =>  $this->input->post('bank_id',TRUE),
            'payment_type'       =>  $this->input->post('paytype',TRUE),
            'duedate'            => $duedate,
            'perusahaan'         => $company,
            
        );
        //Supplier Credit
        $purchasecoatran = array(
          'VNo'            =>  $purchase_id,
          'Vtype'          =>  'Purchase',
          'VDate'          =>  $this->input->post('purchase_date',TRUE),
          'COAID'          =>  $sup_coa->HeadCode,
          'Narration'      =>  'Supplier .'.$supinfo->supplier_name,
          'Debit'          =>  0,
          'Credit'         =>  $this->input->post('grand_total_price',TRUE),
          'IsPosted'       =>  1,
          'CreateBy'       =>  $receive_by,
          'CreateDate'     =>  $receive_date,
          'IsAppove'       =>  1
        ); 
          ///Inventory Debit
       $coscr = array(
      'VNo'            =>  $purchase_id,
      'Vtype'          =>  'Purchase',
      'VDate'          =>  $this->input->post('purchase_date',TRUE),
      'COAID'          =>  10107,
      'Narration'      =>  'Inventory Debit For Supplier '.$supinfo->supplier_name,
      'Debit'          =>  $this->input->post('grand_total_price',TRUE),
      'Credit'         =>  0,//purchase price asbe
      'IsPosted'       => 1,
      'CreateBy'       => $receive_by,
      'CreateDate'     => $createdate,
      'IsAppove'       => 1
    ); 



       // Expense for company
         $expense = array(
      'VNo'            => $purchase_id,
      'Vtype'          => 'Purchase',
      'VDate'          => $this->input->post('purchase_date',TRUE),
      'COAID'          => 402,
      'Narration'      => 'Company Credit For  '.$supinfo->supplier_name,
      'Debit'          => $this->input->post('grand_total_price',TRUE),
      'Credit'         => 0,//purchase price asbe
      'IsPosted'       => 1,
      'CreateBy'       => $receive_by,
      'CreateDate'     => $createdate,
      'IsAppove'       => 1
    ); 
             $cashinhand = array(
      'VNo'            =>  $purchase_id,
      'Vtype'          =>  'Purchase',
      'VDate'          =>  $this->input->post('purchase_date',TRUE),
      'COAID'          =>  1020101,
      'Narration'      =>  'Cash in Hand For Supplier '.$supinfo->supplier_name,
      'Debit'          =>  0,
      'Credit'         =>  $paid_amount,
      'IsPosted'       =>  1,
      'CreateBy'       =>  $receive_by,
      'CreateDate'     =>  $createdate,
      'IsAppove'       =>  1
    ); 

     $supplierdebit = array(
          'VNo'            =>  $purchase_id,
          'Vtype'          =>  'Purchase',
          'VDate'          =>  $this->input->post('purchase_date',TRUE),
          'COAID'          =>  $sup_coa->HeadCode,
          'Narration'      =>  'Supplier .'.$supinfo->supplier_name,
          'Debit'          =>  $paid_amount,
          'Credit'         =>  0,
          'IsPosted'       =>  1,
          'CreateBy'       =>  $receive_by,
          'CreateDate'     =>  $receive_date,
          'IsAppove'       =>  1
        ); 
             
                  // bank ledger
 $bankc = array(
      'VNo'            =>  $purchase_id,
      'Vtype'          =>  'Purchase',
      'VDate'          =>  $this->input->post('purchase_date',TRUE),
      'COAID'          =>  $bankcoaid,
      'Narration'      =>  'Paid amount for Supplier  '.$supinfo->supplier_name,
      'Debit'          =>  0,
      'Credit'         =>  $paid_amount,
      'IsPosted'       =>  1,
      'CreateBy'       =>  $receive_by,
      'CreateDate'     =>  $createdate,
      'IsAppove'       =>  1
    ); 
 // Bank summary for credit

       //new end
       
        $this->db->insert('product_purchase', $data);
       
        $this->db->insert('acc_transaction',$coscr);
        $this->db->insert('acc_transaction',$purchasecoatran);  
        $this->db->insert('acc_transaction',$expense);
        if($this->input->post('paytype') == 2){
          if(!empty($paid_amount)){
        $this->db->insert('acc_transaction',$bankc);
       
        $this->db->insert('acc_transaction',$supplierdebit);
      }
        }
        if($this->input->post('paytype') == 1){
          if(!empty($paid_amount)){
        $this->db->insert('acc_transaction',$cashinhand);
        $this->db->insert('acc_transaction',$supplierdebit); 
        }    
        }       

        $rate       = $this->input->post('product_rate',TRUE);
        $quantity   = $this->input->post('product_quantity',TRUE);
        $t_price    = $this->input->post('total_price',TRUE);
        $discount   = $this->input->post('discount',TRUE);
        $ppn        = $this->input->post('ppn',TRUE);

        for ($i = 0, $n = count($p_id); $i < $n; $i++) {
            $product_quantity = $quantity[$i];
            $product_rate = $rate[$i];
            $product_id = $p_id[$i];
            $total_price = $t_price[$i];
            $disc = $discount[$i];
            $ppn1 = $ppn[$i];

            $data1 = array(
                'purchase_detail_id' => $this->generator(15),
                'purchase_id'        => $purchase_id,
                'product_id'         => $product_id,
                'quantity'           => $product_quantity,
                'rate'               => $product_rate,
                'total_amount'       => $total_price,
                'discount'           => $disc,
                'status'             => 1,
                'ppn'                => $ppn1
            );

            if (!empty($quantity)) {
                $this->db->insert('product_purchase_details', $data1);
            }
        }

        return true;
    }

    //Retrieve purchase Edit Data
    public function retrieve_purchase_editdata($purchase_id) {
        $this->db->select('a.*,
						b.*,
						c.product_id,
						c.product_name,
						c.product_model,
						d.supplier_id,
						d.supplier_name'
        );
        $this->db->from('product_purchase a');
        $this->db->join('product_purchase_details b', 'b.purchase_id =a.purchase_id');
        $this->db->join('product_information c', 'c.product_id =b.product_id');
        $this->db->join('supplier_information d', 'd.supplier_id = a.supplier_id');
        $this->db->where('a.purchase_id', $purchase_id);
        $this->db->order_by('a.purchase_details', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function avalable_value($purchase_id)
    {
        $this->db->select('a.supplier_id,b.product_id');
        $this->db->from('product_purchase a');
        $this->db->join('product_purchase_details b', 'b.purchase_id =a.purchase_id');
        $this->db->WHERE('a.purchase_id',$purchase_id);
        $data = $this->db->get()->row();
        $this->db->select('SUM(a.quantity) as total_purchase,b.*');
        $this->db->from('product_purchase_details a');
        $this->db->join('supplier_product b', 'a.product_id=b.product_id');
        $this->db->where('a.product_id', $data->product_id);
        $this->db->where('b.supplier_id', $data->supplier_id);
        $total_purchase = $this->db->get()->row();

        $this->db->select('SUM(b.quantity) as total_sale');
        $this->db->from('invoice_details b');
        $this->db->where('b.product_id', $data->product_id);
        $total_sale = $this->db->get()->row();

        $available_quantity = ($total_purchase->total_purchase - $total_sale->total_sale);
        return $available_quantity;
    }

    public function retrieve_po_data($po_id) {
        $this->db->select('a.*,
						b.*,
						c.product_id,
						c.product_name,
						c.size,
                        c.merek,
                        c.unit,
                        d.supplier_name,
                        d.address,
                        d.contact,
                        d.phone,
                        d.fax,
                        d.email_address'
                        
        );
        $this->db->from('purchase_order a');
        $this->db->join('purchase_order_details b', 'b.po_id = a.po_id');
        $this->db->join('product_information c', 'c.product_id =b.product_id');
        $this->db->join('supplier_information d', 'd.supplier_id =a.supplier_id');
        $this->db->where('a.po_id', $po_id);
        $this->db->order_by('a.purchase_order', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function retrieve_po_datalist() {
        $this->db->select('a.*,
						b.*,
						c.product_id,
						c.product_name,
						c.size,
                        c.merek,
                        c.unit,
                        d.supplier_name,
                        d.contact,
                        d.phone,
                        d.fax,
                        d.email_address'
                        
        );
        $this->db->from('purchase_order a');
        $this->db->join('purchase_order_details b', 'b.po_id = a.po_id');
        $this->db->join('product_information c', 'c.product_id =b.product_id');
        $this->db->join('supplier_information d', 'd.supplier_id =a.supplier_id');
        $this->db->order_by('a.purchase_order', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }


    public function retrieve_barang_masuk_data($id=null) {
        $this->db->select('a.*,
						b.*,
						c.product_id,
						c.product_name,
						c.size,
                        c.merek,
                        c.unit,
                        d.supplier_name,
                        d.contact,
                        d.phone,
                        d.fax,
                        d.email_address'
                        
        );
        $this->db->from('barang_masuk a');
        $this->db->join('barang_masuk_details b', 'b.bm_id = a.bm_id');
        $this->db->join('product_information c', 'c.product_id =b.product_id');
        $this->db->join('supplier_information d', 'd.supplier_id =a.supplier_id');
        if($id != null || $id==""){
            $this->db->where('a.bm_id',$id);
        }
        $this->db->where('a.bm_id',$id);
        $this->db->order_by('a.barang_masuk', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }



    public function count_purchase_order() {
        $this->db->select('a.*,
						b.*,
						c.product_id,
						c.product_name,
						c.size,
                        c.merek,
                        c.unit,
                        d.supplier_name,
                        d.contact,
                        d.phone,
                        d.fax,
                        d.email_address'
                        
        );
        $this->db->from('purchase_order a');
        $this->db->join('purchase_order_details b', 'b.po_id = a.po_id');
        $this->db->join('product_information c', 'c.product_id =b.product_id');
        $this->db->join('supplier_information d', 'd.supplier_id =a.supplier_id');
        $this->db->order_by('a.purchase_order', 'asc');
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;
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

    //Update Categories
    public function update_purchase() {
          $company      = $this->input->post('perusahaan',TRUE);
          $purchase_id  = $this->input->post('purchase_id',TRUE);
          $paid_amount  = $this->input->post('paid_amount',TRUE);
          $due_amount   = $this->input->post('due_amount',TRUE);
          $bank_id      = $this->input->post('bank_id',TRUE);
          $duedate      = $this->input->post('duedate',TRUE);
          $duedate      = $this->input->post('duedate',TRUE);
        if(!empty($bank_id)){
       $bankname = $this->db->select('bank_name')->from('bank_add')->where('bank_id',$bank_id)->get()->row()->bank_name;
    
       $bankcoaid = $this->db->select('HeadCode')->from('acc_coa')->where('HeadName',$bankname)->get()->row()->HeadCode;
   }
        $p_id = $this->input->post('product_id',TRUE);
        $supplier_id = $this->input->post('supplier_id',TRUE);
        $supinfo =$this->db->select('*')->from('supplier_information')->where('supplier_id',$supplier_id)->get()->row();
        $sup_head = $supinfo->supplier_id.'-'.$supinfo->supplier_name;
        $sup_coa = $this->db->select('*')->from('acc_coa')->where('HeadName',$sup_head)->get()->row();
       $receive_by=$this->session->userdata('user_id');
        $receive_date=date('Y-m-d');
        $createdate=date('Y-m-d H:i:s');


        $data = array(
            'perusahaan'         => $company,
            'purchase_id'        => $purchase_id,
            'chalan_no'          => $this->input->post('chalan_no',TRUE),
            'supplier_id'        => $this->input->post('supplier_id',TRUE),
            'grand_total_amount' => $this->input->post('grand_total_price',TRUE),
            'total_discount'     => $this->input->post('discount',TRUE),
            'purchase_date'      => $this->input->post('purchase_date',TRUE),
            'purchase_details'   => $this->input->post('purchase_details',TRUE),
            'paid_amount'        => $paid_amount,
            'due_amount'         => $due_amount,
            'bank_id'           =>  $this->input->post('bank_id',TRUE),
            'duedate'           =>  $duedate,
            'payment_type'       =>  $this->input->post('paytype',TRUE),
        );
         $cashinhand = array(
      'VNo'            =>  $purchase_id,
      'Vtype'          =>  'Purchase',
      'VDate'          =>  $this->input->post('purchase_date',TRUE),
      'COAID'          =>  1020101,
      'Narration'      =>  'Cash in Hand For Supplier '.$supinfo->supplier_name,
      'Debit'          =>  0,
      'Credit'         =>  $paid_amount,
      'IsPosted'       =>  1,
      'CreateBy'       =>  $receive_by,
      'CreateDate'     =>  $createdate,
      'IsAppove'       =>  1
    ); 
                  // bank ledger
 $bankc = array(
      'VNo'            =>  $purchase_id,
      'Vtype'          =>  'Purchase',
      'VDate'          =>  $this->input->post('purchase_date',TRUE),
      'COAID'          =>  $bankcoaid,
      'Narration'      =>  'Paid amount for Supplier  '.$supinfo->supplier_name,
      'Debit'          =>  0,
      'Credit'         =>  $paid_amount,
      'IsPosted'       =>  1,
      'CreateBy'       =>  $receive_by,
      'CreateDate'     =>  $createdate,
      'IsAppove'       =>  1
    ); 

        
         $purchasecoatran = array(
          'VNo'            =>  $purchase_id,
          'Vtype'          =>  'Purchase',
          'VDate'          =>  $this->input->post('purchase_date',TRUE),
          'COAID'          =>  $sup_coa->HeadCode,
          'Narration'      =>  'Supplier -'.$supinfo->supplier_name,
          'Debit'          =>  0,
          'Credit'         =>  $this->input->post('grand_total_price',TRUE),
          'IsPosted'       =>  1,
          'CreateBy'       =>  $receive_by,
          'CreateDate'     =>  $receive_date,
          'IsAppove'       =>  1
        ); 
          ///Inventory credit
       $coscr = array(
      'VNo'            =>  $purchase_id,
      'Vtype'          =>  'Purchase',
      'VDate'          =>  $this->input->post('purchase_date',TRUE),
      'COAID'          =>  10107,
      'Narration'      =>  'Inventory Devit Supplier '.$supinfo->supplier_name,
      'Debit'          =>  $this->input->post('grand_total_price',TRUE),
      'Credit'         =>  0,//purchase price asbe
      'IsPosted'       => 1,
      'CreateBy'       => $receive_by,
      'CreateDate'     => $createdate,
      'IsAppove'       => 1
    ); 
          // Expense for company
         $expense = array(
      'VNo'            => $purchase_id,
      'Vtype'          => 'Purchase',
      'VDate'          => $this->input->post('purchase_date',TRUE),
      'COAID'          => 402,
      'Narration'      => 'Company Credit For Supplier'.$supinfo->supplier_name,
      'Debit'          => $this->input->post('grand_total_price',TRUE),
      'Credit'         => 0,//purchase price asbe
      'IsPosted'       => 1,
      'CreateBy'       => $receive_by,
      'CreateDate'     => $createdate,
      'IsAppove'       => 1
    ); 

         $supplier_debit = array(
          'VNo'            =>  $purchase_id,
          'Vtype'          =>  'Purchase',
          'VDate'          =>  $this->input->post('purchase_date',TRUE),
          'COAID'          =>  $sup_coa->HeadCode,
          'Narration'      =>  'Supplier . '.$supinfo->supplier_name,
          'Debit'          =>  $paid_amount,
          'Credit'         =>  0,
          'IsPosted'       =>  1,
          'CreateBy'       =>  $receive_by,
          'CreateDate'     =>  $receive_date,
          'IsAppove'       =>  1
        ); 

        if ($purchase_id != '') {
            $this->db->where('purchase_id', $purchase_id);
            $this->db->update('product_purchase', $data);
            //account transaction update
             $this->db->where('VNo', $purchase_id);
            $this->db->delete('acc_transaction');
        
            //supplier ledger update

            $this->db->where('purchase_id', $purchase_id);
            $this->db->delete('product_purchase_details');
        }

        $this->db->insert('acc_transaction',$coscr);
        $this->db->insert('acc_transaction',$purchasecoatran);  
        $this->db->insert('acc_transaction',$expense);
        if($this->input->post('paytype') == 2){
          if(!empty($paid_amount)){
        $this->db->insert('acc_transaction',$bankc);
        $this->db->insert('acc_transaction',$supplier_debit);
      }
        }
        if($this->input->post('paytype') == 1){
          if(!empty($paid_amount)){
        $this->db->insert('acc_transaction',$cashinhand);
        $this->db->insert('acc_transaction',$supplier_debit); 
        }    
        }       

        $rate       = $this->input->post('product_rate',TRUE);
        $p_id       = $this->input->post('product_id',TRUE);
        $quantity   = $this->input->post('product_quantity',TRUE);
        $t_price    = $this->input->post('total_price',TRUE);
        $discount   = $this->input->post('discount',TRUE);
        $ppn        = $this->input->post('ppn',TRUE);

        for ($i = 0, $n = count($p_id); $i < $n; $i++) {
            $product_quantity   = $quantity[$i];
            $product_rate       = $rate[$i];
            $product_id         = $p_id[$i];
            $total_price        = $t_price[$i];
            $disc               = $discount[$i];
            $ppn1               = $ppn[$i];

            $data1 = array(
                'purchase_detail_id' => $this->generator(15),
                'purchase_id'        => $purchase_id,
                'product_id'         => $product_id,
                'quantity'           => $product_quantity,
                'rate'               => $product_rate,
                'total_amount'       => $total_price,
                'discount'           => $disc,
                'ppn'                => $ppn1,
            );


            if (($quantity)) {

                $this->db->insert('product_purchase_details', $data1);
            }
        }
        return true;
    }

    // Delete purchase Item

    public function purchase_search_list($cat_id, $company_id) {
        $this->db->select('a.*,b.sub_category_name,c.category_name');
        $this->db->from('purchases a');
        $this->db->join('purchase_sub_category b', 'b.sub_category_id = a.sub_category_id');
        $this->db->join('purchase_category c', 'c.category_id = b.category_id');
        $this->db->where('a.sister_company_id', $company_id);
        $this->db->where('c.category_id', $cat_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Retrieve purchase_details_data
    public function purchase_details_data($purchase_id) {
        $this->db->select('a.*,b.*,c.*,e.purchase_details,d.product_id,d.product_name,d.product_model');
        $this->db->from('product_purchase a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id');
        $this->db->join('product_purchase_details c', 'c.purchase_id = a.purchase_id');
        $this->db->join('product_information d', 'd.product_id = c.product_id');
        $this->db->join('product_purchase e', 'e.purchase_id = c.purchase_id');
        $this->db->where('a.purchase_id', $purchase_id);
        $this->db->group_by('d.product_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //This function will check the product & supplier relationship.
    public function product_supplier_check($product_id, $supplier_id) {
        $this->db->select('*');
        $this->db->from('supplier_product');
        $this->db->where('product_id', $product_id);
        $this->db->where('supplier_id', $supplier_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        }
        return 0;
    }

    //This function is used to Generate Key
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

    public function purchase_delete($purchase_id = null) {
        //Delete product_purchase table
        $this->db->where('VNo', $purchase_id);
        $this->db->delete('acc_transaction');
        //Delete acc transaction
        $this->db->where('purchase_id', $purchase_id);
        $this->db->delete('product_purchase');
        //Delete product_purchase_details table
        $this->db->where('purchase_id', $purchase_id);
        $this->db->delete('product_purchase_details');
        return true;
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }


    public function purchase_order_delete($purchase_id = null) {
        //Delete product_purchase table
        $this->db->where('po_id', $purchase_id);
        $this->db->delete('purchase_order');
        //Delete acc transaction
        $this->db->where('po_id', $purchase_id);
        $this->db->delete('purchase_order_details');
        
        return true;
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }


    public function barang_masuk_delete($purchase_id = null) {
        //Delete product_purchase table
        $this->db->where('bm_id', $purchase_id);
        $this->db->delete('barang_masuk');
        //Delete acc transaction
        $this->db->where('bm_id', $purchase_id);
        $this->db->delete('barang_masuk_details');
        
        return true;
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

//purchase list date to date
    public function purchase_list_date_to_date($start, $end) {
        $this->db->select('a.*,b.supplier_name');
        $this->db->from('product_purchase a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id');
        $this->db->order_by('a.purchase_date', 'desc');
        $this->db->where('a.purchase_date >=', $start);
        $this->db->where('a.purchase_date <=', $end);
        $query = $this->db->get();

        $last_query = $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
// purchase list for pdf
     public function pdf_purchase_list() {
        $this->db->select('a.*,b.supplier_name');
        $this->db->from('product_purchase a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id');
        $this->db->order_by('a.purchase_date', 'desc');
        $query = $this->db->get();

        $last_query = $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    // csv upload purchase list
        public function purchase_csv_file() {
         $query = $this->db->select('a.chalan_no,a.purchase_id,b.supplier_name,a.purchase_date,a.grand_total_amount')
                ->from('product_purchase a')
                ->join('supplier_information b', 'b.supplier_id = a.supplier_id', 'left')
                ->order_by('a.purchase_date','desc')
                ->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }


    public function purchase_order_entry(){
        $purchase_id    = $this->generator(15);
        $company        = $this->input->post('perusahaan',TRUE);
        $p_id           = $this->input->post('product_id',TRUE);
        $supplier_id    = $this->input->post('supplier_id',TRUE);
        $supinfo        = $this->db->select('*')->from('supplier_information')->where('supplier_id',$supplier_id)->get()->row();
        $sup_head       = $supinfo->supplier_id.'-'.$supinfo->supplier_name;
        $purchase_order = $this->number_generator_po();

        $p_id           = $this->input->post('product_id');
        $quantity       = $this->input->post('product_quantity');
        $rate           = $this->input->post('product_rate');
        $discount       = $this->input->post('discount');
        $discountval    = $this->input->post('discountval');
        $total_price    = $this->input->post('total_price');
        $totalamount    = 0;
        $disc_value    = 0;
        for ($i = 0, $n = count($p_id); $i < $n; $i++) {
            $product_quantity   = $quantity[$i];
            $product_rate       = $rate[$i];
            $product_id         = $p_id[$i];
            $disc               = $discount[$i];
            $discval            = $discountval[$i];
            $total_pricex       = $total_price[$i];
            $data_detail = array(
                'id_po_details' => $this->generator(15),
                'po_id'        => $purchase_id,
                'product_id'   => $product_id,
                'qty'          => $product_quantity,
                'rate'         => $product_rate,
                'discount'     => $disc,
                'val_discount' => $discval,
                'total_price'  => $total_pricex
            );

            $totalamount += $total_pricex;
             $disc_value += $discval;

            if ($product_quantity > 0) {

                $this->db->insert('purchase_order_details', $data_detail);
            }
           
        }


        $valppn = $totalamount*($this->input->post('ppn')/100);

        $data_head = [
            'perusahaan'            =>$company,
            'po_id'                 =>$purchase_id,
            'po_date'               =>$this->input->post('po_date'),
            'supplier_id'           =>$supplier_id,
            'purchase_order'        =>$purchase_order,
            'quot_id'               =>$this->input->post('quot_id'),
            'quot_date'             =>$this->input->post('quot_date'),
            'total_amount'          =>$totalamount,
            'note_delivery_therm'   =>$this->input->post('deltherm'),
            'note_delivery_address' =>$this->input->post('deladdress'),
            'payment_therm'         =>$this->input->post('payment'),
            'remark'                =>$this->input->post('remark'),
            'total_discount'        =>$disc_value,
            'tax'                   =>$this->input->post('ppn'),
            'value_tax'             =>$valppn,
            'created_by'            =>$this->session->userdata('user_id'),
            'created_at'            =>date('Y-m-d H:i:s'),
            'receiver'              => $this->input->post('receiver'),
            'note'                  => $this->input->post('note'),
            'ttd_1'                 => $this->input->post('ttd1'),
            'ttd_2'                 => $this->input->post('ttd2'),
            'ttd_3'                 => $this->input->post('ttd3'),
            'ttd_4'                 => $this->input->post('ttd4'),
            'ttd_5'                 => $this->input->post('ttd5'),
        ];

        $this->db->insert('purchase_order',$data_head);

        return $purchase_id;
    }


    public function update_purchase_order(){

        $company        = $this->input->post('perusahaan');
        $purchase_id    = $this->input->post('po_id');
        $p_id           = $this->input->post('product_id',TRUE);
        $supplier_id    = $this->input->post('supplier_id',TRUE);
        $supinfo        =$this->db->select('*')->from('supplier_information')->where('supplier_id',$supplier_id)->get()->row();
        $sup_head       = $supinfo->supplier_id.'-'.$supinfo->supplier_name;
        $purchase_order = $this->number_generator();

        $p_id           = $this->input->post('product_id');
        $quantity       = $this->input->post('product_quantity');
        $rate           = $this->input->post('product_rate');
        $total_price    = $this->input->post('total_price');
        $discount       = $this->input->post('discount');
        $discountval    = $this->input->post('discountval');
        $disc_value    = 0;
        $totalamount    = 0;
        $this->db->where('po_id',$purchase_id)->delete('purchase_order_details');
        $countR         = $this->db->query("SElECT count_update FROM purchase_order WHERE po_id ='$purchase_id'");
        $arrcountR      = $countR->result_array();
        for ($i = 0, $n = count($p_id); $i < $n; $i++) {
            $product_quantity   = $quantity[$i];
            $product_rate       = $rate[$i];
            $product_id         = $p_id[$i];
            $disc               = $discount[$i];
            $discval            = $discountval[$i];
            $total_pricex       = $total_price[$i];

            $data_detail = array(
                'id_po_details' => $this->generator(15),
                'po_id'         => $purchase_id,
                'product_id'    => $product_id,
                'qty'           => $product_quantity,
                'rate'          => $product_rate,
                'discount'     => $disc,
                'val_discount' => $discval,
                'total_price'   => $total_pricex
            );

            $totalamount += $total_pricex;


            if ($product_quantity > 0) {

                $this->db->insert('purchase_order_details', $data_detail);
            }
        }

        $persenttax = $this->input->post('ppn');
        $vtax       = $totalamount*$persenttax/100;
        $data_head = [
            'perusahaan'            =>$company,
            'po_date'               =>$this->input->post('po_date'),
            'supplier_id'           =>$supplier_id,
            'quot_id'               =>$this->input->post('quot_id'),
            'quot_date'             =>$this->input->post('quot_date'),
            'total_amount'          =>$totalamount,
            'note_delivery_therm'   =>$this->input->post('deltherm'),
            'note_delivery_address' =>$this->input->post('deladdress'),
            'payment_therm'         =>$this->input->post('payment'),
            'remark'                =>$this->input->post('remark'),
            'total_discount'        =>$disc_value,
            'tax'                   =>$persenttax,
            'value_tax'             =>$vtax,
            'updated_at'            =>date('Y-m-d H:i:s'),
            'receiver'              => $this->input->post('receiver'),
            'note'                  => $this->input->post('note'),
            'ttd_1'                 =>$this->input->post('ttd1'),
            'ttd_2'                 =>$this->input->post('ttd2'),
            'ttd_3'                 =>$this->input->post('ttd3'),
            'ttd_4'                 =>$this->input->post('ttd4'),
            'ttd_5'                 =>$this->input->post('ttd5'),
            'count_update'          => $arrcountR[0]['count_update']+1,
        ];

        $this->db->where('po_id',$purchase_id)->update('purchase_order',$data_head);

        return $purchase_id;
    }


    public function update_barang_masuk(){

        $purchase_id = $this->input->post('bmid');
        $p_id = $this->input->post('product_id',TRUE);
        $supplier_id = $this->input->post('supplier_id',TRUE);
        $supinfo =$this->db->select('*')->from('supplier_information')->where('supplier_id',$supplier_id)->get()->row();
        $sup_head = $supinfo->supplier_id.'-'.$supinfo->supplier_name;
        $purchase_order = $this->bm_number_generator();

        $p_id = $this->input->post('product_id');
        $quantity = $this->input->post('product_quantity');
        $remarks = $this->input->post('remarks');

        $this->db->where('bm_id',$purchase_id)->delete('barang_masuk_details');
        for ($i = 0, $n = count($p_id); $i < $n; $i++) {
            $product_quantity = $quantity[$i];
            $remarksx = $remarks[$i];
            $product_id = $p_id[$i];

            $data_detail = array(
                'bm_details_id' => $this->generator(15),
                'bm_id'        => $purchase_id,
                'product_id'         => $product_id,
                'qty'           => $product_quantity,
                'remarks'               => $remarksx
            );



            if ($product_quantity > 0) {

                $this->db->insert('barang_masuk_details', $data_detail);
            }
        }


        

        $data_head = [
            'supplier_id'=>$supplier_id,
            'po_id'=>$this->input->post('po_id'),
            'bm_date'=>$this->input->post('bm_date'),
            'bm_details'=>$this->input->post('keterangan'),
            'updated_at'=>date('Y-m-d H:i:s')
        ];

        $this->db->where('bm_id',$purchase_id)->update('barang_masuk',$data_head);

        return $purchase_id;
    }


    public function barang_masuk_entry(){
        $bm_id = $this->generator(15);

        $p_id = $this->input->post('product_id',TRUE);
        $supplier_id = $this->input->post('supplier_id',TRUE);
        $supinfo =$this->db->select('*')->from('supplier_information')->where('supplier_id',$supplier_id)->get()->row();
        $id_user = $this->session->userdata('user_id');
        $sup_head = $supinfo->supplier_id.'-'.$supinfo->supplier_name;
        $bm_order = $this->bm_number_generator();

        $p_id = $this->input->post('product_id');
        $quantity = $this->input->post('product_quantity');
        $remarks = $this->input->post('remarks');

        for ($i = 0, $n = count($p_id); $i < $n; $i++) {
            $product_quantity = $quantity[$i];
            $remarksx = $remarks[$i];
            $product_id = $p_id[$i];

            $data_detail = array(
                'bm_details_id' => $this->generator(15),
                'bm_id' => $bm_id,
                'product_id' => $product_id,
                'qty' => $product_quantity,
                'remarks' => $remarksx
            );


            if ($product_quantity > 0) {

                $this->db->insert('barang_masuk_details', $data_detail);
            }
        }

        $data_head = [
            'bm_id'=>$bm_id,
            'bm_date'=>$this->input->post('bm_date'),
            'supplier_id'=>$supplier_id,
            'barang_masuk'=>$bm_order,
            'bm_details'=>$this->input->post('keterangan'),
            'po_id'=>$this->input->post('po_id'),
            'created_by'=>$this->session->userdata('user_id'),
            'created_at'=>date('Y-m-d H:i:s')
        ];

        $this->db->insert('barang_masuk',$data_head);

        return $bm_id;
    }


    public function number_generator() {
        $this->db->select_max('purchase_order', 'po_no');
        $query = $this->db->get('purchase_order');
        $result = $query->result_array();
        $invoice_no = $result[0]['po_no'];
        if ($invoice_no != '') {
            $invoice_no = $invoice_no + 1;
        } else {
            $invoice_no = 1000;
        }
        return $invoice_no;
    }
    public function number_generator_po() {
        $this->db->select_max('purchase_order', 'po_no');
        $query = $this->db->get('purchase_order');
        $result = $query->result_array();
        $invoice_no = $result[0]['po_no'];
        if ($invoice_no != '') {
            $invoice_no = $invoice_no + 1;
        } else {
            $invoice_no = 10000;
        }
        return $invoice_no;
    }


    public function bm_number_generator() {
        $this->db->select_max('barang_masuk', 'bm_no');
        $query = $this->db->get('barang_masuk');
        $result = $query->result_array();
        $bm_no = $result[0]['bm_no'];
        if ($bm_no != '') {
            $bm_no = $bm_no + 1;
        } else {
            $bm_no = 1000;
        }
        return $bm_no;
    }

}
