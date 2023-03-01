<script src="<?php echo base_url() ?>my-assets/js/admin_js/invoice_do.js" type="text/javascript"></script>

<!-- Edit Invoice Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('create_do') ?></h1>
            <small><?php echo display('create_do') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('manage_do') ?></a></li>
                <li class="active"><?php echo display('create_do') ?></li>
            </ol>
        </div>
    </section>

    <section class="content">
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
        <!-- Invoice report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4>Form DO Baru</h4>
                        </div>
                    </div>
                    <?php echo form_open('Cinvoice/do_update', array('class' => 'form-vertical', 'id' => 'invoice_update')) ?>
                    <input type="hidden" name="invoiceid" value="{invoice_id}">
                    <input type="hidden" name="iddo" value="{id_do}">
                    <div class="panel-body">

                    <div class="row">

                        <div class="col-sm-6" id="payment_from_1">
                            <div class="form-group row">
                                <label for="customer_name" class="col-sm-3 col-form-label"><?php
                                    echo display('customer_name');
                                    ?></label>
                                <div class="col-sm-6">
                                    <input type="text" size="100"  name="customer_name" class=" form-control" id="customer_name" tabindex="1" readonly="readonly" value="{customer_name}"/>

                                    <input id="autocomplete_customer_id" class="customer_hidden_value abc" type="hidden" name="customer_id" value="{customer_id}">
                                </div>
                                
                            </div>
                        </div>

                        <div class="col-sm-6" id="payment_from_1">
                            <div class="form-group row">
                                <label for="customer_name" class="col-sm-3 col-form-label">NO. PO </label>
                                <div class="col-sm-6">
                                    <input type="text" name="po_id" class=" form-control" placeholder='Masukkan No. PO' id="pono" tabindex="1" readonly="readonly" value="{po_id}"/>
                                </div>
                                
                            </div>
                        </div>
                        </div>

                        <div class="row">

                        
                            <div class="col-sm-6" id="payment_from">
                                <div class="form-group row">
                                    <label for="payment_type" class="col-sm-3 col-form-label">DO Date
                                        <i class="text-danger">*</i></label>
                                    <div class="col-sm-7">
                                       
                                    <input type="date" name="tgldo" class=" form-control" placeholder='Masukkan No. PO' id="tgldo" tabindex="1" value="<?=date('Y-m-d');?>" />
                                    
                                    </div>
                                
                                </div>
                            </div>

                            <div class="col-sm-6" id="payment_from_1">
                                <div class="form-group row">
                                    <label for="customer_name" class="col-sm-3 col-form-label">Tanggal PO</label>
                                    <div class="col-sm-6">
                                        <input type="date" name="po_date" class=" form-control" placeholder='Masukkan No. PO' id="tglpo" tabindex="1" value="{po_date}" readonly/>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">

                         <div class="form-group row">                            
                            
                             <div class="col-sm-6">
                                 <label for="type" class="col-sm-3 col-form-label">Type<i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <select name="type" class="form-control" data-placeholder="<?php echo display('select_one'); ?>" > 

                                        <option value="To be invoice later" <?php $type == 'To be invoice later' ? 'selected' : '' ?>>To be invoice later</option>
                                        <option value="On loan" <?php echo $type == 'On loan' ? 'selected' : '' ?>>On loan</option>     
                                        <option value="Sample" <?php $type == 'Sample' ? 'selected' : '' ?>>Sample</option>     
                                    </select>
                                </div>
                            </div> 
                        </div>
                    </div>

                       
                        
                        <br>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="normalinvoice">
                                <thead>
                                    <tr>
                                    <th class="text-center" width="25%"><?php echo display('item_information') ?> <i class="text-danger">*</i></th>
                                   
                                        <th class="text-center" width="5%"><?php echo display('unit') ?></th>
                                        <th class="text-center" width="10%"><?php echo display('quantity') ?>  <i class="text-danger">*</i></th>
                                       <!--  <th class="text-center" width="20%">Keterangan <i class="text-danger">*</i></th> -->
                                        <th class="text-center" width="20%">Remarks</th>
                                        <th class="text-center" width="10%"><?php echo display('action') ?></th>
                                    </tr>
                                </thead>
                                <tbody id="addinvoiceItem">
                                    {invoice_all_data}
                                    <tr>
                                        <td class="product_field">
                                            <input type="text" name="product_name" onkeypress="invoice_productList({sl});" value="{product_name} - {size} ({merek})" class="form-control productSelection" required placeholder='<?php echo display('product_name') ?>' id="product_name_{sl}" tabindex="3">

                                            <input type="hidden" class="product_id_{sl} autocomplete_hidden_value" name="product_id[]" value="{product_id}" id="SchoolHiddenId"/>
                                        </td>
                                       
                                       
                                        <td>
                                            <input type="text" name="unit[]" class="form-control text-right " readonly="" value="{unit}" />
                                        </td>
                                        <td>
                                            <input type="number" name="product_quantity[]" onclick="quantity_calculate({sl});" onchange="quantity_calculate({sl});" value="{qty}" class="total_qntt_{sl} form-control text-right" id="total_qntt_{sl}" min="0" tabindex="4" required="required"/>

                                            <input type="hidden" name="qty_jual_{sl}" value="{qty}" id="qty_jual_{sl}">
                                        <!-- </td>

                                        <td> -->
                                            <input type="hidden" name="desc[]" value="{desc}" id="desc_{sl}" class="desc{sl} form-control" placeholder="Masukkan Deskripsi"/>
                                        </td>

                                        <td>
                                            <input type="text" name="remarks[]" value="{remarks}" id="remarks_{sl}" class="remarks{sl} form-control" placeholder="Masukkan Remarks"/>
                                        </td>
                                        
                                        <td>

                                            

                                            <button  class="btn btn-danger text-center" type="button" value="<?php echo display('delete') ?>" onclick="deleteRow(this)" tabindex="7"><i class="fa fa-close"></i></button>
                                        </td>
                                    </tr>
                                    {/invoice_all_data}
                                </tbody>

                                <!-- <tfoot>
                                    <tr>
                                        <td colspan="5">
                                            <b>DO Details :</b> -->
                                            <textarea type="hidden" id="ket" name="keterangan" class="form-control" rows="4" placeholder="Masukkan Keterangan">{do_detail}</textarea>
                                       <!--  </td>
                                       
                                    </tr>
                                </tfoot> -->
            
                            </table>

                            <div class="well well-sm">

                            <?=anchor('cinvoice/manage_do','Batalkan',['class'=>'btn btn-danger']);?>

                                <input type="submit" id="add_do" class="btn btn-success" name="add-do" value="Simpan Data"/>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </section>
</div>

