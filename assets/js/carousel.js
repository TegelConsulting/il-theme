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

  let hideButtonsTimeout;

  function showButtons() {
    const btns = document.querySelectorAll(".owl-nav button");
    btns.forEach((btn) => {
      btn.classList.add("show");
    });

    // Clear any existing timeout
    clearTimeout(hideButtonsTimeout);

    // Set a timeout to hide the buttons after 2 seconds
    hideButtonsTimeout = setTimeout(() => {
      hideButtons();
    }, 1000);
  }

  function hideButtons() {
    const btns = document.querySelectorAll(".owl-nav button");
    btns.forEach((btn) => {
      btn.classList.remove("show");
    });
  }

  document.addEventListener("mousemove", showButtons);

  document
    .querySelector(".owl-stage-outer")
    .addEventListener("mouseleave", hideButtons);
});
