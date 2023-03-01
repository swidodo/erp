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
    <meta http-equiv="refresh" content="2;url=<?=site_url('Cquotationproject/list');?>" />
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
        <img src="<?php
        if ($query[0]['perusahaan'] == "CIKA") {
            echo $Web_settings[0]['invoice_logo'];
        } else {
          echo $Web_settings[0]['invoice_logo2'];
        }
        ?>" class="" alt="" style="max-width:400px;">
    </div>


    <div class="content" style="text-align:left;">
    <center>
      <h3 style="font-size: 9pt;">QUOTATION</h3>
      </center>  
      <table border="0" width="100%" cellpadding="1">
      	<tr>
          <td>Company</td>
          <td>:</td>
          <td><?php echo $qedit[0]['customer_name'];?></td>
          <td>Date</td>
          <td>:</td>
          <td><?php echo date('d/m/Y',strtotime($qedit[0]['quotdate']));?></td>
        </tr>
        <tr>
          <td>Attention</td>
          <td>:</td>
          <td><?php echo $qedit[0]['contact'];?></td>
          <td>Quotation</td>
          <td>:</td>
          <td><?php echo html_escape($quot_main[0]['quot_no']); ?>/<?=$quot_main[0]['perusahaan']?>/<?=romawi(intval(date('m',strtotime($quot_main[0]['quotdate']))));?>/<?=date('Y',strtotime($quot_main[0]['quotdate']));?></td>
        </tr>

        <tr>
          <td>CC</td>
          <td>:</td>
          <td></td>
          <td>Tax Registrasion No.</td>
          <td>:</td>
          <td>31.493.674.1-418.000</td>
        </tr>

        <tr valign="top">
          <td>Address</td>
          <td>:</td>
          <td><div style="width:220px;"><?php echo $qedit[0]['customer_address'];?></div></td>
          <td>Marketing</td>
          <td>:</td>
          <td><?php echo $qedit[0]['marketing'];?></td>
        </tr>
        
        <tr>
          <td>Phone</td>
          <td>:</td>
          <td><?php echo $qedit[0]['phone'];?></td>
          <td>Mobile</td>
          <td>:</td>
          <td><?php echo $qedit[0]['phone'];?></td>
        </tr>
        <tr>
          <td>Fax</td>
          <td>:</td>
          <td><?php echo $qedit[0]['fax'];?></td>
          <td>Email</td>
          <td>:</td>
          <td><?php echo $qedit[0]['emailmarketing'];?></td>
        </tr>
        
      </table>
     
      <table border="1" width="100%" class="table" cellpadding="3">
      <thead>	
      <tr bgcolor="#eeeeee">
      		<th style="text-align:center; border:1px solid #000;">No</th>
      		<th style="text-align:center; border:1px solid #000;">Part Description</th>
              <th style="text-align:center; border:1px solid #000;">Brand</th>
              <th style="text-align:center; border:1px solid #000;">Quantity</th>              
      		<th style="text-align:center; border:1px solid #000;">Unit</th>
      		<th style="text-align:center; border:1px solid #000;">Unit Price (IDR)</th>
              <th style="text-align:center; border:1px solid #000;">Total Price (IDR)</th>
      	</tr>
      </thead>
      <tbody>
      	<?php 
      	if(!empty($query)){

      		$no = 0;
              $totalitem1 = 0;
              $totalitem2= 0;
              $totalharga = 0;
      		foreach($query as $row):
      			$no++;
                //   $qtotal1 = $this->db
                //   ->select('SUM(qty) as jumlah, (product_information.price * quotation_project_item.qty) as total')
                  
                //   ->join('product_information','product_information.product_id = quotation_project_item.product_id','LEFT')
                //   ->get_where('quotation_project_item',['quotation_project_item.quot_project_detail_id'=>$row->quotation_id]);

                //   if($qtotal1->num_rows() > 0){
                //       $dtotal1 = $qtotal1->row();
                //       $total1 = $dtotal1->total;
                //   } else {
                //       $total1 = 0;
                //   }
      			?>
      			<tr valign="top">
      				<td style="border-left:1px solid #000;border-right:1px solid #000;"><b><?php echo romawi($no);?><b></td>
             
      				
      				<td style="border-left:1px solid #000;border-right:1px solid #000;"><b><?php echo $row->quot_detail_title;?></b></td>
                <td style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;">&nbsp;</td>                      
      				<td style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
      				<td style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
                     
                      
                      <td style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
                      <td style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
                      
      			</tr>
      			<?php
                  $items = $this->db
                  ->select(['product_information.product_name','product_information.size','product_information.merek','product_information.price as harga','product_information.unit','quotation_project_item.*'])
                  ->join('product_information','product_information.product_id = quotation_project_item.product_id')
                  
                  ->get_where('quotation_project_item',['quot_project_detail_id'=>$row->quot_project_detail_id])
                  ->result();

                  if(!empty($items)){
                   
                    foreach($items as $item){
                        
                        $totalprice = $item->harga * $item->qty;
                  ?>
      			<tr valign="top">
      				<td style="border-left:1px solid #000;border-right:1px solid #000;"></td>
                    <td>&nbsp;&nbsp;<?=$item->product_name;?></td>
                    <td><?=$item->merek;?></td>
                    <td><?=$item->qty;?></td>
                    <td><?=$item->unit;?></td>
                    <td><?=number_format($item->harga);?></td>
                    <td><?=number_format($totalprice);?></td>
                      
      			</tr>
      			<?php
                  $totalitem1 += $totalprice;
                    }
                }

                $subquery = $this->db->order_by('created_at','ASC')->get_where('quotation_project_detail',['parent_id'=>$row->quot_project_detail_id])->result();

                if(!empty($subquery)){
                    $nosub = 0;
                    foreach($subquery as $rsub){
                        $nosub++;
                        ?>
                        <tr>
                            
                            <td><?=$nosub;?></td>
                            <td><?=$rsub->quot_detail_title;?></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td><?=$totalitem2;?></td>
                        </tr>
                        <?php
                        $subitems = $this->db
                        ->select(['product_information.product_name','product_information.size','product_information.merek','product_information.price as harga','product_information.unit','quotation_project_item.*'])
                        ->join('product_information','product_information.product_id = quotation_project_item.product_id')
                        
                        ->get_where('quotation_project_item',['quot_project_detail_id'=>$rsub->quot_project_detail_id])
                        ->result();
        
                        if(!empty($subitems)){
                            $nosubitems = 0;
                            foreach($subitems as $subitem){
                                $nosubitems++;
                                $totalpricesub = $subitem->harga * $subitem->qty;
                                ?>
                                <tr>
                                   
                                    <td>&nbsp;&nbsp;</td>
                                    <td>&nbsp;&nbsp;<?=$subitem->product_name;?></td>
                                    <td><?=$subitem->merek;?></td>
                                    <td><?=$subitem->qty;?></td>
                                    <td><?=$subitem->unit;?></td>
                                    <td><?=number_format($subitem->harga);?></td>
                                    <td><?=number_format($totalpricesub);?></td>
                                </tr>
                                <?php
                                $totalitem2 += $totalpricesub;
                            }
                        }
                    }
                }
                  //$totalharga += $row['total_price'];
      		endforeach;
      	}
          ?>
          </tbody>
          <tfoot>
          <tr>
              <th colspan="6" style="border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;">TOTAL AMOUNT</th>
              <th style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;"><?php echo number_format($totalitem2 + $totalitem1);?></th>
              
          </tr>
      </tfoot>
      </table>
     <br>
     <p><b><u>Note :</u></b><br>
     The above price is excluded of 10% VAT	<br>
        The above price is included of delivery cost<br>	
        The above price are excluded of all civil work<br> 	
        The above price is excluded of QC analysis cost (Performance qualification), chemical-reagen and Lab instrument<br>	
        Lead time approximately 4-6 months<br>	
        Validity  of  quotation 4  weeks<br>	
    </p>

    <p><b>Term of Payment :</b><br>
    30 %   Down Payment, The payment shall be paid when signing of Sales agreement and drawing approved	<br>	
40 %,  The payment shall be paid when material ready to delivery<br>		
25 %,  The payment shall be paid when equipments has been completed installed at site<br>		
5 %,   The payment shall be paid when validation has been done  and Take-Over Certificate  has been signed<br>

<p><b>Advantage</b><br>
Double Pass Reverse Osmosis with fully orbital welding<br>		
Automatic  controll for  PW conductivity is out of spesification<br> 		
Automatic  controll for PW Generator while PW pH is out of spesification.<br>		
Automatic  flow rate in loop to handle peak hour and meet 1.3  m/s regulation.<br>		
Quality parameter base on CPOB Badan POM RI & USP Regulations<br> 		
All material are compliance ASME BPE, 3A (3-A SSI), EHEDG (European Hygienic Engineering and Design Group)<br>		
All Design & Installation in compliance GEP ( Good Engineering Practices)<br>		
Automatic Operation:  RO and Storage and distribution loop (PID System)<br>		
Operation by HMI (Touch screen) & Data logger<br>		
Automatic Orbital Welding & Boroscope report<br>		
Pipe Looping completely drainable & Pipe Slope min. 1%<br>		
Zero dead leg Tee Valve & self draining type for sample valve<br> 		
Sanitary Loop pump with Drain Valve

<p><b>Guarante<br>Warranty is valid for a period of 12 months commencing on the date of signature of the commissioning certificate <br>EDI Module & DC Power:  3  years	
</b></p>

</p>
  
    </p>
        

              
      <!-- <table width="100%">
          <tr>
            <td width="20%">VAT</td>
            <td width="1%">:</td>
            <td widht="35%">Prices quoted excluding 10% VAT</td>
            <td width="20%">Delivery Time</td>
            <td width="1%">:</td>
            <td widht="35%">14 days upon receipt of official order</td>
         
          </tr>

          <tr>
            <td width="20%">Instalation</td>
            <td width="1%">:</td>
            <td widht="35%">Prices quoted excluding installation cost</td>
            <td width="20%">Stock</td>
            <td width="1%">:</td>
            <td widht="35%">Stock availability is not binding</td>
          </tr>

          <tr>
            <td width="20%">Unloading</td>
            <td width="1%">:</td>
            <td widht="35%">Unloading of goods is the responsibility of the buyer.</td>
         
          </tr>
          
          <tr>
            <td width="20%">Validity</td>
            <td width="1%">:</td>
            <td widht="35%" colspan="3">3 weeks</td>
         
          </tr> 
          
      </table> -->
      
      <table border="0" cellpadding="3" cellspacing="0" width="40%">
        <tr>
          <td><b>Sincerely yours,</b><br><br><br><br><br><br><b><i>This is a Computer Generated Proposal, No Signature Required</i><br><?=$this->session->userdata('user_name');?></b></td>
        </tr>
      </table>
     
     

    </div>
</body>
</html>