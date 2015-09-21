<?php $hash = md5(strtolower(trim($comment->author_email))); ?>
<div class="comment-author">
    <img src="//www.gravatar.com/avatar/<?php echo $hash; ?>?d=identicon&amp;s=40" class="gravatar">

    <div class="comment-author-name">
        <?php if (empty($comment->author_name)): ?>
            <?php echo __('Anonymous'); ?>
        <?php elseif (empty($comment->author_url)): ?>
            <?php echo html_escape($comment->author_name); ?>
        <?php else: ?>
            <a href="<?php echo html_escape($comment->author_url); ?>">
                <?php echo html_escape($comment->author_name); ?>
            </a>
        <?php endif; ?>
    </div>
</div>

<div class="comment-added">
    <?php echo date('F j, Y \a\t g:i A', strtotime($comment->added)); ?>
</div>

<div class="comment-body<?php if ($comment->flagged): ?> comment-flagged<?php endif; ?>">
    <?php echo $comment->body; ?>
</div>

<?php if (is_allowed('Commenting_Comment', 'unflag')): ?>
    <p class="comment-flag"<?php if ($comment->flagged): ?> style="display:none"<?php endif; ?>>
        <?php echo __('Flag inappropriate'); ?>
    </p>
    <p class="comment-unflag"<?php if (!$comment->flagged): ?>style="display:none"<?php endif; ?>>
        <?php echo __('Unflag inappropriate'); ?>
    </p>
<?php endif; ?>

<p class="comment-reply">
    <?php echo __('Reply'); ?>
</p>
