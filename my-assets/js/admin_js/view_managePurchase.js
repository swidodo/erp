$(document).ready(function() { 
    "use strict";
    var csrf_test_name = $('[name="csrf_test_name"]').val();
    var total_purchase_no = $("#total_purchase_no").val();
    var base_url = $("#base_url").val();
    var currency = $("#currency").val();
    var prod_id = $("#product_id").val();
    // console.log(prod_id);
    var purchasedatatable = $('#view_ManagePurchaseList').DataTable({ 
       responsive: true,
       "aaSorting": [[4, "desc" ]],
       "columnDefs": [
          { "bSortable": false, "aTargets": [0,1,2,3,5,6] },

      ],
     'processing': true,
     'serverSide': true,

    
     'lengthMenu':[[10, 25, 50,100,250,500, total_purchase_no], [10, 25, 50,100,250,500, "All"]],

       dom:"'<'col-sm-4'l><'col-sm-4 text-center'><'col-sm-4'>Bfrtip", buttons:[ {
          extend: "copy",exportOptions: {
                 columns: [ 0,1,2,3,4,5 ] //Your Colume value those you want
                     }, className: "btn-sm prints"
      }
      , {
          extend: "csv", title: "PURCHASE LIST",exportOptions: {
                 columns: [ 0,1,2,3,4,5] //Your Colume value those you want print
                     }, className: "btn-sm prints"
      }
      , {
          extend: "excel",exportOptions: {
                 columns: [0,1,2,3,4,5 ] //Your Colume value those you want print
                     }, title: "<center> PURCHASE LIST</center>", className: "btn-sm prints"
      }
      , {
          extend: "pdf",exportOptions: {
                 columns: [0,1,2,3,4,5] //Your Colume value those you want print
                     }, title: "<center> PURCHASE LIST</center>", className: "btn-sm prints"
      }
      , {
          extend: "print",exportOptions: {
                 columns: [ 0,1,2,3,4,5] //Your Colume value those you want print
                     },title: "<center> <center> PURCHASE LIST</center></center>", className: "btn-sm prints"
      }
      ],

      
      'serverMethod': 'post',
      'ajax': {
         'url':base_url + 'Cpurchase/get_product_purchase_view',
           "data": function (data) {
   data.fromdate = $('#from_date').val();
   data.todate = $('#to_date').val();
   data.csrf_test_name = csrf_test_name;
   data.prod_id = prod_id;
  
}
      },
    'columns': [
       { data: 'no' },
       { data: 'po_date'},
       { data: 'po_id'},
       { data: 'product_id'},
       { data: 'product_name'},
       { data: 'total_amount',class:"total_sale text-right",render: $.fn.dataTable.render.number( ',', '.', 2, currency )},
       { data: 'isby'},
    ],

"footerCallback": function(row, data, start, end, display) {
var api = this.api();
api.columns('.total_sale', {
page: 'current'
}).every(function() {
var sum = this
.data()
.reduce(function(a, b) {
  var x = parseFloat(a) || 0;
  var y = parseFloat(b) || 0;
  return x + y;
}, 0);
$(this.footer()).html(currency+' '+sum.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}));
});
}


});


$('#btn-filter').click(function(){ 
purchasedatatable.ajax.reload();  
});

});