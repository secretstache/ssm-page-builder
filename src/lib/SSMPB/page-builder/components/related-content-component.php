<?php

$c_classes = 'related';

$related_content_ids = get_sub_field('related_content');

$args['post_type'] = array('post', 'page');
$args['post__in'] = $related_content_ids;
$args['orderby'] = 'post__in';
$args['status'] = 'publish';

$post_query = new WP_Query($args);

?>

<?php if ( $post_query->have_posts() ) { ?>

    <div<?php echo SSMPB\component_id_classes( $c_classes ); ?>>

        <?php while ( $post_query->have_posts() ) { ?>
            <?php $post_query->the_post(); ?>

            <h2 class="entry-title">
                <a href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                </a>
            </h2>

        <?php } ?>

    </div>

    <?php wp_reset_postdata(); ?>

<?php } ?>