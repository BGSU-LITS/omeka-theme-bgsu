<?php
function highlight($hl) {
    $hl = preg_replace('/^\W\s+/', '', trim($hl));
    $hl = preg_replace('/<\/em>\s+<em>/', ' ', $hl);
    $hl = str_replace('<em>', '<em class="mark">', $hl);
    return $hl;
}

$pageTitle = __('Search Results');
$style = include(__DIR__. '/../../style/'. get_theme_option('Style'). '.php');
echo head(array('title' => $pageTitle, 'bodyclass' => 'search'));
?>

<?php if ($results->response->numFound): ?>
    <h1>
        <?php echo $pageTitle; ?>:
        <?php echo isset($_GET['q']) ? html_escape($_GET['q']) : ''; ?>
        <small><?php echo __('(%s total)', $results->response->numFound); ?></small>
    </h1>

    <div class="row">
        <div class="col-sm-9">
            <?php echo pagination_links(); ?>

            <div id="solr-results">
                <?php foreach ($results->response->docs as $doc): ?>
                    <?php if ($item = get_db()->getTable($doc->model)->find($doc->modelid)): ?>
                        <div class="record item">
                            <?php if (!empty($style['item']['browse']['picture'])): ?>
                                <?php if ($image = item_image('thumbnail', array(), 0, $item)): ?>
                                    <div class="picture">
                                        <?php if (is_string($style['item']['browse']['picture'])): ?>
                                            <?php echo $style['item']['browse']['picture']; ?>
                                        <?php endif; ?>
                                        <a href="<?php echo record_url($item, 'show'); ?>">
                                            <?php echo $image; ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <h2>
                                <a href="<?php echo record_url($item, 'show'); ?>">
                                    <?php
                                    $title = is_array($doc->title) ? $doc->title[0] : $doc->title;
                                    echo $title ?: __('Untitled');
                                    ?>
                                </a>
                                <small>(<?php echo $doc->resulttype; ?>)</small>
                            </h2>

                            <?php if (!empty($style['item']['browse']['description'])): ?>
                                <?php
                                $description = '';

                                switch ($doc->resulttype) {
                                    case 'Item':
                                        $description = metadata(
                                            $item,
                                            array('Dublin Core', 'Description'),
                                            array('snippet' => 250, 'no_escape' => true)
                                        );

                                        $collection = $item->getCollection();

                                        if ($collection) {
                                            $description = 'From Collection: ' . 
                                                link_to_collection(null, array(), 'show', $collection) . 
                                                '<br>' . $description;
                                        }

                                        break;

                                    case 'Collection':
                                        $description = metadata(
                                            $item,
                                            array('Dublin Core', 'Description'),
                                            array('snippet' => 250, 'no_escape' => true)
                                        );

                                        break;

                                    case 'Exhibit':
                                        $description = snippet(
                                            $item->description,
                                            0,
                                            250
                                        );

                                        break;

                                    case 'Exhibit Page':
                                        $exhibit = $item->getExhibit();

                                        $description = 'From Exhibit: <a href="' .
                                            record_url($exhibit, 'show') . '">' .
                                            $exhibit->title . '</a>';

                                        break;
                                }
                                ?>

                                <?php if ($description): ?>
                                    <div class="description">
                                        <?php if (is_string($style['item']['browse']['description'])): ?>
                                            <?php echo $style['item']['browse']['description']; ?>
                                        <?php endif; ?>
                                        <?php echo text_to_paragraphs($description); ?>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if (!empty($style['item']['browse']['tags'])): ?>
                                <?php if ($tags = tag_string($item, 'items/browse', ' ')): ?>
                                    <p class="tags">
                                        <?php if (is_string($style['item']['browse']['tags'])): ?>
                                            <?php echo $style['item']['browse']['tags']; ?>
                                        <?php endif; ?>
                                        <?php echo $tags; ?>
                                    </p>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if (get_option('solr_search_hl')): ?>
                                <?php foreach($results->highlighting->{$doc->id} as $field): ?>
                                    <?php foreach($field as $hl): ?>
                                        <p class="highlight">&hellip;<?php echo highlight($hl); ?>&hellip;</p>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <hr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="col-sm-3">
            <?php if ($facets = SolrSearch_Helpers_Facet::parseFacets()): ?>
                <div id="solr-applied-facets" class="panel panel-default">
                    <div class="panel-heading">
                        Current Refinements
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled">
                            <?php foreach ($facets as $facet): ?>
                                <li>
                                    <span class="applied-facet-label"><?php echo SolrSearch_Helpers_Facet::keyToLabel($facet[0]); ?></span>:
                                    <span class="applied-facet-value"><?php echo $facet[1]; ?></span>
                                    <a href="<?php echo SolrSearch_Helpers_Facet::removeFacet($facet[0], $facet[1]); ?>">
                                        <span class="fa fa-times text-danger" title="Remove"></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($results->facet_counts->facet_fields): ?>
                <div id="solr-facets" class="panel panel-default">
                    <div class="panel-heading">
                        Add a Refinement
                    </div>
                    <div class="panel-body">
                        <dl>
                            <?php foreach ($results->facet_counts->facet_fields as $name => $facets): ?>
                                <?php if (count(get_object_vars($facets))): ?>
                                    <dt><?php echo SolrSearch_Helpers_Facet::keyToLabel($name); ?></dt>
                                    <?php foreach ($facets as $value => $count): ?>
                                        <dd><a href="<?php echo SolrSearch_Helpers_Facet::addFacet($name, $value); ?>" class="facet-value"><?php echo $value; ?></a>&nbsp;<small class="facet-count">(<?php echo $count; ?>)</small></dd>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </dl>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php echo pagination_links(); ?>
<?php else: ?>
    <h1>
        <?php echo $pageTitle; ?>:
        <?php echo isset($_GET['q']) ? html_escape($_GET['q']) : ''; ?>
    </h1>

    <div id="no-results">
        <p><strong class="text-danger">
            <?php echo __('No results were found.');?>
        </strong></p>
    </div>
<?php endif; ?>

<?php echo foot(); ?>
