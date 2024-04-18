class CardBooking {
  constructor(block) {
    this.Elements = {
      title: block.querySelector("#cardBookingTitle"),
      thumbnail: block.querySelector("#cardBookingThumbnail"),
      content: block.querySelector("#cardBookingContent"),
      price: {
        container: block.querySelector("#cardBookingPriceContainer"),
        nights: block.querySelector("#cardBookingPriceNights"),
        total: block.querySelector("#cardBookingPriceTotal"),
        sub: block.querySelector("#cardBookingPriceSub"),
      },
      inputs: {
        checkIn: block.querySelector('[name="check_in"]'),
        checkOut: block.querySelector('[name="check_out"]'),
        bedrooms: block.querySelector('[name="bedroom"]'),
      },
      btns: {
        inquire: block.querySelector("#cardBookingBtnInquire"),
        check: block.querySelector("#cardBookingBtnCheck"),
      },
    };

    this.State = {
      delay: null,
      inLoading: false,
      isListenersAdded: false,
      villaId: null,
      inquireHref: null,
    };

    this.init();
  }
  init() {
    this.State.villaId = document.querySelector("[data-villa-id]").getAttribute("data-villa-id");
    this.State.inquireHref = this.Elements.btns.inquire.getAttribute("href");

    this.showData();

    this.Elements.btns.check?.addEventListener("click", this.handleBtn.bind(this));
  }
  handleBtn() {
    clearTimeout(this.State.delay);

    this.State.delay = setTimeout(() => {
      this.showData();
    }, 700);
  }
  async showData() {
    const inputsData = this.collectData();
    const priceData = await this.getVillaPrice(inputsData);
    if (!priceData) return;

    this.removeStartContent();

    this.Elements.title.innerHTML = this.Elements.title.getAttribute("data-alt-title");
    this.Elements.thumbnail.classList.add("active");
    this.Elements.price.container.classList.add("active");
    this.Elements.btns.inquire.classList.add("active");

    this.Elements.price.nights.innerHTML = priceData.nights || "-";
    this.Elements.price.total.innerHTML = priceData.price || "-";

    let html = "";

    if (priceData.sub) {
      html += `<p>${priceData.sub}</p>`;
    }
    
    if (priceData.discount) {
      html += `<p>Inclusive of a ${priceData.discount}% discount</p>`;
    }

    this.Elements.price.sub.innerHTML = html || "-";

    this.Elements.btns.inquire.setAttribute(
      "href",
      this.State.inquireHref +
        new URLSearchParams({
          villa_id: this.State.villaId,
          check_in: inputsData.checkIn,
          check_out: inputsData.checkOut,
          bedroom: inputsData.bedrooms,
        }).toString()
    );
  }
  collectData() {
    const result = {
      bedrooms: null,
      checkIn: null,
      checkOut: null,
    };

    Object.keys(this.Elements.inputs).forEach((item) => {
      const value = this.Elements.inputs[item].value;
      result[item] = value || null;
    });

    return result;
  }
  async getVillaPrice(data) {
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
  removeStartContent() {
    this.Elements.btns.check?.remove();
    this.Elements.content?.remove();

    if (!this.State.isListenersAdded) {
      this.Elements.inputs.checkIn.addEventListener("change", this.handleBtn.bind(this));
      this.Elements.inputs.checkOut.addEventListener("change", this.handleBtn.bind(this));
      this.Elements.inputs.bedrooms.addEventListener("change", this.handleBtn.bind(this));
      this.State.isListenersAdded = true;
    }
  }
}

export default () => {
  const block = document.querySelector(".card-booking");
  if (block) new CardBooking(block);
};
