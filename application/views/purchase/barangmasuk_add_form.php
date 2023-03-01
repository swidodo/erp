<!-- Product Purchase js -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/json/product_purchase.js.php" ></script>
<!-- Supplier Js -->
<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/supplier.js.php" ></script>

<script src="<?php echo base_url()?>my-assets/js/admin_js/barang_masuk.js" type="text/javascript"></script>


<!-- Add New Purchase Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Buat Surat Barang Masuk</h1>
            <small>Form untuk membuat Surat Barang Masuk</small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('purchase') ?></a></li>
                <li class="active">Tambah Surat Barang Masuk</li>
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
                            <h4>Form PO Baru</h4>
                        </div>
                    </div>

                    <div class="panel-body">
                    <?php echo form_open_multipart('Cpurchase/insert_barang_masuk',array('class' => 'form-vertical', 'id' => 'insert_purchase','name' => 'insert_purchase'))?>
                        

                        <div class="row">
                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="supplier_sss" class="col-sm-4 col-form-label">Vendor
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-6">
                                        <select name="supplier_id" id="supplier_id" class="form-control " required="" tabindex="1" autofocus="autofocus"> 
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
                                    <label for="date" class="col-sm-4 col-form-label"> Tanggal
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <?php $date = date('Y-m-d'); ?>
                                        <input type="text" required tabindex="2" class="form-control datepicker" name="bm_date" value="<?php echo $date; ?>" id="bm_date"  />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                               

                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="invoice_no" class="col-sm-4 col-form-label">PO No.
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-6">
                                        <!-- <input type="text" tabindex="3" class="form-control" name="po_id" placeholder="Masukkan PO No." id="po_id" required/> -->
                                        <select id="po_id" class="form-control" name="po_id" >
                                          <option value="">Pilih PO No.</option>
                                
                                        </select>
                                    </div>

                                    <!-- <div class="col-sm-2">
                                        <a class="btn btn-primary" onClick="getDatas()" title="Get Item" href="#"><i class="fa fa-check"></i></a>
                                    </div> -->
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="invoice_no" class="col-sm-4 col-form-label">No. Surat Jalan
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-6">
                                        <input type="text" tabindex="4" class="form-control" name="suratjalan" placeholder="Masukkan No. Surat Jalan" id="suratjalan" required/>
                                    </div>
                                </div>
                            </div>
                        </div>
                             
<br>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="purchaseTable">
                                <thead>
                                     <tr>
                                            <!-- <th class="text-center" width="20%">Code</th>  -->
                                            <th class="text-center" width="40%"><?php echo display('item_information') ?></th> 
                                            <th class="text-center" width="10%">Qty PO</th>
                                            <th class="text-center" width="10%"><?php echo display('unit') ?></th>
                                            <th class="text-center" width="10%">Qty <i class="text-danger">*</i></th>

                                           

                                            <th class="text-center"width="20%">Remarks</th>
                                            <!-- <th class="text-center"><?php echo display('action') ?></th> -->
                                        </tr>
                                </thead>
                                <tbody id="addPurchaseItem">
                                    <tr>

                                       <!--  <td class="span3 supplier">
                                        

                                            <input type="text" autocomplete="off" class="form-control product_id_1" name="product_id[]" id="SchoolHiddenId"/>

                                        </td> -->

                                       <!--  <td class="span3 supplier">
                                           <input type="text" name="product_name" class="form-control" autocomplete="off" onkeypress="product_pur_or_list(1);" placeholder="Nama Produk" id="product_name_1" tabindex="4" >

                                            <input type="hidden" class="autocomplete_hidden_value product_id_1" name="product_id[]" id="SchoolHiddenId"/>

                                            <input type="hidden" class="sl" value="1">
                                        </td>

                                            <td class="text-right">
                                                <input type="text" name="product_quantity[]" autocomplete="off" id="product_quantitiy_1" required="" class="form-control text-right store_cal_1" placeholder="0.00" value=""  tabindex="5"/>
                                            </td>
                                            <td class="test">
                                                <input type="text" name="unit[]" required="" autocomplete="off" id="unit_1" class="form-control text-right" placeholder="Unit" value="" readonly="" tabindex="6" />
                                            </td>
                                           

                                            <td class="text-right">
                                                <input class="form-control" type="text" autocomplete="off" name="remarks[]" id="remarks" placeholder="Masukkan Remarks" tabindex="7" style="text-align:left;"/>
                                            </td>
                                            <td>

                                               

                                                <button  class="btn btn-danger text-right red" type="button" value="<?php echo display('delete')?>" onclick="deleteRow(this)" tabindex="8"><i class="fa fa-close"></i></button>
                                            </td> -->
                                    </tr>
                                   
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5">
                                            <b>Keterangan:</b>
                                            <textarea id="keterangan" name="keterangan" class="form-control" rows="4" placeholder="Masukkan Keterangan"></textarea>
                                        </td>
                                        <!-- <td>
                                            <button type="button" id="add_invoice_item" class="btn btn-info" name="add-invoice-item"  onClick="addPurchaseOrderField1('addPurchaseItem')"  tabindex="9"/><i class="fa fa-plus"></i></button>

                                            <input type="hidden" name="baseUrl" class="baseUrl" value="<?php echo base_url();?>"/>
                                        </td> -->
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6">
                                <a href="<?=site_url('cpurchase/manage_barang_masuk');?>" class="btn btn-danger btn-large">Batalkan</a>
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
<script type="text/javascript">
    $("#supplier_id").change(function(){
   var base_url = $('#base_url').val();

 var supplier_id = $('#supplier_id').val();
var csrf_test_name = $('[name="csrf_test_name"]').val();
   $.ajax({
            type: "POST",
            url: base_url+"Cpurchase/SupPurchaseGet",
             data: {supplier_id:supplier_id,csrf_test_name:csrf_test_name},
            cache: false,
            success: function(data)
            {
                console.log(data);
                data = JSON.parse(data);
                var html = '';
                var i;
                html += '<option value="">Pilih PO No.</option>';

                for(i=0; i<data.length; i++){

                  html += '<option value="'+data[i].po_id+'">'+data[i].purchase_order+' - '+data[i].perusahaan+'</option>';
                }
                  $('#po_id').html(html);
                         
                      } 
        });

});

     $("#po_id").change(function(){
  getDatas();
  })

</script>






