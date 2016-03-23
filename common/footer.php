            </div>
        </main>

        <footer>
            <div class="outer">
                <div class="row">
                    <div class="col-sm-4">
                        <div>
                            <a href="<?php echo empty($style['home']['header']) ? 'http://www.bgsu.edu/library.html' : $style['home']['header']; ?>">
                                <?php
                                $style = include(__DIR__. '/../style/'. get_theme_option('Style'). '.php');
                                echo empty($style['logo']['footer']) ? '' : $style['logo']['footer'];
                                ?>
                            </a>
                        </div>
                    </div>
                    <?php if (!empty($style['footer'])): ?>
                        <?php if (!empty($exhibit)): ?>
                            <div class="col-sm-8 text-right">
                                <div>
                                    The <?php echo exhibit_builder_link_to_exhibit($exhibit); ?> exhibit is part of the
                                    <span class="text-nowrap"><a href="<?php echo url('/'); ?>"><?php echo option('site_title') ?></a> at BGSU.</a>
                                </div>
                            </div>
                        <?php elseif (!empty($collection)): ?>
                            <div class="col-sm-8 text-right">
                                <div>
                                    The <?php echo link_to_collection(null, array(), 'show', $collection); ?> collection is part of the
                                    <span class="text-nowrap"><a href="<?php echo url('/'); ?>"><?php echo option('site_title') ?></a> at BGSU.</a>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="col-sm-4 col-sm-push-4 text-right">
                                <div>
                                    <a title="Like Us on Facebook" href="http://www.facebook.com/BGSULibrary" class="fa-stack fa-lg link-facebook">
                                        <i class="fa fa-square fa-stack-2x"></i>
                                        <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                                    </a>
                                    <a title="Follow Us on Twitter" href="http://twitter.com/BGSULibraries" class="fa-stack fa-lg link-twitter">
                                        <i class="fa fa-square fa-stack-2x"></i>
                                        <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                                    </a>
                                    <a title="Email Us" href="mailto:libhelp@bgsu.edu" class="fa-stack fa-lg link-envelope">
                                        <i class="fa fa-square fa-stack-2x"></i>
                                        <i class="fa fa-envelope fa-stack-1x fa-inverse"></i>
                                    </a>
                                    <a title="Subscribe to the RSS Feed" href="<?php echo url('/items/browse?output=rss2'); ?>" class="fa-stack fa-lg link-rss">
                                        <i class="fa fa-square fa-stack-2x"></i>
                                        <i class="fa fa-rss fa-stack-1x fa-inverse"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-sm-4 col-sm-pull-4 text-center">
                                <div>
                                    <a href="<?php echo url('copyright'); ?>">
                                        Copyright &amp; Use Guidelines
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <?php fire_plugin_hook('public_footer', array('view' => $this)); ?>
            </div>
        </footer>
    </div>
</body>
</html>
