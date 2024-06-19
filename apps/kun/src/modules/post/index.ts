import { addKeyPress, addListener, onMounted } from "@shanhai/util";
import "./index.less";
import $ from "cash-dom";
import Prism from "prismjs";
import { useCodeHelper } from "./code.helper";
import "prismjs/components/prism-less";
import "prismjs/components/prism-typescript";
import "prismjs/components/prism-java";
import "prismjs/components/prism-rust";
import "prismjs/components/prism-go";
import "prismjs/components/prism-bash";
import { useAnchorLocate, useToc } from "./util";
import mediumZoom from "medium-zoom";
import { useFastBar } from "./fastbar";

onMounted(async () => {
  const md = document.querySelector("#markdown-content");
  if (md) {
    Prism.highlightAll();
    useCodeHelper();
    mediumZoom(".markdown-body img", { margin: $("nav.sticky").height() });
  }

  const { syncTocStatus } = useFastBar({ selector: "#fast-bar" });

  /**
   * 评论区
   */
  addKeyPress({
    key: "control+p",
    handler: () => $('a[href="#comments-hr"]').trigger("click"),
    preventDefault: true,
  });

  const toggleToc = () => {
    if ($(".toc").hasClass("invisible")) {
      localStorage.setItem("toc_visible", "visible");
      $(".toc").removeClass("invisible").addClass("show-toc");
    } else {
      localStorage.setItem("toc_visible", "invisible");
      $(".toc")
        .addClass("invisible")
        .removeClass("show-toc")
        .removeClass("hide-toc");
    }
    syncTocStatus();
  };

  addListener({
    selector: "#toggle-toc",
    eventType: "click",
    handler: toggleToc,
  });

  addKeyPress({
    key: "control+j",
    handler: () => $('[data-tooltip-target="next-post"]').trigger("click"),
    preventDefault: true,
  });

  addKeyPress({
    key: "control+l",
    handler: () => $('[data-tooltip-target="prev-post"]').trigger("click"),
    preventDefault: true,
  });

  addKeyPress({
    key: "]",
    handler: toggleToc,
    preventDefault: true,
  });

  const postWithToc = useToc({
    selector: ".markdown-body",
    levels: ["h1", "h2", "h3"],
    syncContent: true,
  });
  if (postWithToc) useAnchorLocate();
});
