class VillaMetaboxConditions {
  constructor(container) {
    this.Elements = {
      sync: container.querySelector("#villaConditionsSync"),
      inputData: container.querySelector("#villaConditionsData"),
      selects: {
        area: acf.getField("field_652d473ef1768"),
        owner: acf.getField("field_6523f8914d3d2"),
      },
      textareas: {
        rental: container.querySelector("#ownerConditionsRental"),
        reservation: container.querySelector("#ownerConditionsReservation"),
        cancellation: container.querySelector("#ownerConditionsCancellation"),
      },
    };

    this.State = {
      areaID: this.Elements.selects.area.val(),
      ownerID: this.Elements.selects.owner.val(),
      sync: this.Elements.sync.querySelector("input:checked").value,
      villaData: JSON.parse(this.Elements.inputData.value),
      ownerData: null,
    };

    this.boundHandleTyping = this.handleTyping.bind(this);
    this.boundHandleChange = this.handleChange.bind(this);

    this.init();
  }
  async init() {
    this.State.ownerData = await this.getOwnerConditions();
    this.toggleData();
    this.Elements.sync.addEventListener("change", this.handleSync.bind(this));
    this.Elements.selects.area.on("change", this.handleSelectArea.bind(this));
    this.Elements.selects.owner.on("change", this.handleSelectOwner.bind(this));
  }

  handleSync(e) {
    const target = e.target;
    if (target.closest("input")) {
      this.State.sync = target.value;
      this.toggleData();
    }
  }
  handleTyping(e) {
    switch (e.target) {
      case this.Elements.textareas.rental:
        this.State.villaData.rental = this.Elements.textareas.rental.value;
        break;
      case this.Elements.textareas.reservation:
        this.State.villaData.reservation = this.Elements.textareas.reservation.value;
        break;
      case this.Elements.textareas.cancellation:
        this.State.villaData.cancellation = this.Elements.textareas.cancellation.value;
        break;
      default:
        break;
    }
  }
  handleChange() {
    this.Elements.inputData.value = JSON.stringify(this.State.villaData);
    this.State.villaData = JSON.parse(this.Elements.inputData.value);
  }
  async handleSelectArea() {
    this.State.areaID = this.Elements.selects.area.val();
    this.State.ownerData = await this.getOwnerConditions();
    this.toggleData();
  }
  async handleSelectOwner() {
    this.State.ownerID = this.Elements.selects.owner.val();
    this.State.ownerData = await this.getOwnerConditions();
    this.toggleData();
  }

  toggleData() {
    switch (this.State.sync) {
      case "no":
        this.showData(this.State.villaData, false);
        break;
      case "yes":
        this.showData(this.State.ownerData, true);
        break;
      default:
        break;
    }
  }
  showData(dataObj, isReadOnly) {
    Object.keys(this.Elements.textareas).forEach((textarea) => {
      this.Elements.textareas[textarea].value = "";
      this.Elements.textareas[textarea].readOnly = isReadOnly;
      this.Elements.textareas[textarea].disabled = isReadOnly;

      if (isReadOnly) {
        this.Elements.textareas[textarea].removeEventListener("input", this.boundHandleTyping);
        this.Elements.textareas[textarea].removeEventListener("input", this.boundHandleChange);
      } else {
        this.Elements.textareas[textarea].addEventListener("input", this.boundHandleTyping);
        this.Elements.textareas[textarea].addEventListener("input", this.boundHandleChange);
      }

      if (dataObj && dataObj[textarea]) {
        this.Elements.textareas[textarea].value = dataObj[textarea];
      }
    });
  }
  async getOwnerConditions() {
    if (!this.State.areaID || !this.State.ownerID) return;
    try {
      const requestData = new URLSearchParams({
        action: "ct_core_js_get_owner_area_conditions",
        area_id: this.State.areaID,
        owner_id: this.State.ownerID,
      });
      const requestFetch = await fetch(ajaxurl, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: requestData.toString(),
      });
      const result = await requestFetch.json();
      return result.success ? result.data : null;
    } catch (error) {
      console.error("Error fetch request:", error);
      throw error;
    }
  }
}

export default () => {
  const container = document.querySelector("#villaMetaboxConditions");
  if (!container) return;
  new VillaMetaboxConditions(container);
};
