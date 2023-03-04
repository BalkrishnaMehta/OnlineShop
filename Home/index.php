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
            }
        }
    } else {
        header('location: /');
    }

    $data2 = array();
    $arr = array();
    $email = $row['email'];
    $name = $row['name'];
    $connection = new mysqli("localhost","root","","neel") or die("Connection failed: " . $connection->connect_error);
    if(empty($_REQUEST['search'])){
        $result = $connection->query("SELECT * FROM data");
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
    }
    else{
        $search_value = $_REQUEST['search'];
        $value = "%".$search_value."%";
        $stmt1 = $connection->prepare("select * from data where title LIKE ?");
        $stmt1->bind_param("s",$value);
        $stmt1->execute();
        $stmt_result1 = $stmt1->get_result();
        if($stmt_result1->num_rows > 0){
            while($row = $stmt_result1->fetch_assoc()){
                $data[] = $row;
            }
            
        }
        else{
            $errorMsg = "No result for $search_value<br>Try checking your spelling or use more general terms<br>";
        }
    }


    $result = $connection->query("SELECT * FROM cart WHERE email = '$email';");
    while($row = $result->fetch_assoc()){
        $data2[] = $row;
    }
    for($i=0;$i<count($data2);$i++){
        $arr[$data2[$i]['title']] = $data2[$i]['quantity'];
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
            <input class="form-control me-2" type="search" placeholder="Search for products..." size="50" aria-label="Search" name="search" autocomplete="off" value="<?php if(isset($_REQUEST['search'])){echo $_GET['search'];} ?>">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
        <div class="navbar-collapse collapse" id="navbarTogg" style="">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 flex-row">
            <li class="nav-item ms-3">
            <a class="nav-link position-relative" href="cart.php"><img src="cart.png" style="height:30px; width:30px;">
                <span  id="productsincart" class="position-absolute top-4 start-90 translate-middle text-center badge rounded-pill bg-danger">
                    <?php echo count($data2);?>
                </span>
            </a>
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
                $style1 = $style2 = ""; 
                $title = $data[$k]['title'];
                $mrp = $data[$k]['mrp'];
                $price = $data[$k]['price'];
                $itemImage = $data[$k]['itemImage'];
                $discount = round(100 - (($data[$k]['price']/$data[$k]['mrp'])*100));
                if (array_key_exists($title,$arr)){
                    $style1 = "style='display: none'";
                }
                else{
                    $style2 = "style='display: none'";
                }
                if(isset($arr[$title])){
                    $quan = $arr[$title];
                }
                else{
                    $quan = 1;
                }
                echo
                "<div class='card mt-3 ms-3' style='width: 23vw; display:inline-block;'>
                    <img src='data:image;base64,$itemImage' class='card-img-top center-block d-block mx-auto' style='padding:4vw; width:22.9vw; height:23vw;'>
                    <div class='card-body' id='cardBody$k'>
                        <h5 class='card-title' style='line-height: 1.5em; height: 3em;  display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;  overflow: hidden; text-overflow: ellipsis; '>$title</h5>
                        <p class='card-text'><b>&#8377; $price</b> <span style='font-size:12px; color:#D0C9C0; text-decoration: line-through;'>&#8377; $mrp</span><br><span style='color: #5BB318;'><b>UPTO $discount &percnt; off</b></span></p>
                        <button class='btn btn-primary w-100' id='addtocart$k' onclick='cartfun(this.id)' $style1>ADD TO CART</button>
                        <div class='w-100 text-center' id='afteraddtocart$k' $style2><button class='btn' id='decreasebtn$k' style='background:transparent;' onclick='decrease(this.id)' '><img src='minus.png' style='height:30px; width:30px;'></button><span class='h6' id='num$k'>$quan</span><button class='btn' id='increasebtn$k' style='background:transparent;' onclick='increase(this.id)' '><img src='plus.png' style='height:30px; width:30px;'></button></div>
                    </div>
                </div>";
            }
        }
        elseif(isset($errorMsg)){
            echo $errorMsg;
        }
        ?>
</body>
<script>
    var title;
    var addtocart;
    var email = '<?php echo $email;?>';
    var name = '<?php echo $name;?>'; 
    function cartfun(idofcart){
        index = idofcart.replace(/[^0-9]/g, '');
        addtocart = $('#addtocart'+index).prop("outerHTML");
        title = $("#cardBody"+index+">h5").text();
        $("#addtocart"+index).hide();
        $("#afteraddtocart"+index).show();

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if(this.readyState == 4 && this.status == 200) {
                $('#productsincart').text(this.responseText);
            }
        }
        xmlhttp.open("GET", "addtodb.php?email=" + email + "&name=" + name + "&title=" + encodeURIComponent(title) + "&quantity=" + $('#num'+index).text(), true);
        xmlhttp.send();
    }

    function increase(idofbtn){
        index = idofbtn.replace(/[^0-9]/g, '');
        title = $("#cardBody"+index+">h5").text();
        var  val = $('#num'+index).text();
        if(parseInt(val) != 10){
            $('#num'+index).text(parseInt(val)+1);
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if(this.readyState == 4 && this.status == 200) {
                    $('#productsincart').text(this.responseText);
                }
            }
            xmlhttp.open("GET", "addtodb.php?email=" + email + "&name=" + name + "&title=" + encodeURIComponent(title) + "&quantity=" + $('#num'+index).text(), true);
            xmlhttp.send();

        }
        else{
            alert("You can not order more than 10 items");
        }
    }
    function decrease(idofbtn){
        index = idofbtn.replace(/[^0-9]/g, '');
        title = $("#cardBody"+index+">h5").text();
        var val = $('#num'+index).text();
        if(parseInt(val) != 1){
            $('#num'+index).text(parseInt(val)-1);

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if(this.readyState == 4 && this.status == 200) {
                    $('#productsincart').text(this.responseText);
                }
            }
            xmlhttp.open("GET", "addtodb.php?email=" + email + "&name=" + name + "&title=" + encodeURIComponent(title) + "&quantity=" + $('#num'+index).text(), true);
            xmlhttp.send();
        }
        else{
            $("#afteraddtocart"+index).hide();
            $("#addtocart"+index).show();

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if(this.readyState == 4 && this.status == 200) {
                    $('#productsincart').text(this.responseText);
                }
            }
            xmlhttp.open("GET", "addtodb.php?email=" + email + "&name=" + name + "&title=" + encodeURIComponent(title) + "&quantity=" + 0, true);
            xmlhttp.send();
        }
    }

    window.addEventListener( "pageshow", function ( event ) {
        var historyTraversal = event.persisted || ( typeof window.performance != "undefined" && window.performance.navigation.type === 2 );
        if ( historyTraversal ) {
            window.location.reload();
        }
    });
</script>
</html>
