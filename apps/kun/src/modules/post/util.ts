import { POST_MEMORY_KEY } from "@/constant";
import $ from "cash-dom";
import hash from "object-hash";
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
  /**
   * 文章区域滚动和toc同步
   */
  syncContent: boolean;
}

export const useToc = (options: TOCOptions): boolean => {
  const { selector, levels, syncContent = false } = options;
  const container = $(selector);
  if (container.length === 0) return false;
  // 导航高度，用于定位
  const navHeight = $("nav.sticky").height() as number;
  // 文章区域的宽度，用于定位
  const postWidth = $("#post-container").width() as number;

  const cardClass = `max-w-sm bg-white border-gray-200 bl-1 br-1 dark:bg-gray-800 dark:border-gray-700`;
  const template = `<aside class="toc py-20 pl-4 flex">
    <div data-simplebar class="flex-grow relative ${cardClass}">
      <div class="sticky w-full" style="top:0;background-image:linear-gradient(#ffffff, transparent 70%);height:32px"></div>
      <ul class="border-l border-gray-200"></ul>
      <div class="sticky w-full" style="bottom:0;background-image:linear-gradient(transparent, #ffffff 70%);height:32px"></div>
    </div>
  </aside>`;
  const toc = $(template);
  toc.css({
    position: "fixed",
    top: navHeight,
    bottom: 0,
    left: `calc(50% + ${postWidth / 2}px  + 5rem)`,
    width: 260,
  });

  // heading标签距离顶部距离的高度数组，用于toc同步
  const headingsOffsetTop = [] as number[];
  const ul = toc.find("ul");

  container.find(levels.join(",")).each((index, element) => {
    const $element = $(element);
    headingsOffsetTop.push($element.offset()?.top ?? -1);
    const tagName = $element.prop("tagName").toLowerCase() as
      | "h1"
      | "h2"
      | "h3";
    const text = $element.text();
    const id = $element.attr("id") || text.toLowerCase().replace(/\s+/g, "-");
    const hashId = hash(index + id).substring(0, 8); // 防止特殊字符的bug、标题崇明
    $element.attr("id", hashId);

    const itemIndentMap = {
      h1: "pl-4",
      h2: "pl-8 text-gray-500",
      h3: "pl-8 text-gray-500",
    };
    const li = $(
      `<li class="truncate toc-${tagName}"><a class="border-l-2 text-sm border-transparent font-base leading-7 ${itemIndentMap[tagName]} " href="#${hashId}" >${text}</a></li>`
    );
    ul.append(li);
  });
  if (ul.children("li").length === 0) return false;
  // 显示目录图标
  $("#toggle-toc").removeClass("invisible");
  $("body").append(toc[0] as HTMLDivElement);
  // 如果开启了同步，处理同步的css效果
  if (syncContent) {
    $(window).on("scroll", () => {
      const currentIndex = headingsOffsetTop.findIndex(
        (i) => i >= window.scrollY + navHeight
      );
      ul.children("li")
        .children("a")
        .addClass("border-transparent")
        .removeClass("border-blue-500")
        .removeClass("text-blue-500");
      ul.children("li")
        .eq(currentIndex)
        .children("a")
        .addClass("border-blue-500")
        .removeClass("border-transparent")
        .addClass("text-blue-500");
    });
  }

  return true;
};

/**
 * 文档目录定位
 */
export const useAnchorLocate = () => {
  $('.toc a[href^="#"]').on("click", (event: Event) => {
    event.preventDefault();

    const anchor = event.currentTarget as HTMLAnchorElement | null;

    if (!anchor) return;

    const targetId = anchor.getAttribute("href");
    if (!targetId) return;

    const targetElement = $(targetId).get(0) as HTMLElement | undefined;
    if (!targetElement) return;

    // 计算顶部偏移并滚动到该位置
    const navHeight = $("nav.sticky").height() as number;
    const topOffset =
      window.scrollY + targetElement.getBoundingClientRect().top - navHeight;
    window.scrollTo({ top: topOffset });

    // 更新样式逻辑
    $(".toc li").removeClass("border-blue-500");
    $(".toc a").removeClass("text-blue-500");

    // 为当前点击的a标签的最近的祖先li节点添加蓝色边框
    $(anchor)
      .closest("li")
      .removeClass("border-gray-200")
      .addClass("border-blue-500");
    $(anchor).addClass("text-blue-500");
    // window.history.pushState({}, '', targetId);
  });
};
