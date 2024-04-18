// Dashboard
import currencyWidgetUpdate from "./currency/widget-update.js";

// Promotion
import promotionAcfFields from "./promotion/acf-fields.js";

// Owner
import ownerMetaboxConditions from "./owner/metabox-conditions.js";

// Villa
import villaPageRating from "./villa/page-rating.js";
import villaMetaboxPrice from "./villa/metabox-price.js";
import villaMetaboxConditions from "./villa/metabox-conditions.js";
import villaMetaboxPromotions from "./villa/metabox-promotions.js";

// Import
import importPage from "./import/page.js";

// Bootstrap
import * as Bootstrap from "bootstrap";

document.addEventListener("DOMContentLoaded", () => {
  // Bootstrap
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
  const tooltipList = [...tooltipTriggerList].map((tooltipTriggerEl) => new Bootstrap.Tooltip(tooltipTriggerEl));

  // Dashboard
  currencyWidgetUpdate();

  // Promotion
  promotionAcfFields();

  // Owner
  ownerMetaboxConditions();

  // Villa
  villaPageRating();
  villaMetaboxPrice();
  villaMetaboxConditions();
  villaMetaboxPromotions();

  // Import
  importPage();
});
