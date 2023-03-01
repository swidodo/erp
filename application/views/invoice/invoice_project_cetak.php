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
      echo site_url('Cinvoice/');
    } else {
      echo site_url('cinvoice/manage_invoice');
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
     <div style="text-align: right;padding-top: 10px"> F-CIKA-004-00</div>
        <img src="<?php
        if (isset($Web_settings[0]['invoice_logo'])) {
            echo $Web_settings[0]['invoice_logo'];
        }
        ?>" class="" alt="" style="max-width:400px;">
    </div>


    <div class="content" style="text-align:left;">
    <center>
      <h3 style="font-size: 9pt;">INVOICE</h3>
      </center>  
      <table border="0" width="100%" cellpadding="1">
      	<tr>
          <td>Name</td>
          <td>:</td>
          <td><?php echo $query[0]['customer_name'];?></td>
          <td>Invoice No</td>
          <td>:</td>
          <td><?=$query[0]['invoice'];?>/CIKA-INV/<?=romawi(intval(date('m',strtotime($query[0]['date'])))).'/'.date('Y',strtotime($query[0]['date']));?></td>
        </tr>
        <tr>
          <td>Address</td>
          <td>:</td>
          <td><?php echo $query[0]['customer_address'];?></td>
          <td>Date</td>
          <td>:</td>
          <td><?php echo date('F d, Y',strtotime($query[0]['date']));?></td>
        </tr>

        <tr>
          <td>Phone</td>
          <td>:</td>
          <td><?=$query[0]['phone'];?></td>
          <td>PO No.</td>
          <td>:</td>
          <td><?=$query[0]['po_id'];?></td>
        </tr>

        <tr valign="top">
          <td>Fax</td>
          <td>:</td>
          <td><div style="width:220px;"><?php echo $query[0]['fax'];?></div></td>
          <td>PO Date</td>
          <td>:</td>
          <td><?php echo date('F d, Y',strtotime($query[0]['po_date']));?></td>
        </tr>
        
      </table>
     
      <table border="0" width="100%" class="table" cellpadding="1">
      <thead>	
      <tr bgcolor="#eeeeee">
      		<th style="text-align:center; border:1px solid #000;">No</th>
      		<th style="text-align:center; border:1px solid #000;" colspan="2">Quantity</th>
      		<th style="text-align:center; border:1px solid #000;">Description</th>
              <th style="text-align:center; border:1px solid #000;">Code</th>
      		<th style="text-align:center; border:1px solid #000;">Unit Price (IDR)</th>
              <th style="text-align:center; border:1px solid #000;">Amount (IDR)</th>
      	</tr>
      </thead>
      <tbody>
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
      				<td style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;"></td>
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
              <th colspan="5" style="border-top:1px solid #000;">&nbsp;</th>
              <th style="border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;">Sale Amount</th>
              <th style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;"><?php echo number_format($totalharga);?></th>
              
              
          </tr>

          <tr>
              <th colspan="5">&nbsp;</th>
              <th style="border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;">Tax/PPN 10%</th>
              <th style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;"><?php echo number_format($totalharga * 10/100);?></th>
              
              
          </tr>

          <tr>
              <th colspan="5">&nbsp;</th>
              <th style="border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;">Sale Amount</th>
              <th style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;"><?php echo number_format($totalharga * (10/100) + $totalharga);?></th>
              
              
          </tr>
      </tfoot>
      </table>
     <br>
              
      <table width="100%">
          <tr>
            <td width="20%">Terbilang</td>
            <td width="1%">:</td>
            <td widht="35%"><?=$CI->linvoice->Terbilang($totalharga + ($totalharga *0.1));?> RUPIAH</td>
            
         
          </tr>

          <tr>
            <td width="20%">Due Date</td>
            <td width="1%">:</td>
            <td widht="35%"><?=date('F Y',strtotime('+2 months',strtotime($query[0]['date'])));?></td>
            
          </tr>
          
      </table>
     
     

    </div>
</body>
</html>