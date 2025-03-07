window.addEventListener("scroll", function () {
  const header = document.querySelector("header");
  if (window.scrollY > 0) {
    header.classList.add("scrolled");
  } else {
    header.classList.remove("scrolled");
  }
});

window.onload = function () {
  const options = {
    root: null,
    rootMargin: "0px",
    threshold: 0.5,
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("fade-in");
      } else {
        entry.target.classList.remove("fade-in");
      }
    });
  }, options);

  const boxes = document.querySelectorAll(".box:not(.no-fade)");

  if (boxes) {
    for (let i = 0; i < boxes.length; i++) {
      observer.observe(boxes[i]);
    }
  }

  const burger = document.querySelector(".burger");
  const nav = document.querySelector(".navigation .menu");
  burger.addEventListener("click", function () {
    const expanded = burger.getAttribute("aria-expanded") === "true" || false;
    burger.setAttribute("aria-expanded", !expanded);
    nav.classList.toggle("open");
    burger.classList.toggle("open");
  });
};
