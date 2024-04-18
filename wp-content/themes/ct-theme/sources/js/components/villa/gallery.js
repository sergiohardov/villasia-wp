import { Fancybox } from "@fancyapps/ui/";

export default () => {
  const block = document.querySelector(".villa-gallery");
  if (!block) return;

  Fancybox.bind('[data-fancybox="villa-gallery"]', {
    id: "villa-gallery",
    Thumbs: {
      type: "classic",
      
      // TODO: test modal desing
      // Carousel: {
      //   axis: "y",
      // },
    },
  });
};
