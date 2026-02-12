<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?= $title ?? 'Login' ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="/dist/css/adminlte.css" />
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body class="login-page bg-body-secondary">
  <div class="login-box">
    <div class="login-logo">
      <a href="#"><b>Admin</b>LTE</a>
    </div>

    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <!-- FORMULAIRE LOGIN -->
        <form id="loginForm">
          <div class="input-group mb-3">
            <input type="email" class="form-control" name="email" placeholder="Email" />
            <div class="input-group-text"><span class="bi bi-envelope"></span></div>
          </div>

          <div class="row">
            <div class="col-8">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="flexCheckDefault" />
                <label class="form-check-label" for="flexCheckDefault">Remember Me</label>
              </div>
            </div>
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
          </div>
        </form>

        <div class="social-auth-links text-center mb-3 d-grid gap-2">
          <p>- OR -</p>
          <a href="#" class="btn btn-primary"><i class="bi bi-facebook me-2"></i> Sign in using Facebook</a>
          <a href="#" class="btn btn-danger"><i class="bi bi-google me-2"></i> Sign in using Google+</a>
        </div>

        <p class="mb-1"><a href="forgot-password.html">I forgot my password</a></p>
        <p class="mb-0"><a href="register.html" class="text-center">Register a new membership</a></p>
      </div>
    </div>
  </div>

  <!-- AdminLTE & Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"></script>
  <script src="/dist/js/adminlte.js"></script>

  <!-- JS LOGIN (fetch auto-login) -->
  <script>
    document.getElementById('loginForm').addEventListener('submit', function(e){
      e.preventDefault();

      const formData = new FormData(this);

      fetch('/login', {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        if(data.success){
          window.location.href = data.redirect; // redirection vers dashboard
        } else {
          alert(data.message || 'Erreur login');
        }
      })
      .catch(err => console.error(err));
    });
  </script>
</body>
</html>
