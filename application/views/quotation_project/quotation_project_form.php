
<script src="<?php echo base_url() ?>my-assets/js/admin_js/json/service_quotation.js.php" ></script>
<script src="<?php echo base_url() ?>my-assets/js/admin_js/json/productquotation.js" ></script>
<script src="<?php echo base_url() ?>my-assets/js/admin_js/json/quotation.js" ></script>

<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('quotation_project') ?></h1>
            <small><?php echo display('add_quotation_project') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('quotation_project') ?></a></li>
                <li class="active"><?php echo display('add_quotation_project') ?></li>
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
        $user_type = $this->session->userdata('user_type');
        $user_id = $this->session->userdata('user_id');
        ?>


        <!-- New category -->
        <div class="row">
            <div class="col-sm-12">                
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('add_quotation') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open('Cquotationproject/store', array('class' => 'form-vertical', 'id' => 'insert_quotation')) 
                    
                    ?>
                    <input type="hidden" id="idquot" name="idquot" value="<?=$idquot?>">
                    <div class="panel-body">
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="customer" class="col-sm-4 col-form-label"><?php echo display('customer') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                               
                                    <?php if ($user_type == 3) { ?>
                                        <input type="text" name="cname" value="<?php echo $this->session->userdata('user_name') ?>" class="form-control" readonly>
                                        <input type="hidden" name="customer_id" value="<?php echo $this->session->userdata('user_id') ?>" class="form-control">
                                    <?php } else { ?>
                                        <select name="customer_id" class="form-control" onchange="get_customer_info(this.value)"  data-placeholder="<?php echo display('select_one'); ?>">
                                            <option value=""></option>
                                            <?php
                                            foreach ($customers as $customer) {
                                                ?>
                                                <option value="<?php echo $customer['customer_id'] ?>">
                                                    <?php echo $customer['customer_name'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="quotation_no" class="col-sm-4 col-form-label"><?php echo display('quotation_no') ?> </label>
                                <div class="col-sm-8">
                                    <input type="text" name="quotation_no" id="quotation_no" class="form-control" placeholder="<?php echo display('quotation_no') ?>" value="<?php echo $quotation_no; ?>" readonly>
                                </div>
                            </div>
                        </div>
                       
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="address" class="col-sm-4 col-form-label"><?php echo display('address') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <input type="text" name="address" class="form-control" value="" id="address" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="qdate" class="col-sm-4 col-form-label"><?php echo display('quotation_date') ?> </label>
                                <div class="col-sm-8">
                                    <input type="text" name="qdate" class="form-control datepicker" id="qdate" value="<?php echo date('Y-m-d') ?>">
                                </div>
                            </div>
                        </div>
                       
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="mobile" class="col-sm-4 col-form-label"><?php echo display('phone') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <input type="text" name="mobile" class="form-control" value="" id="mobile" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                 <label for="expiry_date" class="col-sm-4 col-form-label"> Tgl. Kadaluarsa<i class="text-danger"></i></label>
                                 <div class="col-sm-4">
                                    <input type="number" name="quotationexp" id="quotationexp" class="form-control" required>              
                                </div>
                                <div class="col-sm-4">
                                    
                                    <select name="quotationexpsat" class="form-control" data-placeholder="<?php echo display('select_one'); ?>">
                                        <option value="hari">Hari</option>
                                        <option value="minggu">Minggu</option>
                                            
                                    </select>
                                </div>
                            </div>


                        </div>


                        <div class="form-group row">
                           
                            <div class="col-sm-6">
                                 <label for="expiry_date" class="col-sm-4 col-form-label"> Waktu Pengiriman<i class="text-danger"></i></label>
                                 <div class="col-sm-4">
                                    <input type="number" name="deliverytime" id="deliverytime" class="form-control" required>              
                                </div>
                                <div class="col-sm-4">
                                    
                                    <select name="deliverytimesat" class="form-control" data-placeholder="<?php echo display('select_one'); ?>">
                                        <option value="hari">Hari</option>
                                        <option value="minggu">Minggu</option>
                                        <option value="bulan">Bulan</option>    
                                    </select>
                                </div>
                            </div>

                            


                            <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for="date" class="col-sm-4 col-form-label"><?php echo 'Perusahaan';?> <i class="text-danger">*</i></label>
                                        <div class="col-sm-8">
                                            <select name="perusahaan" id="perusahaan" class="form-control">
                                                <option value="">--Pilih--</option>
                                                <option value="CIKA">CIKA</option>
                                                <option value="KIA">KIA</option>
                                            </select>
                                            <small class="text-danger">Digunakan sebagai KOP dan No. Surat</small>
                                        </div>
                                    </div>
                                </div>


                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label for="details" class="col-sm-2 col-form-label"><?php echo display('details') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-10">
                                    <textarea  name="details" class="form-control" id="details"></textarea>
                                </div>
                            </div>
                        </div>

                              <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive margin-top10">
                            
                        </div>


                            </div>
                        </div>
                    
                        <hr>
                        <div>
                          <button type="button" class="btn btn-primary btn-sm" id="tambahproyek">Tambahkan Proyek Baru</button>  
                        </div>

                        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="modalProyek">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Form Tambah Proyek</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Descriptions</label>
                                            <input type="text" name="descitem" class="form-control" id="descitem">
                                        </div>

                                        <div class="form-group">
                                            <label>Parent ID</label><br>
                                                <div id="pilihParentProyek">
                                                    <select name="parentid" class="form-control" id="parentid">
                                                        <option value="0">--Silahkan Pilih--</option>
                                                    
                                                    </select>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id="simpanproyekitem">Simpan Data</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Modal Item -->
                        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="modalItemProyek">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Form Tambah Item</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Detail ID</label>
                                            <td><input type='text' name='detailid' class='form-control' placeholder='Product Name' id='detailid' required></td>
                                        </div>
                                        <div class="form-group">
                                            <label>Product Name</label><br>
                                            <div class="col-md-12">
                                            <select name="product_id" class="form-control" data-placeholder="<?php echo display('select_one'); ?>" id='product_id' style="width:350px;">
                                            <option value=""></option>
                                            <?php
                                            foreach ($products as $product) {
                                                ?>
                                                <option value="<?php echo $product->product_id; ?>" onclick="pilihproduk('<?=$product->product_id;?>','<?=$product->price;?>')">
                                                    <?php echo $product->product_name.' ('.$product->size.')' ?>
                                                </option>
                                            <?php } ?>
                                        </select>

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Quantity</label><br>
                                            <input type='text' name='product_quantity' value='1' required='required' id="product_quantity" class="form-control" onkeyup='quantity_calculate(1);' onchange='quantity_calculate(1);'/>
                                        </div>

                                        

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id="simpanitem">Simpan Data</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end of modal item -->

                        <div id="projectshow"></div>

                         <hr>

                        <div class="row well">
                            
                        <?=anchor('Cquotationproject/list','Batalkan',['class'=>'btn btn-danger btn-lg']);?>&nbsp;
                        <input type="submit" id="add-quotation" class="btn btn-success btn-lg" name="add-quotation" value="<?php echo display('save') ?>" />
                                   
                           
                        </div>
                    </div>               
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </section>
</div>


<script>
    $(document).ready(function(){
        "use strict";
        var base_url = '<?=site_url();?>';
        var idquot = '<?=$idquot;?>';
        $('#projectshow').load(base_url+'Cquotationproject/projectlist/'+idquot);

        $('#tambahproyek').on('click',function(){
            var customer= $('#customer_id').val();
            var marketing = $('#marketing_id').val();
            if(customer == "" || customer == 0){
                alert('Pilih Pelanggan terlebih dahulu');
            } else if(marketing == "" || marketing == 0){
                alert('Pilih Sales/Marketing terlebih dahulu');
            } else{
                $('#modalProyek').modal('show');
                $('#pilihParentProyek').load(base_url+'Cquotationproject/pilihparent/'+idquot);
            }
            
        });
        
        $('#simpanproyekitem').on('click',function(){
            var descitem = $('#descitem').val();
            var parentid = $('#parentid').val();
            var idquot = $('#idquot').val();
            if(descitem == ""){
                alert('Silahkan masukkan nama proyek terlebih dahulu.');
                $('#descitem').focus();
            } else {
                $.ajax({
                    url : base_url + 'cquotationproject/tambahproyek',
                    type : 'post',
                    dataType: 'json',
                    data :'idquot='+idquot+'&descitem='+descitem+'&parentid='+parentid,
                    
                    success : function(result){
                        
                        $('#msgitemsuccess').show(500);
                        $('#projectshow').load(base_url+'Cquotationproject/projectlist/'+idquot);
                        $('#modalProyek').modal('hide');
                        $('#descitem').val('');
                        $('#parentid').val('');
                        
                    }

                });
            }
        });


        $('#simpanitem').on('click',function(){
            var product_id = $('#product_id').val();
            var quantity = $('#product_quantity').val();
            var idquot = $('#idquot').val();
            var detailid = $('#detailid').val();
            var product_name = $('#product_id').val();

            if(product_name == ""){
                alert('Silahkan masukkan nama produk terlebih dahulu.');
                $('#product_id').focus();
            } else {
                $.ajax({
                    url : base_url + 'cquotationproject/tambahitem',
                    type : 'post',
                    data :'detailid='+detailid+'&quantity='+quantity+'&product_id='+product_id,
                    
                    success : function(result){
                        alert('Success');
                        $('#projectshow').load(base_url+'Cquotationproject/projectlist/'+idquot);
                        $('#modalItemProyek').modal('hide');
                        $('#product_id').val('');
                        $('#product_quantity').val('1');
                        
                    }

                });
            }
        });
        
    });

    function pilihproduct(harga){
        $(document).ready(function(){
            $('#product_item_1').val(harga);
            $('#totalprice').val(harga);
        });
    }
</script>


