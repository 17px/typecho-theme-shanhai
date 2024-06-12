import { onMounted, str2Base64Image } from "@shanhai/util";
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

onMounted(async () => {
  const md = document.querySelector("#markdown-content");
  if (md) {
    Prism.highlightAll();
    useCodeHelper();
  }

  $(`.posts-recommend img[data-title]`).each((index, element) => {
    const img = element as HTMLImageElement;
    const title = $(img).data("title");
    if (title) $(img).attr("src", str2Base64Image(title));
  });
});
