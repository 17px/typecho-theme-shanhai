import "./index.less";
import $ from 'cash-dom'
import Prism from "prismjs";
import mediumZoom from "medium-zoom";
import { onMounted } from "@shanhai/util";

onMounted(() => {
  if ($("#markdown-content").length > 0) {
    Prism.highlightAll();
    mediumZoom(".markdown-body img", {
      margin: $("nav.sticky").height() * 1.5,
    });
    // iframe视频嵌入，调整宽度
    $('.markdown-body iframe').each(function () {
      const width = $('.markdown-body').width();
      if (width) {
        const height = width * 9 / 16;  // 计算高度为宽度的9/16
        $(this).css('height', `${height}px`).css('width', `100%`).addClass('my-2.5 py-2')
      }
    });
  }
})
