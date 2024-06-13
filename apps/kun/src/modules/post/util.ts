import { POST_MEMORY_KEY } from "@/constant";
import $ from "cash-dom";
import hash from 'object-hash'
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

export const useToc = (options: TOCOptions): boolean => {
  const { selector, levels } = options;
  const container = $(selector);
  if (container.length === 0) return false
  // 导航高度，用于定位
  const navHeight = $("nav.sticky").height() as number;
  // 文章区域的宽度，用于定位
  const postWidth = $("#post-container").width() as number;

  const cardClass = `max-w-sm bg-white border-gray-200 bl-1 br-1 dark:bg-gray-800 dark:border-gray-700`;
  const template = `<aside class="toc py-20 pl-4 flex">
    <div data-simplebar class="flex-grow relative ${cardClass}">
      <div class="sticky w-full" style="top:0;background-image:linear-gradient(#ffffff, transparent 70%);height:32px"></div>
      <ul></ul>
      <div class="sticky w-full" style="bottom:0;background-image:linear-gradient(transparent, #ffffff 70%);height:32px"></div>
    </div>
  </aside>`
  const toc = $(template);
  toc.css({
    position: "fixed",
    top: navHeight,
    bottom: 0,
    left: `calc(50% + ${postWidth / 2}px  + 5rem)`,
    width: 260,
  });

  const ul = toc.find("ul");

  container.find(levels.join(",")).each((index, element) => {
    const $element = $(element);
    const tagName = $element.prop("tagName").toLowerCase() as 'h1' | 'h2' | 'h3'
    const text = $element.text();
    const id = $element.attr("id") || text.toLowerCase().replace(/\s+/g, "-");
    const hashId = hash(index + id).substring(0, 8); // 防止特殊字符的bug、标题崇明
    $element.attr("id", hashId);

    const itemText = tagName !== 'h1' ? text : `${index + 1}. ${text}`
    const itemIndentMap = {
      'h1': 'pl-5',
      'h2': 'pl-10 text-gray-500',
      'h3': 'pl-16'
    }
    const li = $(
      `<li class="truncate toc-${tagName} border-l-2 border-gray-200"><a class="font-base leading-8 ${itemIndentMap[tagName]} " href="#${hashId}" >${itemText}</a></li>`
    );
    ul.append(li);
  });
  if (ul.children("li").length === 0) return false
  // 显示目录图标
  $("#toggle-toc").removeClass("invisible")
  $("body").append(toc[0] as HTMLDivElement);
  return true
};

/**
 * 文档目录平滑定位
 */
export const useSmoothAnchor = () => {
  $('.toc a[href^="#"]').on('click', (event: Event) => {
    event.preventDefault();

    const anchor = event.currentTarget as HTMLAnchorElement | null;

    if (!anchor) return;

    const targetId = anchor.getAttribute('href');
    if (!targetId) return;

    const targetElement = $(targetId).get(0) as HTMLElement | undefined;
    if (!targetElement) return;

    // 计算顶部偏移并滚动到该位置
    const navHeight = $("nav.sticky").height() as number;
    const topOffset = window.scrollY + targetElement.getBoundingClientRect().top - navHeight;
    window.scrollTo({ top: topOffset, behavior: 'smooth' });

    // 更新样式逻辑
    $('.toc li').removeClass('border-blue-500'); // 移除所有li的蓝色边框
    $('.toc a').removeClass('text-blue-500'); // 移除所有a标签的蓝色字体

    // 为当前点击的a标签的最近的祖先li节点添加蓝色边框
    $(anchor).closest('li').removeClass('border-gray-200').addClass('border-blue-500');
    $(anchor).addClass('text-blue-500');


    // window.history.pushState({}, '', targetId);

  });
}