class Destination {
  constructor(block) {
    this.Elements = {
      input: block.querySelector(".ct-interface-item__input"),
      clear: block.querySelector(".interface-destination__clear"),
      results: block.querySelector(".interface-destination__results"),
      hidden: block.querySelector('[name="destination"]'),
    };

    this.State = {
      timeout: null,
      isOpenResults: false,
      value: "",
      response: [],
    };

    this.init();
  }

  init() {
    this.Elements.input.addEventListener("input", this.handleInput.bind(this));
    this.Elements.clear.addEventListener("click", this.handleClear.bind(this));
    document.addEventListener("click", this.handleResults.bind(this));
  }
  handleInput(e) {
    clearTimeout(this.State.timeout);
    if (e.target.value.length < 3) return;

    this.setStateValue(e.target.value);
    this.setElementsHiddenValue(e.target.value);

    this.State.timeout = setTimeout(() => {
      this.getResults().then(() => this.showResults());
    }, 500);
  }
  handleClear() {
    clearTimeout(this.State.timeout);
    this.setStateValue("");
    this.setElementsInputValue("");
    this.setElementsHiddenValue("");
    this.closeResults();
  }
  handleResults(e) {
    const target = e.target;

    if (target.closest("li") && target.closest(".interface-destination__results")) {
      const id = target.closest("li").getAttribute("data-destination-id");
      const text = target.textContent;

      this.setStateValue(id);
      this.setElementsHiddenValue(id);
      this.setElementsInputValue(text);
      this.closeResults();
    } else if (!target.closest(".interface-destination__results") && this.State.isOpenResults) {
      this.closeResults();
    }
  }
  showResults() {
    let html = "";

    this.State.response.forEach((item) => {
      html += `<li data-destination-id=${item.id}><span>${item.name}</span></li>`;
    });

    this.Elements.results.innerHTML = html;
    this.Elements.results.classList.add("active");
    this.State.isOpenResults = true;
  }
  closeResults() {
    this.Elements.results.classList.remove("active");
    this.Elements.results.innerHTML = "";
    this.State.isOpenResults = false;
  }
  async getResults() {
    if (!this.State.value) return;

    const requestData = new URLSearchParams({
      action: "ct_theme_js_search_get_locations",
      value: this.State.value,
    });

    try {
      const requestFetch = await fetch(ct_theme.ajaxurl, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: requestData.toString(),
      });

      const result = await requestFetch.json();

      this.State.response = result.data;

      return result.success;
    } catch (error) {
      console.error("Error fetch request:", error);
      throw error;
    }
  }
  setStateValue(val) {
    this.State.value = val;
    return val;
  }
  setElementsHiddenValue(val) {
    this.Elements.hidden.value = val;
    this.Elements.hidden.dispatchEvent(new Event("change"));
    return val;
  }
  setElementsInputValue(val) {
    this.Elements.input.value = val;
    this.Elements.input.dispatchEvent(new Event("change"));
    return val;
  }
}

export default () => {
  const block = document.querySelector(".interface-destination");
  if (!block) return;

  new Destination(block);
};
