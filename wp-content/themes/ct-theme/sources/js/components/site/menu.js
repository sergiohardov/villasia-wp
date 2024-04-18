import Accordion from "accordion-js";

class Menu {
  constructor(header) {
    this.header = header;

    this.Elements = {
      bar: this.header.querySelector(".site-header"),
      headerContainer: this.header.querySelector(".ct-container"),
      headerSearch: this.header.querySelector(".site-header__search"),

      menu: this.header.querySelector(".site-menu"),
      destination: this.header.querySelector(".site-menu__destination"),
      primary: this.header.querySelector(".site-menu__destination-primary"),
      secondary: this.header.querySelector(".site-menu__destination-secondary"),
      theme: this.header.querySelector(".site-menu__theme"),
      inner: this.header.querySelector(".site-menu__inner"),

      controlls: {
        burger: this.header.querySelector(".site-header__burger"),
        search: this.header.querySelector(".site-header__controls-search"),
        wishlist: this.header.querySelector(".site-header__controls-wishlist"),
        currency: this.header.querySelector(".site-header__controls-currency"),
        contact: this.header.querySelector(".site-header__controls-contact"),
      },

      collections: {
        secondary: this.header.querySelectorAll(
          ".site-menu__destination-secondary__item, .site-menu__secondary"
        ),
      }
    };

    this.State = {
      mainOpen: false,
      subOpen: false,
      media: {
        lg: window.matchMedia("(max-width: 992px)"),
        sm: window.matchMedia("(max-width: 576px)"),
      },
      accordions: {
        first: null,
        second: null,
      },
    };

    this.init();
  }

  init() {
    this.adaptiveMenus(this.State.media.lg);
    this.adaptiveSearch(this.State.media.sm);

    this.Elements.controlls.burger.addEventListener("click", this.handlerBurger.bind(this));
    this.Elements.destination.addEventListener("click", this.handlerDestination.bind(this));
    this.State.media.lg.addEventListener("change", this.adaptiveMenus.bind(this));
    this.State.media.sm.addEventListener("change", this.adaptiveSearch.bind(this));
  }

  handlerBurger() {
    const toActive = [this.header, this.Elements.controlls.burger, this.Elements.bar, this.Elements.menu];
    const toHidden = [
      this.Elements.controlls.search,
      this.Elements.controlls.wishlist,
      this.Elements.controlls.currency,
      this.Elements.controlls.contact,
    ];

    document.body.classList.toggle("ct-fixed");

    toActive.forEach((elem) => {
      elem.classList.toggle("active");
    });

    toHidden.forEach((elem) => {
      elem.classList.toggle("hidden");
    });

    if (this.State.mainOpen && this.State.subOpen) {
      this.toggleSubMenu("close");
    }

    this.State.mainOpen = !this.State.mainOpen;
  }
  handlerDestination(e) {
    const target = e.target;

    if (target.closest("a") && target.closest(".site-menu__primary")) {
      if (!this.State.media.lg.matches) e.preventDefault();
      this.toggleSubMenu("open");
      this.updateActiveMenu(target);
    }
  }
  toggleSubMenu(action) {
    if (action === "open" && !this.State.subOpen) {
      this.State.subOpen = true;

      this.Elements.theme.classList.remove("moved");
      this.Elements.secondary.classList.add("visible");
    } else if (action === "close" && this.State.subOpen) {
      this.State.subOpen = false;

      this.Elements.theme.classList.add("moved");
      this.Elements.secondary.classList.remove("visible");
    }
  }
  updateActiveMenu(target) {
    this.Elements.collections.secondary.forEach((item) => {
      item.classList.remove("active");
    });

    const idCountry = target.closest(".site-menu__destination-item").getAttribute("data-country-link-id");
    const idCity = target.getAttribute("data-area-link-id");

    const item = this.Elements.destination.querySelector(`[data-country-list-id="${idCountry}"]`);
    const list = this.Elements.destination.querySelector(`[data-area-list-id="${idCity}"]`);

    item.classList.add("active");
    list.classList.add("active");
  }

  adaptiveSearch(e) {
    if (e.matches) {
      this.Elements.inner.prepend(this.Elements.headerSearch);
    } else {
      this.Elements.headerContainer.append(this.Elements.headerSearch);
    }
  }
  adaptiveMenus(e) {
    if (e.matches) {
      this.State.accordions.first = new Accordion(this.Elements.inner, {
        elementClass: "site-menu-acc-first",
        triggerClass: "site-menu-acc-first__trigger",
        panelClass: "site-menu-acc-first__panel",
        activeClass: "active",
      });

      this.State.accordions.second = new Accordion(this.Elements.primary, {
        elementClass: "site-menu-acc-second",
        triggerClass: "site-menu-acc-second__trigger",
        panelClass: "site-menu-acc-second__panel",
        activeClass: "active",
      });
    } else {
      this.State.accordions.first?.destroy();
      this.State.accordions.second?.destroy();
    }
  }
}

export default () => {
  const header = document.querySelector(".site-header-wrapp");
  if (!header) return;

  new Menu(header);
};
