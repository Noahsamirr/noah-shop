$( document ).ready(function() {
            document.getElementById("productType").selectedIndex = 0;
        });
      //to switch between the dvd,book and furniture inputs 
      $(function() {
          $('#productType').change(function(){
            var type= $(this).val();
            $("form").find( "div.type").css( 'display', 'none');
            $("form").find( "div#"+type).css( 'display', 'block');
           });
    });

      function validateInput(data){
        let valid = true;
        if (data.price === "" || data.sku === "" || data.name === "" || data.type === 0) {
          valid = false;
        }

        switch (data.type) {
          case 'dvd':
            if (data.size === "") valid = false;
            break;
          case 'book':
            if (data.weight === "") valid = false;
            break;
          case 'furniture':
            if (data.height === "" || data.width === "" || data.length === "") valid = false;
            break;
            default : valid = false;
        }

        return valid;
      }

      function appendAlert() {
        $('#unique').remove();
        $('.alert').remove();
        $('#div').prepend("<div class=\"alert alert-dark mt-3\" role=\"alert\">\n" +
            "  Please, submit required data.\n" +
            "</div>");
      
      }

      function appendUniuqenessAlert() {
        $('#unique').remove();
        $('.alert').remove();

          console.log('1');
          $('#div').prepend("<div id=\"unique\" class=\"alert alert-dark unique mt-3\" role=\"alert\">\n" +
              "  Sku should be a unique number.\n" +
              "</div>"
          );
        } 


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

          if (!validateInput(data)) {
            appendAlert();
            return;
          }

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
                appendAlert();
              }else if(jqXHR.status == 503){
                //sku duplication alert
                appendUniuqenessAlert();
              }
          });
      });
      //cancel button transition to index
      $('#to-index').click(function(e){
         e.preventDefault();
         window.location.href= "../index.html";
      });
