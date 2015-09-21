<?php
queue_js_file('login');
$pageTitle = __('Log In');
echo head(array('title' => $pageTitle, 'bodyclass' => 'login'), $header);
?>

<h1><?php echo $pageTitle; ?></h1>

<ul class="list-inline">
    <li><?php echo link_to_home_page(__('Go to Home Page')); ?></li>

    <?php if (!$required): ?>
        <li><?php echo link_to('users', 'forgot-password', __('Lost your password?')); ?></li>
    <?php endif; ?>
</ul>

<?php echo flash(); ?>

<?php
foreach (array('username', 'password') as $name) {
    $element = $this->form->getElement($name);

    if ($element) {
        $element->setAttrib('class', 'form-control');
        $element->setDecorators(
            array(
                'ViewHelper',
                'Label',
                array(
                    'HtmlTag',
                    array('tag' => 'div', 'class' => 'form-group')
                )
            )
        );
    }
}

$element = $this->form->getElement('remember');

if ($element) {
    $element->setDecorators(
        array(
            'ViewHelper',
            'Label',
            array(
                'HtmlTag',
                array('tag' => 'div', 'class' => 'form-group')
            )
        )
    );
}

$element = $this->form->getElement('submit');

if ($element) {
    $element->setAttrib('class', 'btn btn-primary');
}

echo $this->form->setAction($this->url('users/login'));
?>

<?php echo foot(array(), $footer); ?>
