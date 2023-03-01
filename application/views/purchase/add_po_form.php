<!-- Product Purchase js -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/json/product_purchase.js.php" ></script>
<!-- Supplier Js -->
<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/supplier.js.php" ></script>

<script src="<?php echo base_url()?>my-assets/js/admin_js/purchase_order.js" type="text/javascript"></script>


<!-- Add New Purchase Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>New PO</h1>
            <small>Form New PO</small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('purchase') ?></a></li>
                <li class="active">Add PO</li>
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
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
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

        <!-- Purchase report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4>NEW FORM PO</h4>
                        </div>
                    </div>

                    <div class="panel-body">
                    <?php echo form_open_multipart('Cpurchase/insert_purchase_order',array('class' => 'form-vertical', 'id' => 'insert_purchase','name' => 'insert_purchase'))?>
                        

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="date" class="col-sm-4 col-form-label"><?php echo 'Company';?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-6">
                                        <select name="perusahaan" id="perusahaan" class="form-control" required>
                                            <option value="">--Pilih--</option>
                                            <option value="CIKA">CIKA</option>
                                            <option value="KIA">KIA</option>
                                            <option value="ST">ST</option>
                                        </select>
                                        <small class="text-danger">Digunakan sebagai KOP dan No. Surat</small>
                                    </div>
                                </div>
                            </div>

                             <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="date" class="col-sm-4 col-form-label">PO Date
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <?php $date = date('Y-m-d'); ?>
                                        <input type="text" required tabindex="2" class="form-control datepicker" name="po_date" value="<?php echo $date; ?>" id="date"  />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="supplier_sss" class="col-sm-4 col-form-label"><?php echo display('supplier') ?>
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-6">
                                        <select name="supplier_id" id="supplier_id" class="form-control " required="" tabindex="1"> 
                                            <option value=" "><?php echo display('select_one') ?></option>
                                            {all_supplier}
                                            <option value="{supplier_id}">{supplier_name}</option>
                                            {/all_supplier}
                                        </select>
                                    </div>
                                  <?php if($this->permission1->method('add_supplier','create')->access()){ ?>
                                    <div class="col-sm-2">
                                        <a class="btn btn-success" title="Add New Supplier" href="<?php echo base_url('Csupplier'); ?>"><i class="fa fa-user"></i></a>
                                    </div>
                                <?php }?>
                                </div> 
                            </div>

                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="adress" class="col-sm-4 col-form-label">Quotation Date
                                    </label>
                                    <div class="col-sm-8">
                                    <input type="text" required tabindex="2" class="form-control datepicker" name="quot_date" value="<?php echo $date; ?>" id="quot_date"  />

                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="invoice_no" class="col-sm-4 col-form-label">Quotation No.
                                        <i class="text-danger"></i>
                                    </label>
                                    <div class="col-sm-6">
                                        <input type="text" tabindex="3" class="form-control" name="quot_id" placeholder="Masukkan Quotation ID" id="quot_id" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="invoice_no" class="col-sm-4 col-form-label">PPN
                                        <i class="text-danger"></i>
                                    </label>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                                <select id="ppnpo" class="form-control" required>
                                                    <option selected></option>
                                                    <option value="Y">Yes</option>
                                                    <option value="N">No</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-6" id="vppn">
                                               <select name="ppn" id="vlpp" class="form-control" required>
                                                    <option value="0">0 %</option>
                                                    <option value="11">11 %</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                             
                        <br>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="purchaseTable">
                                <thead>
                                     <tr>
                                            <th class="text-center" width="20%"><?php echo display('item_information') ?><i class="text-danger">*</i></th> 
                                            <th class="text-center"><?php echo display('quantity') ?> <i class="text-danger">*</i></th>
                                            <th class="text-center"><?php echo display('rate') ?><i class="text-danger">*</i></th>
                                            <th class="text-center"><?php echo 'Discount' ?></th>
                                            <th class="text-center"><?php echo display('total') ?></th>
                                            <th class="text-center"><?php echo 'remark'; ?></th>
                                            <th class="text-center"><?php echo display('action') ?></th>
                                        </tr>
                                </thead>
                                <tbody id="addPurchaseItem">
                                    <tr>
                                        <td class="span3 supplier">
                                           <input type="text" name="product_name" required class="form-control product_name productSelection" onkeypress="product_pur_or_list(1);" placeholder="<?php echo display('product_name') ?>" id="product_name_1" tabindex="5" >
                                            <input type="hidden" class="autocomplete_hidden_value product_id_1" name="product_id[]" id="SchoolHiddenId"/>
                                            <input type="hidden" class="sl" value="1">
                                        </td>                                        
                                        <td class="text-right">
                                            <input type="text" name="product_quantity[]" id="cartoon_1" required="" min="0" class="form-control text-right store_cal_1" onkeyup="calculate_store(1);" onchange="calculate_store(1);" placeholder="0.00" value=""  tabindex="6"/>
                                        </td>
                                        <td class="test">
                                            <input type="text" name="product_rate[]" required="" onkeyup="calculate_store(1);" onchange="calculate_store(1);" id="product_rate_1" class="form-control product_rate_1 text-right" placeholder="0.00" value="" min="0" tabindex="7"/>
                                        </td>

                                        <td class="text-center">
                                            <input type="text" name="discount[]" required="" onkeyup="calculate_store(1);" onchange="calculate_store(1);" id="discount_rate_1" class="form-control discount_rate_1 text-right" placeholder="0.00" value="0" min="0" tabindex="8"/>
                                            <input type="hidden" name="discountval[]" required="" onkeyup="calculate_store(1);" onchange="calculate_store(1);" id="discountval_1" class="form-control discountval_rate_1 text-right" placeholder="0.00" value="0" min="0"/>
                                        </td>
                                        
                                        <td class="text-right">
                                            <input class="form-control total_price text-right" type="text" name="total_price[]" id="total_price_1" value="0.00" readonly="readonly" />
                                        </td>

                                        <td class="text-center">
                                            <input type="text" name="remark[]" id="remark_1" class="form-control remark_1 text-left" placeholder="remark"/>
                                        </td>

                                        <td>
                                            <button  class="btn btn-danger text-right red" type="button" value="<?php echo display('delete')?>" onclick="deleteRow(this)" tabindex="8"><i class="fa fa-close"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        
                                        <td class="text-right" colspan="4"><b><?php echo display('total') ?>:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="Total" class="text-right form-control" name="total" value="0.00" readonly="readonly" />
                                        </td>
                                        <td></td>
                                        <td> <button type="button" id="add_invoice_item" class="btn btn-info" name="add-invoice-item"  onClick="addPurchaseOrderField1('addPurchaseItem')"  tabindex="9"/><i class="fa fa-plus"></i></button>

                                        <input type="hidden" name="baseUrl" class="baseUrl" value="<?php echo base_url();?>"/></td>
                                    </tr>

                                    <tr>
                                        <td class="text-right"><b>Project <span class="text-danger">*)</span></b></td>
                                        <td class="text-right" colspan="4">
                                            <input type="text" id="project" class="form-control" name="project" placeholder="Project" value="" required/>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><b>Delivery Therms <span class="text-danger">*)</span></b></td>
                                        <td class="text-right" colspan="4">
                                            <input type="text" id="deltherms" class="form-control" name="deltherm" placeholder="Masukkan Delivery Therms" value="" required/>
                                        </td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                       <td class="text-right"><b>Delivery Address <span class="text-danger">*)</span></b></td>
                                       <td class="text-right" colspan="4">
                                           <input type="text" id="deladdress" class="form-control" name="deladdress" placeholder="Masukkan Delivery Therms" value="" required/>
                                       </td>
                                       <td></td>
                                   </tr>

                                   <tr>
                                       <td class="text-right"><b>Receiver <span class="text-danger">*)</span></b></td>
                                       <td class="text-right" colspan="4">
                                           <input type="text" id="receiver" class="form-control" name="receiver" placeholder="Receiver" value="" required/>
                                       </td>
                                       <td></td>
                                   </tr>

                                   <tr>
                                       
                                       <td class="text-right"><b>Payment Therms <span class="text-danger">*)</span></b></td>
                                       <td class="text-right" colspan="4">
                                           <textarea name="payment" id="payment" class="form-control" rows="4" required placeholder="Masukkan Payment Therms"></textarea>
                                       </td>
                                       <td></td>
                                   </tr>
                                                               
                                    <tr>
                                        <td class="text-right"><b>Note</b></td>
                                        <td class="text-right" colspan="4">
                                         <textarea id="note" class="form-control" name="note" placeholder="Note" rows="4"></textarea>
                                        </td>
                                        <td></td>
                                    </tr>
                                    
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-md-4">  
                            Recived By 
                            <input type="text" class="form-control" name="ttd1" required> 
                        </div>
                        <div class="col-md-4">        
                            User
                            <input type="text" class="form-control" name="ttd2" required> 
                        </div>
                        <div class="col-md-4">         
                            Sincerely
                            <input type="text" class="form-control" name="ttd3" required>
                        </div>
                        <div class="col-md-4">          
                            Aproved by 
                            <input type="text" class="form-control" name="ttd4" required> 
                        </div>
                        <div class="col-md-4">         
                            Aproved by 
                            <input type="text" class="form-control" name="ttd5" required>
                        </div>         
                        <div class="form-group row">
                            <div class="col-sm-6" style="margin-top:20px;">
                                <a href="<?=site_url('cpurchase/manage_purchase_order');?>" class="btn btn-danger btn-large">Batalkan</a>
                                <input type="submit" id="add_purchase" class="btn btn-primary btn-large" name="add-purchase" value="<?php echo display('submit') ?>" />
                                
                            </div>
                        </div>
                    <?php echo form_close()?>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
<script>
    $('#perusahaan').change(function(){
        var comp =$(this).val();
        if (comp == "ST"){
            $('#ppnpo').html('<option value="N">No</option>');
            $('#vlppn').html('<option value="0">0 %</option>');
        }
    })
$('#vppn').hide();
    $('#ppnpo').on('change',function(){
        var ppn = $('#ppnpo').val();
        
        if (ppn=='Y')
        {
            $('#vppn').show();
        }
        if (ppn=='N'){
            $('#vlppn').val('0');
        }
        else
        {
            $('#vppn').hide();
            $('#vlppn').val('0');
        }
    })
</script>
<!-- Purchase Report End -->






