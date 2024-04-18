
  class Theme {
    constructor(block) {
      const container = block.querySelector(".search-bar__theme");
      if (!container) return;
  
      this.Elements = {
        select: block.querySelector(".search-bar__theme .search-bar__secondary-dropdown__toggle"),
        container: block.querySelector(".search-bar__theme-list"),
        list: block.querySelectorAll(".search-bar__theme-list input"),
        reset: block.querySelector(".search-bar__theme .search-bar__secondary-dropdown__reset"),
      };
  
      this.State = {
        selected: [],
      };
  
      this.init();
    }
  
    init() {
      this.setStateData();
      this.updateSelectBtnCount();
      this.Elements.container.addEventListener("change", this.handleChange.bind(this));
      this.Elements.reset.addEventListener("click", this.handleReset.bind(this));
    }
  
    setStateData() {
      this.Elements.list.forEach((input) => {
        if (input.checked) {
          this.State.selected.push(input);
        }
      });
    }
  
    updateSelectBtnCount() {
      const defaultText = this.Elements.select.getAttribute("data-default-text");
      const altText = this.Elements.select.getAttribute("data-alt-text");
  
      if (this.State.selected.length > 0) {
        this.Elements.select.innerHTML = `${altText} <span>(${this.State.selected.length})</span>`;
      } else {
        this.Elements.select.innerHTML = defaultText;
      }
    }
  
    handleChange(e) {
      const target = e.target;
  
      if (target.closest(".search-bar__theme-input")) {
        const id = this.State.selected.indexOf(target);
  
        if (id === -1) {
          this.State.selected.push(target);
        } else {
          this.State.selected.splice(id, 1);
        }
  
        this.updateSelectBtnCount();
      }
    }
  
    handleReset() {
      this.Elements.list.forEach((input) => (input.checked = false));
      this.State.selected = [];
      this.updateSelectBtnCount();
    }
  }
  class Feature {
    constructor(block) {
      const container = block.querySelector(".search-bar__more");
      if (!container) return;
  
      this.Media = window.matchMedia("(max-width: 768px)");
  
      this.Elements = {
        select: block.querySelector(".search-bar__more .search-bar__secondary-dropdown__toggle"),
        container: block.querySelector(".search-bar__more-popular"),
        list: {
          rating: block.querySelectorAll(".search-bar__more-rating input"),
          feature: block.querySelectorAll(".search-bar__more-popular .ct-checkbox"),
        },
        moreBtn: block.querySelector(".search-bar__more-show"),
        reset: block.querySelector(".search-bar__more .search-bar__secondary-dropdown__reset"),
      };
  
      this.State = {
        selected: [],
        isMoreOpen: false,
  
        getRows: () => {
          return this.Media.matches ? 7 : 4;
        },
  
        getFeatureItemHeight: () => {
          return this.Elements.list.feature[0].clientHeight;
        },
        getFeatureItemsRowGap: () => {
          const styles = getComputedStyle(this.Elements.container);
          return styles.getPropertyValue("row-gap").replace(/[^0-9]/g, "");
        },
      };
  
      this.init();
    }
  
    init() {
      this.setStateData();
      this.updateSelectBtnCount();
      this.setFeatureListHeight();
      this.Elements.container.addEventListener("change", this.handleChange.bind(this));
      this.Elements.reset.addEventListener("click", this.handleReset.bind(this));
      this.Elements.moreBtn.addEventListener("click", this.handleShowMoreBtn.bind(this));
      this.Media.addEventListener("change", this.setFeatureListHeight.bind(this));
    }
  
    setStateData() {
      this.Elements.list.feature.forEach((item) => {
        const input = item.querySelector("input");
        if (input.checked) {
          this.State.selected.push(input);
        }
      });
    }
  
    updateSelectBtnCount() {
      const defaultText = this.Elements.select.getAttribute("data-default-text");
      const altText = this.Elements.select.getAttribute("data-alt-text");
  
      if (this.State.selected.length > 0) {
        this.Elements.select.innerHTML = `${altText} <span>(${this.State.selected.length})</span>`;
      } else {
        this.Elements.select.innerHTML = defaultText;
      }
    }
  
    handleChange(e) {
      const target = e.target;
  
      if (target.closest(".search-bar__more-input")) {
        const id = this.State.selected.indexOf(target);
  
        if (id === -1) {
          this.State.selected.push(target);
        } else {
          this.State.selected.splice(id, 1);
        }
  
        this.updateSelectBtnCount();
      }
    }
  
    handleReset() {
      this.Elements.list.rating.forEach((input) => (input.checked = false));
      this.Elements.list.feature.forEach((item) => {
        const input = item.querySelector("input");
        input.checked = false;
      });
  
      this.State.selected = [];
      this.updateSelectBtnCount();
    }
  
    handleShowMoreBtn() {
      this.State.isMoreOpen = !this.State.isMoreOpen;
  
      if (this.State.isMoreOpen) {
        this.Elements.container.style.maxHeight = "";
        this.Elements.moreBtn.classList.add("active");
        this.Elements.moreBtn.querySelector("span").innerHTML = this.Elements.moreBtn.getAttribute("data-alt-text");
      } else {
        this.setFeatureListHeight(this.State.rows);
        this.Elements.moreBtn.classList.remove("active");
        this.Elements.moreBtn.querySelector("span").innerHTML = this.Elements.moreBtn.getAttribute("data-default-text");
      }
    }
  
    setFeatureListHeight() {
      const height =
        this.State.getFeatureItemHeight() * this.State.getRows() +
        this.State.getFeatureItemsRowGap() * (this.State.getRows() - 1);
      this.Elements.container.style.maxHeight = height + "px";
    }
  }
  class Modal {
    constructor(block) {
      const container = block.querySelector(".search-bar__modal");
      if (!container) return;
  
      this.Elements = {
        trigger: block.querySelector(".search-bar__mob-filters"),
        close: block.querySelector(".search-bar__modal__header-close"),
        reset: block.querySelector(".search-bar__modal__footer-reset"),
        modal: block.querySelector(".search-bar__modal"),
        movement: block.querySelector(".search-bar__secondary"),
        content: block.querySelector(".search-bar__modal__content"),
        form: block.querySelector(".search-bar__form"),
        inputs: {
          price: {
            from: block.querySelector("#fromSlider"),
            to: block.querySelector("#toSlider"),
          },
          promotion: block.querySelector("[name='promotions'][value='off']"),
          themes: block.querySelectorAll(".search-bar__theme-input"),
          populars: block.querySelectorAll(".search-bar__more-input"),
          rating: block.querySelector("[name='rating'][value='all']"),
        },
      };
  
      this.State = {
        isOpen: false,
        mediaQuery: window.matchMedia("(max-width: 768px)"),
        event: new Event("input", {
          bubbles: true,
          cancelable: true,
        }),
      };
  
      this.init();
    }
    init() {
      this.movingElems(this.State.mediaQuery);
  
      this.State.mediaQuery.addEventListener("change", this.movingElems.bind(this));
      this.Elements.trigger.addEventListener("click", this.handleTrigger.bind(this));
      this.Elements.close.addEventListener("click", this.handleClose.bind(this));
      this.Elements.reset.addEventListener("click", this.handleReset.bind(this));
    }
    handleTrigger() {
      if (!this.State.isOpen) {
        this.Elements.modal.classList.add("active");
        document.body.classList.add("ct-fixed");
        this.State.isOpen = true;
      }
    }
    handleClose() {
      if (this.State.isOpen) {
        this.Elements.modal.classList.remove("active");
        document.body.classList.remove("ct-fixed");
        this.State.isOpen = false;
      }
    }
    handleReset() {
      this.Elements.inputs.price.from.value = this.Elements.inputs.price.from.min;
      this.Elements.inputs.price.to.value = this.Elements.inputs.price.to.max;
      this.Elements.inputs.price.from.dispatchEvent(this.State.event);
      this.Elements.inputs.price.to.dispatchEvent(this.State.event);
  
      this.Elements.inputs.promotion.checked = true;
      this.Elements.inputs.rating.checked = true;
  
      this.Elements.inputs.themes.forEach((item) => {
        item.checked = false;
      });
      this.Elements.inputs.populars.forEach((item) => {
        item.checked = false;
      });
    }
    movingElems(e) {
      if (e.matches) {
        this.Elements.content.append(this.Elements.movement);
      } else {
        this.Elements.form.append(this.Elements.movement);
      }
    }
  }
  
  export default () => {
    const block = document.querySelector(".search-bar");
    if (!block) return;

    new Theme(block);
    new Feature(block);
    new Modal(block);
  };
  