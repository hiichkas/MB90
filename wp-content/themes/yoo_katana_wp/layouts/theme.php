<?php
/**
* @package   Katana
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// get theme configuration
include($this['path']->path('layouts:theme.config.php'));

?>
<!DOCTYPE HTML>
<html lang="<?php echo $this['config']->get('language'); ?>" dir="<?php echo $this['config']->get('direction'); ?>"  data-config='<?php echo $this['config']->get('body_config','{}'); ?>'>

<head>
<?php echo $this['template']->render('head'); ?>
</head>

<body class="<?php echo $this['config']->get('body_classes'); ?>">

    <?php if (!$this['config']->get('layout_fullscreen', 0)) : ?>
    <div class="uk-container uk-container-center">
    <?php endif; ?>

        <header <?php echo $sticky_navigation; ?> >

            <?php if ($this['widgets']->count('toolbar-l + toolbar-r')) : ?>
            <div class="tm-toolbar uk-clearfix uk-hidden-small tm-block-dark">

            <?php if ($this['config']->get('layout_fullscreen', 0)) : ?>
            <div class="uk-container uk-container-center">
            <?php endif; ?>

                <?php if ($this['widgets']->count('toolbar-l')) : ?>
                <div class="uk-float-left"><?php echo $this['widgets']->render('toolbar-l'); ?></div>
                <?php endif; ?>

                <?php if ($this['widgets']->count('toolbar-r')) : ?>
                <div class="uk-float-right"><?php echo $this['widgets']->render('toolbar-r'); ?></div>
                <?php endif; ?>

            <?php if ($this['config']->get('layout_fullscreen', 0)) : ?>
            </div>
            <?php endif; ?>

            </div>
            <?php endif; ?>


            <?php if ($this['widgets']->count('logo + menu + search')) : ?>
            <nav class="tm-navbar uk-navbar">

            <?php if ($this['config']->get('layout_fullscreen')) : ?>
            <div class="uk-container uk-container-center">
            <?php endif; ?>

                <?php if ($this['widgets']->count('logo')) : ?>
                <a class="tm-logo uk-hidden-small" href="<?php echo $this['config']->get('site_url'); ?>"><?php echo $this['widgets']->render('logo'); ?></a>
                <?php endif; ?>

                <?php if ($this['widgets']->count('logo-small')) : ?>
                <a class="tm-logo uk-visible-small" href="<?php echo $this['config']->get('site_url'); ?>"><?php echo $this['widgets']->render('logo-small'); ?></a>
                <?php endif; ?>

                <div class="uk-navbar-flip">

                    <?php if ($this['widgets']->count('menu')) : ?>
                    <?php echo $this['widgets']->render('menu'); ?>
                    <?php endif; ?>

                    <?php if ($this['widgets']->count('offcanvas')) : ?>
                    <a href="#offcanvas" class="uk-navbar-toggle uk-visible-small" data-uk-offcanvas></a>
                    <?php endif; ?>

                    <?php if ($this['widgets']->count('search')) : ?>
                    <div id="js-search-toggle" class="uk-navbar-content uk-hidden-small"><a href="#" data-uk-toggle="{target:'.tm-search-bar'}"><i class="uk-icon-search"></i></a></div>
                    <div class="tm-search-bar uk-hidden">
                        <div class="uk-container uk-container-center">
                            <?php echo $this['widgets']->render('search'); ?>
                            <a href="#" class="uk-close uk-float-right" data-uk-toggle="{target:'.tm-search-bar'}"></a>
                        </div>
                    </div>
                    <?php endif; ?>

                </div>

            <?php if ($this['config']->get('layout_fullscreen', 0)) : ?>
            </div>
            <?php endif; ?>

            </nav>
            <?php endif; ?>

        </header>

        <?php if ($this['widgets']->count('top-teaser')) : ?>
            <div class="tm-block<?php echo $block_classes['top-teaser']; ?>">

            <?php if ($this['config']->get('layout_fullscreen', 0)) : ?>
            <div class="uk-container uk-container-center">
            <?php endif; ?>

                <section class="<?php echo $grid_classes['top-teaser']; echo $display_classes['top-teaser']; ?>" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin><?php echo $this['widgets']->render('top-teaser', array('layout'=>$this['config']->get('grid.top-teaser.layout'))); ?></section>

            <?php if ($this['config']->get('layout_fullscreen', 0)) : ?>
            </div>
            <?php endif; ?>

            </div>
        <?php endif; ?>

        <?php if ($this['widgets']->count('top-a')) : ?>
            <div class="tm-block<?php echo $block_classes['top-a']; ?>">

            <?php if ($this['config']->get('layout_fullscreen', 0)) : ?>
            <div class="uk-container uk-container-center">
            <?php endif; ?>

                <section class="<?php echo $grid_classes['top-a']; echo $display_classes['top-a']; ?>" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin><?php echo $this['widgets']->render('top-a', array('layout'=>$this['config']->get('grid.top-a.layout'))); ?></section>

            <?php if ($this['config']->get('layout_fullscreen', 0)) : ?>
            </div>
            <?php endif; ?>

            </div>
        <?php endif; ?>

        <?php if ($this['widgets']->count('top-b')) : ?>
            <div class="tm-block<?php echo $block_classes['top-b']; ?>">

                <?php if ($this['config']->get('layout_fullscreen', 0)) : ?>
                <div class="uk-container uk-container-center">
                <?php endif; ?>

                <section class="<?php echo $grid_classes['top-b']; echo $display_classes['top-b']; ?>" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin><?php echo $this['widgets']->render('top-b', array('layout'=>$this['config']->get('grid.top-b.layout'))); ?></section>

                <?php if ($this['config']->get('layout_fullscreen', 0)) : ?>
                </div>
                <?php endif; ?>

            </div>
        <?php endif; ?>

        <?php if ($this['widgets']->count('top-c')) : ?>
            <div class="tm-block<?php echo $block_classes['top-c']; ?>">

                <?php if ($this['config']->get('layout_fullscreen', 0)) : ?>
                <div class="uk-container uk-container-center">
                <?php endif; ?>

                <section class="<?php echo $grid_classes['top-c']; echo $display_classes['top-c']; ?>" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin><?php echo $this['widgets']->render('top-c', array('layout'=>$this['config']->get('grid.top-c.layout'))); ?></section>

                <?php if ($this['config']->get('layout_fullscreen', 0)) : ?>
                </div>
                <?php endif; ?>

            </div>
        <?php endif; ?>

        <?php if ($this['widgets']->count('main-top + main-bottom + sidebar-a + sidebar-b') || $this['config']->get('system_output', true)) : ?>
        <div class="tm-block<?php echo $block_classes['middle']; ?>">

        <?php if ($this['config']->get('layout_fullscreen', 0)) : ?>
        <div class="uk-container uk-container-center">
        <?php endif; ?>

            <section class="tm-middle uk-grid" data-uk-grid-match data-uk-grid-margin>

                <?php if ($this['widgets']->count('main-top + main-bottom') || $this['config']->get('system_output', true)) : ?>
                <div class="<?php echo $columns['main']['class'] ?>">

                    <?php if ($this['widgets']->count('main-top')) : ?>
                        <div class="<?php echo $grid_classes['main-top']; echo $display_classes['main-top']; ?>" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin><?php echo $this['widgets']->render('main-top', array('layout'=>$this['config']->get('grid.main-top.layout'))); ?></div>
                    <?php endif; ?>

                    <?php if ($this['config']->get('system_output', true)) : ?>
                        <main class="tm-content">
                            <div class="uk-panel uk-panel-blank">
                                <?php if ($this['widgets']->count('breadcrumbs')) : ?>
                                <?php echo $this['widgets']->render('breadcrumbs'); ?>
                                <?php endif; ?>
                                <?php echo $this['template']->render('content'); ?>
                            </div>
                        </main>
                    <?php endif; ?>

                    <?php if ($this['widgets']->count('main-bottom')) : ?>
                        <div class="<?php echo $grid_classes['main-bottom']; echo $display_classes['main-bottom']; ?>" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin><?php echo $this['widgets']->render('main-bottom', array('layout'=>$this['config']->get('grid.main-bottom.layout'))); ?></div>
                    <?php endif; ?>

                </div>
                <?php endif; ?>

                <?php foreach($columns as $name => &$column) : ?>
                <?php if ($name != 'main' && $this['widgets']->count($name)) : ?>
                    <aside class="<?php echo $column['class'] ?>"><?php echo $this['widgets']->render($name) ?></aside>
                <?php endif ?>
                <?php endforeach ?>

            </section>

        <?php if ($this['config']->get('layout_fullscreen', 0)) : ?>
        </div>
        <?php endif; ?>

        </div>
        <?php endif; ?>

        <?php if ($this['widgets']->count('bottom-a')) : ?>
            <div class="tm-block<?php echo $block_classes['bottom-a']; ?>">

                <?php if ($this['config']->get('layout_fullscreen', 0)) : ?>
                <div class="uk-container uk-container-center">
                <?php endif; ?>

                <section class="<?php echo $grid_classes['bottom-a']; echo $display_classes['bottom-a']; ?>" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin><?php echo $this['widgets']->render('bottom-a', array('layout'=>$this['config']->get('grid.bottom-a.layout'))); ?></section>

                <?php if ($this['config']->get('layout_fullscreen', 0)) : ?>
                </div>
                <?php endif; ?>

            </div>
        <?php endif; ?>

        <?php if ($this['widgets']->count('bottom-b')) : ?>
            <div class="tm-block<?php echo $block_classes['bottom-b']; ?>">

                <?php if ($this['config']->get('layout_fullscreen', 0)) : ?>
                <div class="uk-container uk-container-center">
                <?php endif; ?>

                <section class="<?php echo $grid_classes['bottom-b']; echo $display_classes['bottom-b']; ?>" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin><?php echo $this['widgets']->render('bottom-b', array('layout'=>$this['config']->get('grid.bottom-b.layout'))); ?></section>

                <?php if ($this['config']->get('layout_fullscreen', 0)) : ?>
                </div>
                <?php endif; ?>

            </div>
        <?php endif; ?>

        <?php if ($this['widgets']->count('bottom-c')) : ?>
            <div class="tm-block<?php echo $block_classes['bottom-c']; ?>">

                <?php if ($this['config']->get('layout_fullscreen', 0)) : ?>
                <div class="uk-container uk-container-center">
                <?php endif; ?>

                <section class="<?php echo $grid_classes['bottom-c']; echo $display_classes['bottom-c']; ?>" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin><?php echo $this['widgets']->render('bottom-c', array('layout'=>$this['config']->get('grid.bottom-c.layout'))); ?></section>

                <?php if ($this['config']->get('layout_fullscreen', 0)) : ?>
                </div>
                <?php endif; ?>

            </div>
        <?php endif; ?>

        <?php if ($this['widgets']->count('footer-top')) : ?>
            <div class="tm-block<?php echo $block_classes['footer-top']; ?>">

                <?php if ($this['config']->get('layout_fullscreen', 0)) : ?>
                <div class="uk-container uk-container-center">
                <?php endif; ?>

                <section class="<?php echo $grid_classes['footer-top']; echo $display_classes['footer-top']; ?>" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin><?php echo $this['widgets']->render('footer-top', array('layout'=>$this['config']->get('grid.footer-top.layout'))); ?></section>

                <?php if ($this['config']->get('layout_fullscreen', 0)) : ?>
                </div>
                <?php endif; ?>

            </div>
        <?php endif; ?>

        <?php if ($this['widgets']->count('footer + debug') || $this['config']->get('warp_branding', true) || $this['config']->get('totop_scroller', true)) : ?>
            <div class="uk-text-center uk-margin-bottom-large tm-block<?php echo $block_classes['footer']; ?>">

                <?php if ($this['config']->get('layout_fullscreen', 0)) : ?>
                <div class="uk-container uk-container-center">
                <?php endif; ?>

                <section>
                    <footer class="tm-footer">

                        <?php if ($this['config']->get('totop_scroller', true)) : ?>
                        <a class="tm-totop-scroller" data-uk-smooth-scroll href="#"></a>
                        <?php endif; ?>

                        <?php
                            echo $this['widgets']->render('footer');
                            $this->output('warp_branding');
                            echo $this['widgets']->render('debug');
                        ?>

                        <?php echo $this->render('footer'); ?>

                    </footer>
                </section>

                <?php if ($this['config']->get('layout_fullscreen', 0)) : ?>
                </div>
                <?php endif; ?>

            </div>
        <?php endif; ?>



    <?php if (!$this['config']->get('layout_fullscreen', 0)) : ?>
    </div>
    <?php endif; ?>

    <?php if ($this['widgets']->count('offcanvas')) : ?>
    <div id="offcanvas" class="uk-offcanvas">
        <div class="uk-offcanvas-bar uk-offcanvas-bar-flip"><?php echo $this['widgets']->render('offcanvas'); ?></div>
    </div>
    <?php endif; ?>

</body>
</html>