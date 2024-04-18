const redirect = (page) => {
  const redirect = page.getAttribute("data-redirect-url");

  document.addEventListener(
    "wpcf7mailsent",
    function (event) {
      location = redirect;
    },
    false
  );
};

export default () => {
  const page = document.querySelector(".page-submit");
  if (!page) return;

  redirect(page);
};
