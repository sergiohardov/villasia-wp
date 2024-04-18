class PriceRepeater {
  constructor(block) {
    if (!block) return;

    this.Elements = {
      list: block.querySelector("#villaMetaboxPriceList"),
      row: block.querySelector("#villaMetaboxPriceRowClone"),
      rows: block.querySelectorAll(".villa-metabox-price__row"),
      btn: block.querySelector(".villa-metabox-price__btn"),
    };

    this.State = {
      count: this.Elements.rows.length,
    };

    this.init();
  }

  init() {
    this.Elements.btn.addEventListener("click", this.add.bind(this));
    this.Elements.list.addEventListener("click", this.remove.bind(this));
  }

  add() {
    const el = this.Elements.row.cloneNode(true);
    const inputs = el.querySelectorAll(".villa-metabox-price__input-bedrooms, .villa-metabox-price__input-price");

    el.removeAttribute("id");
    el.classList.remove("visually-hidden");
    el.classList.add("villa-metabox-price__row");

    inputs.forEach((input) => {
      const name = input.getAttribute("data-name") + `[${this.State.count}]` + input.getAttribute("data-key");
      input.setAttribute("name", name);
    });

    this.Elements.list.append(el);
    this.State.count++;
  }
  remove(e) {
    const target = e.target;

    if (target.closest(".villa-metabox-price__remove")) {
      const parent = target.closest(".villa-metabox-price__row");
      parent.remove();
      this.updateIndex();
      this.State.count--;
    }
  }
  updateIndex() {
    const rows = this.Elements.list.querySelectorAll(".villa-metabox-price__row");

    rows.forEach((row, idx) => {
      const inputs = row.querySelectorAll(".villa-metabox-price__input-bedrooms, .villa-metabox-price__input-price");
      inputs.forEach((item) => {
        const inputString = item.getAttribute("name");
        const newNumber = idx;

        item.setAttribute("name", inputString.replace(/\[\d+\]/, `[${newNumber}]`));
      });
    });
  }
}

class VillaMetaboxPrice {
  constructor(container) {
    this.Elements = {
      spinner: container.querySelector("#villaMetaboxPriceSpinner"),
      radioSync: container.querySelector("#villaMetaboxPriceRateSync"),
      addVillaRate: container.querySelector("#villaMetaboxPriceVillaRateAdd"),
      repeaterContainer: document.querySelector("#villaMetaboxPriceBlock"),
      select: {
        ownerId: acf.getField("field_6523f8914d3d2"),
        rateCard: container.querySelector("#villaMetaboxPriceRateSelect"),
      },
    };

    this.State = {
      villaRates: null,
      ownerRates: null,
      repeater: new PriceRepeater(document.querySelector("#villaMetaboxPriceRepeater")),
    };

    this.init();
  }

  async init() {
    this.State.villaRates = await this.getRates(document.querySelector("#post_ID").value);
    this.State.ownerRates = await this.getRates(this.Elements.select.ownerId.val());

    this.Elements.select.ownerId.on("change", this.handleSelectOwnerId.bind(this));
    this.Elements.radioSync.addEventListener("change", this.handleRadioSync.bind(this));
    this.Elements.select.rateCard.addEventListener("change", this.handleSelectRateCard.bind(this));
  }
  async handleSelectOwnerId() {
    const sync_status = this.Elements.radioSync.querySelector("input:checked").value;

    this.State.ownerRates = await this.getRates(this.Elements.select.ownerId.val());

    if (sync_status === "yes") {
      this.updateRateSelectOptions(this.State.ownerRates);
      this.switchVisiblePriceRepeater();
    }
  }
  handleRadioSync(e) {
    const target = e.target;

    if (target.closest("input")) {
      switch (target.value) {
        case "no":
          this.Elements.addVillaRate.classList.remove("visually-hidden");
          this.updateRateSelectOptions(this.State.villaRates);
          break;
        case "yes":
          this.Elements.addVillaRate.classList.add("visually-hidden");
          this.updateRateSelectOptions(this.State.ownerRates);
          break;
        default:
          break;
      }

      this.switchVisiblePriceRepeater(this.Elements.select.rateCard.value);
    }
  }
  handleSelectRateCard(e) {
    this.switchVisiblePriceRepeater(e.target.value);
  }

  updateRateSelectOptions(rates) {
    function addOption(field, value, label) {
      const el = document.createElement("option");
      el.setAttribute("value", value);
      el.innerHTML = label;
      field.append(el);
    }

    this.Elements.select.rateCard.innerHTML = '<option value="">- Select -</option>';

    if (rates) {
      Object.keys(rates).forEach((id) => {
        addOption(this.Elements.select.rateCard, id, rates[id]);
      });
    }
  }
  switchSpinner(status) {
    status ? this.Elements.spinner.classList.add("active") : this.Elements.spinner.classList.remove("active");
  }
  async switchVisiblePriceRepeater(rateId) {
    this.State.repeater = null;
    const html = await this.getRepeaterHtml(rateId);
    this.Elements.repeaterContainer.innerHTML = html;
    this.State.repeater = new PriceRepeater(document.querySelector("#villaMetaboxPriceRepeater"));
  }
  async getRates(id) {
    this.switchSpinner(true);

    const requestData = new URLSearchParams({
      action: "ct_core_js_get_rates_list",
      related_id: id,
    });

    try {
      const requestFetch = await fetch(ajaxurl, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: requestData.toString(),
      });

      const result = await requestFetch.json();

      this.switchSpinner(false);

      return result.success ? result.data : null;
    } catch (err) {
      console.error("Error fetch request:", err);
      throw err;
    }
  }
  async getRepeaterHtml(id) {
    this.switchSpinner(true);

    const requestData = new URLSearchParams({
      action: "ct_core_js_get_html_price_repeater",
      rate_id: id,
    });

    try {
      const requestFetch = await fetch(ajaxurl, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: requestData.toString(),
      });

      const result = await requestFetch.json();

      this.switchSpinner(false);

      return result.success ? result.data : null;
    } catch (err) {
      console.error("Error fetch request:", err);
      throw err;
    }
  }
}

export default () => {
  const container = document.querySelector("#villaMetaboxPrice");
  if (container) new VillaMetaboxPrice(container);
};
