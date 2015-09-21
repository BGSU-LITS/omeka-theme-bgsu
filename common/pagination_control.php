<?php if ($this->pageCount > 1): ?>
    <?php $getParams = $_GET; ?>

    <nav class="pagination-nav">
        <ul class="pagination">
            <li<?php if (!isset($previous)): ?> class="disabled"<?php endif; ?>>
                <?php $getParams['page'] = 1; ?>
                <a rel="start" href="<?php echo html_escape($this->url(array(), null, $getParams)); ?>" title="<?php echo __('First Page'); ?>">
                    <i class="fa fa-angle-double-left"></i>
                </a>
            </li>
            <li<?php if (!isset($previous)): ?> class="disabled"<?php endif; ?>>
                <?php $getParams['page'] = isset($previous) ? $previous : 1; ?>
                <a rel="prev" href="<?php echo html_escape($this->url(array(), null, $getParams)); ?>" title="<?php echo __('Previous Page'); ?>">
                    <i class="fa fa-angle-left"></i>
                </a>
            </li>

            <?php
            $pagesStart = $current - 2;

            if ($pagesStart < 1) {
                $pagesStart = 1;
            }

            $pagesEnd = $pagesStart + 4;

            if ($pagesEnd > $last) {
                $pagesEnd = $last;
            }

            $pages = range($pagesStart, $pagesEnd)
            ?>

            <?php foreach ($pages as $page): ?>
                <li<?php if ($page == $current): ?> class="active"<?php endif; ?>>
                    <?php $getParams['page'] = $page; ?>
                    <a href="<?php echo html_escape($this->url(array(), null, $getParams)); ?>"><?php echo $page; ?></a>
                </li>
            <?php endforeach; ?>

            <li<?php if (!isset($next)): ?> class="disabled"<?php endif; ?>>
                <?php $getParams['page'] = isset($next) ? $next : $last; ?>
                <a rel="next" href="<?php echo html_escape($this->url(array(), null, $getParams)); ?>" title="<?php echo __('Next Page'); ?>">
                    <i class="fa fa-angle-right"></i>
                </a>
            </li>
            <li<?php if (!isset($next)): ?> class="disabled"<?php endif; ?>>
                <?php $getParams['page'] = $last; ?>
                <a rel="end" href="<?php echo html_escape($this->url(array(), null, $getParams)); ?>" title="<?php echo __('Last Page'); ?>">
                    <i class="fa fa-angle-double-right"></i>
                </a>
            </li>
        </ul>
    </nav>
<?php endif; ?>
