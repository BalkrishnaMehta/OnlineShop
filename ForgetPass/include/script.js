function sendOtp(email) {
    if(email != "") {
        var xmlHttp = new XMLHttpRequest();
        xmlHttp.onreadystatechange = function() {
            if(this.readyState == 4 && this.status == 200) {
                if(this.responseText == 0) {
                    document.getElementById('error').innerHTML = "Username doesn't exist";                    
                } else if(this.responseText == 1){
                    location.replace('Validate/');                   
                }
            }
        }
        xmlHttp.open('POST', 'include/sendEmail.php', false);
        xmlHttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xmlHttp.send("email=" + email);
    } else {
        document.getElementById('error').innerHTML = "Username is empty";
    }
}