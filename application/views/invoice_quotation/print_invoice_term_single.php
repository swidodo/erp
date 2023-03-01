 <?php
$CI = & get_instance();
$CI->load->model('Web_settings');
$CI->load->library('linvoice');
$Web_settings = $CI->Web_settings->retrieve_setting_editdata();
$user_type = $this->session->userdata('user_type');
$user_id = $this->session->userdata('user_id');
// $currency = $currency_details[0]['currency'];
// $position = $currency_details[0]['currency_position'];
$arr=array(1=>"I","II","III","IV","V","VI","VII","VIII","IV","X","XI","XII");
$month  =   date('n',strtotime($vinv[0]['date']));
$bln=$arr[$month];
if ($amoutserv !=null):
$serv = $amoutserv[0]['total_amount'];
else:
$serv = 0;
endif;
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
    }?>" />-->
    <title>View Invoice</title>
    <!-- <script src="<?php echo base_url("assets/table.js"); ?>"></script> -->
    <script src="<?php echo base_url("assets/package.js"); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery-3.4.1.min.js?v=3.4.1') ?>" type="text/javascript"></script>
    <link href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>" rel="stylesheet" type="text/css" />
    <style>
       /* @media print {
           .title {
                position: running(titleRunning);
              }
             @page{
                size: letter portrait;
                margin-left: 8mm;
                margin-right: 8mm;
                margin-bottom: 4mm;
                margin-top: 54mm;
                margin-bottom: 1.99mm;
                @bottom-center {
                  content: "Page " counter(page) " of " counter(pages);
            }
            @top-left {
                margin-top: 5px;
                content: element(titleRunning);
            }   
        }
        body{
            font-family: "Verdana", Courier, monospace;
            font-size: 9pt;
       }
       @media screen{
          body{ 
              font-family: "Verdana", Courier, monospace;
              font-size: 9pt;
              margin: auto;
         }
       }
      } */
            body {
        margin-top: 2.9cm;
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
   <script src="<?php echo base_url('assets/js/jquery-3.4.1.min.js?v=3.4.1') ?>" type="text/javascript"></script>
   
</head>
<body>
   <header>
    <!-- <div class="title pagedjs_margin-top pagedjs_margin-content"> -->
     <div style="text-align: right;padding-top: 10px;margin-top:-70px;"> F-<?=$vinv[0]['perusahaan'] ?>-002-00</div>
    <div>
    <?php
      if ($vinv[0]['perusahaan'] == "CIKA") :?>
        <img src="<?= $Web_settings[0]['invoice_logo'];?>" class="img-fluid" width="100%"  style="margin-top:-15px;">
      <?php else :?>
         <img src="<?php  echo $Web_settings[0]['invoice_logo_2'];?>" class="img-fluid" width="100%" style="margin-top:-15px;"> 
      <?php endif;?>
    <!-- </div> -->
   <hr style="weight:5px;border-color:blue;margin-top:-4px"">
   </header>
    <footer>
      <div class="pagenum-container">Page <span class="pagenum"></span></div>
    </footer>
   <p style="font-size: 12pt;text-align: center;">INVOICE</p>
  </div>
    <div class="content" style="text-align:left;margin-top: 10px;"> 
      <table width="100%" class="table" cellpadding="1" style="border-collapse: collapse;">
      <tbody>
        <tr>
          <td colspan="6" style="padding-bottom:20px; border-top: none;">
            <table border="0" width="100%" cellpadding="1">
              <tr>
                <td valign="top">Name</td>
                <td valign="top">:</td>
                <td valign="top"><?= $vinv[0]['customer_name'];?></td>
                <td valign="top">Invoice No</td>
                <td valign="top" width="1">:</td>
                <td valign="top"><?=$vinv[0]['invoice'];?>/<?=$vinv[0]['perusahaan']."-INV";?>/<?=$bln.'/'.date('Y',strtotime($vinv[0]['date']));?></td>
              </tr>
              <tr valign="top">
                <td valign="top">Phone</td>
                <td valign="top">:</td>
                <td valign="top"><?=$vinv[0]['phone'];?></td>
                <td valign="top">Date</td>
                <td valign="top">:</td>
                <td valign="top"><?php echo date('F dS, Y',strtotime($vinv[0]['date']));?></td>
              </tr>

              <tr valign="top">
                <td valign="top" width="10%" rowspan="3">Address</td>
                <td valign="top" width="1%" rowspan="3">:</td>
                <td valign="top" width="45%" rowspan="3" style="padding-right:75px;"><?php echo $vinv[0]['customer_address'];?></td>
               <!--  <td>Fax</td>
                <td>:</td>
                <td><div style="width:220px;"><?php echo $vinv[0]['fax'];?></div></td> -->
                <td valign="top">PO No</td>
                <td valign="top">:</td>
                <td valign="top"><?php if ($vinv[0]['po'] !=""){ echo $vinv[0]['po'];}else { echo "PO-".$vinv[0]['quot_no'];}?></td>
              </tr>

              <tr valign="top">
                <td valign="top">PO Date</td>
                <td valign="top">:</td>
                <td valign="top"><?php if ($vinv[0]['po_date'] !=""){ echo date('F dS, Y',strtotime($vinv[0]['po_date'])); }else{ echo date('F dS, Y',strtotime($vinv[0]['quotdate']));}?></td>
              </tr>
              
            </table>
          </td>
        </tr>
        <tr bgcolor="#eeeeee">
          <td style="text-align:center; border:1px solid #000;">No</td>
          <td style="text-align:center; border:1px solid #000;" colspan="2">Quantity</td>
          <td style="text-align:center; border:1px solid #000;">Description</td>
          <td style="text-align:center; border:1px solid #000;">Unit Price (IDR)</td>
          <td style="text-align:center; border:1px solid #000;">Amount (IDR)</td>
        </tr>
      	<?php 
      	if(!empty($vinv)){
      		    $no = 0;
                $totalitem = 0;
                $totaldiskon= 0;
                $totalharga = 0;
      		foreach($vinv as $row):
      			$no++;
      			?>
      			<tr valign="top">
      				<td style="text-align:center;border-left:1px solid #000;border-right:1px solid #000;border-bottom: none;"><?php echo $no;?></td>
      				<td style="text-align:center;border-left:1px solid #000;border-right:1px solid #000;border-bottom: none;"><?php echo number_format($row['quantity']);?></td>
      				<td style="text-align:center;border-left:1px solid #000;border-right:1px solid #000;border-bottom: none;"><?php echo $row['unit'];?></td>
              <td style="border-left:1px solid #000;border-right:1px solid #000;border-bottom: none;"><?php echo strtoupper($row['product_id'].' '.$row['product_name'].' '.$row['size']. ' ('.$row['merek'].')');?></td>                      
      				<td style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;border-bottom: none;"><?php echo number_format($row['total_amount']+$serv,0,",",".");?></td>
              <td style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;border-bottom: none;"><?php echo number_format($row['total_amount']+$serv,0,",",".");?></td>
                      
      			</tr>
      			<?php
                  $totalharga +=$row['total_price'];
                  
      		endforeach;
      	}
          ?>
          <tr>
            <td style="text-align:center;border-left:1px solid #000;border-right:1px solid #000;border-top: none;"></td>
            <td style="text-align:center;border-left:1px solid #000;border-right:1px solid #000;border-top: none;"></td>
            <td style="text-align:center;border-left:1px solid #000;border-right:1px solid #000;border-top: none;"></td>
            <td style="text-align:left;border-left:1px solid #000;border-right:1px solid #000;padding-top:10px;padding-left:15px;border-top: none;">
            <table>
              <tr>
                <td style="border-top:none;">
                  Term -<?= substr($vinv[0]['type_top'],1,1);?> &nbsp;  
                </td>
                <td>:</td>
                <td style="padding-left:20px;border-top:none;">
                  <?php 
                  if($vinv[0]['type_top']=="T1"):
                    echo "DP ".$vinv[0]['persent'].'%';
                  else:
                    echo $vinv[0]['persent'].'%';
                  endif;
                  ?>
                </td>
              </tr>
              <tr>
                <td>
                  Material
                </td>
                <td> :</td>
                <td style="padding-left:20px;text-align:right;">
                  <?php echo number_format($row['total_amount']);?>
                </td>
              </tr>
              <tr>
                <td>
                  Jasa    
                </td>
                <td>  : </td>
                <td style="padding-left:20px;text-align:right"><?= number_format($serv);?></td>
              </tr>
            </table>
            </td>
            <td style="text-align:center;border-left:1px solid #000;border-right:1px solid #000;border-top: none;"></td>
            <td style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;border-top: none;"></td>
          </tr>
          <tr>
              <th colspan="5" style="border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;text-align: right;">Amount</th>
              <th style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;"><?php echo number_format($vinv[0]['total_amount']+$serv);?></th>
          </tr>
          <tr>
              <th colspan="5" style="border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;text-align: right;">Tax <?php if($vinv[0]['ppn'] !=""):echo $vinv[0]['ppn'];else: echo '0';endif;?>%</th>
              <th style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;"><?php echo number_format($vinv[0]['total_tax']);?></th>
          </tr>
          <tr>
              <th colspan="5" style="border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;text-align: right;">Sale Amount</th>
              <th style="text-align:right;border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;"><?php echo number_format($vinv[0]['total_amount']+$vinv[0]['total_tax']+$serv);?></th>
          </tr>
          <tr>
            <td colspan="6">
              <table width="100%" style="margin-top:30px;">
                  <tr>
                    <td width="10%"><i>Says</i></td>
                    <td width="1%">:</td>
                    <td widht="35%"><i><strong>"<?=$CI->linvoice->toEnglish($vinv[0]['total_amount']+$vinv[0]['total_tax']+$serv);?> Rupiah"</strong></i></td>
                  </tr>
                  <tr>
                    <td colspan="3"><i><strong>Payment Full Amount</strong></i></td>
                  </tr>
                  <tr>
                    <td width="20%"><i>Due Date</i></td>
                    <td width="1%">:</td>
                    <td widht="35%"><i><?php echo date('F dS, Y',strtotime($vinv[0]['duedate']));?></i></td>
                  </tr>
                  <tr class="p5">
                    <td colspan="3">
                      <br /><b>Best Regards</b><br /><b>PT. Cipta Kawan Teknik Abadi<br><br><br><br><br><br>			
                    </b>
                    </td>
                  </tr>
                  <tr>
                      <td width="20%"><hr style="border-color:#000;">Authorised Signature</td>
                      <td colspan="2" width="85%"></td>
                  </tr>
              </table>
              <table>
                  <tr>
                    <td width="30%" valign="top"  style="padding-top:20px;">Banking Detail &nbsp;&nbsp;</td>
                    <td width="10%" valign="top"  style="padding-top:20px;">IDR </td>
                    <td width="1%" valign="top"  style="padding-top:20px;">:</td>
                    <td widht="60%" valign="top"  style="padding-top:20px;"><?=$vinv[0]['ac_name'];?><br><?= strtoupper($vinv[0]['bank_name']).' - '.$vinv[0]['branch'];?><br>No. Acc : <?=$vinv[0]['ac_number'];?></td>
                  </tr>
              </table>
          </td>
        </tr>
      </tbody>
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