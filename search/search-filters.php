<div id="<?php echo $options['id']; ?>">
    <h1>Search Results: <?php echo html_escape($query); ?></h1>
    <p>
        <?php echo html_escape($query_type); ?>

        search for

        <?php
        $last = array_pop($record_types);

        if ($record_types) {
            $record_types = array(implode(', ', $record_types));
        }

        $record_types[] = $last;

        echo html_escape(implode(' and ', $record_types). ' record types.');
        ?>
    </p>
</div>
