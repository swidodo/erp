<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo "INVOICE"; ?></h1>
            <small><?php echo 'New Invoice'; ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo 'Invoice'; ?></a></li>
                <li class="active"><?php echo 'New Invoice';?></li>
            </ol>
        </div>
    </section>
    <!-- New category -->
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo 'New Invoice' ?> </h4>
                        </div>
                    </div>
                    <div class="panel-body">
                    <form action="" class="form-vertical mt-3">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="col-md-4">Quotation No</div>
                                <div class="col-md-8"><input type="text" id="quotID" class="form-control" name="quotId" value="<?= $quotation[0]['quot_no'];?>" readonly></div>
                                <input type="hidden" id="baseurl" value="<?= base_url();?>">
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-4">Invoice No</div>
                                <div class="col-md-8"><input type="text" class="form-control" name="invoiceNo" value="<?= $no_inv;?>" readonly></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="col-md-4">Customer Name</div>
                                <div class="col-md-8"><input type="text" class="form-control" name="customerName" value="<?= $quotation[0]['customer_name'];?>" readonly></div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-4">Date<i class="text-danger">*</i></div>
                                <div class="col-md-8"><input type="text" class="form-control" name="date" value="<?= $quotation[0]['datenow'];?>" required></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="col-md-4">Address</div>
                                <div class="col-md-8"><input type="text" class="form-control" name="address" value="<?= $quotation[0]['customer_address'];?>" readonly></div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-4">Due Date<i class="text-danger">*</i></div>
                                <div class="col-md-8"><input type="date" class="form-control" name="duedate" required></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="col-md-4">Mobile</div>
                                <div class="col-md-8"><input type="text" class="form-control" name="mobile" value="<?= $quotation[0]['customer_mobile'];?>" readonly></div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-4">
                                    <?php echo display('payment_type');?><i class="text-danger" >*</i>
                                </div>
                                <div class="col-sm-8">
                                    <select name="paytype" class="form-select form-control" id="payID" tabindex="3"  required>
                                        <option value="1"><?php echo display('cash_payment')?></option>
                                        <option value="2"><?php echo display('bank_payment')?></option> 
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6" id="bank">
                                <div class="col-md-4">
                                    <?php echo 'Bank';?> <i class="text-danger">*</i>
                                </div>
                                <div class="col-sm-8">
                                    <select name="bank_id" class="form-control">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="col-md-12">Detail</div>
                                <div class="col-md-12">
                                    <textarea name="" class="form-control" placeholder="<?php echo 'Detail Invoice'; ?>" tabindex="12"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                    <table class="table table-bordered">
                        <thead style="background-color:#eeeeee;">
                            <th>Item Product</th>
                            <th>Unit</th>
                            <th>Qty</th>
                            <th>Rate</th>
                            <th>Discount</th>
                            <th>Amount</th>
                        </thead>
                        <tbody>
                            <?php  $i=1; foreach ($product as $list):?>
                            <tr>
                                <td><?= $list['product_name'];?></td>
                                <td><?= $list['unit'];?></td>
                                <td class="text-right"><?= $list['used_qty'];?></td>
                                <td class="text-right"><?= number_format($list['rate'],2);?></td>
                                <td><?= $list['discount_per'];?></td>
                                <td class="text-right"><?= number_format($list['total_price'],2);?></td>
                            </tr>
                            <?php $i++; endforeach;?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-right"><strong>Sub Total</strong></td>
                                <td class="text-right"><?= number_format($quotation[0]['item_total_amount'],2);?></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-right"><strong>Tax</strong></td>
                                <td class="text-right"><?= number_format($quotation[0]['item_total_tax'],2);?></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-right"><strong>Grand Total</strong></td>
                                <td class="text-right"><?= number_format($quotation[0]['item_total_amount']+ $quotation[0]['item_total_tax'],2);?></td>
                            </tr>
                        </tfoot>
                    </table>
                    <?php if ($service!=null):?>
                    <table class="table table-bordered">
                        <thead style="background-color:#eeeeee;">
                            <th>Service Name</th>
                            <th>Qty</th>
                            <th>Rate</th>
                            <th>Discount</th>
                            <th>Amount</th>
                        </thead>
                        <tbody>
                            <?php $i=1; foreach ($service as $serv):?>
                            <tr>
                                <td><?= $serv['service_name'];?></td>
                                <td class="text-right"><?= $serv['qty'];?></td>
                                <td class="text-right"><?= number_format($serv['charge'],2);?></td>
                                <td><?= $serv['discount'];?></td>
                                <td class="text-right"><?= number_format($serv['total'],2);?></td>
                            </tr>
                            <?php $i++; endforeach;?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-right"><strong>Grand Total</strong></td>
                                <td class="text-right"><?= number_format($quotation[0]['service_total_amount'],2);?></td>
                            </tr>
                        </tfoot>
                    </table>
                    <?php endif;?>
                    <table class="table table-bordered">
                        <tr class="text-right">
                            <td>Net Amount</td>
                            <td><?= number_format($quotation[0]['item_total_amount']+ $quotation[0]['item_total_tax']+$quotation[0]['service_total_amount'],2);?></td>
                        </tr>
                        <tr class="text-right">
                        <tr>
                            <td class="text-right">Value Invoice</td>
                            <td class="text-right"><input type="text" name="val_inv" class="text-right" value="<?= number_format($quotation[0]['item_total_amount']+ $quotation[0]['item_total_tax']+$quotation[0]['service_total_amount']);?>"></td>                   
                        </tr>
                    </table>
                    <div class="text-center">
                        <form action="">
                            <input type="hidden" name="quotation_id" value="<?= $quotation[0]['quotation_id'];?>">
                            <input type="hidden" name="customer_id" value="<?= $quotation[0]['customer_id'];?>">
                            <input type="hidden" name="bank_id" value="">

                        </form>
                        <a href="<?= base_url('Cinvoice_quot/manage_invoice_list');?>" class="btn btn-warning shadow-sm">Back</a>
                        <a href="" class="btn btn-primary shadow-lg">New Invoice</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
<script>
$(document).ready(function(){
    $('#bank').hide();
    $('#payID').on('change', function(){
        var pay = $('#payID').val();
        if (pay =='2')
        {
            $('#bank').show();
        } 
        else if(pay==1)
        {
            $('#bank').hide();
        }
    })
    $('#bank_id').on('click','change', function(){    
        $.ajax({
            type : 'post',
            url  : '<?= base_url('Cinvoice_quot/getListBank/');?>',
            data : {id:pay,csrf_test_name:csrf_test_name},
            async: true,
            dataType :'json',
            success: function(e){
                console.log(e);
            }
        })
    })
})
</script>