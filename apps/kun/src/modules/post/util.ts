import { POST_MEMORY_KEY } from "@/constant";

type CDNResource = {
  type: "css" | "js";
  url: string;
  id?: string;
};

/**
 * use js load remote resource
 */
export const loadFromCDN = (resources: CDNResource[]): Promise<void[]> => {
  return Promise.all(
    resources.map((resource) => {
      return new Promise<void>((resolve, reject) => {
        if (resource.type === "css") {
          const link = document.createElement("link");
          link.href = resource.url;
          link.rel = "stylesheet";
          link.onload = () => resolve();
          link.onerror = () =>
            reject(new Error(`Failed to load CSS from ${resource.url}`));
          document.head.appendChild(link);
        } else if (resource.type === "js") {
          const script = document.createElement("script");
          script.src = resource.url;
          if (resource.id) script.id = resource.id;
          script.onload = () => resolve();
          script.onerror = () =>
            reject(new Error(`Failed to load JS from ${resource.url}`));
          document.body.appendChild(script);
        } else {
          reject(new Error("Invalid resource type specified."));
        }
      });
    })
  );
};

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
