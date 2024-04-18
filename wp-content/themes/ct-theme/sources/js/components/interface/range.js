class Range {
  constructor(block) {
    this.Colors = {
      primary: "#FE2260",
      secondary: "#D0D1D0",
    };

    this.Elements = {
      range: {
        from: block.querySelector("#interfaceRangeInputFrom"),
        to: block.querySelector("#interfaceRangeInputTo"),
      },
      label: {
        from: block.querySelector("#interfaceRangeLabelFrom"),
        to: block.querySelector("#interfaceRangeLabelTo"),
      },
    };

    this.init();
  }

  init() {
    this.updateToZindex();
    this.fillSlider();

    this.Elements.range.from.addEventListener("input", this.handleInputFrom.bind(this));
    this.Elements.range.to.addEventListener("input", this.handleInputTo.bind(this));
  }

  handleInputFrom() {
    const [from, to] = this.getParsed(this.Elements.range.from, this.Elements.range.to);

    if (from > to) {
      this.Elements.range.from.value = to;
    } else {
      //   console.log(from);
      this.Elements.label.from.innerHTML = from.toLocaleString("en-US");
    }

    this.fillSlider();
  }
  handleInputTo() {
    const [from, to] = this.getParsed(this.Elements.range.from, this.Elements.range.to);

    if (from <= to) {
      //   console.log(to);
      this.Elements.range.to.value = to;
      this.Elements.label.to.innerHTML = to.toLocaleString("en-US");
    } else {
      this.Elements.range.to.value = from;
    }

    this.updateToZindex();
    this.fillSlider();
  }
  getParsed(rangeFrom, rangeTo) {
    const from = parseInt(rangeFrom.value, 10);
    const to = parseInt(rangeTo.value, 10);
    return [from, to];
  }
  fillSlider() {
    const from = this.Elements.range.from;
    const to = this.Elements.range.to;

    const rangeDistance = to.max - to.min;
    const fromPosition = from.value - to.min;
    const toPosition = to.value - to.min;

    to.style.background = `linear-gradient(
              to right,
              ${this.Colors.secondary} 0%,
              ${this.Colors.secondary} ${(fromPosition / rangeDistance) * 100}%,
              ${this.Colors.primary} ${(fromPosition / rangeDistance) * 100}%,
              ${this.Colors.primary} ${(toPosition / rangeDistance) * 100}%, 
              ${this.Colors.secondary} ${(toPosition / rangeDistance) * 100}%, 
              ${this.Colors.secondary} 100%)`;
  }
  updateToZindex() {
    const [from, to] = this.getParsed(this.Elements.range.from, this.Elements.range.to);

    if (Number(to) <= from) {
      this.Elements.range.to.style.zIndex = 2;
    } else {
      this.Elements.range.to.style.zIndex = 0;
    }
  }
}

export default () => {
  const blocks = document.querySelectorAll(".interface-range");
  blocks?.forEach((block) => new Range(block));
};
