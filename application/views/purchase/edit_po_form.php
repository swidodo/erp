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
            <h1>Ubah PO Baru</h1>
            <small>Form untuk mengubah PO Baru</small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('purchase') ?></a></li>
                <li class="active">Ubah PO</li>
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
                            <h4>Form Update Purchase Order</h4>
                        </div>
                    </div>

                    <div class="panel-body">
                    <?php echo form_open_multipart('Cpurchase/update_purchase_order',array('class' => 'form-vertical', 'id' => 'insert_purchase','name' => 'insert_purchase'))?>
                    <input type="hidden" name="po_id" value="{po_id}">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="date" class="col-sm-4 col-form-label"><?php echo 'Company';?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-6">
                                        <select name="perusahaan" id="perusahaan" class="form-control" required>
                                            <?php
                                                if($perusahaan == "CIKA"){
                                                    ?>
                                                    <option value="CIKA" selected>{perusahaan}</option>
                                                    <option value="KIA">KIA</option>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <option value="CIKA">CIKA</option>
                                                    <option value="KIA" selected>{perusahaan}</option>
                                                    <?php
                                                }
                                            ?>
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
                                        <input type="text" required tabindex="2" class="form-control datepicker" name="po_date" value="{po_date}" id="date"  />
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
                                            {supplier_list}
                                            <option value="{supplier_id}">{supplier_name}</option>
                                            {/supplier_list} 
                                            {supplier_selected}
                                            <option value="{supplier_id}" selected="">{supplier_name}</option>
                                            {/supplier_selected}
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
                                    <input type="text" required tabindex="2" class="form-control datepicker" name="quot_date" value="{quot_date}" id="quot_date"  />

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
                                        <input type="text" tabindex="3" class="form-control" name="quot_id" placeholder="Masukkan Quotation ID" id="quot_id" value="{quot_id}" required/>
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

                                                    <option selected value="{ppn}"><?php if($ppn == 0 || $ppn ==""):
                                                    echo "No";else : echo "Yes"; endif;?></option>
                                                    <option value="Y">Yes</option>
                                                    <option value="N">No</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-6" id="vppn">
                                               <select name="ppn" id="vlpp" class="form-control" required>
                                                    <option value="{ppn}" selected>{ppn}</option>
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
                                            <th class="text-center"><?php echo "Discount" ?></th>
                                            <th class="text-center"><?php echo display('total') ?></th>
                                            <th class="text-center"><?php echo "Remark" ?></th>
                                            <th class="text-center"><?php echo display('action') ?></th>
                                        </tr>
                                </thead>
                                <tbody id="addPurchaseItem">
                                {purchase_info}
                                    <tr>
                                        <td class="span3 supplier">
                                           <input type="text" name="product_name" required class="form-control product_name productSelection" onkeypress="product_pur_or_list({sl});" placeholder="<?php echo display('product_name') ?>" id="product_name_{sl}" tabindex="5" value="{product_name}"  >

                                            <input type="hidden" class="autocomplete_hidden_value product_id_{sl}" name="product_id[]" id="SchoolHiddenId" value="{product_id}"/>

                                            <input type="hidden" class="sl" value="{sl}">
                                        </td>
                                        
                                        <td class="text-right">
                                            <input type="text" name="product_quantity[]" id="cartoon_{sl}" class="form-control text-right store_cal_{sl}" onkeyup="calculate_store({sl});" onchange="calculate_store({sl});" placeholder="0.00" value="{qty}" min="0" tabindex="6"/>
                                        </td>
                                        <td class="test">
                                            <input type="text" name="product_rate[]" onkeyup="calculate_store({sl});" onchange="calculate_store({sl});" id="product_rate_{sl}" class="form-control product_rate_{sl} text-right" placeholder="0.00" value="{rate}" min="0" tabindex="7"/>
                                        </td>
                                       
                                        <td class="text-center">
                                            <input type="text" name="discount[]" required="" onkeyup="calculate_store({sl});" onchange="calculate_store({sl});" id="discount_rate_{sl}" class="form-control discount_rate_{sl} text-right" placeholder="0.00" value="{discount}" min="0" tabindex="8"/>
                                            <input type="hidden" name="discountval[]" required="" onkeyup="calculate_store({sl});" onchange="calculate_store({sl});" id="discountval_{sl}" class="form-control discountval_rate_{sl} text-right" placeholder="0.00" value="{val_discount}" min="0"/>
                                        </td>
                                        <td class="text-right">
                                            <input class="form-control total_price text-right" type="text" name="total_price[]" id="total_price_{sl}" value="{total_price}" readonly="readonly" />
                                        </td>
                                        <td class="text-right">
                                            <input class="form-control remark text-right" type="text" name="remark[]" id="remark_{sl}" value="{remark}"  />
                                        </td>
                                        <td>
                                            <button  class="btn btn-danger text-right red" type="button" value="<?php echo display('delete')?>" onclick="deleteRow(this)" tabindex="8"><i class="fa fa-close"></i></button>
                                        </td>
                                    </tr>
                                    {/purchase_info}
                                </tbody>
                                <tfoot>
                                    <tr>
                                        
                                        <td class="text-right" colspan="4"><b><?php echo display('total') ?>:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="Total" class="text-right form-control" name="total" value="{total_amount}" readonly="readonly" />
                                        </td>
                                        <td></td>
                                        <td> <button type="button" id="add_invoice_item" class="btn btn-info" name="add-invoice-item"  onClick="addPurchaseOrderField1('addPurchaseItem')"  tabindex="9"/><i class="fa fa-plus"></i></button>

                                            <input type="hidden" name="baseUrl" class="baseUrl" value="<?php echo base_url();?>"/></td>
                                    </tr>
                                     <tr>
                                        <td class="text-right"><b>Project <span class="text-danger">*)</span></b></td>
                                        <td class="text-right" colspan="4">
                                            <input type="text" id="project" class="form-control" name="project" value="{project}" placeholder="Project" value="" required/>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr> 
                                        <td class="text-right"><b>Delivery Therms <span class="text-danger">*)</span></b></td>
                                        <td class="text-right" colspan="4">
                                            <input type="text" id="deltherms" class="form-control" name="deltherm" placeholder="Masukkan Delivery Therms" value="{note_delivery_therm}" required/>
                                        </td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                       
                                       <td class="text-right"><b>Delivery Address <span class="text-danger">*)</span></b></td>
                                       <td class="text-right" colspan="4">
                                           <input type="text" id="deladdress" class="form-control" name="deladdress" placeholder="Masukkan Delivery Therms" value="{note_delivery_address}" required/>
                                       </td>
                                       <td></td>
                                   </tr>
                                   <tr>
                                       <td class="text-right"><b>Receiver <span class="text-danger">*)</span></b></td>
                                       <td class="text-right" colspan="4">
                                           <input type="text" id="receiver" class="form-control" name="receiver" placeholder="Receiver" value="{receiver}" required/>
                                       </td>
                                       <td></td>
                                   </tr>

                                   <tr>
                                       <td class="text-right"><b>Payment Therms <span class="text-danger">*)</span></b></td>
                                       <td class="text-right" colspan="4">
                                           <textarea name="payment" id="payment" class="form-control" rows="4" required placeholder="Masukkan Payment Therms">{payment_therm}</textarea>
                                       </td>
                                       <td></td>
                                   </tr>
                                   
                                    <tr>
                                        <td class="text-right"><b>Note</b></td>
                                        <td class="text-right" colspan="4">
                                         <textarea id="note" class="form-control" name="note" placeholder="Note" rows="4">{note}</textarea>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-md-4">
                            Recived By 
                            <input type="text" class="form-control" name="ttd1" value="{ttd1}"> 
                        </div>
                        <div class="col-md-4">        
                            User
                            <input type="text" class="form-control" name="ttd2" value="{ttd2}"> 
                        </div>
                        <div class="col-md-4">         
                            Sincerely
                            <input type="text" class="form-control" name="ttd3" value="{ttd3}">
                        </div>
                        <div class="col-md-4">          
                            Aproved by 
                            <input type="text" class="form-control" name="ttd4" value="{ttd4}"> 
                        </div>
                        <div class="col-md-4">         
                            Aproved by 
                            <input type="text" class="form-control" name="ttd5" value="{ttd5}">
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

<!-- Purchase Report End -->






