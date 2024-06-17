import { addKeyPress, addListener, onMounted } from "@shanhai/util";
import $ from "cash-dom";
import "./index.less";
import "flowbite";

onMounted(() => {
  /**
   * 自动主题判断
   */
  const themeAutoChange = () => {
    if ($("html").hasClass("auto")) {
      const hour = new Date().getHours();
      const mode = hour >= 6 && hour < 18 ? "light" : "dark";
      $("html").removeClass("auto").addClass(mode);
    }
  };

  themeAutoChange();

  const displaySearchDialog = () => {
    $('[data-modal-target="search-modal"]').trigger("click");
    setTimeout(() => {
      const input = $("#search-modal input")[0];
      if (input) input.focus();
    }, 0);
  };

  addListener({
    selector: "#tooltip-search-btn",
    eventType: "click",
    handler: displaySearchDialog,
  });

  addKeyPress({
    key: "control+k",
    preventDefault: true,
    handler: displaySearchDialog,
  });

  addKeyPress({
    key: "control+/",
    preventDefault: true,
    handler: () => $('[data-tooltip-target="tooltip-index"]').trigger("click"),
  });

  addKeyPress({
    key: "[",
    preventDefault: true,
    handler: () =>
      $('[data-tooltip-target="tooltip-category"]').trigger("click"),
  });
});
