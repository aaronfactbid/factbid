<?php
/**
 * Template Name: Factbid create Page
*/
 
    get_header();
    if(is_user_logged_in()){
        $user_id = get_current_user_id();
    }
?>
    <div class="title-bar">
        <h1>Create FactBid</h1>
    </div>
    <div class="full-width pale_blue-bg">
        <div class="container">
            <div class="row">
                <article class="col-xs-12 content-area">
                    <form action="/" method="POST" id="factbid-form">
                        <div class="mb-3">
                            <label for="parent" class="form-label">Parent</label>
                            <?php
                                if(isset($_GET['parent'])){
                                    $parent_fact = $_GET['parent'];
                                } else {
                                    $parent_fact = "";
                                }
                                $parent_fact =trim($parent_fact);
                                if($parent_fact != ""){
                                    $disabled = "disabled";
                                } else {
                                    $disabled = "";
                                }
                            ?>
                            <SELECT <?php echo $disabled; ?> class="form-control" id="parent" aria-describedby="parent">
                                <option value='NULL'>No parent</option>
                                <?php
                                    global $wpdb;
                                    $results = $wpdb->get_results("SELECT id_factbid,title FROM ct_factbid WHERE id_factbid_parent=0");
                                    foreach($results as $result){
                                        $selected_p = "";
                                        if($parent_fact != ""){
                                            if($parent_fact == $result->id_factbid){
                                                $selected_p = "selected";
                                            }
                                        }
                                        echo '<option '.$selected_p.' value="'.$result->id_factbid.'">( '.$result->id_factbid . ' ) ' . $result->title.'</option>';
                                        unset($selected_p);
                                    }
                                ?>
                            </SELECT>
                            
                        </div>
                        
                        

                        <div class="mb-3">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-select" aria-label="type" id="type">
                                <option selected>Select</option>
                                <option value="1">Query</option>
                                <option value="2">Theory</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nobid" class="form-label">No Bid?</label>
                            <input class="form-check-input" type="radio" name="nobid" id="nobid1" value="1">
                            <label class="form-check-label" for="nobid1">
                                Yes
                            </label>
                            <input class="form-check-input" type="radio" name="nobid" id="nobid2" value="0" checked>
                            <label class="form-check-label" for="nobid2">
                                No
                            </label>
                        </div>
                        <div class="mb-3">
                            <label for="visibility" class="form-label">Visibility</label>
                            <select class="form-select" aria-label="Visibility" id="visibility">
                                <option selected>Select</option>
                                <option value="1">Show Profile</option>
                                <option value="2">Claimants</option>
                                <option value="3">Anonymous</option>
                            </select>
                        </div>
                        <div class="mb-3 <?php if(!current_user_can('administrator')){ ?>d-none<?php } ?>">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" aria-label="Status" id="status">
                                <option>Select</option>
                                <option selected value="1">Creating</option>
                                <option value="2">Pending</option>
                                <option value="3">Spam</option>
                                <option value="4">Offensive</option>
                                <option value="5">Completed</option>
                                <option value="6">Inactive</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="topics" class="form-label">Topics</label>
                            <select class="form-select" aria-label="Topics" id="topics">
                                <option selected>Select</option>
                                <option value="1">Covid</option>
                                <option value="2">Politics</option>
                                <option value="3">Religion</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="country" class="form-label">Country</label>
                            <select class="form-select" aria-label="Country" id="country">
                                <option selected>Select</option>
                        <?php
                            global $wpdb;
                            $results = $wpdb->get_results("SELECT iso,name FROM ct_countries");
                            foreach($results as $result){
                                echo '<option value="'.$result->iso.'" '.selected($result->iso,"US").'>'.$result->name.'</option>';
                            }
                        ?>                               
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="language" class="form-label">Language</label>
                            <?php
                                $languages = get_option("languages", true);
                            ?>
                            <select class="form-select" aria-label="Language" id="language">
                                <?php
                                    if($languages){
                                        foreach($languages as $key => $language){
                                            $lan = $language['name'];
                                            echo '<option value="'.$key.'"'.selected($key,"en").'>'.$lan.'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3 <?php if(!current_user_can('administrator')){ ?>d-none<?php } ?>">
                            <label for="priority" class="form-label">Priority</label>
                            <select class="form-select" aria-label="Language" id="priority">
                                <option>Select</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option selected value="3">3</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" aria-describedby="titleHelp">
                            <div id="titleHelp" class="form-text">Title of the FactBid.</div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <?php
                                $content   = '';
                                $editor_id = 'description';
                                $settings  = array( 
                                    'media_buttons' => true, 
                                    'textarea_name'=> 'description',
                                    'textarea_rows' => 5

                                ); 
                                wp_editor($content, $editor_id, $settings); 
                            ?>
                        </div>
                        <div class="mb-3">
                            <label for="q3" class="form-label">What is an acceptable claim?</label>
                            <?php
                                $content   = '';
                                $editor_id = 'acceptable_claim';
                                $settings  = array( 
                                    'media_buttons' => true, 
                                    'textarea_name'=> 'acceptable_claim',
                                    'textarea_rows' => 5

                                ); 
                                wp_editor($content, $editor_id, $settings); 
                            ?>
                        </div>
                        <div class="mb-3">
                            <label for="q1" class="form-label">What will it prove if claimed?</label>
                            <?php
                                $content   = '';
                                $editor_id = 'if_claimed';
                                $settings  = array( 
                                    'media_buttons' => true, 
                                    'textarea_name'=> 'if_claimed',
                                    'textarea_rows' => 5

                                ); 
                                wp_editor($content, $editor_id, $settings); 
                            ?>
                        </div>
                        <div class="mb-3">
                            <label for="q2" class="form-label">What will it prove if unclaimed?</label>
                            <?php
                                $content   = '';
                                $editor_id = 'if_unclaimed';
                                $settings  = array( 
                                    'media_buttons' => true, 
                                    'textarea_name'=> 'if_unclaimed',
                                    'textarea_rows' => 5

                                ); 
                                wp_editor($content, $editor_id, $settings); 
                            ?>
                        </div>
                        
                        <div class="mb-3">

                            <?php
                            if( isset($image_id) && $image = wp_get_attachment_image_src( $image_id ) ) {
                                echo '<a href="#" class="factbid-upl"><img src="' . $image[0] . '" /></a>
                                <a href="#" class="factbid-rmv">Remove image</a>
                                <input type="hidden" name="factbid-img" value="' . $image_id . '">';
                                } else {
                                echo '<a href="#" class="factbid-upl">Upload image</a>
                                <a href="#" class="factbid-rmv" style="display:none">Remove image</a>
                                <input type="hidden" name="factbid-img" id="factbid-img" value="">';
                            } 
                            ?>
                        </div>
                    <button type="submit" data-user="<?php echo $user_id; ?>" class="btn btn-primary" id="create_factbid">Save Draft</button>
                    <p><small><em>When you are ready to go live, click POST at the top.</em></small><p>
                </form>
            </article>
            
        </div>
    </div>
<?php

    get_footer();
?>