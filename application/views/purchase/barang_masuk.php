
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1>Surat Bukti Masuk Barang</h1>
	        <small>Kelola data surat bukti masuk barang</small>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('purchase') ?></a></li>
	            <li class="active">Kelola Surat Masuk Barang</li>
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

	        <div class="panel panel-default">
	            <div class="panel-body"> 
	            	<div class="row">
		            	<div class="col-sm-7">
		             		<?php echo form_open('','class="form-inline"')?>
		                    <div class="form-group">
		                        <label class="" for="from_date"><?php echo display('from') ?></label>
		                        <input type="text" name="from_date" class="form-control datepicker" id="from_date" value="" placeholder="<?php echo display('start_date') ?>" >
		                    </div> 

		                    <div class="form-group">
		                        <label class="" for="to_date"><?php echo display('to') ?></label>
		                        <input type="text" name="to_date" class="form-control datepicker" id="to_date" placeholder="<?php echo display('end_date') ?>" value="">
		                    </div>  

		                    <button type="button" id="btn-filter" class="btn btn-success"><?php echo display('find') ?></button>
		             <?php echo form_close()?>
		            </div>
		           
		        </div>
		    </div>
		</div>

		<!-- Manage Purchase report -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="BarangmasukList"> 
								<thead>
									<tr>
										<th><?php echo display('sl') ?></th>
										<th>PO No.</th>
										<th>Tanggal</th>
										<th>Vendor</th>
										<th>Keterangan</th>
										<th><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
						
								</tbody>
		                    </table>
		                </div>
		            </div>
		        </div>
		    </div>
		      <input type="hidden" id="currency" value="{currency}" name="">
		</div>
	</section>
</div>
<!-- Manage Purchase End -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/barang_masuk.js" type="text/javascript"></script>