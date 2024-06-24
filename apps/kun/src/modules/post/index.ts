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
import mediumZoom from "medium-zoom";
import { useFastBar } from "./fastbar";
import { useToc } from "./toc";
import { useAttachHelper } from "./attach.helper";

onMounted(async () => {
  if ($('#markdown-content').length > 0) {
    Prism.highlightAll();
    useCodeHelper();
    useAttachHelper();
    mediumZoom(".markdown-body img", { margin: $("nav.sticky").height() });
  }

  const hasToc = useToc({ selector: ".markdown-body" });
  useFastBar({ selector: "#fast-bar", toc: hasToc });

  /**
   * 评论区
   */
  addKeyPress({
    key: "control+p",
    handler: () => $('a[href="#comments-hr"]').trigger("click"),
    preventDefault: true,
  });

  addKeyPress({
    key: "control+ArrowRight",
    handler: () => $('[data-tooltip-target="next-post"]').trigger("click"),
    preventDefault: true,
  });

  addKeyPress({
    key: "control+ArrowLeft",
    handler: () => $('[data-tooltip-target="prev-post"]').trigger("click"),
    preventDefault: true,
  });

  addKeyPress({
    key: "]",
    handler: () => $('[data-dropdown-toggle="toc-dropdown"]').trigger("click"),
    preventDefault: true,
  });
});
