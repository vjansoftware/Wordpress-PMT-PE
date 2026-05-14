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
        2223 => 'examtimetable.css',
        2229 => 'examsyllabus.css',
        2235 => 'annualreports.css',
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
        1444 => 'scholarships.css',

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

    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => -1, // all posts
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC'
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) :

        // 👉 Get latest post month/year
        $query->the_post();
        $latest_month = get_the_date('m');
        $latest_year  = get_the_date('Y');

        $query->rewind_posts();

        echo '<div class="pmt-latest-news-shortcut-container">';

        // HEADER (fixed)
        echo '<div class="pmt-latest-news-shortcut-header">Campus News & Announcements</div>';

        // BODY (scroll area)
        echo '<div class="pmt-latest-news-shortcut-body">';
        echo '<div class="pmt-latest-news-shortcut-scroll">';

        while ($query->have_posts()) : $query->the_post();

            $post_month = get_the_date('m');
            $post_year  = get_the_date('Y');

            echo '<div class="pmt-latest-news-shortcut-card">';

            echo '<div class="pmt-latest-news-shortcut-date">'
                    . get_the_date('d M Y') .
                 '</div>';

            echo '<div class="pmt-latest-news-shortcut-content">';

            echo '<a href="' . get_permalink() . '" class="pmt-latest-news-shortcut-link">'
                    . get_the_title() .
                 '</a>';

            // NEW badge logic (latest batch)
            if ($post_month == $latest_month && $post_year == $latest_year) {
                echo '<span class="pmt-latest-news-shortcut-badge">NEW</span>';
            }

            echo '</div>';
            echo '</div>';

        endwhile;

        echo '</div>'; // scroll
        echo '</div>'; // body
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

        <p class="third-priority-page-color">
            Kickstart your career in Physical Education with expert training,
            modern facilities, and professional guidance.
        </p>
        <p class="third-priority-page-color">
           Shape your future in Physical Education through world-class training, modern infrastructure, and experienced faculty guidance.
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
// =========================
// WPFORMS - SAME FORM (6210), DIFFERENT EMAIL PER PAGE
// =========================
add_filter( 'wpforms_entry_email_atts', function( $atts, $fields, $entry, $form_data, $notification_id ) {

    // Only target form ID 6210
    if ( (int) $form_data['id'] !== 6210 ) {
        return $atts;
    }

    $page_id = get_the_ID();

    // EOC Page (ID: 5755)
    if ( $page_id === 5755 ) {
        $atts['address'] = array( 'bsanand2897@gmail.com' );
        $atts['subject'] = 'EOC Form Entry';
    }

    // Student Grievance Page (ID: 1982)
    if ( $page_id === 1982 ) {
        $atts['address'] = array( 'subiswarna@gmail.com' );
        $atts['subject'] = 'Student Grievance Form Entry';
    }

    return $atts;

}, 10, 5 );

function pmt_enqueue_careers_assets() {

    if (is_page('careers')) {

        wp_enqueue_script(
            'pmt-careers-js',
            get_stylesheet_directory_uri() . '/js/pmt-careers.js',
            array(),
            '1.0',
            true
        );

    }
}

add_action('wp_enqueue_scripts', 'pmt_enqueue_careers_assets');

function pmt_lab_page_dequeue() {
  if ( is_page( 3464 ) ) {
    wp_dequeue_style( 'dashicons' );
    wp_dequeue_style( 'tmm_style' );
    wp_dequeue_style( 'tablepress-combined' );
    wp_dequeue_script( 'owl-carousel' );
    wp_dequeue_script( 'jquery-migrate' );
  }
}
add_action( 'wp_enqueue_scripts', 'pmt_lab_page_dequeue', 100 );

// =========================
// GOOGLE FONTS — FAST LOAD
// =========================
function pmt_fix_google_fonts() {
  echo '<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css?family=Montserrat:100&display=swap" rel="stylesheet">';
}
add_action( 'wp_head', 'pmt_fix_google_fonts', 1 );
