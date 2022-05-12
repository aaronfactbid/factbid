<div class="modal fade" id="factBidPermission" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Attention..!!!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <p><em>Before authorizing your user to post a new FactBid or Claim, please state in a couple sentences the nature of your intended post.  This is so a moderator can confirm that you are a real person, and not trying to post spam, pornography, or similar.  The moderator will not determine the merit of your post, only that it is serious.</em></p>
            <form action="/" method="post" id="request_factbid">
                <textarea rows="3" class="form-control" id="post_request" name="post_request"></textarea>
                <input type="hidden" value="{{ user_id }}" name="id_profile">
                <input data-id="{{ user_id }}" type="submit" class="btn btn-primary btnclass post_request_button" value="Submit" name="post_request_button" id="post_request_button">
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>