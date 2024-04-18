class MapContent {
  constructor(page) {
    this.Elements = {
      containers: {
        main: page.querySelector("#mainContainer"),
        map: page.querySelector("#mapContainer"),
      },
      btns: {
        showDesk: page.querySelector("#btnShowDeskMap"),
        showMob: page.querySelector("#btnShowMobMap"),
        close: page.querySelector("#btnCloseMap"),
      },
    };

    this.init();
  }
  init() {
    this.Elements.btns.showDesk.addEventListener("click", this.handleBtnShow.bind(this));
    this.Elements.btns.showMob.addEventListener("click", this.handleBtnShow.bind(this));
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
  const input = page.querySelector("#searchInputOrder");

  select.addEventListener("change", (e) => {
    input.value = e.target.value;
  });
  console.log(select);
};

export default () => {
  const page = document.querySelector(".page-general");
  if (!page) return;

  new MapContent(page);
  orderInput(page);
};
