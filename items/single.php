<div class="record item">
    <a href="<?php echo record_url($item, 'show'); ?>" class="thumbnail">
        <?php if ($file = $item->getFile(0)): ?>
            <div class="cover" style="background:url(<?php echo $file->getWebPath('fullsize'); ?>)"></div>
        <?php endif; ?>

        <?php if ($title = metadata($item, array('Dublin Core', 'Title'))): ?>
            <strong><?php echo strip_formatting($title); ?></strong>
        <?php endif; ?>

        <?php if ($description = metadata($item, array('Dublin Core', 'Description'), array('snippet' => 250, 'no_escape' => true))): ?>
            <div class="description">
                <?php echo text_to_paragraphs($description); ?>
            </div>
        <?php endif; ?>
    </a>
</div>
