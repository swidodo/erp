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
    <meta http-equiv="refresh" content="2;url=<?php
    
    if($target == null){
      echo site_url('Cpurchase/manage_purchase_order');
    } else {
      echo site_url('cpurchase/manage_purchase_order');
    }?>" />
    <title>Document</title>
    <style>
      body{
        font-family: "Verdana", Courier, monospace;
        font-size: 9pt;
        margin:5px;
      }

      .title
      {
		margin-top : -5px;
        font-size: 9pt;
        font-weight: bold;
        border-bottom: 1px solid #000;
      }

      .content
      {
        padding: 3px;
		margin-top:-10px;
	  }

      hr
      {
        border:1px solid #000;
      }


      table{
      	border-collapse:  collapse;
      }

      #watermark
      {
       position:fixed;
       top:90px;
       left:190px;
       opacity:0.2;
       z-index:100;
       color:white;
      }

    </style>
</head>
<body onload="window.print();">
<div class="title">
        <!-- <img src="<?php
        if (isset($Web_settings[0]['invoice_logo'])) {
            echo $Web_settings[0]['invoice_logo'];
        }
        ?>" class="" alt="" style="max-width:400px;"> -->
        <?php
        if ($query[0]['perusahaan'] == "CIKA") :?>
            
          <table>
          <td><img src="<?= $Web_settings[0]['logo'];?>" class="" alt="" width="80%" height="120"></td>
          <td>
            <span style="font-size:20pt !important;color:#4361ee !important;font-family :MS Serif !important;"> PT. CIPTA KAWAN TEKNIK ABADI</span><br />
            <span style="font-size:14pt !important;font-family :MS Serif; !important;">Water and Waste Water Treatment Technology Systems</span><br />
            <span style="font-size:8pt !important;font-family :MS Serif; !important;">Head Office : Komplek Mall WTC Matahari No.816. Jl. Raya Serpong No.39. Tangerang 15326 Banten</span><br />
            <span style="font-size:8pt !important;font-family :MS Serif; !important;">Phone : +6221 53167749. Hotline : 6282 181010030</span><br />
            <span style="font-size:8pt !important;font-family :MS Serif; !important;">Workshop : Jl. Rancaiyuh Km.2 Babat-Legok. Tangerang 15820 Banten-Indonesia</span><br />
          </td>
        </table>
        <hr />
        <?php else :?>
           <img src="<?php  echo $Web_settings[0]['invoice_logo_2'];?>" class="" alt="" width="90%" height="75"> 
        <?php endif;?>
    </div>


    <div class="content" style="text-align:left;">
    <center>
      <h3 style="font-size: 12pt;">PURCHASE ORDER</h3>
      </center>  
      <table border="0" width="100%" cellpadding="1">
      <tr>
          <td colspan="6"><u>Kepada YTH:</u></td>
         
         
        </tr>
      	<tr>
          <td>Company</td>
          <td>:</td>
          <td><?php echo $query[0]['supplier_name'];?></td>
          <td>No. PO</td>
          <td>:</td>
          <td>
            <?php 
            echo $query[0]['purchase_order']; 
            if($query[0]['count_update'] >='1'){echo ".R".$query[0]['count_update'];}else{echo'';}?>/PO/<?=romawi(intval(date('m',strtotime($query[0]['po_date'])))).'/'.date('Y',strtotime($query[0]['po_date']));?>
          </td>
        </tr>
        <tr>
          <td>Phone</td>
          <td>:</td>
          <td><?php echo $query[0]['phone'];?></td>
          <td>Date</td>
          <td>:</td>
          <td><?php echo date('F d, Y',strtotime($query[0]['po_date']));?></td>
        </tr>

        <tr>
          <td>Fax</td>
          <td>:</td>
          <td><?=$query[0]['fax'];?></td>
          <td>Quotation No.</td>
          <td>:</td>
          <td><?= $query[0]['quot_id'];?></td>
        </tr>

        <tr valign="top">
          <td>Attn</td>
          <td>:</td>
          <td><div style="width:220px;"><?php echo $query[0]['contact'];?></div></td>
          <td>Date</td>
          <td>:</td>
          <td><?php echo date('F d, Y',strtotime($query[0]['quot_date']));?></td>
        </tr>
        <tr valign="top">
          <td>Email</td>
          <td>:</td>
          <td><div style="width:220px;"><?php echo $query[0]['email_address'];?></div></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        
      </table>
     <p><u>Harap dikirim barang-barang dibawah ini :</u><br>Please deliver the following goods listed below :</p>
      <table border="0" width="100%" class="table" cellpadding="1">
      <thead>	
      <tr bgcolor="#eeeeee">
      		<th style="text-align:center; border:1px solid #000;" width="5%">No</th>              
      		<th style="text-align:center; border:1px solid #000;" width="25%">Description</th>              
              <th style="text-align:center; border:1px solid #000;" width="10%">Code</th>
      		<th style="text-align:center; border:1px solid #000;" width="10%">Quantity</th>
              <th style="text-align:center; border:1px solid #000;" width="5%">Unit</th>
      		<th style="text-align:center; border:1px solid #000;" width="10%">Unit Price (IDR)</th>
              <th style="text-align:center; border:1px solid #000;" width="15%">Amount (IDR)</th>
      	</tr>
      </thead>
      <tbody>
      	<?php 
      	if(!empty($query)){

      		$no = 0;
              $totalharga = 0;
      		foreach($query as $row):
      			$no++;
      			?>
      			<tr valign="top">
      				<td style="border-left:1px solid #000;border-right:1px solid #000;"><?php echo $no;?></td>
                    <td style="border-left:1px solid #000;border-right:1px solid #000;"><?php echo $row['product_name'].' '.$row['size']. ' ('.$row['merek'].')';?></td>
                    <td style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;"><?= $row['product_id'];?></td>
                    <td style="border-left:1px solid #000;border-right:1px solid #000;"><?php echo $row['qty'];?></td>
      				<td style="border-left:1px solid #000;border-right:1px solid #000;"><?php echo $row['unit'];?></td>
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
              <th style="border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;" colspan="6">Total Amount</th>
              <th style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;"><?php echo number_format($totalharga);?></th>
              
              
          </tr>

          
      </tfoot>
      </table>
     <br>
      Note :         
      <table width="100%">
          <tr>
            <td width="20%">Delivery Therms</td>
            <td width="1%">:</td>
            <td widht="35%"><?=$query[0]['note_delivery_therm'];?></td>
            
         
        </tr>

        <tr>
            <td width="15%">Delivery Address</td>
            <td width="1%">:</td>
            <td widht="35%"><?=$query[0]['note_delivery_address'];?></td>
        </tr>  

        <tr valign="top">
            <td width="15%"><u>Syarat Pembayaran </u><br>Payment therms</td>
            <td width="1%">:</td>
            <td width="35%"><?=$query[0]['payment_therm'];?></td>
        </tr>     
      </table>
      <br>    
      <table border="0" width="100%" style="margin-top:20px;">
          <tr>
              <td width="20%" valign="top">
                Sincerely yours,<br>
                Hormat kami<br><br><br><br><br><br><b><?= strtoupper($query[0]['ttd_1']);?></b> 
              </td>
              <td width="20%" valign="top">
                Received by,<br>
                Penanggung jawab order 1<br><br><br><br><br><b><?= strtoupper($query[0]['ttd_2']);?></b>
              </td>
              <td width="20%" valign="top">
                Received by,<br>
                Penanggung jawab order 2<br><br><br><br><br><b><?= strtoupper($query[0]['ttd_3']);?></b>
              </td>
              <td width="20%" valign="top">
                Received by,<br>
                Penanggung jawab order 3<br><br><br><br><br><b><?= strtoupper($query[0]['ttd_4']);?></b>
              </td>
              <td width="20%" valign="top">
                Received by,<br>
                Penanggung jawab order 4<br><br><br><br><br><b><?= strtoupper($query[0]['ttd_5']);?></b>
              </td>
          </tr>
      </table>
     
     

    </div>
</body>
</html>