import Swiper from "swiper";
import { Navigation, Pagination } from "swiper/modules";

export default () => {
  const section = document.querySelector(".home-instagram");
  if (!section) return;

  const swiper = new Swiper(section.querySelector(".swiper"), {
    modules: [Navigation, Pagination],
    navigation: {
      prevEl: section.querySelector(".swiper-button-prev"),
      nextEl: section.querySelector(".swiper-button-next"),
    },
    pagination: {
      el: section.querySelector(".swiper-pagination"),
    },
    slidesPerView: 2,
    spaceBetween: 6,
    breakpoints: {
      576: {
        slidesPerView: 3,
        spaceBetween: 24,
      },
      768: {
        slidesPerView: 4,
        spaceBetween: 24,
      },
    },
  });
};
