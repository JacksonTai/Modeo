// Drop down box for checkout summary in mobile view.
let checkoutHeader = document.querySelector(".checkout-section__header");
let checkoutBody = document.querySelector(".checkout-section__body");
checkoutHeader.addEventListener("click", () => {
  let upTriangle = document.querySelector(".checkout-section__up-triangle");
  let downTriangle = document.querySelector(".checkout-section__down-triangle");
  let checkoutHeaderText = document.querySelector(
    ".checkout-section__header-text "
  );

  if (upTriangle.classList.contains("hide-triangle")) {
    upTriangle.classList.remove("hide-triangle");
    downTriangle.classList.add("hide-triangle");
    checkoutHeaderText.textContent = "Hide order summary";
    // checkoutBody.style.maxHeight = "100rem";
    checkoutBody.style.maxHeight = checkoutBody.scrollHeight + "px";
  } else {
    upTriangle.classList.add("hide-triangle");
    downTriangle.classList.remove("hide-triangle");
    checkoutHeaderText.textContent = "Show order summary";
    checkoutBody.classList.remove("checkout-summary-close");
    checkoutBody.style.maxHeight = null;
  }
});

// Send data to PHP using Ajax.
const sendFormData = async (url, options = null) => {
  try {
    let res = await fetch(url, options);
    // # Debug
    // let data = await res.text();
    // console.log(data);  
  } catch (error) {
    console.log(error);
    // alert(error);
  }
};

// Form validation
let itemContainer = document.querySelectorAll(".checkout-form__item-container");
for (let item of itemContainer) {
  let input = item.children[1];
  let errorMsg = item.children[2];

  input.addEventListener("input", () => {
    let result = validateInput(input);

    if (result) {
      input.classList.remove("invalid-input-box");
      errorMsg.textContent = "";
    }
  });
}

let paymentForm = document.querySelector(".checkout-form--payment");
paymentForm.addEventListener("submit", function (e) {
  e.preventDefault();

  let error = [];

  for (let item of itemContainer) {
    let label = item.children[0];
    let input = item.children[1];
    let errorMsg = item.children[2];

    let result = validateInput(input);

    if (!result) {
      input.classList.add("invalid-input-box");

      // Derive label text as partial of error message text.
      let field = label.textContent.replace(":", "");
      let errorMsgText = `⚠ Invalid ${field}.`;

      if (result === null) {
        errorMsgText = `* ${field} is required.`;
      }

      errorMsg.textContent = errorMsgText;

      // Add error message to error array, which is used to check if any error exists.
      error.push(errorMsg);
    }
  }

  if (error.length === 0) {
    let deliveryForm = document.querySelector(".checkout-form--delivery");

    // Delivery information.
    let formData = new FormData(deliveryForm);
    formData.append("action", "add");

    sendFormData("checkout.php", {
      method: "POST",
      body: formData,
    });

    // Order information.
    formData = new FormData();
    formData.append("action", "add");

    sendFormData("checkout.php"), {
      method: "POST",
      body: formData,
    }
    window.location.href = 'paymentSuccess.php';
  }
});

function validateInput(input) {
  let result = null;

  if (input.value.trim()) {
    result = false;

    if (input.name === "firstName" || input.name === "lastName") {
      regex = /^[a-z]+$/i;
    }
    if (input.name === "phone") {
      regex = /^(\+?6?01)[0-9]?[0-9]{7,8}$/;
    }
    if (input.name === "country") {
      result = true;
    }
    if (input.name === "address") {
      regex = /^([a-z0-9/,.()]+\s)*[a-z0-9/,.()]+$/i;
    }
    if (
      input.name === "state" ||
      input.name === "city" ||
      input.name === "cardHolder"
    ) {
      regex = /^([a-z]+\s)*[a-z]+$/i;
    }
    if (input.name === "zipCode") {
      regex = /^\d{5}$/;
    }
    if (input.name === "cardNumber") {
      regex = /^\d{16}$/;
    }
    if (input.name === "expirationDate") {
      regex = /^(0[1-9]|1[0-2])\/[0-9]{2}$/;
    }
    if (input.name === "securityCode") {
      regex = /^\d{3}$/;
    }

    // Check if trimmed input match the regular expression.
    if (input.value.trim().match(regex)) {
      result = true;
    }
  }

  return result;
}
