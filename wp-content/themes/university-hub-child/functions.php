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
        1164 => 'playground.css',
        967  => 'hostel.css',
        3382 => 'multigym.css',
        3389 => 'yogahall.css',
        3386 => 'indoorstadium.css',
        970  => 'library.css',
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

    foreach ($page_styles as $page_id => $file) {

        if (is_page($page_id)) {

            wp_enqueue_style(
                'page-' . $page_id,
                get_stylesheet_directory_uri() . '/css_files/' . $file,
                array('theme-style'),
                '1.0'
            );

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
