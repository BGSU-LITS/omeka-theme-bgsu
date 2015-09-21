<?php
$pageTitle = metadata('simple_pages_page', 'title');
$bodyclass = 'page simple-page';

if ($is_home_page) {
    $bodyclass .= ' simple-page-home';
}

$bodyid = metadata('simple_pages_page', 'slug');
echo head(array('title' => $pageTitle, 'bodyclass' => $bodyclass, 'bodyid' => $bodyid));
?>

<div id="primary">
    <?php if (!$is_home_page): ?>
        <h1><?php echo metadata('simple_pages_page', 'title'); ?></h1>
    <?php endif; ?>

    <?php echo $this->shortcodes(metadata('simple_pages_page', 'text', array('no_escape' => true))); ?>
</div>

<?php echo foot(); ?>
