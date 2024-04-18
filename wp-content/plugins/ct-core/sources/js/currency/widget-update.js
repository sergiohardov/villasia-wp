const widgetUpdate = (block) => {
  const btn = block.querySelector("#currencyWidgetUpdateBtn");
  const spinner = block.querySelector("#currencyWidgetUpdateBtnSpinner");
  let isLoading = false;

  async function handleBtn() {
    await updateCurrencies();
  }

  function toggleSpinner() {
    if (isLoading) {
      btn.disabled = true;
      spinner.classList.remove("visually-hidden");
    } else {
      btn.disabled = false;
      spinner.classList.add("visually-hidden");
    }
  }

  async function updateCurrencies() {
    if (isLoading) return;

    isLoading = true;
    toggleSpinner();

    const requestData = new URLSearchParams({
      action: "ct_core_js_update_currency_values",
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

      isLoading = false;
      toggleSpinner();

      return result.success;
    } catch (err) {
      console.error("Error fetch request:", err);
      throw err;
    }
  }

  btn.addEventListener("click", handleBtn);
};

export default () => {
  const block = document.querySelector("#currencyWidgetUpdate");
  if (block) widgetUpdate(block);
};
