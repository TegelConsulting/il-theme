window.addEventListener("scroll", function () {
  const header = document.querySelector("header");
  if (window.scrollY > 0) {
    header.classList.add("scrolled");
  } else {
    header.classList.remove("scrolled");
  }
});

document.addEventListener("DOMContentLoaded", function () {
  const options = {
    root: null,
    rootMargin: "0px",
    threshold: 0.5,
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("fade-in");
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

  const loadMoreTrigger = document.getElementById("load-more-trigger");

  const loadObserver = new IntersectionObserver(
    (entries) => {
      if (entries[0].isIntersecting) {
        loadMorePosts();
      }
    },
    {
      rootMargin: "0px",
      threshold: 1.0,
    },
  );

  if (loadMoreTrigger) loadObserver.observe(loadMoreTrigger);

  function loadMorePosts() {
    let lastPostDate = document
      .querySelector(".wp-block-post:last-child .date time")
      .getAttribute("datetime");

    loadObserver.unobserve(loadMoreTrigger);

    let catQuery = "";
    if (typeof ilThemeData !== "undefined" && ilThemeData.categoryId) {
      catQuery = `category_id=${ilThemeData.categoryId}`;
    }

    fetch(
      `/wordpress/wp-json/il-theme/v1/load-more-posts?date=${lastPostDate}&${catQuery}`,
    )
      .then((response) => response.json())
      .then((data) => {
        const postList = document.getElementById("posts");
        data.posts.forEach((post) => {
          const article = document.createElement("article");
          article.id = `post-${post.id}`;
          article.className = post.class + " wp-block-post";

          const date = new Date(post.date);
          const formattedDate = date
            .toISOString()
            .slice(0, 19)
            .replace("T", " ");
          const displayDate = new Intl.DateTimeFormat("en-US", {
            year: "numeric",
            month: "long",
            day: "numeric",
          }).format(date);

          article.innerHTML = `
            <section class="post__header">
              <h2 class='post__title wp-block-post-title'><a href="${post.link}">${post.title}</a></h2>
              <div class='date wp-block-post-date'>
                <time datetime='${formattedDate}'>${displayDate}</time>
              </div>  
            </section>
            <div class='entry-content post__text wp-block-post-content is-layout-flow wp-block-post-content-is-layout-flow'>
              <p>${post.content}</p></div>
          `;
          postList.appendChild(article);
        });

        if (data.hasMore) {
          lastPostDate = document
            .querySelector(".wp-block-post:last-child .date time")
            .getAttribute("datetime");
          loadObserver.observe(loadMoreTrigger);
        }
      });
  }
});
