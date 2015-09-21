<?php
$pageTitle = __('Exhibit Tags');
echo head(array('title' => $pageTitle, 'bodyclass' => 'exhibits tags'));
?>

<div class="row">
    <div class="record-title col-md-6">
        <h1><?php echo $pageTitle; ?></h1>
    </div>
    <nav class="record-nav col-md-6">
        <?php echo include(__DIR__. '/../../nav/exhibits.php'); ?>
    </nav>
</div>

<?php echo tag_cloud($tags, 'exhibits/browse'); ?>

<?php echo foot(); ?>
