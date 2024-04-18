import Swiper from "swiper";

const navigation = () => {
  const block = document.querySelector(".page-blog__nav");
  if (!block) return;

  const activeEl = block.querySelector(".page-blog__nav__link.current");
  const activeId = activeEl.getAttribute("data-category-loop-id");

  const swiper = new Swiper(block.querySelector(".swiper"), {
    speed: 500,
    slidesPerView: "auto",
    centeredSlidesBounds: true,
    centerInsufficientSlides: true,
    spaceBetween: 8,
    initialSlide: activeId,
    breakpoints: {
      767: {
        spaceBetween: 16,
      },
    },
  });
};

const loadMore = () => {
  const page = document.querySelector(".page-blog");
  if (!page) return;
  
  const category = page.getAttribute("data-category");
  const maxPage = page.getAttribute("data-max-page");
  const list = page.querySelector(".page-blog__posts");
  const btn = page.querySelector(".page-blog__more-btn");

  let currentPage = 1;
  let isLoading = false;

  async function addResults() {
    if (isLoading) return;

    const results = await getResults();

    if (results.success) {
      list.insertAdjacentHTML("beforeend", results.data);
    }

    if (currentPage >= maxPage) {
      btn.remove();
    }
  }

  async function getResults() {
    isLoading = true;

    const requestData = new URLSearchParams({
      action: "ct_theme_js_blog_load_more",
      category: category,
      page: ++currentPage,
    });

    try {
      const requestFetch = await fetch(ct_theme.ajaxurl, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: requestData.toString(),
      });

      const result = await requestFetch.json();

      isLoading = false;

      return result;
    } catch (error) {
      console.error("Error fetch request:", error);
      throw error;
    }
  }

  btn?.addEventListener("click", addResults);
};

export default () => {
  navigation();
  loadMore();
};
