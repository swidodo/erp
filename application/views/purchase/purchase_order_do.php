<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo 'list Detail PO' ?></h1>
            <small><?php echo 'List Detail PO' ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo 'PO' ?></a></li>
                <li class="active"><?php echo 'Detail PO' ?></li>
            </ol>
        </div>
    </section>

    <section class="content">
        <?//= //print_r($do[0]['purchase_id']);?>
        <a href="<?= base_url('Cpurchase/add_do_po/'.$purid);?>" class="btn btn-sm btn-primary" style="margin-bottom:5px;"><i class="fa fa-plus"></i>Add Detail PO</a>
        <div class="table-responsive">
            <table  class="table table-bordered table-striped table-hover">
                <thead>
                    <th>Purchase ID</th>
                    <th>Receivered goods Date</th>
                    <th>No DO</th>
                    <th>DO Date</th>
                     <th>Invoice No</th>
                     <th>Invoice Date</th>
                    <th>Payment Date</th>
                    <th>Payment</th>
                    <th>Due Date</th>
                    <th>Tax Date</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php foreach($do as $data):?>
                    <tr>
                        <td><?= $data['purchase_order'];?></td>
                        <td><?php if($data['date'] == '0000-00-00'): echo '00-00-0000';else: echo date('d-m-Y',strtotime($data['date']));endif;?></td>
                        <td><?= $data['do_number'];?></td>
                        <td><?php if($data['do_date'] == '0000-00-00'): echo '00-00-0000';else: echo  date('d-m-Y',strtotime($data['do_date']));endif;?></td>
                         <td><?= $data['invoice_no'];?></td>
                         <td><?php if($data['invoice_date']=='0000-00-00'): echo '00-00-0000'; else : echo date('d-m-Y',strtotime($data['invoice_date']));endif;?></td>
                        <td><?php if($data['pay_date'] == '0000-00-00'): echo '00-00-0000';else: echo date('d-m-Y',strtotime($data['pay_date']));endif;?></td>
                         <td><?= $data['payment'];?></td>
                        <td><?php if($data['pay_duedate'] == '0000-00-00'): echo '00-00-0000';else: echo date('d-m-Y',strtotime($data['pay_duedate']));endif;?></td>
                        <td><?php if($data['tax_date'] == '0000-00-00'): echo '00-00-0000';else: echo date('d-m-Y', strtotime($data['tax_date']));endif;?></td>
                        <td>
                            <a href="<?= base_url('Cpurchase/edit_purchase_order_do/'.$data['id_do']);?>" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i></a>
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