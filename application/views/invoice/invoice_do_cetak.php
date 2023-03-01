<?php
$CI = & get_instance();
$CI->load->model('Web_settings');
$CI->load->library('linvoice');
$Web_settings = $CI->Web_settings->retrieve_setting_editdata();
$user_type = $this->session->userdata('user_type');
$user_id = $this->session->userdata('user_id');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <title>Document</title>
    <link href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url("assets/package.js"); ?>"></script>
    <script src="<?php echo base_url("assets/table.js"); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery-3.4.1.min.js?v=3.4.1') ?>" type="text/javascript"></script>
    <style>
      /* @media print {
       .title {
            position: running(titleRunning);
          }
         @page{
            size: letter portrait;
            margin-left: 10mm;
            margin-right: 10mm;
            margin-top: 50mm;
            margin-bottom: 1.99mm;
            @bottom-center {
              content: "Page " counter(page) " of " counter(pages);
            }
            @top-left {
              content: element(titleRunning);
            }
        }
      body{
        font-family: "Verdana", Courier, monospace;
        font-size: 9pt;
      }
    } */
   body {
  margin-top: 2.7cm;
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
    <!-- <div class="title"> -->
        <?php
        if ($query[0]['comp'] == "CIKA") :?>
          <div style="text-align:right;margin-bottom: 10px;margin-top:-70px;">F-CIKA-003-00</div>
          <img src="<?= $Web_settings[0]['invoice_logo'];?>" class="img-fluid" alt="logo" width="100%" height="100" style="margin-top:-20px;">
        <?php else :?>
          <div style="text-align:right;margin-bottom: 10px;margin-top:-70px;">F-KIA-003-00</div>
           <img src="<?php  echo $Web_settings[0]['invoice_logo_2'];?>" class="img-fluid" alt="logo" width="100%" height="100" style="margin-top:-20px;"> 
        <?php endif;?>
         <hr style="weight:5px !important;border-color:blue;margin-top:-2px">
         </header>
        <footer>
          <div class="pagenum-container">Page <span class="pagenum"></span></div>
        </footer>
         <center>
          <h4 style="margin-bottom: 15px;margin-top: -10px;">SALES DELIVERY ORDER</h4>
        </center>
    <!-- </div> -->
    <div class="content" style="text-align:left; margin-top: 0px;">  

      <table border="0" width="100%" cellpadding="1" style="margin-bottom:30px;">
          <tr valign="top">
            <td width="10%">Name</td>
            <td width="1%">:</td>
            <td width="25%"><?php echo $query[0]['customer_name'];?></td>
            <td width="10%" style="padding-left:70px;">DO No.</td>
            <td width="1%">:</td>
            <td width="25%"><?=$query[0]['do_number'];?>_LD/<?= $query[0]['comp'];?>-DOS/<?=romawi(intval(date('m',strtotime($query[0]['do_date'])))).'/'.date('Y',strtotime($query[0]['do_date']));?></td>
          </tr>
          <tr valign="top">
            <td>Phone</td>
            <td>:</td>
            <td><?=$query[0]['phone'];?></td>
            <td style="padding-left:70px;" width="20%">DO Date</td>
            <td>:</td>
            <td><?php echo date('F dS, Y',strtotime($query[0]['do_date']));?></td>
          </tr>

          <tr valign="top">
            <td>email</td>
            <td>:</td>
            <td><?=$query[0]['customer_email'];?></td>
            <td style="padding-left:70px;">PO No.</td>
            <td>:</td>
            <td><?=$query[0]['po_id'];?></td>
          </tr>

          <tr valign="top">
            <td>Address</td>
            <td>:</td>
            <td><?php echo $query[0]['customer_address'];?></td>
            <!-- <td>Fax</td>
            <td>:</td>
            <td><div style="width:220px;"><?php //echo $query[0]['fax'];?></div></td> -->
            <td style="padding-left:70px;">PO Date</td>
            <td>:</td>
            <td><?php echo date('F dS, Y',strtotime($query[0]['po_date']));?></td>
          </tr>
          
        </table> 
      <table border="0" width="100%" class="table table-sm" cellpadding="1">
        <thead>
          <tr bgcolor="#eeeeee">
              <th style="text-align:center; border:1px solid #000;" width="5%">No</th>
              <th style="text-align:center; border:1px solid #000;" width="35%">Parts</th>
              <th style="text-align:center; border:1px solid #000;" width="10%">Code</th>
              <th style="text-align:center; border:1px solid #000;" width="10%">Quantity</th>
              <th style="text-align:center; border:1px solid #000;" width="10%">Unit</th>
              <th style="text-align:center; border:1px solid #000;" width="10%">Remarks</th>
            </tr>
        </thead>
      <tbody>
        <?php 
        if(!empty($query)){

          $no = 0;
          foreach($query as $row):
            $no++;
            ?>
            <tr valign="top">
              <td width="5%" style="text-align:center;border-left:1px solid #000;border-right:1px solid #000; border-bottom:1px solid #cccccc;"><?php echo $no;?></td>            
                    <td width="35%" style="border-left:1px solid #000;border-right:1px solid #000; border-bottom:1px solid #cccccc;"><?php echo $row['product_name'].' '.$row['size']. ' ('.$row['merek'].')';?></td>                                           
                    <td width="10%" style="text-align:left;border-left:1px solid #000;border-right:1px solid #000; border-bottom:1px solid #cccccc;"><?php echo $row['product_id'];?></td>
                    <td width="10%" style="text-align:center;border-left:1px solid #000;border-right:1px solid #000; border-bottom:1px solid #cccccc;"><?php echo $row['qty'];?></td>
                <td width="10%" style="text-align:center;border-left:1px solid #000;border-right:1px solid #000; border-bottom:1px solid #cccccc;"><?php echo $row['unit'];?></td>
                    <td width="10%" style="border-left:1px solid #000;border-right:1px solid #000; border-bottom:1px solid #cccccc;"><?php echo $row['remarks'];?></td>
                      
            </tr>
            <?php
                  
          endforeach;
        }
          ?>
          </tbody>
        </table> 
        <div style="border:2px solid #000; border-radius:10px; width:400px; padding:5px; margin-bottom:10px;margin-top: 20px;">
           <b>Note : </b><br>
          Barang-barang yang sudah dibeli tidak dapat ditukar/dikembalikan.<br>
          Goods that have been purchased cannot be exchanged / returned
        </div>
        
              <table width="100%" cellpadding="4" cellspacing="10">
                <tr>
                  <td width="5%" style="border:1px solid #000;text-align: center;"><?php if ($query[0]['type'] == 'To be invoice later') { ?>&#10004; <?php } ?> </td>
                  <td width="5%">&nbsp;</td>
                  <td widht="35%">To be invoiced later</td>
                </tr>
                <tr>
                  <td width="5%" style="border:1px solid #000;text-align: center;"><?php if ($query[0]['type'] == 'On loan') {?>&#10004; <?php } ?> </td>
                  <td width="5%">&nbsp;</td>
                  <td widht="35%">On Loan</td>
                </tr>
                <tr>
                  <td width="5%" style="border:1px solid #000;text-align: center;"><?php if ($query[0]['type'] == 'Sample') {?>&#10004; <?php } ?> </td>
                  <td width="5%">&nbsp;</td>
                  <td widht="35%">Sample</td>
                </tr>                
            </table>
            <br>
        <table width="100%" style="margin-top:30px;">
          <tr>
            <td width="30%" style="text-align:center;padding-right:80px">Authorized-Customer</td>
            <td width="15%" style="text-align:center;">Logistic Manager</td>
            <td width="15%" style="text-align:center;">Logistic Admin</td>
              
          </tr>
          <tr>
            <td width="30%" style="text-align:center;padding-top:80px;padding-right:60px;">( ________________ )</td>
            <td width="17.5%" style="text-align:center;padding-top:80px;">( _____________ )</td>
            <td width="17.5%" style="text-align:center;padding-top:80px;">( _____________ )</td>        
          </tr>
      </table>       
    </div>
    
</body>
</html>