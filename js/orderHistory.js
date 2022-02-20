let orderItems = document.querySelectorAll(
  ".order-history__item-upper-content"
);

for (let orderItem of orderItems) {
  orderItem.addEventListener("click", () => {
    let orderItemId = orderItem.dataset.orderItemId;
    window.location.href = `orderDetail.php?id=${orderItemId}`;
  });
}
