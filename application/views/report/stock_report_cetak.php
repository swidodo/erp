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
    <meta http-equiv="refresh" content="2;url=<?php echo site_url('creport');?>" />
    <title>Document</title>
    <style>
    @media print{
      thead{
        display: table-header-group;
      }
    }
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
<!-- <div class="title">
        <img src="<?php
        if (isset($Web_settings[0]['invoice_logo'])) {
            echo $Web_settings[0]['invoice_logo'];
        }
        ?>" class="" alt="" style="max-width:50%;">
    </div>


    <div class="content" style="text-align:left;">
    <center>
      <h3 style="font-size: 9pt;">LAPORAN STOK BARANG</h3>
      </center>   -->
      
     <table class="table" style="font-size:8pt;" cellpadding="3" cellspacing="1" width="100%" border="1">
         <thead>
         <tr style="border:0px; text-align:left;">
           <th colspan="12">
                <img src="<?php
                if (isset($Web_settings[0]['invoice_logo'])) {
                    echo $Web_settings[0]['invoice_logo'];
                }
                ?>" class="" alt="" style="max-width:50%;">
            </th>
         </tr>
         <tr style="border-top:0px;border-left:0px;border-right:0px">
           <th colspan="12">
             <h3 style="font-size: 9pt;">LAPORAN STOK BARANG</h3>
           </th>
         </tr>
         <tr>
             <th width="2%">No.</th>
             <th width="10%">ProductID</th>
             <th width="15%">Product Name</th>
             <th width="10%">Size</th>
             <th width="10%">Dimensi</th>
             <th width="10%">Bobot</th>
             <th width="10%">Brand</th>
             <th width="5%">product IN</th>
             <th width="5%">Product OUT</th>
             <th width="5%">Akhir</th>
             <!-- <th width="10%">Kondisi</th>
             <th width="10%">Lokasi</th> -->
             <th width="10%">Price</th>
             <th width="10%">Amount(Rp)</th>
         </tr>
         </thead>
         <tbody>
             <?php
             if(!empty($product_list)){
                $no = 0;
                foreach($product_list as $row){
                    $no++;
                    $stockout = $this->db->select('sum(quantity) as totalSalesQnty')->from('invoice_details')->where('product_id',$row->product_id)->where('status',2)->get()->row();
                    $stockin = $this->db->select('sum(quantity) as totalPurchaseQnty,Avg(rate) as purchaseprice')->from('product_purchase_details')->where('product_id',$row->product_id)->get()->row();
                       
           
                       $sprice = (!empty($row->price)?$row->price:0);
                       $pprice = (!empty($stockin->purchaseprice)?sprintf('%0.2f',$stockin->purchaseprice):0); 
                       $stock =  (!empty($stockin->totalPurchaseQnty)?$stockin->totalPurchaseQnty + $row->stock_start:$row->stock_start)-(!empty($stockout->totalSalesQnty)?$stockout->totalSalesQnty:0);

                       $keluar = (!empty($stockout->totalSalesQnty)?$stockout->totalSalesQnty:0);
                       $masuk = (!empty($stockin->totalPurchaseQnty)?$stockin->totalPurchaseQnty + $row->stock_start:$row->stock_start);

                       $akhir = $stock;

                       $totalamount = $stock*$sprice;
                    ?>
                    <tr>
                        <td><?=$no;?></td>
                        <td><?=$row->product_id;?></td>
                        <td><?=$row->product_name;?></td>
                        <td><?=$row->size;?></td>
                        <td><?=$row->dimension;?></td>
                        <td><?=$row->bobot;?></td>
                        <td><?=$row->merek;?></td>
                        <td><?=$masuk;?></td>
                        <td><?=$keluar;?></td>
                        <td><?=$akhir;?></td>
                        <!-- <td></td>
                        <td></td> -->
                        <td><?=number_format($sprice);?></td>
                        <td><?=number_format($totalamount);?></td>
                    </tr>
                    <?php    
                }
             }
             ?>
         </tbody>
     </table>
     

    </div>
</body>
</html>