<?php
if (empty($formActionUri)) {
    $formAttributes['action'] = url(array('controller' => 'items', 'action' => 'browse'));
} else {
    $formAttributes['action'] = $formActionUri;
}

$formAttributes['method'] = 'GET';

if (!empty($_GET['advanced'])) {
    $search = $_GET['advanced'];
} else {
    $search = array(array('field' => '', 'type' => '', 'value' => ''));
}

if (!isset($buttonText)) {
    $buttonText = __('Search');
}
?>

<form class="form-horizontal" <?php echo tag_attributes($formAttributes); ?>>
    <div id="search-keywords" class="form-group">
        <?php
        echo $this->formLabel(
            'keyword-search',
            __('Search for Keywords'),
            array('class' => 'col-md-3 control-label')
        );
        ?>
        <div class="col-md-9">
            <?php
            echo $this->formText(
                'search',
                @$_REQUEST['search'],
                array('id' => 'keyword-search', 'class' => 'form-control')
            );
            ?>
        </div>
    </div>
    <div id="search-narrow-by-fields" class="form-group">
        <?php
        echo $this->formLabel(
            'advanced-0-element_id',
            __('Narrow by Specific Fields'),
            array('class' => 'col-md-3 control-label')
        );
        ?>
        <div class="col-md-9">
            <?php foreach ($search as $i => $rows): ?>
                <p class="search-entry">
                    <?php
                    echo $this->formSelect(
                        "advanced[$i][element_id]",
                        @$rows['element_id'],
                        array('title' => __("Search Field"), 'class' => 'form-control form-control-inline'),
                        get_table_options(
                            'Element',
                            null,
                            array('record_types' => array('Item', 'All'), 'sort' => 'orderBySet')
                        )
                    );
                    ?>
                    <?php
                    echo $this->formSelect(
                        "advanced[$i][type]",
                        @$rows['type'],
                        array('title' => __("Search Type"), 'class' => 'form-control form-control-inline'),
                        label_table_options(array(
                            'contains' => __('contains'),
                            'does not contain' => __('does not contain'),
                            'is exactly' => __('is exactly'),
                            'is empty' => __('is empty'),
                            'is not empty' => __('is not empty')
                        ))
                    );
                    ?>
                    <?php
                    echo $this->formText(
                        "advanced[$i][terms]",
                        @$rows['terms'],
                        array('title' => __("Search Terms"), 'class' => 'form-control form-control-inline')
                    );
                    ?>
                    <button type="button" class="remove_search btn btn-danger" style="display:none" disabled>
                        <?php echo __('Remove'); ?>
                    </button>
                </p>
            <?php endforeach; ?>
        </div>
        <div class="col-md-9 col-md-offset-3">
            <button type="button" class="add_search btn btn-default">
                <?php echo __('Add a Field'); ?>
            </button>
        </div>
    </div>
    <div id="search-by-range" class="form-group">
        <?php
        echo $this->formLabel(
            'range',
            __('Search by a Range of IDs'),
            array('class' => 'col-md-3 control-label')
        );
        ?>
        <div class="col-md-9">
            <?php
            echo $this->formText(
                'range',
                @$_GET['range'],
                array('class' => 'form-control', 'placeholder' => __('Example: 1-4, 156, 79'))
            );
            ?>
        </div>
    </div>
    <div class="form-group">
        <?php
        echo $this->formLabel(
            'collection-search',
            __('Search by Collection'),
            array('class' => 'col-md-3 control-label')
        );
        ?>
        <div class="col-md-9">
            <?php if (isset($_GET['collection'])): ?>
                <input type="text" value="<?php echo metadata(get_record_by_id('collection', $_GET['collection']), array('Dublin Core', 'Title')); ?>" class="form-control" disabled>
                <input type="hidden" name="collection" value="<?php echo html_escape($_GET['collection']); ?>">
            <?php else: ?>
                <?php
                echo $this->formSelect(
                    'collection',
                    @$_REQUEST['collection'],
                    array('id' => 'collection-search', 'class' => 'form-control'),
                    get_table_options('Collection')
                );
                ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="form-group">
        <?php
        echo $this->formLabel(
            'item-type-search',
            __('Search by Type'),
            array('class' => 'col-md-3 control-label')
        );
        ?>
        <div class="col-md-9">
            <?php
            echo $this->formSelect(
                'type',
                @$_REQUEST['type'],
                array('id' => 'item-type-search', 'class' => 'form-control'),
                get_table_options('ItemType')
            );
            ?>
        </div>
    </div>

    <?php if (is_allowed('Users', 'browse')): ?>
        <div class="form-group">
            <?php
            echo $this->formLabel(
                'user-search',
                __('Search by User'),
                array('class' => 'col-md-3 control-label')
            );
            ?>
            <div class="col-md-9">
                <?php
                echo $this->formSelect(
                    'user',
                    @$_REQUEST['user'],
                    array('id' => 'user-search', 'class' => 'form-control'),
                    get_table_options('User')
                );
                ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <?php
        echo $this->formLabel(
            'tag-search',
            __('Search by Tags'),
            array('class' => 'col-md-3 control-label')
        );
        ?>
        <div class="col-md-9">
            <?php
            echo $this->formText(
                'tags',
                @$_REQUEST['tags'],
                array('id' => 'tag-search', 'class' => 'form-control')
            );
            ?>
        </div>
    </div>

    <?php if (is_allowed('Items', 'showNotPublic')): ?>
        <div class="form-group">
            <?php
            echo $this->formLabel(
                'public',
                __('Public/Non-Public'),
                array('class' => 'col-md-3 control-label')
            );
            ?>
            <div class="col-md-9">
                <?php
                echo $this->formSelect(
                    'public',
                    @$_REQUEST['public'],
                    array('class' => 'form-control'),
                    label_table_options(array(
                        '1' => __('Only Public Items'),
                        '0' => __('Only Non-Public Items')
                    ))
                );
                ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <?php
        echo $this->formLabel(
            'featured',
            __('Featured/Non-Featured'),
            array('class' => 'col-md-3 control-label')
        );
        ?>
        <div class="col-md-9">
            <?php
            echo $this->formSelect(
                'featured',
                @$_REQUEST['featured'],
                array('class' => 'form-control'),
                label_table_options(array(
                    '1' => __('Only Featured Items'),
                    '0' => __('Only Non-Featured Items')
                ))
            );
            ?>
        </div>
    </div>

    <?php
    if (!isset($_GET['collection'])) {
        ob_start();
        fire_plugin_hook('public_items_search', array('view' => $this));
        $output = ob_get_clean();

        echo str_replace(
            array(
                '<div class="field"',
                '<div class="two columns alpha"',
                '<label ',
                '<div class="five columns omega inputs"',
                '<select ',
            ),
            array(
                '<div class="form-group"',
                '<div',
                '<label class="col-md-3 control-label" ',
                '<div class="col-md-9"',
                '<select class="form-control" '
            ),
            $output
        );
    }
    ?>

    <div class="form-group">
        <div class="col-md-9 col-md-offset-3">
            <input type="submit" class="btn btn-primary" name="submit_search" id="submit_search_advanced" value="<?php echo $buttonText ?>">
        </div>
    </div>
</form>

<?php echo js_tag('items-search'); ?>

<script type="text/javascript">
    jQuery(document).ready(function () {
        Omeka.Search.activateSearchButtons();
    });
</script>
