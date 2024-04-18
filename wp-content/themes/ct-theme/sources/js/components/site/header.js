import { CookieUtill } from "./../../_classes.js";
const search = () => {
  const block = document.querySelector(".site-header");
  if (!block) return;

  const Elements = {
    btn: block.querySelector(".site-header__controls-search"),
    search: block.querySelector(".site-header__search"),
    input: block.querySelector(".site-header__search-input"),
    results: block.querySelector(".site-header__search-results"),
  };

  const State = {
    timeout: null,
    isOpenSearch: false,
    isOpenResults: false,
    value: Elements.input.value,
    response: [],
  };

  function handleTrigger(e) {
    const target = e.target;

    if (target.closest(".site-header__controls-search") && !State.isOpenSearch) {
      State.isOpenSearch = true;
      Elements.search.classList.add("active");
      Elements.btn.classList.add("active");
    } else if (!target.closest(".site-header__search") && State.isOpenSearch) {
      State.isOpenSearch = false;
      Elements.search.classList.remove("active");
      Elements.btn.classList.remove("active");
    }
  }
  function handleInput(e) {
    clearTimeout(State.timeout);
    if (e.target.value.length < 3) return;

    State.value = e.target.value;

    State.timeout = setTimeout(() => {
      getResults().then(() => showResults());
    }, 500);
  }
  function showResults() {
    let html = "";

    State.response.forEach((item) => {
      let icon = "";

      switch (item.type) {
        case "location":
          icon = "map";
          break;
        case "villa":
          icon = "home";
          break;
        default:
          break;
      }

      html += `<li><i class="ct-icon ct-icon--fill-${icon}"></i><a href="${item.link}">${item.name}</a></li>`;
    });

    Elements.results.innerHTML = html;
    Elements.results.classList.add("active");
    State.isOpenResults = true;
  }
  async function getResults() {
    if (!State.value) return;

    const requestData = new URLSearchParams({
      action: "ct_theme_js_search_header",
      value: State.value,
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

      State.response = result.data;

      return result.success;
    } catch (error) {
      console.error("Error fetch request:", error);
      throw error;
    }
  }

  document.addEventListener("click", handleTrigger);
  Elements.input.addEventListener("input", handleInput);
};
const wishlist = () => {
  function addVilla(id) {
    const data = CookieUtill.get("villasia_wishlist") || "[]";
    const parse = JSON.parse(data);

    if (!parse.includes(id)) {
      parse.push(id);
      CookieUtill.set("villasia_wishlist", JSON.stringify(parse));
    }

    return;
  }
  function removeVilla(id) {
    const data = CookieUtill.get("villasia_wishlist") || "[]";
    const parse = JSON.parse(data);

    const indexToRemove = parse.indexOf(id);

    if (indexToRemove !== -1) {
      parse.splice(indexToRemove, 1);
      CookieUtill.set("villasia_wishlist", JSON.stringify(parse));
    }

    return;
  }
  function getData(el) {
    const id = el.getAttribute("data-villa-id");
    const inWishlist = el.getAttribute("data-in-wishlist");

    if (+inWishlist) {
      el.setAttribute("data-in-wishlist", 0);
      removeVilla(id);
    } else {
      el.setAttribute("data-in-wishlist", 1);
      addVilla(id);
    }
  }
  function handleBtn(e) {
    const target = e.target;

    if (target.closest(".card-villa__footer-bottom__fav")) {
      getData(target.closest(".card-villa"));
    }

    if (target.closest(".villa-overview__fav")) {
      getData(target.closest(".page-villa"));
    }
  }

  document.addEventListener("click", handleBtn);
};
const currency = () => {
  const block = document.querySelector(".site-header__controls-currency");
  if (!block) return;

  function handleCurrency(e) {
    const target = e.target;

    if (target.closest("li")) {
      const id = target.closest("li").getAttribute("data-id");
      CookieUtill.set("villasia_currency", id);
      location.reload();
    }
  }

  block.addEventListener("click", handleCurrency);
};

export default () => {
  search();
  wishlist();
  currency();
};
