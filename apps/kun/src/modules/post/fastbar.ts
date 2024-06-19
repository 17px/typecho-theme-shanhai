import Draggabilly from "draggabilly";
import $ from "cash-dom";

export const fastbar_pos = "fast_bar_pos";
export const toc_visible = "toc_visible";

export interface FastBarPos {
  left: number;
  top: number;
}

export interface FastBarProps {
  /**
   * 页面上快捷导航的dom
   */
  selector?: string;
}

/**
 * 快捷操作条
 */
export const useFastBar = (props: FastBarProps): any => {
  const { selector = "#fast-bar" } = props;
  if ($(selector).length !== 1) return;

  // 预设位置为顶部导航高度 + 10，水平居中
  const unset = { top: $("nav.sticky").height() + 10, left: "50%" };
  const cache = localStorage.getItem(fastbar_pos);
  const pos = JSON.parse(cache ?? JSON.stringify(unset)) as FastBarPos;

  $(selector)
    .css({
      position: "fixed",
      zIndex: 1994,
      top: pos.top,
      left: pos.left,
      transform: pos ? "auto" : "translateX(-50%)",
    })
    .removeClass("hidden")
    .addClass("flex")
    .appendTo($("body"));

  /**
   * 拖拽
   */
  new Draggabilly(selector).on("dragEnd", () => {
    const element = document.querySelector(selector) as HTMLElement;
    const { left, top } = element.getBoundingClientRect();
    const dragEndPos = JSON.stringify({ left, top });
    localStorage.setItem(fastbar_pos, dragEndPos);
  });

  /**
   * 初始化目录显示状态
   */
  const syncTocStatus = () => {
    const tocVisible = localStorage.getItem(toc_visible) ?? "visible";
    tocVisible === "visible"
      ? $("#toggle-toc")
          .addClass("text-blue-500")
          .removeClass("dark:text-zinc-400 text-zinc-500")
      : $("#toggle-toc")
          .addClass("dark:text-zinc-400 text-zinc-500")
          .removeClass("text-blue-500");
  };

  // 初始化执行以下同步
  syncTocStatus();

  return { syncTocStatus };
};
