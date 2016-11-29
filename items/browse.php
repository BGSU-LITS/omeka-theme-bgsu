<?php
$pageTitle = __('Browse Items');
$style = include(__DIR__. '/../style/'. get_theme_option('Style'). '.php');
$params = Zend_Controller_Front::getInstance()->getRequest()->getParams();

if (!empty($params['collection'])) {
    $collection = get_record_by_id('collection', $params['collection']);
}

echo head(array('title' => $pageTitle, 'bodyclass' => 'items browse', 'collection' => @$collection));
?>

<div class="clearfix">
    <nav class="record-nav">
        <?php echo include(__DIR__. '/../nav/items.php'); ?>
    </nav>
    <h1>
        <?php echo $pageTitle; ?>
        <small><?php echo __('(%s total)', $total_results); ?></small>
    </h1>
</div>

<?php echo item_search_filters(); ?>

<?php if ($total_results > 0): ?>
    <?php if (!empty($style['item']['browse']['sort'])): ?>
        <div id="sort">
            <span class="sort-label"><?php echo __('Sort by:'); ?></span>
            <?php
            $sortLinks[__('Title')] = 'Dublin Core,Title';
            $sortLinks[__('Creator')] = 'Dublin Core,Creator';
            $sortLinks[__('Date Added')] = 'added';
            echo browse_sort_links(array_flip($style['item']['browse']['sort']), array('list_attr' => array('class' => 'list-inline')));
            ?>
        </div>
    <?php endif; ?>

    <?php echo pagination_links(); ?>
<?php endif; ?>

<?php foreach (loop('items') as $item): ?>
    <div class="record item">
        <?php if (!empty($style['item']['browse']['picture'])): ?>
            <?php if ($image = item_image('thumbnail')): ?>
                <div class="picture">
                    <?php if (is_string($style['item']['browse']['picture'])): ?>
                        <?php echo $style['item']['browse']['picture']; ?>
                    <?php endif; ?>
                    <a href="<?php echo record_url($item, 'show'); ?>">
                        <?php echo $image; ?>
                    </a>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <h2>
            <a href="<?php echo record_url($item, 'show'); ?>">
                <?php echo strip_formatting(metadata($item, array('Dublin Core', 'Title'))); ?>
            </a>
        </h2>

        <?php if (!empty($style['item']['browse']['elements'])): ?>
            <?php foreach ($style['item']['browse']['elements'] as $setName => $setElements): ?>
                <div class="element-set">
                    <?php foreach ($setElements as $elementName => $displayName): ?>
                        <?php if ($elementText = metadata($item, array($setName, $elementName), array('delimiter' => ', '))): ?>
                            <p class="element-text">
                                <?php if (is_string($displayName)): ?>
                                    <?php echo $displayName; ?>
                                <?php endif; ?>
                                <?php echo $elementText; ?>
                            </p>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (!empty($style['item']['browse']['description'])): ?>
            <?php if ($description = metadata('item', array('Dublin Core', 'Description'), array('snippet' => 250, 'no_escape' => true))): ?>
                <div class="description">
                    <?php if (is_string($style['item']['browse']['description'])): ?>
                        <?php echo $style['item']['browse']['description']; ?>
                    <?php endif; ?>
                    <?php echo text_to_paragraphs($description); ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <?php if (!empty($style['item']['browse']['tags'])): ?>
            <?php if ($tags = tag_string('items', 'items/browse', ' ')): ?>
                <div class="tags">
                    <?php if (is_string($style['item']['browse']['tags'])): ?>
                        <?php echo $style['item']['browse']['tags']; ?>
                    <?php endif; ?>
                    <?php echo $tags; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <?php fire_plugin_hook('public_items_browse_each', array('view' => $this, 'item' => $item)); ?>
    </div>

    <hr>
<?php endforeach; ?>

<?php echo pagination_links(); ?>

<?php /*
<div id="format">
    <span class="format-label"><?php echo __('Other Formats:'); ?></span>
    <?php echo output_format_list(false); ?>
</div>
*/ ?>

<?php fire_plugin_hook('public_items_browse', array('items' => $items, 'view' => $this)); ?>

<?php echo foot(array('collection' => @$collection)); ?>
