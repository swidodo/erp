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
                    <?php echo form_open('Cpurchase/update_insert_purchase/'.$do[0]['id_do'], array('class' => 'form-vertical', 'id' => 'do_purchase')) ?>
                    <div class="panel-body">
                    <div class="row">

                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="supplier_name" class="col-sm-3 col-form-label"><?php
                                    echo 'Supplier Name';
                                    ?></label>
                                <div class="col-sm-6">
                                    <input type="text" size="100"  name="suppliername" class=" form-control" id="supplier_name" tabindex="1" value='<?= $do[0]['supplier_name'];?>' readonly/>
                                </div>
                                
                            </div>
                        </div>

                        
                        <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="doid" class="col-sm-3 col-form-label">DO ID</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="do_id" class=" form-control" value="<?= $do[0]['do_number'];?>" id="doid">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6" id="purchase_id">
                                <div class="form-group row">
                                    <label for="purchase_id" class="col-sm-3 col-form-label">Purchase ID </label>
                                    <div class="col-sm-6">
                                        <input type="text" name="purchase_id" class=" form-control"  id="purchase_id" tabindex="1" value='<?= $do[0]['purchase_id'];?>' readonly/>
                                    </div>
                                    
                                </div>
                            </div>
                             <div class="col-sm-6" id="dodate">
                                <div class="form-group row">
                                    <label for="dodate" class="col-sm-3 col-form-label">DO Date
                                        </label>
                                    <div class="col-sm-6">
                                    <input type="date" name="dodate" class=" form-control" value="<?= $do[0]['do_date'];?>"  id="dodate" tabindex="1" />
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                             <div class="col-sm-6" id="purchasedate">
                                <div class="form-group row">
                                    <label for="purchasedate" class="col-sm-3 col-form-label">Purchase Date</label>
                                    <div class="col-sm-6">
                                        <input type="date" name="purchase_date" class=" form-control" id="purchasedate" tabindex="1" value="<?= $do[0]['purchase_date'];?>"  readonly/>
                                    </div>
                                </div>
                            </div>
                           <div class="col-sm-6" id="paydate">
                                <div class="form-group row">
                                    <label for="purchasedate" class="col-sm-3 col-form-label">Payment Date</label>
                                    <div class="col-sm-6">
                                        <input type="date" name="pay_date" class=" form-control" value="<?= $do[0]['pay_date'];?>" id="purchasedate" tabindex="1"/>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <div class="row">
                            <?php $tgl=date('Y-m-d',strtotime($do[0]['date']));?>
                            <div class="col-sm-6" id="date">
                                <div class="form-group row">
                                    <label for="date" class="col-sm-3 col-form-label">Date</label>
                                    <div class="col-sm-6">
                                        <input type="date" name="date" class="form-control" value="<?= $tgl;?>" id="date" tabindex="1"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6" id="paydate">
                                <div class="form-group row">
                                    <label for="purchasedate" class="col-sm-3 col-form-label">Due Date</label>
                                    <div class="col-sm-6">
                                        <input type="date" name="due_date" class=" form-control" value="<?= $do[0]['pay_duedate'];?>" id="purchasedate" tabindex="1"/>
                                    </div>
                                </div>
                            </div>
                        </div>                      
                        <br>
                        <div class="well well-sm">
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

