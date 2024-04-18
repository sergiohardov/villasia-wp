export default () => {
  const block = document.querySelector(".home-hero");
  if (!block) return;

  const search = block.querySelector(".search-bar");
  const innerContainer = block.querySelector(".home-hero__content__inner");
  const outerContainer = block.querySelector(".home-hero__outer .ct-container");

  const mediaQuery = "(max-width: 768px)";
  const mediaQueryList = window.matchMedia(mediaQuery);

  function moveSearch(matches) {
    if (matches) {
      outerContainer.append(search);
    } else {
      innerContainer.append(search);
    }
  }

  moveSearch(mediaQueryList.matches);

  mediaQueryList.addEventListener("change", (e) => {
    moveSearch(e.matches);
  });
};
