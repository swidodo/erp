<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo 'INVOICE' ?></h1>
            <small><?php echo 'Report Invoice' ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo 'Report';?></a></li>
                <li class="active"><?php echo 'Report Invoice'; ?></li>
            </ol>
        </div>
    </section>
    <section class="content">
        <!-- <div class="container"> -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4><?php echo 'Report Invoice'; ?> </h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="">
                                <tbody>
                                    <tr></tr>
                                    <tr>
                                        <td>Start Date&nbsp;&nbsp;</td>
                                        <td><input type="date" id="start"></td>
                                        <td>&nbsp;&nbsp;End Date&nbsp;&nbsp;</td>
                                        <td><input type="date" id="end"></td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                        <td><button class="btn btn-sm btn-warnig"></button>&nbsp;</td>
                                        <td><a href="<?php echo base_url('Cinvoice_quot/reportPeriodeInvoice') ?>" class="btn btn-sm btn-info">All Data</a>&nbsp;</td>
                                        <td><button class="btn btn-sm btn-warning" onclick="printDiv('printableArea')">Print</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="panel-body" id="printableArea">
                            <table class="print-table" width="100%">             
                                <tr>
                                    <td align="left" class="print-table-tr">
                                        <img src="<?php echo $logo[0]['logo'];?>" alt="logo">
                                    </td>
                                    <td align="center" class="print-cominfo">
                                        <span class="company-txt">
                                            <?php echo $company[0]['company_name'];?>
                                            
                                        </span><br>
                                        <?php echo $company[0]['address'];?>
                                        <br>
                                        <?php echo $company[0]['email'];?>
                                        <br>
                                        <?php echo $company[0]['mobile'];?>
                                    </td>
                                    <td align="right" class="print-table-tr" width="20%">
                                        <date>
                                        <?php echo display('date')?>: <?php
                                        echo date('d-M-Y');
                                        ?> 
                                        </date>
                                    </td>
                                </tr>            
                            </table>
                            <div class="table-responsive" id="rsults">
                                <table id="example" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <th>No</th>
                                        <th>Invoice No</th>
                                        <th>Invoice Date</th>
                                        <th>DueDate</th>
                                        <th>Costumer Name</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </thead>
                                    <tbody id="body">
                                        <?php $i=1; foreach($listInv as $Inv):?>
                                        <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?php echo $Inv['invoice'];?></td>
                                            <td><?php echo $Inv['date'];?></td>
                                            <td><?php echo $Inv['duedate'];?></td>
                                            <td><?php echo $Inv['customer_name'];?></td>
                                            <td class="text-right"><?php echo $Inv['total_amount'];?></td>
                                            <td><?php if($Inv['status']=='1'){ echo 'NOT APPROVAL';}elseif($Inv['status']=='2'){echo 'APPROVAL';};?></td>
                                        </tr>
                                        <?php $i++; endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- </div> -->
    </section>
</div>
<script>
   $(document).ready(function(){
       $('#start').on('change', function(){
           var start = $('#start').val();
           var end   = $('#end').val();
           $.ajax({
                url      : '<?= base_url('Cinvoice_quot/periodInv');?>',
                type     : 'post',
                data     : {start:start,end:end},
                async    : true,
                dataType : 'json',
                success  : function(data){
                    var html = '';
                    var i;
                    for (var i = 1; i < data.length; i++) {
                        html += `  
                        <tr>
                            <td>`+ i +`</td>
                            <td>`+ data[i].invoice +`</td>
                            <td>`+ data[i].date +`</td>
                            <td>`+ data[i].duedate +`</td>
                            <td>`+ data[i].customer_name +`</td>
                            <td class="text-right">`+ data[i].total_amount +`</td>`;
                            if (data[i].status == '1'){
                        html+=    ` <td>NOT APPROVAL</td>`;
                                    }else if (data[i].status == '2'){
                        html+=    ` <td>APPROVAL</td>`;
                                    }
                                    else{
                        html+=    ` <td>-</td>`; 
                                    }
                        html += `</tr>`;
                    }
                    $('#body').html(html);
               }
           })
       })
       $('#end').on('change', function(){
           var start = $('#start').val();
           var end   = $('#end').val();
           $.ajax({
                url      : '<?= base_url('Cinvoice_quot/periodInv');?>',
                type     : 'post',
                data     : {start:start,end:end},
                async    : true,
                dataType : 'json',
                success  : function(data){
                
                    var html = '';
                    var i;
                    for (var i = 1; i < data.length; i++) {
                        html += `  
                                <tr>
                                    <td>`+ i +`</td>
                                    <td>`+ data[i].invoice +`</td>
                                    <td>`+ data[i].date +`</td>
                                    <td>`+ data[i].duedate +`</td>
                                    <td>`+ data[i].customer_name +`</td>
                                    <td class="text-right">`+ data[i].total_amount +`</td>`;
                                    if (data[i].status == '1'){
                        html+=    ` <td>NOT APPROVAL</td>`;
                                    }else if (data[i].status == '2'){
                        html+=    ` <td>APPROVAL</td>`;
                                    }
                                    else{
                        html+=    ` <td>-</td>`; 
                                    }
                        html += `</tr>`;

                    }
                    $('#body').html(html);
               }
           })
       })
   })
</script>