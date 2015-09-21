<?php
$query['collection'] = $collection->id;

$pageNav = array(
    array(
        'label' => __('Home'),
        'uri' => record_url($collection)
    ),
    array(
        'label' => __('Exhibits'),
        'uri' => url(
            'exhibits/browse',
            $query + array('tags' => 'Centennial Memories')
        )
    ),
    array(
        'label' => __('Items'),
        'uri' => url('items/browse', $query)
    ),
    array(
        'label' => __('Search'),
        'uri' => url('items/search', $query)
    ),
    array(
        'label' => __('About'),
        'uri' => url('memories-about', $query)
    ),
    array(
        'label' => __('Centennial'),
        'uri' => 'http://www.bgsu.edu/centennial.html'
    )
);

return nav($pageNav)->setUlClass('nav nav-pills');
