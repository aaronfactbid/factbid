<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" action="<?php echo get_the_permalink($args['factbid_post_id']); ?>" method="POST" name="report_form">
      <div class="modal-header">
        <h5 class="modal-title">Report FactBid</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <label for="report_content" class="form-label">Explain Why your are reporting this Factbid.</label>
            <p><small>Did you find it spam or offensive?</small></p>
            <input type="hidden" value="<?php echo get_current_user_id(); ?>" name="current_user_id">
            <input type="hidden" value="<?php echo $args['factbid_id']; ?>" name="factbid_id">
            <input type="hidden" value="<?php echo $args['factbid_post_id']; ?>" name="factbid_post_id">
            <textarea class="form-control" rows="3" id="report_content" name="report_content"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-danger">Report</button>
      </div>
    </form>
  </div>
</div>