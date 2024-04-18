import Swiper from "swiper";
import { Navigation, Pagination } from "swiper/modules";

// TODO: Disable sliders on mob
export default () => {
  const blocks = document.querySelectorAll(".card-villa");

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
      slidesPerView: 1,
    });
  });
};
