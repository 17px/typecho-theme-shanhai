const copyIconSVG =
  '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"></path><rect x="9" y="3" width="6" height="4" rx="2"></rect></g></svg>';
const copySuccessIconSVG =
  '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"></path><rect x="9" y="3" width="6" height="4" rx="2"></rect><path d="M9 14l2 2l4-4"></path></g></svg>';

export const useCodeHelper = () => {
  const pres = document.querySelectorAll("#markdown-content pre > code");
  pres.forEach((codeElement) => {
    const preElement = codeElement.parentNode as HTMLPreElement;
    if (!preElement) return;
    const wrapper = document.createElement("div");
    wrapper.classList.add("mb-3");
    // 将 pre 标签的父节点设置为这个新的 div
    preElement.parentNode!.insertBefore(wrapper, preElement);
    // 移动 pre 标签到新的 div 中
    wrapper.appendChild(preElement);

    // 复制按钮
    const btn = document.createElement("span");
    btn.className =
      "w-[18px] h-[18px] inline-block cursor-pointer hover:color:blue";
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

    wrapper.appendChild(btn);
  });
};
