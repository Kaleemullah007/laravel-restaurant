// Initiate an Ajax request on button click
$(document).on("click", "button", function(){
    // Adding timestamp to set cache false
    $.get("/examples/php/customers.php?v="+ $.now(), function(data){
        $("body").html(data);
    });
});

// Add remove loading class on body element depending on Ajax request status
$(document).on({
    ajaxStart: function(){
        $("#loading").css({"display":"inline-block"});
    },
    ajaxStop: function(){
         $("#loading").css("display","none");
    }
});

$(document).ready(function () {
    $("#loading").css("display","none");
       });
