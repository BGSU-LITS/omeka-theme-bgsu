<?php
$pageTitle = __('Exhibit Tags');
echo head(array('title' => $pageTitle, 'bodyclass' => 'exhibits tags'));
?>

<div class="clearfix">
    <nav class="record-nav">
        <?php echo include(__DIR__. '/../../nav/exhibits.php'); ?>
    </nav>
    <h1><?php echo $pageTitle; ?></h1>
</div>

<?php echo tag_cloud($tags, 'exhibits/browse'); ?>

<?php echo foot(); ?>
