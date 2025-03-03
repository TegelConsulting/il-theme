const header = document.querySelector("header");

window.addEventListener("scroll", function () {
  if (window.scrollY > 0) {
    header.classList.add("scrolled");
  } else {
    header.classList.remove("scrolled");
  }
});

const burger = document.querySelector(".burger");
const nav = document.querySelector(".navigation .menu");
burger.addEventListener("click", function () {
  const expanded = burger.getAttribute("aria-expanded") === "true" || false;
  burger.setAttribute("aria-expanded", !expanded);
  nav.classList.toggle("open");
  burger.classList.toggle("open");
});
