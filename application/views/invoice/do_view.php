
<!-- Manage Invoice Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('manage_do') ?></h1>
            <small><?php echo display('manage_your_do') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('invoice') ?></a></li>
                <li class="active"><?php echo display('manage_do') ?></li>
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

        <div class="row">
            <div class="col-sm-12">
               
    <!-- <?php if($this->permission1->method('new_invoice','create')->access()){ ?>
                    <a href="<?php echo base_url('Cinvoice') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('new_invoice') ?> </a>
                <?php }?>
              <?php if($this->permission1->method('pos_invoice','create')->access()){ ?>
                    <a href="<?php echo base_url('Cinvoice/pos_invoice') ?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('pos_invoice') ?> </a>
                <?php }?> -->

                <a href="<?php echo base_url('Cinvoice/manage_invoice') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-list"> </i> Data Penjualan </a>

                
            </div>
        </div>

        <!-- date between search -->
        <div class="row">
             <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body"> 
                        <div class="col-sm-10">
                        <?php echo form_open('', array('class' => 'form-inline', 'method' => 'get')) ?>
                        <?php
                      
                        $today = date('Y-m-d');
                        ?>
                        <div class="form-group">
                            <label class="" for="from_date"><?php echo display('start_date') ?></label>
                            <input type="text" name="from_date" class="form-control datepicker" id="from_date" value="" placeholder="<?php echo display('start_date') ?>" >
                        </div> 

                        <div class="form-group">
                            <label class="" for="to_date"><?php echo display('end_date') ?></label>
                            <input type="text" name="to_date" class="form-control datepicker" id="to_date" placeholder="<?php echo display('end_date') ?>" value="">
                        </div>  

                        <button type="button" id="btn-filter" class="btn btn-success"><?php echo display('find') ?></button>

                        <?php echo form_close() ?>
                    </div>
                  
          
                </div>
            </div>
            </div>
        </div>
        <div class="row"> 
        </div>
        <!-- Manage Invoice report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive" >
                            <table class="table table-hover table-bordered" cellspacing="0" width="100%" id="DoList"> 
                                <thead>
                                    <tr>
                                    <th><?php echo display('sl') ?></th>
                                    <th>Customer Name</th>
                                    <th>DO No.</th>
                                    <th>DO Date</th>
                                    <th>PO No.</th>
                                    <th>PO Date</th>
                                    <th>Invoice No.</th>
                                    <th class="text-center"><?php echo display('action') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
             
                                </tbody>
                                
                            </table>
                            
                        </div>
                       

                    </div>
                </div>
               
            </div>
        </div>
    </section>
</div>
<!-- Manage Invoice End -->
