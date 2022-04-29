<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://example.com/laws-regulations
 * @since      1.0.0
 *
 * @package    Laws_Regulations
 * @subpackage Laws_Regulations/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Laws_Regulations
 * @subpackage Laws_Regulations/admin
 * @author     Unknown <admin@easeare.com>
 */
class Laws_Regulations_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Laws_Regulations_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Laws_Regulations_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/laws-regulations-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Laws_Regulations_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Laws_Regulations_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( 'wp-color-picker');
		wp_enqueue_script( 'wp-color-picker');
		wp_enqueue_script( 'pdfjs', plugin_dir_url( __FILE__ ) . 'js/pdf.js', array(  ), $this->version, false );
		wp_enqueue_script( 'pdf.warker', plugin_dir_url( __FILE__ ) . 'js/pdf.warker.js', array( 'pdfjs' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/laws-regulations-admin.js', array( 'jquery', 'pdf.warker' ), $this->version, true );

	}

	function laws_regulations_post_type(){
		$labels = array(
			'name'                  => __( 'Laws & Regulations', 'laws-regulations' ),
			'singular_name'         => __( 'Laws & Regulation', 'laws-regulations' ),
			'menu_name'             => __( 'CFA L&R', 'laws-regulations' ),
			'name_admin_bar'        => __( 'CFA L&R', 'laws-regulations' ),
			'add_new'               => __( 'New Document', 'laws-regulations' ),
			'add_new_item'          => __( 'New Document', 'laws-regulations' ),
			'new_item'              => __( 'New Document', 'laws-regulations' ),
			'edit_item'             => __( 'Edit Document', 'laws-regulations' ),
			'view_item'             => __( 'View Document', 'laws-regulations' ),
			'all_items'             => __( 'Documents', 'laws-regulations' ),
			'search_items'          => __( 'Search Documents', 'laws-regulations' ),
			'parent_item_colon'     => __( 'Parent Documents:', 'laws-regulations' ),
			'not_found'             => __( 'No Documents found.', 'laws-regulations' ),
			'not_found_in_trash'    => __( 'No Documents found in Trash.', 'laws-regulations' )
		);
		$args = array(
			'labels'             => $labels,
			'description'        => 'Documents custom post type.',
			'public'             => true,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'laws-regulation' ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => 45,
			'menu_icon'      	 => 'dashicons-book',
			'supports'           => array( 'title', 'thumbnail' ),
			'show_in_rest'       => false
		);
		  
		register_post_type( 'laws-regulation', $args );
	}

	function lr_categories(){
		$labels = array(
			'name'              => _x( 'Ministry', 'taxonomy general name', 'laws-regulations' ),
			'singular_name'     => _x( 'Ministry', 'taxonomy singular name', 'laws-regulations' ),
			'search_items'      => __( 'Search Ministry', 'laws-regulations' ),
			'all_items'         => __( 'All Ministries', 'laws-regulations' ),
			'parent_item'       => __( 'Parent Ministry', 'laws-regulations' ),
			'parent_item_colon' => __( 'Parent Ministry:', 'laws-regulations' ),
			'edit_item'         => __( 'Edit Ministry', 'laws-regulations' ),
			'update_item'       => __( 'Update Ministry', 'laws-regulations' ),
			'add_new_item'      => __( 'Add New Ministry', 'laws-regulations' ),
			'new_item_name'     => __( 'New Ministry Name', 'laws-regulations' ),
			'menu_name'         => __( 'Ministries', 'laws-regulations' ),
		);
	 
		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'ministries' ),
		);
	 
		register_taxonomy( 'ministries', array( 'laws-regulation' ), $args );
	}
	
	// Manage table columns
	function manage_laws_regulation_columns($columns) {
		unset(
			$columns['subscribe-reloaded'],
			$columns['title'],
			$columns['taxonomy-ministries'],
			$columns['date']
		);
	
		$new_columns = array(
			'title' => __('Title', 'laws-regulations'),
			'lrdownloads' => __('Downloads', 'laws-regulations'),
			'lr_ministry' => __('Ministry', 'laws-regulations'),
			'lr_year' => __('Date/Year', 'laws-regulations'),
			'date' => __('Create Date', 'laws-regulations'),
		);
	
		return array_merge($columns, $new_columns);
	}

	function manage_laws_regulation_sortable_columns($columns){
		return $columns;
	}

	// View custom column data
	function manage_laws_regulation_columns_views($column_id, $post_id){
		switch ($column_id) {
			case 'lr_year':
				$year = get_post_meta($post_id, 'lr_year', true);
				echo $year;
				break;
			case 'lrdownloads':
				$downloads = get_post_meta($post_id, 'lr_document_downloads', true);
				echo (($downloads)?lr_thousandsShortFormat($downloads): 0);
				break;
			case 'lr_ministry':
				$ministries = get_the_terms($post_id, 'ministries');
				if(is_array($ministries) && sizeof($ministries) > 0){
					$ministriesList = [];
					foreach($ministries as $ministry){
						$ministriesList[ $ministry->term_id ] = $ministry->name;
					}
					echo implode(', ', $ministriesList);
				}
				break;
		}
	}

	function __return_empty_array($months, $post_type){
		$months=[];
		return $months;
	}

	function add_year_filter_to_admin_area($post_type){
		if('laws-regulation' !== $post_type){
			return; //check to make sure this is your cpt
		}
		
		?>
		<select name="lr_year_filter" id="lr_year_filter">
			<option value="all">Show all years</option>
			<?php
			$args = array(
				'post_type' => 'laws-regulation',
				'post_status' => 'publish',
				'numberposts' => -1
			);
			
			$months = array();
			$posts = get_posts($args);

			$yearsList = [];
			if($posts){
				foreach($posts as $docPost){
					$lr_date = get_post_meta($docPost->ID, 'lr_year', true);
					$lr_date = date("j F, Y", strtotime($lr_date));
					$lr_file = get_post_meta($docPost->ID, 'lr_document_file', true);
					$post_title = get_the_title( $docPost->ID );

					if($lr_date && $lr_file && $post_title){
						$year = explode(', ', $lr_date)[1];
						$yearsList[$year] = $year;
					}
				}
			}
			arsort($yearsList);
			if(sizeof($yearsList) > 0){
				foreach($yearsList as $yeard){
					$selected = ((isset($_REQUEST['lr_year_filter'])) ? $_REQUEST['lr_year_filter'] : '');
					echo '<option '.(($selected === $yeard) ? 'selected' : '').' value="'.$yeard.'">'.$yeard.'</option>';
				}
			}
			?>
		</select>
		<?php
	}

	function add_ministry_filter_to_admin_area($post_type){
		if('laws-regulation' !== $post_type){
			return; //check to make sure this is your cpt
		}
		$taxonomy_slug = 'ministries';
		$taxonomy = get_taxonomy($taxonomy_slug);
		$selected = '';
		$request_attr = 'ministry_filter'; //this will show up in the url
		if ( isset($_REQUEST[$request_attr] ) ) {
			$selected = $_REQUEST[$request_attr]; //in case the current page is already filtered
		}
		wp_dropdown_categories(array(
			'show_option_all' =>  __("Show All ministries"),
			'taxonomy'        =>  $taxonomy_slug,
			'name'            =>  $request_attr,
			'orderby'         =>  'name',
			'selected'        =>  $selected,
			'hierarchical'    =>  false,
			'depth'           =>  0,
			'show_count'      =>  false, // Show number of post in parent term
			'hide_empty'      =>  false, // Don't show posts w/o terms
		));
	}
	
	function laws_regulation_filter( $query ) {
		//modify the query only if it is admin and main query.
		if( !(is_admin() AND $query->is_main_query()) ){ 
			return $query;
		}
		//we want to modify the query for the targeted custom post.
		if( 'laws-regulation' !== $query->query['post_type'] ){
			return $query;
		}
		//type filter
		if( isset($_REQUEST['ministry_filter']) &&  0 != $_REQUEST['ministry_filter']){
			$term =  $_REQUEST['ministry_filter'];
			$taxonomy_slug = 'ministries';
			$query->query_vars['tax_query'] = array(
				array(
					'taxonomy'  => $taxonomy_slug,
					'field'     => 'ID',
					'terms'     => array($term)
				)
			);
		}

		if(isset($_REQUEST['lr_year_filter']) && $_REQUEST['lr_year_filter'] !== 'all'){
			$year = $_REQUEST['lr_year_filter'];
			if(!empty($year)){
				$query->query_vars['meta_query'] = array(
					array(
						'key' => 'lr_year',
						'value' => $year,
						'compare' => 'LIKE'
					)
				);
			}
		}


		return $query;
	}
	
	// Remove Quick edit
	function remove_quick_edit_laws_regulation( $actions, $post ) {
		if(get_post_type( $post ) === 'laws-regulation'){
			unset($actions['inline hide-if-no-js']);
			return $actions;
		}else{
			return $actions;
		}
	}

	//   Remove edit option from bulk
	function remove_laws_regulation_edit_actions( $actions ){
		unset( $actions['edit'] );
		return $actions;
	}

	// Add meta boxespostcustom
	function laws_regulation_meta_boxes(){
		global $wp_meta_boxes;
		unset($wp_meta_boxes['laws-regulation']);

		add_meta_box( 'submitdiv', "Publish", 'post_submit_meta_box', 'laws-regulation', 'side' );
		add_meta_box( 'ministriesdiv', "Ministry", 'post_categories_meta_box', 'laws-regulation', 'side', '', array(
			'taxonomy' => 'ministries'
			) );
			
		add_meta_box( 'lr_year', "Date/Year", [$this, 'fn_lr_year'], 'laws-regulation', 'side' );
		add_meta_box( 'lr_document', 'Upload Document', [$this, 'fn_document_meta'], 'laws-regulation', 'advanced' );
		add_meta_box( 'lr_document_url', 'Document URL', [$this, 'fn_document_url_meta'], 'laws-regulation', 'advanced' );
		add_meta_box( 'postimagediv', "Featured image", 'post_thumbnail_meta_box', 'laws-regulation', 'side' );
	}

	function fn_lr_year($post){
		$year = get_post_meta($post->ID, 'lr_year', true);
		echo '<input type="date" required class="widefat" name="lr_year" id="lr_year" value="'.$year.'">';
	}

	function fn_document_meta($post){
		wp_enqueue_media(  );
		?>
		<div id="lr_document">
			<div class="lr_filearea">
				<div class="file-input">
					<span class="lr_document_btn" for="lr_document">
						<svg
						aria-hidden="true"
						focusable="false"
						data-prefix="fas"
						data-icon="upload"
						class="svg-inline--fa fa-upload fa-w-16"
						role="img"
						xmlns="http://www.w3.org/2000/svg"
						viewBox="0 0 512 512"
						>
						<path
							fill="currentColor"
							d="M296 384h-80c-13.3 0-24-10.7-24-24V192h-87.7c-17.8 0-26.7-21.5-14.1-34.1L242.3 5.7c7.5-7.5 19.8-7.5 27.3 0l152.2 152.2c12.6 12.6 3.7 34.1-14.1 34.1H320v168c0 13.3-10.7 24-24 24zm216-8v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h136v8c0 30.9 25.1 56 56 56h80c30.9 0 56-25.1 56-56v-8h136c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z"
						></path>
						</svg>
						<span>Upload file</span>
					</span>
				</div>
			</div>

			<div class="lr_file_previews">
				<img src="" id="lr_pdf_view">
			</div>
		</div>
		<?php
	}

	function fn_document_url_meta($post){
		$lr_document_file = get_post_meta($post->ID, 'lr_document_file', true);
		echo '<input class="widefat" type="url" value="'.$lr_document_file.'" placeholder="File URL" id="lr_document_file" name="lr_document_file">';
	}

	function laws_regulation_save_post($post_id){
		if(isset($_POST['lr_year'])){
			$lr_year = $_POST['lr_year'];
			update_post_meta( $post_id, 'lr_year', $lr_year );
		}
		if(isset($_POST['lr_document_file'])){
			$lr_document_file = $_POST['lr_document_file'];
			update_post_meta( $post_id, 'lr_document_file', $lr_document_file );
		}
	}

	function laws_regulation_admin_menu(){
		add_submenu_page( 'edit.php?post_type=laws-regulation', 'Settings', 'Settings', 'manage_options', 'lr-settings', [$this, 'fn_laws_regulation_settings'] );
		add_settings_section( 'laws_regulation_opt_section', '', '', 'laws_regulation_opt_page' );
		// Shortcode
		add_settings_field( 'lr_sortcode', 'Shortcode', [$this, 'lr_sortcode_cb'], 'laws_regulation_opt_page','laws_regulation_opt_section' );
		register_setting( 'laws_regulation_opt_section', 'lr_sortcode' );
		// Documents per page
		add_settings_field( 'lr_docs_perpage', 'Documents per page', [$this, 'lr_docs_perpage_cb'], 'laws_regulation_opt_page','laws_regulation_opt_section' );
		register_setting( 'laws_regulation_opt_section', 'lr_docs_perpage' );
		// Static Color
		add_settings_field( 'lr_static_color', 'Static Color', [$this, 'lr_static_color_cb'], 'laws_regulation_opt_page','laws_regulation_opt_section' );
		register_setting( 'laws_regulation_opt_section', 'lr_static_color' );
		// Selected Color
		add_settings_field( 'lr_selected_color', 'Selected Color', [$this, 'lr_selected_color_cb'], 'laws_regulation_opt_page','laws_regulation_opt_section' );
		register_setting( 'laws_regulation_opt_section', 'lr_selected_color' );
		// Fallback thumbnail
		add_settings_field( 'lr_fallback_thumb', 'Fallback thumbnail', [$this, 'lr_fallback_thumb_cb'], 'laws_regulation_opt_page','laws_regulation_opt_section' );
		register_setting( 'laws_regulation_opt_section', 'lr_fallback_thumb' );
		// Section heading text color
		add_settings_field( 'lr_section_heading_text_color', 'Section heading text color', [$this, 'lr_section_heading_text_color_cb'], 'laws_regulation_opt_page','laws_regulation_opt_section' );
		register_setting( 'laws_regulation_opt_section', 'lr_section_heading_text_color' );
		// Section heading font size
		add_settings_field( 'lr_section_heading_font_size', 'Section heading font size', [$this, 'lr_section_heading_font_size_cb'], 'laws_regulation_opt_page','laws_regulation_opt_section' );
		register_setting( 'laws_regulation_opt_section', 'lr_section_heading_font_size' );
		// Ministry items padding
		add_settings_field( 'lr_ministry_items_padding', 'Ministry items padding', [$this, 'lr_ministry_items_padding_cb'], 'laws_regulation_opt_page','laws_regulation_opt_section' );
		register_setting( 'laws_regulation_opt_section', 'lr_ministry_items_padding' );
		// Ministry items padding on mobile
		add_settings_field( 'lr_ministry_items_padding_mobile', 'Ministry items padding (mobile/tablet)', [$this, 'lr_ministry_items_padding_mobile_cb'], 'laws_regulation_opt_page','laws_regulation_opt_section' );
		register_setting( 'laws_regulation_opt_section', 'lr_ministry_items_padding_mobile' );
		// Ministry items margin
		add_settings_field( 'lr_ministry_items_margin', 'Ministry items margin', [$this, 'lr_ministry_items_margin_cb'], 'laws_regulation_opt_page','laws_regulation_opt_section' );
		register_setting( 'laws_regulation_opt_section', 'lr_ministry_items_margin' );
		// Ministry items font_size
		add_settings_field( 'lr_ministry_items_font_size', 'Ministry items font size', [$this, 'lr_ministry_items_font_size_cb'], 'laws_regulation_opt_page','laws_regulation_opt_section' );
		register_setting( 'laws_regulation_opt_section', 'lr_ministry_items_font_size' );
		// Year items paddings
		add_settings_field( 'lr_year_items_paddings', 'Year items padding', [$this, 'lr_year_items_paddings_cb'], 'laws_regulation_opt_page','laws_regulation_opt_section' );
		register_setting( 'laws_regulation_opt_section', 'lr_year_items_paddings' );
		// Year items font size
		add_settings_field( 'lr_year_items_font_size', 'Year items font size', [$this, 'lr_year_items_font_size_cb'], 'laws_regulation_opt_page','laws_regulation_opt_section' );
		register_setting( 'laws_regulation_opt_section', 'lr_year_items_font_size' );
		// Document title color
		add_settings_field( 'lr_doc_title_color', 'Document title color', [$this, 'lr_doc_title_color_cb'], 'laws_regulation_opt_page','laws_regulation_opt_section' );
		register_setting( 'laws_regulation_opt_section', 'lr_doc_title_color' );
		// Document title font_size
		add_settings_field( 'lr_doc_title_font_size', 'Document title font size', [$this, 'lr_doc_title_font_size_cb'], 'laws_regulation_opt_page','laws_regulation_opt_section' );
		register_setting( 'laws_regulation_opt_section', 'lr_doc_title_font_size' );
		// Document title font_size mobile
		add_settings_field( 'lr_doc_title_font_size_mbl', 'Document title font size (mobile/tablet)', [$this, 'lr_doc_title_font_size_mbl_cb'], 'laws_regulation_opt_page','laws_regulation_opt_section' );
		register_setting( 'laws_regulation_opt_section', 'lr_doc_title_font_size_mbl' );
		// Document title font weight
		add_settings_field( 'lr_doc_title_font_weight', 'Document title font-weight', [$this, 'lr_doc_title_font_weight_cb'], 'laws_regulation_opt_page','laws_regulation_opt_section' );
		register_setting( 'laws_regulation_opt_section', 'lr_doc_title_font_weight' );
		// Document date color
		add_settings_field( 'lr_doc_date_color', 'Document date color', [$this, 'lr_doc_date_color_cb'], 'laws_regulation_opt_page','laws_regulation_opt_section' );
		register_setting( 'laws_regulation_opt_section', 'lr_doc_date_color' );
		// Document date font-weight
		add_settings_field( 'lr_doc_date_font_weight', 'Document date font-weight', [$this, 'lr_doc_date_font_weight_cb'], 'laws_regulation_opt_page','laws_regulation_opt_section' );
		register_setting( 'laws_regulation_opt_section', 'lr_doc_date_font_weight' );
		// Document date uppercase
		add_settings_field( 'lr_doc_date_uppercase', 'Document date uppercase', [$this, 'lr_doc_date_uppercase_cb'], 'laws_regulation_opt_page','laws_regulation_opt_section' );
		register_setting( 'laws_regulation_opt_section', 'lr_doc_date_uppercase' );
		// Download button font size
		add_settings_field( 'lr_download_btn_font_size', 'Download button font size', [$this, 'lr_download_btn_font_size_cb'], 'laws_regulation_opt_page','laws_regulation_opt_section' );
		register_setting( 'laws_regulation_opt_section', 'lr_download_btn_font_size' );
		// Download button paddings
		add_settings_field( 'lr_download_btn_paddings', 'Download button padding', [$this, 'lr_download_btn_paddings_cb'], 'laws_regulation_opt_page','laws_regulation_opt_section' );
		register_setting( 'laws_regulation_opt_section', 'lr_download_btn_paddings' );
		// Download button radius
		add_settings_field( 'lr_download_btn_radius', 'Download button radius', [$this, 'lr_download_btn_radius_cb'], 'laws_regulation_opt_page','laws_regulation_opt_section' );
		register_setting( 'laws_regulation_opt_section', 'lr_download_btn_radius' );
		// Download counter font size
		add_settings_field( 'lr_download_counter_font_size', 'Download counter font size', [$this, 'lr_download_counter_font_size_cb'], 'laws_regulation_opt_page','laws_regulation_opt_section' );
		register_setting( 'laws_regulation_opt_section', 'lr_download_counter_font_size' );
		// Download counter font color
		add_settings_field( 'lr_download_counter_font_color', 'Download counter font color', [$this, 'lr_download_counter_font_color_cb'], 'laws_regulation_opt_page','laws_regulation_opt_section' );
		register_setting( 'laws_regulation_opt_section', 'lr_download_counter_font_color' );
		// Load More button font size
		add_settings_field( 'lr_loadmore_btn_font_size', 'Load More button font size', [$this, 'lr_loadmore_btn_font_size_cb'], 'laws_regulation_opt_page','laws_regulation_opt_section' );
		register_setting( 'laws_regulation_opt_section', 'lr_loadmore_btn_font_size' );
		// Loadmore button paddings
		add_settings_field( 'lr_loadmore_btn_paddings', 'Load More button padding', [$this, 'lr_loadmore_btn_paddings_cb'], 'laws_regulation_opt_page','laws_regulation_opt_section' );
		register_setting( 'laws_regulation_opt_section', 'lr_loadmore_btn_paddings' );
		// Load More button background color
		add_settings_field( 'lr_loadmore_btn_bg_color', 'Load More button background color', [$this, 'lr_loadmore_btn_bg_color_cb'], 'laws_regulation_opt_page','laws_regulation_opt_section' );
		register_setting( 'laws_regulation_opt_section', 'lr_loadmore_btn_bg_color' );
	}

	function lr_sortcode_cb(){
		echo '<input disabled style="text-align:center" type="text" readonly value="[laws_regulations]">';
	}

	function lr_docs_perpage_cb(){
		echo '<input type="number" min="1" oninput="this.value = Math.abs(this.value)" name="lr_docs_perpage" value="'.get_option('lr_docs_perpage').'" placeholder="10">';
	}

	function lr_static_color_cb(){
		echo '<input type="text" name="lr_static_color" id="lr_static_color" data-default-color="#3f51b5" value="'.((get_option('lr_static_color')) ? get_option('lr_static_color') : '#3f51b5').'">';
	}
	function lr_selected_color_cb(){
		echo '<input type="text" name="lr_selected_color" id="lr_selected_color" data-default-color="#00bcd4" value="'.((get_option('lr_selected_color')) ? get_option('lr_selected_color') : '#00bcd4').'">';
	}
	function lr_fallback_thumb_cb(){
		echo '<input type="url" required name="lr_fallback_thumb" placeholder="Image URL" id="lr_fallback_thumb" class="widefat" value="'.get_option('lr_fallback_thumb').'">';
	}
	function lr_section_heading_text_color_cb(){
		echo '<input type="text" data-default-color="#000000" name="lr_section_heading_text_color" id="lr_section_heading_text_color" value="'.((get_option('lr_section_heading_text_color')) ? get_option('lr_section_heading_text_color') : '#000000').'">';
	}
	function lr_section_heading_font_size_cb(){
		echo '<input type="text" placeholder="18px" name="lr_section_heading_font_size" id="lr_section_heading_font_size" value="'.get_option('lr_section_heading_font_size').'">';
	}
	function lr_ministry_items_margin_cb(){
		echo '<input type="text" placeholder="0px 0px 5px" name="lr_ministry_items_margin" id="lr_ministry_items_margin" value="'.get_option('lr_ministry_items_margin').'">';
	}
	function lr_ministry_items_padding_cb(){
		echo '<input type="text" placeholder="5px 18px" name="lr_ministry_items_padding" id="lr_ministry_items_padding" value="'.get_option('lr_ministry_items_padding').'">';
	}
	function lr_ministry_items_padding_mobile_cb(){
		echo '<input type="text" placeholder="12px 20px" name="lr_ministry_items_padding_mobile" id="lr_ministry_items_padding_mobile" value="'.get_option('lr_ministry_items_padding_mobile').'">';
	}
	function lr_ministry_items_font_size_cb(){
		echo '<input type="text" placeholder="16px" name="lr_ministry_items_font_size" id="lr_ministry_items_font_size" value="'.get_option('lr_ministry_items_font_size').'">';
	}
	function lr_year_items_paddings_cb(){
		echo '<input type="text" placeholder="4px 18px" name="lr_year_items_paddings" id="lr_year_items_paddings" value="'.get_option('lr_year_items_paddings').'">';
	}
	function lr_year_items_font_size_cb(){
		echo '<input type="text" placeholder="16px" name="lr_year_items_font_size" id="lr_year_items_font_size" value="'.get_option('lr_year_items_font_size').'">';
	}
	function lr_doc_title_color_cb(){
		echo '<input type="text" data-default-color="#3a3a3a" name="lr_doc_title_color" id="lr_doc_title_color" value="'.((get_option('lr_doc_title_color')) ? get_option('lr_doc_title_color') : '#3a3a3a').'">';
	}
	function lr_doc_title_font_size_cb(){
		echo '<input type="text" placeholder="16px" name="lr_doc_title_font_size" id="lr_doc_title_font_size" value="'.get_option('lr_doc_title_font_size').'">';
	}
	function lr_doc_title_font_size_mbl_cb(){
		echo '<input type="text" placeholder="14px" name="lr_doc_title_font_size_mbl" id="lr_doc_title_font_size_mbl" value="'.get_option('lr_doc_title_font_size_mbl').'">';
	}
	function lr_doc_title_font_weight_cb(){
		echo '<input type="text" placeholder="500" name="lr_doc_title_font_weight" id="lr_doc_title_font_weight" value="'.get_option('lr_doc_title_font_weight').'">';
	}
	function lr_doc_date_color_cb(){
		echo '<input type="text" data-default-color="#e91e63" name="lr_doc_date_color" id="lr_doc_date_color" value="'.((get_option('lr_doc_date_color')) ? get_option('lr_doc_date_color') : '#e91e63').'">';
	}
	function lr_doc_date_font_weight_cb(){
		echo '<input type="text" placeholder="300" name="lr_doc_date_font_weight" id="lr_doc_date_font_weight" value="'.get_option('lr_doc_date_font_weight').'">';
	}
	function lr_doc_date_uppercase_cb(){
		echo '<input type="checkbox" name="lr_doc_date_uppercase" '.((get_option('lr_doc_date_uppercase') === 'on') ? 'checked' : '').' id="lr_doc_date_uppercase">';
	}
	function lr_download_btn_font_size_cb(){
		echo '<input type="text" placeholder="16px" name="lr_download_btn_font_size" id="lr_download_btn_font_size" value="'.get_option('lr_download_btn_font_size').'">';
	}
	function lr_download_btn_paddings_cb(){
		echo '<input type="text" placeholder="3px 15px" name="lr_download_btn_paddings" id="lr_download_btn_paddings" value="'.get_option('lr_download_btn_paddings').'">';
	}
	function lr_download_btn_radius_cb(){
		echo '<input type="text" placeholder="0px" name="lr_download_btn_radius" id="lr_download_btn_radius" value="'.get_option('lr_download_btn_radius').'">';
	}
	function lr_download_counter_font_size_cb(){
		echo '<input type="text" placeholder="12px" name="lr_download_counter_font_size" id="lr_download_counter_font_size" value="'.get_option('lr_download_counter_font_size').'">';
	}
	function lr_download_counter_font_color_cb(){
		echo '<input type="text" data-default-color="#ff0000" name="lr_download_counter_font_color" id="lr_download_counter_font_color" value="'.((get_option('lr_download_counter_font_color')) ? get_option('lr_download_counter_font_color') : '#ff0000').'">';
	}
	function lr_loadmore_btn_font_size_cb(){
		echo '<input type="text" placeholder="16px" name="lr_loadmore_btn_font_size" id="lr_loadmore_btn_font_size" value="'.get_option('lr_loadmore_btn_font_size').'">';
	}
	function lr_loadmore_btn_paddings_cb(){
		echo '<input type="text" placeholder="5px 20px" name="lr_loadmore_btn_paddings" id="lr_loadmore_btn_paddings" value="'.get_option('lr_loadmore_btn_paddings').'">';
	}
	function lr_loadmore_btn_bg_color_cb(){
		echo '<input type="text" data-default-color="#3f51b5" name="lr_loadmore_btn_bg_color" id="lr_loadmore_btn_bg_color" value="'.((get_option('lr_loadmore_btn_bg_color')) ? get_option('lr_loadmore_btn_bg_color') : '#3f51b5').'">';
	}

	function fn_laws_regulation_settings(){
		echo '<h3>Settings</h3>';
		echo '<hr>';

		echo '<form style="width: 75%;" action="options.php" method="post">';
		settings_fields( 'laws_regulation_opt_section' );
		do_settings_sections('laws_regulation_opt_page');
		echo get_submit_button( 'Save Changes', 'secondary', 'save-laws-regulation-setting' );
		echo '</form>';
	}
}
