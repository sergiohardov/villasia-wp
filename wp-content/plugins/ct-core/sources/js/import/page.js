class ImportPage {
  constructor(container) {
    this.Elements = {
      container: container,
      inputs: {
        separator: container.querySelector("#ctcoreImportInputSeparator"),
        rewrite: container.querySelector("#ctcoreImportInputRewrite"),
        file: container.querySelector("#ctcoreImportInputFile"),
      },
      buttons: {
        start: container.querySelector("#ctcoreImportBtnStart"),
        stop: container.querySelector("#ctcoreImportBtnStop"),
      },
      progressbar: {
        percent: container.querySelector("#ctcoreImportProgressBarPercent"),
        message: container.querySelector("#ctcoreImportProgressBarDetail"),
        line: container.querySelector("#ctcoreImportProgressBarLine"),
      },
      details: container.querySelector("#ctcoreImportDetailsBody"),
    };

    this.State = {
      apiUrl: container.getAttribute("data-rest-url"),
      apiKey: container.getAttribute("data-api-key"),
      inProgress: false,
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

    this.Elements.buttons.start.addEventListener("click", this.handleStart.bind(this));
  }

  async handleStart() {
    if (this.State.inProgress) return;

    const checkInputs = this.checkInputs();
    if (checkInputs.length) return;

    const { separator, rewrite, file } = this.Elements.inputs;

    this.importStart();
    await this.importCore(separator.value, file.files[0], rewrite.checked);
    this.importEnd();
  }

  checkInputs() {
    const errorInputs = [];
    const { separator, file } = this.Elements.inputs;

    separator.classList.remove("border-danger");
    file.classList.remove("border-danger");

    if (separator.value === "") {
      separator.classList.add("border-danger");
      errorInputs.push("separator");
    }

    if (file.value === "") {
      file.classList.add("border-danger");
      errorInputs.push("file");
    }

    return errorInputs;
  }
  setMessageDetails(message) {
    const currentTime = this.getCurrentTime();

    this.Elements.progressbar.message.innerHTML = message;
    this.Elements.details.value += `${currentTime} - ${message}\n`;
    this.Elements.details.scrollTop = this.Elements.details.scrollHeight;
  }
  setPercent(percent) {
    this.Elements.progressbar.percent.innerHTML = percent + "%";
    this.Elements.progressbar.line.style.width = percent + "%";
  }
  getCurrentTime() {
    const now = new Date();
    const hours = now.getHours().toString().padStart(2, "0");
    const minutes = now.getMinutes().toString().padStart(2, "0");
    const seconds = now.getSeconds().toString().padStart(2, "0");

    const currentTime = `${hours}:${minutes}:${seconds}`;
    return currentTime;
  }
  importStart() {
    this.setPercent(0);
    this.Elements.details.value = "";
    this.State.inProgress = true;
    this.Elements.buttons.start.disabled = true;
    this.setMessageDetails("Import started...");
  }
  importEnd() {
    this.State.inProgress = false;
    this.Elements.buttons.start.disabled = false;
    this.setMessageDetails("Import end.");
  }

  async importCore(separator, file, rewrite) {
    this.setMessageDetails("Sending import file...");
    const sendFile = await this.Service.post("send_file", { file: file });
    this.setMessageDetails(sendFile.message);
    if (!sendFile || !sendFile.success) {
      this.setMessageDetails("Import filed.");
      return;
    }

    this.setMessageDetails("Getting parsed data...");
    const parsedData = await this.Service.get("get_parsed_data", {
      filename: sendFile.data.filename,
      separator: separator,
    });
    this.setMessageDetails(parsedData.message);
    if (!parsedData || !parsedData.success) {
      this.setMessageDetails("Import filed.");
      return;
    }

    let postIndex = 0;

    for (const item of parsedData.data) {
      this.setMessageDetails(`[${postIndex + 1}/${parsedData.data.length}] - Post iteration...`);

      this.setMessageDetails("Created country...");
      const createCountry = await this.Service.post("create_country", { country: item.country });
      this.setMessageDetails(createCountry.message);
      if (!createCountry || !createCountry.success) {
        this.setMessageDetails("Import filed.");
        return;
      }

      this.setMessageDetails("Created area...");
      const createArea = await this.Service.post("create_area", {
        area: item.area,
        country_id: createCountry.data.term_id,
      });
      this.setMessageDetails(createArea.message);
      if (!createArea || !createArea.success) {
        this.setMessageDetails("Import filed.");
        return;
      }

      this.setMessageDetails("Created city...");
      const createCity = await this.Service.post("create_city", {
        city: item.city,
        area_id: createArea.data.term_id,
      });
      this.setMessageDetails(createCity.message);
      if (!createCity || !createCity.success) {
        this.setMessageDetails("Import filed.");
        return;
      }

      this.setMessageDetails("Clear images folder...");
      const clearImagesFolder = await this.Service.get("clear_images_folder");
      this.setMessageDetails(clearImagesFolder.message);
      if (!clearImagesFolder || !clearImagesFolder.success) {
        this.setMessageDetails("Import filed.");
        return;
      }

      if (!rewrite) {
        this.setMessageDetails("Check is post exist...");
        const getPostByTitle = await this.Service.get("get_post_by_title", { title: item.villa_name });
        this.setMessageDetails(getPostByTitle.message);
        if (!getPostByTitle || !getPostByTitle.success) {
          this.setMessageDetails("Import filed.");
          return;
        } else if (getPostByTitle.data.post_id !== null) {
          this.setMessageDetails("Skip to next iteration.");
          postIndex++;
          this.setPercent(Math.round((postIndex / parsedData.data.length) * 100));
          continue;
        }
      }

      this.setMessageDetails("Getting dropbox images...");
      const getDropboxImages = await this.Service.post("get_dropbox_images", { link: item.lien_dropbox });
      this.setMessageDetails(getDropboxImages.message);
      if (!getDropboxImages || !getDropboxImages.success) {
        this.setMessageDetails("Import filed.");
        return; // or continue
      }

      this.setMessageDetails("Downloading images...");
      let imageIndex = 0;

      if (getDropboxImages.data.length) {
        for (const image of getDropboxImages.data) {
          this.setMessageDetails(`[${imageIndex + 1}/${getDropboxImages.data.length}] - Downloading images...`);
          const dowloadDropboxImage = await this.Service.post("download_dropbox_image", { path: image });
          this.setMessageDetails(dowloadDropboxImage.message);
          if (!dowloadDropboxImage || !dowloadDropboxImage.success) continue;
          imageIndex++;
        }
      }

      this.setMessageDetails("Creating or updating post...");
      const createPost = await this.Service.post("create_post", { data: JSON.stringify(item) });
      this.setMessageDetails(createPost.message);

      postIndex++;
      this.setPercent(Math.round((postIndex / parsedData.data.length) * 100));
    }
    return;
  }
}

export default () => {
  const container = document.querySelector("#ctcoreImportPage");
  if (container) new ImportPage(container);
};
