function validateEmailInput() {
  const emailInput = document.getElementById('emailInput').value;
  const feedbackElement = document.getElementById('emailFeedback');
  const emailStatus = document.getElementById('emailStatus');
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    console.log(emailInput);
  if (emailRegex.test(emailInput)) {
    feedbackElement.textContent = ""; // Email is valid
    emailStatus.value = "1";
  } else {
    emailStatus.value = "0";
    feedbackElement.textContent = "Please enter a valid email address.";
  }
}

function validateUsernameInput() {
    const usernameInput = document.getElementById('usernameInput').value;
    const feedbackElement = document.getElementById('usernameFeedback');
    const usernameStatus = document.getElementById('usernameStatus');
    console.log(usernameInput);
    const pattern = /^[a-zA-Z0-9._]+$/;
    if (usernameInput.length < 3) {
        feedbackElement.textContent ="Username is too short.";
        usernameStatus.value = "0";
    }
    else if (usernameInput.length > 16) {
        usernameStatus.value = "0";
        feedbackElement.textContent =  "Username is too long.";
    }

    // Regex to check valid characters: letters, numbers, dots, underscores
    
    else if (!pattern.test(usernameInput)) {
        usernameStatus.value = "0";
        feedbackElement.textContent = "Username contains invalid characters. Only letters, numbers, dots, and underscores are allowed."; 
    }

    // Check that it doesn't start or end with a dot or underscore
    else if (usernameInput.startsWith('.') || usernameInput.startsWith('_')) {
        usernameStatus.value = "0";
        feedbackElement.textContent = "Username cannot start with a dot or underscore.";
    }
    else if (usernameInput.endsWith('.') || usernameInput.endsWith('_')) {
        usernameStatus.value = "0";
        feedbackElement.textContent = "Username cannot end with a dot or underscore.";
    }
    else{
        usernameStatus.value = "1";
        feedbackElement.textContent="";
    }
}

function validateFullNameInput() {
  const fullnameInput = document.getElementById('fullnameInput').value;
  const feedbackElement = document.getElementById('fullnameFeedback');
  const fullnameStatus = document.getElementById('fullnameStatus');
  const nameRegex = /^[a-zA-Z]+(?:[-' ][a-zA-Z]+)*$/;
  const words = fullnameInput.trim().split(' ');
  // Check if the full name matches the regex
  if (!nameRegex.test(fullnameInput)) {
    feedbackElement.textContent = "Invalid name format";
    fullnameStatus.value = "0";
  }else if (words.length < 2) {
    feedbackElement.textContent = "Requires at least first and last name";
    fullnameStatus.value = "0";
  }else if (fullnameInput.includes('  ')) {
    feedbackElement.textContent = "Consecutive Spaces";
    fullnameStatus.value = "0";
  }else{
        feedbackElement.textContent="";
        fullnameStatus.value = "1";
    }
}

function validateDescInput() {
  const descInput = document.getElementById('descriptionInput').value;
  const feedbackElement = document.getElementById('descriptionFeedback');
  const descStatus = document.getElementById('descriptionStatus');
  if (descInput.length === 0) {
    feedbackElement.textContent = "An empty string cannot have a capitalized first letter";
    descStatus.value = "0";
  }else{
    const firstChar = descInput.charAt(0);
    if(firstChar.toUpperCase() && firstChar !== firstChar.toLowerCase()){
      feedbackElement.textContent = "";
      descStatus.value = "1";
    }else{
      feedbackElement.textContent = " is not a letter";
      descStatus.value = "0";
    }
  }
}

function validateNameInput(){
    const nameInput = document.getElementById('nameInput').value;
    const feedbackElement = document.getElementById('nameFeedback');
    const nameStatus = document.getElementById('nameStatus');
    let input = nameInput.trim();
    if (nameInput !== input) {
      feedbackElement.textContent = "Input Not Valid (Input cannot be empty or just whitespace.)";
      nameStatus.value = "0";
    } else {
      if(input.length > 30){
        feedbackElement.textContent = "max 30 Char)";
        nameStatus.value = "0";
      }else{
        feedbackElement.textContent = "";
        nameStatus.value = "1";
      }
    }
}


function validateFirstNameInput() {
  const firstnameInput = document.getElementById('firstnameInput').value;
    const feedbackElement = document.getElementById('firstnameFeedback');
    const nameStatus = document.getElementById('firstnameStatus');
  const nameRegex = /^[a-zA-Z]+(?:[ -][a-zA-Z]+)*$/;

  // Check if the first name is empty
  if (firstnameInput.trim() === "") {
     feedbackElement.textContent = "First name cannot be empty";
      nameStatus.value = "0";
  }

  // Check if the first name matches the regular expression
  if (!nameRegex.test(firstnameInput)) {
      feedbackElement.textContent = "First name can only contain letters, spaces, and hyphens.";
      nameStatus.value = "0";
  }

  // Optional: Add length constraints
  if (firstnameInput.length < 2 || firstnameInput.length > 50) {
      feedbackElement.textContent = "First name must be between 2 and 50 characters long.";
      nameStatus.value = "0";
  }else{
     feedbackElement.textContent = "";
        nameStatus.value = "1";
  }
}

function validateLastNameInput() {
  const lastnameInput = document.getElementById('lastnameInput').value;
  const feedbackElement = document.getElementById('lastnameFeedback');
  const nameStatus = document.getElementById('lastnameStatus');

  if (!lastnameInput || lastnameInput.trim() === "") {
    feedbackElement.textContent = "Last name is required.";
      nameStatus.value = "0";
  }

  // Regular expression to allow letters, spaces, hyphens, and apostrophes
  // This regex allows for common name formats like "O'Malley" or "Smith-Jones"
  const namePattern = /^[a-zA-Z\s'-]+$/; 

  // Test the last name against the pattern
  if (!namePattern.test(lastnameInput)) {
       feedbackElement.textContent = "Invalid last name. Only letters, spaces, hyphens, and apostrophes are allowed.";
      nameStatus.value = "0";
  }else{
     feedbackElement.textContent = "";
        nameStatus.value = "1";
  }
}