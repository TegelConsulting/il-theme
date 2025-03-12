jQuery(document).ready(function ($) {
  const { __, setLocaleData } = wp.i18n;

  // Debugging: Check if wp.i18n is loaded
  console.log("wp.i18n loaded:", typeof __ === "function");

  // Debugging: Check if translations are available
  console.log('Translation for "Previous":', __("Previous", "iltheme"));
  console.log('Translation for "Next":', __("Next", "iltheme"));

  const carousel = $(".carousel");

  if (carousel.length > 0) {
    $(carousel).owlCarousel({
      items: 1,
      loop: true,
      autoplay: true,
      dots: true,
      nav: true,
      navText: [
        `<div class='nav-btn prev-slide'>${__("Föregående", "iltheme")}</div>`,
        `<div class='nav-btn next-slide'>${__("Nästa", "iltheme")}</div>`,
      ],
      slideTransition: "ease-in",
      navSpeed: 400,
      autoplaySpeed: 400,
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
  }
});
