<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Page to Play Chess</title>
        <link href="style.css" rel="stylesheet">
    </head>
    

<form id="sign_up_form" method="post" action="../includes/register.php">
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
            <script>
function signUp(event){
    event.preventDefault();
    let signUpForm = document.getElementById("sign_up_form");

    let firstName = signUpForm.elements["first_name"].value;
    let lastName = signUpForm.elements["last_name"].value;
    let signUpEmail = signUpForm.elements["sign_up_email"].value;
    let signUpUsername = signUpForm.elements["sign_up_username"].value;
    let signUpPassword = signUpForm.elements["sign_up_password"].value;

    if(firstName == "" || lastName == "" || signUpEmail == "" || signUpUsername == "" || signUpPassword == ""){
        alert("You need to enter a correct first name, last name, email, username, and/or password.");
    }else if(!/[a-z]/.test(firstName) || !/[A-Z]/.test(firstName)){
        alert("Make sure your first name is correct.");
    }else if(!/[a-z]/.test(lastName) || !/[A-Z]/.test(lastName)){
        alert("Make sure your last name is correct.");
    }else if(!signUpEmail.includes("@") || !signUpEmail.includes(".")){
        alert("Make sure you have entered a vaild email.");
    }else if(!/[A-Z]/.test(signUpUsername) && !/[a-z]/.test(signUpUsername)){
        alert("Make sure you enter a vaild username.");
    }else if(signUpPassword.length < 8 || !/[0-9]/.test(signUpPassword) ||
        !/[A-Z]/.test(signUpPassword) || !/[a-z]/.test(signUpPassword)){
            alert("Please enter a vaild password.");
    }else{
        signUpForm.submit();
        // Sumbits to a PHP form
    }
}
                </script>