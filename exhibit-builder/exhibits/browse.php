<?php
$pageTitle = __('Browse Exhibits');
echo head(array('title' => $pageTitle, 'bodyclass' => 'exhibits browse'));
?>

<div class="clearfix">
    <nav class="record-nav">
        <?php echo include(__DIR__. '/../../nav/exhibits.php'); ?>
    </nav>

    <h1>
        <?php echo $pageTitle; ?>
        <small><?php echo __('(%s total)', $total_results); ?></small>
    </h1>
</div>

<?php echo item_search_filters(); ?>

<?php echo pagination_links(); ?>

<?php foreach (loop('exhibits') as $exhibit): ?>
    <div class="record exhibit">
        <?php if ($image = record_image('exhibit', 'thumbnail')): ?>
            <div class="picture picture-stack">
                <?php echo link_to_exhibit($image); ?>
            </div>
        <?php endif; ?>

        <h2><?php echo link_to_exhibit(); ?></h2>

        <?php if ($description = metadata('exhibit', 'description', array('snippet' => 250, 'no_escape' => true))): ?>
            <div class="description">
                <?php echo $description; ?>
            </div>
        <?php endif; ?>

        <?php if ($tags = tag_string('exhibits', 'exhibits', ' ')): ?>
            <div class="tags">
                <?php echo __('Tags:'); ?>
                <?php echo $tags; ?></p>
            </div>
        <?php endif; ?>
    </div>

    <hr>
<?php endforeach; ?>

<?php echo pagination_links(); ?>

<?php echo foot(); ?>
