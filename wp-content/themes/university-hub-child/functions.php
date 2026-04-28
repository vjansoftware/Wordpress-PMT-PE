<?php
function university_hub_child_enqueue() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'university_hub_child_enqueue');

function pmt_theme_styles() {

    // =========================
    // GLOBAL STYLE
    // =========================
    wp_enqueue_style(
        'theme-style',
        get_stylesheet_uri(),
        array(),
        '1.0'
    );

    // =========================
    // HOME PAGE (ID: 1693)
    // =========================
    if (is_front_page() || is_page(1693)) {
    wp_enqueue_style(
        'home',
        get_stylesheet_directory_uri() . '/css_files/home.css',
        array('theme-style'),
        '1.0'
    );
}

    // =========================
    // PAGE ID BASED STYLES
    // =========================
    $page_styles = array(

        1977 => ['examcell.css', 'principalsmessage.css'],

        1008 => 'ourcollege.css',
        866  => 'visionmission.css',
        870  => 'principalsmessage.css',
        388  => 'placements.css',
        876  => 'affiliationapproval.css',
        125  => 'courses.css',
        888  => 'syllabus.css',
        891  => 'academiccalendar.css',
        206  => 'admissionprocess.css',
        900  => 'eligibilitycriteria.css',
        903  => 'applyonline.css',
        386  => 'feestructure.css',
        1444 => 'scholarship.css',

        945  => 'outdoorsports.css',
        948  => 'indoorsports.css',
        951  => 'coachingprograms.css',
        954  => 'achievements.css',
        4451 => 'intramural.css',
        4447 => 'extramural.css',
        1164 => 'playground.css',
        967  => 'hostel.css',
        3382 => 'multigym.css',
        3389 => 'yogahall.css',
        3386 => 'indoorstadium.css',
        5230 => 'library.css',
        3464 => 'laboratory.css',
        973  => 'medicalfacility.css',

        1982 => 'studentgrievance.css',
        1993 => 'antiragging.css',
        3125 => 'womenhelpdesk.css',
        3128 => 'studenthelpdesk.css',

        982  => 'teachingstaff.css',
        979  => 'nonteachingstaff.css',

        1022 => 'photos.css',
        1025 => 'videos.css',
        3755 => 'careers.css',
        121  => 'contactus.css'

    );

    foreach ($page_styles as $page_id => $files) {

    if (is_page($page_id)) {

        // convert single file to array
        if (!is_array($files)) {
            $files = array($files);
        }

        foreach ($files as $file) {

            wp_enqueue_style(
                'page-' . $page_id . '-' . $file,
                get_stylesheet_directory_uri() . '/css_files/' . $file,
                array('theme-style'),
                '1.0'
            );

        }
    }
}

    // =========================
    // CLUB PAGES
    // =========================
    $club_pages = array(3392, 3398, 3405, 3413, 3417);

   if (is_page($club_pages)) {

    wp_enqueue_style(
        'clubs-common',
        get_stylesheet_directory_uri() . '/css_files/club.css',
        array('theme-style'),
        '1.0'
    );

}
} 
add_action('wp_enqueue_scripts', 'pmt_theme_styles');

function add_club_body_class($classes) {
    $club_pages = array(3392, 3398, 3405, 3413, 3417);

    if (is_page($club_pages)) {
        $classes[] = 'pmt-clubs';
    }

    return $classes;
}
add_filter('body_class', 'add_club_body_class');

/* ════════════════════════════════
   PMT NEWS TABLE SHORTCODE
════════════════════════════════ */

fufunction pmt_latest_news_shortcode() {

    ob_start();

    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 5,
        'paged' => $paged
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) :

        echo '<div class="pmt-latest-news-shortcut-wrapper">';

        $count = 0;

        while ($query->have_posts()) : $query->the_post();
            $count++;

            echo '<div class="pmt-latest-news-shortcut-card">';

            // Date
            echo '<div class="pmt-latest-news-shortcut-date">';
            echo '<span class="pmt-latest-news-shortcut-day">' . get_the_date('d') . '</span>';
            echo '<span class="pmt-latest-news-shortcut-month">' . get_the_date('M Y') . '</span>';
            echo '</div>';

            // Content
            echo '<div class="pmt-latest-news-shortcut-content">';
            echo '<a href="' . get_permalink() . '" class="pmt-latest-news-shortcut-title">' . get_the_title() . '</a>';

            if ($paged == 1 && $count == 1) {
                echo '<span class="pmt-latest-news-shortcut-badge">NEW</span>';
            }

            echo '</div>';

            echo '</div>';

        endwhile;

        // Pagination
        echo '<div class="pmt-latest-news-shortcut-pagination">';
        echo paginate_links(array(
            'total' => $query->max_num_pages,
            'prev_text' => '← Prev',
            'next_text' => 'Next →'
        ));
        echo '</div>';

        echo '</div>';

        wp_reset_postdata();

    endif;

    return ob_get_clean();
}

add_shortcode('pmt_latest_news', 'pmt_latest_news_shortcode');

