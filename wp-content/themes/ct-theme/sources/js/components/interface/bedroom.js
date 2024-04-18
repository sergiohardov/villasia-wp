class Bedroom {
  constructor(block) {
    this.Elements = {
      input: block.querySelector(".ct-interface-item__input"),
      controlls: block.querySelector(".interface-bedroom__controlls"),
      counter: block.querySelector("#interfaceCounterBedroom"),
    };

    this.State = {
      isOpenCounter: false,
      value: this.Elements.counter.value,
    };

    this.init();
  }

  init() {
    document.addEventListener("click", this.handleTrigger.bind(this));
    this.Elements.counter.addEventListener("change", this.handleCounter.bind(this));
  }
  handleTrigger(e) {
    const target = e.target;

    if (target.closest(".interface-bedroom") && !this.State.isOpenCounter) {
      this.Elements.controlls.classList.add("active");
      this.State.isOpenCounter = true;
    } else if (!target.closest(".interface-bedroom__controlls") && this.State.isOpenCounter) {
      this.Elements.controlls.classList.remove("active");
      this.State.isOpenCounter = false;
    }
  }
  handleCounter() {
    this.State.value = this.Elements.counter.value;
    this.updateUI();
  }
  updateUI() {
    if (this.State.value === "0") {
      this.Elements.input.innerHTML = this.Elements.input.getAttribute("data-default-text");
    } else {
      this.Elements.input.innerHTML = this.State.value + " Bedrooms";
    }
  }
}

export default () => {
  const block = document.querySelector(".interface-bedroom");
  if (!block) return;

  new Bedroom(block);
};
