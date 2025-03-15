$(document).on('click', '.post-option-btn', function (e) {
    e.stopPropagation();
    
    // Hide any other open popups
    $('.post-options').not($(this).next('.post-options')).hide();
    
    // Toggle the popup visibility for the clicked button
    $(this).next('.post-options').toggle();
});

// Hide the popup when clicking outside of it
$(document).on('click', function (e) {
    if (!$(e.target).closest('.post-option-btn, .post-options').length) {
        $('.post-options').hide(); // Hide all popups if clicking outside
    }
});

// Hide the popup when clicking any button inside `.post-options`
$(document).on('click', '.post-options button', function () {
    $(this).closest('.post-options').hide(); // Hide the popup
});

$(document).on('click', '.edit-btn', function() {
    const postId = $(this).closest('.posts').data('id') ?? null;
    const sharedPostId = $(this).closest('.shared-posts').data('id') ?? null;

    console.log("Post ID:", postId);
    console.log("Shared Post ID:", sharedPostId);

    $.ajax({
        url: `/post/${postId}/postData`, // URL for the AJAX request
        method: 'GET',
        data: {
            sharedpost_id: sharedPostId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(post_) {
            const post = post_.postData;
            console.log("Post Data:", post);

            let html = `
                <div class="position-absolute screen center z-5 post-edit-card" id="edit-post" data-id="${post.id}">
                    <div class="orig-post" data-id=${post?.post_id ?? null}></div>
                    <div class="comment-card main-bg-color rounded">
                        <div class="d-flex align-items-center justify-content-between p-1 pl-3 pr-3 col6A041D">
                            <div>
                                <h3>Edit Post</h3>
                            </div>
                            <div>
                                <button class="btn col6A041D" id="x-btn"><i class="fa-solid fa-x"></i></button>
                            </div>
                        </div>

                        <div class="p-3">
                            <textarea class="form-control" style="resize: none; height: 50vh;" id="update-post" required>${post.body}</textarea>
                            <button class="form-control bg-col6A041D colWhite update-post">Update</button>
                        </div>
                    </div>
                </div>
            `;

            $('#temp-body').append(html);

            $('#x-btn').on('click', function() {
                $('#edit-post').remove();
            });
        },
        error: function(xhr, status, error) {
            console.error("Error fetching data:", error);
            console.log("Response:", xhr.responseText);
        }
    });
});

$(document).on('click', '.update-post', function() {
    const origPost = document.getElementsByClassName('orig-post')[0].dataset.id;
    const postId = $(this).closest('.post-edit-card').data('id');

    console.log("Original Post:", origPost);

    $.ajax({
        url: `/post/${postId}/editPost`, // The URL should match your route
        method: 'POST',
        data: {
            ifShared: origPost != "null" ? origPost : 0,
            body: $('#update-post').val(),
            _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
        },
        success: function(response) {
            console.log("Response:", response); // Log the entire response
            if (response.postData) {
                $(`.posts[data-id="${postId}"] .caption`).html(response.postData.body);
            } else if (response.sharedPostData) {
                $(`.posts[data-id="${postId}"] .caption`).html(response.sharedPostData.body);
            }
            $('#edit-post').remove();
            location.reload();
        },
        error: function(xhr) {
            console.log("Error updating post:", xhr.responseText);
        }
    });
})

$(document).on('click', '.delete-btn', function() {
    const postId = $(this).closest('.posts').data('id');
    const shareId = $(this).closest('.shared-posts').data('id');

    console.log("Post ID:", postId);
    console.log("Share ID:", shareId);

    $.ajax({
        url: "/post/delete-post",
        method: 'POST',
        data: {
            post_id: postId,
            share_id: shareId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log("Post Deleted:", response);
            location.reload();
        },
        error: function(xhr, status, error) {
            console.error("Error deleting post:", error);
            console.log("Response:", xhr.responseText);
        }
    });
});

$(document).on('click', '.edit-comment-btn', function() {
    const commentId = $(this).closest('._comment-card').data('id');

    $.ajax({
        url: `/comment/${commentId}/data`,
        type: 'GET',
        success: function(response) {
            const comment = response.comment;
            $(`._comment-card[data-id="${commentId}"] .comment-body`).empty();
            $(`._comment-card[data-id="${commentId}"] .comment-body`).html(
                `
                    <div class="d-flex comment-editor">
                        <textarea class="form-control" id="edited-comment" style="resize: none;">${comment.body}</textarea>
                        <button class="btn bg-col6A041D colWhite bold-font edit-comment" type="submit">Save</button>
                    </div>
                `
            );
        },
        error: function(xhr) {
            console.error("Error fetching comment data:", xhr.responseText);
        }
    });
});

$(document).on('click', '.share-now-btn', function() {
    const postId = $(this).closest('.share-caption-card').data('id');
    const caption = $('#share-caption').val();

    $.ajax({
        url: `/share`,
        type: 'POST',
        data: {
            post_id: postId,
            body: caption,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                console.log("Share successful:", response);
                location.reload(); // Reload page to show new share
            } else {
                console.error("Share failed:", response.message);
                alert("Failed to share post: " + response.message);
            }
        },
        error: function(xhr) {
            console.error("Error sharing post:", xhr.responseText);
            alert("Error sharing post. Please try again.");
        }
    });

    // Remove share dialog
    $('#share-card').remove();
});

$(document).on('click', '.save-post', function() {
    const postId = $(this).closest('.posts').data('id');

    $.ajax({
        url: `/post/${postId}/editPost`,
        type: 'POST',
        data: {
            body: $('#edited-post').val(),
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log("Response:", response); // Log the entire response
            $(`.posts[data-id="${postId}"] .caption`).html(response.post.body);
        },
        error: function(xhr) {
            console.error("Error saving post:", xhr.responseText);
        }
    });
});