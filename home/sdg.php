<?php
$params = array(
    'featured' => true,
    'hasImage' => true,
    'sort_field' => 'random'
);

$exhibits = get_records('Exhibit', $params, 3);
?>

<div class="row">
    <?php foreach ($exhibits as $record): ?>
        <div class="col-md-6">
            <?php echo $this->partial(
                'exhibits/single.php',
                array('exhibit' => $record)
            ); ?>
        </div>
    <?php endforeach; ?>
</div>
