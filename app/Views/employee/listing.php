<!doctype html>
<html>
  <head>
  <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Codeigniter 4 CRUD Tutorial</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <div class="d-flex justify-content-end">
        <a href="<?php echo site_url('/employee/create') ?>" class="btn btn-success mb-2">Add Employee</a>
    </div>
    <?php if(session()->getFlashdata('success')): ?>
    <div style="color: green;"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

  <div class="mt-3">
     <table class="table table-bordered">
       <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Position</th>
          </tr>
       </thead>
       <tbody>
          <?php if(count($employee)){ ?>
          <?php foreach($employee as $single_emp){ ?>
          <tr>
             <td><?php echo $single_emp['name']; ?></td>
             <td><?php echo $single_emp['email']; ?></td>
            <td><?php echo $single_emp['position']; ?></td>
             <td>
              <a href="<?php echo base_url('employee/edit/'.$single_emp['id']);?>" class="btn btn-primary btn-sm">Edit</a>
              <a href="#" class="btn btn-primary btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#editModal" data-id="<?= $single_emp['id'] ?>">Edit using popup</a>
              <a href="<?php echo base_url('employee/delete/'.$single_emp['id']);?>" class="btn btn-danger btn-sm">Delete</a>
              </td>
          </tr>
         <?php } ?>
         <?php } ?>
       </tbody>
       <?= $pager->links() ?>

     </table>
  </div>
</div>
 
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm">
                <div class="modal-body">
                    <input type="hidden" name="id" id="emp-id">
                    <div class="mb-3">
                        <label for="emp-name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="emp-name" name="name">
                        <div class="text-danger" id="name_error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="emp-email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="emp-email" name="email">
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

</body>
</html>
<style>
.pagination li a
{
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    // When an edit button is clicked, fetch the record data
    $('.edit-btn').on('click', function() {
        var id = $(this).data('id');

        $.ajax({
            url: '<?= base_url('employee/getRecord') ?>/' + id,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response) {
                    $('#emp-id').val(response.id);
                    $('#emp-name').val(response.name);
                    $('#emp-email').val(response.email);
                    $('#emp-position').val(response.position);
                }
            }
        });
    });

    // Handle form submission via AJAX
    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        var id = $('#emp-id').val();

        $.ajax({
            url: "/employee/update/"+$("#emp-id").val(),
            type: "POST",
            data: formData,
            success: function(response) {
                if(response.status == "error"){
                    $('.text-danger').html(''); // Clear previous errors
                    $.each(response.errors, function(key, value) {
                        $('#' + key + '_error').html(value);
                    });
                }
                else if(response.status == "success"){
                    alert('Record updated successfully!');
                    $('#editModal').modal('hide');
                    window.location.href = response.redirect;

                }
            },
            error: function() {
                alert('An error occurred.');
            }
        });
    });
});
</script>

</body>
</html>