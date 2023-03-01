<?php
    $CI =& get_instance();
    $CI->load->model('Web_settings');
    $Web_settings = $CI->Web_settings->retrieve_setting_editdata();

$CI->load->library('lreturn');
$user_type = $this->session->userdata('user_type');
$user_id = $this->session->userdata('user_id');
$arr=array(1=>"I","II","III","IV","V","VI","VII","VIII","IV","X","XI","XII");
$month  =   date('n',strtotime($final_date));
$bln=$arr[$month];


?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('return_details') ?></h1>
            <small><?php echo display('return_details') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('return') ?></a></li>
                <li class="active"><?php echo display('return_details') ?></li>
            </ol>
        </div>
    </section>

    <!-- Main content -->
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
                <div class="panel panel-bd">
	                <div id="printableArea">
	                    <div class="panel-body">
	                        <div class="row">
	                        	<!-- {company_info} -->
	                            <div class="col-sm-12">
	                            	         <div style="text-align: right;padding-top: 10px"> F-CIKA-008-00</div>


	                                 <img src="<?php if (isset($Web_settings[0]['invoice_logo'])) {echo $Web_settings[0]['invoice_logo']; }?>" class="" alt="logo" width="100%">
	                                 <hr style="weight:5px;border-color:blue;" >
	                                    <p style="font-size: 12pt;text-align: center;font-weight: bold;">RETURN</p>

	                                <br>
	                               <!--  <span class="label label-success-outline m-r-15 p-10" ><?php echo display('billing_from') ?></span>
	                                <address class="margin-top10">
	                                    <strong>{company_name}</strong><br>
	                                    {address}<br>
	                                    <abbr><b><?php echo display('mobile') ?>:</b></abbr> {mobile}<br>
	                                    <abbr><b><?php echo display('email') ?>:</b></abbr> 
	                                    {email}<br>
	                                    <abbr><b><?php echo display('website') ?>:</b></abbr> 
	                                    {website}
	                                </address> -->
	                            </div>
	                            <table width="100%" class="table table-borderless" cellpadding="1" style="border-collapse: collapse;">
						      <tbody>
						        <tr>
						          <td colspan="6" style="padding-bottom:20px;border-top: none;">
						            <table border="0" width="100%" cellpadding="1">
						              <tr>
						                <th valign="top">Name</th>
						                <th>:</th>
						                <th><?= $customer_name;?></th>
						                <th>Return No</th>
						                <th>:</th>
						                <th><?=$number;?>/<?= "CIKA"."-RTN";?>/<?=$bln.'/'.date('Y',strtotime($final_date));?></th>
						              </tr>
						              <tr valign="top">
						                <th>Phone</th>
						                <th>:</th>
						                <th><?=$customer_mobile;?></th>
						                <th>Date</th>
						                <th>:</th>
						                <th><?php echo date('F dS, Y',strtotime($final_date));?></th>
						              </tr>

						              <tr valign="top">
						                <th width="10%" rowspan="3">Address</th>
						                <th width="1%" rowspan="3">:</th>
						                <th width="45%" rowspan="3" style="padding-right:75px;"><?php echo $customer_address;?></th>
						               <!--  <th>PO No</th>
						                <th>:</th>
						                <th><?php if ($vinv[0]['po'] !=""){ echo $vinv[0]['po'];}else { echo "PO-".$vinv[0]['quot_no'];}?></th> -->
						              </tr>

						              <tr valign="top">
						               <!--  <th>PO Date</th>
						                <td>:</td>
						                <td><?php if ($vinv[0]['po_date'] !=""){ echo date('F dS, Y',strtotime($vinv[0]['po_date'])); }else{ echo date('F dS, Y',strtotime($vinv[0]['quotdate']));}?></td> -->
						              </tr>
						              
						            </table>
						          </td>
						        </tr>
						    </tbody>
						</table>
	                            <!-- {/company_info} -->
	                           <!--  <div class="col-sm-12 text-left invoice-details-billing">
	                                <h2 class="m-t-0"><?php echo display('return') ?></h2>
	                                <div><?php echo display('return_id') ?>: {invoice_no}</div>
	                                 <div><?php echo display('invoice_id') ?>: {invoice_id}</div>
	                                <div class="m-b-15"><?php echo display('billing_date') ?>: {final_date}</div>

	                                <span class="label label-success-outline m-r-15"><?php echo display('billing_to') ?></span>

	                                  <address class="details-address">  
	                                    <strong>{customer_name} </strong><br>
	                                    <?php if ($customer_address) { ?>
		                                {customer_address}
		                                <?php } ?>
	                                    <br>
	                                    <abbr><b><?php echo display('mobile') ?>:</b></abbr>
	                                    <?php if ($customer_mobile) { ?>
	                                    {customer_mobile}
	                                    <?php }if ($customer_email) {
	                                    ?>
	                                    <br>
	                                    <abbr><b><?php echo display('email') ?>:</b></abbr> 
	                                    {customer_email}
	                                   	<?php } ?>
	                                </address>
	                            </div> -->
	                        </div>
	                         <!-- <hr> -->

	                        <div class="table-responsive m-b-20">
	                            <table class="table table-striped table-bordered">
	                                <thead>
	                                    <tr>
	                                        <th class="text-center">No</th>
	                                        <th class="text-center"><?php echo display('product_name') ?></th>
	                                        <th class="text-center"><?php echo display('quantity') ?></th>
	                                        
	                                        <?php if ($discount_type == 1) { ?>
	                                        <th class="text-center"><?php echo display('discount_percentage') ?> %</th>
	                                        <?php }elseif($discount_type == 2){ ?>
	                                        <th class="text-center"><?php echo display('discount') ?> </th>
	                                        <?php }elseif($discount_type == 3) { ?>
	                                        <th class="text-center"><?php echo display('fixed_dis') ?> </th>
	                                        <?php } ?>

	                                        <th class="text-center"><?php echo display('rate') ?></th>
	                                        <th class="text-center"><?php echo display('ammount') ?></th>
	                                    </tr>
	                                </thead>
	                                <tbody>
	                                	<?php 
	                                	if(!empty($invoice_all_data)){
							      		    $no = 0;
							               
							      		foreach($invoice_all_data as $row):
							      			$no++;
							      			?>
							      			<tr valign="top">
								      			<td align="center"><?php echo $no;?></td>
		                                        <td class="text-left"><?php echo $row['product_name'].' - ('. $row['product_model'].')' ?></td>
								                <td align="center"><?php echo $row['ret_qty'];?></td>

		                                        <?php if ($discount_type == 1) { ?>
		                                        <td align="center"><?php echo $row['deduction'];?></td>
		                                        <?php }else{ ?>
		                                        <td align="right"><?php  echo $row['deduction'];?></td>
		                                        <?php } ?>
		                                        
		                                        <td align="right"><?php echo number_format($row['product_rate']);?></td>
		                                        <td align="right"><?php echo number_format($row['total_ret_amount']);?></td>                 

							                  
							                      
							      			</tr>
							      			<?php
							                
							                  
							      		endforeach;
							      	}
							          ?>
										<!-- {invoice_all_data} -->
										<!-- <tr>
	                                    	<td class="text-center">{sl}</td>
	                                        <td class="text-center"><div><strong>{product_name} - ({product_model})</strong></div></td>
	                                        <td align="center">{ret_qty}</td>

	                                        <?php if ($discount_type == 1) { ?>
	                                        <td align="center">{deduction}</td>
	                                        <?php }else{ ?>
	                                        <td align="right"><?php echo (($position==0)?"{deduction}":"{deduction}") ?></td>
	                                        <?php } ?>
	                                        
	                                        <td align="right"><?php echo (($position==0)?"{product_rate}":"{product_rate}") ?></td>
	                                        <td align="right"><?php echo number_format((float)"{total_ret_amount}") ?></td>
	                                    </tr> -->
	                                    <!-- {/invoice_all_data} -->
	                                </tbody>
	                                <tfoot>
	                                	<td align="center" colspan="2"><b>Total :</b></td>
	                                	<td align="center" ><b>{subTotal_quantity}</b></td>
	                                	<td colspan="2"></td>
	                                	
	                                	<td align="right" ><b><?php echo (($position==0)?"{subTotal_ammount}":"{subTotal_ammount}") ?></b></td>
	                                </tfoot>
	                            </table>
	                        </div>
	                        <div class="row">
		                        
		                        	<div class="col-xs-8 invoicefooter-content">
		                                <p><strong><?php echo display('note') ?> : </strong>{note}</p>
		                                
		                                <div  class="">
											
										</div>
		                            </div>
		                            <div class="col-xs-4 inline-block">

				                        <table class="table">
				                            <?php
			                                	if ($invoice_all_data[0]['total_deduct'] != 0) {
			                                ?>
				                            	<tr>
				                            		<th class="border-bottom-top"><?php echo display('deduction') ?> : </th>
				                            		<td class="border-bottom-top text-right"><?php echo (($position==0)?"{total_deduct}":"{total_deduct}") ?> </td>
				                            	</tr>
				                            <?php } 
				                              	if ($invoice_all_data[0]['total_tax'] != 0) {
			                                ?>
				                            	<tr>
				                            		<th class="border-bottom-top"><?php echo display('tax') ?> : </th>
				                            		<td class="border-bottom-top text-right"><?php echo (($position==0)?"{total_tax}":"{total_tax}") ?> </td>
				                            	</tr>
				                            <?php } ?>
				                            	<tr>
				                            		<th class="grand_total "><?php echo display('grand_total') ?> :</th>
				                            		<td class="grand_total text-right"><?php echo (($position==0)?"{totalnamount}":"{totalnamount}") ?></td>
				                            	</tr>
				                            	
			                            </table>
		                   
		                                <div class="sig_div">
												<?php echo display('authorised_by') ?>
										</div>
		                            
		                        </div>
	                        </div>
	                    </div>
	                </div>

                     <div class="panel-footer text-left">
                     	<a  class="btn btn-danger" href="<?php echo base_url('Cretrun_m');?>"><?php echo display('cancel') ?></a>
						<button  class="btn btn-info" onclick="printDiv('printableArea')"><span class="fa fa-print"></span></button>
						
                    </div>
                </div>
            </div>
        </div>
    </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->



