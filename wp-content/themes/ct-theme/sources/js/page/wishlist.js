class MapContent {
  constructor(page) {
    this.Elements = {
      containers: {
        main: page.querySelector("#mainContainer"),
        map: page.querySelector("#mapContainer"),
      },
      btns: {
        show: page.querySelector("#btnShowMap"),
        close: page.querySelector("#btnCloseMap"),
      },
    };

    this.init();
  }
  init() {
    this.Elements.btns.show.addEventListener("click", this.handleBtnShow.bind(this));
    this.Elements.btns.close.addEventListener("click", this.handleBtnClose.bind(this));
  }
  handleBtnShow() {
    this.Elements.containers.main.classList.add("map-open");
  }
  handleBtnClose() {
    this.Elements.containers.main.classList.remove("map-open");
  }
}

const orderInput = (page) => {
  const select = page.querySelector("#generalOrderSelect");
  
  let url = window.location.href;

  select.addEventListener("change", (e) => {
    if (url.indexOf("?") > -1) {
      url += "&order=" + e.target.value;
    } else {
      url += "?order=" + e.target.value;
    }
    window.location.href = url;
  });
};

export default () => {
  const page = document.querySelector(".page-wishlist");
  if (!page) return;

  new MapContent(page);
  orderInput(page);
};
