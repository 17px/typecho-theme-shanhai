import "simplebar";

const copyIconSVG =
  '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"></path><rect x="9" y="3" width="6" height="4" rx="2"></rect></g></svg>';
const copySuccessIconSVG = `<svg class="w-3.5 h-3.5 text-blue-700 dark:text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
</svg>`;

export const useCodeHelper = () => {
  const pres = document.querySelectorAll("#markdown-content pre > code");
  pres.forEach((codeElement, index) => {
    const preElement = codeElement.parentNode as HTMLPreElement;
    if (!preElement) return;
    const wrapper = document.createElement("div");
    wrapper.classList.add("mb-3", "relative");
    // 将 pre 标签的父节点设置为这个新的 div
    preElement.parentNode!.insertBefore(wrapper, preElement);
    // 移动 pre 标签到新的 div 中
    wrapper.appendChild(preElement);

    // 代码按钮组
    const btnsWrapper = document.createElement("section");
    btnsWrapper.classList.add("inline-flex","whitespace-nowrap", "justify-center", "items-center", "absolute", "right-0", "top-0");

    // 复制按钮
    const item = document.createElement("div");
    const btn = document.createElement("button");
    btn.setAttribute("data-tooltip-target", `tooltip-copy-code-${index}`);
    btn.setAttribute("data-tooltip-placement", "bottom");
    btn.className =
      "inline-flex items-center justify-center hover:text-blue-500 text-zinc-500 w-10 h-10 dark:text-zinc-400 rounded-lg text-sm p-2.5";
    btn.innerHTML = copyIconSVG;

    btn.addEventListener("click", function () {
      const code = codeElement.textContent as string;
      navigator.clipboard.writeText(code).then(() => {
        btn.innerHTML = copySuccessIconSVG;
        setTimeout(() => {
          btn.innerHTML = copyIconSVG;
        }, 2000);
      });
    });

    const tooltip = document.createElement("div");
    tooltip.innerHTML = "<span>复制</span>";
    tooltip.className =
      "absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-zinc-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-zinc-700";
    tooltip.setAttribute("id", `tooltip-copy-code-${index}`);
    tooltip.setAttribute("role", "tooltip");

    item.appendChild(tooltip);
    item.appendChild(btn);
    btnsWrapper.appendChild(item);
    wrapper.appendChild(btnsWrapper);
  });
};
