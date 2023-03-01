<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('manage_product') ?></h1>
            <small><?php echo 'manage your purchase product' ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('product') ?></a></li>
                <li class="active"><?php echo display('manage_product') ?></li>
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
        ?>
        <!-- Manage Product report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('manage_product') ?></h4>


                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="ManagePurchaseList"> 
                                <thead>
                                    <tr>
                                        <th><?php echo 'No' ?></th>
                                        <th><?php echo 'Kode Barang' ?></th>
                                        <th><?php echo 'Nama Barang' ?></th>
                                        <th><?php echo display('product_details') ?></th>
                                        <th><?php echo display('size') ?></th>
                                        <th><?php echo 'Dimensi' ?></th>
                                        <th><?php echo 'bobot'; ?></th>
                                        <th><?php echo display('brand') ?></th>
                                        <th><?php echo display('price') ?></th>
                                        <th><?php echo display('total_purchase') ?></th>
                                        <th><?php echo display('action') ?> 
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                  
                                </tbody>
                            </table>
                          
                        </div>
                    </div>
                </div>
                <!-- <input type="hidden" id="total_product" value="<?php echo $total_product;?>" name=""> -->
            </div>
        </div>
    </section>
</div>
<script src="<?php echo base_url()?>my-assets/js/admin_js/managePurchase.js" type="text/javascript"></script>