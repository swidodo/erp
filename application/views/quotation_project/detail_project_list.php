<table class="table table-bordered" style="font-size:8pt;">
    <thead>
        <tr>
            <th width="5%">#</th>
            <th width="5%">No</th>
            <th width="35%">Part Descriptions</th>
            <th width="15%">Brand</th>
            <th width="10%">Quantity</th>
            <th width="5%">Unit</th>
            <th width="15%">Unit Price IDR</th>
            <th width="15%">Total Price IDR</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if(!empty($query)){
            $no = 0;
            foreach($query as $row){
                $no++;
                ?>
                <tr>
                    <td><button class="btn btn-xs btn-danger" type="button" onclick="hapusitem('<?=$row->quot_project_detail_id;?>','<?=$row->quotation_id;?>')"><i class="fa fa-trash"></i></button></td>
                    <td><b><?=romawi($no);?></b></td>
                    <td><b><?=$row->quot_detail_title;?></b>&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-xs btn-warning" type="button" onclick="tambahitem('<?=$row->quot_project_detail_id;?>','<?=$row->quotation_id;?>')"><i class="fa fa-plus"></i> Tambahkan Item</button></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <?php
                $items = $this->db
                ->select(['product_information.product_name','product_information.size','product_information.merek','product_information.price as harga','product_information.unit','quotation_project_item.*'])
                ->join('product_information','product_information.product_id = quotation_project_item.product_id')
                
                ->get_where('quotation_project_item',['quot_project_detail_id'=>$row->quot_project_detail_id])
                ->result();

                if(!empty($items)){
                    $noitem = 0;
                    foreach($items as $item){
                        $noitem++;
                        $totalprice = $item->harga * $item->qty;
                        ?>
                        <tr>
                            <td><button class="btn btn-xs btn-danger" type="button" onclick="hapusitemproyek('<?=$item->quot_item_id;?>','<?=$row->quotation_id;?>')"><i class="fa fa-trash"></i></button></td>
                            <td>&nbsp;&nbsp;<?=$noitem;?></td>
                            <td>&nbsp;&nbsp;<?=$item->product_name;?></td>
                            <td><?=$item->merek;?></td>
                            <td><?=$item->qty;?></td>
                            <td><?=$item->unit;?></td>
                            <td><?=number_format($item->harga);?></td>
                            <td><?=number_format($totalprice);?></td>
                        </tr>
                        <?php
                    }
                }

                $subquery = $this->db->order_by('created_at','ASC')->get_where('quotation_project_detail',['parent_id'=>$row->quot_project_detail_id])->result();

                if(!empty($subquery)){
                    $nosub = 0;
                    foreach($subquery as $rsub){
                        $nosub++;
                        ?>
                        <tr>
                            <td><button class="btn btn-xs btn-danger" type="button" onclick="hapusitem('<?=$rsub->quot_project_detail_id;?>','<?=$rsub->quotation_id;?>')"><i class="fa fa-trash"></i></button></td>
                            <td><?=$nosub;?></td>
                            <td><?=$rsub->quot_detail_title;?>&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-xs btn-warning" type="button" onclick="tambahitem('<?=$rsub->quot_project_detail_id;?>','<?=$rsub->quotation_id;?>')"><i class="fa fa-plus"></i> Tambahkan Item</button></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <?php
                        $subitems = $this->db
                        ->select(['product_information.product_name','product_information.size','product_information.merek','product_information.price as harga','product_information.unit','quotation_project_item.*'])
                        ->join('product_information','product_information.product_id = quotation_project_item.product_id')
                        
                        ->get_where('quotation_project_item',['quot_project_detail_id'=>$rsub->quot_project_detail_id])
                        ->result();
        
                        if(!empty($subitems)){
                            $nosubitems = 0;
                            foreach($subitems as $subitem){
                                $nosubitems++;
                                $totalpricesub = $subitem->harga * $subitem->qty;
                                ?>
                                <tr>
                                    <td><button class="btn btn-xs btn-danger" type="button" onclick="hapusitemproyek('<?=$subitem->quot_item_id;?>','<?=$rsub->quotation_id;?>')"><i class="fa fa-trash"></i></button></td>
                                    <td>&nbsp;&nbsp;<?=$nosubitems;?></td>
                                    <td>&nbsp;&nbsp;<?=$subitem->product_name;?></td>
                                    <td><?=$subitem->merek;?></td>
                                    <td><?=$subitem->qty;?></td>
                                    <td><?=$subitem->unit;?></td>
                                    <td><?=number_format($subitem->harga);?></td>
                                    <td><?=number_format($totalpricesub);?></td>
                                </tr>
                                <?php
                            }
                        }
                    }
                }
            }
        }else {
            echo '<tr><th colspan="7">Data belum ada.</th></tr>';
        }
        ?>
    </tbody>
</table>

<script>
    "use strict";
    var base_url = '<?=site_url();?>';
    function hapusitem(idproject, idquot){
        $(function(){
            
            var tanya = confirm('Apakah yakin akan menghapus data ini?');
            if(tanya){
                $.ajax({
                    url : base_url+'Cquotationproject/projectdestroy/'+idproject,
                    success : function(){
                        $('#projectshow').load(base_url+'Cquotationproject/projectlist/'+idquot);
                    }
                });
            }

            
        });
    }


    function hapusitemproyek(idproject, idquot){
        $(function(){
            
            var tanya = confirm('Apakah yakin akan menghapus data ini?');
            if(tanya){
                $.ajax({
                    url : base_url+'Cquotationproject/itemdestroy/'+idproject,
                    success : function(){
                        $('#projectshow').load(base_url+'Cquotationproject/projectlist/'+idquot);
                    }
                });
            }

            
        });
    }

    function tambahitem(idproject, idquot){
        $(function(){
            $('#modalItemProyek').modal('show');
            $('#detailid').val(idproject);
        });
    }

</script>