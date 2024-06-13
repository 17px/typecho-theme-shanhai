import { POST_MEMORY_KEY } from "@/constant";
import $ from "cash-dom";
import "simplebar";

export const saveScrollHeight = (selector: string) => {
  const element = document.querySelector<HTMLElement>(selector);
  if (element) {
    const scrolledHeight = element.scrollTop;
    localStorage.setItem(POST_MEMORY_KEY, String(scrolledHeight));
  } else {
    console.warn("Element not found for selector:", selector);
  }
};

export const restoreScrollHeight = (selector: string) => {
  const element = document.querySelector<HTMLElement>(selector);
  if (element) {
    const recordedHeight = localStorage.getItem(POST_MEMORY_KEY);
    if (recordedHeight) {
      element.scrollTop = Number(recordedHeight);
    }
  } else {
    console.warn("Element not found for selector:", selector);
  }
};
interface TOCOptions {
  selector: string;
  levels: string[];
}

export const useToc = (options: TOCOptions): void => {
  const { selector, levels } = options;
  const container = $(selector);
  if (container.length === 0) return
  // 文章区域的宽度，用于定位
  const postWidth = $("#post-container").width() as number;

  const cardClass = `max-w-sm p-6 bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700`;
  const toc = $(`<div data-simplebar class="toc invisible ${cardClass}"><ul></ul></div>`);
  toc.css({
    position: "fixed",
    top: "10%",
    left: `calc(50% + ${postWidth / 2}px  + 2rem)`,
    bottom: "10%",
    paddingLeft: 20,
    width: 220,
  });

  const ul = toc.find("ul");

  container.find(levels.join(",")).each((_, element) => {
    const $element = $(element);
    const tagName = $element.prop("tagName").toLowerCase();
    const text = $element.text();
    const id = $element.attr("id") || text.toLowerCase().replace(/\s+/g, "-");
    $element.attr("id", id);

    const li = $(
      `<li class="toc-${tagName}"><a href="#${id}">${text}</a></li>`
    );
    ul.append(li);
  });
  if (ul.children("li").length === 0) return;
  // 显示目录图标
  $("#toggle-toc").removeClass("invisible")
  $("body").append(toc[0] as HTMLDivElement);
};
