<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        
    </head>
    <link href="style.css" rel="stylesheet">
    <body>
        <div class="container">
            <form id="login_form" method="post" action="../Processes/login.php">
                <label for="username"><b>Username:</b></label>
                <input type="text" placeholder="Enter your username" id="username" name="username"> <br><br>
                <label for="password"><b>Password:</b></label>
                <input type="password" placeholder="Enter your password" id="password" name="password"><br><br>
                <button onclick="login(event);">Login</button>
            </form> 

        </div>
        <div class="container">
            <button onclick="clickRegister(event)">Register here</button>
        </div>
        <script>
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
            function clickRegister(event){
                <?php
                header("register.php")
                ?>
                <a href="register.php"></a>
            }
        </script>
    </body>
</html>