<div class="container-fluid d-none" id="collapse-div">
  <button type="button" class="btn btn-collp-btn" data-bs-toggle="collapse" data-bs-target="#myCollapse">
  <img alt="Menu Icon" src="<?php echo get_stylesheet_directory_uri() .'/assets/images/menu.svg'; ?>">
  </button>
</div>
<div class="collapse show" id="myCollapse">
  <div class="container-fluid option-bar">
      <div class="option-cols">
        <span class="lable">Status:</span> 
        <span>
          <select class="filter_select" id="status_filter">
            <option value="">SELECT</option>
            <option value="0">Unclaimed</option>
            <option value="1">Claimed</option>
          </select>
        </span>
      </div>

      <div class="option-cols">
      <span class="lable">Topics:</span> 
        <span>
          <select class="filter_select" id="topic_filter">
            <option value="">SELECT</option>
            <option value="1">Covid</option>
            <option value="2">Politics</option>
            <option value="3">Religion</option>
          </select>
        </span>
      </div>


      <div class="option-cols">
      <span class="lable">Author:</span> 
        <span>
          <select class="filter_select" id="author_filter">
            <option value="">SELECT</option>
            <?php
              $users = get_users( array(
              'role__in'     => array('administrator', 'subscriber', 'author'),
              ) );
            
            foreach($users as $user){
              echo '<option value="'.$user->ID.'">'.$user->display_name.'</option>';
            }
            ?>
          </select>
        </span>
      </div>

      <div class="option-cols">
      <span class="lable">Sort:</span> 
        <span>
          <select class="filter_select" id="sort_filter">
            <option value="">SELECT</option>
            <option value="commented">Most Commented</option>
            <option value="viewed">Most Viewed</option>
            <option value="liked">Most Liked</option>
          </select>
        </span>
      </div>


      <div class="option-cols search-form"  id="search-form">
        <span class="lable">Search:</span> 
        <span>
          <form class="search-form-area" action="#status_filter">
          <input type="text" class="option-bar-search-area" name="search2" id="search2">
          <button type="submit" class="option-bar-search" id="search_go">GO</button>
        </form>
        </span>
      </div>
  </div>
</div>