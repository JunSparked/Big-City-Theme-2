<?php

// add css and scripts
function chelseah_add_css_scripts() {
	// css
	wp_enqueue_style( 'main', get_template_directory_uri().'/css/main.css');

	// scripts
	wp_enqueue_script( 'bootstrap', get_template_directory_uri().'/js/bootstrap.bundle.min.js', array(), '', true );
	wp_enqueue_script( 'main', get_template_directory_uri().'/js/main.js', array(), '', true );
}
add_action( 'wp_enqueue_scripts', 'chelseah_add_css_scripts' );





/* stuff for the client and defaults for wordpress
-------------------------------------------------------------------*/
include('includes/func_defaults.php');


/* custom post types
-------------------------------------------------------------------*/
include('includes/func_post_types.php');


/* custom functions
-------------------------------------------------------------------*/
//add_theme_support( 'post-thumbnails' );

// add custom logo to login page
function chelseah_login_logo_css() { ?>
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/logo.png);
            height: 170px;
            width: inherit;
            background-size: contain;
        }
        <?php // style login page ?>
/*
        body.login { background: #333; }
        .login #backtoblog a,
        .login #nav a { color: #fff !important; }
*/
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'chelseah_login_logo_css' );


// add custom css or js to admin
function chelseah_custom_admin_css() { ?>
    <style type="text/css">
	    /* limit annoying category spacing description field */
        .edit-tags-php .description.column-description { white-space: nowrap; overflow: auto; }

        /* client help dashboard widget */
        #client_help .inside h2 { font-size: 16px; line-height: inherit; padding: 0 0 10px 0; font-weight: bold; }
        #client_help .inside ul { list-style-type: disc; padding-left: 25px; }
        #client_help .inside ul,
        #client_help .inside ol { margin-bottom: 25px; margin-top: 0; }
        #client_help .inside p,
        #client_help .inside li { font-size: 14px; }
        #client_help .inside a { text-decoration: underline; }
        
        /* gutenburg styles */
        .wp-block { max-width: 1100px; }
    </style>
<?php }
add_action( 'admin_head', 'chelseah_custom_admin_css' );

// add custom css to admin wysiwyg editor
/*
function chelseah_admin_wysiwyg_styles() {
    add_editor_style( 'css/wp.css' );
}
add_action( 'admin_init', 'chelseah_admin_wysiwyg_styles' );
*/
/*
* Creating a function to create our CPT
*/
 
function custom_post_type() {

        $labels = array(
            'name'                => _x( 'News', 'Post Type General Name', 'chelseah' ),
            'singular_name'       => _x( 'New', 'Post Type Singular Name', 'chelseah' ),
            'menu_name'           => __( 'News', 'chelseah' ),
            'parent_item_colon'   => __( 'Parent News', 'chelseah' ),
            'all_items'           => __( 'All News', 'chelseah' ),
            'view_item'           => __( 'View News', 'chelseah' ),
            'add_new_item'        => __( 'Add New News', 'chelseah' ),
            'add_new'             => __( 'Add New', 'chelseah' ),
            'edit_item'           => __( 'Edit News', 'chelseah' ),
            'update_item'         => __( 'Update News', 'chelseah' ),
            'search_items'        => __( 'Search News', 'chelseah' ),
            'not_found'           => __( 'Not Found', 'chelseah' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'chelseah' ),
        );
         
        $args = array(
            'label'               => __( 'news', 'chelseah' ),
            'description'         => __( 'News Artcle', 'chelseah' ),
            'labels'              => $labels,
         
            'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'comments', 'revisions', 'custom-fields','page-attributes', 'thumbnail', 'post-formats', ),
         
            'taxonomies'          => array( 'genres','post_tag','category', ),
          
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'post',
            'show_in_rest' => true,
     
        );
         
        register_post_type( 'news', $args );
        add_theme_support( 'post-thumbnails', array( 'post', 'news' ) );
    }
     
    add_action( 'init', 'custom_post_type', 0 );