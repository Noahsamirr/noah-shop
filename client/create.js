
      //to switch between the dvd,book and furniture inputs 
      $(function() {
        $('#productType').change(function(){
          var type= $(this).val();
          $("form").find( "div.type").css( 'display', 'none');
          $("form").find( "div#"+type).css( 'display', 'block');
         });
  });




    $('#submit-form').click(function(e) {
        //to prevent form default action
          e.preventDefault();
        //data object from the form
        var data = {
            price: $("input[id=price]").val(),
            sku: $("input[id=sku]").val(),
            name: $("input[id=name]").val(),
            type: $("select[id=productType]").val(),
            size: $("input[id=size]").val(),
            height: $("input[id=height]").val(),
            width: $("input[id=width]").val(),
            length: $("input[id=length]").val(),
            weight: $("input[id=weight]").val()
        };
        //post request to create product using ajax
        var ajaxRequest = $.ajax({
            type: "POST",
            url: "https://noah-shop.herokuapp.com/api/controllers/ProductsController.php",
            data: JSON.stringify(data),
            contentType: "application/x-www-form-urlencoded; charset=utf-8",
            dataType: "json"});

        //When the request successfully finished, execute passed in function
        ajaxRequest.done(function(msg){
            window.location.href= "../index.html";
        });

        //When the request failed, execute the passed in function
        ajaxRequest.fail(function(jqXHR, status){

            if(jqXHR.status == 400)
            {
              //no data submited alert
            // if the data equals an empty string or 0 print alert status
            if(jqXHR.responseText.length == 0 || jqXHR.responseText.charAt(0) == ' ') return false;
                $('#div').prepend("<div class=\"alert alert-dark mt-3\" role=\"alert\">" +
                    "  Please, submit required data." +
                    "</div>");

            }else if(jqXHR.status == 503){
              //sku duplication alert
                $('#div').prepend("<div class=\"alert alert-dark mt-3\" role=\"alert\">" +
                    "  Sku should be a unique number.\n" +
                    "</div>");
            }
        });
    });
    //cancel button transition to index
    $('#to-index').click(function(e){
       e.preventDefault();
       window.location.href= "../index.html";
    });