import Swiper from "swiper";
import { Pagination } from "swiper/modules";

export default () => {
  const section = document.querySelector(".villa-related");
  if (!section) return;

  const swiper = new Swiper(section.querySelector(".villa-related__swiper"), {
    modules: [Pagination],
    slidesPerView: 1,
    spaceBetween: 24,
    pagination: {
      el: section.querySelector(".villa-related__pagination"),
    },
    breakpoints: {
      567: {
        slidesPerView: 2,
      },
      992: {
        slidesPerView: 3,
      },
    },
  });
};
