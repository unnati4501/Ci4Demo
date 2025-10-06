<!DOCTYPE html>
<html>
<head>
  <title>Codeigniter 4 : Add New Employee</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<?php if(isset($validation)): ?>
    <div style="color:red;">
        <?= $validation->listErrors() ?>
    </div>
<?php endif; ?>

<body>
  <div class="container mt-5">
    <form method="post" id="employee_add" name="employee_add" enctype="multipart/form-data"
     nonvalidate>
      <div class="form-group">
        <label>Employee Name</label>
        <input type="text" name="name" class="form-control">
        <span id="name_error" style="color:red;"></span><br>
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="text" name="email" class="form-control">
        <span id="email_error" style="color:red;"></span><br>

      </div>
      <div class="form-group">
        <label>Position</label>
        <input type="text" name="position" class="form-control">
        <span id="position_error" style="color:red;"></span><br>

      </div>
      <div class="form-group">
        <label>Images</label> 
        <input type="file" name="images[]" multiple><br>
        <span id="image_error" style="color:red;"></span><br>
      </div>

      <h5>Properties</h5>
    <div id="employee_properties">
        <?php if(!empty($properties)): ?>
            <?php foreach($properties as $prop): ?>
            <div class="row property-row mt-2">
                <div class="col-md-4">
                    <input type="text" name="property_name[]" class="form-control" placeholder="Property Name" value="<?= $prop['property_name'] ?>">
                </div>
                <div class="col-md-4">
                    <input type="text" name="property_value[]" class="form-control" placeholder="Property Value" value="<?= $prop['property_value'] ?>">
                </div>
                <div class="col-md-4">
                    <!-- First row has Add More, others Remove -->
                    <?php //if($index == count($properties)-1): ?>
                        <button type="button" class="btn btn-success add_more">Add More</button>
                        <?php //if(count($properties) > 1): ?>
                            <button type="button" class="btn btn-danger remove_row">Remove</button>
                        <?php //endif; ?>
                   
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
        <button type="submit" id="add_employee_btn" class="btn btn-primary btn-block">Store</button>
      </div>
    </form>
    <p id="success_message" style="color:green;"></p>

  </div>
   
</body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?= base_url('assets/js/employee-properties.js') ?>"></script>
