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
                            <h4>Form List DO</h4>
                        </div>
                    </div>
                    <?php echo form_open('Cpurchase/do_insert_purchase', array('class' => 'form-vertical', 'id' => 'do_purchase')) ?>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="supplier_name" class="col-sm-3 col-form-label"><?php
                                    echo 'Supplier Name';
                                    ?></label>
                                <div class="col-sm-6">
                                    <input type="text" size="100"  name="suppliername" class=" form-control" id="supplier_name" tabindex="1" value='<?= $purchase[0]['supplier_name'];?>' readonly/>
                                </div>
                                
                            </div>
                        </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="doid" class="col-sm-3 col-form-label">DO ID</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="do_id" class=" form-control" id="doid">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6" id="purchase_id">
                                <div class="form-group row">
                                    <label for="purchase_id" class="col-sm-3 col-form-label">Purchase ID </label>
                                    <div class="col-sm-6">
                                        <input type="text"id="purchase_id" tabindex="1" value='<?= $purchase[0]['purchase_id'];?>' readonly/>
                                        <input type="hidden" name="purchase_id" value='<?= $purchase[0]['purchase_id'];?>' />
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-sm-6" id="dodate">
                                <div class="form-group row">
                                    <label for="dodate" class="col-sm-3 col-form-label">DO Date
                                        </label>
                                    <div class="col-sm-6">
                                    <input type="date" name="dodate" class=" form-control"  id="dodate" tabindex="1" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6" id="purchasedate">
                                <div class="form-group row">
                                    <label for="purchasedate" class="col-sm-3 col-form-label">Purchase Date</label>
                                    <div class="col-sm-6">
                                        <input type="date" name="purchase_date" class=" form-control" id="purchasedate" tabindex="1" value="<?= $purchase[0]['purchase_date'];?>"  readonly/>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-sm-6" id="paydate">
                                <div class="form-group row">
                                    <label for="purchasedate" class="col-sm-3 col-form-label">Payment Date</label>
                                    <div class="col-sm-6">
                                        <input type="date" name="pay_date" class=" form-control" id="purchasedate" tabindex="1"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6" id="date">
                                <div class="form-group row">
                                    <label for="purchasedate" class="col-sm-3 col-form-label">Date</label>
                                    <div class="col-sm-6">
                                        <input type="date" name="date" class=" form-control" id="purchasedate" tabindex="1"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6" id="paydate">
                                <div class="form-group row">
                                    <label for="purchasedate" class="col-sm-3 col-form-label">Due Date</label>
                                    <div class="col-sm-6">
                                        <input type="date" name="due_date" class=" form-control" id="purchasedate" tabindex="1"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br> 
                        <!-- <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="normalinvoice">
                                <thead>
                                    <tr>
                                    <th class="text-center" width="25%"><?php echo display('item_information') ?> <i class="text-danger">*</i></th>
                                   
                                        <th class="text-center" width="5%"><?php echo display('unit') ?></th>
                                        <th class="text-center" width="10%"><?php echo display('quantity') ?>  <i class="text-danger">*</i></th>
                                        <th class="text-center" width="20%">Keterangan <i class="text-danger">*</i></th>
                                        <th class="text-center" width="20%">Remarks</th>
                                        <th class="text-center" width="10%"><?php echo display('action') ?></th>
                                    </tr>
                                </thead>
                                <tbody id="addinvoiceItem">
                                    
                                    <tr>
                                        <td class="product_field">
                                            <select name="" id="">
                                                <?php foreach($do as $prod):?>
                                                    <option value=""></option>
                                                <?php endforeach;?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="unit[]" class="form-control text-right " readonly="" value="{unit}" />
                                        </td>
                                        <td>
                                            <input type="number" name="product_quantity[]" onclick="quantity_calculate({sl});" onchange="quantity_calculate({sl});" value="0" class="total_qntt_{sl} form-control text-right" id="total_qntt_{sl}" min="0" tabindex="4" required="required"/>

                                            <input type="hidden" name="qty_jual_{sl}" value="{quantity}" id="qty_jual_{sl}">
                                        </td>

                                        <td>
                                            <input type="text" name="desc[]" value="" id="desc_{sl}" class="desc{sl} form-control" required="" placeholder="Masukkan Deskripsi"/>
                                        </td>

                                        <td>
                                            <input type="text" name="remarks[]" value="" id="remarks_{sl}" class="remarks{sl} form-control" placeholder="Masukkan Remarks"/>
                                        </td>
                                        <td>
                                            <button  class="btn btn-danger text-center" type="button" value="<?php echo display('delete') ?>" onclick="deleteRow(this)" tabindex="7"><i class="fa fa-close"></i></button>
                                        </td>
                                    </tr>
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td colspan="6">
                                            <b>DO Details :</b>
                                            <textarea id="ket" name="keterangan" class="form-control" rows="4" placeholder="Masukkan Keterangan"></textarea>
                                        </td>
                                    </tr>
                                </tfoot>
            
                            </table>-->
                            <div class="well well-sm">
                                <a href="<?= base_url('Cpurchase/purchase_do_details/'.$purchase[0]['purchase_id']);?>" class="btn btn-warning">Cancel</a>
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

