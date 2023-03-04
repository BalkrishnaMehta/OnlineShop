function validate(type, value) {
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() {
        if(this.status == 200 && this.readyState == 4) {
            if(this.responseText == 0) {
                document.getElementById(type).setAttribute("style", "border: 2px solid red");
                return false;
            } else if(this.responseText == 1){
                document.getElementById(type).removeAttribute("style");
                return true;
            }
        }
    }
    xmlHttp.open("GET", "include/liveval.php?type="+type + "&value=" + value, true);
    xmlHttp.send();
}




function submission() {
    var password = document.getElementById('password').value;
    var passwordc = document.getElementById('passwordc').value;
    if(password == "" || passwordc == "") {
        alert('Invalid form data');
        return;
    } else if(password != passwordc) {
        alert("Password do not match !");
        return;
    }
    var arr = ['name', 'email', 'contact', 'password'];
    arr.forEach(element => {
        validate(element, document.getElementById(element).value);
    });


    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() {
        if(this.status == 200 && this.readyState == 4) {
            console.log(this.responseText);
            if(this.responseText == 0) {
                alert("Invalid form data");
            } else if(this.responseText == 1) {
                alert("Account creation Successful");
                location.replace('../');
            }
        }
    }
    xmlHttp.open("POST", "include/script.php", true);
    xmlHttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xmlHttp.send("name=" + document.getElementById('name').value + "&password=" + document.getElementById('password').value + "&email=" + document.getElementById('email').value + "&contact=" + document.getElementById('contact').value);
}


function passval(val1, val2) {
    if(val1 != val2) {
        document.getElementById('passwordc').setAttribute("style", "border: 2px solid red");
        return;
    } else {
        document.getElementById('passwordc').removeAttribute("style");
        return;
    }
} 