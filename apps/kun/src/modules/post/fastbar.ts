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
  /**
   * 显示目录按钮，有些文章不存在toc
   */
  toc?: boolean;
}

/**
 * 快捷操作条
 */
export const useFastBar = (props: FastBarProps): any => {
  const { selector = "#fast-bar", toc = true } = props;
  if ($(selector).length !== 1) return;

  if (!toc) $('[data-dropdown-toggle="toc-dropdown"]').parent("li").remove();
  $(selector).removeClass("hidden").addClass("flex").appendTo($("body"));
};
