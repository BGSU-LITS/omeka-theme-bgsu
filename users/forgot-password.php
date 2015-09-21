<?php
$pageTitle = __('Forgot Password');
echo head(array('title' => $pageTitle, 'bodyclass' => 'login'), $header);
?>

<h1><?php echo $pageTitle; ?></h1>

<ul class="list-inline">
    <li><?php echo link_to('users', 'login', __('Back to Log In')); ?></li>
</ul>

<p><?php echo __('Enter your email address to retrieve your password.'); ?></p>

<?php echo flash(); ?>

<form method="post" accept-charset="utf-8">
    <div class="form-group">
        <label for="email"><?php echo __('Email'); ?></label>
        <?php echo $this->formText('email', @$_POST['email'], array('class' => 'form-control')); ?>
    </div>

    <input type="submit" class="btn btn-primary" value="<?php echo __('Submit'); ?>">
</form>

<?php echo foot(array(), $footer); ?>
