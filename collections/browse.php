<?php
$pageTitle = __('Browse Collections');
echo head(array('title' => $pageTitle, 'bodyclass' => 'collections browse'));
?>

<h1>
    <?php echo $pageTitle; ?>
    <small><?php echo __('(%s total)', $total_results); ?></small>
</h1>

<?php if ($total_results > 0): ?>
    <div id="sort">
        <span class="sort-label"><?php echo __('Sort by:'); ?></span>
        <?php
        $sortLinks[__('Title')] = 'Dublin Core,Title';
        $sortLinks[__('Date Added')] = 'added';
        echo browse_sort_links($sortLinks, array('list_attr' => array('class' => 'list-inline')));
        ?>
    </div>

    <?php echo pagination_links(); ?>
<?php endif; ?>

<?php foreach (loop('collections') as $collection): ?>
    <div class="record collection">
        <?php if ($image = record_image('collection', 'thumbnail')): ?>
            <div class="picture picture-stack">
                <?php echo link_to_collection($image); ?>
            </div>
        <?php endif; ?>

        <h2><?php echo link_to_collection(); ?></h2>

        <?php if ($description = metadata('collection', array('Dublin Core', 'Description'), array('snippet' => 250, 'no_escape' => true))): ?>
            <div class="description">
                <?php echo text_to_paragraphs($description); ?>
            </div>
        <?php endif; ?>

        <?php fire_plugin_hook('public_collections_browse_each', array('view' => $this, 'collection' => $collection)); ?>
    </div>
    <hr>
<?php endforeach; ?>

<?php echo pagination_links(); ?>
<?php fire_plugin_hook('public_collections_browse', array('collections' => $collections, 'view' => $this)); ?>
<?php echo foot(); ?>
