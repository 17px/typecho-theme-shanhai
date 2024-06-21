import Identicon from "identicon.js";
import hash from "object-hash";
import { createIcon } from '@download/blockies';

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

export const blockies = (source: string | number) => {
  const icon = createIcon({ // All options are optional
    seed: source, // seed used to generate icon data, default: random
    color: 'random', // to manually specify the icon color, default: random
    bgcolor: 'transparent', // choose a different background color, default: white
    size: 20, // width/height of the icon in blocks, default: 10
    scale: 3 // width/height of each block in pixels, default: 5
  });
  return icon.toDataURL("image/png")
}