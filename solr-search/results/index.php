<?php
function highlight($hl) {
    $hl = str_replace('<', ' <', $hl);
    $hl = strip_tags($hl, '<em>');
    $hl = str_replace(' <', '<', $hl);
    $hl = str_replace('</em> <em>', ' ', $hl);
    $hl = str_replace('<em>', '<em class="mark">', $hl);
    $hl = preg_replace('/^\W\s+/', '', trim($hl));
    return $hl;
}

$pageTitle = __('Search Results');
echo head(array('title' => $pageTitle, 'bodyclass' => 'search'));
?>

<h1>
    <?php echo $pageTitle; ?>:
    <?php echo isset($_GET['q']) ? html_escape($_GET['q']) : ''; ?>
</h1>

<?php if ($results->response->numFound): ?>
    <div class="row">
        <div class="col-sm-8">
            <?php echo pagination_links(); ?>

            <div id="solr-results">
                <?php foreach ($results->response->docs as $doc): ?>
                    <h2>
                        <a href="<?php echo SolrSearch_Helpers_View::getDocumentUrl($doc); ?>">
                            <?php
                            $title = is_array($doc->title) ? $doc->title[0] : $doc->title;
                            echo $title ?: __('Untitled');
                            ?>
                        </a>
                    </h2>

                    <?php if (get_option('solr_search_hl')): ?>
                        <?php foreach($results->highlighting->{$doc->id} as $field): ?>
                            <?php foreach($field as $hl): ?>
                                <p class="highlight">&hellip;<?php echo highlight($hl); ?>&hellip;</p>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <hr>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="col-sm-4">
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
                                        <dd class="<?php echo $value; ?>">
                                            <a href="<?php echo SolrSearch_Helpers_Facet::addFacet($name, $value); ?>" class="facet-value"><?php echo $value; ?></a>&nbsp;<small class="facet-count">(<?php echo $count; ?>)</small>
                                        </dd>
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
    <div id="no-results">
        <p><strong class="text-danger">
            <?php echo __('No results were found.');?>
        </strong></p>
    </div>
<?php endif; ?>

<?php echo foot(); ?>
