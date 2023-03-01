<?php
$CI = & get_instance();
$CI->load->model('Web_settings');
$Web_settings = $CI->Web_settings->retrieve_setting_editdata();
$user_type = $this->session->userdata('user_type');
$user_id = $this->session->userdata('user_id');
$currency = $currency_details[0]['currency'];
$position = $currency_details[0]['currency_position'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- <meta http-equiv="refresh" content="2;url=<?=site_url('Cquotation/quotation_details_data/'.$this->uri->segment(3));?>" /> -->
    <title>Document QUOTATION</title>
    <link href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>" rel="stylesheet" type="text/css" />
    <!-- <script src="<?php echo base_url("assets/package.js"); ?>"></script> -->
    <script src="<?php echo base_url("assets/table.js"); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery-3.4.1.min.js?v=3.4.1') ?>" type="text/javascript"></script>
    <style>
 /* @media print{ */

   table {page-break-before: auto;}
    tr{page-break-inside: avoid; page-break-after: auto}
    td{page-break-inside:  avoid;page-break-after: auto;}
    thead{display:table-header-group !important;}
     thead .logo{page-break-after:always;}
    .h-50{
      max-height: 100px;
      width: 50%;
      margin-bottom: 20px;
    }
    /* .title {
      position: running(titleRunning);
    } */
   /* @page{ */
      /* size: A4 landscape; */
      /* margin-left: 10mm;
      margin-right: 10mm; */
      /* margin-top: 45mm; */
      /* display-internal: table-header-group !important; */
      /* @bottom-center {
        content: "Page " counter(page) " of " counter(pages);
      } */
      /* @top-left { */
        /* margin-top:20px; */
        /* content: element(titleRunning); */
      /* } */

     
  /* body{
    font-family: "Verdana", Courier, monospace;
    font-size: 9pt;
  } */

body {
  margin-top: 2.3cm;
  margin-left: 0.2cm;
  margin-right: 0.2cm;
  margin-bottom: 0.5cm;
  page-break-before: always;
}

/** Define the header rules **/
header {
    position: fixed;
    top: 0cm;
    left: 0cm;
    right: 0cm;
    height: 2cm;
    /** Extra personal styles **/
    /* background-color: #eaeaea; */
    color: black;
    text-align: left;
    line-height: 1.5cm;
    
}

/** Define the footer rules **/
footer {
    position: fixed;
    bottom: 0cm;
    left: 0cm;
    right: 0cm;
    height: 0.5cm;

    /** Extra personal styles **/
    /* background-color: #eaeaea; */
    color: black;
    text-align: center;
    line-height: 0.5cm;
}
footer .pagenum:before {
    content: counter(page);
}
  </style>
</head>
<body>
  <header>
  <!-- <div class="title pagedjs_margin-top pagedjs_margin-content"> -->
   <?php
    if ($quot_main[0]['perusahaan'] == "CIKA") :?>
      <div style="text-align:right;margin-top:-50px;">F-CIKA-001-00</div>
      <img src="<?php  echo $Web_settings[0]['invoice_logo'];?>" class="h-50" alt="logo" style="margin-top:-20px;"> 
    <?php else :?>
       <div style="text-align:right;margin-top:-50px;">F-KIA-001-00</div>
       <img src="<?php  echo $Web_settings[0]['invoice_logo_2'];?>" class="h-50" alt="logo"  style="margin-top:-20px;"> 
    <?php endif;?>
     <hr style="border-weight:10px;border-color:blue;margin-top:-15px;" >
  </header>
  <footer>
    <div class="pagenum-container">Page <span class="pagenum"></span></div>
  </footer>
     <!-- <hr style="margin-top: -10px;border-weight:10px;border-color:blue;"> -->
     <p class="text-center hd" border="none" style="font-size: 12pt;">QUOTATION</p>
  <!-- </div> -->
  <table width="100%"  style="margin-bottom:20px;">          
    <tr valign="top">
      <td>Company</td>
      <td>:</td>
      <td><?php echo $customer_info[0]['customer_name'];?></td>
      <td>Date</td>
      <td>:</td>
      <td><?php echo date('F dS, Y',strtotime($quot_main[0]['quotdate']));?></td>
    </tr>
    <tr valign="top">
        <td>Attention</td>
        <td>:</td>
        <td><?php echo $customer_info[0]['contact'];?></td>
        <td>Quotation</td>
        <td>:</td>
        <td><?php echo html_escape($quot_main[0]['quot_no'].".");if ($rev !=null):if($rev[0]['jml'] != "0"):echo html_escape("R".$rev[0]['jml'].".");endif;endif;echo html_escape(substr(strtoupper($quot_main[0]['first_name']),0,2)); ?>/<?=$quot_main[0]['perusahaan']."-QTT"?>/<?=romawi(intval(date('m',strtotime($quot_main[0]['quotdate']))));?>/<?=date('Y',strtotime($quot_main[0]['quotdate']));?></td>
    </tr>

    <tr valign="top">
        <td>Phone</td>
        <td>:</td>
        <td><?php echo $customer_info[0]['phone'];?></td>
        <td>Tax Registrasion No.</td>
        <td>:</td>
        <td>
          <?php 
          if ($quot_main[0]['perusahaan']=='CIKA'):
              echo html_escape($tax_id[0]['reg_no']);
          else : echo '-';
          endif;
          ?>
        </td>
    </tr>

    <tr valign="top">
        <td>Email</td>
        <td>:</td>
        <td><?php echo $customer_info[0]['customer_email'];?></td>
        <td>Marketing</td>
        <td>:</td>
        <td><?php echo $quot_main[0]['marketing'];?></td>
    </tr>

    <tr>
        <td valign="top" rowspan="3">Address</td>
        <td valign="top" rowspan="3">:</td>
        <td valign="top" rowspan="3"><div style="width:400px;"><?php echo $customer_info[0]['customer_address'];?></div></td>
        <td>Mobile</td>
        <td>:</td>
        <td><?php echo $quot_main[0]['phone'];?></td>
    </tr>

    <tr valign="top">
        <td>Email</td>
        <td>:</td>
        <td><?php echo $quot_main[0]['emailmarketing'];?></td>
    </tr>
</table>
  <table width="100%" class="table table-sm w-100" cellpadding="1">
        <thead style="display: table-header-group !important;">
            <tr bgcolor="#eeeeee">
              <th style="text-align:center; border:1px solid #000;"><strong>No</strong></th>
              <th style="text-align:center; border:1px solid #000;"><strong>Code Number</strong></th>
              <th style="text-align:center; border:1px solid #000;"><strong>Part Description</strong></th>
              <th style="text-align:center; border:1px solid #000;"><strong>Quantity</strong></th>              
              <th style="text-align:center; border:1px solid #000;"><strong>Unit</strong></th>
              <th style="text-align:center; border:1px solid #000;"><strong>Unit Price</strong></th>
              <th style="text-align:center; border:1px solid #000;"><strong>Discount</strong></th>
              <th style="text-align:center; border:1px solid #000;"><strong>Nett Price</strong></th>
              <th style="text-align:center; border:1px solid #000;"><strong>Total Price</strong></th>
            </tr>
        </thead>
    <tbody>
        <?php 
        if(!empty($quot_product)){

          $no = 0;
              $totalitem = 0;
              $totaldiskon= 0;
              $totalharga = 0;
              $bk=1;
          foreach($quot_product as $row):
            $no++;
            ?>
            <tr valign="top">
              <td style="text-align:center;border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #cccccc;;"><?php echo $no;?></td>
                  <td style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #cccccc;;"><?php echo $row['product_id'];?></td>
              <td style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #cccccc;;"><?php echo $row['product_name'].' '.$row['size']. ' ('.$row['merek'].')';?></td>
                    <td style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #cccccc;;"><?php echo $row['used_qty'];?></td>                      
              <td style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #cccccc;;"><?php echo $row['unit'];?></td>
              <td style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #cccccc;;"><?php echo number_format($row['rate'],2);?></td>
              <td style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #cccccc;;"><?php if ($row['discount_per']==''):echo number_format('0',2);else:echo number_format($row['discount_per'],2);endif;?></td>
              <td style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #cccccc;;">
                <?php 
                  if($row['discount_per'] > 0) :
                      $hdsc   = $row['rate'] * $row['discount_per']/100;
                      $hrg    = $row['rate'] - $hdsc;
                      echo number_format(ROUND($hrg),2);
                      else:
                          echo number_format($row['rate'],2);
                  endif;
                  ?>
              </td>
              <td style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #cccccc;;border-bottom:1px solid #cccccc;"><?php echo number_format($row['total_price'],2);?></td>
                      
            </tr>
            <?php
                  $totalharga += $row['total_price'];
          endforeach;
        }
          ?>
            <tr>
                <th colspan="8" style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;">Amount</th>
                <th style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;"><?php echo number_format($quot_main[0]['item_total_amount'],2);?></th>
            </tr>
      </tbody>
      </table>
            <!-- <tr> -->
              <!-- <td colspan="9"> -->
                <?php if(!empty($quot_service)):?>
                  <table border="0" width="100%" class="table" cellpadding="1">
                  <thead> 
                  <tr bgcolor="#eeeeee">
                      <th style="text-align:center; border:1px solid #000;">No</th>
                      <th style="text-align:center; border:1px solid #000;">Service Name</th>
                      <th style="text-align:center; border:1px solid #000;">Quantity</th>
                      <th style="text-align:center; border:1px solid #000;">Unit Price</th>              
                      <th style="text-align:center; border:1px solid #000;">Discount</th>
                      <th style="text-align:center; border:1px solid #000;">Amount Price</th>                 
                      <th style="text-align:center; border:1px solid #000;">Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                        $no = 0;
                        $totalitem = 0;
                        $totaldiskon= 0;
                        $totalService = 0;
                      foreach($quot_service as $ser):
                        $no++;
                        ?>
                        <tr valign="top">
                          <td style="border-left:1px solid #000;border-right:1px solid #000;"><?php echo $no;?></td>
                          <td style="border-left:1px solid #000;border-right:1px solid #000;"><?php echo $ser['service_name'];?></td>
                          <td style="border-left:1px solid #000;border-right:1px solid #000;text-align:center"><?php echo $ser['qty'];?></td>
                          <td style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;"><?php echo $ser['charge'];?></td>                      
                          <td style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;"><?php echo $ser['discount'];?></td>
                          <td style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;">
                          <?php 
                            if($ser['discount'] > 0):
                                $cdsc  = $ser['charge'] * $ser['discount']/100;
                                $cser  = $ser['charge'] - $cdsc;
                                echo number_format(ROUND($cser),2);
                                else :
                                    echo number_format($ser['charge'],2);
                            endif;
                          ?>
                          </td>                                           
                          <td style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;"><?php echo $ser['total'];?></td>
                        </tr>
                        <?php
                              $totalService += $ser['total'];
                      endforeach;
                      ?>
                      <tr>
                          <th colspan="6" style="border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;text-align:right;">Amount</th>
                          <th style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;"><?php echo number_format($totalService,2);?></th>
                      </tr>
                    </tbody>
                  </table>
                  <div class="row">
                    <div class="col-md-7"></div>
                    <div class="col-md-5">
                        <div class="row bg-info valign-cneter"  style="min-height:50px;font-size:12pt">
                            <div class="col-md-6 text-left"><strong>AMOUNT NET :</strong></div>
                            <div class="col-md-6 text-right"><strong><?= number_format(($quot_main[0]['item_total_amount']+$quot_main[0]['service_total_amount']),2);?>&nbsp;&nbsp;</strong></div>
                        </div>
                    </div>
                </div>
                <?php endif;?>
              <!-- </td> -->
            <!-- </tr> -->
          <!-- </tbody> -->
        <!-- </table> -->
           
        <p><b><u>The terms and condition for the above prices are as follows:</u></b></p>        
          <table width="100%" border="0" cellspacing="0">
              <tr valign="top">
                <td width="10%">VAT</td>
                <td width="1%">:</td>
                <td widht="35%">Prices quoted excluding 11% VAT</td>
                <td width="10%">Delivery Time</td>
                <td width="1%">:</td>
                <td widht="35%"><?= $quot_main[0]['delivery_time']." ".$quot_main[0]['delivery_time_sat'];?></td>         
              </tr>

              <tr valign="top">
                <td width="10%">Instalation</td>
                <td width="1%">:</td>
                <td widht="35%" style="padding-right: 70px;">Prices quoted <?= substr($quot_main[0]['type'],0,6);?>ing installation cost</td>
                <td width="10%">Validity</td>
                <td width="1%">:</td>
                <td widht="35%"><?= $quot_main[0]['quotation_exp']." ".$quot_main[0]['quotation_exp_sat'];?></td>         
              
              </tr>

              <tr valign="top">
                <td width="10%">Unloading</td>
                <td width="1%">:</td>
                <td widht="35%">Unloading of goods is the responsibility of the <?php if ($quot_main[0]['type']=="Include"): echo "seller"; else: echo "buyer";endif;?>.</td>
                <td width="10%">TOP</td>
                <td width="1%">:</td>
                <td widht="35%"><?= $quot_main[0]['top'];?></td>
             
              </tr>
              
              <tr valign="top">
                <td width="10%">Stock</td>
                <td width="1%">:</td>
                <td widht="35%">Stock availability is not binding</td>
                <td width="10%"></td>
                <td width="1%"></td>
                <td widht="35%"></td>
              </tr> 
              
          </table>
          
          <table border="0" cellpadding="3" cellspacing="0" width="" style="margin-top:15px;">
            <tr>
              <td><b>Sincerely yours,</b><br><br><br><br><br><b><i>This is a Computer Generated Proposal, No Signature Required</i><br><?=$this->session->userdata('user_name');?></b></td>
            </tr>
          </table>
      
    </div>
     <script>
      $(document).ready(function(){
        setTimeout(function(){
          window.print();
        },3000);
      })
   
    if (isset($pdf)) {
        $x = 550;
        $y = 800;
        $text = "{PAGE_NUM} of {PAGE_COUNT}";
        $font = null;
        $size = 12;
        $color = array(255,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        // header
        $pdf->page_text(250,10,'HEADER: GGG',$font,$size,$color,$word_space,$char_space,$angle);
        // footer
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    }
</script>
</body>
</html>