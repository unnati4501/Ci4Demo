<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - MyApp</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
  <style>
    body {
      background: #f7f9fc;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }
    .login-card {
      max-width: 400px;
      width: 100%;
      background: #fff;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
    .login-card h4 {
      text-align: center;
      margin-bottom: 1.5rem;
      color: #333;
    }
    .form-control:focus {
      border-color: #0d6efd;
      box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.25);
    }
    .invalid-feedback {
      display: block;
    }
  </style>
</head>

<body>
  <div class="login-card">
    <h4>Login</h4>
    <form id="loginForm" method="post">
      <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" placeholder="Enter email">
        <div class="invalid-feedback" id="email_error"></div>
      </div>

      <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" placeholder="Enter password">
        <div class="invalid-feedback" id="password_error"></div>
      </div>

      <div class="d-grid mb-3">
        <button type="submit" class="btn btn-primary">Login</button>
      </div>

      <p class="text-center">
        Don’t have an account? <a href="<?= base_url('register') ?>">Register</a>
      </p>
    </form>

    <div id="message" class="text-center mt-3"></div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(function(){
      $('#loginForm').on('submit', function(e){
        e.preventDefault();
        $('#email_error, #password_error, #message').text('');
        let formData = $(this).serialize();

        $.ajax({
        url: "/login",
          method: 'POST',
          data: formData,
          dataType: 'json',
          success: function(response){
            if(response.status === 'error'){
              if(response.errors.email) $('#email_error').text(response.errors.email);
              if(response.errors.password) $('#password_error').text(response.errors.password);
            }
            else if(response.status === 'fail'){
              $('#message').html('<span class="text-danger">' + response.message + '</span>');
            }
            else if(response.status === 'success'){
              $('#message').html('<span class="text-success">' + response.message + '</span>');
              setTimeout(() => {
                window.location.href = response.redirect;
              }, 1000);
            }
          },
          error: function(){
            $('#message').html('<span class="text-danger">Something went wrong. Try again.</span>');
          }
        });
      });
    });
  </script>
</body>
</html>
