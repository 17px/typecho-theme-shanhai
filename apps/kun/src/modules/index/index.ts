import { str2Base64Image, onMounted } from "@shanhai/util";
import $ from "cash-dom";
import "./index.less";

onMounted(() => {
  /**
   * 文章标题生成icon
   */
  $(`.posts-in-category img[data-title]`).each((index, element) => {
    const img = element as HTMLImageElement;
    const title = $(img).data("title");
    if (title) $(img).attr("src", str2Base64Image(title));
  });
});
