function login(event){
    event.preventDefault();
    let loginForm = document.getElementById("login_form");
    
    let username = loginForm.elements["username"].value;
    let password = loginForm.elements["password"].value;

    if(username == "" || password == ""){
        alert("You need to enter both username and password.");
    }else{
        loginForm.submit();
        // Submits to a PHP form
    }
}