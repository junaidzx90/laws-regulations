<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://example.com/laws-regulations
 * @since      1.0.0
 *
 * @package    Laws_Regulations
 * @subpackage Laws_Regulations/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Laws_Regulations
 * @subpackage Laws_Regulations/public
 * @author     Unknown <admin@easeare.com>
 */
class Laws_Regulations_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_shortcode( 'laws_regulations', [$this, 'lr_documents_view'] );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/laws-regulations-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( 'vuejs', plugin_dir_url( __FILE__ ) . 'js/vue.min.js', array(  ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/laws-regulations-public.js', array( 'jquery', 'vuejs' ), $this->version, true );
		wp_localize_script( $this->plugin_name, 'lr_ajax', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce( 'lr_nonce' )
		));
	}

	function wp_head_scripts(){
		?>
		<style>
			:root{
				--lr_static: <?php echo ((get_option('lr_static_color')) ? get_option('lr_static_color') : '#3f51b5') ?>;
				--lr_selected: <?php echo ((get_option('lr_selected_color')) ? get_option('lr_selected_color') : '#00bcd4') ?>;
				--lr_section_heading_text_color: <?php echo ((get_option('lr_section_heading_text_color')) ? get_option('lr_section_heading_text_color') : '#000000') ?>;
				--lr_section_heading_font_size: <?php echo ((get_option('lr_section_heading_font_size')) ? get_option('lr_section_heading_font_size') : '18px') ?>;
				--lr_ministry_item_padding: <?php echo ((get_option('lr_ministry_items_padding')) ? get_option('lr_ministry_items_padding') : '5px 18px') ?>;
				--lr_ministry_items_padding_mobile: <?php echo ((get_option('lr_ministry_items_padding_mobile')) ? get_option('lr_ministry_items_padding_mobile') : '12px 20px') ?>;
				--lr_ministry_item_margin: <?php echo ((get_option('lr_ministry_items_margin')) ? get_option('lr_ministry_items_margin') : '0px 0px 5px') ?>;
				--lr_ministry_items_font_size: <?php echo ((get_option('lr_ministry_items_font_size')) ? get_option('lr_ministry_items_font_size') : '16px') ?>;
				--lr_year_items_paddings: <?php echo ((get_option('lr_year_items_paddings')) ? get_option('lr_year_items_paddings') : '4px 18px') ?>;
				--lr_year_items_font_size: <?php echo ((get_option('lr_year_items_font_size')) ? get_option('lr_year_items_font_size') : '16px') ?>;
				--lr_doc_title_color: <?php echo ((get_option('lr_doc_title_color')) ? get_option('lr_doc_title_color') : '#3a3a3a') ?>;
				--lr_doc_title_font_size: <?php echo ((get_option('lr_doc_title_font_size')) ? get_option('lr_doc_title_font_size') : '16px') ?>;
				--lr_doc_title_font_size_mbl: <?php echo ((get_option('lr_doc_title_font_size_mbl')) ? get_option('lr_doc_title_font_size_mbl') : '14px') ?>;
				--lr_doc_title_font_weight: <?php echo ((get_option('lr_doc_title_font_weight')) ? get_option('lr_doc_title_font_weight') : '500') ?>;
				--lr_doc_date_color: <?php echo ((get_option('lr_doc_date_color')) ? get_option('lr_doc_date_color') : '#e91e63') ?>;
				--lr_doc_date_font_weight: <?php echo ((get_option('lr_doc_date_font_weight')) ? get_option('lr_doc_date_font_weight') : '300') ?>;
				--lr_doc_date_uppercase: <?php echo ((get_option('lr_doc_date_uppercase') === 'on') ? 'uppercase' : 'capitalize') ?>;
				--lr_download_btn_font_size: <?php echo ((get_option('lr_download_btn_font_size')) ? get_option('lr_download_btn_font_size') : '16px') ?>;
				--lr_download_btn_paddings: <?php echo ((get_option('lr_download_btn_paddings')) ? get_option('lr_download_btn_paddings') : '3px 15px') ?>;
				--lr_download_btn_radius: <?php echo ((get_option('lr_download_btn_radius')) ? get_option('lr_download_btn_radius') : '0px') ?>;
				--lr_download_counter_font_size: <?php echo ((get_option('lr_download_counter_font_size')) ? get_option('lr_download_counter_font_size') : '12px') ?>;
				--lr_download_counter_font_color: <?php echo ((get_option('lr_download_counter_font_color')) ? get_option('lr_download_counter_font_color') : '#ff0000') ?>;
				--lr_loadmore_btn_font_size: <?php echo ((get_option('lr_loadmore_btn_font_size')) ? get_option('lr_loadmore_btn_font_size') : '16px') ?>;
				--lr_loadmore_btn_paddings: <?php echo ((get_option('lr_loadmore_btn_paddings')) ? get_option('lr_loadmore_btn_paddings') : '5px 20px') ?>;
				--lr_loadmore_btn_bg_color: <?php echo ((get_option('lr_loadmore_btn_bg_color')) ? get_option('lr_loadmore_btn_bg_color') : '#3f51b5') ?>;
			}
		</style>
		<?php
	}

	function lr_documents_view(){
		ob_start();
		require_once plugin_dir_path( __FILE__ ).'partials/laws-regulations-public-display.php';
		$output = ob_get_contents();
		ob_get_clean();
		return $output;
	}

	function lr_title_filter( $where, $wp_query ){
		global $wpdb;
		if ( $search_term = $wp_query->get( 'search_prod_title' ) ) {
			$where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $wpdb->esc_like( $search_term ) ) . '%\'';
		}
		return $where;
	}

	function get_laws_regulations_documents(){
		if(!wp_verify_nonce( $_GET['nonce'], 'lr_nonce' )){
			die("Invalid nonce");
		}

		$page = 1;
		if(isset($_GET['page'])){
			$page = intval($_GET['page']);
		}

		$perpage = ((get_option('lr_docs_perpage')) ? intval(get_option('lr_docs_perpage')) : 10);

		$args = array(
			'post_type' => 'laws-regulation',
			'post_status' => 'publish',
			'posts_per_page' => $perpage,
			'paged' => $page,
    		'meta_key' => 'lr_year',
    		'orderby' => 'meta_value',
			'meta_type' => 'DATE',
			'order' => 'DESC',
		);

		if(isset($_GET['searchTerms'])){
			$search_term = sanitize_text_field( $_GET['searchTerms'] );
			if(!empty($search_term)){
				$args['search_prod_title'] = $search_term;
				add_filter( 'posts_where', [$this, 'lr_title_filter'], 10, 2 );
			}
		}

		if(isset($_GET['ministry']) && $_GET['ministry'] !== 'all'){
			$category_id = intval($_GET['ministry']);
			if(!empty($category_id)){
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'ministries',
						'terms' => $category_id,
						'include_children' => false
					)
				);
			}
		}

		if(isset($_GET['year']) && $_GET['year'] !== 'all'){
			$year = $_GET['year'];
			if(!empty($year)){
				$args['meta_query'] = array(
					array(
						'key' => 'lr_year',
						'value' => $year,
						'compare' => 'LIKE'
					)
				);
			}
		}
		
		$documents = array();

		$documentsObj = new WP_Query( $args );
		remove_filter( 'posts_where', [$this, 'lr_title_filter'] );
		
		if ( $documentsObj->have_posts() ){
			while ( $documentsObj->have_posts() ){
				$documentsObj->the_post();
				$document_id = get_post()->ID;
				$post_title = get_the_title(  );
				$lr_date = get_post_meta($document_id, 'lr_year', true);
				$lr_date = date("j F, Y", strtotime($lr_date));

				$lr_file = get_post_meta($document_id, 'lr_document_file', true);
				
				if($post_title && $lr_date && $lr_file){
					$docData = array(
						'id' => $document_id,
						'title' => sanitize_text_field( $post_title ),
						'file' => $lr_file,
						'thumbnail' => ((get_the_post_thumbnail_url(  )) ? get_the_post_thumbnail_url(  ) : get_option('lr_fallback_thumb') ),
						'date' => $lr_date,
						'downloads' => ((get_post_meta($document_id, 'lr_document_downloads', true)) ? get_post_meta($document_id, 'lr_document_downloads', true) : 0)
					);
	
					$documents[] = $docData;
				}
				
			}
		}

		echo json_encode(array(
			'documents' => $documents,
			'maxpages' => $documentsObj->max_num_pages
		));
		die;
	}

	function download_a_file(){
		if(isset($_POST['id'])){
			$doc_id = intval($_POST['id']);
			if($doc_id){
				$downloads = get_post_meta( $doc_id, 'lr_document_downloads', true );
				$downloads = intval($downloads);
				$downloads += 1;
				if(update_post_meta($doc_id, 'lr_document_downloads', $downloads)){
					echo json_encode(array('success' => get_post_meta( $doc_id, 'lr_document_downloads', true )));
					die;
				}
			}
			die;
		}
	}
}
