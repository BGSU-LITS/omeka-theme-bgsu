<?php
$style = include(__DIR__. '/../style/'. get_theme_option('Style'). '.php');

if (empty($style['item']['show']['elements'])) {
    return;
}

$type = $record->getProperty('item_type_name');

if (!empty($type)) {
    $elementsForDisplay['Dublin Core']['Type']['texts'][] = $type;
}

$mimeTypes = array_unique(array_map(
    function ($file) {
        return $file->mime_type;
    },
    $record->getFiles()
));

foreach ($mimeTypes as $mimeType) {
    $elementsForDisplay['Dublin Core']['Format']['texts'][] = $mimeType;
}

$elementsForDisplay['Dublin Core']['Identifier']['texts'][] =
    record_url($record, 'show', true);

if (!is_array($style['item']['show']['elements'])) {
    $style['item']['show']['elements'] = array();

    foreach ($elementsForDisplay as $setName => $setElements) {
        $style['item']['show']['elements'][$setName] = true;
    }
}

foreach ($elementsForDisplay as $setName => $setElements) {
    if (isset($style['item']['show']['elements'][$setName])) {
        if (!is_array($style['item']['show']['elements'][$setName])) {
            $style['item']['show']['elements'][$setName] = array();

            foreach (array_keys($setElements) as $elementName) {
                $style['item']['show']['elements'][$setName][$elementName] =
                    $elementName;
            }
        }
    }
}
?>

<?php foreach ($style['item']['show']['elements'] as $setName => $setElements): ?>
    <?php if (!is_array($setElements)) continue; ?>
    <div class="element-set">
        <?php if ($showElementSetHeadings): ?>
            <h2><?php echo html_escape(__($setName)); ?></h2>
        <?php endif; ?>

        <?php foreach ($setElements as $elementName => $displayName): ?>
            <?php if ($elementName != 'Content' && !empty($elementsForDisplay[$setName][$elementName]['texts'])): ?>
                <div id="<?php echo text_to_id(html_escape("$setName $elementName")); ?>" class="element">
                    <?php if (is_string($displayName)): ?>
                        <h3><?php echo html_escape(__($displayName)); ?></h3>
                    <?php endif; ?>
                    <?php foreach ($elementsForDisplay[$setName][$elementName]['texts'] as $text): ?>
                        <?php if (!preg_match('/^slug:/', $text)): ?>
                            <div class="element-text">
                                <?php if (filter_var($text, FILTER_VALIDATE_URL)): ?>
                                    <a href="<?php echo $text; ?>"><?php echo $text; ?></a>
                                <?php else: ?>
                                    <?php echo $text; ?>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php endforeach;
