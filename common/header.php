<!DOCTYPE html>
<html lang="<?php echo get_html_lang(); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        <?php
        if (isset($title)) {
            $titleParts[] = strip_formatting($title);
        }

        if (!empty($exhibit)) {
            $titleParts[] = metadata($exhibit, 'title');
        } elseif (!empty($collection)) {
            $titleParts[] = metadata(
                $collection,
                array('Dublin Core', 'Title')
            );
        }

        $titleParts[] = option('site_title');
        $titleParts[] = 'BGSU Libraries';
        echo implode(' &middot; ', $titleParts);
        ?>
    </title>

    <?php if (isset($description)): ?>
        <meta name="description" content="<?php echo $description; ?>">
    <?php endif; ?>

    <?php echo auto_discovery_link_tags(); ?>
    <?php fire_plugin_hook('public_head', array('view' => $this)); ?>

    <?php
    queue_css_url('https://lib.bgsu.edu/assets/css/font-awesome.css');
    queue_css_url('https://lib.bgsu.edu/assets/css/photoswipe.css');
    queue_css_url('https://lib.bgsu.edu/assets/css/photoswipe/default-skin.css');

    queue_js_url('https://lib.bgsu.edu/assets/js/photoswipe.js');
    queue_js_url('https://lib.bgsu.edu/assets/js/photoswipe-ui-default.js');
    queue_js_url('https://lib.bgsu.edu/assets/js/typogr.js');

    $style = include(__DIR__. '/../style/'. get_theme_option('style'). '.php');
    echo head_css();
    echo head_js();
    ?>
</head>
<?php echo body_tag(array('id' => @$bodyid, 'class' => @$bodyclass)); ?>
    <a href="#content" id="skipnav" class="sr-only sr-only-focusable"><?php echo __('Skip to main content'); ?></a>
    <?php fire_plugin_hook('public_body', array('view' => $this)); ?>

    <header>
        <?php fire_plugin_hook('public_header', array('view' => $this)); ?>
        <div class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3">
                        <p>
                            <a href="<?php echo empty($style['home']['header']) ? 'http://www.bgsu.edu/' : $style['home']['header']; ?>">
                                <?php echo empty($style['logo']['header']) ? __('BGSU') : $style['logo']['header']; ?>
                            </a>
                        </p>
                    </div>
                    <div class="header-search col-sm-7 col-md-8 col-lg-9 hidden-xs text-right" role="search">
                        <?php if ($cse = get_theme_option('cse')): ?>
                            <form class="form-inline" action="https://www.google.com/cse">
                                <div class="form-group">
                                    <label for="q" class="sr-only"><?php echo __('Search'); ?></label>
                                    <input type="hidden" name="cx" value="<?php echo $cse; ?>">
                                    <input type="hidden" name="ie" value="UTF-8">
                                    <input type="text" name="q" id="q" placeholder="<?php echo __('Search'); ?>" class="form-control">
                                </div>
                                <input type="submit" value="<?php echo __('Go'); ?>" class="btn btn-primary">
                            </form>
                        <?php else: ?>
                            <?php echo search_form(array('show_advanced' => true, 'form_attributes' => array('id' => 'search-form-header', 'class' => 'form-inline'), 'limiters' => @$style['search'])); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container clearfix">
        <?php if (!empty($style['navbar'])): ?>
            <nav id="public-nav-main" class="navbar navbar-default">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo empty($style['home']['navbar']) ? url('/') : $style['home']['navbar']; ?>">
                        <?php echo empty($style['logo']['navbar']) ? __('Home') : $style['logo']['navbar']; ?>
                    </a>
                </div>
                <div class="collapse navbar-collapse">
                    <div class="navbar-search hidden-sm hidden-md hidden-lg" role="search">
                        <?php echo search_form(array('form_attributes' => array('id' => 'search-bar-nav', 'class' => 'navbar-form'), 'limiters' => @$style['search'])); ?>
                    </div>
                    <?php
                    if ($style['navbar'] !== true) {
                        $navbar = include($style['navbar']);
                        echo $navbar->setUlClass('nav navbar-nav navbar-right');
                    }

                    ?>
                </div>
            </nav>
        <?php endif; ?>

        <main id="content">
            <div class="wrapper clearfix">
                <?php fire_plugin_hook('public_content_top', array('view' => $this)); ?>
