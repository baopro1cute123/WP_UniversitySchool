<?php

get_header();

if (have_posts()) {
    while (have_posts()) {
        the_post();
              getBanner();

        ?>
<!-- <div class="page-banner">
    <div class="page-banner__bg-image"
        style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>);"></div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php the_title(); ?></h1>
    </div>
</div> -->

<div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
        <p><a class="metabox__blog-home-link" href="<?php echo site_url('/programme'); ?>"><i class="fa fa-home"
                    aria-hidden="true"></i> All Programs</a> <span class="metabox__main">
                Posted by <?php the_author_posts_link(); ?> on <?php the_time('n.j.y'); ?>
            </span></p>
    </div>

    <div class="generic-content">
        <?php the_content(); ?>
    </div>

    <?php
        // Custom Query for Events
        $today = date('Ymd');
        $homepageEvents = new WP_Query(array(
            'posts_per_page' => 2,
            'post_type' => 'event',
            'meta_key' => 'events_date',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                    "key" => 'events_date',
                    "compare" => '>=',
                    "value" => $today,
                    "type" => 'numeric'
                ),
                array(
                    "key" => 'related_programs',
                    "compare" => 'LIKE',
                    "value" => '"' . get_the_ID() . '"'
                )
            )
        ));

        if ($homepageEvents->have_posts()) {
            echo '<hr class="section-break" />';
            echo '<h2 class="headline headline--medium">Upcoming events for ' . get_the_title() . '</h2>';

            while ($homepageEvents->have_posts()) {
                $homepageEvents->the_post(); ?>
    <div class="event-summary">
        <a class="event-summary__date t-center" href="#">
            <?php
                $eventsDate = new DateTime(get_field('events_date')); ?>
            <span class="event-summary__month"><?php echo $eventsDate->format('M'); ?></span>
            <span class="event-summary__day"><?php echo $eventsDate->format('d'); ?></span>
        </a>
        <div class="event-summary__content">
            <h5 class="event-summary__title headline headline--tiny"><a
                    href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
            <p><?php echo wp_trim_words(get_the_content(), 18); ?><a href="<?php the_permalink(); ?>"
                    class="nu gray">Learn more</a></p>
        </div>
    </div>
    <?php
            }
        }

        wp_reset_postdata(); // Reset after Events loop

        // Custom Query for Professors
        $professorProgram = new WP_Query(array(
            'posts_per_page' => 2,
            'post_type' => 'professor',
            'orderby' => 'title',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                    "key" => 'related_programs',
                    "compare" => 'LIKE',
                    "value" => '"' . get_the_ID() . '"'
                )
            )
        ));

        if ($professorProgram->have_posts()) {
            echo '<hr class="section-break" />';
            echo '<h2 class="headline headline--medium">Professors for ' . get_the_title() . '</h2>';
            echo '<ul class="professor-cards">';
            while ($professorProgram->have_posts()) {
                $professorProgram->the_post(); ?>
    <li class="professor-card__list-item">
        <a class="professor-card" href="<?php the_permalink(); ?>">
            <img class="professor-card__image" src="<?php the_post_thumbnail_url('professorLandscape'); ?>" alt="">
            <span class="professor-card__name"><?php the_title(); ?></span>
        </a>
    </li>
    <?php
            }
            echo '</ul>';
        }

        wp_reset_postdata(); // Reset after Professors loop
        ?>
</div>
<?php
    }
}

get_footer();