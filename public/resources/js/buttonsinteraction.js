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
    const postId = $(this).closest('.posts').data('id');

    $.ajax({
        url: `/post/${postId}/postData`, // URL for the AJAX request
        method: 'GET',
        success: function(post) {
            post = post.postData
            let html = `
                <div class="position-absolute screen center z-5 post-edit-card" id="edit-post" data-id="${post.id}"}>
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

            $('#comment-body').append(html);

            $('#x-btn').on('click', function() {
                $('#edit-post').remove();
            });
        },
        error: function(xhr, status, error) {
            console.error("Error fetching data:", error);
        }
    });
});

$(document).on('click', '.update-post', function() {
    const postId = $(this).closest('.post-edit-card').data('id');

    $.ajax({
        url: `/post/${postId}/editPost`, // The URL should match your route
        method: 'POST',
        data: {
            body: $('#update-post').val(),
            _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
        },
        success: function(response) {
            $(`.posts[data-id="${postId}"] .caption`).html(response.postData.body);
            $('#edit-post').remove();
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
})

$(document).on('click', '.edit-comment-btn', function() {
    const commentId = $(this).closest('._comment-card').data('id');
    
    $.ajax({
        url: `/comment/${commentId}/data`,
        type: 'GET',
        success: function(response) {
            const comment = response.comment
            $(`._comment-card[data-id="${commentId}"] .comment-body`).empty()
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
            console.error(xhr.responseText);
        }
    });
});