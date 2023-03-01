$(document).ready(function() { 
    "use strict";
    var csrf_test_name = $('[name="csrf_test_name"]').val();
    var total_purchase_no = $("#total_purchase_no").val();
    var base_url = $("#base_url").val();
    var currency = $("#currency").val();
    
    var purchasedatatable = $('#ManagePurchaseList').DataTable({ 
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
                 columns: [ 0,1,2,3,4,5,6,7,8,9 ] //Your Colume value those you want
                     }, className: "btn-sm prints"
      }
      , {
          extend: "csv", title: "<center> PURCHASE LIST</center>",exportOptions: {
                 columns: [ 0,1,2,3,4,5,6,7,8,9] //Your Colume value those you want print
                     }, className: "btn-sm prints"
      }
      , {
          extend: "excel",exportOptions: {
                 columns: [0,1,2,3,4,5,6,7,8,9 ] //Your Colume value those you want print
                     }, title: "<center> PURCHASE LIST</center>", className: "btn-sm prints"
      }
      , {
          extend: "pdf",exportOptions: {
                 columns: [0,1,2,3,4,5,6,7,8,9] //Your Colume value those you want print
                     }, title: "<center> PURCHASE LIST</center>", className: "btn-sm prints"
      }
      , {
          extend: "print",exportOptions: {
                 columns: [ 0,1,2,3,4,5,6,7,8,9] //Your Colume value those you want print
                     },title: "<center> <center> PURCHASE LIST</center></center>", className: "btn-sm prints"
      }
      ],

      
      'serverMethod': 'post',
      'ajax': {
         'url':base_url + 'Cpurchase/Manage_product_data',
           "data": function (data) {
   data.fromdate = $('#from_date').val();
   data.todate = $('#to_date').val();
   data.csrf_test_name = csrf_test_name;
  
}
      },
    'columns': [
       { data: 'no' },
       { data: 'product_id'},
       { data: 'product_name'},
       { data: 'product_details'},
       { data: 'size'},
       { data: 'dimension'},
       { data: 'bobot'},
       { data: 'merek'},
       { data: 'price'},
       { data: 'total_amount',class:"total_sale text-right",render: $.fn.dataTable.render.number( ',', '.', 2, currency )},
       { data: 'button'},
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