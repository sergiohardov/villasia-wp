import { Swiper } from "swiper";
import { Pagination } from "swiper/modules";

export default () => {
  const section = document.querySelector(".home-promotions");
  if (!section) return;

  const Elements = {
    items: section.querySelectorAll(".home-promotions__item--hidden"),
    btn: section.querySelector(".home-promotions__more"),
    swiper: section.querySelector(".home-promotions__cards"),
    pagination: section.querySelector(".home-promotions__pagination"),
  };

  const State = {
    opened: false,
  };

  let swiper = undefined;

  const mediaQuery = "(max-width: 768px)";
  const mediaQueryList = window.matchMedia(mediaQuery);

  function displayNone(e) {
    const item = e.target;
    item.style.display = "none";
    item.removeEventListener("transitionend", displayNone);
  }

  function toggleMore() {
    if (!State.opened) {
      Elements?.items.forEach((item) => {
        item.style.display = "block";
        item.style.maxHeight = item.scrollHeight + "px";
      });

      Elements.btn.classList.add("active");
      Elements.btn.textContent = Elements.btn.getAttribute("data-text-alt");
      State.opened = true;
    } else {
      Elements?.items.forEach((item) => {
        item.style.maxHeight = 0;
        item.addEventListener("transitionend", displayNone);
      });

      Elements.btn.classList.remove("active");
      Elements.btn.textContent = Elements.btn.getAttribute("data-text-default");
      State.opened = false;
    }
  }

  function applySlider(e) {
    if (e.matches) {
      swiper = new Swiper(Elements.swiper, {
        modules: [Pagination],
        speed: 500,
        spaceBetween: 50,
        pagination: {
          el: Elements.pagination,
        },
      });
    } else {
      if (swiper !== undefined) swiper.destroy(true, true);
    }
  }

  applySlider(mediaQueryList);

  Elements.btn?.addEventListener("click", toggleMore);
  mediaQueryList.addEventListener("change", applySlider);
};
