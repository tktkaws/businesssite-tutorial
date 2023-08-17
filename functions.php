<?php
function my_enqueue_scripts()
{
	$uri = esc_url(get_template_directory_uri());
	wp_enqueue_script('jquery');
	wp_enqueue_script('bundle_js', $uri . '/assets/js/bundle.js', array());
	wp_enqueue_style('my_styles', $uri . '/assets/css/styles.css', array());
}
add_action('wp_enqueue_scripts', 'my_enqueue_scripts');

// ヘッダー、フッターのカスタムメニュー化
register_nav_menus(array(
	'place_global' => ' グローバル',
	'place_footer' => ' フッターナビ',
));

// メイン画像上にテンプレートごとの文字列を表示
function get_main_title()
{
	if (is_singular('post')) :
		$category_obj = get_the_category();
		return $category_obj[0]->name;
	elseif (is_page()) :
		return get_the_title();
	elseif (is_category()) :
		return single_cat_title();
	endif;
}

// 子ページを取得する関数
function get_child_pages($number = -1, $specified_id = null)
{
	if (isset($specified_id)) :
		$parent_id = $specified_id;
	else :
		$parent_id = get_the_ID();
	endif;
	$args = array(
		'posts_per_page' => $number,
		'post_type' => 'page',
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'post_parent' => $parent_id,
	);
	$child_pages = new WP_Query($args);
	return $child_pages;
}
