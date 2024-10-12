<?php
require get_theme_file_path('/inc/rest-api.php');
require get_theme_file_path('/inc/rest-like.php');


// Thêm field vào rest api của Wordpress// thêm trường authorName vào api của bài viết post và page
function registerField(){
    register_rest_field( 'post', 'authorName', array(
        'get_callback' => function () {return get_author_name();},
    ) );
    //Bài tập cho custom rest api => post type = page
    register_rest_field( 'page', 'authorName', array(
        'get_callback' => function () {return get_author_name();},
    ) );
}
add_action( 'rest_api_init', 'registerField' );



//THêm css/js vào wp
function load_assets() {
    // Enqueue Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i', [], null);

    // Enqueue Font Awesome
    wp_enqueue_style('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', [], '4.7.0', 'all');

    // Enqueue custom styles
    wp_enqueue_style('custom-style', get_template_directory_uri() . '/build/index.css', [], null, 'all');
    wp_enqueue_style('custom-style-index', get_template_directory_uri() . '/build/style-index.css', [], null, 'all');

    wp_enqueue_script('university_scripts', get_theme_file_uri() . '/build/index.js', array('jquery'), '1.02', true) ;
    
    wp_localize_script( 'university_scripts', 'universityData', array(
        'root_url' => get_site_url(),
        'nonce' => wp_create_nonce('wp_rest'),
    ) );
}
add_action('wp_enqueue_scripts', 'load_assets');

// thêm menu vào wp -> footer

function add_menu() {
    // Đăng ký nhiều vị trí menu cùng lúc
    register_nav_menus(
        array(
            'themeLocationOne' => __( 'Theme Footer One' ),
            'themeLocationTwo' => __( 'Theme Footer Two' ),
            'themeLocationThree' => __( 'Theme Header Menu' ),

        )
    );

}
add_action( 'init', 'add_menu' );

//giới hạn ký tự của hàm excerpt
function wp_docs_custom_excerpt_length( $length ) {
	return 25;
}
add_filter( 'excerpt_length', 'wp_docs_custom_excerpt_length' );

//tạo mới một main query

//đại diện cho đối tượng WP_Query mà WordPress sử dụng để lấy bài viết từ cơ sở dữ liệu

function university_create_query($query) {
      if(!is_admin() AND is_post_type_archive( 'programme' ) AND $query->is_main_query()) {
        $query->set('orderby','title');
        $query->set('order','ASC');
        $query->set('posts_per_page', -1); //k giới hạng bài viết của programmes
    }
    if(!is_admin() AND is_post_type_archive( 'event' ) AND $query->is_main_query()) {
        $today = date('Ymd');
        $query->set('post_type','event');
        $query->set('posts_per_page', 2);
        $query->set('meta_key','events_date');
        $query->set('orderby','meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query',array(
                array( 
                "key" => 'events_date',
                "compare" => '>=',
                "value" => $today,
                "type" => 'numeric'
                )
        ) );
    }

}
add_action('pre_get_posts','university_create_query');

// xử lý hình ảnh cho professors
add_action( 'after_setup_theme', 'wpdocs_theme_setup' );
function wpdocs_theme_setup() {
	// add_theme_support('post-thumbnails');
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrail', 480, 650, true);
    add_image_size('pageBanner', 1500, 350, true);
    
}

//Khai báo hàm getBanner

function getBanner($nhanthamso = NULL){
    
    if(!isset($nhanthamso['title'])){
        $nhanthamso['title'] = get_the_title();
    }
    if(!isset($nhanthamso['subtitle'])){
        $nhanthamso['subtitle'] = get_field('page_banner_subtitle');
    }
    if(!isset($nhanthamso['photo'])){
       if(get_field("page_banner_background_image")) {
        $nhanthamso["photo"] = get_field("page_banner_background_image")['sizes']['pageBanner'];
       } else {
        $nhanthamso["photo"] = get_theme_file_uri( '/images/ocean.jpg' );
       }
    }

    ?>
<div class="page-banner">

    <div class="page-banner__bg-image" style="background-image: url(<?php echo $nhanthamso["photo"]; ?>);">
    </div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php echo $nhanthamso["title"]; ?></h1>
        <div class="page-banner__intro">
            <!-- <p><?php the_field('page_banner_subtittle'); ?></p> -->
            <p><?php echo $nhanthamso["subtitle"]; ?></p>
        </div>
    </div>
</div>

<?php
    
}

// Redirect homepage when guest login
add_action('admin_init','redirectHomePage');

function redirectHomePage() {
    $guests = wp_get_current_user(); //lấy thông tin người dùng hiện tại
    if($guests->roles[0] == 'subscriber') {
        wp_redirect( site_url( '/') );
        exit;
    }
}

//Ẩn thanh topbar
add_action('wp_loaded','noAdminBar');

function noAdminBar() {
    $guests = wp_get_current_user();
    if($guests->roles[0] == 'subscriber') {
        show_admin_bar( false );
    }
}

// Chuyển về trang chủ khi ng dùng click vào biểu tượng Wordpress của form login

add_filter('login_headerurl', 'ChuyenTrangHomePage');

function ChuyenTrangHomePage (){
    return esc_url(site_url('/'));

}

//load css cho trang login
add_action('login_enqueue_scripts','login_loading_assets');

function login_loading_assets () {
    wp_enqueue_style("font","//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i", array(), "1.0", "all");
    wp_enqueue_style( "bootstrapcss", '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(), "1.1", 'all');
    wp_enqueue_style( "maincss", get_theme_file_uri() . '/build/index.css', array(), '1.0.2', 'all' );
    wp_enqueue_style( "mainstylecss", get_theme_file_uri() . '/build/style-index.css', array(), '1.0.3', 'all' );
}

//Thay đổi tiêu đề cho trang login
function my_login_logo_url_title() {
    return get_bloginfo( 'name' );
}
add_filter( 'login_headertext', 'my_login_logo_url_title' );


// Force note posts to be private
add_filter('wp_insert_post_data', 'makeNotePrivate', 10, 2);

function makeNotePrivate($data,$postarr) {
  if ($data['post_type'] == 'note') {
    if(count_user_posts(get_current_user_id(), 'note') >= 4 AND !$postarr['ID']) {
      die("You have reached your note limit.");
    }

    $data['post_content'] = sanitize_textarea_field($data['post_content']);
    $data['post_title'] = sanitize_text_field($data['post_title']);
  }

  if($data['post_type'] == 'note' AND $data['post_status'] != 'trash') {
    $data['post_status'] = "private";
  }
  
  return $data;
}