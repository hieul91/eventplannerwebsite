function validate_registration() {
  // Get references to form elements
  const emailInput = document.getElementById("email");
  const fullNameInput = document.getElementById("fullname");
  const passInput = document.getElementById("pass");
  const pass2Input = document.getElementById("pass2");

  // Initialize error flag
  let hasErrors = false;

  // Regular expression for valid email. 
  // "/  /" is begining and end
  // "^  $" is the start and end of the string
  // []+ This quantifier mean previous character class [] should occur one or more times
  // @ and  \.(escaped with a backslash) is required part
  // {3,} is a quantifier that specifies a minimum of three characters. 
  const emailPattern = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{3,}$/;

  // Clear any previous error messages
  const errorMessages = document.getElementsByClassName("error");
  for (let i = 0; i < errorMessages.length; i++) {
    errorMessages[i].style.display = "none";
  }

  // Validate email
  // .test() is a method checks if emailPattern matches the value of the email input field
  // const.value and const.style
  if (!emailPattern.test(emailInput.value)) {
    hasErrors = true;
    // If the email is invalid, this line accesses an HTML element with 
    //  the id "emailError" and changes its CSS display property to "block".
    document.getElementById("emailError").style.display = "block";
    emailInput.style.border = "1px solid red";
  } else {
    emailInput.style.border = "1px solid #ccc";
  }

  // Validate fullname
  // if login input field is empty after removing leading and trailing whitespace
  if (fullNameInput.value.trim() === "") {
    hasErrors = true;
    document.getElementById("fullnameError").style.display = "block";
    fullNameInput.style.border = "1px solid red";
  } else {
    fullNameInput.style.border = "1px solid #ccc";
  }

  // Validate password

  // (?=.*[a-z])  This is a positive lookahead assertion. It checks 
  // if the string contains at least one lowercase letter (from 'a' to 'z'). 
  // .*:          This part matches any character (represented by .) 
  // zero or more times (indicated by *)
  const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
  if (!passwordPattern.test(passInput.value)){

    // if length is less than 8
    // if (passInput.value.length < 8){

    hasErrors = true;
    document.getElementById("passError").style.display = "block";
    passInput.style.border = "1px solid red";
  } else {
    passInput.style.border = "1px solid #ccc";
  }

  // Validate re-type password
  if (pass2Input.value !== passInput.value || pass2Input.value.trim() === "") {
    hasErrors = true;
    document.getElementById("pass2Error").style.display = "block";
    pass2Input.style.border = "1px solid red";
  } else {
    pass2Input.style.border = "1px solid #ccc";
  }

  // Prevent form submission if there are errors
  // If there are errors (hasErrors is true), !hasErrors will be false.
  // If there are validation errors in the form, the function will set hasErrors to true, 
  // and returning !hasErrors as false will prevent the form submission.
  return !hasErrors;
}

function validate_login() {
  // Get references to form elements
  const emailInput = document.getElementById("email");
  const passInput = document.getElementById("pass");

  // Initialize error flag
  let hasErrors = false;

  // Clear any previous error messages
  const errorMessages = document.getElementsByClassName("error");
  for (let i = 0; i < errorMessages.length; i++) {
    errorMessages[i].style.display = "none";
  }

  // Validate email
  if (emailInput.value.length === 0) {
    hasErrors = true;
    // If the email is invalid, this line accesses an HTML element with 
    //  the id "emailError" and changes its CSS display property to "block".
    document.getElementById("emailError").style.display = "block";
    emailInput.style.border = "1px solid red";
  } else {
    emailInput.style.border = "1px solid #ccc";
  }


  // Validate password
  if (passInput.value.length === 0){
    hasErrors = true;
    document.getElementById("passError").style.display = "block";
    passInput.style.border = "1px solid red";
  } else {
    passInput.style.border = "1px solid #ccc";
  }

  // Prevent form submission if there are errors
  // If there are errors (hasErrors is true), !hasErrors will be false.
  // If there are validation errors in the form, the function will set hasErrors to true, 
  // and returning !hasErrors as false will prevent the form submission. 
  return !hasErrors;
}

//Function creates alert whenever the subcription button is checked by the user
const subscription = document.getElementById("subscription");
subscription.addEventListener("click", function() {
  if (subscription.checked) {
      // Display an alert when the checkbox is checked
      alert("Thank you for subscribing to our weekly newsletter.");
  }
})

