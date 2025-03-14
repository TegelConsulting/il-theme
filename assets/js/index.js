window.addEventListener("DOMContentLoaded", () => {
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

  loadMorePostsMain(currentPage);
});
