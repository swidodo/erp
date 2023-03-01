<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo 'INVOICE' ?></h1>
            <small><?php echo 'invoice Quotation' ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo 'Invoice Quotation';?></a></li>
                <li class="active"><?php echo 'Manage Invoice Quotation'; ?></li>
            </ol>
        </div>
    </section>
    <section class="content">
        <!-- <div class="container"> -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4><?php echo 'Manage Invoice Quotation'; ?> </h4>
                            </div>
                        </div>
                        <?php $error_message = $this->session->userdata('inv');
                            if (isset($error_message)):?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?php 
                            echo $error_message; 
                            ?>                    
                        </div>
                        <?php  $this->session->unset_userdata('inv');?>
                        <?php endif;?>
                        <div class="panel-body">
                            <div class="table-responsive" id="rsults">
                                <table id="example" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <!-- <th>No</th> -->
                                        <th>Quotation Date</th>
                                        <!-- <th>Quotation DueDate</th> -->
                                        <th>Quotation No</th>
                                        <th>Costumer Name</th>
                                        <th>Paid Amount</th>
                                        <th>Paid Invoice</th>
                                        <th>Invoice Remainder</th>
                                        <th width="9%">Action</th>
                                    </thead>
                                    <tbody>
                                        <?php $i=1; foreach($quot as $inv):
                                              $arr=array(1=>"I","II","III","IV","V","VI","VII","VIII","IV","X","XI","XII");
                                              $month  =   date('n',strtotime($inv['quotdate']));
                                              $bln=$arr[$month];
                                        ?>
                                        <tr>
                                            <!-- <td><?//= $i;?></td> -->
                                            <td class="text-center"><?= $inv['quotdate'];?></td>
                                            <!-- <td class="text-center"><?= $inv['expire_date'];?></td> -->
                                            <td><?= $inv['quot_no'].".".substr($inv['first_name'],0,2)."/".$inv['perusahaan']."-QTT/".$bln."/".date('Y',strtotime($inv['quotdate']));?></td>
                                            <td><?= $inv['customer_name'];?></td>
                                            <td class="text-right"><?= number_format(round($inv['item_total_amount']),2);?></td>
                                            <td class="text-right"><?= number_format(round($inv['Tot'][0]['total_amount']),2);?></td>
                                            <td class="text-right"><?= number_format(round($inv['item_total_amount']-$inv['Tot'][0]['total_amount']),2);?></td>
                                            <td class="text-center">
                                                <a href="<?= base_url('Cinvoice_quot/add_invoice/'.$inv['quotation_id']);?>" class="btn btn-sm btn-success"><i class="fa fa-plus"></i></a>
                                                <a href="<?= base_url('Cinvoice_quot/view_invoice_Quotation/'.$inv['quotation_id']);?>" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
                                            </td>
                                        </tr>
                                        <?php $i++; endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- </div> -->
    </section>
</div>
<script>
    $(document).ready(function() {
        $('#example').DataTable( {
            "order": [[ 1,2, "desc" ]]
        } );
    } );
</script>