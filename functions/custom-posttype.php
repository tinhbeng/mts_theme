<?php
/*
* Custom Posttype BaoHiem
*/
add_action( 'init', 'bh_custom_posttype' );
/**
 * Register a book post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function bh_custom_posttype() {
	$labels = array(
		'name'               => _x( 'Bảo Hiểm', 'post type general name', 'best' ),
		'singular_name'      => _x( 'Bảo Hiểm', 'post type singular name', 'best' ),
		'menu_name'          => _x( 'Bảo Hiểm', 'admin menu', 'best' ),
		'name_admin_bar'     => _x( 'Bảo Hiểm', 'add new on admin bar', 'best' ),
		'add_new'            => _x( 'Thêm mới', 'book', 'best' ),
		'add_new_item'       => __( 'Thêm mới Bảo Hiểm', 'best' ),
		'new_item'           => __( 'Bảo hiểm mới', 'best' ),
		'edit_item'          => __( 'Sửa', 'best' ),
		'view_item'          => __( 'Xem', 'best' ),
		'all_items'          => __( 'Tất cả', 'best' ),
		'search_items'       => __( 'Tìm', 'best' ),
		'parent_item_colon'  => __( 'Parent Books:', 'best' ),
		'not_found'          => __( 'Không tìm thấy.', 'best' ),
		'not_found_in_trash' => __( 'Không tìm thấy trong Trash.', 'best' )
	);

	$args = array(
		'labels'             => $labels,
        'description'        => __( 'Mô tả.', 'best' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'baohiem' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	);

	register_post_type( 'baohiem', $args );

	// Register a taxonomy for Project Categories.
    $category_labels = array(
        'name'                          => esc_html__( 'Phân loại bảo hiểm', 'best' ) ,
        'singular_name'                 => esc_html__( 'Phân loại bảo hiểm', 'best' ) ,
        'menu_name'                     => esc_html__( 'Phân loại bảo hiểm', 'best' ) ,
        'all_items'                     => esc_html__( 'Tất cả', 'best' ) ,
        'edit_item'                     => esc_html__( 'Sửa', 'best' ) ,
        'view_item'                     => esc_html__( 'Xem', 'best' ) ,
        'update_item'                   => esc_html__( 'Cập nhật', 'best' ) ,
        'add_new_item'                  => esc_html__( 'Thêm mới', 'best' ) ,
        'new_item_name'                 => esc_html__( 'Thêm mới', 'best' ) ,
        'parent_item'                   => esc_html__( 'Parent phân loại', 'best' ) ,
        'parent_item_colon'             => esc_html__( 'Parent phân loại:', 'best' ) ,
        'search_items'                  => esc_html__( 'Tìm', 'best' ) ,
        'popular_items'                 => esc_html__( 'Popular', 'best' ) ,
        'separate_items_with_commas'    => esc_html__( 'Separate', 'best' ) ,
        'add_or_remove_items'           => esc_html__( 'Add or remove', 'best') ,
        'choose_from_most_used'         => esc_html__( 'Choose', 'best' ) ,
        'not_found'                     => esc_html__( 'Không tìm thấy', 'best' ) ,
    );

    $category_args = array(
        'labels'            => $category_labels,
        'public'            => true,
        'show_ui'           => true,
        'show_in_nav_menus' => false,
        'show_tagcloud'     => false,
        'show_admin_column' => false,
        'hierarchical'      => true,
        'query_var'         => true,
        'rewrite'           => array(
            'slug'          => 'bh_category',
            'with_front'    => false
        ) ,
    );

    register_taxonomy('bh_category','baohiem', $category_args);
}