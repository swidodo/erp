<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo "Revisi"; ?></h1>
            <small><?php echo "List Revisi"; ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo "Revisi"; ?></a></li>
                <li class="active"><?php echo "List Revisi"; ?></li>
            </ol>
        </div>
    </section>
    <section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="panel-title">
                        <h4><?php echo "Historical Revisi" ?> </h4>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">   
                        <table id="example" class="table table-bordered table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Customer Name</th>
                                    <th>Quotation No</th>
                                    <th>Quotation Date</th>
                                    <th>Marketing</th>
                                    <th>Item Total</th>
                                    <th>Revisi</th>
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $i=1; 
                                    foreach ($quot as $dtl):
                                    $arr=array(1=>"I","II","III","IV","V","VI","VII","VIII","IV","X","XI","XII");
                                    $month  =   date('n',strtotime($dtl['quotdate']));
                                    $bln=$arr[$month];
                                ?>
                                <tr>
                                    <td><?= $i;?></td>
                                    <td><?= $dtl['customer_name'];?></td>
                                    <td><?= $dtl['quot_no'].".".substr($dtl['name'],0,2)."/".$dtl['perusahaan']."/".$bln."/".date('Y', strtotime($dtl['quotdate']));?></td>
                                    <td><?= $dtl['quotdate'];?></td>
                                    <td><?= $dtl['name'];?></td>
                                    <td class="text-right"><?= number_format($dtl['item_total_amount']);?></td>
                                    <td class="text-right"><?= $dtl['count'][0]['count'];?></td>
                                    <td class="text-center">
                                        <a href="<?php echo base_url().'Cquotation/view_revisi/' . $dtl['quotation_id']; ?>" class="btn btn-primary btn-sm">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
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
</section>
</div>
<script>
    $(document).ready(function() {
        $('#example').DataTable( {
            "order": [[ 3, "desc" ]]
        } );
    } );
</script>