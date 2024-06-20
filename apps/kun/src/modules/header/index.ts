import { addKeyPress, addListener, onMounted } from "@shanhai/util";
import $ from "cash-dom";
import "./index.less";
import "flowbite";

onMounted(() => {
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
