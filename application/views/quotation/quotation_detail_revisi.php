<style>
    @media Print{
        .break{
             
        }
        @page{
            display:landscape;
        }
    }
</style>
<div class="content-wrapper">
    <section class="content-header d-print-none">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo "Revisi"; ?></h1>
            <small><?php echo "Revisi Quotation"; ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('quotation') ?></a></li>
                <li class="active"><?php echo "Revisi Quotation"; ?></li>
            </ol>
        </div>
    </section>

    <section class="content">
    <div class="row">
           <div class="col-sm-12">
               <div class="panel panel-bd lobidrag">
                   <div class="panel-heading">
                       <div class="panel-title">
                           <h4><?php echo "Revisi Quotation"; ?> </h4>
                       </div>
                    </div>   
                    <div class="panel-body">
                     <button class="btn btn-scondery btn-primary mr-auto" onclick="javascript:printDiv('panel-body');">Print</button>
                         <div id="panel-body">
                            <?php $X=1; foreach($data as $data):?>
                            <div style="margin-top:50px;">
                                <div style="background-color:#eeeeee; page-break-before: always;">
                                    <hr>
                                    <p>&nbsp;<strong>REVISI #<?= $X;?></strong></p>
                                    <hr>
                                </div>
                                    <?php 
                                    $arr=array(1=>"I","II","III","IV","V","VI","VII","VIII","IV","X","XI","XII");
                                    $month  =   date('n',strtotime($data['quotdate']));
                                    $bln=$arr[$month];
                                    ?>
                                    <table border="0" width="100%"  cellpadding="1" style ="margin-bottom:20px;">
                                        <tr>
                                            <td valign="top">Customer Name</td>
                                            <td valign="top">:</td>
                                            <td style="padding-right:20px;" valign="top"><?= $data['customer_name'];?></td> 
                                            <td style="padding-left:20px;" valign="top">Quotation No</td>
                                            <td valign="top">:</td>
                                            <td valign="top"> <?= $data['quot_no'].".".substr($data['first_name'],0,2)."/".$data['perusahaan']."/".$bln."/".date('Y',strtotime($data['quotdate']));?></td>
                                        </tr>
                                        <tr valign="top">
                                            <td>Phone</td>
                                            <td>:</td>
                                            <td style="padding-right:20px;"><?= $data['customer_mobile'];?></td>
                                            <td style="padding-left:20px;" valign="top">Quotation Date</td>
                                            <td valign="top">:</td>
                                            <td valign="top"><?= date('d-m-Y',strtotime($data['quotdate']));?></td>
                                        </tr> 
                                        <tr valign="top">
                                            <td rowspan="4">Address</td>
                                            <td rowspan="4">:</td>
                                            <td  rowspan="4"  width="35%" style="padding-right:80px;"><?= $data['customer_address'];?></td>
                                            <td style="padding-left:20px;">Delivery Time</td>
                                            <td>:</td>
                                            <td><?= $data['delivery_time']." ".$data['delivery_time_sat'];?></td>
                                        </tr>
                                        <tr>                                         
                                            <td style="padding-left:20px;">Validity Time</td>
                                            <td>:</td>
                                            <td> <?= $data['quotation_exp']." ".$data['quotation_exp_sat'];?></td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left:20px;">Type</td>
                                            <td>:</td>
                                            <td><?= $data['type'];?></td>
                                        </tr>
                                        <tr valign="top">
                                            <td style="padding-left:20px;">TOP</td>
                                            <td>:</td>
                                            <td><?= $data['top'];?></td>
                                        </tr>
                                    </table>
                                <p>ITEM QUOTATION</p>
                            </div>
                            <table id="example" class="table table-bordered table-hover" style="width:100%">
                                <thead>
                                    <th>No</th>
                                    <th>Product ID</th>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Price</th>
                                    <th>Discount%</th>
                                    <th>Nett Price</th>
                                    <th>Total Price</th>
                                </thead>
                                <tbody>
                                    <?php 
                                    $arr = explode('&', $data['products']);
                                    $i=1; foreach($arr as $prod):
                                    [$pid,$pnm,$punit,$pqty,$pprice,$pdisc,$disk,$ptot] = explode('~^',$prod);?>
                                    <tr>
                                        <td><?= $i;?></td>
                                        <td><?= $pid;?></td>
                                        <td><?= $pnm;?></td>
                                        <td class="text-right"><?= $pqty;?></td>
                                        <td><?= $punit;?></td>
                                        <td class="text-right"><?= number_format($pprice,2);?></td>
                                        <td class="text-center"><?= $pdisc;?></td>
                                        <td>
                                            <?php
                                            if($pdisc > 0):
                                                $netdsc = $pprice*$pdisc/100;
                                                $hrgnet = $pprice-$netdsc;
                                                echo number_format(ROUND($hrgnet,2));
                                            else:
                                                echo number_format($pprice,2);
                                            endif;
                                            ?>
                                        </td>
                                        <td class="text-right"><?= number_format($ptot,2);?></td>
                                    </tr>
                                    <?php $i++; endforeach;?>
                                    <tr>
                                        <td colspan="8"><strong>Total</strong></td>
                                        <td class="text-right"><strong><?= number_format($data['item_total_amount'],2);?></strong></td>
                                    </tr>
                        
                                </tbody>
                            </table>
                            <?php if ($data['services'] !=null){?>
                            <div>
                                <p>SERVICE QUOTATION</p>
                            </div>
                            <table id="example" class="table table-bordered table-hover" style="width:100%">
                                <thead>
                                    <th>No</th>
                                    <th>Service Name</th>
                                    <th>Quantinty</th>
                                    <th>Charge</th>
                                    <th>Discount%</th>
                                    <th>Nett Price</th>
                                    <th>Total Price</th>
                                </thead>
                                <tbody>
                                    <?php 
                                        $i=1;
                                        $ser = explode(',', $data['services']); 
                                        foreach($ser as $serv):
                                        [$snm,$qty,$price,$sdisc,$discout_amount,$stot] = explode('~^',$serv); 
                                    ?>
                                        <tr>
                                            <td><?= $i;?></td>
                                            <td><?= $snm;?></td>
                                            <td class="text-right"><?= $qty;?></td>
                                            <td class="text-right"><?= number_format($price,2);?></td>
                                            <td class="text-center"><?= $sdisc;?></td>
                                            <td class="text-right">
                                                <?php
                                                    if($sdisc > 0):
                                                    $sdis       = $price * $sdisc/100;
                                                    $servhrgdsc = $price-$sdis;
                                                    echo number_format($servhrgdsc,2);
                                                    else :
                                                       echo number_format($price,2);
                                                    endif;
                                                ?>
                                            </td>
                                            <td class="text-right"><?= number_format($stot,2);?></td>
                                        </tr>
                                    <?php $i++; endforeach;?>
                                    <tr>
                                        <td colspan="6"><strong>Total</strong></td>
                                        <td class="text-right"><strong><?= number_format($data['service_total_amount'],2);?></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php }?>
                            <div style="text-align:right;font-size:16pt;">
                                <strong>AMOUNT NET : <?= number_format($data['item_total_amount']+$data['service_total_amount'],2);?> </strong>
                            </div>
                            <?php $X++; endforeach;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
            
