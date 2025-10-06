<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Registration | MyApp</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: #f4f7fa;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .form-control.is-invalid {
      border-color: #dc3545 !important;
    }

    .btn-primary {
      background-color: #007bff;
      border: none;
    }

    .btn-primary:hover {
      background-color: #0069d9;
    }

    #success_message {
      text-align: center;
      font-weight: 500;
      color: green;
      margin-top: 10px;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="col-md-6 col-lg-5 mx-auto">
      <div class="card p-4">
        <h4 class="text-center mb-4">Create Your Account</h4>

        <form id="register" method="post" enctype="multipart/form-data" novalidate>
          <div class="mb-3">
            <label class="form-label">User Name</label>
            <input type="text" name="username" class="form-control" placeholder="Enter your username">
            <div class="invalid-feedback error" id="username_error"></div>
          </div>

          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder="Enter your email">
            <div class="invalid-feedback error" id="email_error"></div>
          </div>

          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter a strong password">
            <div class="invalid-feedback error" id="password_error"></div>
          </div>

          <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control" placeholder="Re-enter your password">
            <div class="invalid-feedback error" id="confirm_password_error"></div>
          </div>

          <button type="submit" id="register_btn" class="btn btn-primary w-100 py-2">Register</button>

          <p class="text-center mt-3 mb-0">
            Already have an account?
            <a href="/login" class="text-decoration-none">Login here</a>
          </p>
        </form>

        <p id="success_message"></p>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(function() {
      $("#register").submit(function(e) {
        e.preventDefault();

        // Reset previous errors
        $('#register input').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        $('#success_message').text('');

        let formData = new FormData(this);

        $.ajax({
          url: "/register",
          type: "POST",
          data: formData,
          dataType: "json",
          contentType: false,
          processData: false,
          beforeSend: function() {
            $('#register_btn').prop('disabled', true).text('Registering...');
          },
          success: function(response) {
            $('#register_btn').prop('disabled', false).text('Register');

            if (response.status === "error") {
              $.each(response.errors, function(field, message) {
                let input = $('[name="' + field + '"]');
                input.addClass('is-invalid');
                input.next('.invalid-feedback').text(message);
              });
            }
            else if (response.status === "success") {
              $('#success_message').text(response.message);
              setTimeout(() => {
                window.location.href = response.redirect;
              }, 1500);
            }
            else if (response.status === "fail") {
              $('#success_message').css('color', 'red').text(response.message);
            }
          },
          error: function() {
            $('#register_btn').prop('disabled', false).text('Register');
            alert('Something went wrong. Please try again.');
          }
        });
      });
    });
  </script>
</body>
</html>
