<!DOCTYPE html>
<html>
<head>
  <title>Codeigniter 4 : Update Employee</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <form method="post" id="employee_update" name="employee_update" enctype="multipart/form-data">
    <input type = "hidden" id="empId" value="<?php echo $employee['id']; ?>">
    <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" value="<?php echo $employee['name']; ?>" class="form-control">
        <span id="name_error" style="color:red;"></span><br>
    </div>
    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="<?php echo $employee['email']; ?>" class="form-control">
        <span id="email_error" style="color:red;"></span><br>

    </div>
    <div class="form-group">
        <label>Position</label>
        <input type="text" name="position" value="<?php echo $employee['position']; ?>" class="form-control">
        <span id="position_error" style="color:red;"></span><br>

    </div>
    <div class="form-group">
        <div id="existing_images">
            <?php foreach($images as $img): ?>
            <div class="image-wrapper" data-id="<?= $img['id'] ?>">
                <img src="<?= base_url('uploads/employees/'.$img['image']) ?>" width="100">
                <button type="button" class="delete-image" data-id="<?= $img['id'] ?>">Delete</button>
            </div>
            <?php endforeach; ?>
        </div>
        <!-- Upload new images -->
        <input type="file" name="images[]" multiple><br>
    </div>

    <div class="employee_properties">
    <?php if(!empty($properties)): ?>
        <?php foreach($properties as $prop): ?>
        <div class="row property-row mt-2">
            <div class="col-mt-2">
                <input type="text" name="property_name[]" class="form-control" placeholder="Property Name" value="<?= $prop['property_name'] ?>">
            </div>
            <div class="col-mt-2">
                <input type="text" name="property_value[]" class="form-control" placeholder="Property Value" value="<?= $prop['property_value'] ?>">
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

    <div class="form-group">
        <button type="submit" class="btn btn-primary btn-block">Update</button>
    </div>
</form>
</div>
</body>

</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
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

    $(".delete-image").click(function(){
        if(!confirm("Delete this image?")) return;
        let id = $(this).data("id");
        let wrapper = $(this).closest(".image-wrapper");

        $.ajax({
            url: "/employee/deleteImage/"+id,
            type: "POST",
            dataType: "json",
            success: function(res){
                if(res.status === "success"){
                    wrapper.remove();
                }
            }
        });
    });

    $("#employee_update").submit(function(e){
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: "/employee/update/"+$("#empId").val(),
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
</script>
