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
      echo site_url('Cinvoice/');
    } else {
      echo site_url('cinvoice/manage_invoice');
    }?>" /> -->
    <title>Document</title>
    <link href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url("assets/table.js"); ?>"></script>
    <script src="<?php echo base_url("assets/package.js"); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery-3.4.1.min.js?v=3.4.1') ?>" type="text/javascript"></script>
    <style>
      /* @media print {
       .title {
            position: running(titleRunning);
          }
         @page{
            size: letter portrait;
            margin-left: 8mm;
            margin-right: 8mm;
            margin-bottom: 1.75mm;
            margin-top: 45mm;
            @bottom-center {
                            margin-top: -30px;

              content: "Page " counter(page) " of " counter(pages);
            }
            @top-left {
              content: element(titleRunning);
            }
            
        }
      body{
        font-family: "Verdana", Courier, monospace;
        font-size: 9pt;
      } */
      body {
        margin-top: 3.2cm;
        margin-left: 0.1cm;
        margin-right: 0.1cm;
        margin-bottom: 0.5cm;
        page-break-before: always;
      }
      header {
          position: fixed;
          top: 0cm;
          left: 0cm;
          right: 0cm;
          height: 4cm;
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
     <div style="text-align: right;padding-top: 10px;margin-top:-70px;"> F-<?=$query[0]['perusahaan'] ?>-004-00</div>
    <img src="<?php
    if ($query[0]['perusahaan'] == "CIKA") {
        echo $Web_settings[0]['invoice_logo'];
    } else {
      echo $Web_settings[0]['invoice_logo2'];
    }
    ?>" class="img-fluid" alt="logo" width="100%">
    <hr style="border-weight:10px;border-color:blue;margin-top:-4px">
    </header>
     <footer>
        <div class="pagenum-container">Page <span class="pagenum"></span></div>
      </footer>
    <center>
        <h3 style="font-size: 12pt;">INVOICE - TOKO</h3>
    </center>
  <!-- </div> -->
    <div class="content" style="text-align:left;margin-top: 10px;"> 
      <table border="0" width="100%" class="table table-sm table-borderless" cellpadding="1">
      <tbody>
        <tr>
          <td colspan="6" style="border-top:none;">
            <table border="0" width="100%" cellpadding="1" style="margin-bottom:10px;">
            	<tr valign="top">
                <td>Name</td>
                <td>:</td>
                <td><?php echo $query[0]['customer_name'];?></td>
                <td>Invoice No</td>
                <td>:</td>
                <td><?=$query[0]['invoice'];?>/<?=$query[0]['perusahaan']?>/<?=romawi(intval(date('m',strtotime($query[0]['date'])))).'/'.date('Y',strtotime($query[0]['date']));?></td>
              </tr>
              <tr valign="top">
                <td>Phone</td>
                <td>:</td>
                <td><?=$query[0]['phone'];?></td>
                <td>Date</td>
                <td>:</td>
                <td><?php echo date('F dS, Y',strtotime($query[0]['date']));?></td>
              </tr>

              <tr valign="top">
                <td width="10%" rowspan="2">Address</td>
                <td width="1%" rowspan="2">:</td>
                <td width="47%" rowspan="2" style="padding-right:75px;"><?php echo $query[0]['customer_address'];?></td>
                <td>PO No.</td>
                <td>:</td>
                <td><?=$query[0]['po_id'];?></td>
              </tr>

              <tr valign="top">
                <!-- <td>Fax</td>
                <td>:</td>
                <td><div style="width:220px;"><?php echo $query[0]['fax'];?></div></td> -->
                <td>PO Date</td>
                <td>:</td>
                <td><?php echo date('F dS, Y',strtotime($query[0]['po_date']));?></td>
              </tr>
              
            </table>
          </td>
        </tr>
        <tr bgcolor="#eeeeee">
      		<th style="text-align:center; border:1px solid #000;">No</th>
      		<th style="text-align:center; border:1px solid #000;" colspan="2">Quantity</th>
      		<th style="text-align:left; border:1px solid #000;">Description</th>
            <th style="text-align:left; border:1px solid #000;" width="13%">Code</th>
      		<th style="text-align:center; border:1px solid #000;">Unit Price (IDR)</th>
          <th style="text-align:center; border:1px solid #000;">Amount (IDR)</th>
      	</tr>
      	<?php 
      	if(!empty($query)){

      		$no = 0;
              $totalitem = 0;
              $totaldiskon= 0;
              $totalharga = 0;
      		foreach($query as $row):
      			$no++;
      			?>
      			<tr valign="top">
      				<td style="border-left:1px solid #000;border-right:1px solid #000;"><?php echo $no;?></td>
             
      				<td style="border-left:1px solid #000;border-right:1px solid #000;"><?php echo $row['quantity'];?></td>
      				<td style="border-left:1px solid #000;border-right:1px solid #000;"><?php echo $row['unit'];?></td>
                    <td style="border-left:1px solid #000;border-right:1px solid #000;"><?php echo $row['product_name'].' '.$row['size']. ' ('.$row['merek'].')';?></td>                      
      				<td style="text-align:left;border-left:1px solid #000;border-right:1px solid #000;" width="13%"><?= $row['product_id'];?></td>
      				<td style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;"><?php echo number_format($row['rate'],0,",",".");?></td>
                      
                      
                    <td style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;"><?php echo number_format($row['total_price'],0,",",".");?></td>
                      
      			</tr>
      			<?php
                  $totalharga += $row['total_price'];
      		endforeach;
      	}
          ?>
          </tbody>
          <tfoot>
       
			  <tr>
              <th colspan="5" style="border-top:1px solid #000;border-bottom: none;">&nbsp;</th>
              <th style="border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;">Sale Amount</th>
              <th style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;"><?php echo number_format($totalharga);?></th>
              
              
          </tr>

         <!--  <tr>
              <th colspan="5">&nbsp;</th>
              <th style="border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;">
                
                Tax <?php if($query[0]['ppn'] !=""):echo $query[0]['ppn'];else: echo '0';endif;?>%
              </th>
              <th style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;"><?php echo number_format($totalharga * 11/100);?></th>
              
              
          </tr> 

          <tr>
              <th colspan="5" style="border-top:none;">&nbsp;</th>
              <th style="border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;">Sale Amount</th>
              <th style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;"><?php echo number_format($totalharga);?></th>
              
              
          </tr>
-->
      </tfoot>
      </table>
     <br>
              
      <table width="100%">
          <tr>
            <td width="30%"><i>Says</i></td>
            <td width="1%">:</td>
            <td widht="35%"><i><?= $CI->linvoice->toEnglish($totalharga + ($totalharga *0.1));?> Rupiah</td></td>
            
         
          </tr>
          <tr>
            <td colspan="3"><i><strong>Payment Full Amount</strong></i></td>
          </tr>
          <tr>
            <td width="20%">Due Date</td>
            <td width="1%">:</td>
            <td widht="35%"><?=date('F dS, Y',strtotime('+2 months',strtotime($query[0]['date'])));?></td>
          </tr>

          <tr>
            <td width="20%"><b>PT. Cipta Kawan Teknik Abadi<br><br><br><br><br><br><hr style="border-color:#000;">Authorised Signature			
</b></td>
            <td colspan="2">&nbsp;</td>
            
          </tr>
          <tr valign="top">
            <td width="20%"  style="padding-top:20px;">Bank Detail</td>
            <td width="1%"  style="padding-top:20px;">:</td>
            <td widht="35%"  style="padding-top:20px;"><?=$query[0]['ac_name'];?><br><?=$query[0]['bank_name'].' - '.$query[0]['branch'];?><br>No. Acc : <?=$query[0]['ac_number'];?></td>
            
          </tr>
      </table>
    </div>
     <script>
      $(document).ready(function(){
        setTimeout(function(){
          window.print();
        },3000);
      })
    </script>
</body>
</html>