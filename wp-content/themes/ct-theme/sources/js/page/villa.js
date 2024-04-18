class Sidebar {
  constructor(page) {
    this.Elements = {
      btn: page.querySelector("#villaPageSidebarToggle"),
      close: page.querySelector("#villaPageSidebarClose"),
      sidebar: page.querySelector("#villaPageSidebarBlock"),
    };

    this.State = {
      isOpen: false,
    };

    this.init();
  }
  init() {
    this.Elements.btn.addEventListener("click", this.open.bind(this));
    this.Elements.close.addEventListener("click", this.close.bind(this));
  }

  open() {
    if (this.State.isOpen) return;

    this.Elements.sidebar.classList.add("active");
    document.body.classList.add("ct-fixed");
    this.State = true;
  }
  close(e) {
    const target = e.target;
    
    if (target.closest("#villaPageSidebarClose")) {
      this.Elements.sidebar.classList.remove("active");
      document.body.classList.remove("ct-fixed");
      this.State = false;
    }
  }
}

export default () => {
  const page = document.querySelector(".page-villa");
  if (!page) return;

  new Sidebar(page);
};
