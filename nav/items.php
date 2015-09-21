<?php
$query = array();

if (!empty($collection)) {
    $pageNav[] = array(
        'label' => __('Home'),
        'uri' => record_url($collection)
    );

    $query['collection'] = $collection->id;
}

$pageNav[] = array(
    'label' => __('Browse Items'),
    'uri' => url('items/browse', $query)
);

if (empty($collection) && total_records('Tag')) {
    $pageNav[] = array(
        'label' => __('Item Tags'),
        'uri' => url('items/tags', $query)
    );
}

$pageNav[] = array(
    'label' => __('Advanced Search'),
    'uri' => url('items/search', $query)
);

return nav($pageNav)->setUlClass('nav nav-pills');
