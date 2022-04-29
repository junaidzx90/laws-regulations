<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://example.com/laws-regulations
 * @since      1.0.0
 *
 * @package    Laws_Regulations
 * @subpackage Laws_Regulations/public/partials
 */
?>
<?php
$args = array(
    'post_type' => 'laws-regulation',
    'post_status' => 'publish',
    'numberposts' => -1
);

$ministries = array();
$years = array();
$posts = get_posts($args);
if($posts){
    foreach($posts as $docPost){
        $categories = get_the_terms($docPost->ID, 'ministries');
        if($categories){
            foreach($categories as $category){
                $term = array(
                    'term_id' => $category->term_id,
                    'term_name' => ucfirst($category->name)
                );
                $ministries[$category->term_id] = $term;
            }
        }

        $lr_date = get_post_meta($docPost->ID, 'lr_year', true);
        $lr_date = date("j F, Y", strtotime($lr_date));
        $lr_file = get_post_meta($docPost->ID, 'lr_document_file', true);
        $post_title = get_the_title( $docPost->ID );

        if($lr_date && $lr_file && $post_title){
            $year = explode(', ', $lr_date)[1];
            $years[$year] = array(
                'year' => $year,
                'value' => get_post_meta($docPost->ID, 'lr_year', true)
            );
        }
        
    }
}
asort($years);
$term_name = array_column($ministries, 'term_name');
array_multisort($term_name, SORT_ASC, $ministries);

?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div id="laws_regulations">
    <div id="lr_container" v-bind:class="isDisabled === true ? 'lrdisabled' : '' ">
        <div class="lr_ministries">
            <h3 class="heading_ttl">Ministry</h3>

            <div @click="mobileMinistrySelector()" class="select_ministry">
                <span class="lr_ministry_selected">{{currentSelected}}</span>
                <span class="lr-right-arrow"></span>
            </div>

            <div class="ministrySelectBox">
                <div class="innerMinistry">
                    <div class="selecttitle"><h3>Select a Ministry</h3></div>
                    <ul>
                        <?php
                        if(sizeof($ministries) > 0){
                            echo '<li class="lractive m-all" @click="filterDocuments(\'ministry\', \'all\', event)">All</li>';
                            foreach($ministries as $ministry){
                                echo '<li @click="filterDocuments(\'ministry\', '.$ministry['term_id'].', event)">'.$ministry['term_name'].'</li>';
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="lr_contents" id="lr_contents">
            <div class="lr_years">
                <h3 class="heading_ttl">Year</h3>
                <div class="years_btns">
                    <?php
                    if(sizeof($years) > 0){
                        echo '<span @click="filterDocuments(\'year\', \'all\', event)" class="lrbtn lractive y-all">All</span>';
                        foreach($years as $year1){
                            echo '<span @click="filterDocuments(\'year\', \''.$year1['year'].'\', event)" class="lrbtn year">'.$year1['year'].'</span>';
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="lr_docs_wrap">
                <h3 class="heading_ttl">Documents</h3>

                <div class="searchField">
                    <div class="searchBar">
                        <span @click="searchLrDocument('search')" class="lr_searchBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 1000 1000" width="18px" height="18px"  fill="#3f4095" enable-background="new 0 0 1000 1000" xml:space="preserve">
                        <metadata> Svg Vector Icons : http://www.onlinewebfonts.com/icon </metadata>
                        <g><g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"><path d="M4051.1,5009.7c-1328.8-114.9-2500.5-808-3235.8-1910.8C-314.4,1404.4-86.5-860.7,1361-2312c1202.4-1206.2,3021.3-1583.4,4600.9-953.5c208.7,84.2,467.2,210.6,626.1,310.2l105.3,65.1l861.6-853.9c920.9-915.2,951.6-940.1,1206.2-1007.1c654.8-170.4,1280.9,453.8,1110.5,1106.7c-61.3,235.5-82.3,260.4-997.5,1187.1l-867.4,878.8l74.7,122.5c174.2,283.4,342.7,670.1,440.4,1010.9c382.9,1338.4,93.8,2760.9-785,3869.5c-792.7,999.5-2094.6,1614.1-3377.5,1594.9C4231,5017.3,4093.2,5013.5,4051.1,5009.7z M4702.1,3778.6c534.2-59.4,959.2-214.4,1407.3-513.1c241.2-160.8,593.5-494,746.7-708.4c298.7-417.4,478.7-842.5,564.8-1334.5c47.9-271.9,44-733.3-5.8-1024.3c-147.4-823.3-624.2-1556.6-1317.3-2020c-1407.3-940.1-3312.4-561-4250.6,842.4c-700.8,1051.1-695,2368.4,13.4,3436.8c162.7,245.1,557.2,639.5,802.2,802.2C3285.2,3673.2,4005.1,3855.1,4702.1,3778.6z"/></g></g>
                        </svg>
                        </span>
                        <input v-on:keyup.enter="searchLrDocument('search')" v-model="searchTerms" type="search" placeholder="Search using a keyword" id="lr_searchInp">
                        <span v-if="isSearchhResults" @click="searchLrDocument('clear')" class="clearSearch">
                            <svg height="14px" id="Layer_1" fill="#929292" style="enable-background:new 0 0 512 512;" version="1.1" viewBox="0 0 512 512" width="14px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M437.5,386.6L306.9,256l130.6-130.6c14.1-14.1,14.1-36.8,0-50.9c-14.1-14.1-36.8-14.1-50.9,0L256,205.1L125.4,74.5  c-14.1-14.1-36.8-14.1-50.9,0c-14.1,14.1-14.1,36.8,0,50.9L205.1,256L74.5,386.6c-14.1,14.1-14.1,36.8,0,50.9  c14.1,14.1,36.8,14.1,50.9,0L256,306.9l130.6,130.6c14.1,14.1,36.8,14.1,50.9,0C451.5,423.4,451.5,400.6,437.5,386.6z"/></svg>
                        </span>
                    </div>
                </div>

                <div class="lr_documents">
                    
                    <div v-for="(document, index) in documents" :key="index" class="lr_document">
                        <div class="document_placehholder">
                            <img v-bind:src="document.thumbnail" alt="thumbnail">
                        </div>
                        <div class="lr_doc_info">
                            <h3 class="lr_title" v-html="document.title"></h3>
                            <p class="lr_date">{{document.date}}</p>
                        </div>
                        <div class="lr_downloads">
                            <button @click="downloadFile(document.file, document.id, event)" class="lr_download">Download</button>
                            <p v-if="document.downloads > 1 || document.downloads < 1" class="lr_download_counts">{{nFormatter(document.downloads, 1)}} Downloads</p>
                            <p v-if="document.downloads == 1" class="lr_download_counts">{{document.downloads}} Download</p>
                        </div>
                    </div>

                    <div class="no-docs" v-if="documents.length == 0">No documents are found.</div>
                </div>

                <div v-if="max_pages > currentpage" class="loadmore-wrap">
                    <span @click="loadmoreDocs()" class="lr-loademorebtn">Load More</span>
                </div>
            </div>
        </div>
    </div>
    <div v-if="isDisabled" id="lr-loader-loading">
        <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="50px" height="50px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">
            <path opacity="0.2" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946
            s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634
            c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"></path>
            <path fill="<?php echo ((get_option('lr_selected_color')) ? get_option('lr_selected_color') : '#00bcd4') ?>" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0
            C22.32,8.481,24.301,9.057,26.013,10.047z">
            <animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 20 20" to="360 20 20" dur="0.9s" repeatCount="indefinite"></animateTransform>
            </path>
        </svg>
    </div>
</div>