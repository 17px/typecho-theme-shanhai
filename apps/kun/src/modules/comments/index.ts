import { onMounted } from "@shanhai/util";
import "./index.less";
import $ from "cash-dom";
import Prism from "prismjs";
import mediumZoom from "medium-zoom";
import "prismjs/components/prism-less";
import "prismjs/components/prism-typescript";
import "prismjs/components/prism-java";
import "prismjs/components/prism-rust";
import "prismjs/components/prism-go";
import "prismjs/components/prism-bash";
import { createPicker } from "picmo";

const insertAtCursor = (textarea: HTMLTextAreaElement, text: string) => {
  const start = textarea.selectionStart;
  const end = textarea.selectionEnd;
  const textValue = textarea.value;
  textarea.value =
    textValue.substring(0, start) + text + textValue.substring(end);
  textarea.selectionStart = textarea.selectionEnd = start + text.length;
  textarea.focus();
};

const useEmoji = () => {
  const rootElement = document.querySelector("#emoji") as HTMLElement;
  if (rootElement) {
    const picker = createPicker({
      rootElement,
      locale: "zh",
      emojiSize: "1rem",
      className: "picmo rounded-lg flex-grow",
      categories: [
        "activities",
        "animals-nature",
        "custom",
        "flags",
        "food-drink",
        "people-body",
        "symbols",
      ],
    });
    picker.addEventListener("emoji:select", (event) => {
      const emoji = event.emoji;
      const textarea = document.querySelector(
        "#comment-textarea"
      ) as HTMLTextAreaElement;
      insertAtCursor(textarea, emoji);
    });
  }
};

onMounted(() => {
  const md = document.querySelector("#comment-content");
  if (md) {
    Prism.highlightAll();
    console.log("执行");
    mediumZoom(".markdown-body img", {
      margin: $("nav.sticky").height() as number,
    });
    useEmoji();
  }

  $("[data-reply-id]")
    .on("mouseenter", function () {
      //@ts-ignore
      $(`#${$(this).attr("data-reply-id")} article`).addClass(
        "rounded bg-zinc-100 dark:bg-zinc-800"
      );
    })
    .on("mouseleave", function () {
      //@ts-ignore
      $(`#${$(this).attr("data-reply-id")} article`).removeClass(
        "rounded bg-zinc-100 dark:bg-zinc-800"
      );
    });
});
