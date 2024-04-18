import * as fecha from "fecha";
import HotelDatepicker from "hotel-datepicker";

class Check {
  constructor(block) {
    this.Elements = {
      container: block,
      inputPicker: block.querySelector("#interfaceCheckInputPicker"),
      textareaBooked: block.querySelector("#interfaceCheckTextareaBooked"),
      checkIn: {
        input: block.querySelector("#interfaceCheckInputCheckIn"),
        label: block.querySelector("#interfaceCheckLabelCheckIn"),
        title: block.querySelector("#interfaceCheckTitleCheckIn"),
      },
      checkOut: {
        input: block.querySelector("#interfaceCheckInputCheckOut"),
        label: block.querySelector("#interfaceCheckLabelCheckOut"),
      },
    };

    this.State = {
      datepicker: null,
      adaptive: Number(this.Elements.container.getAttribute("data-adaptive")),
      mediaQuery: window.matchMedia("(max-width: 1200px)"),
    };

    this.init();
  }
  init() {
    this.State.datepicker = this.datepickerSetup();
    this.Elements.container.addEventListener("click", this.datepickerOpen.bind(this));

    if (this.State.adaptive === 1) {
      this.adaptive(this.State.mediaQuery);
      this.State.mediaQuery.addEventListener("change", this.adaptive.bind(this));
    }
  }
  datepickerSetup() {
    const datepicker = new HotelDatepicker(this.Elements.inputPicker, {
      showTopbar: false,
      animationSpeed: ".5s",
      hoveringTooltip: () => false,
      onSelectRange: () => this.datepickerSelectRange(),
      disabledDates: JSON.parse(this.Elements.textareaBooked.value),
    });

    const checkIn = this.Elements.checkIn.input.value;
    const checkOut = this.Elements.checkOut.input.value;

    if (checkIn && checkOut) {
      datepicker.setRange(checkIn, checkOut);
      this.setLabels(checkIn, checkOut);
    }

    return datepicker;
  }
  datepickerOpen() {
    this.State.datepicker.open();
  }
  datepickerGetValue() {
    const value = this.State.datepicker.getValue();
    return value ? value.split(" - ") : [null, null];
  }
  datepickerSelectRange() {
    const [checkin, checkout] = this.datepickerGetValue();

    this.Elements.checkIn.input.value = checkin;
    this.Elements.checkOut.input.value = checkout;

    this.setLabels(checkin, checkout);
  }
  setLabels(checkin, checkout) {
    if (!checkin || !checkout) return false;

    if (this.State.adaptive === 1 && this.State.mediaQuery.matches) {
      this.Elements.checkIn.label.innerHTML = this.altFormatDate(checkin) + " - " + this.altFormatDate(checkout);
    } else {
      this.Elements.checkIn.label.innerHTML = this.formatDate(checkin);
      this.Elements.checkOut.label.innerHTML = this.formatDate(checkout);
    }
  }

  adaptive(e) {
    const [checkin, checkout] = this.datepickerGetValue();

    if (e.matches) {
      this.Elements.checkIn.title.innerHTML = "Travel Dates";
    } else {
      this.Elements.checkIn.title.innerHTML = "Check-in";
    }

    this.setLabels(checkin, checkout);
  }
  formatDate(val) {
    if (!val) return null;

    const date = new Date(val);
    const options = { weekday: "short", month: "2-digit", day: "2-digit", year: "2-digit" };
    return new Intl.DateTimeFormat("en-US", options).format(date);
  }
  altFormatDate(val) {
    if (!val) return null;
    const date = new Date(val);
    const day = date.getDate();
    const month = date.toLocaleString("en-US", { month: "short" });

    // const options = { day: '2-digit', month: 'short' };
    // result = new Intl.DateTimeFormat('en-US', options).format(date);
    return `${day} ${month}`;
  }
}

export default () => {
  const block = document.querySelector(".interface-check");
  if (block) new Check(block);
};
