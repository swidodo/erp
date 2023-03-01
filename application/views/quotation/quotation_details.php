<?php
$CI = & get_instance();
$CI->load->model('Web_settings');
$Web_settings = $CI->Web_settings->retrieve_setting_editdata();
$user_type = $this->session->userdata('user_type');
$user_id = $this->session->userdata('user_id');
$currency = $currency_details[0]['currency'];
$position = $currency_details[0]['currency_position'];
?>
<link href="<?php echo base_url('assets/custom/quotation.css') ?>" rel="stylesheet" type="text/css"/>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('quotation') ?></h1>
            <small><?php echo display('quotation_details') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('quotation') ?></a></li>
                <li class="active"><?php echo display('quotation_details') ?></li>
            </ol>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Alert Message -->
        <?php
        $message = $this->session->userdata('message');
        if (isset($message)) {
            ?>
            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $message ?>                    
            </div>
            <?php
            $this->session->unset_userdata('message');
        }
        $error_message = $this->session->userdata('error_message');
        if (isset($error_message)) {
            ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $error_message ?>                    
            </div>
            <?php
            $this->session->unset_userdata('error_message');
        }
        ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd">
                    <div id="printableArea">
                        <div class="panel-body">
                            <div class="row marginleft5">
                                <div class="fl-left">
                                    <div class="logo-content" >
                                       <img src="<?php
                                            if ($quot_main[0]['perusahaan'] == "CIKA") {
                                                echo $Web_settings[0]['invoice_logo'];
                                            } else {
                                                echo $Web_settings[0]['invoice_logo_2'];
                                            }
                                            ?>" class="" alt="" style="max-width:500px;">
                                         
                                        </div>
                                    </div>
                                </div>

                                <table class="table table-condesed">
                                    <tr>
                                        <td width="10%"><b>Company</b></td>
                                        <td width="1%">:</td>
                                        <td width="15%"><?php echo $customer_info[0]['customer_name']; ?> </td>
                                        <td width="5%">&nbsp;</td>
                                        <td width="10%"><b>Quotation No</b></td>
                                        <td width="1%">:</td>
                                        <td><?php echo html_escape($quot_main[0]['quot_no'].".");if ($rev !=null):if($rev[0]['jml'] != "0"):echo html_escape("R".$rev[0]['jml'].".");endif;endif;echo html_escape(substr(strtoupper($quot_main[0]['first_name']),0,2)); ?>/<?=$quot_main[0]['perusahaan']."-QTT"?>/<?=romawi(intval(date('m',strtotime($quot_main[0]['quotdate']))));?>/<?=date('Y',strtotime($quot_main[0]['quotdate']));?></td>
        
                                    </tr>
                                    <tr>
                                        <td width="10%"><abbr><b><?php echo display('mobile') ?>:</b></abbr>
                                        </td>
                                        <td width="1%">:</td>
                                        <td width="15%"><?php echo $customer_info[0]['customer_mobile']; ?> </td>
                                        <td width="5%">&nbsp;</td>
                                        <td width="10%"><b><?php echo display('quotation_date'); ?></b></td>
                                        <td width="1%">:</td>
                                        <td width="15%"><?php echo date('F dS, Y', strtotime($quot_main[0]['quotdate'])); ?> </td>

                                    </tr>
                                    <tr>
                                        <td><b>Type</b></td>
                                        <td>:</td>
                                        <td><?= $quot_main[0]['type'];?></td>
                                        <td width="5%">&nbsp;</td>
                                        <td width="10%"><b>Delivery Time</b></td>
                                        <td width="1%">:</td>
                                        <td width="15%"><?php echo $quot_main[0]['delivery_time'].' '.$quot_main[0]['delivery_time_sat']; ?> </td>

                                    </tr>
                                    <tr>
                                        <td><b>TOP</b></td>
                                        <td>:</td>
                                        <td><?= $quot_main[0]['top'];?></td>
                                        <td width="5%">&nbsp;</td>
                                        <td width="10%">
                                            <abbr><b>Validity Time</b></abbr>
                                        </td>
                                        <td width="1%">:</td>
                                        <td width="15%"><?php echo $quot_main[0]['quotation_exp'].' '.$quot_main[0]['quotation_exp_sat']; ?> </td>
                                    </tr>
                                </table> 
                    

                                    <?php
                                     $amount = 0;
                                if (!empty($quot_product[0]['product_name'])) {
                                    ?>
                                    <div class="table-responsive m-b-20">
                                        <table class="table table-striped">
                                            <caption class="text-center"> <h4 class="title-text"><?php echo strtoupper(display('item_quotation')); ?> </h4></caption>
                                            <thead>
                                                <tr>
                                                    <th><?php echo display('sl') ?></th>
                                                    <th class="text-left"><?php echo display('product_id') ?></th>
                                                    <th class="text-left"><?php echo display('item') ?></th>
                                                    <th class="text-right"><?php echo display('qty') ?></th>
                                                    <th class="text-center"><?php echo display('unit') ?></th>
                                                    <th class="text-right"><?php echo display('price') ?></th>
                                                    <?php if ($discount_type == 1) { ?>
                                                    <th class="text-right"><?php echo display('discount_percentage') ?>%</th>
                                                    <?php } elseif ($discount_type == 2) { ?>
                                                    <th class="text-right"><?php echo display('discount') ?> </th>
                                                    <?php } elseif ($discount_type == 3) { ?>
                                                    <th class="text-right"><?php echo display('fixed_dis') ?> </th>
                                                    <?php } ?>
                                                    <th class="text-right"><?php echo 'Nett Price';?></th>
                                                    <th class="text-right"><?php echo 'Total Price'; ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sl = 1;
                                                $amount = 0;
                                                foreach ($quot_product as $item) {
                                           
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $sl ?></td>
                                                        <td class="text-left"><?php echo $item['product_id']; ?></td>
                                                        <td class="text-left"><?php echo $item['product_name'].' '.$item['size'].' ('.$item['merek'].')'; ?></td>
                                                        <td class="text-right"><?php echo $item['used_qty']; ?></td>
                                                        <td class="text-center"><?php echo $item['unit']; ?></td>
                                                        <td class="text-right">
                                                            <?php
                                                            $rate = number_format($item['rate'],2);
                                                            echo $rate;
                                                            ?>
                                                        </td>
                                                        <td class="text-right">
                                                            <?php
                                                            $itemdiscountper = $item['discount_per'];
                                                            echo (!empty($itemdiscountper)?$itemdiscountper:'0');
                                                            ?>
                                                        </td>
                                                        <td class="text-right">                                                         
                                                           <?php  
                                                           if($item['discount_per']>0):
                                                                $hdsc   = $item['rate'] * $item['discount_per']/100;
                                                                $hrg   = $item['rate'] - $hdsc;
                                                                echo number_format(ROUND($hrg),2);
                                                                else:
                                                                     echo number_format($item['rate'],2);
                                                            endif;
                                                           ?>
                                                        </td>
                                                        <td class="text-right">
                                                            <?php
                                                            $amount += $item['total_price'];
                                                            $rate_total = number_format($item['total_price'],2);
                                                            echo $rate_total;
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $sl++;   
                                                }
                                                ?>
                                            </tbody>
                                       
                                            <tfoot>
                                                <tr>
                                                    <td colspan="8" class="text-right"><b><?php echo display('Amount'); ?></b> :</td>
                                                    <td class="text-right">
                                                        <b><?php $amount = number_format($quot_main[0]['item_total_amount'],2);
                                                        echo $amount;?></b>
                                                    </td>
                                                </tr>
                                    
                                            </tfoot>
                                        </table>
                                    </div>
                                <?php } ?>

                                <!-- Service Part start -->
                                                 <?php
                                if (!empty($quot_service[0]['service_name'])) {
                                    ?>
                                    <div class="table-responsive m-b-20">
                                        <table class="table table-striped">
                                            <caption class="text-center"> <h4 class="title-text"><?php echo strtoupper(display('service_quotation')); ?> </h4></caption>
                                            <thead>
                                                <tr>
                                                    <th><?php echo display('sl') ?></th>
                                                    <th class="text-left"><?php echo display('service_name') ?></th>
                                                    <th class="text-center"><?php echo display('qty') ?></th>
                                                    <th class="text-right"><?php echo display('charge') ?></th>
                                                    <?php if ($discount_type == 1) { ?>
                                                    <th class="text-right"><?php echo display('discount_percentage') ?> %</th>
                                                    <?php } elseif ($discount_type == 2) { ?>
                                                        <th class="text-right"><?php echo display('discount') ?> </th>
                                                    <?php } elseif ($discount_type == 3) { ?>
                                                        <th class="text-right"><?php echo display('fixed_dis') ?> </th>
                                                    <?php } ?>
                                                    <th class="text-right"><?php echo 'Amount Price'; ?></th>
                                                    <th class="text-right"><?php echo display('total') ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $ssl = 1;
                                                $subtotalservice = 0;
                                                foreach ($quot_service as $service) {
                                           
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $ssl ?></td>
                                                        <td class="text-left"><?php echo $service['service_name']; ?></td>
                                                        <td class="text-center"><?php echo $service['qty']; ?></td>
                                                        <td class="text-right">
                                                            <?php
                                                            $charge = $service['charge'];
                                                            echo $charge;
                                                            // echo (($position == 0) ? "$currency $charge" : "$charge $currency");
                                                            ?>
                                                        </td>
                                                        <td class="text-right">
                                                            <?php
                                                            $diper = $service['discount'];
                                                            echo (!empty($diper)?$diper:'0');
                                                            ?>
                                                        </td>
                                                        <td class="text-right">
                                                            <?php 
                                                            if($service['discount'] > 0) :
                                                            $cdsc   = $service['charge'] * $service['discount']/100;
                                                            $chrg   = $service['charge'] - $cdsc;
                                                                echo number_format(ROUND($chrg),2);
                                                            else :
                                                                 echo number_format($service['charge'] ,2);
                                                             endif;
                                                            ?>
                                                        </td>
                                                        <td class="text-right">
                                                            <?php
                                                            $subtotalservice += $service['total'];
                                                            $totalcharge = $service['total'];
                                                            echo $totalcharge;
                                                            // echo (($position == 0) ? "$currency $totalcharge" : "$totalcharge $currency");
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $ssl++;
                                                }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="6" class="text-right"><b>Amount :</b></td>
                                                    <td class="text-right"><b>
                                                            <?php
                                                            $servicetotalamount = number_format($quot_main[0]['service_total_amount'], 2);
                                                            echo $servicetotalamount;
                                                            // echo (($position == 0) ? "$currency $servicetotalamount" : "$servicetotalamount $currency");
                                                            ?>
                                                        </b>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                <?php } ?>
                                <!-- <div class="row"> -->                                   
                                <div class="table-responsive m-b-20">
                                    <table class="table table-stripped">
                                       <thead>
                                           <tr><th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                       </thead>
                                        <tbody>
                                            <tr>
                                                <th colspan="24" class="text-right">Amount Net :</th>
                                                <th class="text-right">
                                                    <?php $nettotal = (!empty($quot_main[0]['item_total_amount'])?$quot_main[0]['item_total_amount']:0)+(!empty($quot_main[0]['service_total_amount'])?$quot_main[0]['service_total_amount']:0);
                                               $ntotal =  number_format($nettotal,2);
                                               echo $ntotal;
                                                //   echo (($position == 0) ? "$currency $ntotal" : "$ntotal $currency");
                                                ?> </th>
                                            </tr>
                                        </tbody>                                     
                                    </table>
                                </div>
                                    <div class="row margin-top50" >
                                        <div class="desc-div">
                                            <strong><?php echo display('quot_description') ?> : </strong> <?php echo $quot_main[0]['quot_description'] ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                    
                            <div class="panel-footer text-left">
                                <a  class="btn btn-danger" href="<?php echo base_url('Cquotation/manage_quotation'); ?>"><?php echo display('cancel') ?></a>
                                <a href="<?php echo base_url('Cquotation/print_preview_quotation/'.$quot_main[0]['quotation_id']); ?>"  class="btn btn-success"><span class="fa fa-eye"></span></a>
                                <a href="<?php echo base_url('Cquotation/print_quotation/'.$quot_main[0]['quotation_id']); ?>"  class="btn btn-info" target="_blank"><span class="fa fa-print"></span></a>

                            </div>
                        </div>

                      
                    </div>
                </div>
                </section> <!-- /.content -->
          
            </div> <!-- /.content-wrapper -->
         