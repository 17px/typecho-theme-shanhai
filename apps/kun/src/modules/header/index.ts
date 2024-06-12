import { addKeyPress, onMounted } from "@shanhai/util";
import "./index.less";
import $ from "cash-dom";
import "flowbite";

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

  /**
   * 坤
   */
  $(window).on("mousemove", (e: MouseEvent) => {
    $(".eye").each((_, eye) => {
      const $eye = $(eye);
      const rect = eye.getBoundingClientRect();
      const x = rect.left + eye.clientWidth / 2;
      const y = rect.top + eye.clientHeight / 2;
      const rad = Math.atan2(e.pageY - y, e.pageX - x);
      const rot = rad * (180 / Math.PI) * 1 + 270;
      $eye.css("transform", `rotate(${rot}deg)`);
    });
  });

  addKeyPress({
    key: 'control+h',
    handler: () => location.href = '/',
    preventDefault: true
  })

  addKeyPress({
    key: 'control+j',
    handler: () => $("#mega-menu-full-dropdown-button").trigger('click'),
    preventDefault: true
  })
});
