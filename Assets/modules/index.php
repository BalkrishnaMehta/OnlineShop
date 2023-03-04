<?php
    session_start();
    if(isset($_COOKIE['username']) && isset($_COOKIE['password'])){
        $connect = new mysqli("localhost","root","","neel") or die('Connection Failed: '.$connect->connect_error);
        $stmt = $connect->prepare("select * from users where email = ?");
        $stmt->bind_param("s",$_COOKIE['username']);
        $stmt->execute();
        $stmt_result = $stmt->get_result();
        $data1 = $stmt_result->fetch_assoc();
        $class = "bg-primary";
        if($data1['Role']=="Admin"){
            $class = "bg-success";
        }
        if(isset($_POST['logout'])){
            session_unset();
            setcookie('username', '', -1, '/');
            setcookie('password', '', -1, '/');
            header('location: ../../');
        }
    }
    else{
        header('Location: ../../');
    }
?>
<!DOCTYPE HTML>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </head>
    <body>
        <div style="display:grid; place-items:center;">
            <a class="navbar-brand text-primary" href="../../" style="color:black !important;">Shreeji Krupa Farsan</a>
        </div>
        <div style="display:grid; place-items:center; margin:auto; width:18rem; border:2px solid; margin-top:2em !important; padding:1em; background-color: #FFFFF0;">
            <img src='account.png' style="height:100px;width:100px; border: 1px solid black;border-radius:50%; background-color:#B8E8FC; margin:1em;">
            <p><?php echo $data1['name']."  ";?><span class="badge rounded-pill <?php echo $class;?>" style=""><?php echo $data1['Role'];?></span></p>
            <p><?php echo $data1['email']."  ";?></p>
            <p><?php echo $data1['contact']."  ";?></p>
            <form method="post" action="">
                <input type="submit" name="logout" value="Logout">
            </form>
        </div>
    </body>
</HTML>
