import Swiper from "swiper";
import { Navigation, Pagination } from "swiper/modules";

export default () => {
  const blocks = document.querySelectorAll(".slider-locations");
  blocks?.forEach((block) => {
    const swiper = new Swiper(block.querySelector(".swiper"), {
      modules: [Navigation, Pagination],
      navigation: {
        prevEl: block.querySelector(".swiper-button-prev"),
        nextEl: block.querySelector(".swiper-button-next"),
      },
      pagination: {
        el: block.querySelector(".swiper-pagination"),
      },
      breakpoints: {
        577: {
          slidesPerView: 2,
          spaceBetween: 24,
        },
        769: {
          slidesPerView: 3,
          spaceBetween: 24,
        },
      },
    });
  });
};
