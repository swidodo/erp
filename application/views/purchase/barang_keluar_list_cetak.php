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
      echo site_url('Cpurchase/manage_barang_keluar');
    } else {
      echo site_url('cpurchase/manage_barang_keluar');
    }?>" /> -->
    <title>Document</title>
    <link href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>" rel="stylesheet" type="text/css" />
    <!-- <script src="<?php echo base_url("assets/package.js"); ?>"></script> -->
    <script src="<?php echo base_url("assets/table.js"); ?>"></script>
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
            margin-bottom: 1.99mm;
            margin-top: 55mm;
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
        margin-top: 2.8cm;
        margin-left: 0.2cm;
        margin-right: 0.2cm;
        margin-bottom: 0.5cm;
        page-break-before: always;
      }
       header {
    position: fixed;
    top: 0cm;
    left: 0cm;
    right: 0cm;
    height: 2.5cm;
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
      <div style="text-align: right;margin-top: -70px"> F-CIKA-007-00</div>
      <img src="<?php
      if (isset($Web_settings[0]['invoice_logo'])) {
          echo $Web_settings[0]['invoice_logo'];
      }else{
        echo $Web_settings[0]['invoice_logo_2'];
      }
      ?>" class="img-fluid" alt="logo" width="100%" style="margin-top: -10px">
      <hr style="border-weight:10px;border-color:blue; margin-top: -3px">
      <!-- </div> -->
    </header>
    <footer>
      <div class="pagenum-container">Page <span class="pagenum"></span></div>
    </footer>
      <center>
          <h3 style="font-size: 12pt;">SURAT BUKTI BARANG KELUAR</h3>
      </center>  


    <div class="content" style="text-align:left;margin-top: 20px;">
      <table border="0" width="100%" cellpadding="1">
      	<tr valign="top">
           <td valign="top" width="10%">Customer</td>
           <td valign="top" width="1%">:</td>
           <td valign="top" width="45%"><?php echo $query[0]['customer_name'];?></td>
           <td valign="top" width="45%">No. Barang Keluar</td>
           <td valign="top" width="1%">:</td>
           <td valign="top"><?php echo $query[0]['barang_keluar'];?></td>
        </tr>
        <tr valign="top">
          <td valign="top" rowspan="2" width="10%">Address</td>
          <td valign="top" rowspan="2" width="1%">:</td>
          <td valign="top" rowspan="2" width="45%" style="padding-right: 50px;"><?php echo $query[0]['customer_address'];?></td>
          <td valign="top">Date</td>
          <td valign="top">:</td>
          <td><?php echo date('F d, Y',strtotime($query[0]['bk_date']));?></td>
        </tr>
        <tr valign="top">
          <td valign="top">PO No.</td>
          <td valign="top">:</td>
          <td valign="top"><div style="width:220px;"><?php echo $query[0]['po_id'];?></div></td>
        </tr>
        
      </table>
      <table border="0" width="100%" class="table" cellpadding="3">
      <thead>	
      <tr bgcolor="#eeeeee">
      		<th style="text-align:center; border:1px solid #000;" width="5%">No</th>              
      		<th style="text-align:center; border:1px solid #000;" width="35%">Description</th>              
              <th style="text-align:center; border:1px solid #000;" width="10%">Code</th>
      		<th style="text-align:center; border:1px solid #000;" width="10%">Quantity</th>
              <th style="text-align:center; border:1px solid #000;" width="5%">Unit</th>
              <th style="text-align:center; border:1px solid #000;" width="15%">Remarks</th>
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
      				<td style="text-align: center;border-left:1px solid #000;border-right:1px solid #000;border-bottom: 1px solid #cccccc;" width="5%"><?php echo $no;?></td>
                    <td style="border-left:1px solid #000;border-right:1px solid #000;border-bottom: 1px solid #cccccc;" width="35%"><?php echo $row['product_name'].' '.$row['size']. ' ('.$row['merek'].')';?></td>
                    <td style="text-align:left;border-left:1px solid #000;border-right:1px solid #000;border-bottom: 1px solid #cccccc;" width="10%"><?= $row['product_id'];?></td>
                    <td style="text-align: center;border-left:1px solid #000;border-right:1px solid #000;border-bottom: 1px solid #cccccc;" width="10%"><?php echo $row['qty'];?></td>
      				<td style="text-align: center;border-left:1px solid #000;border-right:1px solid #000;border-bottom: 1px solid #cccccc;" width="5%"><?php echo $row['unit'];?></td>
                      <td style="text-align: left;border-left:1px solid #000;border-right:1px solid #000;border-bottom: 1px solid #cccccc;" width="15%"><?php echo $row['remarks'];?></td>
                      
      			</tr>
      			
                      <?php
          		endforeach;
          	}
          ?>
          </tbody>
          <tfoot>
          <tr valign="top">
      				<td style="border-top:1px solid #000;" colspan="6">&nbsp;</td>
                    
                      
      			</tr>
          </tfoot>
         
      </table>
     
      <br>    
      <table border="0" width="100%">
          <tr>
              <td width="15%" style="text-align:center;">
              Logistic Manager,<br>
              <br><br><br><br><b>(______________)</b> 

              </td>

              <td width="15%" style="text-align:center;">
              Project Manager,<br>
              <br><br><br><br><b>(______________)</b>
 

              </td>

              <td width="15%" style="text-align:center;padding-right: 55px;">
              Logistic Admin,<br>
              <br><br><br><br><b>(______________)</b>
 

              </td>

              <td width="15%" style="text-align:center;">
              Delivery By,<br>
              <br><br><br><br><b>(______________)</b>
 

              </td>
              <td width="15%" style="text-align:center;">
              Received By,<br>
              <br><br><br><br><b>(______________)</b>
 

              </td>
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