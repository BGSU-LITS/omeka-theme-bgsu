<?php
$pageTitle = metadata('file', array('Dublin Core', 'Title'));

if (!$pageTitle) {
    $pageTitle = metadata('file', 'original filename');
}

$item = get_record_by_id('item', $file->item_id);

if (!empty($item->collection_id)) {
    $collection = get_record_by_id('collection', $item->collection_id);
}

echo head(array('title' => $pageTitle, 'bodyclass' => 'files show', 'collection' => @$collection));
?>

<h1><?php echo $pageTitle; ?></h1>

<div class="row">
    <div class="col-md-7">
        <?php echo file_markup($file, array('imageSize' => 'fullsize')); ?>
    </div>
    <div class="col-md-5">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2 class="panel-title">
                    <?php echo __('Associated Item'); ?>
                </h2>
            </div>
            <div class="panel-body">
                <?php echo link_to_item(null, array(), 'show', $item); ?>
            </div>
        </div>
        <div id="format-metadata" class="panel panel-default">
            <div class="panel-heading">
                <h2 class="panel-title">
                    <?php echo __('Format Metadata'); ?>
                </h2>
            </div>
            <div class="panel-body">
                <div id="original-filename" class="element">
                    <h3><?php echo __('Original Filename'); ?></h3>
                    <p class="element-text">
                        <?php echo metadata('file', 'Original Filename'); ?>
                    </p>
                </div>

                <div id="file-size" class="element">
                    <h3><?php echo __('File Size'); ?></h3>
                    <p class="element-text">
                        <?php echo __('%s bytes', metadata('file', 'Size')); ?>
                    </p>
                </div>

                <div id="authentication" class="element">
                    <h3><?php echo __('Authentication'); ?></h3>
                    <p class="element-text">
                        <?php echo metadata('file', 'Authentication'); ?>
                    </p>
                </div>
            </div>
        </div>

        <div id="type-metadata" class="panel panel-default">
            <div class="panel-heading">
                <h2 class="panel-title">
                    <?php echo __('Type Metadata'); ?>
                </h2>
            </div>
            <div class="panel-body">
                <div id="mime-type-browser" class="element">
                    <h3><?php echo __('Mime Type'); ?></h3>
                    <p class="element-text">
                        <?php echo metadata('file', 'MIME Type'); ?>
                    </p>
                </div>
                <div id="file-type-os" class="element">
                    <h3><?php echo __('File Type / OS'); ?></h3>
                    <p class="element-text">
                        <?php echo metadata('file', 'Type OS'); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo all_element_texts('file', array('show_element_set_headings' => false)); ?>

<?php echo foot(array('collection' => $collection));?>
