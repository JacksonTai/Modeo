document.getElementById("iban").addEventListener("input", function (e) {

  let target = e.target;
  let position = target.selectionEnd;
  let length = target.value.length;

  // console.log(this.value);
  // console.log(position);

  // target.value = target.value.replace(/[^\dA-Z]/g, "")
  // console.log(target.value.replace(/(.{4})/g, "$1 "));

  target.value = target.value.replace(/[^\dA-Z]/g, "").replace(/(.{4})/g, "$1 ").trim();
  
  target.selectionEnd = position += target.value.charAt(position - 1) === " " && target.value.charAt(length - 1) === " " && length !== target.value.length ? 1 : 0;
});
