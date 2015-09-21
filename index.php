<?php
$file = __DIR__. '/home/'. get_theme_option('style'). '.php';
echo head(array('description' => option('description'), 'bodyid' => 'home'));

if (file_exists($file)) {
    include($file);
} else {
    $params = array(
        'featured' => true,
        'hasImage' => true,
        'sort_field' => 'random'
    );

    foreach (array('Exhibit', 'Collection', 'Item') as $type) {
        $records[$type] = get_records($type, $params, 3);
    }

    $span = floor(12 / sizeof($records));
}
?>

<?php if (!empty($records)): ?>
    <div class="row">
        <?php foreach (array_keys($records) as $type): ?>
            <div class="col-md-<?php echo $span; ?>">
                <h2>
                    <a href="<?php echo $this->pluralize($type); ?>">
                        <?php echo ucwords($this->pluralize($type)); ?>
                    </a>
                </h2>

                <?php foreach ($records[$type] as $record): ?>
                    <?php echo $this->partial(
                        $this->pluralize($type). '/single.php',
                        array(strtolower($type) => $record)
                    ); ?>
                <?php endforeach; ?>

                <p class="text-center">
                    <a href="<?php echo $this->pluralize($type); ?>" class="btn btn-primary">
                        <?php echo __('Browse All '. ucwords($this->pluralize($type))); ?>
                    </a>
                </p>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php fire_plugin_hook('public_home', array('view' => $this)); ?>

<?php echo foot(); ?>
