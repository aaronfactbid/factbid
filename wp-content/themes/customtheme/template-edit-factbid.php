<?php
/**
 * Template Name: Factbid Edit Page
*/
 
    get_header();
?>
    <div class="title-bar">
        <h1>Edit FactBid</h1>
    </div>
    <div class="full-width pale_blue-bg">
        <div class="container">
            <div class="row">
                <article class="col-xs-12 content-area">
                    <form action="/" method="POST" id="factbid-form">
                        
                        <div class="mb-3">
                            <label for="parent" class="form-label">Parent</label>
                            <?php
                                if(isset($_GET['id'])){
                                    $fact = $_GET['id'];
                                    $factbid_data = $wpdb->get_results($wpdb->prepare(
                                        "SELECT * FROM ct_factbid WHERE id_factbid=%s", 
                                        $fact
                                    ));
                                    $factbid_data = $factbid_data[0];
                                    $factbid_post = get_post($factbid_data->post_id);
                                    $user_id = get_current_user_id();
                                    $id_parent = $factbid_data->id_factbid_parent;
                                }
                            ?>
                            <input type="hidden" name="old_post_id" value="<?php echo $factbid_data->post_id; ?>">
                            <select class="form-control" id="parent" aria-describedby="parent">
                                <option value='NULL'>No parent</option>
                                <?php
                                    global $wpdb;
                                    $results = $wpdb->get_results("SELECT id_factbid,title FROM ct_factbid WHERE id_factbid_parent=0");
                                    foreach($results as $result){
                                        $selected_p = "";
                                        if($fact != ""){
                                            if($id_parent == $result->id_factbid){
                                                $selected_p = "selected";
                                            }
                                        }
                                        echo '<option '.$selected_p.' value="'.$result->id_factbid.'">( '.$result->id_factbid . ' ) ' . $result->title.'</option>';
                                        unset($selected_p);
                                    }
                                ?>
                            </select>
                            
                        </div>
                        

                        <div class="mb-3">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-select" aria-label="type" id="type">
                            <?php
                                $type_options = get_option("fact_bid_type", true);
                                if($type_options){
                                    foreach($type_options as $key => $type_option){
                                        $sel1 = "";
                                        if($factbid_data->type == $key){
                                            $sel1 = "selected";
                                        }
                            ?>
                                <option <?php echo $sel1; ?> value="<?php echo $key; ?>"><?php echo $type_option; ?></option>

                            <?php unset($sel1); } } ?>

                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nobid" class="form-label">No Bid?</label>
                            <input <?php if($factbid_data->nobid == 1){echo "checked";} ?> class="form-check-input" type="radio" name="nobid" id="nobid1" value="1">
                            <label class="form-check-label" for="nobid1">
                                Yes
                            </label>
                            <input class="form-check-input" type="radio" name="nobid" id="nobid2" value="0" <?php if($factbid_data->nobid == 0){echo "checked";} ?>>
                            <label class="form-check-label" for="nobid2">
                                No
                            </label>
                        </div>
                        <div class="mb-3">
                            <label for="visibility" class="form-label">Visibility</label>
                            <select class="form-select" aria-label="Visibility" id="visibility">
                                <?php
                                    $visibility_options = get_option("fact_bid_visibility", true);
                                    if($visibility_options){
                                        foreach($visibility_options as $key => $visibility_option){
                                            $sel1 = "";
                                            if($factbid_data->visibility == $key){
                                                $sel1 = "selected";
                                            }
                                ?>
                                <option <?php echo $sel1; ?> value="<?php echo $key; ?>"><?php echo $visibility_option; ?></option>
                                <?php
                                    unset($sel1);
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3 <?php if(!current_user_can('administrator')){ ?>d-none<?php } ?>">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" aria-label="Status" id="status">
                            <?php
                                $status_options = get_option("fact_bid_status", true);
                                if($status_options){
                                    foreach($status_options as $key => $status_option){
                                        $sel1 = "";
                                        if($factbid_data->status == $key){
                                            $sel1 = "selected";
                                        }
                            ?>
                                <option <?php echo $sel1; ?> value="<?php echo $key; ?>"><?php echo $status_option; ?></option>
                            <?php
                                unset($sel1);
                                }
                            }
                            ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="topics" class="form-label">Topics</label>
                            <select class="form-select" aria-label="Topics" id="topics">

                            <?php
                                $topics_options = get_option("fact_bid_topics", true);
                                if($topics_options){
                                    foreach($topics_options as $key => $topics_option){
                                        $sel1 = "";
                                        if($factbid_data->topics == $key){
                                            $sel1 = "selected";
                                        }
                            ?>
                                <option <?php echo $sel1; ?> value="<?php echo $key; ?>"><?php echo $topics_option; ?></option>
                            <?php
                                unset($sel1);
                                }
                            }
                            ?>
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
                                $sel1 = "";
                                if($factbid_data->country == $result->iso){
                                    $sel1 = "selected";
                                }
                                echo '<option '.$sel1.' value="'.$result->iso.'">'.$result->name.'</option>';
                                unset($sel1);
                            }
                        ?>                               
                            </select>
                        </div>
                        <div class="mb-3 <?php if(!current_user_can('administrator')){ ?>d-none<?php } ?>">
                            <label for="priority" class="form-label">Priority</label>
                            <select class="form-select" aria-label="Language" id="priority">
                                <?php
                                    $priority_options = get_option("fact_bid_priority", true);
                                    if($priority_options){
                                        $sel1 = "";
                                        foreach($priority_options as $key => $priority_option){
                                            $ac_key = (int)$key + 1;
                                            if($factbid_data->priority == $ac_key){
                                                $sel1 = "selected";
                                            }
                                ?>
                                    <option <?php echo $sel1; ?> value="<?php echo $ac_key; ?>"><?php echo $priority_option; ?></option>
                                <?php
                                    unset($sel1);
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" aria-describedby="titleHelp" value="<?php echo $factbid_post->post_title; ?>">
                            <div id="titleHelp" class="form-text">Title of the FactBid.</div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <?php
                                $content   =  $factbid_post->post_content;
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
                            $accept_claim = get_post_meta($factbid_data->post_id, "acceptable_claim", true);
                            $content   = $accept_claim;
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
                            $if_claim = get_post_meta($factbid_data->post_id, "if_claimed", true);

                            $content   = $if_claim;
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
                            $if_unclaim = get_post_meta($factbid_data->post_id, "if_unclaimed", true);
                            $content   = $if_unclaim;
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
                      
                            $image_id = get_post_thumbnail_id($factbid_data->post_id);
                       
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
                    <button type="submit" data-user="<?php echo $user_id; ?>" class="btn btn-primary" id="edit_factbid">Save Draft</button>
                    <p><small><em>When you are ready to go live, click POST at the top.</em></small><p>
                </form>
            </article>
            
        </div>
    </div>
<?php

    get_footer();
?>