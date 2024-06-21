import $ from "cash-dom";
import hash from "object-hash";
import "simplebar";

interface TOCOptions {
  selector: string;
  levels?: string[];
}

export const useToc = (options: TOCOptions): boolean => {
  const { selector, levels = ["h1", "h2", "h3"] } = options;
  // 计算顶部偏移并滚动到该位置
  const navHeight = $("nav.sticky").height() as number;
  const container = $(selector);
  if (container.length === 0) return false;
  // 文章区域的宽度，用于定位
  const template = `<aside class="flex max-h-96">
    <div data-simplebar class="flex-grow py-2 pr-4 relative">
      <ul></ul>
    </div>
  </aside>
  `;
  const aside = $(template);
  const ul = aside.find("ul");
  const headingsOffsetTop = [] as number[];
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
      h2: "pl-8",
      h3: "pl-8",
    };
    const li = $(
      `<li class="truncate text-zinc-600 hover:text-zinc-900 dark:text-zinc-500 dark:hover:text-zinc-300 toc-${tagName}"></li>`
    );
    const a = $(
      `<a class="border-l-2 text-sm border-transparent font-base leading-7 ${itemIndentMap[tagName]} " href="#${hashId}" >${text}</a>`
    );
    // 滚动修正
    a.on("click", function (event: Event) {
      event.preventDefault();
      const anchor = event.currentTarget as HTMLAnchorElement | null;
      if (!anchor) return;
      const targetId = anchor.getAttribute("href");
      if (!targetId) return;
      const targetElement = $(targetId).get(0) as HTMLElement | undefined;
      if (!targetElement) return;
      const topOffset =
        window.scrollY + targetElement.getBoundingClientRect().top - navHeight;
      window.scrollTo({ top: topOffset, behavior: "smooth" });
      // 更新样式逻辑
      $("li a", ul).removeClass("text-blue-500");
      $(anchor).addClass("text-blue-500");
    });
    li.append(a);
    ul.append(li);
  });
  if (ul.children("li").length === 0) return false;
  $("#toc-dropdown").append(aside[0]);
  return true;
};
