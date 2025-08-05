<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Page to Play Chess</title>
        <script src="login.js" rel="javascript"></script>
        <script src="register.js" rel="javascript"></script>
    </head>
    <link href="style.css" rel="stylesheet">
    <body>
        <div class="container">
            <form id="login_form" method="post" action="login.php">
                <label for="username"><b>Username:</b></label>
                <input type="text" placeholder="Enter your username" id="username" name="username"> <br><br>
                <label for="password"><b>Password:</b></label>
                <input type="password" placeholder="Enter your password" id="password" name="password"><br><br>
                <button onclick="login(event);">Login</button>
            </form> <br><br><br><br><br>

            <form id="sign_up_form" method="post" action="register.php">
                <label for="first_name"><b>Sign Up: Enter your first name</b><br><br>
                <br>- Make sure to capitalize the first letter of your name<br></label>
                <input type="text" placeholder="Enter first name" id="first_name" name="first_name"> <br><br><br>
                <label for="last_name"><b>Enter your last name</b><br><br>
                <br>- Make sure to capitalize the first letter of your name<br></label>
                <input type="text" placeholder="Enter last name" id="last_name" name="last_name"> <br><br><br>
                <label for="sign_up_email"><b>Enter a vaild email</b></label>
                <input type="text" placeholder="Enter email" id="sign_up_email" name="sign_up_email"> <br><br><br>
                <label for="sign_up_username"><b>Enter your username</b><br><br>
                    <br>- The username should include uppercase or lowercase letters</label>
                <input type="text" placeholder="Enter username" id="sign_up_username" name="sign_up_username"> <br><br><br>
                <label for="sign_up_password"><b>Enter your password - Include the following:</b><br><br>
                    <br>- The password must be at least 8 characters long<br>
                    <br>- The password must have a number included<br>
                    <br>- The password must have uppercase and lowercase letters included<br></label>
                <input type="password" placeholder="Enter password" id="sign_up_password" name="sign_up_password"> <br><br>
                <button onclick="signUp(event);">Sign Up</button>
            </form>
        </div>
    </body>
</html>