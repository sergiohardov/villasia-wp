class PromotionsRepeater {
  constructor(block) {
    this.Elements = {
      owner: acf.getField("field_6523f8914d3d2"),
      container: block.querySelector("#VillaMetaboxPromotionsRepeaterItems"),
      clone: block.querySelector("#VillaMetaboxPromotionsRepeaterClone"),
      button: block.querySelector("#VillaMetaboxPromotionsRepeaterAdd"),
    };

    this.State = {
      clone: this.Elements.clone.querySelector("div"),
      get_owner_id: () => {
        return this.Elements.owner.val();
      },
      get_promotions: async (id) => {
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
      },
    };

    this.init();
  }

  init() {
    this.Elements.clone.remove();

    this.Elements.owner.on("change", this.handleOwner.bind(this));
    this.Elements.button.addEventListener("click", this.addItem.bind(this));
    this.Elements.container.addEventListener("click", this.removeItem.bind(this));
  }
  async handleOwner() {
    function addOption(field, value, label) {
      const el = document.createElement("option");
      el.setAttribute("value", value);
      el.innerHTML = label;
      field.append(el);
    }

    const ownerId = this.State.get_owner_id();
    const data = await this.State.get_promotions(ownerId);
    const select = this.State.clone.querySelector("select");

    this.Elements.container.innerHTML = "";
    select.innerHTML = "";

    addOption(select, "", "- Select -");

    if (Object.keys(data)) {
      Object.keys(data).forEach((id) => {
        addOption(select, id, data[id]);
      });
    }
  }
  addItem() {
    const el = this.State.clone.cloneNode(true);
    this.Elements.container.insertAdjacentElement("beforeend", el);
  }
  removeItem(e) {
    const button = e.target.closest("button");

    if (button) {
      const parent = button.parentElement;
      parent.remove();
    }
  }
}

export default () => {
  const container = document.querySelector("#VillaMetaboxPromotions");
  if (container) new PromotionsRepeater(container);
};
