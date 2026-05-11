function Login(event){

    event.preventDefault();

    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../Controller/AdminController.php", true);

    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function(){

        if(xhr.readyState == 4 && xhr.status == 200){

            console.log(xhr.responseText); // MUST SHOW JSON ONLY

            var res = JSON.parse(xhr.responseText);

            if(res.status === "success"){
                window.location.href = "../View/Admin.DashboardView.php";
            }else{
                alert("Login failed");
            }
        }
    };

    xhr.send("action=Login&email=" + email + "&password=" + password);
}