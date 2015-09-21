<?php
$pageTitle = metadata('exhibit', 'title');
echo head(array('bodyclass' => 'exhibits summary', 'exhibit' => $exhibit));
?>

<nav id="exhibit-pages" class="navbar navbar-default collapse navbar-collapse">
    <?php echo include(__DIR__. '/../../nav/exhibit-pages.php'); ?>
</nav>

<h1><?php echo $pageTitle; ?></h1>

<?php if ($exhibitDescription = metadata('exhibit', 'description', array('no_escape' => true))): ?>
    <div class="exhibit-description">
        <?php echo $exhibitDescription; ?>
    </div>
<?php endif; ?>

<?php if (($exhibitCredits = metadata('exhibit', 'credits'))): ?>
    <div class="exhibit-credits">
        <h2><?php echo __('Credits'); ?></h2>
        <p><?php echo $exhibitCredits; ?></p>
    </div>
<?php endif; ?>

<?php if ($exhibitPages = $exhibit->getTopPages()): ?>
    <p class="text-center">
        <?php echo exhibit_builder_link_to_exhibit($exhibit, __('Enter the Exhibit'), array('class' => 'btn btn-primary btn-lg'), reset($exhibitPages)); ?>
    </p>
<?php endif; ?>

<?php echo foot(array('exhibit' => $exhibit)); ?>
