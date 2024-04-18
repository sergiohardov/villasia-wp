class Guests {
  constructor(block) {
    this.Elements = {
      input: block.querySelector(".ct-interface-item__input"),
      controlls: block.querySelector(".interface-guests__controlls"),
      counters: {
        adults: block.querySelector("#interfaceCounterAdults"),
        children: block.querySelector("#interfaceCounterChildren"),
      },
    };

    this.State = {
      isOpenControlls: false,
      value: {
        adults: this.Elements.counters.adults.value,
        children: this.Elements.counters.children.value,
      },
    };

    this.init();
  }

  init() {
    document.addEventListener("click", this.handleTrigger.bind(this));
    this.Elements.counters.adults.addEventListener("change", this.handleCounterAdult.bind(this));
    this.Elements.counters.children.addEventListener("change", this.handleCounterChildren.bind(this));
  }

  handleTrigger(e) {
    const target = e.target;

    if (target.closest(".interface-guests") && !this.State.isOpenControlls) {
      this.Elements.controlls.classList.add("active");
      this.State.isOpenControlls = true;
    } else if (!target.closest(".interface-guests__controlls") && this.State.isOpenControlls) {
      this.Elements.controlls.classList.remove("active");
      this.State.isOpenControlls = false;
    }
  }
  handleCounterAdult() {
    this.State.value.adults = this.Elements.counters.adults.value;
    this.updateUI();
  }
  handleCounterChildren() {
    this.State.value.children = this.Elements.counters.children.value;
    this.updateUI();
  }
  updateUI() {
    const arr = [];

    if (this.State.value.adults !== "0") {
      arr.push(this.State.value.adults + " Adults");
    }

    if (this.State.value.children !== "0") {
      arr.push(this.State.value.children + " Children");
    }

    if (this.State.value.adults === "0" && this.State.value.children === "0") {
      arr.push(this.Elements.input.getAttribute("data-default-text"));
    }

    this.Elements.input.innerHTML = arr.join(", ");
  }
}

export default () => {
  const block = document.querySelector(".interface-guests");
  if (!block) return;

  new Guests(block);
};
