const sticky = (page) => {
  const el = page.querySelector(".page-managment__cta");

  const observer = new IntersectionObserver(
    ([e]) => e.target.classList.toggle("page-managment__cta--sticky", e.intersectionRatio < 1),
    { threshold: [1] }
  );

  observer.observe(el);
};

export default () => {
  const page = document.querySelector(".page-managment");
  if (!page) return;

  sticky(page);
};
