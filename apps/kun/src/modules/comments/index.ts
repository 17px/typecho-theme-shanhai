import { onMounted } from "@shanhai/util";
import "./index.less";
import $ from "cash-dom";
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
  useEmoji();
});
