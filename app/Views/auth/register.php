<!DOCTYPE html>
<html>
<head>
  <title>Codeigniter 4 : Register</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
  <div class="container mt-5">
    <form method="post" id="register" name="register" enctype="multipart/form-data"
     nonvalidate>
      <div class="form-group">
        <label>User Name</label>
        <input type="text" name="username" class="form-control">
        <div class="invalid-feedback error" id="username_error"></div>
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="text" name="email" class="form-control">
        <div class="invalid-feedback error" id="email_error"></div>

      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="text" name="password" class="form-control">
        <div class="invalid-feedback error"></div>

      </div>
      <div class="form-group">
        <label>Confirm Password</label>
        <input type="text" name="confirm_password" class="form-control">
        <div class="invalid-feedback error"></div>

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
<script>
    $(document).ready(function() {

    $("#register").submit(function(e){
        e.preventDefault();

        $('#register input').removeClass('is-invalid');
        $('#register .invalid-feedback').text('');


        let formData = new FormData(this);

        $.ajax({
            url: "/register",
            type: "POST",
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function(response){
                if(response.status == "error"){
                    $.each(response.errors, function(field, message) {
                        let input = $('[name="' + field + '"]');
                        input.addClass('is-invalid');
                        input.next('.invalid-feedback').text(message);
                    });
                }
                else if(response.status == "success"){
                    window.location.href = response.redirect;
                }
            }
        });
    });
});
</script>
