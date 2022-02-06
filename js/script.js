const hamburgerMenu = document.querySelector(".index-header__hamburger-menu");
const nav = document.querySelector(".index-header__nav");

hamburgerMenu.addEventListener("click", () => {
  if (hamburgerMenu.classList.contains("open")) {
    // open hamburger
    hamburgerMenu.classList.remove("open");
    nav.classList.remove("fade-in");
    nav.classList.add("fade-out");
  } else {
    // close hamburger
    hamburgerMenu.classList.add("open");
    nav.classList.add("fade-in");
    nav.classList.remove("fade-out");
  }
});
