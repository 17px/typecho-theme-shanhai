import { onMounted } from "@shanhai/util";
import "./index.less";

onMounted(() => {
  const toggleButton = document.getElementById("darkModeToggle");
  toggleButton?.addEventListener("click", () => {
    document.documentElement.classList.toggle("dark");
    // 保存用户偏好到 localStorage
    if (document.documentElement.classList.contains("dark")) {
      localStorage.setItem("theme", "dark");
    } else {
      localStorage.setItem("theme", "light");
    }
  });

  // 检查用户偏好
  if (
    localStorage.getItem("theme") === "dark" ||
    (!("theme" in localStorage) &&
      window.matchMedia("(prefers-color-scheme: dark)").matches)
  ) {
    document.documentElement.classList.add("dark");
  } else {
    document.documentElement.classList.remove("dark");
  }
});
