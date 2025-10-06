$(function(){
    $(document).on('click', '.add_more', function(){
          let html = `<div class="row property-row mt-2">
                          <div class="col-md-4">
                              <input type="text" name="property_name[]" class="form-control" placeholder="Property Name">
                          </div>
                          <div class="col-md-4">
                              <input type="text" name="property_value[]" class="form-control" placeholder="Property Value">
                          </div>
                          <div class="col-md-4">
                              <button type="button" class="btn btn-danger remove_row">Remove</button>
                          </div>
                      </div>`;
          $('#employee_properties').append(html);
      });
  
      // Remove row
      $(document).on('click', '.remove_row', function(){
          $(this).closest('.property-row').remove();
      });
  
      $("#employee_add").submit(function(e){
          e.preventDefault();
          let formData = new FormData(this);
  
          $.ajax({
              url: "/employee/store",
              type: "POST",
              data: formData,
              dataType: "json",
              contentType: false,
              processData: false,
              success: function(response){
                  if(response.status == "error"){
                      $("#name_error").text(response.errors.name ?? "");
                      $("#email_error").text(response.errors.email ?? "");
                      $("#position_error").text(response.errors.position ?? "");
                  }
                  else if(response.status == "success"){
                      window.location.href = response.redirect;
                  }
              }
          });
      });
  });
  