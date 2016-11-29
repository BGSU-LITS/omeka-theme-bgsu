<?php
$pageTitle = metadata('exhibit_page', 'title');
echo head(array('title' => $pageTitle, 'bodyclass' => 'exhibits show', 'exhibit' => $exhibit));
?>

<nav id="exhibit-pages" class="navbar navbar-default collapse navbar-collapse">
    <?php echo include(__DIR__. '/../../nav/exhibit-pages.php'); ?>
</nav>

<h1 class="exhibit-page">
    <?php echo $pageTitle; ?>
</h1>

<?php
$exhibitPage = get_current_record('exhibit_page');
$currentPage = $exhibitPage;
$parents = array();

while ($currentPage->parent_id) {
    $currentPage = $currentPage->getParent();
    array_unshift($parents, $currentPage);
}
?>

<ol class="breadcrumb exhibit-breadcrumb">
    <li><?php echo exhibit_builder_link_to_exhibit(); ?></li>
    <?php foreach ($parents as $parent): ?>
        <li><?php echo exhibit_builder_link_to_exhibit($exhibit, metadata($parent, 'title'), array(), $parent); ?></li>
    <?php endforeach; ?>
    <li class="active"><?php echo $pageTitle; ?></li>
</ol>

<?php exhibit_builder_render_exhibit_page(); ?>

<?php if ($children = exhibit_builder_child_pages()): ?>
    <div id="exhibit-child-pages" class="list-group">
        <?php foreach ($children as $child): ?>
            <?php echo exhibit_builder_link_to_exhibit($exhibit, metadata($child, 'title'), array('class' => 'list-group-item'), $child); ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<nav class="row" id="exhibit-page-navigation">
    <div class="col-sm-5">
        <?php echo exhibit_builder_link_to_previous_page(); ?>
    </div>
    <div class="col-sm-5 col-sm-push-2 text-right">
        <?php echo exhibit_builder_link_to_next_page(); ?>
    </div>
    <div class="col-sm-2 col-sm-pull-5 text-center">
        <?php echo exhibit_builder_link_to_exhibit(null, 'Exhibit Home'); ?>
    </div>
</nav>

<?php echo foot(array('exhibit' => $exhibit)); ?>
