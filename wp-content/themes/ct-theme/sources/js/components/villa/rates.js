import Accordion from "accordion-js";

const table = (block) => {
  const select = block.querySelector(".villa-rates__select-options");
  const tables = block.querySelectorAll(".villa-rates__table");

  function switchTable() {
    const value = select.value;
    const visible = block.querySelector(".villa-rates__table.visible");
    visible.classList.remove("visible");
    tables[value].classList.add("visible");
  }

  select?.addEventListener("change", switchTable);
};

const conditions = (block) => {
  const container = block.querySelector(".villa-rates__conditions");
  if (!container) return;

  new Accordion(container, {
    elementClass: "villa-rates__conditions-accordion",
    triggerClass: "villa-rates__conditions-header",
    panelClass: "villa-rates__conditions-content",
    activeClass: "active",
  });
};

export default () => {
  const block = document.querySelector(".villa-rates");
  if (!block) return;

  table(block);
  conditions(block);
};
