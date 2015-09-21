<?php
$pageNav = array();

if ($exhibitPages = $exhibit->getTopPages()) {
    foreach ($exhibitPages as $exhibitPage) {
        $pageNav[] = array(
            'label' => metadata($exhibitPage, 'title', array('no_escape' => true)),
            'uri' => exhibit_builder_exhibit_uri($exhibit, $exhibitPage)
        );
    }
}

return nav($pageNav)->setUlClass('nav navbar-nav');
