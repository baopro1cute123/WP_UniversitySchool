<?php 
// header
get_header();
getBanner(array(
  "title" => get_the_archive_title(),
  "subtitle" => get_the_archive_description(),
    'photo'=> get_theme_file_uri("/images/ocean.jpg")

));

?>
<!-- Layout body -->

<div class="container container--narrow page-section">
    <?php
           while(have_posts()) {
            the_post();
            //Hiển thị thông tin bài viết

            get_template_part("template-part/content", "event");

            ?>
    <!-- <div class="event-summary">
        <a class="event-summary__date t-center" href="#">
            <?php
                        $eventsDate = new DateTime(get_field('events_date'))  ;
                        // echo get_field('events_date')

                    ?>
            <span class="event-summary__month"><?php echo $eventsDate->format('M') ?></span>
            <span class="event-summary__day"><?php echo $eventsDate->format('d') ?></span>
        </a>
        <div class="event-summary__content">
            <h5 class="event-summary__title headline headline--tiny"><a
                    href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
            <p><?php echo wp_trim_words(get_the_content(), 18);  ?><a href="<?php the_permalink(); ?>"
                    class="nu gray">Learn more</a></p>
        </div>
    </div> -->

    <?php
           }

           echo paginate_links();
          
      ?>

    <div class="metabox metabox--position-up metabox--with-home-link">
        <p><a class="metabox__blog-home-link" href="<?php echo site_url('/past-events'); ?>"><i class="fa fa-home"
                    aria-hidden="true"></i>
                Go to past Events</a> <span class="metabox__main"><?php the_archive_title(); ?></span></p>
    </div>
</div>





<?php 
// footer
get_footer();




?>