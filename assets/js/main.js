window.addEventListener("scroll", function () {
  const header = document.querySelector("header");
  if (window.scrollY > 0) {
    header.classList.add("scrolled");
  } else {
    header.classList.remove("scrolled");
  }
});

const postsContainer = document.querySelector(".wp-block-query");
const paginationContainer = document.querySelector(
  ".wp-block-query-pagination"
);
let currentPage = 1;
let maxPages = 1;

function loadMorePostsMain(page) {
  fetch(`/wordpress/wp-json/iltheme/v1/load-more-posts-main?page=${page}`)
    .then((response) => response.json())
    .then((data) => {
      const posts = data.posts;
      maxPages = data.max_num_pages;

      postsContainer.innerHTML = "";

      // Append new posts
      posts.forEach((post) => {
        const article = document.createElement("article");
        article.id = `post-${post.id}`;
        article.className = post.class;
        article.innerHTML = `
          <section class="post__header">
            <h2 class="post__title"><a href="${post.link}">${
          post.title
        }</a></h2>
            <div class="post__date"><time datetime="${post.date}">${new Date(
          post.date
        ).toLocaleDateString()}</time></div>
          </section>
          <div class="post__text">${post.excerpt}</div>
        `;
        postsContainer.appendChild(article);
      });

      // Update pagination
      updatePagination(page);
    });
}

function updatePagination(page) {
  paginationContainer.innerHTML = "";

  if (page > 1) {
    const prevLink = document.createElement("a");
    prevLink.href = "#";
    prevLink.className = "query-pagination-previous";
    prevLink.textContent = "Previous";
    prevLink.addEventListener("click", function (event) {
      event.preventDefault();
      loadMorePostsMain(page - 1);
    });
    paginationContainer.appendChild(prevLink);
  }

  if (page < maxPages) {
    const nextLink = document.createElement("a");
    nextLink.href = "#";
    nextLink.className = "query-pagination-next";
    nextLink.textContent = "Next";
    nextLink.addEventListener("click", function (event) {
      event.preventDefault();
      loadMorePostsMain(page + 1);
    });
    paginationContainer.appendChild(nextLink);
  }
}

document.addEventListener("DOMContentLoaded", function () {
  const options = {
    root: null,
    rootMargin: "0px",
    threshold: 0.2,
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

  let fetching = false;

  const loadObserver = new IntersectionObserver(
    (entries) => {
      if (entries[0].isIntersecting) {
        if (!fetching) {
          fetching = true;
          loadMorePosts();
        }
      }
    },
    {
      rootMargin: "0px",
      threshold: 1.0,
    }
  );

  if (loadMoreTrigger) loadObserver.observe(loadMoreTrigger);

  function loadMorePosts() {
    const loader = document.getElementById("loader");
    loader.style.display = "block";

    let lastPostDate = document
      .querySelector(".wp-block-post:last-child .date time")
      .getAttribute("datetime");

    const lastPreviousPostDateElement = document.querySelector(
      "#previous .wp-block-post:last-child .date time"
    );

    if (lastPreviousPostDateElement) {
      lastPostDate = lastPreviousPostDateElement.getAttribute("datetime");
    }

    loadObserver.unobserve(loadMoreTrigger);

    let catQuery = "";
    if (typeof ilThemeData !== "undefined" && ilThemeData.categoryId) {
      catQuery = `category_id=${ilThemeData.categoryId}`;
    }

    fetch(
      `/wordpress/wp-json/iltheme/v1/load-more-posts?date=${lastPostDate}&${catQuery}`
    )
      .then((response) => response.json())
      .then((data) => {
        const postList = document.getElementById("previous");
        data.posts.forEach((post) => {
          const article = document.createElement("article");
          article.id = `post-${post.id}`;
          article.className = post.class + " wp-block-post";

          const date = new Date(post.date);
          const formattedDate = date
            .toISOString()
            .slice(0, 19)
            .replace("T", " ");
          const displayDate = new Intl.DateTimeFormat("sv-SE", {
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

        loader.style.display = "none";
        fetching = false;
      });
  }

  // Initial load
  loadMorePostsMain(currentPage);
});
