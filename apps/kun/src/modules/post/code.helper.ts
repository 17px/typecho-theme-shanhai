import "simplebar";

const copyIconSVG = `<svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path></svg>`;
const copySuccessIconSVG = `<svg class="text-blue-700 dark:text-blue-500" stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="m12 15 2 2 4-4"></path><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path></svg>`;

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
    btnsWrapper.classList.add(
      "inline-flex",
      "whitespace-nowrap",
      "justify-center",
      "items-center",
      "absolute",
      "right-1",
      "top-0"
    );

    // 复制按钮
    const item = document.createElement("div");
    const btn = document.createElement("button");
    btn.setAttribute("data-tooltip-target", `tooltip-copy-code-${index}`);
    btn.setAttribute("data-tooltip-placement", "bottom");
    btn.className =
      "inline-flex items-center justify-center hover:text-blue-500 text-zinc-500 w-4 h-4 dark:text-zinc-400 rounded-lg text-sm";
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
      "absolute z-10 inline-block px-2 text-sm font-medium text-zinc-900 bg-white border border-zinc-200 rounded-lg tooltip opacity-0 invisible";
    tooltip.setAttribute("id", `tooltip-copy-code-${index}`);
    tooltip.setAttribute("role", "tooltip");

    item.appendChild(tooltip);
    item.appendChild(btn);
    btnsWrapper.appendChild(item);
    wrapper.appendChild(btnsWrapper);
  });
};
