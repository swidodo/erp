// "use strict";
// function addInputField(t) {
//     var row = $("#normalinvoice tbody tr").length;
//     var count = row + 1;
//       var  tab1 = 0;
//       var  tab2 = 0;
//       var  tab3 = 0;
//       var  tab4 = 0;
//       var  tab5 = 0;
//       var  tab6 = 0;
//       var  tab7 = 0;
//       var  tab8 = 0;
//       var  tab9 = 0;
//       var  tab10 = 0;
//       var  tab11 = 0;
//       var  tab12 = 0;
//     var limits = 500;
//     var tbfild ='';
    
//     if (count == limits)
//         alert("You have reached the limit of adding " + count + " inputs");
//     else {
//         var a = "product_name_" + count,
//                 tabindex = count * 6,
//                 e = document.createElement("tr");
//         tab1 = tabindex + 1;
//         tab2 = tabindex + 2;
//         tab3 = tabindex + 3;
//         tab4 = tabindex + 4;
//         tab5 = tabindex + 5;
//         tab6 = tabindex + 6;
//         tab7 = tabindex + 7;
//         tab8 = tabindex + 8;
//         tab9 = tabindex + 9;
//         tab10 = tabindex + 10;
//         tab11 = tabindex + 11;
//         tab12 = tabindex + 12;
//         e.innerHTML = "<td><input type='text' name='product_name' onkeypress='invoice_productList(" + count + ");' class='form-control productSelection common_product' placeholder='Nama Produk' id='" + a + "' required tabindex='" + tab1 + "'><input type='hidden' class='common_product autocomplete_hidden_value  product_id_" + count + "' name='product_id[]' id='SchoolHiddenId'/></td><td><input type='text' name='merek[]' id='' class='form-control text-right merek_" + count + "' value='0' readonly='readonly' /></td><td> <input type='text' name='product_quantity[]' value='1' required='required' onkeyup='quantity_calculate(" + count + ");' onchange='quantity_calculate(" + count + ");' id='total_qntt_" + count + "' class='common_qnt total_qntt_" + count + " form-control text-right'  placeholder='0.00' min='0' tabindex='" + tab3 + "'/></td><td><input class='form-control text-right common_name unit_" + count + " valid' value='Unit' readonly='' aria-invalid='false' type='text'></td><td><input type='text' name='product_rate[]' onkeyup='quantity_calculate(" + count + ");' onchange='quantity_calculate(" + count + ");' id='price_item_" + count + "' class='common_rate price_item" + count + " form-control text-right' required placeholder='0.00' min='0' tabindex='" + tab4 + "'/></td><td class='text-right'><input class='common_total_price total_price form-control text-right' type='text' name='total_price[]' id='total_price_" + count + "' value='0.00' readonly='readonly'/></td><td>"+tbfild+"<input type='hidden' id='all_discount_" + count + "' class='total_discount dppr' name='discount_amount[]'/><button tabindex='" + tab5 + "' style='text-align: right;' class='btn btn-danger' type='button' value='Delete' onclick='deleteRow(this)'><i class='fa fa-close'></i></button></td>",
//                 document.getElementById(t).appendChild(e),
//                 document.getElementById(a).focus(),
//                 document.getElementById("add_invoice_item").setAttribute("tabindex", tab6);
//                 document.getElementById("details").setAttribute("tabindex", tab7);
//                 document.getElementById("invoice_discount").setAttribute("tabindex", tab8);
//                 document.getElementById("shipping_cost").setAttribute("tabindex", tab9);    
//                 document.getElementById("paidAmount").setAttribute("tabindex", tab10);
//                 document.getElementById("full_paid_tab").setAttribute("tabindex", tab11);
//                 document.getElementById("add_invoice").setAttribute("tabindex", tab12);
//                 count++
//     }
// }


"use strict";
function quantity_calculate(item) {
    var quantity            = $("#total_qntt_" + item).val();
    var available_quantity  = $(".available_quantity_" + item).val();
    var price_item          = $("#price_item_" + item).val();
    var invoice_discount    = $("#invoice_discount").val();
    var discount            = $("#discount_" + item).val();
    var total_tax           = $("#total_tax_" + item).val();
    var total_discount      = $("#total_discount_" + item).val();
    var taxnumber           = $("#txfieldnum").val();
    var dis_type            = $("#discount_type_" + item).val();
    if (parseInt(quantity) > parseInt(available_quantity)) {
        var message = "You can Sale maximum " + available_quantity + " Items";
        alert(message);
        $("#total_qntt_" + item).val('');
        var quantity = 0;
        $("#total_price_" + item).val(0);
            for(var i=0;i<taxnumber;i++){
            $("#all_tax"+i+"_" + item).val(0);
               quantity_calculate(item);
        }
    }

if (quantity > 0 || discount > 0) {
        if (dis_type == 1) {
            var price = quantity * price_item;
            var dis = +(price * discount / 100);
 

            $("#all_discount_" + item).val(dis);

            //Total price calculate per product
            var temp = price - dis;
            var ttletax = 0;
            $("#total_price_" + item).val(temp);
             for(var i=0;i<taxnumber;i++){
                var tax = (temp-ttletax) * $("#total_tax"+i+"_" + item).val();
                //    var tax = (temp-ttletax) * $("#total_tax"+i+"_" + item).val();
                ttletax += Number(tax);
                $("#all_tax"+i+"_" + item).val(tax);
            }

          
        } else if (dis_type == 2) {
            var price = quantity * price_item;

            // Discount cal per product
            var dis = (discount * quantity);

            $("#all_discount_" + item).val(dis);

            //Total price calculate per product
            var temp = price - dis;
            $("#total_price_" + item).val(temp);

            var ttletax = 0;
             for(var i=0;i<taxnumber;i++){
                var tax = (temp-ttletax) * $("#total_tax"+i+"_" + item).val();
                ttletax += Number(tax);
                    $("#all_tax"+i+"_" + item).val(tax);
            }
        } else if (dis_type == 3) {
            var total_price = quantity * price_item;
             var dis =  discount;
            // Discount cal per product
            $("#all_discount_" + item).val(dis);
            //Total price calculate per product
            var price = total_price - dis;
            $("#total_price_" + item).val(price);

             var ttletax = 0;
             for(var i=0;i<taxnumber;i++){
                var tax = (price-ttletax) * $("#total_tax"+i+"_" + item).val();
                ttletax += Number(tax);
                    $("#all_tax"+i+"_" + item).val(tax);
            }
        }
    } else {
        var n = quantity * price_item;
        var c = quantity * price_item * total_tax;
        $("#total_price_" + item).val(n),
        $("#all_tax_" + item).val(c)
    }
    calculateSum();
    invoice_paidamount();
}
//Calculate Sum
    "use strict";
function calculateSum() {
     var taxnumber = $("#txfieldnum").val();
    var t = 0,
        a = 0,
        e = 0,
        o = 0,
        p = 0,
        f = 0,
        ad = 0,
        tx = 0,
        ds = 0,
        tf = 0,
        tp = 0,
        ttg = 0,
        s_cost =  $("#shipping_cost").val();

    //Total Tax
   for(var i=0;i<taxnumber;i++){
      
var j = 0;
    $(".total_tax"+i).each(function () {
        isNaN(this.value) || 0 == this.value.length || (j += parseFloat(this.value))
    });
            $("#total_tax_ammount"+i).val(j.toFixed(2, 2));
             
    }
            //Total Discount
            $(".total_discount").each(function () {
        isNaN(this.value) || 0 == this.value.length || (p += parseFloat(this.value))
    }),
            $("#total_discount_ammount").val(p.toFixed(2, 2)),

             $(".totalTax").each(function () {
        isNaN(this.value) || 0 == this.value.length || (f += parseFloat(this.value))
    }),
            $("#total_tax_amount").val(f.toFixed(2, 2)),
        tf = f.toFixed(2, 2),
            //Total Price
            $(".total_price").each(function () {
        isNaN(this.value) || 0 == this.value.length || (t += parseFloat(this.value))
    }),
         tp = t.toFixed(2, 2),
         ttg =t,
        $("#grandTotal").val(ttg.toFixed(2, 2)),
        $("#subtotal").val(t.toFixed(2, 2)),

 $(".dppr").each(function () {
        isNaN(this.value) || 0 == this.value.length || (ad += parseFloat(this.value))
    }),
            
    o = a.toFixed(2, 2),
    e = t.toFixed(2, 2),
    tx = f.toFixed(2, 2),
    ds = p.toFixed(2, 2);

    var test = +tx + +s_cost + +e + -ds + + ad;
    // $("#grandTotal").val(test.toFixed(2, 2));


    var invdis = $("#invoice_discount").val();
    var total_discount_ammount = $("#total_discount_ammount").val();
    var ttl_discount = +total_discount_ammount;
    $("#total_discount_ammount").val(ttl_discount.toFixed(2, 2));
    invoice_paidamount();
    // var gt = $("#grandTotal").val();
    // var grnt_totals = gt;
    // $("#grandTotal").val(grnt_totals);
}

//Invoice Paid Amount
    "use strict";
function invoice_paidamount() {
 var  prb = parseFloat($("#previous").val(), 10);
 var pr = 0;
 var d = 0;
 var nt = 0;
    if(prb != 0){
        pr =  prb;
    }else{
        pr = 0;
    }
    var t = $("#grandTotal").val(),
            a = $("#paidAmount").val(),
            e = t - a,
            f = e + pr,
            nt = parseFloat(t, 10) + pr;
            d = a - nt;
    $("#n_total").val(nt.toFixed(2, 2));      
     if(f > 0){
    $("#dueAmmount").val(f.toFixed(2,2));
     if(a <= f){
     $("#change").val(0);   
    }
   }else{
    if(a < f){
     $("#change").val(0);   
    }
    if(a > f){
        $("#change").val(d.toFixed(2,2))
    }
  $("#dueAmmount").val(0)   

}
}

//Stock Limit
    "use strict";
function stockLimit(t) {
    var a = $("#total_qntt_" + t).val(),
            e = $(".product_id_" + t).val(),
            o = $(".baseUrl").val();

    $.ajax({
        type: "POST",
        url: o + "Cinvoice/product_stock_check",
        data: {
            product_id: e
        },
        cache: !1,
        success: function (e) {
            alert(e);
            if (a > Number(e)) {
                var o = "You can Sale maximum " + e + " Items";
                alert(o), $("#qty_item_" + t).val("0"), $("#total_qntt_" + t).val("0"), $("#total_price_" + t).val("0")
            }
        }
    })
}


    "use strict";
function stockLimitAjax(t) {
    var a = $("#total_qntt_" + t).val(),
            e = $(".product_id_" + t).val(),
            o = $(".baseUrl").val();
            
    $.ajax({
        type: "POST",
        url: o + "Cinvoice/product_stock_check",
        data: {
            product_id: e
        },
        cache: !1,
        success: function (e) {
            alert(e);
            if (a > Number(e)) {
                var o = "You can Sale maximum " + e + " Items";
                alert(o), $("#qty_item_" + t).val("0"), $("#total_qntt_" + t).val("0"), $("#total_price_" + t).val("0.00"), calculateSum()
            }
        }
    })
}

//Invoice full paid
    "use strict";
function full_paid() {
    var grandTotal = $("#n_total").val();
    $("#paidAmount").val(grandTotal);
    invoice_paidamount();
    calculateSum();
}

//Delete a row of table
    "use strict";
function deleteRow(t) {
    var a = $("#normalinvoice > tbody > tr").length;
    if (1 == a)
        alert("There only one row you can't delete.");
    else {
        var e = t.parentNode.parentNode;
        e.parentNode.removeChild(e),
                calculateSum();
        invoice_paidamount();
        var current = 1;
        $("#normalinvoice > tbody > tr td input.productSelection").each(function () {
            current++;
            $(this).attr('id', 'product_name' + current);
        });
        var common_qnt = 1;
        $("#normalinvoice > tbody > tr td input.common_qnt").each(function () {
            common_qnt++;
            $(this).attr('id', 'total_qntt_' + common_qnt);
            $(this).attr('onkeyup', 'quantity_calculate('+common_qnt+');');
            $(this).attr('onchange', 'quantity_calculate('+common_qnt+');');
        });
        var common_rate = 1;
        $("#normalinvoice > tbody > tr td input.common_rate").each(function () {
            common_rate++;
            $(this).attr('id', 'price_item_' + common_rate);
            $(this).attr('onkeyup', 'quantity_calculate('+common_qnt+');');
            $(this).attr('onchange', 'quantity_calculate('+common_qnt+');');
        });
        var common_discount = 1;
        $("#normalinvoice > tbody > tr td input.common_discount").each(function () {
            common_discount++;
            $(this).attr('id', 'discount_' + common_discount);
            $(this).attr('onkeyup', 'quantity_calculate('+common_qnt+');');
            $(this).attr('onchange', 'quantity_calculate('+common_qnt+');');
        });
        var common_total_price = 1;
        $("#normalinvoice > tbody > tr td input.common_total_price").each(function () {
            common_total_price++;
            $(this).attr('id', 'total_price_' + common_total_price);
        });




    }
}
var count = 2,
        limits = 500;



    "use strict";
    function bank_info_show(payment_type)
    {
        if (payment_type.value == "1") {
            document.getElementById("bank_info_hide").style.display = "none";
        } else {
            document.getElementById("bank_info_hide").style.display = "block";
        }
    }

     "use strict";
    function active_customer(status)
    {
        if (status == "payment_from_2") {
            document.getElementById("payment_from_2").style.display = "none";
            document.getElementById("payment_from_1").style.display = "block";
            document.getElementById("myRadioButton_2").checked = false;
            document.getElementById("myRadioButton_1").checked = true;
        } else {
            document.getElementById("payment_from_1").style.display = "none";
            document.getElementById("payment_from_2").style.display = "block";
            document.getElementById("myRadioButton_2").checked = false;
            document.getElementById("myRadioButton_1").checked = true;
        }
    }


        window.onload = function () {
        $('body').addClass("sidebar-mini sidebar-collapse");
    }

        "use strict";
      function bank_paymet(val){
        if(val==2){
           var style = 'block'; 
           document.getElementById('bank_id').setAttribute("required", true);
        }else{
       var style ='none';
        document.getElementById('bank_id').removeAttribute("required");
        }
           
        document.getElementById('bank_id').value='';
        document.getElementById('bank_div').style.display = style;
    }

    $(document ).ready(function() {
    $('#normalinvoice .toggle').on('click', function() {
    $('#normalinvoice .hideableRow').toggleClass('hiddenRow');
  })
});

     "use strict";
    function customer_due(id){
   var csrf_test_name = $('[name="csrf_test_name"]').val();
   var base_url = $("#base_url").val();
        $.ajax({
            url: base_url + 'Cinvoice/previous',
            type: 'post',
            data: {customer_id:id,csrf_test_name:csrf_test_name}, 
            success: function (msg){
               
                $("#previous").val(msg);
            },
            error: function (xhr, desc, err){
                 alert('failed');
            }
        });        
    }

       $('.ac').click(function () {
        $('.customer_hidden_value').val('');
    });
    $('#myRadioButton_1').click(function () {
        $('#customer_name').val('');
    });

    $('#myRadioButton_2').click(function () {
        $('#customer_name_others').val('');
    });
    $('#myRadioButton_2').click(function () {
        $('#customer_name_others_address').val('');
    });
    "use strict";
    function invoice_productList(sl) {

        var priceClass = 'price_item'+sl;
        var available_quantity = 'available_quantity_'+sl;
        var unit = 'unit_'+sl;
        var tax = 'total_tax_'+sl;
        var serial_no = 'serial_no_'+sl;
        var discount_type = 'discount_type_'+sl;
        var csrf_test_name = $('[name="csrf_test_name"]').val();
        var base_url = $("#base_url").val();

   // Auto complete
   var options = {
       minLength: 0,
       source: function( request, response ) {
           var product_name = $('#product_name_'+sl).val();
       $.ajax( {
         url: base_url + "Cinvoice/autocompleteproductsearch",
         method: 'post',
         dataType: "json",
         data: {
           term: request.term,
           product_name:product_name,
           csrf_test_name:csrf_test_name,
         },
         success: function( data ) {
           response( data );

         }
       });
     },
      focus: function( event, ui ) {
          $(this).val(ui.item.label);
          return false;
      },
      select: function( event, ui ) {
           $(this).parent().parent().find(".autocomplete_hidden_value").val(ui.item.value); 
               $(this).val(ui.item.label);
               var id=ui.item.value;
               var dataString = 'product_id='+ id;
               var base_url = $('.baseUrl').val();

               $.ajax
                  ({
                       type: "POST",
                       url: base_url+"Cinvoice/retrieve_product_data_inv",
                       data: {product_id:id,csrf_test_name:csrf_test_name},
                       cache: false,
                       success: function(data)
                       {
                           var obj = jQuery.parseJSON(data);
                            for (var i = 0; i < (obj.txnmber); i++) {
                                var txam = obj.taxdta[i];
                                var txclass = 'total_tax'+i+'_'+sl;                                
                                $('.'+txclass).val(obj.taxdta[i]);
                            }                           
                           $('.'+priceClass).val(obj.price);
                           $('.'+available_quantity).val(obj.total_product.toFixed(2,2));
                           $('.'+unit).val(obj.unit);
                           $('.'+tax).val(obj.tax);
                           $('#txfieldnum').val(obj.txnmber);
                           $('#'+serial_no).html(obj.serial);
                           $('#'+discount_type).val(obj.discount_type);
                                  quantity_calculate(sl);  
                       } 
                   });

           $(this).unbind("change");
           return false;
      }
  }

  $('body').on('keypress.autocomplete', '.productSelection', function() {
      $(this).autocomplete(options);
  });

}


$(document).ready(function() {
        "use strict";
     $("#service_quotation_div").click(function () {
         $("#quotation_service").toggle(1500,"easeOutQuint",function(){
          }); 
  });    
  });

     "use strict";
    function get_customer_info(t) {
        var csrf_test_name = $('[name="csrf_test_name"]').val();
        var base_url = $("#base_url").val();
        $.ajax({
            url: base_url + "Cquotation/get_customer_info",
            type: 'POST',
            data: {customer_id: t,csrf_test_name:csrf_test_name},
            success: function (r) {
                r = JSON.parse(r);
                $("#address").val(r.customer_address);
                $("#mobile").val(r.phone);
                $("#website").val(r.customer_email);
            }
        });
       
    }

//open
    "use strict";
function invoice_productList(sl) {

        var priceClass = 'price_item'+sl;
        var available_quantity = 'available_quantity_'+sl;
        var unit = 'unit_'+sl;
        var tax = 'total_tax_'+sl;
        var serial_no = 'serial_no_'+sl;
        var discount_type = 'discount_type_'+sl;
        var csrf_test_name = $('[name="csrf_test_name"]').val();
        var base_url = $("#base_url").val();

    // Auto complete
    var options = {
        minLength: 0,
        source: function( request, response ) {
            var product_name = $('#product_name_'+sl).val();
        $.ajax( {
          url: base_url + "Cinvoice/autocompleteproductsearch",
          method: 'post',
          dataType: "json",
          data: {
            term: request.term,
            product_name:product_name,
            csrf_test_name:csrf_test_name,
          },
          success: function( data ) {
            response( data );

          }
        });
      },
       focus: function( event, ui ) {
           $(this).val(ui.item.label);
           return false;
       },
       select: function( event, ui ) {
            $(this).parent().parent().find(".autocomplete_hidden_value").val(ui.item.value); 
                $(this).val(ui.item.label);
                var id=ui.item.value;
                var dataString = 'product_id='+ id;
                var base_url = $('.baseUrl').val();

                $.ajax
                   ({
                        type: "POST",
                        url: base_url+"Cinvoice/retrieve_product_data_inv",
                        data: {product_id:id,csrf_test_name:csrf_test_name,},
                        cache: false,
                        success: function(data)
                        {
                            var obj = jQuery.parseJSON(data);
                            for (var i = 0; i < (obj.txnmber); i++) {
                            var txam = obj.taxdta[i];
                            var txclass = 'total_tax'+i+'_'+sl;
                           $('.'+txclass).val(obj.taxdta[i]);
                            }
                            $('.'+priceClass).val(obj.price);
                            $('.'+available_quantity).val(obj.total_product.toFixed(2,2));
                            $('.'+unit).val(obj.unit);
                            $('.'+tax).val(obj.tax);
                            $('#txfieldnum').val(obj.txnmber);
                            $('#supplier_price_'+sl).val(obj.supplier_price);
                            $('#'+serial_no).html(obj.serial);
                            $('#'+discount_type).val(obj.discount_type);
                                   quantity_calculate(sl);
                                   //This Function Stay on others.js page
                            
                            
                        } 
                    });

            $(this).unbind("change");
            return false;
       }
   }

   $('body').on('keypress.autocomplete', '.productSelection', function() {
       $(this).autocomplete(options);
   });

}

       "use strict";
 function addService(t) {
    var row = $("#serviceInvoice tbody tr").length;
    var count = row + 1;
    var tab1 = 0;
    var tab2 = 0;
    var tab3 = 0;
    var tab4 = 0;
    var tab5 = 0;
    var tab6 = 0;
    var limits = 500;
    var taxnumber = $("#sertxfieldnum").val();
    var tbfild ='';
    for(var i=0;i<taxnumber;i++){
        var taxincrefield = '<input id="total_service_tax'+i+'_'+count+'" class="total_service_tax'+i+'_'+count+'" type="hidden"><input id="all_servicetax'+i+'_'+count+'" class="total_service_tax'+i+'" type="hidden" name="stax[]">';
         tbfild +=taxincrefield;
    }
    if (count == limits)
        alert("You have reached the limit of adding " + count + " inputs");
    else {
        var a = "service_name" + count,
                tabindex = count * 5,
                e = document.createElement("tr");
        //e.setAttribute("id", count);
        tab1 = tabindex + 1;
        tab2 = tabindex + 2;
        tab3 = tabindex + 3;
        tab4 = tabindex + 4;
        tab5 = tabindex + 5;
        tab6 = tabindex + 6;
        e.innerHTML = "<td><input type='text' name='service_name' onkeypress='invoice_serviceList(" + count + ");' class='form-control serviceSelection common_product' placeholder='Service Name' id='" + a + "'  tabindex='" + tab1 + "'><input type='hidden' class='common_product autocomplete_hidden_value  service_id_" + count + "' name='service_id[]' id='SchoolHiddenId'/></td><td> <input type='text' name='service_quantity[]'  onkeyup='serviceCAlculation(" + count + ");' onchange='serviceCAlculation(" + count + ");' id='total_service_qty_" + count + "' class='common_qnt total_service_qty_" + count + " form-control text-right'  placeholder='0.00' min='0' tabindex='" + tab2 + "'/></td><td><input type='text' name='service_rate[]' onkeyup='serviceCAlculation(" + count + ");' onchange='serviceCAlculation(" + count + ");' id='service_rate_" + count + "' class='common_rate service_rate" + count + " form-control text-right'  placeholder='0.00' min='0' tabindex='" + tab3 + "'/></td><td><input type='text' name='sdiscount[]' onkeyup='serviceCAlculation(" + count + ");' onchange='serviceCAlculation(" + count + ");' id='sdiscount_" + count + "' class='form-control text-right common_servicediscount' placeholder='0.00' min='0' tabindex='" + tab4 + "' /><input type='hidden' value='' name='discount_type' id='sdiscount_type_" + count + "'></td><td class='text-right'><input class='common_total_service_amount total_serviceprice form-control text-right' type='text' name='total_service_amount[]' id='total_service_amount_" + count + "' value='0.00' readonly='readonly'/></td><td>"+tbfild+"<input type='hidden'  id='totalServiceDicount_" + count + "' class='totalServiceDicount_" + count + "' /><input type='hidden' id='all_service_discount_" + count + "' class='totalServiceDicount' name='sdiscount_amount[]'/><button tabindex='" + tab5 + "'  class='btn btn-danger text-center' type='button' onclick='deleteServicraw(this)'><i class='fa fa-close'></i></button></td>",
                document.getElementById(t).appendChild(e),
                document.getElementById(a).focus(),
                document.getElementById("add_service_item").setAttribute("tabindex", tab6);
        count++
    }
}
//Quantity calculat
    "use strict";
function serviceCAlculation(item) {
    var quantity            = $("#total_service_qty_" + item).val();
    var service_rate        = $("#service_rate_" + item).val();
    var service_discount    = $("#service_discount").val();
    var discount            = $("#sdiscount_" + item).val();
    var total_service_tax   = $("#total_service_tax_" + item).val();
    var taxnumber           = $("#sertxfieldnum").val();
    var totalServiceDicount = $("#totalServiceDicount_" + item).val();
    var dis_type            = $("#sdiscount_type_" + item).val();

    if (quantity > 0 || discount > 0) {
        if (dis_type == 1) {
            var price = quantity * service_rate;
            var dis = +(price * discount / 100);
            $("#all_service_discount_" + item).val(dis);

            //Total price calculate per product
            var temp = price - dis;
            var ttletax = 0;
            $("#total_service_amount_" + item).val(temp);
            for(var i=0;i<taxnumber;i++){
                var tax = (temp-ttletax) * $("#total_service_tax"+i+"_" + item).val();
                var tax1 = $("#total_service_tax"+i+"_" + item).val();
                ttletax += Number(tax);
                $("#all_servicetax"+i+"_" + item).val(tax);
                // console.log(tax1);
            }
        } else if (dis_type == 2) {
            var price = quantity * service_rate;

            // Discount cal per product
            var dis = (discount * quantity);

            $("#all_service_discount_" + item).val(dis);

            //Total price calculate per product
            var temp = price - dis;
            $("#total_service_amount_" + item).val(temp);

            var ttletax = 0;
             for(var i=0;i<taxnumber;i++){
                var tax = (temp-ttletax) * $("#total_service_tax"+i+"_" + item).val();
                ttletax += Number(tax);
                    $("#all_servicetax"+i+"_" + item).val(tax);
            }
        } else if (dis_type == 3) {
            var total_service_amount = quantity * service_rate;
            
            // Discount cal per product
            $("#all_service_discount_" + item).val(discount);
            //Total price calculate per product
            var price = (total_service_amount - discount);
            $("#total_service_amount_" + item).val(total_service_amount);

             var ttletax = 0;
             for(var i=0;i<taxnumber;i++){
                var tax = (price-ttletax) * $("#total_service_tax"+i+"_" + item).val();
                ttletax += Number(tax);
                $("#all_servicetax"+i+"_" + item).val(tax);
            }
        
        }
       
        
    }
    else {
        var n = quantity * service_rate;
        var c = quantity * service_rate * total_service_tax;
        // var c = quantity * service_rate;
        $("#total_service_amount_" + item).val(n),
        $("#all_servicetax_" + item).val(c)
        // console.log(c);
    }
    ServiceCalculation();
   
}
//Calculate Sum
    "use strict";
function ServiceCalculation() {
  var taxnumber = $("#sertxfieldnum").val();
    
          var t = 0,          
            a = 0,
            e = 0,
            o = 0,
            p = 0,
            f = 0;
        
  //Total Tax
for(var i=0;i<taxnumber;i++){
      
var j = 0;
    $(".total_service_tax"+i).each(function () {
        isNaN(this.value) || 0 == this.value.length || (j += parseFloat(this.value))
    });
            $("#total_service_tax_amount"+i).val(j.toFixed(2, 2));
             
    }
 
        //Discount part
         $(".totalServiceDicount").each(function () {
        isNaN(this.value) || 0 == this.value.length || (p += parseFloat(this.value))
    }),
            $("#total_service_discount").val(p.toFixed(2, 2)),

    $(".totalServiceTax").each(function () {
        isNaN(this.value) || 0 == this.value.length || (f += parseFloat(this.value))
    }),
            $("#total_service_tax").val(f.toFixed(2, 2)),
            //Total Price
            $(".total_serviceprice").each(function () {
        isNaN(this.value) || 0 == this.value.length || (t += parseFloat(this.value))
    }),
    $('#serviceSubTotal').val(t.toFixed(2,2));
        // o = f.toFixed(2, 2),
        // e = t.toFixed(2, 2);
    	// f = p.toFixed(2, 2);

    var test = t;
    $("#serviceGrandTotal").val(test.toFixed(2, 2));
 
    // var gt = $("#serviceGrandTotal").val();
    var invdis = $("#service_discount").val();
    var total_service_discount = $("#total_service_discount").val();
    var ttl_discount = +total_service_discount + +invdis;
    $("#total_service_discount").val(ttl_discount.toFixed(2, 2));
    // var grnt_totals = gt;
    // $("#serviceGrandTotal").val(grnt_totals);

}


//Delete a row of table
    "use strict";
function deleteServicraw(t) {
    var a = $("#serviceInvoice > tbody > tr").length;
//    alert(a);
    if (1 == a)
        alert("There only one row you can't delete.");
    else {
        var e = t.parentNode.parentNode;
        e.parentNode.removeChild(e),
                ServiceCalculation();
        var current = 1;
        $("#serviceInvoice > tbody > tr td input.productSelection").each(function () {
            current++;
            $(this).attr('id', 'product_name' + current);
        });
        var common_qnt = 1;
        $("#serviceInvoice > tbody > tr td input.common_qnt").each(function () {
            common_qnt++;
            $(this).attr('id', 'total_service_qty_' + common_qnt);
            $(this).attr('onkeyup', 'serviceCAlculation('+common_qnt+');');
            $(this).attr('onchange', 'serviceCAlculation('+common_qnt+');');
        });
        var common_rate = 1;
        $("#serviceInvoice > tbody > tr td input.common_rate").each(function () {
            common_rate++;
            $(this).attr('id', 'service_rate_' + common_rate);
            $(this).attr('onkeyup', 'serviceCAlculation('+common_qnt+');');
            $(this).attr('onchange', 'serviceCAlculation('+common_qnt+');');
        });
        var common_servicediscount = 1;
        $("#serviceInvoice > tbody > tr td input.common_servicediscount").each(function () {
            common_servicediscount++;
            $(this).attr('id', 'sdiscount_' + common_servicediscount);
            $(this).attr('onkeyup', 'serviceCAlculation('+common_qnt+');');
            $(this).attr('onchange', 'serviceCAlculation('+common_qnt+');');
        });
        var common_total_service_amount = 1;
        $("#serviceInvoice > tbody > tr td input.common_total_service_amount").each(function () {
            common_total_serviceprice++;
            $(this).attr('id', 'total_serviceprice_' + common_total_price);
        });




    }
}
    var count = 2,
        limits = 500;
              "use strict";
    function bank_paymet(val){
        if(val==2){
           var style = 'block'; 
           document.getElementById('bank_id').setAttribute("required", true);
        }else{
            var style ='none';
            document.getElementById('bank_id').removeAttribute("required");
        }
           
        document.getElementById('bank_id').value='';
        document.getElementById('bank_div').style.display = style;
    }

    $( document ).ready(function() {
        var is_quotation = $("#is_quotation").val();
        if(is_quotation !==''){
          $("#quotation_service").css("display", "block");        
      }else{
       $("#quotation_service").css("display", "none"); 
      }

    
    });

    // revisi
    function invoice_serviceList(cName) {
		var priceClass = 'service_rate'+cName;
		var discount_type = 'sdiscount_type_'+cName;
		var csrf_test_name = $('[name="csrf_test_name"]').val();
        var tax = 'total_tax_'+cName;
        var tax2 = 'total_tax2_'+cName;
        var tax3 = 'total_tax3_'+cName;
        var base_url = $("#base_url").val();
        var list = {
            minLength: 0,
            source: function(request, response) {
                var service_name = $('#service_name_'+cName).val();
            $.ajax( {
              url: base_url + "Cinvoice/autocompleteservicesearch",
              method: 'post',
              dataType: "json",
              data: {
                term: request.term,
                product_name:service_name,
                csrf_test_name:csrf_test_name,
              },
              success: function(data) {
                response(data);
              }
            });
          },
			focus: function(event, ui) {
				$(this).parent().find(".autocomplete_hidden_value").val(ui.item.value);
				$(this).val(ui.item.label);
				return false;
			},
			select: function(event, ui) {
				$(this).parent().find(".autocomplete_hidden_value").val(ui.item.value);
				$(this).val(ui.item.label);
				
				var id=ui.item.value;

				var dataString = 'service_id='+ id;
				var base_url = $('.baseUrl').val();

				
				$.ajax
				   ({
						type: "POST",
						url: base_url+"Cservice/retrieve_service_data_inv",
						data: {service_id:id,csrf_test_name:csrf_test_name},
						cache: false,
						success: function(data)
						{
                            

							var obj = jQuery.parseJSON(data);
							for (var i = 0; i < (obj.txnmber); i++) {
							var txam = obj.taxdta[i];
							var txclass = 'total_service_tax'+i+'_'+cName;
                           $('.'+txclass).val(obj.taxdta[i]);
							}
							$('.'+priceClass).val(obj.price);
							$('#'+discount_type).val(obj.discount_type);
							$('#sertxfieldnum').val(obj.txnmber);
							//This Function Stay on others.js page
							serviceCAlculation(cName);
							
						} 
					});
				
				$(this).unbind("change");
				return false;
			}
        }
		// $(".serviceSelection" ).focus(function(){
		// 	$(this).change(APchange);
		
		// });
        $('body').on('keypress.autocomplete', '.serviceSelection', function() {
            $(this).autocomplete(list);
        });
    }
    
    