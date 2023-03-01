<?php
$CI = & get_instance();
$CI->load->model('Web_settings');
$CI->load->library('linvoice');
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
    <!-- <meta http-equiv="refresh" content="2;url=<?php
    
    if($target == null){
      echo site_url('Cpurchase/manage_purchase_order');
    } else {
      echo site_url('cpurchase/manage_purchase_order');
    }?>" /> -->
    <title>Document</title>
    <link href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>" rel="stylesheet" type="text/css" />
    <!-- <script src="<?php echo base_url("assets/table.js"); ?>"></script> -->
    <!-- <script src="<?php echo base_url("assets/package.js"); ?>"></script> -->
    <script src="<?php echo base_url('assets/js/jquery-3.4.1.min.js?v=3.4.1') ?>" type="text/javascript"></script>
    <style>
      /* @media print{
        .title {
            position: running(titleRunning);
          }
         @page{
            size: letter landscape;
            margin-left: 10mm;
            margin-right: 10mm;
            @bottom-center {
              content: "Page " counter(page) " of " counter(pages);
            }
            @top-left {
              margin-top:20px;
              content: element(titleRunning);
            }
            
        }
        table {page-break-before: auto;}
      tr{page-break-inside: avoid; page-break-after: auto}
      td{page-break-inside:  avoid;page-break-after: auto;}
      thead{display:table-header-group;}

      }
      body{
        font-family: "Verdana", Courier, monospace;
        font-size: 9pt;
      /* } */
      .h-50{
      width: 50%;
      max-height: 128px;
      margin-bottom: 20px;
    }
    thead { display:table-header-group;  }
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
         <div style="text-align: right;padding-top: 10px;margin-top:-70px;"> F-<?=$query[0]['perusahaan'] ?>-005-00</div>

    <?php if ($query[0]['perusahaan'] == "CIKA") :?>  
      <img src="<?php  echo $Web_settings[0]['invoice_logo'];?>" class="h-50" alt="logo" > 
    <?php elseif ($query[0]['perusahaan'] == "KIA") :?> 
       <img src="<?php  echo $Web_settings[0]['invoice_logo_2'];?>" class="h-50" alt="logo"> 
    <?php else :?>
       <img src="<?= base_url();?>my-assets/image/logo/st.png" class="h-50" alt="logo"> 
    <?php endif;?>
    <hr style="margin-top: -10px;border-weight:10px;border-color:blue;margin-top:-18px;">
    </header>
    <footer>
    <div class="pagenum-container">Page <span class="pagenum"></span></div>
  </footer>
    <p style="margin-top:2px;font-size: 12pt;text-align:center">PURCHASE</p>
  <!-- </div> -->
  <table width="100%" class="table table-sm" cellpadding="1" style="margin-top: 20px;">
      <tbody>
        <tr>
          <td colspan="9" style="border-top:0px; border-left: 0px;border-bottom:0px !important;">
       
          <table width="100%" style="border-top:0px; border-left: 0px !important;border-bottom:0px !important;">
           <!--  <tr>
              <td colspan="6"><u>Dear :</u></td>
            </tr> -->
            <tr valign="top">
              <td>Company</td>
              <td>:</td>
              <td><?php echo $query[0]['supplier_name'];?></td>
              <td>Invoice No</td>
              <td>:</td>
              <td>
                <?php 
                echo $query[0]['chalan_no'];                 

                ?>
              </td>
            </tr>
            <tr valign="top">
              <td>Phone</td>
              <td>:</td>
              <td><?php echo $query[0]['phone'];?></td>
              <td>Billing Date</td>
              <td>:</td>
              <td><?php echo date('F dS, Y',strtotime($query[0]['purchase_date']));?></td>
            </tr>

            <tr valign="top">
             <!--  <td>Fax</td>
              <td>:</td>
              <td><?=$query[0]['fax'];?></td> -->
                <td>Attention</td>
              <td>:</td>
              <td><div style="width:220px;"><?php echo $query[0]['contact'];?></div></td>
             <!--  <td>Quotation No.</td>
              <td>:</td>
              <td><?= $query[0]['quot_id'];?></td> -->
            </tr>

            <tr valign="top">
              <td>Email</td>
              <td>:</td>
              <td><div style="width:220px;"><?php if($query[0]['emailnumber'] !=""):echo $query[0]['emailnumber'];else: echo $query[0]['email_address'];endif;?></div></td>
             <!--  <td>NPWP</td>
              <td>:</td>
              <td><?= $npwp[0]['npwp'];?></td> -->
            </tr>
            <tr valign="top">
              <td>Address</td>
              <td>:</td>
              <td><div style="width:220px;"><?php echo $query[0]['address'];?></div></td>
             <!--  <td>Date</td>
              <td>:</td>
              <td><?php echo date('F dS, Y',strtotime($query[0]['quot_date']));?></td> -->
            </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td colspan="9" style="border-top:0px; border-left: 0px;"><p>Please deliver the following goods listed below :</p></td></tr>
  </tr>
  </tbody>
  </table>
    <table width="100%" style="margin-top:-30px; border-left: 0px !important;border-bottom:0px !important;">
          <!--  -->
          <thead>
        <tr bgcolor="#eeeeee">
          <th style="text-align:center; border:1px solid #000;" width="5%">No</th>              
          <th style="text-align:center; border:1px solid #000;" width="25%">Description</th>              
              <th style="text-align:center; border:1px solid #000;" width="10%">Code</th>
          <th style="text-align:center; border:1px solid #000;" width="10%">Quantity</th>
              <th style="text-align:center; border:1px solid #000;" width="5%">Unit</th>
          <th style="text-align:center; border:1px solid #000;" width="10%">Unit Price (IDR)</th>
          <th style="text-align:center; border:1px solid #000;" width="5%">Discount (%)</th>
          <th style="text-align:center; border:1px solid #000;" width="15%">Amount (IDR)</th>
          <!-- <th style="text-align:center; border:1px solid #000;" width="15%">Remark</th> -->
        </tr>
      </thead>
      	<?php 
      	if(!empty($query)){

      		$no = 0;
              $totalharga = 0;
              $totalppn = 0;
      		foreach($query as $row):
      			$no++;
      			?>
      			<tr valign="top">
      				<td style="text-align:center;border:1px solid #000;border-bottom: 1px solid #cccccc;" width="5%"><?php echo $no;?></td>
              <td style="border:1px solid #000;border-bottom: 1px solid #cccccc;" width="25%"><?php echo $row['product_name'].' '.$row['size']. ' ('.$row['merek'].')';?></td>
              <td style="text-align:center;border:1px solid #000;border-bottom: 1px solid #cccccc;" width="10%"><?= $row['product_id'];?></td>
              <td style="text-align:center;border:1px solid #000;border-bottom: 1px solid #cccccc;" width="10%"><?php echo $row['quantity'];?></td>
      				<td style="text-align:center;border:1px solid #000;border-bottom: 1px solid #cccccc;" width="5%"><?php echo $row['unit'];?></td>
      				<td style="text-align:right;border:1px solid #000;border-bottom: 1px solid #cccccc;" width="10%"><?php echo number_format($row['rate'],0,",",".");?></td>
              <td style="text-align:center;border:1px solid #000;border-bottom: 1px solid #cccccc;" width="5%"><?php echo $row['discount'];?></td><?php $total_amount=$row['quantity']*$row['total_amount']; ?>
              <td style="text-align:right;border:1px solid #000;border-bottom: 1px solid #cccccc;" width="15%"><?php echo number_format($row['ttl_price'],0,",",".");?></td>
              <!-- <td style="text-align:right;border:1px solid #000;border-bottom: 1px solid #cccccc;" width="15%"><?= $row['remark'];?></td> -->
            </tr>
      			<?php
                  $totalharga += $row['total_amount'];
      		endforeach;
      	}
          ?>
          <!-- </tbody> -->
          
          <tr>
              <th style="text-align:right;
              border-left:1px solid #000;border-right:1px solid #000;border-top:2px solid #000;border-bottom:1px solid #000;" colspan="7">Amount</th>
              <th style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;border-top:2px solid #000;border-bottom:1px solid #000;" width="15%"><?= number_format($totalharga,0,",",".");?></th>
          </tr>
         <!--  <tr>
              <th style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;" colspan="8">Tax <?= $query[0]['tax'];?>%</th>
              <th style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;" width="15%"><?= number_format($query[0]['value_tax']);?></th>
          </tr> -->
          <tr>
            <?php if($totalppn <= 0){?>
              <th style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;" colspan="7">PPN 0%</th>
            <?php }else {?>
              <th style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;" colspan="7">PPN 11%</th>
           <?php }?>
              <th style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;" width="15%"><?= number_format($query[0]['value_ppn'],0,",",".");?></th>
          </tr>
          <tr>
              <th style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;" colspan="7">Sale Amount</th>
              <th style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;" width="15%"><?= number_format($totalharga,0,",",".");?></th>
          </tr>
      </table>
          <!-- </tr>

          <tr>
            <td colspan="9"> -->
          <table width="100%">
            <tr>
              <td width="10%" style="padding-bottom: 15px;"><b>Note</b></td>
              <td width="1%" style="padding-bottom: 15px;">:</td>
              <td widht="35%" style="padding-bottom: 15px;"><b><?=$query[0]['purchase_details'];?></b></td>
            </tr>
           <!--  <tr>
              <td width="10%">Project</td>
              <td width="1%">:</td>
              <td widht="35%" style="margin-bottom: 4px;"><?=$query[0]['project'];?></td>
            </tr>
            <tr>
              <td width="10%">Delivery Term</td>
              <td width="1%">:</td>
              <td widht="35%"><?=$query[0]['note_delivery_therm'];?></td>
            </tr>
            <tr>
                <td width="10%">Delivery Address</td>
                <td width="1%">:</td>
                <td widht="35%"><?=$query[0]['note_delivery_address'];?></td>
            </tr>
            <tr>
                <td width="10%">Receiver</td>
                <td width="1%">:</td>
                <td widht="35%"><?=$query[0]['receiver'];?></td>
            </tr>
            <tr valign="top">
              <td width="10%">Payment term</td>
              <td width="1%">:</td>
              <td width="35%"><?=$query[0]['payment_therm'];?></td>
            </tr>      -->
          </table>
              <table border="0" width="100%" style="margin-top:10px;">
                <tr>
                    <td width="20%" valign="top">
                      Received by,<br>
                      <br><br><br><br><br><b>
                        <!-- <?= $query[0]['ttd_1'];?> -->
                          
                        </b> 
                    </td>
                    <!-- <td width="20%" valign="top">
                      User,<br>
                      <br><br><br><br><br><b><?= $query[0]['ttd_2'];?></b>
                    </td>
                    <td width="20%" valign="top">
                      Sincerely,<br>
                      <br><br><br><br><br><b><?= $query[0]['ttd_3'];?></b>
                    </td>
                    <td width="20%" valign="top">
                      Aproved by,<br>
                      <br><br><br><br><br><b><?= $query[0]['ttd_4'];?></b>
                    </td>
                    <td width="20%" valign="top">
                      Aproved by,<br>
                      <br><br><br><br><br><b><?= $query[0]['ttd_5'];?></b>
                    </td> -->
                </tr>
              </table>  
            <!-- </td>
          </tr>
      </table> -->
    </div>
     <!-- <script>
      $(document).ready(function(){
        setTimeout(function(){
          window.print();
        },3000);
      })
    </script> -->
</body>
</html>