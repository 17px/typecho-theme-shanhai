import {
  addKeyPress,
  addListener,
  onMounted,
  str2Base64Image,
} from "@shanhai/util";
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

onMounted(async () => {
  const md = document.querySelector("#markdown-content");
  if (md) {
    Prism.highlightAll();
    useCodeHelper();
    mediumZoom(".markdown-body img", {
      margin: $("nav.sticky").height() as number,
    });
  }

  $(`.posts-recommend img[data-title]`).each((index, element) => {
    const img = element as HTMLImageElement;
    const title = $(img).data("title");
    if (title) $(img).attr("src", str2Base64Image(title));
  });

  addKeyPress({
    key: "control+k",
    handler: () => $('a[href="#comments-hr"]').trigger("click"),
    preventDefault: true,
  });

  const toggleToc = () => {
    $(".toc").hasClass("invisible")
      ? $(".toc").removeClass("invisible").addClass("show-toc")
      : $(".toc")
          .addClass("invisible")
          .removeClass("show-toc")
          .removeClass("hide-toc");
  };

  addListener({
    selector: "#toggle-toc",
    eventType: "click",
    handler: toggleToc,
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
