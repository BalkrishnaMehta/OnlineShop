<?php
    ini_set('display_errors', '1');
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

            $connection = new mysqli("localhost","root","","neel") or die("Connection failed: " . $connection->connect_error);
            
            if(!isset($_REQUEST['submit'])) {
                $_SESSION['title'] = $_REQUEST['title'];
                $title = $_REQUEST['title'];
                 $result = $connection->query("SELECT * FROM data WHERE title = '".$title."';");
            if(mysqli_num_rows($result) > 0 ) {
                while($row = $result->fetch_assoc()){
                    $data[] = $row;
                }
                $title = urlencode($data[0]['title']);
                $mrp = $data[0]['mrp'];
                $price = $data[0]['price'];
                $image = $data[0]['itemImage'];
            }
            

            }

            
            
           
            if(isset($_REQUEST['submit'])){
                unset($_REQUEST['submit']);
                $title = $_REQUEST['title'];
                $mrp = $_REQUEST['mrp'];
                $price = $_REQUEST['price'];
                $result = $connection->query("UPDATE data SET title = '$title', mrp = '$mrp', price = '$price' WHERE title = '".$_SESSION['title']."'");
                header('Location: index.php?cart=');
            }
        }
    } else {
        header('location: /');
    }
?>
<!DOCTYPE HTML>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body style="background-color:#FFFFF0;">
    <form method="post" enctype="multipart/form-data" action="">
    <div class="container">
        <div style="display:grid; place-items:center; margin-top:3em">
            <h4>Edit Item</h4>
        </div>
    <table class="table table-striped table-bordered" style="margin-top:2em !important; margin:auto; width:40em; background-color:white;">
        <thead>
            <tr>
                <th>Column</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>Title</th>
                <td><input type="text" name="title" required value=<?php 
                    if(strpos(rawurldecode($title), '+') !== false) {
                        $title = rawurldecode($title);
                        $title = str_replace("+", "&nbsp;", $title);
                        echo $title;
                    } else {
                        echo rawurldecode($title);
                    }
                    
                    ?>></td>
            </tr>
            <tr>
                <th>MRP</th>
                <td><input type="number" step="0.01" min="0" name="mrp" id="mrp" value=<?php echo $mrp;?> required></td>
            </tr>
            <tr>
                <th>Price</th>
                <td><input type="number" step="0.01" min="0" name="price" id="price" value=<?php echo $price;?> required onfocusout="validateprice(document.getElementById('price').value,document.getElementById('mrp').value)"></td>
            </tr>
            <tr>
                <th>Image</th>
                <td><img src='<?php echo "data:image;base64,$image"?>' class='card-img-top' style='width:15vw; height:15vw;'></td>
            </tr>
        </tbody>
        <tfoot>
            <td></td>
            <td><input type="submit" name="submit" value="Submit" onclick=""></td>
        </tfoot>
    </table>
    </div>
    </form>
</body>
    <script>
        function validateprice(price,mrp){
            if(parseFloat(price) > parseFloat(mrp)){
                document.getElementById('price').value="";
                alert("Price cannot be higher than MRP.");
            }
            if(document.getElementById('mrp').value == ""){
                alert("Please Enter MRP First.");
            }
        }
        function fun(){
            alert('Item updated Successfully');
        }
    </script>
</html>