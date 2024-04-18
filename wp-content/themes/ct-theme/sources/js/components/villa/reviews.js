class Reviews {
  constructor(block) {
    this.Elements = {
      btn: block.querySelector(".villa-reviews__btn"),
      list: block.querySelector(".villa-reviews__list"),
      items: block.querySelectorAll(".villa-reviews__item"),
    };

    if (!this.Elements.list) return;

    this.State = {
      isOpen: false,
      text: {
        default: this.Elements.btn?.getAttribute("data-default-text"),
        alt: this.Elements.btn?.getAttribute("data-alt-text"),
      },
      height: {
        min: this.setListHeight(),
        max: Array.from(this.Elements.items).reduce((acc, item) => acc + item.offsetHeight + 16, 0),
      },
    };

    this.init();
  }

  init() {
    this.Elements.list.style.maxHeight = this.State.height.min + "px";
    this.Elements.btn?.addEventListener("click", this.toggleHeight.bind(this));
  }

  setListHeight() {
    let result = 0;

    if (this.Elements.items.length > 2) {
      result = this.Elements.items[0].offsetHeight + this.Elements.items[1].offsetHeight + 16;
    } else {
      result = this.Elements.list.offsetHeight;
    }

    return result;
  }
  toggleHeight() {
    this.isOpen = !this.isOpen;

    if (this.isOpen) {
      this.Elements.list.style.maxHeight = this.State.height.max + "px";
      this.Elements.btn.classList.add("active");
      this.Elements.btn.innerHTML = this.State.text.alt;
    } else {
      this.Elements.list.style.maxHeight = this.State.height.min + "px";
      this.Elements.btn.classList.remove("active");
      this.Elements.btn.innerHTML = this.State.text.default;
    }
  }
}

export default () => {
  const block = document.querySelector(".villa-reviews");
  if (!block) return;

  new Reviews(block);
};
