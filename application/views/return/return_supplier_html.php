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
            <h1><?php echo display('return') ?></h1>
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
						                <th><?= $supplier_name;?></th>
						                <th>Return No</th>
						                <th>:</th>
						                <th><?=$number;?>/<?= "CIKA"."-RTN";?>/<?=$bln.'/'.date('Y',strtotime($final_date));?></th>
						              </tr>
						              <tr valign="top">
						                <th>Phone</th>
						                <th>:</th>
						                <th><?=$mobile;?></th>
						                <th>Date</th>
						                <th>:</th>
						                <th><?php echo date('F dS, Y',strtotime($final_date));?></th>
						              </tr>

						              <tr valign="top">
						                <th width="10%" rowspan="3">Address</th>
						                <th width="1%" rowspan="3">:</th>
						                <th width="45%" rowspan="3" style="padding-right:75px;"><?php echo $address;?></th>
						               <!--  <th>PO No</th>
						                <th>:</th>
						                <th><?php if ($vinv[0]['po'] !=""){ echo $vinv[0]['po'];}else { echo "PO-".$vinv[0]['quot_no'];}?></th> -->
						              </tr>

						              <tr valign="top">
						               <!--  <td>PO Date</td>
						                <td>:</td>
						                <td><?php if ($vinv[0]['po_date'] !=""){ echo date('F dS, Y',strtotime($vinv[0]['po_date'])); }else{ echo date('F dS, Y',strtotime($vinv[0]['quotdate']));}?></td> -->
						              </tr>
						              
						            </table>
						          </td>
						        </tr>
						    </tbody>
						</table>
	                           <!--  {/company_info}
	                            <div class="col-sm-4 text-left invoice-details-billing">
	                                <h2 class="m-t-0"><?php echo display('supplier_return') ?></h2>
	                                <div><?php echo display('return_id') ?>: {invoice_no}</div>
	                                 <div><?php echo display('purchase_id') ?>: {purchase_id}</div>
	                                <div class="m-b-15"><?php echo display('billing_date') ?>: {final_date}</div>

	                                <span class="label label-success-outline m-r-15"><?php echo display('billing_to') ?></span>

	                                  <address class="details-address">  
	                                    <strong>{supplier_name} </strong><br>
	                                    <?php if ($address) { ?>
		                                {address}
		                                <?php } ?>
	                                    <br>
	                                    <abbr><b><?php echo display('mobile') ?>:</b></abbr>
	                                   
	                                </address>
	                            </div> -->
	                        </div> 

	                        <div class="table-responsive m-b-20">
	                            <table class="table table-striped table-bordered">
	                                <thead>
	                                    <tr>
	                                        <th class="text-center">No</th>
	                                        <th class="text-center"><?php echo display('product_name') ?></th>
	                                        <th class="text-center"><?php echo display('quantity') ?></th>
	                                        
	                                        <th class="text-center"><?php echo display('rate') ?></th>
	                                        <th class="text-center"><?php echo display('ammount') ?></th>
	                                    </tr>
	                                </thead>
	                                <tbody>
	                                	<?php 
	                                	if(!empty($return_detail)){
							      		    $no = 0;
							               
							      		foreach($return_detail as $row):
							      			$no++;
							      			?>
							      			<tr valign="top">
								      			<td valign="center"><?php echo $no;?></td>
		                                        <td class="text-left"><?php echo $row['product_name'] ?></td>
								                <td align="center"><?php echo $row['ret_qty'];?></td>

		                                        
		                                        <td align="right"><?php echo number_format($row['price']);?></td>
		                                        <td align="right"><?php echo number_format($row['total_ret_amount']);?></td>                 

							                  
							                      
							      			</tr>
							      			<?php
							                
							                  
							      		endforeach;
							      	}
							          ?>
										<!-- {return_detail}
										<tr>
	                                    	<td class="text-center">{sl}</td>
	                                        <td class="text-center"><div><strong>{product_name}</strong></div></td>
	                                        <td align="center">{ret_qty}</td>
	                                        <td align="center"><?php echo (($position==0)?" {price}":"{price} ") ?></td>
	                                        <td align="center"><?php echo (($position==0)?" {total_ret_amount}":"{total_ret_amount} ") ?></td>
	                                    </tr>
	                                    {/return_detail} -->
	                                </tbody>
	                                <tfoot>
	                                	<td align="center" colspan="2"><b><?php echo display('total')?>:</b></td>
	                                	<td align="center" ><b>{subTotal_quantity}</b></td>
	                                	<td></td>
	                                	<td align="right" ><b><?php echo (($position==0)?" {subTotal_ammount}":"{subTotal_ammount} ") ?></b></td>
	                                </tfoot>
	                            </table>
	                        </div>
	                        <div class="row">
		                        
		                        	<div class="col-xs-8 invoicefooter-content">
		                                <p><strong><?php echo display('note') ?> : </strong>{note}</p>
		                               
		                                <div>
												
										</div>
		                            </div>
		                            <div class="col-xs-4 inline-block">

				                        <table class="table">
				                     
				                            	
				                            	<tr>
				                            		<th class="grand_total"><?php echo display('grand_total') ?> :</th>
				                            		<td class="grand_total text-right"><?php echo (($position==0)?" {subTotal_ammount}":"{subTotal_ammount} ") ?></td>
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



