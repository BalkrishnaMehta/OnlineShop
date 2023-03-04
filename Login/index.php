<?php
    session_start();
    include('../Assets/modules/accFetch.php');

    if(isset($_SESSION['username']) || isset($_COOKIE['username'])) {
        if(isset($_SESSION['password']) || isset($_COOKIE['password'])) {

            $username = (isset($_SESSION['username']))? $_SESSION['username']: $_COOKIE['username'];
            $password = (isset($_SESSION['password']))? $_SESSION['password']: $_COOKIE['password'];

            $row = login($username, $password);

            if($row['Role'] == 'Admin') {
                header('location: Admin/');
            } else {
                header('location: Home/');
            }
        }
      }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  <title>Login</title>
  <style>

    #error {
      font-weight: 600;
    }

    .card {
      background: #000000;
    }

    .mb-2 {
      padding: 40px;
    }

  </style>
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
                  <h2 class="fw-bold mb-2 text-uppercase text-light">Login</h2>
                  <div class="form-outline form-white mb-4">
                    <input type="email" class="form-control form-control-lg" id="username" name="username" placeholder="abc@xyz.com" autofocus/>
                  </div>
                  <div class="form-outline mb-4">
                    <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="password"/>
                  </div>
                  <div class="form-outline mb-4 text-white" id='error'>
                  </div>
                  <p class="small mb-5 pb-lg-2"><a class="text-light" href="../ForgetPass">Forgot password ?</a></p>
                  <button class="btn btn-outline-light btn-lg px-5" type="button" onclick="login(document.getElementById('username').value, document.getElementById('password').value)">Login</button>
                  <button class="btn btn-outline-light btn-lg px-5" type="button" onclick="location.replace('../Register/');">Register</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </section>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  <script src="include/script.js"></script>
</body>
</html>