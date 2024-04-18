export default () => {
  const block = document.querySelector(".villa-navigation");
  if (!block) return;

  let scrollPosition = window.scrollY;
  let active = document.querySelector(".villa-navigation__item.active");

  const navItems = block.querySelectorAll(".villa-navigation__item");

  const obj = Array.from(navItems).reduce((acc, item) => {
    const id = item.querySelector("a").getAttribute("href");
    const el = document.querySelector(id);
    
    if (el) {
      const position = el.offsetTop - 150;
      acc[position] = item;
    }

    return acc;
  }, {});

  const handleScroll = () => {
    scrollPosition = window.scrollY;
    const currentKey = Object.keys(obj).reduce((acc, key) => (scrollPosition > key ? key : acc), Object.keys(obj)[0]);

    if (active !== obj[currentKey]) {
      active.classList.remove("active");
      obj[currentKey].classList.add("active");
      active = obj[currentKey];
    }
  };

  document.addEventListener("scroll", handleScroll);
};
