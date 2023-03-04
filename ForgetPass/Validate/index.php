<?php
  session_start();  
  if(!isset($_SESSION['otp'])) {
    header('location: ../');
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
    <style>
        .mb-2 {
            padding: 40px;
        }

        .card {
            background: #000000 !important;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>
<body>
<section class="vh-100">
    <div class="container py-5 h-100">
      <form>
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card" style="border-radius: 1rem;">
              <div class="card-body p-5 text-center">
                <div class="mb-md-4 mt-md-4 pb-5">
                  <h2 class="fw-bold mb-2 text-uppercase text-light">Forget Password</h2>
                  <div class="form-outline form-white mb-4">
                    <input type="text" class="form-control form-control-lg" id="otp" name="otp" placeholder="OTP" autofocus/>
                  </div>
                  <div class="form-outline form-white mb-4">
                    <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="New Password"/>
                  </div>
                  <div class="form-outline form-white mb-4">
                    <input type="password" class="form-control form-control-lg" id="passwordc" name="passwordc" placeholder="Confirm Password"/>
                  </div>
                  <div class="form-outline mb-4 text-light" id='error'>
                  </div>
                  <button class="btn btn-outline-light btn-lg px-5" type="button" onclick="validateOtp(document.getElementById('otp').value, document.getElementById('password').value, document.getElementById('passwordc').value)">Verify</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </section>
  <script src="include/script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>