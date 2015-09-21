<?php
if (empty($collection)) {
    $collection = get_record_by_id('collection', 4);
}

// Builds query string appended to requests for Bootstrap CSS.
$theme_query = http_build_query(
    // Array items are defined as Less variables when compiling CSS.
    array(
        // Color for most links and buttons.
        'brand-primary' => '#C77E1F',

        // Background for primary buttons.
        'btn-primary-bg' => '#ff7300',

        // Font stack used for most text.
        'font-family-base' => 'Georgia,Times,"Times New Roman",serif',

        // Color for headings.
        'headings-color' => '#521500'
    ),
    '',
    '&'
);

// Defines style settings for the theme.
$theme_style = array(
    // HTML for the three logos that appear on a page.
    'logo' => array(
        // Appears in the header.
        // Typically the BGSU logo.
        'header' =>
            '<img width="113" height="34" class="logo-header"'.
            ' src="https://lib.bgsu.edu/assets/img/bgsu-white.svg"'.
            ' alt="'. __('BGSU'). '">',

        // Appears below header.
        // Typically logo for the collection/exhibit.
        'navbar' => false,

        // Appears in the footer.
        // Typically the BGSU University Libraries logo.
        'footer' =>
            '<img width="190" height="50" class="logo-footer"'.
            ' src="https://lib.bgsu.edu/assets/img/ul.svg"'.
            ' alt="'. __('BGSU University Libraries'). '">',
    ),

    // Links for the three logos that appear on a page.
    'home' => array(
        // Appears in the header.
        // If false, will default to the BGSU website.
        'header' => false,

        // Appears below header.
        // If false, will default to the main Omeka page.
        'navbar' => false,

        // Appears in the footer.
        // If false, will default to the BGSU Libraries website.
        'footer' => false
    ),

    // Which search box to use.
    // Default is false, which will search entire gallery for all types.
    // If true, will search entire gallery for items.
    // If an array, key/value pairs are added as hidden fields to item search.
    'search' => array('collection' => $collection->id),

    // Which navbar to use.
    // If false, no navbar is used.
    // If true, which will show navbar for entire gallery.
    // If a string, path to file which will return an Omeka nav() object.
    'navbar' => __DIR__. '/../nav/cm.php',

    // Whether the footer should display page details.
    'footer' => true,

    // Settings for items.
    'item' => array(
        // Settings for each item when browsing items.
        'browse' => array(
            // If an array, each key is the string name of a means to sort the
            // list, and each value is the string title for that sort.
            'sort' => array(
                'Dublin Core,Title' => __('Title'),
                'added' => __('Date Added')
            ),

            // If not empty, display thumbnail picture.
            // If a string, display as title for the picture.
            'picture' => true,

            // If an array, each key is an element set name and value is an
            // array. In the value array, each key is the name of an element
            // from the element set that should be displayed. If the value is
            // a string, it specifies a title to be displayed for the element.
            'elements' => false,

            // If not empty, display description truncated to 250 characters.
            // If a string, display as title for the descripton.
            'description' => true,

            // If not empty, display tags.
            // If a string, display as title for the tags.
            'tags' => __('Tags:')
        ),

        // Settings for showing an individual item.
        'show' => array(
            // If not empty, display thumbnail pictures or embedded content.
            // If a string, display as title for the pictures.
            'pictures' => true,

            // If true, display all elements specified for the item.
            // If an array, each key is an element set name and value is which
            // items to display from that element set. If true, all items are
            // displayed. If an array, each key is the name of an element
            // from the element set that should be displayed. If the value is
            // a string, it specifies a title to be displayed for the element.
            'elements' => true,

            // If not empty, display thumbnails linking to all item files.
            // If a string, display as title for the files.
            'files' => false,

            // If not empty, display collection name.
            // If a string, display as title for the collection name.
            'collection' => false,

            // If not empty, display tags.
            // If a string, display as title for the tags.
            'tags' => __('Tags'),

            // If not empty, display recommended citation.
            // If a string, display as title for the recommended citation.
            'citation' => __('Citation'),

            // If not empty, displayed at bottom of page.
            'other' => '<h3>'. __('Rights'). '</h3><p>'. __(
                'Content submitted to Centennial Memories is available to'.
                ' users for private reflection, research, reflection,'.
                ' educational, and research purposes, not for commercial use.'.
                ' The original creators of materials in Centennial Memories'.
                ' retain all rights, except where noted. All else Copyright'.
                ' 2009 University Libraries, Center for Archival Collections,'.
                ' and Bowling Green State University.'). '</p>'
        )
    )
);

// Load Bootstrap and Bootstrap theme files with appropriate variables.
queue_css_url('https://lib.bgsu.edu/assets/theme/bootstrap.css?'. $theme_query);
queue_css_url('https://lib.bgsu.edu/assets/theme/bootstrap-theme.css?'. $theme_query);

// Load main CSS file for the theme.
queue_css_file('theme');

// Load CSS file for this style.
queue_css_file('style/cm');

// Load Javascript files for Bootstrap and the theme.
queue_js_url('https://lib.bgsu.edu/assets/js/bootstrap.js');
queue_js_file('theme');

// Return style information.
return $theme_style;
