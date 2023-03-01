
<!-- Sales Report Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Item Pembelian Report</h1>
            <small>-</small>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url()?>"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('report') ?></a></li>
                <li class="active">Item Pembelian Report</li>
            </ol>
        </div>
    </section>

    <section class="content">


        <div class="row">
            <div class="col-sm-12">




            </div>
        </div>

        <!-- Sales report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body"> 
                        <?php echo form_open('Admin_dashboard/retrieve_dateWise_SalesReports', array('class' => 'form-inline', 'method' => 'get')) ?>
                        <?php
                        $today = date('Y-m-d');
                        ?>
                        <div class="form-group">
                            <label class="" for="from_date"><?php echo display('start_date') ?></label>
                            <input type="text" name="from_date" class="form-control datepicker" id="from_date" placeholder="<?php echo display('start_date') ?>" value="<?php echo $today ?>">
                        </div> 

                        <div class="form-group">
                            <label class="" for="to_date"><?php echo display('end_date') ?></label>
                            <input type="text" name="to_date" class="form-control datepicker" id="to_date" placeholder="<?php echo display('end_date') ?>" value="<?php echo $today ?>">
                        </div>

                   <!--  <div class="form-group">
                        <label class="" for="to_date">Sales</label>

                        <select name="sales" id="sales" class="form-control">
                            <option value="all">Pilih Semua</option>
                            <?php
                            foreach($sales as $sal){
                                echo '<option value="'.$sal->user_id.'">'.$sal->first_name.' '.$sal->last_name.'</option>';
                            }
                            ?>
                        </select>
                    </div> -->

                    <button type="submit" class="btn btn-success"><?php echo display('search') ?></button>
                    <a  class="btn btn-warning" href="#" onclick="printDiv('purchase_div')"><?php echo display('print') ?></a>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="panel-title">
                        <h4>Item Report </h4>
                    </div>
                </div>
                <div class="panel-body">
                    <div id="purchase_div" class="table-responsive">
                       <table class="print-table" width="100%">

                        <tr>
                            <td align="left" class="print-table-tr">
                                <img src="<?php echo $software_info[0]['logo'];?>" alt="logo">
                            </td>
                            <td align="center" class="print-cominfo">
                                <span class="company-txt">
                                    <?php echo $company[0]['company_name'];?>

                                </span><br>
                                <?php echo $company[0]['address'];?>
                                <br>
                                <?php echo $company[0]['email'];?>
                                <br>
                                <?php echo $company[0]['mobile'];?>

                            </td>

                            <td align="right" class="print-table-tr">
                                <date>
                                    <?php echo display('date')?>: <?php
                                    echo date('d-M-Y');
                                    ?> 
                                </date>
                            </td>
                        </tr>            

                    </table>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Vendor</th>
                                    <th>Total</th>
                                    <th>Tanggal</th> 
                                    <!-- <th><?php echo display('total_price') ?> -->

                                    <?php echo form_close() ?></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $subtotal = 0;
                                if ($sales_report) {
                                    ?>
                                    
                                    <?php 
                                    $subtotal = 0;
                                    foreach($sales_report as $sales){ ?>
                                     <tr>
                                        <td><?php echo $sales['product_name'].' - '.$sales['product_details']?></td>
                                        <td><?php echo $sales['supplier_name']?></td>

                                                <td class="text-right">
                                                    <?php 
                                                    if($position == 0){
                                                      echo $currency.' '.number_format($sales['total_price'],2);  
                                                  }else{
                                                    echo number_format($sales['total_price'],2).' '.$currency; 
                                                }
                                                $subtotal += $sales['total_price']; ?>

                                            </td>
                                                <td><?php echo $this->occational->dateConvert($sales['po_date'])?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } else {
                                    ?>

                                    <tr>
                                        <th class="text-center" colspan="6"><?php echo display('not_found'); ?></th>
                                    </tr> 
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right"><b><?php echo display('total_seles') ?></b></td>
                                    <td class="text-right"><b><?php echo (($position == 0) ? "$currency ". number_format($subtotal) : number_format($subtotal) ." $currency") ?></b></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="text-right"><?php echo $links ?></div>
            </div>
        </div>
    </div>
</div>
</section>
</div>
<!-- Sales Report End -->