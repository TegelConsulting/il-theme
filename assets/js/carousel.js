jQuery(document).ready(function ($) {
  $(".carousel").owlCarousel({
    items: 1,
    loop: true,
    autoplay: false,
    dots: true,
    nav: true,
    navText: [
      "<div class='nav-btn prev-slide'>Föregående</div>",
      "<div class='nav-btn next-slide'>Nästa</div>",
    ],
  });

  document.getElementById("carousel").addEventListener("mouseover", () => {
    const btns = document.querySelectorAll(".owl-nav button");

    btns.forEach((btn) => {
      btn.classList.add("show");
    });
  });

  document.getElementById("carousel").addEventListener("mouseleave", () => {
    const btns = document.querySelectorAll(".owl-nav button");

    btns.forEach((btn) => {
      btn.classList.remove("show");
    });
  });
});
