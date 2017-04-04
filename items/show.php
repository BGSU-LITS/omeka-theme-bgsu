<?php
$pageTitle = metadata('item', array('Dublin Core', 'Title'));
$style = include(__DIR__. '/../style/'. get_theme_option('Style'). '.php');
$params = Zend_Controller_Front::getInstance()->getRequest()->getParams();

if (preg_match('/\.jpg$/', $params['id'])) {
    $file = getcwd() . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR .
        $item->getFile()->getStoragePath('thumbnail');

    if (file_exists($file)) {
        header('Content-Type: image/jpeg');
        readfile($file);
        exit();
    }
}

if (!empty($style['item']['show']['pictures'])) {
    add_file_display_callback('application/pdf', function ($file, $options) {
        return
            '<a href="'. $file->getWebPath('fullsize'). '">'.
            '<img src="'. $file->getWebPath('thumbnail'). '" alt="Cover"></a>'.
            '<div><a class="btn btn-default" href="'. $file->getWebPath('original'). '">'.
            __('Download PDF'). '</a></div>';
    });
}

if (!empty($item->collection_id)) {
    $collection = get_record_by_id('collection', $item->collection_id);
}

echo head(array('title' => $pageTitle, 'bodyclass' => 'item show', 'collection' => @$collection, 'exhibit' => @$exhibit));
?>

<?php if (!empty($exhibit)): ?>
    <nav id="exhibit-pages" class="navbar navbar-default collapse navbar-collapse">
        <?php echo include(__DIR__. '/../nav/exhibit-pages.php'); ?>
    </nav>
    <h1><?php echo $pageTitle; ?></h1>
    <ol class="breadcrumb">
        <li><?php echo exhibit_builder_link_to_exhibit(); ?></li>
        <li class="active"><?php echo $pageTitle; ?></li>
    </ol>
<?php elseif (!empty($collection)): ?>
    <div class="clearfix">
        <nav class="record-nav">
            <?php echo include(__DIR__. '/../nav/items.php'); ?>
        </nav>
        <h1><?php echo $pageTitle; ?></h1>
    </div>
    <ol class="breadcrumb">
        <li><?php echo link_to_collection_for_item(); ?></li>
        <li class="active"><?php echo $pageTitle; ?></li>
    </ol>
<?php else: ?>
    <h1><?php echo $pageTitle; ?></h1>
<?php endif; ?>

<?php if (!empty($style['item']['show']['pictures'])): ?>
    <?php if ($content = metadata('item', array(ElementSet::ITEM_TYPE_NAME, 'Content'))): ?>
        <div id="itemfiles" class="element pictures clearfix">
            <?php if (is_string($style['item']['show']['pictures'])): ?>
                <h3><?php echo $style['item']['show']['pictures']; ?></h3>
            <?php endif; ?>
            <div class="element-text">
                <?php echo $content; ?>
            </div>
        </div>
    <?php elseif (metadata('item', 'has files')): ?>
        <div id="itemfiles" class="element pictures clearfix">
            <?php if (is_string($style['item']['show']['pictures'])): ?>
                <h3><?php echo $style['item']['show']['pictures']; ?></h3>
            <?php endif; ?>
            <div class="element-text">
                <?php foreach ($item->Files as $file): ?>
                    <?php
                    $w = '';
                    $h = '';

                    $watermark = false;

                    $mime_types = array(
                        'image/gif',
                        'image/jpeg',
                        'image/png',
                        'application/pdf'
                    );

                    if (in_array($file->mime_type, $mime_types)) {
                        $watermark = get_theme_option('Watermark') !== '0';

                        if ($file->has_derivative_image) {
                            $metadata = json_decode($file->metadata, true);

                            if (!empty($metadata['video']['resolution_x'])
                             && !empty($metadata['video']['resolution_y'])) {
                                $w = $metadata['video']['resolution_x'];
                                $h = $metadata['video']['resolution_y'];
                            } else {
                                $path = FILES_DIR. '/'.
                                    $file->getStoragePath('fullsize');
                                $size = getimagesize($path);

                                if (!empty($size[0]) && !empty($size[1])) {
                                    $w = $size[0];
                                    $h = $size[1];
                                }
                            }
                        }
                    }

                    $file_markup = file_markup(
                        $file,
                        array('imageSize' => 'thumbnail'),
                        array(
                            'class' => 'picture',
                            'data-w' => (string) $w,
                            'data-h' => (string) $h
                        )
                    );

                    if (!empty($watermark)) {
                        $preg = '{//([^/]+)/((.*/)?files/(fullsize|original)/)}';
                        $replace = '//$1/w/$2';

                        if (preg_match($preg, $file_markup, $matches)) {
                            if ($matches[1] === 'digitalgallery.bgsu.edu') {
                                $replace = '//lib.bgsu.edu/w/digitalgallery/$2';
                            }
                        }

                        $file_markup = preg_replace(
                            $preg,
                            $replace,
                            $file_markup
                        );
                    }

                    echo $file_markup;
                    ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php echo all_element_texts('item', array('show_element_set_headings' => false)); ?>

<?php if (!empty($style['item']['show']['files']) && metadata('item', 'has files')): ?>
    <div id="itemfiles" class="element">
        <?php if (is_string($style['item']['show']['files'])): ?>
            <h3><?php echo $style['item']['show']['files']; ?></h3>
        <?php endif; ?>
        <div class="element-text">
            <?php foreach ($item->Files as $file): ?>
                <?php echo file_markup($file, array('imageSize' => 'thumbnail')); ?>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<?php if (!empty($style['item']['show']['collection'])): ?>
    <div id="collection" class="element">
        <?php if (is_string($style['item']['show']['collection'])): ?>
            <h3><?php echo $style['item']['show']['collection']; ?></h3>
        <?php endif; ?>
        <div class="element-text">
            <p><?php echo link_to_collection_for_item(); ?></p>
        </div>
    </div>
<?php endif; ?>

<?php if (!empty($style['item']['show']['tags'])): ?>
    <?php if (metadata('item', 'has tags')): ?>
        <div id="item-tags" class="element">
            <?php if (is_string($style['item']['show']['tags'])): ?>
                <h3><?php echo $style['item']['show']['tags']; ?></h3>
            <?php endif; ?>
            <div class="element-text">
                <p class="tags"><?php echo tag_string('items', 'items/browse', ' '); ?></p>
            </div>
        </div>
    <?php endif;?>
<?php endif;?>

<?php if (!empty($style['item']['show']['citation'])): ?>
    <div id="item-citation" class="element">
        <?php if (is_string($style['item']['show']['citation'])): ?>
            <h3><?php echo $style['item']['show']['citation']; ?></h3>
        <?php endif; ?>
        <div class="element-text">
            <?php echo metadata('item', 'citation', array('no_escape' => true)); ?>
        </div>
    </div>
<?php endif; ?>

<?php if (!empty($style['item']['show']['other'])): ?>
    <?php echo $style['item']['show']['other']; ?>
<?php endif; ?>

<?php fire_plugin_hook('public_items_show', array('view' => $this, 'item' => $item)); ?>

<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="pswp__bg"></div>
    <div class="pswp__scroll-wrap">
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>
        <div class="pswp__ui pswp__ui--hidden">
            <div class="pswp__top-bar">
                <div class="pswp__counter"></div>
                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                <button class="pswp__button pswp__button--share" title="Share"></button>
                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                      <div class="pswp__preloader__cut">
                        <div class="pswp__preloader__donut"></div>
                      </div>
                    </div>
                </div>
            </div>
            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div>
            </div>
            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>
        </div>
    </div>
</div>

<?php echo foot(array('collection' => @$collection, 'exhibit' => @$exhibit)); ?>
