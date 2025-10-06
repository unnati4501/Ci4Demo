<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Employee | CodeIgniter 4</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/css/employee.css') ?>">
</head>
<body>
<div class="container mt-5">
  <h2 class="mb-4">Update Employee</h2>

  <form id="employee_update" enctype="multipart/form-data">
    <input type="hidden" id="empId" value="<?= $employee['id'] ?>">

    <div class="form-group mb-3">
      <label>Name</label>
      <input type="text" name="name" value="<?= esc($employee['name']) ?>" class="form-control">
      <span id="name_error" class="text-danger"></span>
    </div>

    <div class="form-group mb-3">
      <label>Email</label>
      <input type="email" name="email" value="<?= esc($employee['email']) ?>" class="form-control">
      <span id="email_error" class="text-danger"></span>
    </div>

    <div class="form-group mb-3">
      <label>Position</label>
      <input type="text" name="position" value="<?= esc($employee['position']) ?>" class="form-control">
      <span id="position_error" class="text-danger"></span>
    </div>

    <div class="form-group mb-3">
      <label>Existing Images</label>
      <div id="existing_images">
        <?php foreach($images as $img): ?>
        <div class="image-wrapper" data-id="<?= $img['id'] ?>">
          <img src="<?= base_url('uploads/employees/'.$img['image']) ?>" alt="Employee Image">
          <button type="button" class="btn btn-sm btn-danger delete-image" data-id="<?= $img['id'] ?>">×</button>
        </div>
        <?php endforeach; ?>
      </div>
      <input type="file" name="images[]" multiple class="form-control mt-2">
    </div>

    <h5>Properties</h5>
    <div id="employee_properties">
      <?php if(!empty($properties)): ?>
        <?php foreach($properties as $prop): ?>
        <div class="row property-row mt-2">
          <div class="col-md-4">
            <input type="text" name="property_name[]" class="form-control" placeholder="Property Name" value="<?= esc($prop['property_name']) ?>">
          </div>
          <div class="col-md-4">
            <input type="text" name="property_value[]" class="form-control" placeholder="Property Value" value="<?= esc($prop['property_value']) ?>">
          </div>
          <div class="col-md-4">
            <button type="button" class="btn btn-danger remove_row">Remove</button>
          </div>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="row property-row mt-2">
          <div class="col-md-4">
            <input type="text" name="property_name[]" class="form-control" placeholder="Property Name">
          </div>
          <div class="col-md-4">
            <input type="text" name="property_value[]" class="form-control" placeholder="Property Value">
          </div>
          <div class="col-md-4">
            <button type="button" class="btn btn-success add_more">Add More</button>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <div class="form-group mt-4">
      <button type="submit" class="btn btn-primary btn-block">Update Employee</button>
    </div>
  </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function(){
    // Add more properties
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

    // Remove property row
    $(document).on('click', '.remove_row', function(){
        $(this).closest('.property-row').remove();
    });

    // Delete existing image
    $(document).on('click', '.delete-image', function(){
        if(!confirm("Delete this image?")) return;
        let id = $(this).data("id");
        let wrapper = $(this).closest(".image-wrapper");

        $.ajax({
            url: "/employee/deleteImage/" + id,
            type: "POST",
            dataType: "json",
            success: function(res){
                if(res.status === "success"){
                    wrapper.remove();
                } else {
                    alert(res.message || "Failed to delete image");
                }
            }
        });
    });

    // Submit form via AJAX
    $("#employee_update").submit(function(e){
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: "/employee/update/" + $("#empId").val(),
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
                } else if(response.status == "success"){
                    window.location.href = response.redirect;
                }
            },
            error: function(){
                alert("Something went wrong. Please try again.");
            }
        });
    });
});
</script>
</body>
</html>
