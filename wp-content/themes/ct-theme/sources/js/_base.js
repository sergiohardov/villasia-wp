export const headerHeight = () => {
  const header = document.querySelector(".site-header-wrapp");
  if (!header) return;

  const root = document.querySelector(":root");
  const height = header.offsetHeight;

  root.style.setProperty("--site-header-height", height + "px");
};

export const dropdown = () => {
  const obj = {
    dropdown: null,
    handler(e) {
      const dropdown = e.target.closest(".ct-dropdown");

      // TODO: click in open drop menu (fix close, example dropdown for location/destination in searchbar)
      if (dropdown) {
        // e.preventDefault();

        if (dropdown === this.dropdown) {
          // this.close();
        } else {
          this.close();
          this.dropdown = dropdown;
          this.open();
        }
      } else {
        this.close();
      }
    },
    open() {
      this.dropdown.querySelector(".ct-dropdown__toggle").classList.add("ct-dropdown__toggle--open");
      this.dropdown.querySelector(".ct-dropdown__menu").classList.add("ct-dropdown__menu--open");
    },
    close() {
      if (this.dropdown) {
        this.dropdown.querySelector(".ct-dropdown__toggle").classList.remove("ct-dropdown__toggle--open");
        this.dropdown.querySelector(".ct-dropdown__menu").classList.remove("ct-dropdown__menu--open");
        this.dropdown = null;
      }
    },
  };

  document.addEventListener("click", obj.handler.bind(obj));
};

export const tabs = () => {
  const handleClick = (e) => {
    const tab = e.target.closest(".ct-tabs__nav-item");

    if (tab && !tab.classList.contains("ct-tabs__nav-item--active")) {
      const parent = tab.closest(".ct-tabs");
      const navItems = parent.querySelectorAll(".ct-tabs__nav .ct-tabs__nav-item");
      const contentItems = parent.querySelectorAll(".ct-tabs__content .ct-tabs__content-item");

      navItems.forEach((navItem, index) => {
        const isActiveTab = navItem === tab;
        navItem.classList.toggle("ct-tabs__nav-item--active", isActiveTab);
        if (contentItems[index]) {
          contentItems[index].classList.toggle("ct-tabs__content-item--active", isActiveTab);
        }
      });
    }
  };

  document.addEventListener("click", handleClick);
};

export const googleMaps = () => {
  ((g) => {
    var h,
      a,
      k,
      p = "The Google Maps JavaScript API",
      c = "google",
      l = "importLibrary",
      q = "__ib__",
      m = document,
      b = window;
    b = b[c] || (b[c] = {});
    var d = b.maps || (b.maps = {}),
      r = new Set(),
      e = new URLSearchParams(),
      u = () =>
        h ||
        (h = new Promise(async (f, n) => {
          await (a = m.createElement("script"));
          e.set("libraries", [...r] + "");
          for (k in g)
            e.set(
              k.replace(/[A-Z]/g, (t) => "_" + t[0].toLowerCase()),
              g[k]
            );
          e.set("callback", c + ".maps." + q);
          a.src = `https://maps.${c}apis.com/maps/api/js?` + e;
          d[q] = f;
          a.onerror = () => (h = n(Error(p + " could not load.")));
          a.nonce = m.querySelector("script[nonce]")?.nonce || "";
          m.head.append(a);
        }));
    d[l]
      ? console.warn(p + " only loads once. Ignoring:", g)
      : (d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n)));
  })({ key: "AIzaSyCDhRFczczBuQTL0TcnwVrHybP9JnKOwvY", v: "beta" }); // TODO: Hide api
};
