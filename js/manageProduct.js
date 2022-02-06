/* Fetch product information to be displayed in modals. */
const fetchProduct = async (table, productId = null) => {
  productId ? (productId = `&productId=${productId}`) : (productId = "");

  try {
    let res = await fetch(
      `manageProductView.php?action=get&table=${table}${productId}`
    );
    let data = await res.json();
    return data;
  } catch (error) {
    console.log(error);
    alert(error);
  }
};

// Add product to php server through Ajax.
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

/* -- Modal -- */

// 1) Add product
let addBtn = document.querySelector(".manage-product__item--add");
let addProductModalOverlay = document.querySelector(
  ".modal-overlay--add-product"
);
let addProductModal = document.querySelector(".modal--add-product");
let addProductForm = document.querySelector(
  ".manage-product-form--add-product"
);

// Input validation for add product form.
addProductForm.addEventListener("submit", function (e) {
  e.preventDefault();

  // Convert htmlcollection into array using spread operator.
  let itemContainer = [...this.children];

  // Remove button(last item) from item container.
  itemContainer.pop();

  let errorMsgs = [];

  for (let item of itemContainer) {
    let label = item.children[0];
    let input = item.children[1];
    let errorMsg = item.children[2];

    if (!input.value) {
      input.classList.add("invalid-input-box");
      errorMsg.textContent = `* ${label.textContent.replace(
        ":",
        ""
      )} is required.`;
      errorMsgs.push(errorMsg.textContent);
    }

    input.addEventListener("input", () => {
      input.classList.remove("invalid-input-box");
      errorMsg.textContent = "";
    });
  }

  if (errorMsgs.length == 0) {
    let formData = new FormData(this);

    for (let item of itemContainer) {
      let input = item.children[1];
      console.log(input.value);

      formData.append(input.name, input.value);
    }

    // To identify executing function in php file.
    formData.append("action", "add");

    // To identify inserting table.
    formData.append("table", "product");

    sendFormData("manageProductView.php", {
      method: "POST",
      body: formData,
    });
    closeModal();
    window.location.href = "manageProductView.php";
  }
});

addBtn.addEventListener("click", () => {
  addProductModal.style.display = "block";
  addProductModalOverlay.style.display = "flex";
  document.body.classList.add("no-scroll");
});

// 2) Update product
let updateBtns = document.querySelectorAll(".manage-product__item-btn--update");
let updateProductModalOverlay = document.querySelector(
  ".modal-overlay--update-product"
);
let updateProductModal = document.querySelector(".modal--update-product");
let updateProductForm = document.querySelector(
  ".manage-product-form--update-product"
);
let updateBtn = document.querySelector(".modal__update-product-btn");

// Fill existing data into update modal input box.
const fillUpdateContent = async (productId) => {
  try {
    // Add product id as update button value.
    updateBtn.value = productId;

    const content = await fetchProduct("product", productId);
    let contentArrs = Object.entries(content);

    // Convert htmlcollection into array using spread operator.
    let itemContainer = [...updateProductForm.children];

    // Remove button(last item) from item container.
    itemContainer.pop();

    for (let item of itemContainer) {
      let labelText = item.children[0].textContent;
      let input = item.children[1];

      for (let contentArr of contentArrs) {
        // Get field and value from content object.
        let field = contentArr[0];
        let value = contentArr[1];

        if (labelText.replace(":", "").toLowerCase().includes(field)) {
          if (input.type != "file") {
            input.value = value;
          }
        }
      }
    }
  } catch (error) {
    console.log(error);
    alert(error);
  }
};

// Input validation for update product form.
updateProductForm.addEventListener("submit", function (e) {
  e.preventDefault();

  // Convert htmlcollection into array using spread operator.
  let itemContainer = [...this.children];

  // Remove button(last item) from item container.
  itemContainer.pop();

  let errorMsgs = [];

  for (let item of itemContainer) {
    let label = item.children[0];
    let input = item.children[1];
    let errorMsg = item.children[2];

    // Avoid adding error message and styling for file input.
    if (!input.value && input.type != "file") {
      input.classList.add("invalid-input-box");
      errorMsg.textContent = `* ${label.textContent.replace(
        ":",
        ""
      )} is required.`;
      errorMsgs.push(errorMsg.textContent);
    }

    input.addEventListener("input", () => {
      input.classList.remove("invalid-input-box");
      errorMsg.textContent = "";
    });
  }
  if (errorMsgs.length == 0) {
    let formData = new FormData(this);

    // Fill up the form data with the input name and value.
    for (let item of itemContainer) {
      let input = item.children[1];

      // Avoid adding image info into form data if the file input is empty.
      if (!input.value && input.type == "file") {
        continue;
      }

      formData.append(input.name, input.value);
    }

    // To identify executing function in php file.
    formData.append("action", "update");

    // To identify updating table.
    formData.append("table", "product");

    // To identify updating product.
    formData.append("productId", updateBtn.value);

    sendFormData("manageProductView.php", {
      method: "POST",
      body: formData,
    });
    closeModal();
    window.location.href = "manageProductView.php";
  }
});

for (let updateBtn of updateBtns) {
  updateBtn.addEventListener("click", function () {
    updateProductModal.style.display = "block";
    updateProductModalOverlay.style.display = "flex";
    document.body.classList.add("no-scroll");
    fillUpdateContent(this.value);
  });
}

// 3) Delete product
let deleteBtns = document.querySelectorAll(".manage-product__item-btn--delete");
let deleteProductModalOverlay = document.querySelector(
  ".modal-overlay--delete-product"
);
let deleteProductModal = document.querySelector(".modal--delete-product");
let deleteInfos = document.querySelectorAll(".modal__delete-info");
let deleteImg = document.querySelector(".modal__delete-img");
let deleteBtn = document.querySelector(".modal__delete-product-btn");

// Fill all related content into delete modal elements.
const fillDeleteContent = async (productId) => {
  try {
    // Set delete button value
    deleteBtn.value = productId;

    const content = await fetchProduct("product", productId);
    let contentArrs = Object.entries(content);

    for (let contentArr of contentArrs) {
      // Get field and value from content object.
      let field = contentArr[0];
      let value = contentArr[1];

      // Set image source and alternative text.
      if (field == "image") {
        deleteImg.src = `data:image/jpg;charset=utf8;base64,${value}`;
      }
      if (field == "name") {
        deleteImg.alt = value;
      }

      // Set price and size unit.
      if (field == "price") {
        value = "RM" + value;
      }
      if (field == "size") {
        value += "(EU)";
      }

      // Set deleting product's info
      for (let deleteInfo of deleteInfos) {
        // Get delete info span, which also can be deemed as the label of the delete info.
        let deleteInfoSpan = deleteInfo.children[0];

        // Get text of 'delete info span' to check with field.
        let deleteInfoSpanText = deleteInfoSpan.textContent
          .replace(":", "")
          .trim()
          .toLowerCase();

        // Check if text of 'delete info span' includes in field.
        if (field.toLowerCase().includes(deleteInfoSpanText)) {
          let deleteText = document.createTextNode(value);
          deleteInfo.appendChild(deleteText);
        }
      }
    }
  } catch (error) {
    console.log(error);
    alert(error);
  }
};

// Delete product by passing URL information.
deleteBtn.addEventListener("click", function () {
  fetchProduct("productItem", this.value)
    .then((res) => {
      let action = "action=delete";

      let table = "table=productWithQty";

      // Check if product does not have any stocks.
      let contentArrs = Object.values(res);
      if (contentArrs.length == 0) {
        table = "table=product";
      }

      let productId = `productId=${this.value}`;

      let url = `manageProductView.php?${action}&${table}&${productId}`;

      sendFormData(url);
      closeModal();
      window.location.href = "manageProductView.php";
    })
    .catch((error) => {
      console.log(error);
      alert(error);
    });
});

for (let deleteBtn of deleteBtns) {
  deleteBtn.addEventListener("click", function () {
    deleteProductModal.style.display = "block";
    deleteProductModalOverlay.style.display = "flex";
    document.body.classList.add("no-scroll");
    fillDeleteContent(this.value);
  });
}

// 4) Manage product
let manageBtns = document.querySelectorAll(".manage-product__item-manage-btn");
let manageProductModalOverlay = document.querySelector(
  ".modal-overlay--manage-product"
);
let manageProductModal = document.querySelector(".modal--manage-product");
let addProductItemForm = document.querySelector(
  ".manage-product-form--add-product-item"
);
let addProductItemBtn = document.querySelectorAll(".add-product-item-btn");
let manageProductForm = document.querySelector(
  ".manage-product-form--manage-product"
);

const fillManageContent = async (productId) => {
  try {
    // Add product id as add product stock button value.
    addProductItemBtn.value = productId;

    const content = await fetchProduct("productItem", productId);
    let contentArrs = Object.values(content);

    for (let contentArr of contentArrs) {
      // Get field and value from content object.
      let size = contentArr.size;
      let qty = contentArr.quantity;

      // Create input elements.
      let inputSize = document.createElement("input");
      inputSize.name = "productSize";
      inputSize.value = `${size} (EU)`;

      let inputQty = document.createElement("input");
      inputQty.type = "number";
      inputQty.name = "productQty";
      inputQty.placeholder = "Quantity";
      inputQty.min = 0;
      inputQty.value = qty;

      // Create delete stock button elements.
      let deleteStockBtn = document.createElement("button");
      let deleteImg = document.createElement("img");
      deleteStockBtn.className = "delete-product-stock-btn";
      deleteImg.src = "../../img/icons/trash.jpg";
      deleteImg.alt = "Delete";
      deleteStockBtn.append(deleteImg);

      // Create item container.
      let itemContainer = document.createElement("div");
      itemContainer.className =
        "manage-product-form__item-container--manage-product";
      itemContainer.dataset.productId = productId;
      itemContainer.dataset.size = size;
      itemContainer.append(inputSize, inputQty, deleteStockBtn);

      // Add item container.
      manageProductForm.append(itemContainer);

      // Add event listener for each qty input box created.
      inputQty.addEventListener("change", function () {
        let formData = new FormData(manageProductForm);

        formData.append("action", "update");
        formData.append("table", "productItem");
        formData.append("productId", itemContainer.dataset.productId);
        formData.append("productSize", itemContainer.dataset.size);
        formData.append("productQty", inputQty.value);

        sendFormData("manageProductView.php", {
          method: "POST",
          body: formData,
        });
      });

      // Add event listener for each delete stock buttons created.
      deleteStockBtn.addEventListener("click", function () {
        let action = "action=delete";
        let table = "table=productItem";
        let productId = `productId=${itemContainer.dataset.productId}`;
        let size = `productSize=${itemContainer.dataset.size}`;

        let url = `manageProductView.php?${action}&${table}&${productId}&${size}`;

        sendFormData(url);
        closeModal();
        window.location.href = "manageProductView.php";
      });
    }
  } catch (error) {
    console.log(error);
    alert(error);
  }
};

manageProductForm.addEventListener("submit", function (e) {
  e.preventDefault();
});

addProductItemForm.addEventListener("submit", function (e) {
  e.preventDefault();

  // Convert htmlcollection into array using spread operator.
  let inputs = [...this.children];

  // Remove button(last item) from the form.
  inputs.pop();

  let errorMsgs = [];

  for (let input of inputs) {
    let tempPlaceholderName = input.placeholder;

    if (!input.value) {
      input.classList.add("invalid-input-box");
      input.classList.add("invalid-placeholder-text");
      input.placeholder = `* ${input.placeholder}`;
      errorMsgs.push(`${input.name} cannot be empty.`);
    }

    input.addEventListener("input", () => {
      input.classList.remove("invalid-input-box");
      input.classList.remove("invalid-placeholder-text");
      input.placeholder = tempPlaceholderName;
    });
  }

  if (errorMsgs.length == 0) {
    let formData = new FormData(this);

    for (let input of inputs) {
      formData.append(input.name, input.value);
    }

    // To identify executing function in php file.
    formData.append("action", "add");

    // To identify updating table.
    formData.append("table", "productItem");

    // To identify updating product.
    formData.append("productId", addProductItemBtn.value);

    sendFormData("manageProductView.php", {
      method: "POST",
      body: formData,
    });
    closeModal();
    window.location.href = "manageProductView.php";
  }
});

for (let manageBtn of manageBtns) {
  manageBtn.addEventListener("click", function () {
    manageProductModal.style.display = "block";
    manageProductModalOverlay.style.display = "flex";
    document.body.classList.add("no-scroll");
    fillManageContent(this.value);
  });
}

/* -- Close Modal -- */
let modalOverlays = document.querySelectorAll(".modal-overlay");
let modals = document.querySelectorAll(".modal");
let closeBtns = document.querySelectorAll(".modal__close-btn");

for (let closeBtn of closeBtns) {
  closeBtn.addEventListener("click", closeModal);
}

function closeModal() {
  document.body.classList.remove("no-scroll");

  for (let modal of modals) {
    modal.style.display = "none";
  }

  for (let modalOverlay of modalOverlays) {
    modalOverlay.style.display = "none";
  }

  // Remove input styling and error message.
  let allForm = [addProductForm, updateProductForm];

  for (let form of allForm) {
    let itemContainer = [...form.children];

    // Remove button(last item) from item container.
    itemContainer.pop();

    for (let item of itemContainer) {
      let input = item.children[1];
      let errorMsg = item.children[2];

      input.classList.remove("invalid-input-box");
      errorMsg.textContent = "";
    }
  }

  // Remove delete info in delete modal.
  for (let deleteInfo of deleteInfos) {
    // Get delete info span, which also can be deemed as the label of the delete info.
    let deleteInfoSpan = deleteInfo.children[0];

    // Empty the text content (including the span element).
    deleteInfo.textContent = "";

    // Append the span again.
    deleteInfo.appendChild(deleteInfoSpan);
  }

  for (let input of addProductItemForm) {
    // Remove styling only for input that has placeholder and asterisk in placholder.
    if (input.placeholder && input.placeholder.includes("*")) {
      input.classList.remove("invalid-input-box");
      input.classList.remove("invalid-placeholder-text");
      input.placeholder = input.placeholder.split("*")[1].trim();
    }
  }

  manageProductForm.textContent = "";
}

/* -- Window -- */
// Prevent page from scrolling after refreshing browser
window.onbeforeunload = function () {
  let scrollPos;

  if (typeof window.pageYOffset != "undefined") {
    scrollPos = window.pageYOffset;
  } else if (
    typeof document.compatMode != "undefined" &&
    document.compatMode != "BackCompat"
  ) {
    scrollPos = document.documentElement.scrollTop;
  } else if (typeof document.body != "undefined") {
    scrollPos = document.body.scrollTop;
  }

  document.cookie = "scrollTop=" + scrollPos;
};

window.onload = function () {
  if (document.cookie.match(/scrollTop=([^;]+)(;|$)/) != null) {
    let arr = document.cookie.match(/scrollTop=([^;]+)(;|$)/);
    document.documentElement.scrollTop = parseInt(arr[1]);
    document.body.scrollTop = parseInt(arr[1]);
  }
};
