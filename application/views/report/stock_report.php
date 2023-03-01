
<!-- Stock List Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('stock_report') ?></h1>
            <small><?php echo display('all_stock_report') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('stock') ?></a></li>
                <li class="active"><?php echo display('stock_report') ?></li>
            </ol>
        </div>
    </section>

     <section class="content">
        <!-- Alert Message -->
        <?=form_open('creport/tampilkan_stok');?>
               
        <div class="row">
            <div class="col-sm-5">
                <b>Kategori Produk</b><br>
                <select class="form-control" id="category_id" name="category_id" tabindex="3">
                    <option value="all">Semua Kategori</option>
                    <?php if ($category_list) { ?>
                        {category_list}
                        <option value="{category_id}">{category_name}</option>
                        {/category_list}
                    <?php } ?>
                </select>
                
            </div>
            <div class="col-sm-3">
                <br>
                <button type="submit" class="btn btn-info" name="tampilkan" id="tampilkan">
                    <i class="fa fa-print"></i> Cetak Data
                </button>
            </div>
        </div>
        <?=form_close();?>
        <br>
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
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title text-right">
                           
                        </div>
                    </div>
                    <div class="panel-body">
                        <div>
                           
                            <div class="table-responsive" id="printableArea">
                               <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="checkListStockList">
                                    <thead>
                                        <tr>
                                    <th class="text-center"><?php echo display('sl') ?></th>
                                    <th class="text-center">Kode</th>
                                    <th class="text-center"><?php echo display('product_name') ?></th>
                                    <th class="text-center">Unit</th>
                                    <th class="text-center">Kategori</th>
                                    <th class="text-center"><?php echo display('in_qnty') ?></th>
                                    <th class="text-center"><?php echo display('out_qnty') ?></th>
                                    <th class="text-center"><?php echo display('stock') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <tfoot>
                                            <tr>
               
                <th id="stockqty"></th>
                  <th></th>  <th></th> 
            </tr>
                                            
                                        </tfoot> 
                                
                                </table>
                            </div>
                        </div>
                        <input type="hidden" id="currency" value="{currency}" name="">
                         <input type="hidden" id="total_stock" value="<?php echo $totalnumber;?>" name="">
                    </div>
                </div>
            </div>
        </div>
       
    </section>
</div>


