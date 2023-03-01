<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo 'Add list Do' ?></h1>
            <small><?php echo 'Add List DO' ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo 'DO' ?></a></li>
                <li class="active"><?php echo 'Add DO' ?></li>
            </ol>
        </div>
    </section>

    <section class="content">
        <?//= //print_r($do[0]['purchase_id']);?>
        <a href="<?= base_url('Cpurchase/add_do_purchase/'.$purid);?>" class="btn btn-sm btn-primary" style="margin-bottom:5px;"><i class="fa fa-plus"></i>Add DO</a>
        <div class="table-responsive">
            <table  class="table table-bordered table-striped table-hover">
                <thead>
                    <th>Purchase ID</th>
                    <th>Receivered goods Date</th>
                    <th>No DO</th>
                    <th>DO Date</th>
                    <!-- <th>Invoice No</th> -->
                    <th>Payment Date</th>
                    <th>Due Date</th>
                    <th>Tax Date</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php foreach($do as $data):?>
                    <tr>
                        <td><?= $data['purchase_id'];?></td>
                        <td><?= date('d-m-Y', strtotime($data['date']));?></td>
                        <td><?= $data['do_number'];?></td>
                        <td><?= date('d-m-Y', strtotime($data['do_date']));?></td>
                        <!-- <td><?= $data['invoice_no'];?></td> -->
                        <td><?= date('d-m-Y', strtotime($data['pay_date']));?></td>
                        <td><?= date('d-m-Y', strtotime($data['pay_duedate']));?></td>
                        <td><?= date('d-m-Y', strtotime($data['tax_date']));?></td>
                        <td>
                            <a href="<?= base_url('Cpurchase/edit_do_purchase/'.$data['id_do']);?>" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i></a>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</section>
                </div>