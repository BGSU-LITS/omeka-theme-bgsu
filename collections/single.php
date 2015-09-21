<div class="record collection">
    <a href="<?php echo record_url($collection, 'show'); ?>" class="thumbnail">
        <?php if ($file = $collection->getFile()): ?>
            <div class="cover" style="background:url(<?php echo $file->getWebPath('fullsize'); ?>)"></div>
        <?php endif; ?>

        <?php if ($title = metadata($collection, array('Dublin Core', 'Title'))): ?>
            <strong><?php echo strip_formatting($title); ?></strong>
        <?php endif; ?>

        <?php if ($description = metadata($collection, array('Dublin Core', 'Description'), array('snippet' => 250, 'no_escape' => true))): ?>
            <div class="description">
                <?php echo text_to_paragraphs($description); ?>
            </div>
        <?php endif; ?>
    </a>
</div>
