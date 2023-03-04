<?php
    session_start();
    include('../Assets/modules/accFetch.php');

    if(isset($_SESSION['username']) || isset($_COOKIE['username'])) {
        if(isset($_SESSION['password']) || isset($_COOKIE['password'])) {

            $username = (isset($_SESSION['username']))? $_SESSION['username']: $_COOKIE['username'];
            $password = (isset($_SESSION['password']))? $_SESSION['password']: $_COOKIE['password'];

            $row = login($username, $password);

            if($row['Role'] != 'Admin') {
                header('location: Home/');
            }
        }
    } else {
        header('location: Login/');
    }
    $data2 = array();
    $arr = array();
    $connection = new mysqli("localhost","root","","neel") or die("Connection failed: " . $connection->connect_error);
    if(!empty($_REQUEST['search'])){
        $result = $connection->query("select * from data where title LIKE '%".$_REQUEST['search']."%'");
        if(mysqli_num_rows($result) > 0 ) {
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
        } 
        else{
            $errorMsg = "No result for ".$_REQUEST['search']."<br>Try checking your spelling or use more general terms<br>";
        }
    } else if(isset($_REQUEST['cart'])) {
        $result = $connection->query("SELECT * FROM data");
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
    } else {
        $connection = new mysqli("localhost","root","","neel") or die("Connection failed: " . $connection->connect_error);
        $result = $connection -> query("SELECT name FROM orders group by email");
        while($row = $result -> fetch_assoc()) {
            $dataa[] = $row;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"> </script>
    <style>
        @media only screen and (max-width: 600px) {
            .card{
                width: 43vw !important;
            }
            .card-body > button{
                font-size:70% !important;
            }
        }
        @media only screen and (max-width: 799px) and (min-width: 601px) {
            .card{
                width: 22vw !important;
            }
        }
        .navbar-toggler {
            background-color: white;
            border: none;
            padding: 0.3em;
            margin:0.5em;
            outline: 0rem;
            text-align: center;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-dark sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="index.php">Shreeji Krupa Farsan</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogg" aria-controls="navbarTogglerDemo01" aria-expanded="true" aria-label="Toggle navigation">
      		<span class="navbar-toggler-icon"></span>
    	</button>
    	<form class="d-flex ms-auto" role="search">
            <input class="form-control me-2" type="search" placeholder="Search for products..." size="50" aria-label="Search" name="search" autocomplete="off" value="">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
        <div class="navbar-collapse collapse" id="navbarTogg">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 flex-row">
        <li class="nav-item ms-3">
            <a class="nav-link" name="cart" href='index.php?cart=True'><img src="cart.png" style="height:30px; width:30px;"></a>
        </li>
            <li class="nav-item ms-3">
            <a class="nav-link" href="upload.php"><img src="upload.png" style="height:30px; width:30px;"></a>
            </li>
            <li class="nav-item ms-3">
            <a class="nav-link" href="../Assets/modules/"><img src="account.png" style="height:30px; width:30px;"></a>
            </li>
        </ul>
        </div>
    </div>
</nav>
        <?php
        if(!empty($data)){
            for($k=0;$k<count($data);$k++){
                $title = $data[$k]['title'];
                $mrp = $data[$k]['mrp'];
                $price = $data[$k]['price'];
                $itemImage = $data[$k]['itemImage'];
                $discount = round(100 - (($data[$k]['price']/$data[$k]['mrp'])*100));
                echo
                "<div class='card mt-3 ms-3' style='width: 23vw; display:inline-block;'>
                    <img src='data:image;base64,$itemImage' class='card-img-top center-block d-block mx-auto' style='padding:4vw; width:22.9vw; height:23vw;'>
                    <div class='card-body' id='cardBody$k'>
                        <h5 class='card-title' style='line-height: 1.5em; height: 3em;  display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;  overflow: hidden; text-overflow: ellipsis; ' id='title$k'>$title</h5>
                        <p class='card-text'><b>&#8377; $price</b> <span style='font-size:12px; color:#D0C9C0; text-decoration: line-through;'>&#8377; $mrp</span><br><span style='color: #5BB318;'><b>UPTO $discount &percnt; off</b></span></p>
                        <button class='btn btn-primary' id='editBtn$k' onclick='editItem(this.id)' style='width:48.3%; height:35px; font-size:100%;'>EDIT</button>
                        <button class='btn btn-primary' id='deleteBtn$k' onclick='Prodel(this.id)' style='width:48.3%; height:35px; font-size:100%;'>DELETE</button>
                    </div>
                </div>";
            }
        } elseif(isset($errorMsg)){
            echo $errorMsg;
        } elseif (isset($dataa)) {
            echo "<div class='container mt-4'>            
            <table class='table table-bordered' style='border: 2px solid black !important;'>
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Data</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>";
            for($i = 0; $i < count($dataa); $i++) {  
                echo "<tr><td id='name$i'>".$dataa[$i]['name']."</td><td><table class='table table-striped table-bordered'>
                <thead>
                  <tr>
                    <th>Title</th>
                    <th>Quantity</th>
                  </tr>
                </thead>
                <tbody>";
                $connection = new mysqli("localhost","root","","neel") or die("Connection failed: " . $connection->connect_error);
                $result1 = $connection -> query("SELECT * FROM orders where name='".$dataa[$i]['name']."'");
                while($row = $result1 -> fetch_assoc()) {
                    $dat[] = $row;
                }
                for($j = 0; $j < count($dat); $j++) {
                    echo "<tr><td>".$dat[$j]['title']."</td><td>".$dat[$j]['quantity']."</td></tr>";
                }
                $dat = null;
                echo "</tbody></table><td><button style='border: white; border-radius: 10px; background: blue; color: white' id='$i' onclick='done(this.id);'>Checked</button></td>";
            }
            echo "</td></tr></tbody></table></div>";
        } else {
            echo "<div class='container' style='height: 85vh; align-items: center; display: flex; justify-content: center'><img src='noorder.jpg'></div>";
        }
        ?>
</body>
<script>
    window.addEventListener( "pageshow", function ( event ) {
        var historyTraversal = event.persisted || ( typeof window.performance != "undefined" && window.performance.navigation.type === 2 );
        if ( historyTraversal ) {
            window.location.reload();
        }
    });

    function editItem(id){
        index = id.replace(/[^0-9]/g, '');
        var title = $('#title' + index).text();
        window.open('edit.php?title=' + encodeURIComponent(title),'_SELF');
    }

    function Prodel(id) {
        index = id.replace(/[^0-9]/g, '');
        var title = $('#title' + index).text();
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if(this.readyState == 4 && this.status == 200) {
                location.replace('.');
            }
        }
        xmlhttp.open("GET", "delete.php?title=" + encodeURIComponent(title), true);
        xmlhttp.send();
    }

    function done(id) {

        var name = $('#name' + id).prop('innerHTML');
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if(this.readyState == 4 && this.status == 200) {
                location.replace('.');
            }
        }
        xmlhttp.open("GET", "done.php?name=" + name, true);
        xmlhttp.send();
    }
</script>
</html>
