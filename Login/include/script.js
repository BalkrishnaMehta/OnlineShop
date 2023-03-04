function login(username, password){
    if(username == "" || password == "") {
        document.getElementById('error').innerHTML = 'Username or Password is empty';
        return;
    }

    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            switch(this.responseText) {
                case 'User': {
                    location.replace('../Home/');
                    break;
                }

                case 'Admin': {
                    location.replace('../Admin/');
                    break;
                }

                case '0': {
                    document.getElementById('error').innerHTML = 'Incorrect Username or Password';
                    break;
                }
            }
        }
    }
    xmlHttp.open('POST', 'include/script.php', true);
    xmlHttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xmlHttp.send('username=' + username + '&password=' + password);
}

    
