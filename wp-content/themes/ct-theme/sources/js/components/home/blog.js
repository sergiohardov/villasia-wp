import { Swiper } from "swiper";
import { Pagination } from "swiper/modules";

export default () => {
  const block = document.querySelector(".home-blog");
  if (!block) return;

  const mediaQuery = "(max-width: 768px)";
  const mediaQueryList = window.matchMedia(mediaQuery);

  let swiper = undefined;

  function applySlider(e) {
    if (e.matches) {
      swiper = new Swiper(block.querySelector(".home-blog__slider"), {
        modules: [Pagination],
        speed: 500,
        spaceBetween: 50,
        pagination: {
          el: block.querySelector(".home-blog__pagination"),
        },
      });
    } else {
      if (swiper !== undefined) swiper.destroy(true, true);
    }
  }

  applySlider(mediaQueryList);
  mediaQueryList.addEventListener("change", applySlider);
};
