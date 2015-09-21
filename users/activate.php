<?php
$pageTitle = __('User Activation');
echo head(array('title' => $pageTitle), $header);
?>

<h1><?php echo $pageTitle; ?></h1>

<p><?php echo html_escape(__('Hello %s, your username is: %s', $user->name , $user->username)); ?></p>

<?php echo flash(); ?>

<form method="post">
    <div class="form-group">
        <?php echo $this->formLabel('new_password1', __('Create a Password')); ?>
        <input type="password" name="new_password1" id="new_password1" class="form-control">
    </div>
    <div class="form-group">
        <?php echo $this->formLabel('new_password2', __('Re-type the Password')); ?>
        <input type="password" name="new_password2" id="new_password2" class="form-control">
    </div>
    <input type="submit" class="btn btn-primary" name="submit" value="<?php echo __('Activate'); ?>">
</form>

<?php echo foot(array(), $footer); ?>
