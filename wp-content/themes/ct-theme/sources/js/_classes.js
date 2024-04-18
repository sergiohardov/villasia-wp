export class DraggableScroll {
  constructor(selector) {
    if (typeof selector === "string") {
      this.element = document.querySelector(selector);
    } else if (selector instanceof Element) {
      this.element = selector;
    } else {
      throw new Error("Invalid argument. Please provide a selector or an element.");
    }

    if (!this.element) {
      throw new Error(`Element with selector '${selector}' not found.`);
    }

    this.element.style.cursor = "grab";
    this.element.style.overflow = "auto";

    this.pos = { top: 0, left: 0, x: 0, y: 0 };

    this.mouseDownHandler = this.mouseDownHandler.bind(this);
    this.mouseMoveHandler = this.mouseMoveHandler.bind(this);
    this.mouseUpHandler = this.mouseUpHandler.bind(this);

    this.element.addEventListener("mousedown", this.mouseDownHandler);
  }
  mouseDownHandler(e) {
    this.element.style.cursor = "grabbing";
    this.element.style.userSelect = "none";

    this.pos = {
      left: this.element.scrollLeft,
      top: this.element.scrollTop,
      x: e.clientX,
      y: e.clientY,
    };

    this.element.addEventListener("mousemove", this.mouseMoveHandler);
    this.element.addEventListener("mouseup", this.mouseUpHandler);
  }
  mouseMoveHandler(e) {
    const dx = e.clientX - this.pos.x;
    const dy = e.clientY - this.pos.y;

    this.element.scrollTop = this.pos.top - dy;
    this.element.scrollLeft = this.pos.left - dx;
  }
  mouseUpHandler() {
    this.element.style.cursor = "grab";
    this.element.style.removeProperty("user-select");

    this.element.removeEventListener("mousemove", this.mouseMoveHandler);
    this.element.removeEventListener("mouseup", this.mouseUpHandler);
  }
}
export class CookieUtill {
  constructor() {}
  static get(name) {
    let matches = document.cookie.match(
      new RegExp("(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, "\\$1") + "=([^;]*)")
    );
    return matches ? decodeURIComponent(matches[1]) : undefined;
  }

  static set(name, value, options = {}) {
    options = {
      path: "/",
      ...options,
    };

    if (options.expires instanceof Date) {
      options.expires = options.expires.toUTCString();
    }

    let updatedCookie = encodeURIComponent(name) + "=" + encodeURIComponent(value);

    for (let optionKey in options) {
      updatedCookie += "; " + optionKey;
      let optionValue = options[optionKey];
      if (optionValue !== true) {
        updatedCookie += "=" + optionValue;
      }
    }

    document.cookie = updatedCookie;
  }

  static delete(name) {
    setCookie(name, "", {
      "max-age": -1,
    });
  }
}
