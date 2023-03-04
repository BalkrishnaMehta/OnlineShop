function validateOtp(otp, password, passwordc) {
    if(otp == "" || password == "" || passwordc == "") {
        document.getElementById('error').innerHTML = "None of the field should be empty";
    } else {
        if(password != passwordc) {
            alert("Passwords do not match");
        } else {
            var xmlHttp = new XMLHttpRequest();
            xmlHttp.onreadystatechange = function() {
                if(this.readyState == 4 && this.status == 200) {
                    if(this.responseText == 0) {
                        alert('Invalid OTP');
                    } else if(this.responseText == 1){
                        alert('Password Updated Successfully');
                        location.replace('../../');
                    }
                }
            }
            xmlHttp.open('POST', 'include/script.php', true);
            xmlHttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xmlHttp.send("otp=" + otp + "&passwordc=" + passwordc);
        }
    }
}