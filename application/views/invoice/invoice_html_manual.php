<?php
$CI = & get_instance();
$CI->load->model('Web_settings');
$Web_settings = $CI->Web_settings->retrieve_setting_editdata();
?>
<script src="<?php echo base_url() ?>my-assets/js/admin_js/invoice_onloadprint.js" type="text/javascript"></script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('invoice_details') ?></h1>
            <small><?php echo display('invoice_details') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('invoice') ?></a></li>
                <li class="active"><?php echo display('invoice_details') ?></li>
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
                    <div id="printableArea" onload="printDiv('printableArea')">
                        <div class="panel-body">
                            <div class="row print_header">
                                
                                <div class="col-sm-12 company-content">
                                    <img src="<?php
                                    if (isset($Web_settings[0]['invoice_logo'])) {
                                        echo html_escape($Web_settings[0]['invoice_logo']);
                                    }
                                    ?>" class="img-bottom-m" alt="">
                                    
                                   
                                  

                                </div>

                                <div class="col-sm-12 company-content">
                                    <center><h2 class="m-t-0"><?php echo display('invoice') ?></h2></center>

                                    <table border="0" cellpadding="2" cellspacing="0" width="100%">
                                        <tr>
                                            <td width="15%">Name</td>
                                            <td width="1%">:</td>
                                            <td width="25%">{customer_name}</td>
                                            <td width="15%">Invoice No.</td>
                                            <td width="1%">:</td>
                                            <td width="25%">{invoice_no}/CIKA-INV/<?=romawi(intval(date('m',strtotime($final_date)))).'/'.date('Y',strtotime($final_date))?></td>
                                        </tr>

                                        <tr>
                                            <td width="15%">Address</td>
                                            <td width="1%">:</td>
                                            <td width="25%"><?php if ($customer_address) { ?>
                                            {customer_address}
                                        <?php } ?></td>
                                        </tr>

                                        <tr>
                                            <td width="15%">Phone</td>
                                            <td width="1%">:</td>
                                            <td width="25%"><?php if ($customer_mobile) { ?>
                                            {customer_mobile}
                                        <?php } ?></td>
                                        </tr>
                                        <tr>
                                            <td width="15%">Fax</td>
                                            <td width="1%">:</td>
                                            <td width="25%"><?php if ($customer_fax) { ?>
                                            {customer_fax}
                                        <?php } ?></td>
                                        </tr>
                                    </table>
                                   
                                  

                                </div>
                                
                                 
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                                   <tr>
                                            <th class="text-center"><?php echo display('sl') ?></th>
                                            <th class="text-center"><?php echo display('product_name') ?></th>
                                            <th class="text-right"><?php echo display('quantity') ?></th>
                                              <th class="text-center"><?php if($is_unit !=0){ echo display('unit');
                                              }?></th>
                                            <th class="text-center"><?php if($is_desc !=0){ echo display('item_description');} ?></th>
                                           
                                            
                                            <?php if($is_discount > 0){ ?>
                                            <!-- <?php if ($discount_type == 1) { ?>
                                                <th class="text-right"><?php echo display('discount_percentage') ?> %</th>
                                            <?php } elseif ($discount_type == 2) { ?>
                                                <th class="text-right"><?php echo display('discount') ?> </th>
                                            <?php } elseif ($discount_type == 3) { ?>
                                                <th class="text-right"><?php echo display('fixed_dis') ?> </th>
                                            <?php } ?>
                                        <?php }else{ ?>
<th class="text-right"><?php echo ''; ?> </th>
<?php }?> -->
                                            <th class="text-right"><?php echo display('rate') ?></th>
                                            <th class="text-right"><?php echo display('ammount') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {invoice_all_data}
                                        <tr>
                                            <td class="text-center">{sl}</td>
                                            <td class="text-center"><div>{product_name} - ({size})</div></td>
                                            
                                            <td align="right">{quantity}</td>
                                              <!-- <td class="text-center"><div>{unit}</div></td>
                                            <td align="center">{description}</td>
                                            <td align="center">{serial_no}</td>

                                            <?php if ($discount_type == 1) { ?>
                                                <td align="right">{discount_per}</td>
                                            <?php } else { ?>
                                                <td align="right"><?php echo (($position == 0) ? "$currency {discount_per}" : "{discount_per} $currency") ?></td>
                                            <?php } ?> -->

                                            <td align="right"><?php echo (($position == 0) ? "$currency {rate}" : "{rate} $currency") ?></td>
                                            <td align="right"><?php echo (($position == 0) ? "$currency {total_price}" : "{total_price} $currency") ?></td>
                                        </tr>
                                        {/invoice_all_data}
                                        <tr>
                                            <td class="text-left" colspan="6"><b><?php echo display('grand_total') ?>:</b></td>
                                            <td align="right" ><b>{subTotal_quantity}</b></td>
                                            <td></td>
                                            <td></td>
                                            <td align="right" ><b><?php echo (($position == 0) ? "$currency {subTotal_ammount}" : "{subTotal_ammount} $currency") ?></b></td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                               <div class="row">

                                <div class="col-xs-8 invoicefooter-content">

                                    <p></p>
                                    <p><strong>{invoice_details}</strong></p> 
                                   
                                </div>
                                <div class="col-xs-4 inline-block">

                                    <table class="table">
                                        <?php
                                        if ($invoice_all_data[0]['total_discount'] != 0) {
                                            ?>
                                            <tr>
                                                <th class="border-bottom-top"><?php echo display('total_discount') ?> : </th>
                                                <td class="text-right border-bottom-top"><?php echo html_escape((($position == 0) ? "$currency {total_discount}" : "{total_discount} $currency")) ?> </td>
                                            </tr>
                                            <?php
                                        }
                                        if ($invoice_all_data[0]['total_tax'] != 0) {
                                            ?>
                                            <tr>
                                                <th class="text-left border-bottom-top"><?php echo display('tax') ?> : </th>
                                                <td  class="text-right border-bottom-top"><?php echo html_escape((($position == 0) ? "$currency {total_tax}" : "{total_tax} $currency")) ?> </td>
                                            </tr>
                                        <?php } ?>
                                         <?php if ($invoice_all_data[0]['shipping_cost'] != 0) {
                                            ?>
                                            <tr>
                                                <th class="text-left border-bottom-top"><?php echo 'Shipping Cost' ?> : </th>
                                                <td class="text-right border-bottom-top"><?php echo html_escape((($position == 0) ? "$currency {shipping_cost}" : "{shipping_cost} $currency")) ?> </td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <th class="text-left grand_total"><?php echo display('previous'); ?> :</th>
                                            <td class="text-right grand_total"><?php echo html_escape((($position == 0) ? "$currency {previous}" : "{previous} $currency")) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-left grand_total"><?php echo display('grand_total') ?> :</th>
                                            <td class="text-right grand_total"><?php echo html_escape((($position == 0) ? "$currency {total_amount}" : "{total_amount} $currency")) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-left grand_total border-bottom-top"><?php echo display('paid_ammount') ?> : </th>
                                            <td class="text-right grand_total border-bottom-top"><?php echo html_escape((($position == 0) ? "$currency {paid_amount}" : "{paid_amount} $currency")) ?></td>
                                        </tr>				 
                                        <?php
                                        if ($invoice_all_data[0]['due_amount'] != 0) {
                                            ?>
                                            <tr>
                                                <th class="text-left grand_total"><?php echo display('due') ?> : </th>
                                                <td  class="text-right grand_total"><?php echo html_escape((($position == 0) ? "$currency {due_amount}" : "{due_amount} $currency")) ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </table>

                                   

                                </div>
                            </div>
                            <div class="row margin-top50">
                                <div class="col-sm-4">
                                 <div class="inv-footer-left">
                                        <?php echo display('received_by') ?>
                                    </div>
                                </div>
                               <div class="col-sm-4"></div>
                                     <div class="col-sm-4"> <div class="inv-footer-right">
                                        <?php echo display('authorised_by') ?>
                                    </div></div>
                            </div>
                           
                        </div>
                    </div>

                    <div class="panel-footer text-left">
                        <input type="hidden" name="" id="url" value="<?php echo base_url('Cinvoice');?>">
                        <a  class="btn btn-danger" href="<?php echo base_url('Cinvoice'); ?>"><?php echo display('cancel') ?></a>
                        <button  class="btn btn-info" onclick="printDiv('printableArea')"><span class="fa fa-print"></span></button>

                    </div>
                </div>
            </div>
        </div>
    </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->

