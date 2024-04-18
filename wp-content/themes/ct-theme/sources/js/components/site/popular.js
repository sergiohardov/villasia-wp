import { DraggableScroll } from "../../_classes.js";

export default () => {
  const container = document.querySelector(".site-popular");
  if (!container) return;
  
  const nav = container.querySelector(".ct-tabs__nav");

  new DraggableScroll(nav);
};
