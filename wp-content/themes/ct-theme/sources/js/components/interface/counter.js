class Counter {
  constructor(block) {
    this.Elements = {
      minus: block.querySelector(".interface-counter__minus"),
      input: block.querySelector(".interface-counter__input"),
      plus: block.querySelector(".interface-counter__plus"),
    };

    this.State = {
      value: this.Elements.input.value,
    };

    this.init();
  }

  init() {
    this.Elements.minus.addEventListener("click", this.handleMinus.bind(this));
    this.Elements.plus.addEventListener("click", this.handlePlus.bind(this));
    this.Elements.input.addEventListener("input", this.handleInput.bind(this));
  }

  handleMinus() {
    this.changeValue(-1);
    this.updateInput();
  }
  handlePlus() {
    this.changeValue(1);
    this.updateInput();
  }
  handleInput() {
    this.State.value = Math.max(0, this.Elements.input.value);
    this.updateInput();
  }
  changeValue(delta) {
    this.State.value = Math.max(0, parseInt(this.State.value) + delta);
  }
  updateInput() {
    this.Elements.input.value = this.State.value;
    this.Elements.input.dispatchEvent(new Event("change"));
  }
}

export default () => {
  const blocks = document.querySelectorAll(".interface-counter");
  if (!blocks) return;
  blocks.forEach((block) => {
    new Counter(block);
  });
};
