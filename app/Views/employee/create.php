<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add New Employee | CodeIgniter 4</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <style>
    body {
      background-color: #f8f9fa;
    }
    .container {
      max-width: 800px;
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      margin-bottom: 25px;
    }
    .form-group span {
      font-size: 0.9rem;
      color: red;
    }
    .property-row {
      align-items: center;
    }
  </style>
</head>

<body>
  <div class="container mt-5">
    <h2>Add New Employee</h2>

    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?php if (isset($validation)): ?>
      <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
    <?php endif; ?>

    <form id="employee_add" method="post" enctype="multipart/form-data" novalidate>

      <!-- Name -->
      <div class="form-group">
        <label for="name">Employee Name</label>
        <input type="text" name="name" id="name" class="form-control" placeholder="Enter employee name">
        <span id="name_error"></span>
      </div>

      <!-- Email -->
      <div class="form-group">
        <label for="email">Employee Email</label>
        <input type="email" name="email" id="email" class="form-control" placeholder="Enter employee email">
        <span id="email_error"></span>
      </div>

      <!-- Position -->
      <div class="form-group">
        <label for="position">Position</label>
        <input type="text" name="position" id="position" class="form-control" placeholder="Enter position">
        <span id="position_error"></span>
      </div>

      <!-- Images -->
      <div class="form-group">
        <label>Employee Images</label>
        <input type="file" name="images[]" id="images" class="form-control-file" multiple>
        <span id="image_error"></span>
      </div>

      <!-- Dynamic Properties -->
      <h5 class="mt-4">Employee Properties</h5>
      <div id="employee_properties">
        <div class="row property-row mt-2">
          <div class="col-md-5">
            <input type="text" name="property_name[]" class="form-control" placeholder="Property Name">
          </div>
          <div class="col-md-5">
            <input type="text" name="property_value[]" class="form-control" placeholder="Property Value">
          </div>
          <div class="col-md-2 text-center">
            <button type="button" class="btn btn-success add_more">+</button>
          </div>
        </div>
      </div>

      <!-- Submit -->
      <div class="form-group mt-4">
        <button type="submit" id="add_employee_btn" class="btn btn-primary btn-block">Save Employee</button>
      </div>

      <p id="success_message" class="text-success text-center"></p>

    </form>
  </div>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?= base_url('assets/js/employee-properties.js') ?>"></script>

