<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<?php function threadedComments($comments, $options)
{
  $commentClass = '';
  if ($comments->authorId) {
    if ($comments->authorId == $comments->ownerId) {
      $commentClass .= ' comment-by-author';
    } else {
      $commentClass .= ' comment-by-user';
    }
  }

  $commentLevelClass = $comments->levels > 0 ? ' comment-child' : ' comment-parent';
?>

  <li id="li-<?php $comments->theId(); ?>" class="pb-1 <?php
                                                        if ($comments->levels > 0) {
                                                          echo ' comment-child';
                                                          $comments->levelsAlt(' comment-level-odd', ' comment-level-even');
                                                        } else {
                                                          echo ' comment-parent';
                                                        }
                                                        $comments->alt(' comment-odd', ' comment-even');
                                                        echo $commentClass;
                                                        ?>">
    <div class="pb-2" id="<?php $comments->theId(); ?>">
      <div class="comment-author flex items-center">
        <img class="w-[32px] h-[32px] rounded-lg flex-shrink-0" src="<?php echo getGravatar($comments->mail) ?>" />
        <div class="pl-3 flex-grow">
          <span class="text-sm"><?php $comments->author(); ?> · <em class="text-xs"><?php $comments->mail() ?></em></span>
          <p class="text-xs text-gray-400 flex">
            <a href="<?php $comments->permalink(); ?>"><?php $comments->date('F j, Y H:i'); ?></a>
            <span class="pl-2"><?php $comments->reply(); ?></span>
          </p>
        </div>
      </div>
      <div class="py-2">
        <?php
        $parentAuthor = getParentCommentAuthor($comments->parent);
        if (!empty($parentAuthor)) : ?>
          <span class="mb-1 text-gray-400 text-sm">@<?php echo htmlspecialchars($parentAuthor); ?></span>
        <?php endif; ?>
        <?php $comments->content(); ?>
      </div>
    </div>
    <?php if ($comments->children) { ?>
      <div class="comment-children">
        <?php $comments->threadedComments($options); ?>
      </div>
    <?php } ?>
  </li>
<?php } ?>


<!-- inject:css -->
<div id="comments">
  <?php $this->comments()->to($comments); ?>
  <?php if ($comments->have()) : ?>
    <h3 class="text-center mb-4"><?php $this->commentsNum(_t('暂无评论'), _t('仅有一条评论'), _t('已有 %d 条评论')); ?></h3>

    <?php $comments->listComments(); ?>

    <?php $comments->pageNav('&laquo; 前一页', '后一页 &raquo;'); ?>

  <?php endif; ?>

  <?php if ($this->allow('comment')) : ?>
    <div id="<?php $this->respondId(); ?>" class="pt-8">
      <div class="cancel-comment-reply">
        <?php $comments->cancelReply('<button type="button" class="py-1.5 px-3 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">取消回复</button>'); ?>
      </div>
      <form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" role="form">
        <?php if ($this->user->hasLogin()) : ?>
          <p>
            <?php _e('登录身份: '); ?><a href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>
            <a class="inline-block px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?></a>
          </p>
        <?php else : ?>
          <div class="flex align-center gap-3 pb-3">
            <div class="flex-1">
              <label for="author" class="block text-sm font-medium text-gray-900 dark:text-white"><?php _e('称呼'); ?></label>
              <input for="author" type="text" name="author" value="<?php $this->remember('author'); ?>" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            </div>
            <div class="flex-1">
              <label for="mail" <?php if ($this->options->commentsRequireMail) : ?> class="block text-sm font-medium text-gray-900 dark:text-white" <?php endif; ?>><?php _e('Email'); ?></label>
              <input id="mail" value="<?php $this->remember('mail'); ?>" <?php if ($this->options->commentsRequireMail) : ?> required<?php endif; ?> type="email" name="mail" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            </div>
            <div class="flex-1">
              <label for="url" class="block text-sm font-medium text-gray-900 dark:text-white <?php if ($this->options->commentsRequireURL) : ?> required <?php endif; ?>"><?php _e('网站'); ?></label>
              <input type="url" id="url" name="url" placeholder="<?php _e('http://'); ?>" value="<?php $this->remember('url'); ?>" <?php if ($this->options->commentsRequireURL) : ?> required<?php endif; ?> class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            </div>
          </div>
        <?php endif; ?>

        <div class="w-full mb-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
          <div class="px-4 py-2 bg-white rounded-t-lg dark:bg-gray-800">
            <label for="textarea" class="sr-only">Your comment</label>
            <textarea placeholder="发表你的观点..." rows="8" cols="50" name="text" id="textarea" class="w-full px-0 text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400" required><?php $this->remember('text'); ?></textarea>
          </div>
          <div class="flex items-center justify-between px-3 py-2 border-t dark:border-gray-600">
            <button type="submit" class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">
              <?php _e('提交评论'); ?>
            </button>
            <div class="flex ps-0 space-x-1 rtl:space-x-reverse sm:ps-2">
              <button type="button" class="inline-flex justify-center items-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 20">
                  <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M1 6v8a5 5 0 1 0 10 0V4.5a3.5 3.5 0 1 0-7 0V13a2 2 0 0 0 4 0V6" />
                </svg>
                <span class="sr-only">Attach file</span>
              </button>
              <button type="button" class="inline-flex justify-center items-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
                  <path d="M8 0a7.992 7.992 0 0 0-6.583 12.535 1 1 0 0 0 .12.183l.12.146c.112.145.227.285.326.4l5.245 6.374a1 1 0 0 0 1.545-.003l5.092-6.205c.206-.222.4-.455.578-.7l.127-.155a.934.934 0 0 0 .122-.192A8.001 8.001 0 0 0 8 0Zm0 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z" />
                </svg>
                <span class="sr-only">Set location</span>
              </button>
              <button type="button" class="inline-flex justify-center items-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                  <path d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z" />
                </svg>
                <span class="sr-only">Upload image</span>
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
  <?php else : ?>
    <h3><?php _e('评论已关闭'); ?></h3>
  <?php endif; ?>
</div>

<!-- inject:js -->