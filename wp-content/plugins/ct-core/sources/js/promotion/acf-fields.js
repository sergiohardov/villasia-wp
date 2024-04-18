class PeriodFields {
  constructor() {
    this.Elements = {
      related: acf.getField("field_658d9040100aa"),
      ratecard: acf.getField("field_651eb4fff98ed"),
      offer: acf.getField("field_651eb60cf98f4"),
    };

    this.State = {
      postID: document.querySelector("#post_ID")?.value,
    };

    if (!this.Elements.related || !this.Elements.ratecard || !this.Elements.offer) return;

    this.init();
  }

  init() {
    this.Elements.related.on("change", this.handleRelated.bind(this));
  }

  async handleRelated() {
    const relatedID = this.Elements.related.val();
    const rates = await this.getRates(relatedID);
    const promotions = await this.getPromotions(relatedID);

    const selectRatecard = this.Elements.ratecard.$input()[0];
    const selectOffer = this.Elements.offer.$input()[0];

    selectRatecard.innerHTML = '<option value="">- Select -</option>';
    selectOffer.innerHTML = '<option value="">- Select -</option>';

    if (rates) {
      Object.keys(rates).forEach((id) => {
        this.addOption(selectRatecard, id, rates[id]);
      });
    }

    if (promotions) {
      Object.keys(promotions).forEach((id) => {
        if (this.State.postID !== id) {
          this.addOption(selectOffer, id, promotions[id]);
        }
      });
    }
  }

  async getRates(id) {
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

      return result.success ? result.data : null;
    } catch (err) {
      console.error("Error fetch request:", err);
      throw err;
    }
  }
  // TODO: Updated return value need test
  async getPromotions(id) {
    const requestData = new URLSearchParams({
      action: "ct_core_js_get_promotions_list",
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

      return result.success ? result.data : null;
    } catch (err) {
      console.log(err);
      return null;
    }
  }

  addOption(field, value, label) {
    const el = document.createElement("option");
    el.setAttribute("value", value);
    el.innerHTML = label;
    field.append(el);
  }
}

export default () => {
  if (typeof acf === "undefined") return;

  new PeriodFields();
};
