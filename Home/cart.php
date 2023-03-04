<?php
    session_start();
    include('../Assets/modules/accFetch.php');

    if(isset($_SESSION['username']) || isset($_COOKIE['username'])) {
        if(isset($_SESSION['password']) || isset($_COOKIE['password'])) {

            $username = (isset($_SESSION['username']))? $_SESSION['username']: $_COOKIE['username'];
            $password = (isset($_SESSION['password']))? $_SESSION['password']: $_COOKIE['password'];

            $row1 = login($username, $password);

            if($row1['Role'] == 'Admin') {
                header('location: Admin/');
            }
        }
    } else {
        header('location: Login/');
    }
    $data = array();
    $email = $row1['email'];
    $connection = new mysqli("localhost","root","","neel") or die("Connection failed: " . $connection->connect_error);
    $result = $connection->query("SELECT * FROM cart WHERE email = '$email'");
    while($row = $result->fetch_assoc()){
        $data[] = $row;
    }
    for($i=0;$i<count($data);$i++){
        $title =  $data[$i]['title'];
        $result2 = $connection->query("SELECT * FROM data WHERE title = '".$title."';");
        while($row = $result2->fetch_assoc()){
            foreach($row as $key => $value){
                $data[$i][$key] = $value;
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"> </script>
    <title></title>
    <style>
        html,body{
            width: 100%;
            background-color: #EAEAEA;
        }   
        .parent{
            margin-top:2%;
            width: 100%;
            height: 98%;
            display: flex;
            flex-flow: row nowrap;
        }
        .products{
            height: fit-content;
            width:80%;
            padding:1em;
            background-color:white;
            margin:0 auto;
            border-radius:0.4em;
        }
        .payment{
            height: fit-content;
            width:80%;
            padding:1em;
            background-color:white;
            margin-top:5em !important;
            border-radius:0.4em;
        }
        .btn-light:not([disabled]):not(.disabled).active,
        .btn-light:not([disabled]):not(.disabled):active,
        .btn-light:not([disabled]):not(.disabled).hover,
        .btn-light:not([disabled]):not(.disabled):hover {
            color: #111 !important;
            background-color: #f8f9fa !important;
            border-color: #f8f9fa !important;
        }
        .flex-container {
            height: 100%;
            padding: 0;
            margin: 0;
            display: flex;
            flex-flow: column nowrap;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="parent">
        <div class= "space1" style='width:15vw; height:100;'>
        </div>
        <div class= "content" style='width:55vw; height:100;'>
            <h2 style="margin-left: 6vw;"> Order Summary</h2>
            <div class="products">
                <h6 style="font-size:14px; color: #7F8487;">PRODUCTS</h6><br>
                <?php
                    for($j=0;$j<count($data);$j++){
                    $itemImage = $data[$j]['itemImage'];
                    $title = $data[$j]['title'];
                    $price = $data[$j]['price'];
                    $mrp = $data[$j]['mrp'];
                    $quantity = $data[$j]['quantity'];
                    $priceProductQuantity = $price*$quantity;
                    $mrpProductQuantity = $mrp*$quantity;
                    echo "
                    <div style='width:100%; display:flex; flex-flow:row nowrap; margin:0.7em;'>
                        <div style='width:15%;'>
                            <img src='data:image;base64,$itemImage' style='width:20px; height:30px;'>
                        </div>
                        <div style='width:84%;'>
                            <h5 id='title$j'>$title<h5>
                            <p style='color: #749F82;' ><b id='priceProductQuantity$j'>&#8377; $priceProductQuantity</b> <span id= 'mrpProductQuantity$j' style='font-size:12px; color:#D0C9C0; text-decoration: line-through;'>&#8377; $mrpProductQuantity</span><br><span style='color: #5BB318;'></p>
                            <button type='button' class='btn btn-light'>QTY:
                                <select id ='select$j' class='text-bg-light' onfocus='changeQTY(this)' style='border:none; outline:none; width:80px; text-align:center;'>";
                                for($k=1;$k<=10;$k++){
                                    if($k == $quantity){
                                        echo "<option value='$k' selected>$k</option>";
                                    }
                                    else{
                                        echo "<option value='$k'>$k</option>";
                                    }
                                } 
                                    
                    echo        "</select>
                            </button><br><br>
                            <button type='button' class='btn btn-light' id='remove$j' onclick='deletefun(this)'>REMOVE</button>
                        </div>
                    </div><hr>
                    ";
                    }
                ?>
            </div>
        </div>
        <div class= "space2" style='width:30vw; height:150px;'>
        
        <div class="payment">
        <h5 style="font-size:14px; color: #7F8487; text-align: center">PAYMENT DETAILS</h5><br>
            <div style="display: flex; flex-wrap: wrap; flex-direction: column; justify-content: space-between;">
                <h6 style="font-size:14px; color: #7F8487;">Customer Name: <?php echo $row1['name']?></h6>
                <h6 style="font-size:14px; color: #7F8487;" id='time'></h6>
            </div><br>
            
            <p>M.R.P Total<span id="totalMrp" style="float:right;">0</span></span></p>
            <p>Discount<span id="Discount" style="float:right;">0</span></span></p>
            <p>Total Amount<span id="totalPrice" style="float:right;">0</span></span></p>
            <button type="button" class="btn btn-success" onclick="order()">SUBMIT</button>
        </div>
    </div>
</body>
<script>
    const d = new Date();
    document.getElementById('time').innerHTML = "Billing Date: " + d.getDate() + "/" + (d.getMonth() + 1) + "/" + d.getFullYear();
    var totalmrp = 0;
    var totalprice = 0;
    for(var i = 0; i < <?php echo count($data);?>; i++){
        totalmrp += parseInt($("#mrpProductQuantity"+i).text().slice(2,));
        totalprice += parseInt($("#priceProductQuantity"+i).text().slice(2,));
    }
    var discount = totalmrp - totalprice;
    $("#totalPrice").html('&#8377;'+totalprice);
    $("#totalMrp").html('&#8377;'+totalmrp);
    $("#Discount").html('- &#8377;'+discount);

    var previousQty;
    var currentQty;
    function changeQTY(selectinstance) {
        var totalmrp = 0;
        var totalprice = 0;
        index = selectinstance.id.replace(/[^0-9]/g, '');
        title = $("#title"+index).text();
        previousQty = parseInt(selectinstance.value);
        $("#"+selectinstance.id).on('change', function () {
            currentQty = parseInt(this.value);
            var price = parseInt($("#priceProductQuantity"+index).text().slice(2,));
            var mrp = parseInt($("#mrpProductQuantity"+index).text().slice(2,));
            $("#priceProductQuantity"+index).html('&#8377; '+((price*currentQty)/previousQty));
            $("#mrpProductQuantity"+index).html('&#8377; '+((mrp*currentQty)/previousQty));

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", "changeqty.php?qty="+currentQty+"&title="+encodeURIComponent(title)+"&email="+"<?php echo $email;?>", true);
            xmlhttp.send();
            
            
            for(var i = 0; i < <?php echo count($data);?>; i++){
                totalmrp += parseInt($("#mrpProductQuantity"+i).text().slice(2,));
                totalprice += parseInt($("#priceProductQuantity"+i).text().slice(2,));
            }
            var discount = totalmrp - totalprice;
            $("#totalPrice").html('&#8377;'+totalprice);
            $("#totalMrp").html('&#8377;'+totalmrp);
            $("#Discount").html('- &#8377;'+discount);

            previousQty = parseInt(this.value);
        });
    }

    function deletefun(instanceofElement){
        id = instanceofElement.id;
        title = $("#title"+id.replace(/[^0-9]/g, '')).text();
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if(this.readyState == 4 && this.status == 200) {
                location.reload();
            }
        }
        xmlhttp.open("GET", "delete.php?title=" + encodeURIComponent(title) +"&email="+"<?php echo $email;?>", true);
        xmlhttp.send();
    }

    function order() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if(this.readyState == 4 && this.status == 200) {
                print();
                location.replace('../');
            }
        }
        xmlhttp.open("GET", "order.php", true);
        xmlhttp.send();
    }

    if(<?php echo count($data);?> == 0){
        $('body').css('background-color','#F7F7F7');
        $('html').css('height','100%');
        $('body').css('height','100%');
        $('body').html("<div class='flex-container'><img src='emptycart.png'><br><br><a href='index.php' class='btn btn-success'>ADD PRODUCTS</a></div>");
    }
</script>
</html>