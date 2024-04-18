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

class Form {
  constructor(page) {
    this.Elements = {
      hiddenInput: {
        checkIn: page.querySelector('[name="contact-check-in"]'),
        checkOut: page.querySelector('[name="contact-check-out"]'),
        bedroom: page.querySelector('[name="contact-bedroom"]'),
        villaName: page.querySelector('[name="contact-villa-name"]'),
        price: page.querySelector('[name="contact-price"]'),
        nights: page.querySelector('[name="contact-nights"]'),
        location: page.querySelector('[name="contact-location"]'),
      },
      visibleInput: {
        checkIn: page.querySelector('.interface-check [name="check_in"]'),
        checkOut: page.querySelector('.interface-check [name="check_out"]'),
        bedroom: page.querySelector('.interface-bedroom [name="bedroom"]'),
      },
      textElem: {
        checkIn: page.querySelector("#infoValueCheckIn"),
        checkOut: page.querySelector("#infoValueCheckOut"),
        bedroom: page.querySelector("#infoValueBedroom"),
        villaName: page.querySelector("#infoVillaName"),
        price: page.querySelector("#infoValuePrice"),
        nights: page.querySelector("#infoValueNights"),
        location: page.querySelector("#infoVillaLocation"),
        sub: page.querySelector("#infoValueSub"),
      },
    };

    this.State = {
      delay: null,
      villaId: page.querySelector("#villaID").value,
      inLoading: false,
    };

    this.init();
  }
  init() {
    // Set static inputs (villa name + villa location)
    this.Elements.hiddenInput.villaName.value = this.Elements.textElem.villaName.innerHTML;
    this.Elements.hiddenInput.location.value = this.Elements.textElem.location.innerHTML;

    // Set dynamic inputs
    this.showData();
    this.Elements.visibleInput.checkIn.addEventListener("change", this.handleChange.bind(this));
    this.Elements.visibleInput.checkOut.addEventListener("change", this.handleChange.bind(this));
    this.Elements.visibleInput.bedroom.addEventListener("change", this.handleChange.bind(this));
  }
  handleChange() {
    clearTimeout(this.State.delay);

    this.State.delay = setTimeout(() => {
      this.showData();
    }, 700);
  }
  async showData() {
    const inputsData = this.collectData();
    const priceData = await this.getPriceData(inputsData);
    if (!priceData) return;

    this.Elements.hiddenInput.checkIn.value = inputsData.checkIn;
    this.Elements.hiddenInput.checkOut.value = inputsData.checkOut;
    this.Elements.hiddenInput.bedroom.value = inputsData.bedrooms;
    this.Elements.hiddenInput.nights.value = priceData.nights || "-";
    this.Elements.hiddenInput.price.value = priceData.price || "-";

    this.Elements.textElem.checkIn.innerHTML = this.dateFormatToCard(inputsData.checkIn);
    this.Elements.textElem.checkOut.innerHTML = this.dateFormatToCard(inputsData.checkOut);
    this.Elements.textElem.bedroom.innerHTML = inputsData.bedrooms + " Bedrooms"; // TODO: Fix bedrooms word (no translate ready)
    this.Elements.textElem.nights.innerHTML = priceData.nights || "-";
    this.Elements.textElem.price.innerHTML = priceData.price || "-";

    let html = "";

    if (priceData.sub) {
      html += `<p>${priceData.sub}</p>`;
    }

    if (priceData.discount) {
      html += `<p>Inclusive of a ${priceData.discount}% discount</p>`;
    }

    this.Elements.textElem.sub.innerHTML = html || "-";
  }
  collectData() {
    const result = {
      checkIn: this.Elements.visibleInput.checkIn.value || null,
      checkOut: this.Elements.visibleInput.checkOut.value || null,
      bedrooms: this.Elements.visibleInput.bedroom.value || 0,
    };

    return result;
  }
  async getPriceData(data) {
    if (Object.values(data).includes(null)) return null;
    if (this.State.inLoading) return;

    this.State.inLoading = true;

    const requestData = new URLSearchParams({
      action: "ct_theme_get_booking_details",
      villa_id: this.State.villaId,
      check_in: data.checkIn,
      check_out: data.checkOut,
      bedrooms: data.bedrooms,
    });

    try {
      const requestFetch = await fetch(ct_theme.ajaxurl, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: requestData.toString(),
      });

      const result = await requestFetch.json();

      this.State.inLoading = false;

      return result.success ? result.data : null;
    } catch (error) {
      console.error("Error fetch request:", error);
      throw error;
    }
  }
  dateFormatToCard(timestamp) {
    const date = new Date(timestamp);
    const options = { weekday: "long", day: "numeric", month: "long", year: "numeric" };
    const formattedDate = date.toLocaleDateString("en-GB", options);

    return formattedDate;
  }
}

export default () => {
  const page = document.querySelector(".page-inquiry");
  if (!page) return;

  redirect(page);
  new Form(page);
};
