<div class="record exhibit">
    <a href="<?php echo record_url($exhibit, 'show'); ?>" class="thumbnail">
        <?php if ($file = $exhibit->getFile()): ?>
            <div class="cover" style="background:url(<?php echo $file->getWebPath('fullsize'); ?>)"></div>
        <?php endif; ?>

        <?php if ($title = metadata($exhibit, 'title')): ?>
            <strong><?php echo strip_formatting($title); ?></strong>
        <?php endif; ?>

        <?php if ($description = metadata($exhibit, 'description', array('snippet' => 250, 'no_escape' => true))): ?>
            <div class="description">
                <?php echo text_to_paragraphs($description); ?>
            </div>
        <?php endif; ?>
    </a>
</div>
