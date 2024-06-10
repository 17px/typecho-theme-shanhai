import { onMounted } from "@shanhai/util";
import $ from 'cash-dom';
import "./index.less";

onMounted(() => {

  $(window).on('mousemove', (e: MouseEvent) => {
    $('.eye').each((_, eye) => {
      const $eye = $(eye);
      const rect = eye.getBoundingClientRect();
      const x = rect.left + eye.clientWidth / 2;
      const y = rect.top + eye.clientHeight / 2;
      const rad = Math.atan2(e.pageY - y, e.pageX - x);
      const rot = (rad * (180 / Math.PI) * 1) + 270;
      $eye.css('transform', `rotate(${rot}deg)`);
    });
  });

});
