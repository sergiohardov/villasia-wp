class VillaPageRating {
  constructor(page) {
    this.Elements = {
      update: {
        container: page.querySelector(".villa-page-rating__update"),
        btn: page.querySelector(".villa-page-rating__update-btn button"),
        spinner: page.querySelector(".villa-page-rating__update-btn .spinner"),
      },
      status: {
        container: page.querySelector(".villa-page-rating__update-status"),
        textarea: page.querySelector(".villa-page-rating__update-status textarea"),
      },
      list: {
        bg: page.querySelector(".villa-page-rating__list-bg"),
      },
    };

    this.State = {
      loading: false,
      apiKey: page.getAttribute("data-api-key"),
      apiUrl: page.getAttribute("data-rest-url"),
    };

    this.Service = {
      get: async (action, data = {}) => {
        const params = new URLSearchParams({
          api_key: this.State.apiKey,
          ...data,
        });

        try {
          const request = await fetch(this.State.apiUrl + action + "?" + params.toString());
          const response = await request.json();

          return response;
        } catch (error) {
          return { success: false, message: "Error: Problem in fetch request. Message: " + error };
        }
      },
      post: async (action, data = {}) => {
        const formData = new FormData();
        formData.append("api_key", this.State.apiKey);

        Object.keys(data).forEach((item) => {
          formData.append(item, data[item]);
        });

        try {
          const request = await fetch(this.State.apiUrl + action, { method: "POST", body: formData });
          const response = await request.json();

          return response;
        } catch (error) {
          return { success: false, message: "Error: Problem in fetch request. Message: " + error };
        }
      },
    };

    this.init();
  }

  init() {
    this.Elements.update.btn.addEventListener("click", this.handleUpdateBtn.bind(this));
  }

  handleUpdateBtn() {
    if (this.State.loading) return;

    this.Elements.status.textarea.value = "";
    this.State.loading = true;

    this.toggleSpinner();
    this.updateRating();
  }

  async updateRating() {
    this.updateStatus("Starting update...");

    const getVillaIds = await this.Service.get("get_villa_ids");
    this.updateStatus(getVillaIds.message);
    if (!getVillaIds || !getVillaIds.success) {
      this.updateStatus("Proccess filed.");
      return;
    }

    const posts = getVillaIds.data;

    if (posts) {
      this.updateStatus("Starting loop...");

      for (const [step, id] of posts.entries()) {
        this.updateStatus(`[${step + 1}/${posts.length}] Start work with villa - [${id}]...`);

        const getPlaceId = await this.Service.get("get_villa_place_id", { villa_id: id });
        this.updateStatus(getPlaceId.message);
        if (!getPlaceId || !getPlaceId.success) continue;

        const { place_id } = getPlaceId.data;

        const getVillaPlaceDetails = await this.Service.get("get_villa_place_details", { place_id: place_id });
        this.updateStatus(getVillaPlaceDetails.message);
        if (!getVillaPlaceDetails || !getVillaPlaceDetails.success) continue;

        const { rating, reviews } = getVillaPlaceDetails.data.place_data;

        if (rating) {
          const setVillaRating = await this.Service.post("set_villa_rating", { villa_id: id, rating: rating });
          this.updateStatus(setVillaRating.message);
        }

        if (reviews) {
          const setVillaReviews = await this.Service.post("set_villa_reviews", {
            villa_id: id,
            reviews: JSON.stringify(reviews),
          });
          this.updateStatus(setVillaReviews.message);
        }
      }
    }

    this.State.loading = false;
    this.toggleSpinner();
    this.updateStatus("Ending of update!");
    this.Elements.list.bg.classList.add("active");
  }

  toggleSpinner() {
    if (this.State.loading) {
      this.Elements.update.btn.setAttribute("disabled", "");
      this.Elements.update.spinner.style.visibility = "visible";
    } else {
      this.Elements.update.btn.removeAttribute("disabled");
      this.Elements.update.spinner.style.visibility = "hidden";
    }
  }
  handleError(errorMsg) {
    console.warn(errorMsg);
    this.updateStatus(errorMsg);
    this.State.loading = false;
    this.toggleSpinner();
  }
  updateStatus(text) {
    this.Elements.status.textarea.value += this.getCurrentTime() + " - " + text + "\n";
    this.Elements.status.textarea.scrollTop = this.Elements.status.textarea.scrollHeight;
  }
  getCurrentTime() {
    const now = new Date();
    const hours = now.getHours().toString().padStart(2, "0");
    const minutes = now.getMinutes().toString().padStart(2, "0");
    const seconds = now.getSeconds().toString().padStart(2, "0");

    const currentTime = `${hours}:${minutes}:${seconds}`;
    return currentTime;
  }
}

export default () => {
  const page = document.querySelector(".villa-page-rating");
  if (!page) return;

  new VillaPageRating(page);
};
