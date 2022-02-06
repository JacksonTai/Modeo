const userInputs = document.querySelectorAll(".user-entry-form__input--signup");
const errorMessages = document.querySelectorAll(".user-entry-form__error-msg");

for (let userInput of userInputs) {
  // Add event listener to every input fields.
  userInput.addEventListener("input", () => {
    checkUserInput(userInput);
  });

  // Check input field that has existing value once the page has been loaded.
  if (userInput.value) {
    checkUserInput(userInput);
  }

  // Style input field that has error messages below it.
  for (let errorMessage of errorMessages) {
    // Get the class name that has modifier.
    let errorMessageClassName = errorMessage.className.split(" ")[1];

    // Extract the modifier from the class name.
    let modifier = errorMessageClassName.split("--")[1];

    if (modifier == userInput.name && errorMessage.innerHTML != "") {
      styleInputBox(userInput, false);
    }
  }
}

function checkUserInput(userInput) {
  let result = null;
  let regex = null;

  if (userInput.value) {
    result = false;

    // Check input name and assign regular expression accordingly.
    if (userInput.name === "email") {
      regex =
        /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    }
    if (userInput.name === "username") {
      regex = /^[a-z]{8,30}$/i;
    }
    if (userInput.name === "password") {
      regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/;
    }
    if (
      userInput.name === "passwordRepeat" &&
      userInput.value === password.value
    ) {
      result = true;
    }

    // Check if input match the regular expression.
    if (userInput.value.match(regex)) {
      result = true;
    }
  }

  styleInputBox(userInput, result);
  removeErrorMessage(userInput, result);
}

function styleInputBox(input, result) {
  const rulesText = input.nextElementSibling;

  if (result) {
    input.classList.add("valid-input-box");
    input.classList.remove("invalid-input-box");

    // Check if rules text exists.
    if (rulesText) {
      rulesText.classList.add("valid-rules-text");
      rulesText.classList.remove("invalid-rules-text");
    }
  } else if (result === null) {
    input.classList.remove("valid-input-box");
    input.classList.remove("invalid-input-box");

    if (rulesText) {
      rulesText.classList.remove("valid-rules-text");
      rulesText.classList.remove("invalid-rules-text");
    }
  } else {
    input.classList.remove("valid-input-box");
    input.classList.add("invalid-input-box");

    if (rulesText) {
      rulesText.classList.remove("valid-rules-text");
      rulesText.classList.add("invalid-rules-text");
    }
  }
}

function removeErrorMessage(userInput, result) {
  // Style input field that has error messages below it.
  for (let errorMessage of errorMessages) {
    // Get the class name that has modifier.
    let errorMessageClassName = errorMessage.className.split(" ")[1];

    // Extract the modifier from the class name.
    let modifier = errorMessageClassName.split("--")[1];

    if (
      modifier == userInput.name &&
      errorMessageClassName.includes(modifier)
    ) {
      if (result && modifier != "email") {
        errorMessage.innerHTML = "";
      }
    }
  }
}
