<?php
$pageNav = array(
    array(
        'label' => __('Browse Exhibits'),
        'uri' => url('exhibits'. (empty($total_results) ? '/browse' : ''))
    ),
    array(
        'label' => __('Exhibit Tags'),
        'uri' => url('exhibits/tags')
    )
);

return nav($pageNav)->setUlClass('nav nav-pills');
