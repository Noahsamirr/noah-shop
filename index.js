$(document).ready(function(){
        //jquery get request to get products 
        $.get("https://noah-shop.herokuapp.com/api/controllers/ProductsController.php", function(data){
         //data.records is the array
         arr = data.records;
          $.each(arr,function(index,value){
            var type = value.type;
            $("#home").append(`<div id="card" class="card border-secondary col-4 mt-2" style="max-width: 18rem; display: inline-block;">
                                      <div class="card-body text-secondary text-center">
                                          <div class="form-check">
                                              <input class="form-check-input delete-checkbox" name="delete" type="checkbox" value=${value.sku} id="delete">
                                          </div>
                                        <h5 class="card-name">${value.name}</h5>
                                        <p class="card-SKU">${value.sku}</p>
                                        <p class="card-price" >${value.price} $</p>
                                        <p class="card-data type"  id="${value.type}">${value.specialData}</p>

                                        </div>
                               </div>
                               `);

                               
            
          });
          
            //mass delete button event listener
          $("#delete_product_btn").click(function(e){
              e.preventDefault();
            var del = $('input[name="delete"]:checked');
            var delarr = [];
            del.each(function(){
                delarr.push($(this).val());
            });
            //array to items to delete
            var data = { "items":delarr};
              var ajaxRequest = $.ajax({
                  type: "DELETE",
                  url: "https://noah-shop.herokuapp.com/api/controllers/ProductsController.php",
                  data: JSON.stringify(data),
                  contentType: "application/x-www-form-urlencoded; charset=utf-8",
                  dataType: "json"});

              //When the request successfully finished, execute passed in function
              ajaxRequest.done(function(msg){
                  window.location.href= "index.html";
              });

              //When the request failed, execute the passed in function
              ajaxRequest.fail(function(jqXHR, status){
                  console.log('error')
              });

          });
        });
      });
