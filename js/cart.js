const sendFormData = async (url, options = null) => {
  try {
    let res = await fetch(url, options);
    // # Debug
    // let data = await res.text();
    // console.log(data);
  } catch (error) {
    console.log(error);
    alert(error);
  }
};

/* -- Update cart item -- */
let cartTableRows = document.querySelectorAll(".cart-table__row");
let productQtyInputs = document.querySelectorAll(".cart-table__input-quantity");
let qtyDataCells = document.querySelectorAll(".cart-table__data--quantity");
let priceDataCells = document.querySelectorAll(".cart-table__data--price");
let totalPriceLabels = document.querySelectorAll(
  ".cart-table__label--total-price"
);
let totalPriceDataCells = document.querySelectorAll(
  ".cart-table__data--total-price"
);
let subTotalDataCell = document.querySelector(".cart-table__data--subtotal");

window.addEventListener("resize", changeQtyInputView);
window.addEventListener("load", changeQtyInputView);
window.addEventListener("resize", changeTotalPriceView);
window.addEventListener("load", changeTotalPriceView);

/* Manipulate quantity input box existance in different cells */
function changeQtyInputView() {
  // Looping through two array simultaneously.
  qtyDataCells.forEach((qtyDataCell, qtyIndex) => {
    priceDataCells.forEach((priceDataCell, priceIndex) => {
      if (qtyIndex == priceIndex) {
        if (window.innerWidth < 1245) {
          if (!priceDataCell.children[1]) {
            priceDataCell.appendChild(qtyDataCell.children[0]);
          }

          if (qtyDataCell.children[0]) {
            qtyDataCell.children[0].remove();
          }
        }

        if (window.innerWidth >= 1245) {
          if (!qtyDataCell.children[0]) {
            qtyDataCell.appendChild(priceDataCell.children[1]);
          }

          if (priceDataCell.children[1]) {
            priceDataCell.children[1].remove();
          }
        }
      }
    });
  });
}

function changeTotalPriceView() {
  totalPriceDataCells.forEach((totalPriceDataCell, totalPriceIndex) => {
    totalPriceLabels.forEach((totalPriceLabel, totalPriceLabelIndex) => {
      if (totalPriceIndex == totalPriceLabelIndex) {
        let totalPriceRow = totalPriceLabel.parentElement;

        if (window.innerWidth < 1245) {
          if (totalPriceDataCell) {
            totalPriceDataCell.remove();
          }

          if (!totalPriceRow.children[1]) {
            totalPriceRow.append(totalPriceDataCell);
          }
        }

        if (window.innerWidth >= 1245) {
          let cartTableRow = totalPriceRow.previousElementSibling;

          if (!cartTableRow.children[4]) {
            cartTableRow.append(totalPriceLabel.parentElement.children[1]);
          }

          if (totalPriceRow.children[1]) {
            totalPriceRow.children[1].remove();
          }
        }
      }
    });
  });
}

function updateCartItem(input) {
  let formData = new FormData();

  formData.append("action", "update");
  formData.append("cartItemId", input.dataset.cartItemId);
  formData.append("quantity", input.value);

  sendFormData("cart.php", {
    method: "POST",
    body: formData,
  });
}

function updateTotalPrice(input) {
  let inputRowId = input.parentElement.parentElement.dataset.cartItemId;
  priceDataCells.forEach((dataCell) => {
    let priceRowId = dataCell.parentElement.dataset.cartItemId;

    if (inputRowId == priceRowId) {
      totalPriceDataCells.forEach((totalPriceDataCell) => {
        let totalPriceRowId =
          totalPriceDataCell.parentElement.dataset.cartItemId;

        if (inputRowId == totalPriceRowId) {
          let price = parseFloat(
            dataCell.children[0].textContent.replace("RM", "")
          );
          let qty = parseInt(input.value);
          let totalPrice = Math.round(price * qty * 100) / 100;

          totalPriceDataCell.textContent = `RM${totalPrice}`;
        }
      });
    }
  });
}

function updateSubtotal() {
  let subtotal = 0;
  let totalPriceDataCells = document.querySelectorAll(
    ".cart-table__data--total-price"
  );

  totalPriceDataCells.forEach((totalPriceDataCell) => {
    if (!totalPriceDataCell.classList.contains("strike")) {
      let totalPrice = totalPriceDataCell.textContent
        .replace("RM", "")
        .trim(" ");
      let parsedTotalPrice = parseFloat(totalPrice);
      subtotal += Math.round(parsedTotalPrice * 100) / 100;
      subtotal = Math.round(subtotal * 100) / 100;
    }
  });

  subTotalDataCell.textContent = `Subtotal: RM${subtotal}`;
}

productQtyInputs.forEach((input) => {
  input.addEventListener("change", () => {
    updateCartItem(input);
    updateTotalPrice(input);
    updateSubtotal();
  });
});

/* -- Delete cart item -- */
let removeLinks = document.querySelectorAll(".cart-table__remove-link");

for (let removeLink of removeLinks) {
  removeLink.addEventListener("click", function () {
    // Update the cart table row and subtotal price.
    cartTableRows.forEach((row) => {
      if (row.dataset.cartItemId == removeLink.dataset.cartItemId) {
        row.remove();
        updateSubtotal();
      }
    });

    let action = "action=delete";
    let cartItemId = `cartItemId=${removeLink.dataset.cartItemId}`;
    let url = `cart.php?${action}&${cartItemId}`;

    sendFormData(url);
  });
}

/* -- Checkout -- */
let checkOutBtn = document.querySelector(".check-out-btn");
 
checkOutBtn.addEventListener("click", () => {
  // Avoid user from checking out white nothing in cart. 
  if (subTotalDataCell.textContent.trim() !== "Subtotal: RM0") {
    window.location.href = "checkout.php";
  }
});
