import Identicon from "identicon.js";
import hash from "object-hash";

/**
 * 根据随机字符串、数字生成图片
 * @param { string | number} source
 */
export const str2Base64Image = (source: string | number): string => {
  const salt = "1804a4d788307255db316b70";
  const hashString = hash(encodeURI(String(source)) + salt);
  const identicon = new Identicon(hashString, {
    format: "svg",
    size: 64,
    background: [255, 255, 255, 0],
  });
  return `data:image/svg+xml;base64,${identicon.toString()}`;
};
