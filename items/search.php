<?php
$pageTitle = __('Advanced Search');
$params = Zend_Controller_Front::getInstance()->getRequest()->getParams();

if (!empty($params['collection'])) {
    $collection = get_record_by_id('collection', $params['collection']);
}

echo head(array('title' => $pageTitle, 'bodyclass' => 'items advanced-search', 'collection' => @$collection));
?>

<div class="clearfix">
    <nav class="record-nav">
        <?php echo include(__DIR__. '/../nav/items.php'); ?>
    </nav>
    <h1><?php echo $pageTitle; ?></h1>
</div>

<?php echo $this->partial('items/search-form.php', array('formAttributes' => array('id' => 'advanced-search-form'))); ?>

<?php echo foot(array('collection' => @$collection)); ?>
