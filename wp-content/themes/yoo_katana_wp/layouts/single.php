 <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>

    <article class="uk-article" data-permalink="<?php the_permalink(); ?>">

        <?php if (has_post_thumbnail()) : ?>
            <?php
            $image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
            $width = get_option('thumbnail_size_w'); //get the width of the thumbnail setting
            $height = get_option('thumbnail_size_h'); //get the height of the thumbnail setting
            ?>
            <div class="tm-blog-image-single-view" style="background:url(<?php echo $image; ?>);"></div>
        <?php endif; ?>

        <div class="uk-container uk-container-center uk-margin-large">

            <p class="uk-article-meta uk-text-small">
                <?php
                    $date = '<time datetime="'.get_the_date('Y-m-d').'">'.get_the_date().'</time>';
                    printf(__('Written by %s on %s. Posted in %s', 'warp'), '<a href="'.get_author_posts_url(get_the_author_meta('ID')).'" title="'.get_the_author().'">'.get_the_author().'</a>', $date, get_the_category_list(', '));
                ?>
            </p>

            <h1 class="uk-article-title"><?php the_title(); ?></h1>

            <?php the_content(''); ?>

            <?php wp_link_pages(); ?>

            <?php the_tags('<p>'.__('Tags: ', 'warp'), ', ', '</p>'); ?>

            <?php edit_post_link(__('Edit this post.', 'warp'), '<p><i class="uk-icon-pencil"></i> ','</p>'); ?>

            <?php if (pings_open()) : ?>
            <p><?php printf(__('<a href="%s">Trackback</a> from your site.', 'warp'), get_trackback_url()); ?></p>
            <?php endif; ?>

            <?php if (get_the_author_meta('description')) : ?>
            <div class="uk-panel uk-panel-box">

                <div class="uk-align-medium-left">

                    <?php echo get_avatar(get_the_author_meta('user_email')); ?>

                </div>

                <h2 class="uk-h3 uk-margin-top-remove"><?php the_author(); ?></h2>

                <div class="uk-margin"><?php the_author_meta('description'); ?></div>

            </div>
            <?php endif; ?>

            <?php comments_template(); ?>

        </div>

    </article>

    <?php endwhile; ?>
 <?php endif; ?>