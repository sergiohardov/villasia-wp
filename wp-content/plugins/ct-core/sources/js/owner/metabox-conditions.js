class OwnerMetaboxConditions {
  constructor(container) {
    this.Elements = {
      location: acf.getField("field_651d55b83c7ca"),
      data: container.querySelector("#ownerConditionsData"),
      fields: container.querySelector("#ownerConditionsFields"),
      info: container.querySelector("#ownerConditionsInfo"),
      select: container.querySelector("#ownerConditionsSelect"),
      rental: container.querySelector("#ownerConditionsRental"),
      reservation: container.querySelector("#ownerConditionsReservation"),
      cancellation: container.querySelector("#ownerConditionsCancellation"),
    };

    this.State = {
      data: JSON.parse(this.Elements.data.value),
      selectID: 0,
    };

    this.Data = {
      location_label: "",
      rental: "",
      reservation: "",
      cancellation: "",
    };

    this.init();
  }
  init() {
    this.setOptions();

    this.Elements.location.on("change", this.handleMainLocation.bind(this));
    this.Elements.select.addEventListener("change", this.handleSelect.bind(this));
    this.Elements.fields.addEventListener("input", this.handleInputTyping.bind(this));
    this.Elements.fields.addEventListener("change", this.handleInputChange.bind(this));
  }

  handleMainLocation() {
    const locationsID = this.Elements.location.val();
    const locationsElems = document.querySelectorAll(".select2-selection__choice");

    // ADD
    locationsID.forEach((item, idx) => {
      if (!this.State.data.hasOwnProperty(item)) {
        this.State.data[item] = { ...this.Data };
        this.State.data[item].location_label = locationsElems[idx].getAttribute("title");
      }
    });

    Object.keys(this.State.data).forEach((item) => {
      if (!locationsID.includes(item)) {
        delete this.State.data[item];
      }
    });

    if (locationsID.length === 0) {
      this.Elements.fields.classList.add("hidden");
      this.Elements.info.classList.remove("hidden");
    } else {
      this.Elements.fields.classList.remove("hidden");
      this.Elements.info.classList.add("hidden");
    }

    this.Elements.data.value = JSON.stringify(this.State.data);
    this.State.data = JSON.parse(this.Elements.data.value);

    this.setOptions();
  }
  handleSelect(e) {
    this.State.selectID = e.target.value;
    this.updateFields();
  }
  handleInputTyping(e) {
    const data = this.State.data[this.State.selectID];

    switch (e.target) {
      case this.Elements.rental:
        data.rental = this.Elements.rental.value;
        break;
      case this.Elements.reservation:
        data.reservation = this.Elements.reservation.value;
        break;
      case this.Elements.cancellation:
        data.cancellation = this.Elements.cancellation.value;
        break;
      default:
        break;
    }
  }
  handleInputChange() {
    this.Elements.data.value = JSON.stringify(this.State.data);
    this.State.data = JSON.parse(this.Elements.data.value);
  }

  setOptions() {
    this.Elements.select.innerHTML = "";

    Object.keys(this.State.data).forEach((item, idx) => {
      const el = document.createElement("option");
      el.setAttribute("value", item);
      el.innerHTML = this.State.data[item].location_label;
      this.Elements.select.append(el);

      if (idx === 0) {
        this.State.selectID = item;
        this.updateFields();
      }
    });
  }
  updateFields() {
    const data = this.State.data[this.State.selectID];

    this.Elements.rental.value = data.rental;
    this.Elements.reservation.value = data.reservation;
    this.Elements.cancellation.value = data.cancellation;
  }
}

export default () => {
  const container = document.querySelector("#ownerConditionsMetabox");
  if (!container) return;
  if (typeof acf === "undefined") return;

  new OwnerMetaboxConditions(container);
};
