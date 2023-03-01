<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo "INVOICE"; ?></h1>
            <small><?php echo 'List Invoice From Quotation'; ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo 'Invoice'; ?></a></li>
                <li class="active"><?php echo 'List Invoice From Quotation';?></li>
            </ol>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo 'List Invoice From Quotation' ?> </h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php if ($listInv !=null):?>
                        <form action="" class="form-vertical mt-3">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="col-md-4">Perusahaan</div>
                                    <div class="col-md-8"><input type="text" class="form-control" value="<?= $listInv[0]['perusahaan'];?>" readonly></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-4">Quotation No<i class="text-danger">*</i></div>
                                    <div class="col-md-8"><input type="text" class="form-control" value="<?= $listInv[0]['quot_no'];?>" readonly></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="col-md-4">Customer Name</div>
                                    <div class="col-md-8"><input type="text" class="form-control" value="<?= $listInv[0]['customer_name'];?>" readonly></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-4">Quotation Date<i class="text-danger">*</i></div>
                                    <div class="col-md-8"><input type="date" class="form-control" value="<?= $listInv[0]['quotdate'];?>" readonly></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="col-md-4">Address</div>
                                    <div class="col-md-8"><input type="text" class="form-control" value="<?= $listInv[0]['customer_address'];?>" readonly></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-4">Type</div>
                                    <div class="col-md-8"><input type="text" class="form-control" value="<?= $listInv[0]['type'];?>" readonly></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="col-md-4">Mobile</div>
                                    <div class="col-md-8"><input type="text" class="form-control" value="<?= $listInv[0]['customer_mobile'];?>" readonly></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-4">TOP</div>
                                    <div class="col-md-8"><input type="text" class="form-control" value="<?= $listInv[0]['top'];?>" readonly></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="col-md-12">Detail</div>
                                    <div class="col-md-12">
                                        <textarea class="form-control" placeholder="<?php echo 'Detail Invoice'; ?>" tabindex="12" readonly><?= $listInv[0]['quot_description'];?></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <hr />
                        LIST INVOICE
                        <hr />
                        <div class="table-responsive" id="rsults">
                            <table id="example" class="table table-bordered table-striped table-hover">
                            <thead>
                                <th class="text-center">No</th>
                                <th class="text-center">Invoice No</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Due Date</th>
                                <th class="text-center">Amount</th>
                                <th class="text-center">view</th>
                            </thead>
                            <tbody>
                                <?php $i=1; foreach($listInv as $inv):?>
                                <tr>
                                    <td class="text-center"><?= $i;?></td>
                                    <td class="text-center"><?= $inv['invoice'];?></td>
                                    <td class="text-center"><?= date('d-m-Y',strtotime($inv['date']));?></td>
                                    <td class="text-center"><?= $inv['duedate'];?></td>
                                    <td class="text-right"><?= number_format(round($inv['total_amount']),2);?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('Cinvoice_quot/detailInvoice/'.$inv['invoice']);?>" target="__blank" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                         <!-- <a href="<?= base_url('Cinvoice_quot/editIvoice/'.$inv['invoice']);?>" target="__blank" class="btn btn-success"><i class="fa fa-pencil"></i></a> -->
                                    </td>
                                </tr>
                                <?php $i++; endforeach;?>
                            </tbody>
                        </table>
                        <?php else :?>
                            <div id="alertsukses">
                                <div class="alert alert-success d-flex align-items-center" role="alert">
                                    <div>
                                      <i class="fa fa-edit"></i>  Invoice Belum Di buat !
                                    </div>
                                </div>
                            </div>
                            <a href="<?= base_url('Cinvoice_quot/manage_invoice_list');?>" class="btn btn-warning">Back</a>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>