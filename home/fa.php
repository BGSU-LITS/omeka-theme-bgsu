<?php $collections = get_records('Collection'); ?>

<h1><?php echo __('Welcome'); ?></h1>
<div class="row">
    <?php foreach($collections as $collection): ?>
        <div class="col-sm-6">
            <h3>
                <?php
                $title = metadata($collection, array('Dublin Core', 'Title'));

                $queryParams = array(
                    'collection' => $collection->id,
                    'sort_field' => 'Dublin Core,Title'
                );

                echo link_to('items', 'browse', $title, array(), $queryParams);
                ?>
            </h3>

            <?php if ($description = metadata($collection, array('Dublin Core', 'Description'))): ?>
                <p><?php echo $description; ?></p>
            <?php endif; ?>

            <h4>Browse Sub-Collections</h4>
            <ul>
                <?php 
                $subjects = metadata($collection, array('Dublin Core', 'Subject'), array('all' => true)) ;
                sort($subjects);
                foreach ($subjects as $subject): ?>
                    <li>
                        <?php
                        $queryParams = array(
                            'tags' => $subject,
                            'collection' => $collection->id,
                            'sort_field' => 'Dublin Core,Title'
                        );

                        echo link_to('items', 'browse', $subject, array(), $queryParams);
                        ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endforeach; ?>
</div>

<script src="https://lib.bgsu.edu/assets/js/masonry.pkgd.js"></script>
<script>
jQuery(window).load(function() {
    new Masonry(
        'main .row',
        {'percentPosition': true, transitionDuration: 0}
    );
});
</script>
