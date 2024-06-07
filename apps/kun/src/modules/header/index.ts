import { onMounted } from "@shanhai/util";
import $ from "cash-dom";
import 'flowbite';

import "./index.less";
import {
  LSP_THEME,
  MEDIA_THEME_DARK,
  DEFAULT_THEME,
  THEME_ICONS,
} from "@/constant";

onMounted(() => {
  /**
   * 切换主题色
   */
  $("#darkModeToggle").on("click", () => {
    $("html").toggleClass("dark");
    const theme = $("html").hasClass("dark") ? "dark" : "light";
    $("#darkModeToggle").html(THEME_ICONS[theme]);
    localStorage.setItem(LSP_THEME, theme);
  });

  /**
   * 初始化: 用户主题
   */
  const userTheme = localStorage.getItem(LSP_THEME) ?? DEFAULT_THEME;
  const systemThemeDark = window.matchMedia(MEDIA_THEME_DARK).matches;
  const isDark = userTheme === "dark" || systemThemeDark;
  $("#darkModeToggle").html(THEME_ICONS[isDark ? "dark" : "light"]);
  isDark ? $("html").addClass("dark") : $("html").removeClass("dark");
});
