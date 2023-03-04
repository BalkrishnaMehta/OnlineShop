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
        }
    } else {
        header('location: Login/');
    }
    if(isset($_REQUEST['submit'])){
        unset($_REQUEST['submit']);
        
        if(!empty($_FILES['itemImage']['name'])){
            $fileName = basename($_FILES['itemImage']['name']);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            $allowTypes = array('jpg','png','jpeg','svg','ico','bmp');
            if(in_array($fileType,$allowTypes)){
                $itemImage = addslashes($_FILES['itemImage']['tmp_name']);
                $itemImageContent = base64_encode(file_get_contents($itemImage));
            }
        }
        
        // Creating Database and Table
        $connection1 = new mysqli("localhost","root","","neel") or die("Connection failed: " . $connection1->connect_error);
        $connection1->query("CREATE TABLE IF NOT EXISTS data(itemImage longblob)")  or die("Error creating table: " . mysqli_error($connection2));
        
        $attribute = array_keys($_REQUEST);
        for($i=0;$i<count($attribute);$i++){
            $connection1->query("ALTER TABLE data ADD COLUMN IF NOT EXISTS $attribute[$i] varchar(255);");
        }

        $connection1->query("ALTER TABLE data ADD PRIMARY KEY IF NOT EXISTS (title);");

        // Inserting Value
        $connection1->query("INSERT INTO data VALUES ('$itemImageContent', '".$_REQUEST['title']."', '".$_REQUEST['mrp']."', '".$_REQUEST['price']."');");
        header('Location: index.php');
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
            <h4>Add Item</h4>
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
                <td><input type="text" name="title" required></td>
            </tr>
            <tr>
                <th>MRP</th>
                <td><input type="number" step="0.01" min="0" name="mrp" id="mrp" value="<?php if (isset($_REQUEST['mrp'])){echo $_REQUEST['mrp'];}?>" required></td>
            </tr>
            <tr>
                <th>Price</th>
                <td><input type="number" step="0.01" min="0" name="price" id="price" value="<?php if (isset($_REQUEST['price'])){echo $_REQUEST['price'];}?>" required onfocusout="validateprice(document.getElementById('price').value,document.getElementById('mrp').value)"></td>
            </tr>
            <tr>
                <th>Image</th>
                <td><input type="file" name="itemImage" id="image" required style="color: rgba(0, 0, 0, 0)"><img src="" id="imgPreview" style="display:none;"></td>
            </tr>
        </tbody>
        <tfoot>
            <td></td>
            <td><input type="submit" name="submit" value="upload"></td>
        </tfoot>
    </table>
    </div>
    </form>
</body>
    <script>
        const inpFile = document.getElementById('image');
        const previewimage = document.getElementById('imgPreview');
        inpFile.addEventListener("change",function(){
            const file = this.files[0];
            if(file){
                const reader = new FileReader();
                reader.addEventListener("load",function(){
                    previewimage.setAttribute("style","display:inline-block;margin-left:-140px; height:150px;width:150px;border-radius:10%;");
                    previewimage.setAttribute("src",this.result);
                });
                reader.readAsDataURL(file);
            }
            else{
                previewimage.setAttribute("style","display:none");
            }
        });

        function validateprice(price,mrp){
            if(parseFloat(price) > parseFloat(mrp)){
                document.getElementById('price').value="";
                alert("Price cannot be higher than MRP.");
            }
            if(document.getElementById('mrp').value == ""){
                alert("Please Enter MRP First.");
            }
        }
    </script>
</html>
