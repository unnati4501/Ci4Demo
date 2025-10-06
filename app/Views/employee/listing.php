<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employee List | CodeIgniter 4</title>
  
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8f9fa;
    }
    .container {
      margin-top: 40px;
    }
    table th, table td {
      vertical-align: middle !important;
    }
    .pagination li a {
      position: relative;
      display: block;
      padding: .5rem .75rem;
      margin-left: -1px;
      line-height: 1.25;
      color: #007bff;
      background-color: #fff;
      border: 1px solid #dee2e6;
    }
    .pagination li.active a {
      z-index: 1;
      color: #fff;
      background-color: #007bff;
      border-color: #007bff;
    }
  </style>
</head>
<body>
<div class="container">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Employee List</h2>
    <a href="<?= site_url('/employee/create') ?>" class="btn btn-success">+ Add Employee</a>
  </div>

  <?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
  <?php endif; ?>

  <?php if(!empty($employee) && count($employee) > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Position</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($employee as $index => $single_emp): ?>
            <tr>
              <td><?= $index + 1 ?></td>
              <td><?= esc($single_emp['name']) ?></td>
              <td><?= esc($single_emp['email']) ?></td>
              <td><?= esc($single_emp['position']) ?></td>
              <td>
              <a href="<?php echo base_url('employee/edit/'.$single_emp['id']);?>" class="btn btn-primary btn-sm">Edit</a>

                <button class="btn btn-primary btn-sm edit-btn" 
                        data-bs-toggle="modal" data-bs-target="#editModal" 
                        data-id="<?= $single_emp['id'] ?>">Edit</button>
                <a href="<?= base_url('employee/delete/'.$single_emp['id']);?>" 
                   class="btn btn-danger btn-sm" 
                   onclick="return confirm('Are you sure to delete this employee?');">Delete</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <?= $pager->links() ?>

  <?php else: ?>
    <div class="alert alert-info text-center">
      No employees found. <a href="<?= site_url('/employee/create') ?>">Add one now</a>.
    </div>
  <?php endif; ?>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editForm">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Employee</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="id" id="emp-id">
          <div class="mb-3">
            <label for="emp-name" class="form-label">Name</label>
            <input type="text" class="form-control" id="emp-name" name="name">
            <div class="text-danger" id="name_error"></div>
          </div>
          <div class="mb-3">
            <label for="emp-email" class="form-label">Email</label>
            <input type="email" class="form-control" id="emp-email" name="email">
            <div class="text-danger" id="email_error"></div>
          </div>
          <div class="mb-3">
            <label for="emp-position" class="form-label">Position</label>
            <input type="text" class="form-control" id="emp-position" name="position">
            <div class="text-danger" id="position_error"></div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Bootstrap JS Bundle + jQuery -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    // Fetch record for edit
    $('.edit-btn').on('click', function() {
        var id = $(this).data('id');
        $.ajax({
            url: '<?= base_url('employee/getRecord') ?>/' + id,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if(response) {
                    $('#emp-id').val(response.id);
                    $('#emp-name').val(response.name);
                    $('#emp-email').val(response.email);
                    $('#emp-position').val(response.position);
                }
            }
        });
    });

    // Submit edit form via AJAX
    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        $('.text-danger').html('');
        var formData = $(this).serialize();
        var id = $('#emp-id').val();

        $.ajax({
            url: "<?= base_url('employee/update/') ?>" + id,
            type: "POST",
            data: formData,
            dataType: 'json',
            success: function(response) {
                if(response.status == "error") {
                    $.each(response.errors, function(key, val){
                        $('#' + key + '_error').html(val);
                    });
                } else if(response.status == "success") {
                    alert('Employee updated successfully!');
                    $('#editModal').modal('hide');
                    location.reload();
                }
            },
            error: function() {
                alert('An error occurred. Please try again.');
            }
        });
    });
});
</script>
</body>
</html>
