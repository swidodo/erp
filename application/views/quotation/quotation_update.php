<script src="<?php echo base_url() ?>my-assets/js/admin_js/json/service_quotation.js.php" ></script>
<script src="<?php echo base_url() ?>my-assets/js/admin_js/json/productquotation.js" ></script>
<script src="<?php echo base_url() ?>my-assets/js/admin_js/json/quotation.js" ></script>

<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('quotation') ?></h1>
            <small><?php echo display('update_quotation'); ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('quotation') ?></a></li>
                <li class="active"><?php echo display('update_quotation') ?></li>
            </ol>
        </div>
    </section>

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
        $user_type = $this->session->userdata('user_type');
        $user_id = $this->session->userdata('user_id');
        ?>


        <!-- New category -->
        <div class="row">
            <div class="col-sm-12">                
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('update_quotation'); ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open('Cquotation/update_quotation', array('class' => 'form-vertical', 'id' => 'insert_quotation')) ?>
                    <div class="panel-body">
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="date" class="col-sm-4 col-form-label"><?php echo 'Company';?> <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <select name="perusahaan" id="perusahaan" class="form-control">
                                        <option value=""><?= $quot_main[0]['perusahaan']?></option>
                                        <?php
                                        if($quot_main[0]['perusahaan'] == "CIKA"){
                                            ?>
                                            <option value="CIKA" selected>CIKA</option>
                                            <option value="KIA">KIA</option>
                                            <?php
                                        }else{
                                            ?>
                                            <option value="CIKA">CIKA</option>
                                            <option value="KIA" selected>KIA</option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <small class="text-danger">Digunakan sebagai KOP dan No. Surat</small>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="quotation_no" class="col-sm-4 col-form-label"><?php echo display('quotation_no') ?> </label>
                                <div class="col-sm-8">
                                    <input type="text" name="quotation_no" id="quotation_no" class="form-control" placeholder="<?php echo display('quotation_no') ?>" value="<?php echo $quot_main[0]['quot_no']; ?>" readonly>
                                    <input type="hidden" name="quotation_id" id="quotation_id" class="form-control"  value="<?php echo $quot_main[0]['quotation_id']; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="customer" class="col-sm-4 col-form-label"><?php echo display('customer') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <select name="customer_id" class="form-control" onchange="get_customer_info(this.value)"  data-placeholder="<?php echo display('select_one'); ?>">
                                        <option value=""></option>
                                        <?php
                                        foreach ($customers as $customer) {
                                            ?>
                                            <option value="<?php echo $customer['customer_id'] ?>" <?php if($customer_info[0]['customer_id']== $customer['customer_id']){echo 'selected';}?>>
                                                <?php echo $customer['customer_name'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="expiry_date" class="col-sm-4 col-form-label">Dilevery Time<i class="text-danger"></i></label>
                                <div class="col-sm-4">
                                    <input type="number" name="deliverytime" id="deliverytime" class="form-control" required value="<?=$quot_main[0]['delivery_time']?>">              
                                </div>
                                <div class="col-sm-4">
                                    
                                    <select name="deliverytimesat" class="form-control" data-placeholder="<?php echo display('select_one'); ?>">
                                        <option value="<?= $quot_main[0]['delivery_time_sat'];?>" selected><?= $quot_main[0]['delivery_time_sat'];?></option>
                                        <option value="day">Day</option>
                                        <option value="week">Week</option>
                                        <option value="mounth">Mounth</option>  
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="address" class="col-sm-4 col-form-label"><?php echo display('address') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <input type="text" name="address" class="form-control" id="address" readonly value="<?php echo $customer_info[0]['customer_address'];?>">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                 <label for="expiry_date" class="col-sm-4 col-form-label"> Validity Time<i class="text-danger"></i></label>
                                 <div class="col-sm-4">
                                    <input type="number" name="quotationexp" id="quotationexp" class="form-control" required value="<?=$quot_main[0]['quotation_exp']?>">              
                                </div>
                                <div class="col-sm-4">
                                    
                                    <select name="quotationexpsat" class="form-control" data-placeholder="<?php echo display('select_one'); ?>">
                                        <option value="<?= $quot_main[0]['quotation_exp_sat'];?>" selected><?= $quot_main[0]['quotation_exp_sat'];?></option>
                                        <option value="day">Day</option>
                                        <option value="week">Week</option> 
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="mobile" class="col-sm-4 col-form-label"><?php echo display('phone') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <input type="text" name="mobile" class="form-control" value="<?=$customer_info[0]['phone']?>" id="mobile" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="top" class="col-sm-4 col-form-label">TOP</label>
                                <div class="col-sm-8">
                                    <input type="text" name="top" class="form-control" id="top" value="<?= $quot_main[0]['top'];?> ">
                                </div>
                            </div>
                        </div> 
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="qdate" class="col-sm-4 col-form-label"><?php echo display('quotation_date') ?> </label>
                                <div class="col-sm-8">
                                    <input type="text" name="qdate" class="form-control datepicker" id="qdate" value="<?php echo $quot_main[0]['quotdate']?>">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                 <label for="type" class="col-sm-4 col-form-label">Type<i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <select name="type" class="form-control" data-placeholder="<?php echo display('select_one'); ?>">
                                        <?php if ($quot_main[0]['type']=="Exclude"):?>
                                            <option value="<?= $quot_main[0]['type'];?>" selected style="background:#eeeeee;"><?= $quot_main[0]['type'];?></option>
                                            <option value="Include">Include</option>
                                        <?php else:?>
                                            <option value="<?= $quot_main[0]['type'];?>" selected style="background:#eeeeee;"><?= $quot_main[0]['type'];?></option>
                                            <option value="Exclude">Exclude</option> 
                                        <?php endif;?>    
                                    </select>
                                </div>
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <?php
                                    $amount = 0;
                                    if (!empty($quot_product[0]['product_name'])) {
                                ?>
                            <div class="table-responsive margin-top10" >
                            <table class="table table-bordered table-hover" id="normalinvoice">
                                <thead>
                                    <tr>
                                        <th class="text-center product_field"><?php echo display('item_information') ?> <i class="text-danger">*</i></th>
                                        <th class="text-center"><?php echo display('available_qnty') ?></th>
                                        <th class="text-center"><?php echo display('unit') ?></th>
                                        <th class="text-center"><?php echo display('quantity') ?> <i class="text-danger">*</i></th>
                                        <th class="text-center invoice_fields"><?php echo display('rate') ?> <i class="text-danger">*</i></th>

                                        <?php if ($discount_type == 1) { ?>
                                            <th class="text-center invoice_fields"><?php echo display('discount_percentage') ?> %</th>
                                        <?php } elseif ($discount_type == 2) { ?>
                                            <th class="text-center invoice_fields"><?php echo display('discount') ?> </th>
                                        <?php } elseif ($discount_type == 3) { ?>
                                            <th class="text-center invoice_fields"><?php echo display('fixed_dis') ?> </th>
                                        <?php } ?>

                                        <th class="text-center invoice_fields"><?php echo display('total') ?> 
                                        </th>
                                        <th class="text-center"><?php echo display('action') ?></th>
                                    </tr>
                                </thead>
                                <tbody id="addinvoiceItem">
                                    <?php
                                        $sl = 1;
                                        $amount = 0;
                                        foreach ($quot_product as $item) {

                                        $product_id = $item['product_id'];
                                        $av = $this->db->query("SELECT a.stock_start + (SELECT if (quantity !='',SUM(quantity),0) as qtyp FROM product_purchase_details WHERE product_id='$product_id') - (SELECT if (quantity !='',SUM(quantity),0) as qtyinv FROM invoice_details WHERE product_id='$product_id' and status='2') as avalable FROM product_information as a WHERE a.product_id='$product_id'");
                                        $available_quantity = $av->result_array();
                                    ?>
                                    <tr>
                                        <td class="product_field">
                                            <input type="text" name="product_name" onkeypress="invoice_productList(<?php echo $sl;?>);" class="form-control productSelection" placeholder='<?php echo display('product_name') ?>' value="<?php echo $item['product_name'].' '.$item['size'].' ('.$item['merek'].')'; ?>"  id="product_name_<?php echo $sl;?>" tabindex="5">

                                            <input type="hidden" class="autocomplete_hidden_value product_id_<?php echo $sl;?>" value="<?php echo $item['product_id']; ?>" name="product_id[]" id="SchoolHiddenId"/>

                                            <input type="hidden" class="baseUrl" value="<?php echo base_url(); ?>" />
                                        </td>
                                         
                                        
                                        <td>
                                            <input type="text" name="available_quantity[]" class="form-control text-right available_quantity_<?php echo $sl;?>" value="<?php echo $available_quantity[0]['avalable'];?>" readonly="" />
                                        </td>
                                        <td>
                                            <input name="" id="" class="form-control text-right unit_<?php echo $sl;?> valid" value="<?php echo $item['unit']; ?>" readonly="" aria-invalid="false" type="text">
                                        </td>
                                        <td>
                                            <input type="text" name="product_quantity[]" onkeyup="quantity_calculate(<?php echo $sl;?>);" onchange="quantity_calculate(<?php echo $sl;?>);" class="total_qntt_1 form-control text-right" id="total_qntt_<?php echo $sl;?>" placeholder="0.00" min="0" tabindex="8"  value="<?php echo $item['used_qty']; ?>"/>
                                        </td>
                                        <td class="invoice_fields">
                                            <input type="text" name="product_rate[]" id="price_item_<?php echo $sl;?>" class="price_item<?php echo $sl;?> price_item form-control text-right" tabindex="9"  onkeyup="quantity_calculate(<?php echo $sl;?>);" onchange="quantity_calculate(<?php echo $sl;?>);" value="<?php echo $item['rate']; ?>" placeholder="0.00" min="0" />
                                             <input type="hidden" name="supplier_price[]" id="supplier_price_<?php echo $sl;?>" value="<?php echo $item['supplier_rate']; ?>">
                                        </td>
                                        <!-- Discount -->
                                        <td>
                                            <input type="text" name="discount[]" onkeyup="quantity_calculate(<?php echo $sl;?>);"  onchange="quantity_calculate(<?php echo $sl;?>);" id="discount_<?php echo $sl;?>" class="form-control text-right" min="0" tabindex="10" placeholder="0.00" value="<?php echo $item['discount_per']; ?>"/>
                                            <input type="hidden" value="<?php echo $discount_type;?>" name="discount_type" id="discount_type_<?php echo $sl;?>">

                                        </td>
                                        <td class="invoice_fields">
                                            <input class="total_price form-control text-right" type="text" name="total_price[]" id="total_price_<?php echo $sl;?>" value="<?php echo $item['total_price']; ?>" readonly="readonly" />
                                        </td>

                                        <td>
                                           <button   class='btn btn-danger' type='button'  onclick='deleteRow(this)'><i class='fa fa-close'></i></button>
                                            <!-- Tax calculate start-->
                                            <?php $x=0;
                                        foreach($taxes as $taxfldt){
                                        $tfield = 'tax'.$x;
                                        ?>

                                            <input id="total_tax<?php echo $x;?>_<?php echo $sl;?>" class="total_tax<?php echo $x;?>_<?php echo $sl;?>" type="hidden" value="<?php echo $item[$tfield]; ?>">
                                            <input id="all_tax<?php echo $x;?>_<?php echo $sl;?>" class="total_tax<?php echo $x;?>" value="<?php echo $itemtaxin[0][$tfield];?>" type="hidden" name="tax[]">
                                           
                                            <!-- Tax calculate end-->

                                            <!-- Discount calculate start-->
                                           
                                        <?php $x++;} ?>
                                            <!-- Tax calculate end-->

                                            <!-- Discount calculate start-->
                                            <input type="hidden" id="total_discount_<?php echo $sl;?>" class=""  value="<?php echo $item['discount']; ?>"/>
                                            <input type="hidden" id="all_discount_<?php echo $sl;?>" class="total_discount dppr" name="discount_amount[]" value="<?php echo $item['discount']; ?>"/>
                                            <!-- Discount calculate end -->

                                        
                                        </td>
                                    </tr>
                                    <?php $sl++; }?>
                                </tbody>
                                <tfoot>
                                    <!-- <tr>
                                        <td class="text-right" colspan="6"><b><?php echo display('invoice_discount') ?>:</b></td>
                                        <td class="text-right"> -->
                                        <input type="hidden" onkeyup="quantity_calculate(1);"  onchange="quantity_calculate(1);" id="invoice_discount" class="form-control text-right total_discount" name="invoice_discount" placeholder="0.00" value="<?php echo $quot_main[0]['quot_dis_item']; ?>"   tabindex="13"/>
                                        <input type="hidden" id="txfieldnum" value="<?php echo $taxnumber;?>">
                                        <!-- </td>
                                    </tr> -->
                                    <tr>
                                        <td class="text-right" colspan="6">
                                            <b><?php echo 'Amount'; ?>:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="subtotal" class="form-control text-right" name="sub_total" value="<?php echo $quot_main[0]['item_total_amount']; ?>" readonly="readonly" />
                                            <input type="hidden" id="total_discount_ammount" class="form-control text-right" name="total_discount" value="<?php echo $quot_main[0]['item_total_dicount']; ?>" readonly="readonly" />
                                        </td>
                                        <td><a  id="add_invoice_item" class="btn btn-info" name="add-invoice-item"  onClick="addInputField('addinvoiceItem');"  tabindex="11"><i class="fa fa-plus"></i></a></td>
                                    </tr>
                                    <!-- <tr>
                                        <td class="text-right" colspan="6"><b><?php echo display('total_tax') ?>:</b></td>
                                        <td class="text-right"> -->
                                            <?php $x=0;foreach($taxes as $taxfldt){$txfild = 'tax'.$x;?>
                                  
                                            <input id="total_tax_ammount<?php echo $x;?>" tabindex="-1" class="form-control text-right valid totalTax" name="total_tax<?php echo $x;?>" value="<?php echo $itemtaxin[0][$txfild]?>" readonly="readonly" aria-invalid="false" type="hidden">
                                
                                            <?php $x++;}?>
                                            <input id="total_tax_amount" tabindex="-1" class="form-control text-right valid" name="total_tax" value="<?php echo $quot_main[0]['item_total_tax']; ?>" readonly="readonly" aria-invalid="false" type="hidden">
                                       <!--  </td> -->
                                </tfoot>
                            </table>
                        </div>
                        <?php }?>
                    </div>
                </div>
                    
                <hr>
                <div>
                    <button type="button" class="btn btn-primary"  id="service_quotation_div">Add Service Quotation</button>  
                </div>
                <div class="row" id="quotation_service" >
                    <div class="col-sm-12">
                        <input type="hidden" id="is_quotation" value="<?php echo $quot_service[0]['service_id'];?>" name="">
                    <div class="table-responsive margin-top10">
                        <table class="table table-bordered table-hover" id="serviceInvoice">
                            <thead>
                                <tr>
                                    <th class="text-center product_field"><?php echo display('service_name') ?> <i class="text-danger">*</i></th>
                                    <th class="text-center"><?php echo display('quantity') ?> <i class="text-danger">*</i></th>
                                    <th class="text-center invoice_fields"><?php echo display('charge') ?> <i class="text-danger">*</i></th>

                                    <?php if ($discount_type == 1) { ?>
                                        <th class="text-center"><?php echo display('discount_percentage') ?> %</th>
                                    <?php } elseif ($discount_type == 2) { ?>
                                        <th class="text-center"><?php echo display('discount') ?> </th>
                                    <?php } elseif ($discount_type == 3) { ?>
                                        <th class="text-center"><?php echo display('fixed_dis') ?> </th>
                                    <?php } ?>

                                    <th class="text-center"><?php echo display('total') ?> 
                                    </th>
                                    <th class="text-center"><?php echo display('action') ?></th>
                                </tr>
                            </thead>
                            <tbody id="addservicedata">
                                <?php
                                if($quot_service){
                                    $sr = 1;
                                    foreach ($quot_service as $service) {
                                ?>
                                <tr>
                                    <td class="product_field">
                                        <input type="text" name="service_name" onkeypress="invoice_serviceList(<?php echo $sr;?>);" class="form-control serviceSelection" placeholder='<?php echo display('service_name') ?>' value="<?php echo $service['service_name']; ?>" id="service_name" tabindex="7">

                                        <input type="hidden" class="autocomplete_hidden_value service_id_<?php echo $sr;?>" name="service_id[]" value="<?php echo $service['service_id']; ?>"/>

                                        <input type="hidden" class="baseUrl" value="<?php echo base_url(); ?>" />
                                    </td>

                                    <td>
                                        <input type="text" name="service_quantity[]" onkeyup="serviceCAlculation(<?php echo $sr;?>);" onchange="serviceCAlculation(<?php echo $sr;?>);" class="total_service_qty_<?php echo $sr;?> form-control text-right" id="total_service_qty_<?php echo $sr;?>" value="<?php echo $service['qty']; ?>" placeholder="0.00" min="0" tabindex="8"/>
                                    </td>
                                    <td class="invoice_fields">
                                        <input type="text" name="service_rate[]" id="service_rate_<?php echo $sr;?>" class="service_rate<?php echo $sr;?> service_rate form-control text-right" value="<?php echo $service['charge']; ?>" tabindex="9" onkeyup="serviceCAlculation(<?php echo $sr;?>);" onchange="serviceCAlculation(<?php echo $sr;?>);" placeholder="0.00" min="0" />
                                        
                                    </td>
                                    <!-- Discount -->
                                    <td>
                                        <input type="text" name="sdiscount[]" onkeyup="serviceCAlculation(<?php echo $sr;?>);" onchange="serviceCAlculation(<?php echo $sr;?>);" id="sdiscount_<?php echo $sr;?>" class="form-control text-right common_servicediscount" value="<?php echo $service['discount']; ?>" placeholder="0.00" min="0">
                                        <input type='hidden' value='<?php echo $discount_type;?>' name='discount_type' id='sdiscount_type_<?php echo $sr;?>'>
                                    </td>
                                    <td class="invoice_fields">
                                        <input class="total_serviceprice form-control text-right" type="text" name="total_service_amount[]" id="total_service_amount_<?php echo $sr;?>" value="<?php echo $service['total']; ?>" readonly="readonly" />
                                    </td>
                                    <td>
                                        <button  class='btn btn-danger text-center' type='button'  onclick="deleteServicraw(this)"><i class='fa fa-close'></i></button>
                                        <!-- Tax calculate start-->
                                        <?php $x=0;
                                        foreach($taxes as $taxfldt){
                                            $stxin = 'tax'.$x;
                                        ?>
                                        <input id="total_service_tax<?php echo $x;?>_<?php echo $sr;?>" class="total_service_tax<?php echo $x;?>_<?php echo $sr;?>" type="hidden" value="<?php echo $service[$stxin]; ?>">
                                        <input id="all_servicetax<?php echo $x;?>_<?php echo $sr;?>" class="total_service_tax<?php echo $x;?>" type="hidden" name="stax[]">
                                        
                                        <!-- Tax calculate end-->

                                        <!-- Discount calculate start-->
                                           
                                        <?php $x++;} ?>
                                        <!-- Tax calculate end-->
                                        <input type="hidden" id="totalServiceDicount_<?php echo $sr;?>" value="<?php echo $service['discount_amount']; ?>" class="totalServiceDicount_<?php echo $sr;?>">

                                        <input type="hidden" id="all_service_discount_<?php echo $sr;?>" value="<?php echo $service['discount_amount']; ?>" class="totalServiceDicount" name="sdiscount_amount[]">   
                                    </td>
                                </tr>
                                <?php $sr++;}}else{ ?>
                                <tr>
                                    <td class="product_field">
                                        <input type="text" name="service_name" onkeypress="invoice_serviceList(1);" class="form-control serviceSelection" placeholder='<?php echo display('service_name') ?>'  id="service_name" tabindex="7">

                                        <input type="hidden" class="autocomplete_hidden_value service_id_1" name="service_id[]"/>

                                        <input type="hidden" class="baseUrl" value="<?php echo base_url(); ?>" />
                                    </td>
                                    <td>
                                        <input type="text" name="service_quantity[]" onkeyup="serviceCAlculation(1);" onchange="serviceCAlculation(1);" class="total_service_qty_1 form-control text-right" id="total_service_qty_1" placeholder="0.00" min="0" tabindex="8"/>
                                    </td>
                                    <td>
                                        <input type="text" name="service_rate[]" id="service_rate_1" class="service_rate1 service_rate form-control text-right" tabindex="9" onkeyup="serviceCAlculation(1);" onchange="serviceCAlculation(1);" placeholder="0.00" min="0" />
                                        
                                    </td>
                                    <!-- Discount -->
                                    <td>
                                        <input type="text" name="sdiscount[]" onkeyup="serviceCAlculation(1);" onchange="serviceCAlculation(1);" id="sdiscount_1" class="form-control text-right common_servicediscount" placeholder="0.00" min="0">
                                        <input type='hidden' value='' name='discount_type' id='sdiscount_type_1'>
                                    </td>
                                    <td>
                                        <input class="total_serviceprice form-control text-right" type="text" name="total_service_amount[]" id="total_service_amount_1" value="0.00" readonly="readonly" />
                                    </td>
                                    <td>
                                        <!-- Tax calculate start-->
                                        <?php $x=0;
                                        foreach($taxes as $taxfldt){?>
                                            <input id="total_service_tax<?php echo $x;?>_1" class="total_service_tax<?php echo $x;?>_1" type="hidden">
                                            <input id="all_servicetax<?php echo $x;?>_1" class="total_service_tax<?php echo $x;?>" type="hidden" name="stax[]">
                                           
                                            <!-- Tax calculate end-->

                                            <!-- Discount calculate start-->
                                           
                                        <?php $x++;} ?>
                                        <!-- Tax calculate end-->
                                        <input type="hidden" id="totalServiceDicount_1" class="totalServiceDicount_1">

                                        <input type="hidden" id="all_service_discount_1" class="totalServiceDicount" name="sdiscount_amount[]">
                                    </td>
                                </tr>
                                <?php }?>
                            </tbody>
                            <tfoot>
                                <!-- <tr> -->
                                    <!-- <td class="text-right" colspan="4">
                                        <b><?php echo display('service_discount') ?>:</b>
                                    </td> -->
                                    <!-- <td class="text-right"> -->
                                        <input type="hidden" onkeyup="serviceCAlculation(1);"  onchange="serviceCAlculation(1);" id="service_discount" class="form-control text-right" name="service_discount" placeholder="0.00" value="<?php echo $quot_main[0]['quot_dis_service']; ?>" />
                                        <input type="hidden" id="sertxfieldnum" value="<?php echo $taxnumber;?>">
                                    <!-- </td> -->
                                    
                                </tr>
                                <tr>
                                    <!-- <td class="text-right" colspan="4">
                                        <b><?php echo display('totalServiceDicount') ?>:</b>
                                    </td>
                                    <td class="text-right"> -->
                                        <input type="hidden" id="total_service_discount" class="form-control text-right" name="totalServiceDicount" readonly="readonly" value="<?php echo $quot_main[0]['service_total_discount']; ?>"/>
                                    <!-- </td>
                                    <td>
                                        <button type="button" id="add_service_item" class="btn btn-info" name="add-invoice-item"  onClick="addService('addservicedata');"><i class="fa fa-plus"></i></button>
                                    </td> -->
                                </tr>    
                                <tr>
                                    <td colspan="4"  class="text-right">
                                        <b><?php echo 'Amount'; ?>:</b>
                                    </td>
                                    <td class="text-right">
                                        <input type="text" id="serviceSubTotal" class="form-control text-right" name="grand_total_service_amount" value="<?php echo $quot_main[0]['service_total_amount']; ?>" readonly="readonly" />
                                    </td>
                                    <td>
                                        <button type="button" id="add_service_item" class="btn btn-info" name="add-invoice-item"  onClick="addService('addservicedata');"><i class="fa fa-plus"></i></button>
                                    </td>
                                </tr>
                               <!--  <tr> 
                                    <td class="text-right" colspan="4">
                                        <b><?php echo display('total_service_tax') ?>:</b>
                                    </td>
                                    <td class="text-right"> -->
                                        <?php $x=0;
                                            foreach($taxes as $taxfldt){
                                                $stxssinf= 'tax'.$x;
                                        ?>
                                         <input id="total_service_tax_amount<?php echo $x;?>" tabindex="-1" class="form-control text-right valid totalServiceTax" name="total_service_tax<?php echo $x;?>" value="<?php echo $servicetaxin[0][$stxssinf]?>" readonly="readonly" aria-invalid="false" type="hidden">
                                      <?php $x++;}?> 
                                        <input type="hidden" id="total_service_tax" class="form-control text-right" name="total_service_tax" value="<?php echo $quot_main[0]['service_total_tax']; ?>" readonly="readonly" />
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                    <div class="col-sm-6">
                        <input type="submit" id="add-quotation" class="btn btn-success btn-large" name="add-quotation" value="<?php echo 'Update'; ?>" />
                    </div>
                        </div>
                    </div>               
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </section>
</div>
