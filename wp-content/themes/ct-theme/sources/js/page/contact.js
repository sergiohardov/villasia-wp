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
const additional = (page) => {
  const form = page.querySelector(".page-contact__form");

  const Elements = {
    hidden: {
      destination: form.querySelector('[name="contact-destination"]'),
      checkIn: form.querySelector('[name="contact-check-in"]'),
      checkOut: form.querySelector('[name="contact-check-out"]'),
      nights: form.querySelector('[name="contact-nights"]'),
      adults: form.querySelector('[name="contact-adults"]'),
      children: form.querySelector('[name="contact-children"]'),
    },
    visible: {
      destination: form.querySelector(".interface-destination .ct-interface-item__input"),
      checkIn: form.querySelector('.interface-check [name="check_in"]'),
      checkOut: form.querySelector('.interface-check [name="check_out"]'),
      adults: form.querySelector('.interface-guests [name="adults"]'),
      children: form.querySelector('.interface-guests [name="children"]'),
    },
  };

  function timestampNights(start, end) {
    let date1 = new Date(start);
    let date2 = new Date(end);

    let diffTime = Math.abs(date2 - date1);
    let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    return diffDays;
  }

  Elements.visible.destination.addEventListener("change", (e) => {
    Elements.hidden.destination.value = e.target.value;
  });

  Elements.visible.checkIn.addEventListener("change", (e) => {
    Elements.hidden.checkIn.value = Elements.visible.checkIn.value;
    Elements.hidden.nights.value = timestampNights(Elements.visible.checkIn.value, Elements.visible.checkOut.value);
  });

  Elements.visible.checkOut.addEventListener("change", (e) => {
    Elements.hidden.checkOut.value = Elements.visible.checkOut.value;
    Elements.hidden.nights.value = timestampNights(Elements.visible.checkIn.value, Elements.visible.checkOut.value);
  });

  Elements.visible.adults.addEventListener("change", (e) => {
    Elements.hidden.adults.value = e.target.value;
  });

  Elements.visible.children.addEventListener("change", (e) => {
    Elements.hidden.children.value = e.target.value;
  });
};

export default () => {
  const page = document.querySelector(".page-contact");
  if (!page) return;

  redirect(page);
  additional(page);
};
