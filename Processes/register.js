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