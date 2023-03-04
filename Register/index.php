<?php
    session_start();
    include('../Assets/modules/accFetch.php');

    if(isset($_SESSION['username']) || isset($_COOKIE['username'])) {
        if(isset($_SESSION['password']) || isset($_COOKIE['password'])) {

            $username = (isset($_SESSION['username']))? $_SESSION['username']: $_COOKIE['username'];
            $password = (isset($_SESSION['password']))? $_SESSION['password']: $_COOKIE['password'];

            $row = login($username, $password);

            if($row) {
                header('location: /');
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
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
      .card-registration {
        background: #000000;
      }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
<section class="vh-100 gradient-custom">
  <div class="container py-5 h-100">
    <div class="row justify-content-center align-items-center h-100">
      <div class="col-12 col-lg-9 col-xl-7">
        <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
          <div class="card-body p-4 p-md-5">
            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 text-center text-light">Registration Form</h3>
            
            <form method="POST" name="form1">

              <div class="row">
                <div class="col-md-12 mb-4">

                  <div class="form-outline">
                    <input type="text" id="name" placeholder="Michael" name="name" class="form-control form-control-lg" onkeyup="validate(this.id, this.value)" autofocus/>
                    <label class="form-label text-light" for="Name" >Name</label>
                  </div>

                </div>
              </div>


              <div class="row">
                <div class="col-md-6 mb-4 pb-2">

                  <div class="form-outline">
                    <input type="email" id="email" name="email"  placeholder="abc@xyz.com" onkeyup="validate(this.id, this.value)" class="form-control form-control-lg" />
                    <label class="form-label text-light" for="emailAddress">Email</label>
                  </div>

                </div>
                <div class="col-md-6 mb-4 pb-2">

                  <div class="form-outline">
                    <input type="tel" id="contact" name="contact" onkeyup="validate(this.id, this.value)" class="form-control form-control-lg" placeholder="7845664644"/>
                    <label class="form-label text-light" for="contact">Phone Number</label>
                  </div>

                </div>
              </div>

              <div class="row">
                <div class="col-md-12 mb-4">

                  <div class="form-outline">
                    <input type="password" id="password" placeholder="Password" name="password" class="form-control form-control-lg" onkeyup="validate(this.id, this.value)"/>
                    <label class="form-label text-light" for="password" >Password</label>
                  </div>

                </div>
              </div>

              <div class="row">
                <div class="col-md-12 mb-4">

                  <div class="form-outline">
                    <input type="password" id="passwordc" placeholder="Confirm Password" name="passwordc" class="form-control form-control-lg" onkeyup="passval(document.getElementById('password').value, this.value)"/>
                    <label class="form-label text-light" for="passwordc" >Confirm Password</label>
                  </div>

                </div>
              </div>
              
              <div class="mt-4 pt-2">
                <input class="btn btn-primary btn-lg" type="button" onclick="submission()" value="Submit" />
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script src="include/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>