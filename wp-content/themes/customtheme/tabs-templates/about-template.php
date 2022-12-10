<?php
    $postId =  get_the_ID();
?>
<div class="content-area">
	<table>
	<tr>
		<td bgcolor="gainsboro">
			<div class="sub-cnt">
				<?php
					 $acceptable_claim = get_post_meta($postId, "acceptable_claim", true);
					 if($acceptable_claim){
				?>
				<h5 class="contents-heading">What is an acceptable claim:</h5>
				<?php
				   
					echo apply_filters('the_content', $acceptable_claim);
				}
				?>
			</div>
		</td>
	</tr>
	<tr>
	<td bgcolor="silver">
		<div class="sub-cnt">
			<?php
				 $social_media = get_post_meta($postId, "social_media", true);
				 if($social_media){
			?>
			<h5 class="contents-heading">Social media thread to comment and share on this FactBid</h5>
			<?php
			   
				echo apply_filters('the_content', $social_media);
			}
			?>
		</div>
	</td>
	</tr>
	</table>

    <div class="sub-cnt ">
        <h5 class="contents-heading">Description:</h5>
        <?php the_content(); ?>
    </div>
</div>
