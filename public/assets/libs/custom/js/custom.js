    //  --------select2 js ---------
    $( document ).ready(function() {
        $(".select2").select2();
    });
    var chart;
    setTimeout(() => {
        $( document ).ready(function() {

            $(function() {
                $('input[name="daterange"]').daterangepicker({
                  opens: 'left'
                }, function(start, end, label) {
                  console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                });
              });
        });


        // $(".getSales").on("change", function () {
        //     getSales();
        // });

    }, 1000);
    // daterangepicker



    //  --------sidebar active transition js ---------
    $(document).on('click', '#sidebar li', function() {
        $(this).addClass('active').siblings().removeClass('active')
    });

    //  --------sidebar collapse toggle js ---------
    $(document).ready(function() {
        $("#toggleSidebar").click(function() {
            $(".left-menu").toggleClass("hide");
            $(".content-wrapper").toggleClass("hide");
        });
    });

    // --------- left menu sidebar dropdown toggle    ---------
    $('.sub-menu ul').hide();
    $('.sub-menu a').click(function() {
        $(this).parent(".sub-menu").children("ul").slideToggle("180");
        $(this).find(".right").toggleClass("bi-caret-up-fill bi-caret-down-fill");
    });

    // ------- datatables js ------
    $(document).ready(function () {
        // $('#order-table').DataTable();
    });

    // ------- full screen button ---------
    const toggleFullScreen = () => {
        let doc = window.document;
        let docEl = doc.documentElement;

        let requestFullScreen =
          docEl.requestFullscreen ||
          docEl.mozRequestFullScreen ||
          docEl.webkitRequestFullScreen ||
          docEl.msRequestFullscreen;
        let cancelFullScreen =
          doc.exitFullscreen ||
          doc.mozCancelFullScreen ||
          doc.webkitExitFullscreen ||
          doc.msExitFullscreen;

        if (
          !doc.fullscreenElement &&
          !doc.mozFullScreenElement &&
          !doc.webkitFullscreenElement &&
          !doc.msFullscreenElement
        ) {
          requestFullScreen.call(docEl);
        } else {
          cancelFullScreen.call(doc);
        }
      };

    //   $( document ).ready(function() {
    //     toggleFullScreen
    //  })
    let allproducts = [];
    function getPrice(id)
    {

        let product_id = id+'-product_id';
        selected_product = $("#"+product_id).val();
        var productid = $("#"+id+"-product_id").val();
        if(productid == 'Choose'){
            alert("Select Product to add new");
            return false;
        }




        if ($.inArray(productid, allproducts) >= 0) {

            var div = $("#setting-row"+id+" > div:parent");
            var x = $("#setting-row"+id).prev().attr('id');
            //  if(x !== undefined)
            //  {

            //     return false;
            //  }

            var backway = parseInt(x.split("").reverse().join(""));

            $("input[name^='products']").each(function (index,val) {
                var id_loop = this.id;
                var product_input_id = parseInt(id_loop);

                product_id = product_input_id+'-product_id';
                lop_selected_product = $("#"+product_id).val();

                // console.log(lop_selected_product+' '+selected_product)
                if(selected_product == lop_selected_product ){
                    if(id_loop.includes('qty'))
                    {
                        var row_id = parseInt(id_loop);
                        product_id =  $("#"+row_id+"-product_id").val();

                        product_qty = product_input_id+'-qty';
                        old_value = parseInt($("#"+product_qty).val()) + 1;
                        $("#"+product_qty).val(old_value);
                        $("#"+id+"-product_id").val('');
                        $("#"+id+"-product_id"+" option").filter(function() {
                            //may want to use $.trim in here
                            return $(this).text() == 'Choose';
                          }).prop('selected', true);

                        $.ajax({
                            type: "GET",
                            url: "/get-price/"+productid,
                            success: function(data) {
                                // $("#"+id+"-sale_price").val(data.sale_price)

                                // $("#"+id+"-available-stock").css({"font-size":"12px","color":data.color,"font-weight":"bold"}).text(" Available("+data.stock+")");



                                calcualtePrice();
                            }
                        });



                                    }
                }

             });



            // return false;
        } else {
            $("input[name^='products']").each(function (index,val) {
            var id = this.id;
            // console.log(this.value+' '+id)
            if(id.includes('qty')){
                var row_id = parseInt(id);
                product_id =  $("#"+row_id+"-product_id").val();
                allproducts.push(product_id);
            }
         });

            $.ajax({
                type: "GET",
                url: "/get-price/"+productid,
                success: function(data) {
                    $("#"+id+"-sale_price").val(data.sale_price)

                    $("#"+id+"-available-stock").css({"font-size":"12px","color":data.color,"font-weight":"bold"}).text(" Available("+data.stock+")");



                    calcualtePrice();
                }
            });


        }


        // $("input[name^='products']").each(function (index,val) {
        //     var id = this.id;
        //     if(id.includes('qty')){
        //         var row_id = parseInt(id);
        //         product_id =  $("#"+row_id+"-product_id").val();
        //         allproducts.push(product_id);
        //     }
        //  });







    }

    function calcualtePrice()
    {

        var tax = $("#tax").val();
        var shipping = $("#shipping").val();

        var paid_amount = $("#paid_amount").val();
        var qty = $("#qty").val();
        var discount = $("#discount").val();

        var n = $("input[name^='products']").length;
        var price = 0;
        var qty = 0;
        $("input[name^='products']").each(function (index,val) {

            var id = this.id;

            var id_loop = id;
                var product_input_id = parseInt(id_loop);

                product_id = product_input_id+'-product_id';
                lop_selected_product = $("#"+product_id).val();


            if(lop_selected_product != 'Choose'){




            if(id.includes('qty')){
                var row_id = parseInt(id);
                row_qty =  $("#"+row_id+"-qty").val();
                row_price =  $("#"+row_id+"-sale_price").val();
                qty += row_qty;
                price += row_qty * row_price;
            }
        }

         });
        // var values = $("input[name='products[]']")
        //       .map(function(){return $(this).val();}).get();


        sale_price = price ;
        qty = qty;





      
        var subtotal = parseFloat(sale_price);
        let tax_amount = 0;
        if(parseInt(tax) > 0)
         tax_amount = (subtotal/100)*tax;
        var total_amount = parseFloat(sale_price)-parseFloat(discount) +parseFloat(tax_amount) +parseFloat(shipping);

        var remaining_amount=  total_amount - parseFloat(paid_amount);
        $("#remaining_amount").val(remaining_amount);
        $("#total").val(total_amount);
        $("#remaining").text(remaining_amount.toFixed(2));
        $("#paid").text(paid_amount);
        $("#sub_total").text(subtotal.toFixed(2));
        $("#show_discount").text(discount);
       
        $("#show_Tax").text(tax_amount.toFixed(2));
        $("#show_Shipping").text(shipping);

        $("#show_total").text(total_amount.toFixed(2));




    }



    $(document).on("change",".calculation", function () {
        calcualtePrice();
    });



    function showLoader()
    {
    alert("showLoader");
    }

    function hideLoader()
    {
    alert("hideLoader");
    }

    function getStatisticsForDashBoard()
    {
        var daterange = $("#daterange").val();
        var admin_id = $("#admin").val();

        var search = $("#search").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: "/get-dashboard",
            data:{"daterange":daterange, "admin_id":admin_id},
            success: function(data) {

                // $("#monthlySalesChart").remove();
                $('#row1').html(data.html);
                $('#row2').html(data.latest_html);
             //   initChart(data.monthlySales);


             
             datasets = data.monthlySalesData.map(user => ({
                label: user.name,
                data: user.sales,
                // borderColor: getRandomColor(),
                fill: false,
                tension: 0.1
            }));

        
            
            if (chart) {
                chart.data.datasets = datasets;
                chart.update();
            } else {
                initChart(response.monthlySales);  // Initialize chart if it hasn't been created
            }

                // updateChart(data.monthlySalesData)
            }
        });

    }


    function getDeposit()
    {
        var user_id = $("#user_id").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "GET",
            url: "/deposit-html",
            data:{"user_id":user_id},

            success: function(data) {
                $('#searchable').html(data.html);
            }
        });

    }





    function getSales()
    {
        var daterange = $("#daterange").val();
        var search = $("#search").val();
        var customer_id = $("#customer_id").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: "/get-sales",
            data:{"daterange":daterange,"search":search,"customer_id":customer_id},
            success: function(data) {
                $('#searchable').html(data.html);
                $('#searchable_pagination').html(data.phtml);
            }
        });

    }

    //  Get products


    function getProducts()
    {
        var search = $("#search").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: "/get-products",
            data:{"search":search},
            success: function(data) {
                $('#searchable').html(data.html);
                $('#searchable_pagination').html(data.phtml);
            }
        });

    }

    let isRequestInProgress = false; //
    // POS search 
    function getProductsForPos()
    {
        if (isRequestInProgress) {
            return; // Exit if a request is in progress
        }

        isRequestInProgress = true; // Se
        var search = $("#search").val();
        // if(search.length > 3){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "/get-pos-products",
                data:{"search":search},
                success: function(data) {
                    $('#searchable').html(data.html);
                    if ($("#barcodeActive").is(':checked')) {
                        if(data.products_count == 1)
                        addProductToCart(data.product_id,data.is_deal);
                    }
                   
                },
                complete: function() {
                    isRequestInProgress = false; // Reset flag when request is complete
                }
            });
        // }
        

    }

    // Get Purchases


    function getPurchases()
    {
        var daterange = $("#daterange").val();
        var search = $("#search").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: "/get-purchases",
            data:{"daterange":daterange,"search":search},
            success: function(data) {
                $('#searchable').html(data.html);
                $('#searchable_pagination').html(data.phtml);
            }
        });

    }

    //  Get Productions
    function getProductions()
    {
        var daterange = $("#daterange").val();
        var search = $("#search").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: "/get-productions",
            data:{"daterange":daterange,"search":search},
            success: function(data) {
                $('#searchable').html(data.html);
                $('#searchable_pagination').html(data.phtml);
            }
        });

    }


    // Get expenses
    function getExpenses()
    {
        var daterange = $("#daterange").val();
        var search = $("#search").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: "/get-expenses",
            data:{"daterange":daterange,"search":search},
            success: function(data) {
                $('#searchable').html(data.html);
                $('#searchable_pagination').html(data.phtml);
            }
        });

    }

    // Get customers
    function getCustomers()
    {

        var search = $("#search").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: "/get-customers",
            data:{"search":search},
            success: function(data) {
                $('#searchable').html(data.html);
                $('#searchable_pagination').html(data.phtml);

            }
        });

    }



    $(document).on('click','.export-csv-sale',function(){

        //var restaurants_id = $('#restaurants_id').val();



        var datetimerange = $('#daterange').val();
        var search = $('#daterange').val();
        var url = "/get-csv-sales?daterange="+datetimerange+'search='+search,

        new_window = window.open(url);
    })


    $(document).on('click','.export-csv-production',function(){

        //var restaurants_id = $('#restaurants_id').val();



        var datetimerange = $('#daterange').val();
        var search = $('#daterange').val();
        var url = "/get-csv-productions?daterange="+datetimerange+'search='+search,

        new_window = window.open(url);
    })



    $(document).on('click','.export-csv-expense',function(){

        //var restaurants_id = $('#restaurants_id').val();



        var datetimerange = $('#daterange').val();
        var search = $('#daterange').val();
        var url = "/get-csv-expenses?daterange="+datetimerange+'search='+search,

        new_window = window.open(url);
    })



    $(document).on('click','.export-csv-purchase',function(){

        //var restaurants_id = $('#restaurants_id').val();



        var datetimerange = $('#daterange').val();
        var search = $('#daterange').val();
        var url = "/get-csv-purchases?daterange="+datetimerange+'search='+search,

        new_window = window.open(url);
    })


    $(document).on('click','.export-csv-product',function(){

        //var restaurants_id = $('#restaurants_id').val();



        var datetimerange = $('#daterange').val();
        var url = "/get-csv-products?daterange="+datetimerange,

        new_window = window.open(url);
    })
    function addSetting(id) {

        // 0-qty
        allproducts = [];
        $("input[name^='products']").each(function (index,val) {
            var id = this.id;
            // console.log(this.value+' '+id)
            if(id.includes('qty')){
                var row_id = parseInt(id);
                product_id =  $("#"+row_id+"-product_id").val();
                allproducts.push(product_id);
            }
         });

        $("#setting-row" +id+ "-href").attr('disabled',true)
       var OldRow = id;

            totalrows = $(".setting > .setting-row").length;
            totalrecord = $('.totalrecord-settings').length;
         var div = $(".setting > .setting-row:last");
         FirstRowId = div.attr('id');
         lastRow = FirstRowId.split("setting-row");
        //  console.log(lastRow);
        product_id = id+'-product_id';
        selected_product = $("#"+product_id).val();
        // console.log(selected_product);
        if(selected_product == 'Choose'){
            alert("Select Product to add new");
            return false;
        }
        if($('#'+product_id).length > 1){
            product_qty = id+'-qty';
            old_value = parseInt($("#"+product_qty).val()) + 1;
            $("#"+product_qty).val(old_value);
        }else{


            var NextRow = parseInt(lastRow[1]) + 1;

            $.ajaxSetup({

              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });

            var addButton = '<a href="javascript:void(0)" class="btn btn-success " onclick="addSetting('+NextRow+')"><i class="bi bi-plus-lg"></i> Add</a>';
            var removeButton = '<a href="javascript:void(0)" class="btn btn-danger" rel='+FirstRowId+' onclick="removeSetting(this.rel)"><i class="bi bi-trash"></i></a>';
            $("#"+FirstRowId+'-btn').html(removeButton);

           //  $(".setting").append("<div class='setting-row' id='setting-row"+NextRow+"' >Hello  <a href='#' class='btn btn-success ' onclick='removeSetting("+NextRow+")'><i class='bi bi-minus-lg'></i> Remove</a></div>");

           products = [];
           $("input[name^='products']").each(function (index,val) {
               var id = this.id;
               if(id.includes('qty')){
                   var row_id = parseInt(id);
                   product_id =  $("#"+row_id+"-product_id").val();
                   products.push(product_id);
               }
            });


           //  console.log(totalrows+ ' '+ NextRow);
            $.ajax({

              type: 'get',

              url: '/add-new-row',

              data: { new_row: NextRow,totalrecord:totalrecord,"products":products },
              dataType: 'html',

              success: function (data) {
               $("#" + FirstRowId+ "-btn").html(removeButton)
                $(".setting").append(data)
              }
            })



        }






     }


     function addProductToCart(id,product_Type) {


        let product = document.querySelector("#original_product"+id);
        product.style.pointerEvents = "none";
       
       
        if ($("#setting-row"+id).length > 0){

            
            let  actual_qty = $("#original_stock_product"+id).val();
            let  current_qty = $("#cart_product_qty_"+id).val();
            if(product_Type == 1){
                old_value = parseFloat(current_qty) + 1;
                remaining_qty = parseFloat(actual_qty)-old_value;
                if(remaining_qty > 0){
                    updateProductSubTotal(id,old_value)
                    $("#cart_product_qty_"+id).val(parseFloat(old_value).toFixed(2));
                    $("#stock_product"+id).text(remaining_qty.toFixed(2));
                }
                else{
                    $("#cart_product_qty_"+id).val(parseFloat(actual_qty).toFixed(2));
                    $("#stock_product"+id).text(0);
                }
            }else{
                old_value = parseFloat(current_qty) + 1;
                updateProductSubTotal(id,old_value)
                $("#cart_product_qty_"+id).val(parseFloat(old_value).toFixed(2));
            }
            
            product.style.pointerEvents = "auto";



            
            posCalcualtePrice();
        }else{

            $.ajax({

              type: 'get',

              url: '/add-new-row-pos',

              data: { product_id: id},
              dataType: 'html',

              success: function (data) {
                $(".setting").append(data)
                product.style.pointerEvents = "auto";
                posCalcualtePrice();


                // let  actual_qty = $("#original_stock_product"+id).val();
                // let  current_qty = $("#cart_product_qty_"+id).val();
                // remaining_qty = parseFloat(actual_qty).toFixed(2)-parseFloat(current_qty).toFixed(2);
                // $("#stock_product"+id).text(remaining_qty.toFixed(2));



              }
            })
        }
     }
     

     function paidamountCal(){

        setTimeout(() => {
            posCalcualtePrice() 
        }, 500);
     }


     $(document).on("keyup",".change_price",function(){
        
        $("#cart_product_price_"+parseInt(this.id)).text(this.value);
        $("#sub_total_product_prices"+parseInt(this.id)).text(parseFloat(this.value) * parseFloat($("#cart_product_qty_"+parseFloat(this.id)).val()));
        
        posCalcualtePrice();
     })

     function posCalcualtePrice()
     {
 
 
         var paid_amount = parseFloat($("#paidsss").val()||0).toFixed(2);
        
         
        
        // let qty = $("#qty").val();
        let discount = parseFloat($("#discount").val() ||0 ).toFixed(2);
        let tax = parseFloat($("#tax").val() ||0 ).toFixed(2);
        let shipping = parseFloat($("#shipping").val() ||0 );

 
        let n = $("input[name^='products']").length;
        let price = 0;
        let qty = 0;
         $("input[name^='products']").each(function (index, val) {
             var id = this.id;
            //  console.log(index, id);
           
             var id_loop = id;
             if (id.includes("cart_product_code")) {
                 var product_input_id = parseInt(id_loop);

                 let current_qty = parseFloat(
                     $("#cart_product_qty_" + product_input_id).val()
                 );
                 let single_price = parseFloat(
                     $("#cart_product_price_" + product_input_id).text()
                     ||0);

                     var productStatus = $('input[name="products['+parseInt(id_loop)+'][product_status]"]:checked').val();;
                    //  console.log(productStatus);
                     if(productStatus == 'E' || productStatus == 'D' ){
                        current_qty = 0;
                        single_price = 0;
                     }else{
                        var product_sub_total_price =
                     single_price * parseFloat(current_qty||1);

                 price += product_sub_total_price;
                 qty += current_qty;

                     }
                 
             }
         });
    

       
 
         var total_amount = price-discount;
         
         var subtotal = price;
         let tax_amount = 0;
         if(parseInt(tax) > 0)
          tax_amount = parseFloat((subtotal/100)*tax);
        //  console.log(typeof(tax_amount),typeof(total_amount) , typeof(discount) , typeof(shipping)  ,typeof(paid_amount));
       
         let remaining_amount=  (total_amount +tax_amount + shipping - (paid_amount||0));
         $("#remaining_amount").val(parseFloat(remaining_amount || 0).toFixed(2));
        $("#total_product_view").text(qty);
         $("#total").text(total_amount +tax_amount + shipping);
         $("#total_").text(total_amount +tax_amount + shipping);
         $("#grand_view").text((total_amount +tax_amount + shipping).toFixed(2));
        $("#show_shipping").text(shipping);

         $("#show_discount").text(discount);
         $("#remaining").text(remaining_amount.toFixed(2));
         $("#paid_view").text(paid_amount);

         
       
         $("#tax_view").text(tax_amount.toFixed(2));
         $("#sub_total").text(subtotal);
        
        
 
 
 
 
     }

 
     function updateProductSubTotal(id,qty){
        let  price = parseFloat($("#cart_product_price_"+id).text() ) * parseFloat(qty);
        $("#sub_total_product_prices"+id).text(price.toFixed(2));
     }
      


     function addProductQty(id){
        let  actual_qty = $("#original_stock_product"+id).val();
        let current_qty = $("#cart_product_qty_"+id).val();
        qty = parseFloat(current_qty) + 1;

        remaining_qty = parseFloat(actual_qty)-qty;
        // console.log(actual_qty);
        // console.log(qty);
        let current_product_type = $("#product_type"+id).attr('rel');
        if(current_product_type == 1){
            if(remaining_qty >= 0){
                $("#cart_product_qty_"+id).val(qty);
                updateProductSubTotal(id,qty)
                posCalcualtePrice();
                $("#stock_product"+id).text(remaining_qty);
            }else{
                $("#cart_product_qty_"+id).val(parseFloat(actual_qty));
                $("#stock_product"+id).text(0);
            }
    
        }
        else{

            if(current_qty >= 0){
                $("#cart_product_qty_"+id).val(qty);
                updateProductSubTotal(id,qty)
                posCalcualtePrice();
                
            }else{
                $("#cart_product_qty_"+id).val(parseFloat(1));
            }
            

        }

        
     }

     function minusProductQty(id){

        let  actual_qty = $("#original_stock_product"+id).val();
        let current_qty = $("#cart_product_qty_"+id).val();
       
       
        let current_product_type = $("#product_type"+id).attr('rel');
        if(current_product_type == 1){

        if(current_qty > 1){
            qty = parseFloat(current_qty) - 1;
            remaining_qty = parseFloat(actual_qty)-parseFloat(qty);
      
            $("#cart_product_qty_"+id).val(qty);
            updateProductSubTotal(id,qty)
            posCalcualtePrice();
            $("#stock_product"+id).text(remaining_qty);
        }
        }

        else{
            qty = parseFloat(current_qty) - 1;
            if(qty < 1){
                qty = 1;
            }
            $("#cart_product_qty_"+id).val(qty);
            updateProductSubTotal(id,qty)
            posCalcualtePrice();

        }
     }
     function ManualUpdate(id){
        let  actual_qty = $("#original_stock_product"+id).val();
        let current_qty = $("#cart_product_qty_"+id).val();
        let current_product_type = $("#product_type"+id).attr('rel');

        if(current_product_type == 1){

            if(current_qty > 0){

                remaining_qty = parseFloat(actual_qty)-parseFloat(current_qty);
            
                if(remaining_qty >= 0){
                    $("#cart_product_qty_"+id).val(current_qty);
                    updateProductSubTotal(id,current_qty)
                    posCalcualtePrice();
                    $("#stock_product"+id).text(remaining_qty);
                }else{
                    $("#cart_product_qty_"+id).val(parseFloat(actual_qty));
                    $("#stock_product"+id).text(0);
                }
    
            }
            else{
                $("#cart_product_qty_"+id).val(1);
                let current_qty = $("#cart_product_qty_"+id).val();
                remaining_qty = parseFloat(actual_qty)-parseFloat(current_qty);
                updateProductSubTotal(id,current_qty)
                    posCalcualtePrice();
                    $("#stock_product"+id).text(remaining_qty);
            }
            

        }
        else{


            if(current_qty > 0){

                
            
                
                    $("#cart_product_qty_"+id).val(current_qty);
                    updateProductSubTotal(id,current_qty)
                    posCalcualtePrice();
                   
    
            }
            else{
                $("#cart_product_qty_"+id).val(1);
                let current_qty = $("#cart_product_qty_"+id).val();
                updateProductSubTotal(id,current_qty)
                    posCalcualtePrice();
                   
            }


        }
        
        
        
     }


     
    document.addEventListener('keyup', function(event) {
        if (event.target && event.target.id === 'tax' || event.target && event.target.id === 'shipping' || event.target && event.target.id === 'discount' ) {
           posCalcualtePrice();
        }
        else{
            product_id  = event.target.id;
            parts = product_id.split('_');
            if(event.target && event.target.id === 'cart_product_qty_'+parts[3]){
                // console.log(parts[3]);

                ManualUpdate(parts[3]);
            }
            
        }
        
    });

    
     function removeCartRow(id) {

        let current_qty = $("#cart_product_qty_"+id).val();
        let current_stock = $("#stock_product"+id).text();
        stock = parseFloat(current_qty) + parseFloat(current_stock);
        $("#stock_product"+id).text(stock);

        $("#setting-row"+id).remove();
        posCalcualtePrice();
     }

       function removeSetting(id) {

           $("#"+id).remove();
           allproducts  = [];
           $("input[name^='products']").each(function (index,val) {
            var id = this.id;
            if(id.includes('qty')){
                var row_id = parseInt(id);
                product_id =  $("#"+row_id+"-product_id").val();
                allproducts.push(product_id);
            }
         });

         totalrows = $(".setting > .setting-row").length;
            totalrecord = $('.totalrecord-settings').length;
         var div = $(".setting > .setting-row:last");
         FirstRowId = div.attr('id');
        //  console.log(FirstRowId);
         lastRow = FirstRowId.split("setting-row");



         $.ajax({

            type: 'get',

            url: '/update-products',

            data: {"products":allproducts },
            dataType: 'html',

            success: function (data) {
                // console.log(data);

                var last_product_id = $("#" + parseInt(lastRow[1])+ "-product_id").val();

               $("#" + lastRow[1]+ "-product_id").html(data)


               $("#" + parseInt(lastRow[1])+ "-product_id").val(last_product_id).click();
            //    $("#mydropdownlist").val("thevalue").change();


              calcualtePrice();
            }
          })





       }


           //  Get Productions
           $("#FormData").submit(function (event) {

            event.preventDefault();

               $.ajaxSetup({
                   headers: {
                       "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                           "content"
                       ),
                   },
               });
               FormData = $("#FormData").serialize();
               $.ajax({
                   type: "POST",
                   url: '/customer',
                   data: FormData,
                   success: function (data) {
                    dropdownElement = $("#user_id");
                    dropdownElement.find('option[value='+data.data.id+']').remove();

                    var updateOptionPP = '<option value='+data.data.id+' selected>'+data.data.name+'</option>';
                    $("#user_id").append(updateOptionPP)

                    $("#add_customer").modal('hide');
                    $("#FormData")[0].reset();
                   },
               });
           });

                      //  Get Productions
                      $("#FormDataVendor").submit(function (event) {

                        event.preventDefault();

                           $.ajaxSetup({
                               headers: {
                                   "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                       "content"
                                   ),
                               },
                           });
                           FormData = $("#FormDataVendor").serialize();
                           $.ajax({
                               type: "POST",
                               url: '/vendor',
                               data: FormData,
                               success: function (data) {
                                dropdownElement = $("#user_id");
                                dropdownElement.find('option[value='+data.data.id+']').remove();

                                var updateOptionPP = '<option value='+data.data.id+' selected>'+data.data.name+'</option>';
                                $("#user_id").append(updateOptionPP)

                                $("#add_vendor").modal('hide');
                               },
                           });
                       });


                            $("#FormDataCustomer").submit(function (event) {
                                event.preventDefault();

                                $.ajaxSetup({
                                    headers: {
                                        "X-CSRF-TOKEN": $(
                                            'meta[name="csrf-token"]'
                                        ).attr("content"),
                                    },
                                });
                                // FormData = $("#FormDataCustomer").serialize();
                                var formElement =
                                    document.getElementById("FormDataCustomer");
                                var formData = new FormData(formElement);
                                formData.append("user_type", "customer");
                                formData.append("password", "password");
                                $.ajax({
                                    type: "POST",
                                    url: "/customer",
                                    data: formData,
                                    processData: false, // Important: Prevents jQuery from processing data as a query string
                                    contentType: false,
                                    success: function (data) {
                                        dropdownElement = $("#user_id");
                                        dropdownElement
                                            .find(
                                                "option[value=" +
                                                    data.data.id +
                                                    "]"
                                            )
                                            .remove();

                                        var updateOptionPP =
                                            "<option value=" +
                                            data.data.id +
                                            " selected>" +
                                            data.data.name +
                                            "</option>";
                                        $("#user_id").append(updateOptionPP);

                                        $("#add_customer").modal("hide");
                                    },
                                });
                            });


//  Change form id and calculation ids with their default values


// print function for pos

function printInvoice() {
    window.print();
}

function getAmount(type)
{
    
    
    var admin_id = $("#user_id").val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    let customer = '';
    if(type == 'customer'){
        customer = 'customer';
    }
    else if(type == 'vendor'){
        customer = 'vendor';
    }
    if(parseInt(admin_id) > 0){
        
    $.ajax({
        type: "get",
        url: `/${customer}-amount/${admin_id}`,
        success: function(data) {
            if (data.price > 0 || data.price < 0 ) {
            $('#customer_amount').addClass(data.addClass).html(data.price+' '+data.message);        
            }else{
                $('#customer_amount').html(data.currency+data.price+' '+data.message);        
            }
        }
    });
    }else{
        $('#customer_amount').html('');        
    }
}

