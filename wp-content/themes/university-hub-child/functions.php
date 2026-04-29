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
        5755 => 'eoc.css',
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

function pmt_news_table_shortcode() {

    ob_start();

    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 4,
        'paged' => $paged
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) :

        echo '<div class="pmt-latest-news-shortcut-container">';
        echo '<div class="pmt-latest-news-shortcut-scroll">';

        $count = 0;

        while ($query->have_posts()) : $query->the_post();
            $count++;

            echo '<div class="pmt-latest-news-shortcut-card">';

            echo '<div class="pmt-latest-news-shortcut-date">'
                    . get_the_date('d M Y') .
                 '</div>';

            echo '<div class="pmt-latest-news-shortcut-content">';

            echo '<a href="' . get_permalink() . '" class="pmt-latest-news-shortcut-link">'
                    . get_the_title() .
                 '</a>';

            if ($paged == 1 && $count == 1) {
                echo '<span class="pmt-latest-news-shortcut-badge">NEW</span>';
            }

            echo '</div>';
            echo '</div>';

        endwhile;

        echo '</div>'; // scroll
        echo '</div>'; // container

        wp_reset_postdata();

    endif;

    return ob_get_clean();
}

add_shortcode('pmt_news_table', 'pmt_news_table_shortcode');

function pmt_admission_overview_shortcode() {

    ob_start();
    ?>

    <div class="pmt-admission-overview-card">

        <h3>Admissions Open 2026</h3>

        <p>
            Kickstart your career in Physical Education with expert training,
            modern facilities, and professional guidance.
        </p>

        <a href="/admission-open/" class="pmt-admission-overview-btn">
            Learn More →
        </a>

    </div>

    <?php
    return ob_get_clean();
}

add_shortcode('pmt_admission_overview', 'pmt_admission_overview_shortcode');

add_action('wp_footer', 'pmt_news_scroll_script');

function pmt_news_scroll_script() {
?>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const scrollBoxes = document.querySelectorAll(".pmt-latest-news-shortcut-scroll");

    scrollBoxes.forEach(function(scrollBox) {

        if (!scrollBox.classList.contains("duplicated")) {
            scrollBox.innerHTML += scrollBox.innerHTML;
            scrollBox.classList.add("duplicated");
        }

    });

});
</script>
<?php
}
