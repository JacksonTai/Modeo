const userInputs = document.querySelectorAll(".user-entry-form__input--signin");
const userEmailInput = document.querySelector("[name='email']");
const errorMessages = document.querySelectorAll(".user-entry-form__error-msg");

for (let userInput of userInputs) {
  for (let errorMessage of errorMessages) {
    // Check if error message class name include the name of input field.
    if (errorMessage.className.includes(userInput.name)) {
      // Check if there is any error message or not.
      if (errorMessage.innerHTML != "") {
        styleInputBox(userInput, false);
      }

      // Remove red color from input box if there is no error in input fields.
      if (userInput.innerHTML == "" && errorMessage.innerHTML == "") {
        styleInputBox(userInput, true);
      }

      // Make email input box red color once email or password is incorrect.
      if (
        userInput.name == "password" &&
        errorMessage.innerHTML.includes("Incorrect")
      ) {
        styleInputBox(userEmailInput, false);
      }
    }
  }
}

function styleInputBox(input, result) {
  if (result) {
    input.classList.remove("invalid-input-box");
  } else {
    input.classList.add("invalid-input-box");
  }
}
