<?php
    /**
     * Template Name: List Users
     */


    get_header();
?>
<?php if (have_posts()):
        while(have_posts()):
            the_post();
?>
    <div class="title-bar">
        <h1>Approve Users</h1>
    </div>
    <div class="container">
        <div class="row">
            <article class="col-xs-12 content-area">
                <?php the_content(); ?>

                <table class="table table-success table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">User ID</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <th scope="col">Request</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    
                        <?php
                            global $wpdb;
                            $pending_users = $wpdb->get_results($wpdb->prepare("SELECT id_user, post_request FROM ct_profile WHERE post_status=%s", "Pending"));
                            if(!empty($pending_users)){
                                $i = 0;
                                foreach($pending_users as $pending_user){
                                    $i++;
                                    $user = get_user_by("ID", $pending_user->id_user);
                                    $fullname = "";
                                    if($user){
                                        $fname = $user->first_name;
                                        $lname = $user->last_name;
                                        $fullname = $fname . " " . $lname;
                                    }
                                    if($fullname == ""){
                                        $fullname = $user->display_name;
                                    }
                                    if($fullname == ""){
                                        $fullname = $user->user_login;
                                    }

                                    $post_request = $pending_user->post_request;
                                    $username = $user->user_login;
                                    $email = $user->user_email;

                                ?>
                                <tr>
                                    <th scope="row"><?php echo $i; ?></th>
                                    <td><?php echo $pending_user->id_user; ?></td>
                                    <td><?php echo $fullname; ?></td>
                                    <td><?php echo $username; ?></td>
                                    <td><?php echo $email; ?></td>
                                    <td><?php echo $post_request; ?></td>
                                    <td><a id="approve_request_button" data-id="<?php echo $pending_user->id_user; ?>" class="btn btn-primary btnclass approve_request_button" href="">Approve</a></td>
                                </tr>
                                <?php
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </article>
            
        </div>
    </div>
<?php
    endwhile;
endif;
?>
<?php

    get_footer();
?>