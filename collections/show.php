<?php
queue_js_url('https://lib.bgsu.edu/assets/js/masonry.pkgd.js');

$featuredDisplay = get_theme_option('featured');

if ($featuredDisplay != 'disabled') {
    $featuredItems = get_records(
        'Item',
        array(
            'collection' => $collection->id,
            'featured' => true,
            'hasImage' => true,
            'sort_field' => 'random'
        )
    );
}

$pageTitle = metadata('collection', array('Dublin Core', 'Title'));
echo head(array('title' => $pageTitle, 'bodyclass' => 'collections show', 'collection' => $collection));
?>

<?php if ($featuredItems && $featuredDisplay == 'carousel'): ?>
    <div class="featured-carousel">
        <div class="featured-carousel-display">
            <ul>
                <?php foreach (loop('items', $featuredItems) as $item): ?>
                    <?php if ($file = $item->getFile(0)): ?>
                        <li style="background:url(<?php echo $file->getWebPath('fullsize'); ?>)">
                            <a href="<?php echo record_url($item, 'show'); ?>">
                                <div><?php echo metadata($item, array('Dublin Core', 'Title')); ?></div>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="featured-carousel-control">
            <a href="#" class="featured-carousel-control-prev">
                <i class="fa fa-angle-double-left"></i>
            </a>
            <a href="#" class="featured-carousel-control-next">
                <i class="fa fa-angle-double-right"></i>
            </a>
        </div>
    </div>
<?php endif; ?>

<div class="clearfix">
    <nav class="record-nav">
        <?php echo include(__DIR__. '/../nav/items.php'); ?>
    </nav>
    <h1><?php echo $pageTitle; ?></h1>
</div>

<?php if ($description = metadata('collection', array('Dublin Core', 'Description'))): ?>
    <div class="description">
        <?php echo $description; ?>
    </div>
<?php endif; ?>

<?php if ($featuredItems && $featuredDisplay == 'gallery'): ?>
    <div class="featured">
        <h2><?php echo __('Featured'); ?></h2>
        <div>
        <?php foreach (loop('items', $featuredItems) as $item): ?>
            <?php if ($image = item_image('fullsize')): ?>
                <div class="picture">
                    <a href="<?php echo record_url($item, 'show'); ?>">
                        <?php echo $image; ?>
                    </a>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
        </div>
    </div>

    <script>
    jQuery(window).load(function() {
        new Masonry(
            '.featured div',
            {'percentPosition': true, transitionDuration: 0}
        );
    });
    </script>
<?php endif; ?>


<?php fire_plugin_hook('public_collections_show', array('view' => $this, 'collection' => $collection)); ?>
<?php echo foot(array('collection' => $collection)); ?>
