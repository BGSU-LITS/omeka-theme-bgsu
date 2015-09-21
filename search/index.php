<?php
$searchRecordTypes = get_search_record_types();
echo head(array('title' => 'Search Results', 'bodyclass' => 'search'));
?>

<?php echo search_filters(); ?>

<?php if ($total_results): ?>
    <?php echo pagination_links(); ?>

    <table id="search-results" class="table">
        <thead>
            <tr>
                <th><?php echo __('Title');?></th>
                <th><?php echo __('Part Of');?></th>
                <th colspan="2"><?php echo __('Record Type');?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (loop('search_texts') as $searchText): ?>
                <?php
                $record = get_record_by_id(
                    $searchText['record_type'],
                    $searchText['record_id']
                );

                $file = false;

                if ($searchText->record_type === 'File') {
                    $file = $record;
                    $fileInfo = pathinfo($file['filename']);
                    $record = get_record_by_id('Item', $record['item_id']);
                }

                if (empty($searchText['title'])) {
                    $searchText['title'] = metadata(
                        $record,
                        array('Dublin Core', 'Title')
                    );
                }

                if ($searchText->record_type == 'ExhibitPage') {
                    $partOf = $record->getExhibit();

                    if ($partOf) {
                        $partOfTitle = $partOf->title;
                    }
                } else {
                    $partOf = get_collection_for_item($record);

                    if ($partOf) {
                        $partOfTitle = metadata(
                            $partOf,
                            array('Dublin Core', 'Title')
                        );
                    }
                }
                ?>
                <tr>
                    <td>
                        <a href="<?php echo record_url($record, 'show'); ?>">
                            <?php echo $searchText['title'] ? $searchText['title'] : '[Unknown]'; ?>
                        </a>
                    </td>
                    <td>
                        <?php if ($partOf): ?>
                            <a href="<?php echo record_url($partOf, 'show'); ?>">
                                <?php echo $partOfTitle; ?>
                            </a>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php echo $searchRecordTypes[$searchText['record_type']]; ?>
                    </td>
                    <td class="text-right">
                        <?php if ($file): ?>
                            <a href="<?php echo file_display_url($file, 'original'); ?>">
                                Download <?php echo strtoupper($fileInfo['extension']); ?>
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php echo pagination_links(); ?>
<?php else: ?>
    <div id="no-results">
        <p><strong class="text-danger">
            <?php echo __('No results were found.');?>
        </strong></p>
    </div>
<?php endif; ?>

<?php echo foot(); ?>
