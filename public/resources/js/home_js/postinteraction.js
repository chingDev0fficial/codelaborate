function comment_card(response) {

    $('#temp-body').empty();
    const comments = response.comments;
    const post = response.post;
    const creator = response.creator; 
    const current_user_id = response.current_user_id;

    const post_date = new Date(post?.share?.created_at ?? post.created_at)

    // Format the date as desired
    const options = { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric', 
        hour: '2-digit', 
        minute: '2-digit', 
        second: '2-digit'
    };

    const post_formattedDate = post_date.toLocaleString('en-US', options);

    let html = `
        <div class="position-absolute screen center z-5 post-card" id="comment" ${post.id ? `data-id="${post.id}"` : ''}>
            <div class="shared-posts bg-colWhite" data-id="${post?.share?.id ?? null}"><div>
            <div class="comment-card main-bg-color rounded">
                <div class="d-flex align-items-center justify-content-between p-1 pl-3 pr-3 col6A041D">
                    <div>
                        <h3>Comment</h3>
                    </div>
                    <div>
                        <button class="btn col6A041D" id="x-btn"><i class="fa-solid fa-x"></i></button>
                    </div>
                </div>

                <div class="scrollable pl-3 pr-3 pb-3">
                    <div>
                        <div class="d-flex align-items-center">
                            <img class="profile-pic mr-1" src="http://127.0.0.1:8000/storage/${creator.profile_picture}" alt="">
                            <p style="margin: 0; margin-right: 5px;"><strong>${creator.name}</strong></br><i>${post_formattedDate}</i></p>
                        </div>
                        <hr>
                        <div class="p-3 caption">
                            ${post?.share?.body ?? post.body}
                        </div>
                    </div>
                    <div class="p-3 bg-colWhite main-bg-color" style="z-index: 3;">
                        <img src="http://127.0.0.1:8000/storage/${post?.origin_post?.image ?? post.image}" alt="" style="width: 100%; height: auto;">
                    </div>

                    <div class="p-3 sticky-top main-bg-color">
                        <textarea class="form-control" style="resize: none;" name="input-comment" id="input-comment" placeholder="Write a comment..." required></textarea>
                        <button class="form-control bg-col6A041D colWhite submit-comment">Comment</button>
                        <hr>
                    </div>

                    <div id="comments-list" class="p-3">
    `;

    comments.forEach(function(comment) {

        const date = new Date(comment.created_at);

        const formattedDate = date.toLocaleString('en-US', options);

        html += `
            <div class="bg-colWhite rounded mb-3 _comment-card" data-id="${comment.id}">
                <div class="d-flex justify-content-between align-items-center p-3">
                    <div class="p-2 d-flex align-items-center">
                        <img class="profile-pic mr-2" src="http://127.0.0.1:8000/storage/${comment.user.profile_picture}" alt="">
                        <p style="margin: 0; margin-right: 5px;"><strong>${comment.user.name} ${post.user_id == comment.user.id ? `<i class="fa-solid fa-marker col6A041D"></i>` : ''}</strong></br>${formattedDate}</p>
                    </div>
                    
                    <div class="relative">
                        <button class="btn round-btn center post-option-btn mb-2">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                        <div class="post-options p-2 rounded">
                            ${comment.user_id == current_user_id ? `
                                <button class="btn mb-1 bg-col6A041D colWhite bold-font edit-comment-btn" style="width:100%;"><i class="fa-solid fa-pen-to-square"></i> Edit Comment</button>
                                <button type="submit" class="btn mb-1 bg-col6A041D colWhite bold-font delete-comment-btn" style="width:100%;"><i class="fa-solid fa-trash"></i> Delete Comment</button>
                            ` : 
                        
                            `
                                <button class="btn mb-1 bg-col6A041D colWhite bold-font hide-comment-btn" style="width:100%;"><i class="fa-solid fa-eye-slash"></i> Hide Comment</button>
                                <button type="submit" class="btn mb-1 bg-col6A041D colWhite bold-font delete-comment-btn" style="width:100%;"><i class="fa-solid fa-trash"></i> Delete Comment</button>
                                <button type="submit" class="btn bg-col6A041D colWhite bold-font report-comment-btn" style="width:100%;"><i class="fa-solid fa-bug"></i> report Comment</button>
                            `}
                        </div>
                    </div>
                </div>
                <div class="p-3 comment-body">
                    ${comment.body}
                </div>
            </div>
        `;
    });

    html += `
                    </div>
                </div>
            </div>
        </div>
    `;
    console.log(response)
    // let html = `<button class="form-control bg-col6A041D colWhite submit-comment" data-id="${response.share_id}">Comment</button>`

    $('#temp-body').append(html);

    // Set up click event to remove the modal on 'x-btn' click
    $('#x-btn').on('click', function() {
        $('#comment').remove();
    });
}

function loadComments(_url) {
    try {
        const commentBody = document.getElementById('input-comment')

        if (commentBody.value.trim() === "")
        {
            alert("Please fill out this field!");
            commentBody.focus(); // Bring focus back to the textarea
        }

        $.ajax({
            url: _url,
            type: 'GET',
            data: {
                commentBody: commentBody.value.trim(), // Pass the trimmed comment body here
                _token: '{{ csrf_token() }}' // CSRF token for security
            },
            success: function(response) {
                console.log("Respond")
                console.log(response)
                comment_card(response)
                
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    } catch ( error ) {
        $.ajax({
            url: _url,
            type: 'GET',
            success: function(response) {
                comment_card(response)
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }
}

// Event listener for commenting on a post
$(document).on('click', '.comment-btn', function() {
    const postId = $(this).closest('.posts').data('id'); // Get the post ID
    const sharedPostId = $(this).closest('.shared-posts').data('id') ?? null;
    console.log(`Post ID: ${postId}`)
    console.log(`Share ID: ${sharedPostId}`)
    loadComments(`/post/${postId}/${sharedPostId}/comments`);
});

$(document).on('click', '.submit-comment', function() {
    const postId = $(this).closest('.post-card').data('id'); // Get the post ID
    const sharedPostId = $(this).closest('.shared-posts').data('id') ?? null;
    console.log(`Post ID: ${postId}`)
    console.log(`Share ID: ${sharedPostId}`)
    loadComments(`/post/${postId}/${sharedPostId}/submitComment`);
});

$(document).on('click', '.edit-comment', function() {
    const commentId = $(this).closest('._comment-card').data('id');
    const edited = $('#edited-comment').val();

    $.ajax({
        url: `/comment/${commentId}/edit`,
        type: 'POST',
        data: {
            body: edited, // Pass the trimmed comment body here
            _token: $('meta[name="csrf-token"]').attr('content') // CSRF token for security
        },
        success: function(response) {
            const comment = response.comment;
            $('.comment-editor').remove();
            $(`._comment-card[data-id="${commentId}"] .comment-body`).html(comment.body);
        },
        error: function(xhr) {
            console.error(xhr.responseText);
        }
    });
});

$(document).on('click', '.delete-comment-btn', function() {
    const commentId = $(this).closest('._comment-card').data('id');

    $.ajax({
        url: `/comment/${commentId}/delete`,
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content') // CSRF token for security
        },
        success: function(response) {
            $(`._comment-card[data-id="${commentId}"]`).remove();
        },
        error: function(xhr) {
            console.error(xhr.responseText);
        }
    });
});

$(document).on('click', '.heart-btn', function() {

    function heart(postId, shareId, heartBTN) {

        $.ajax({
            url: `/heart/${postId}`,
            type: 'POST',
            data: {
                share_id: shareId,
                post_type: shareId ? 'original' : 'shared',
                _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
            },
            success: function(response) {
                console.log(response)
                heart = response.heart
                numberOfHearts = response.numberOfHearts;
    
                if(heart == 1)
                {
                    heartBTN.html(`<i class="fa-regular fa-heart"></i> Heart ${numberOfHearts}`);
                }
                else
                {
                    heartBTN.html(`<i class="fa-solid fa-heart"></i> Heart ${numberOfHearts}`);
                }
    
                // Add animation class
                heartBTN.addClass('heart-animation');
    
                // Remove the animation class after the animation duration
                setTimeout(() => {
                    heartBTN.removeClass('heart-animation');
                }, 300);
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }

    const shareId = $(this).closest('.shared-posts').data('id');
    const postId = $(this).closest('.posts').data('id');
    const heartBTN = $(this);

    heart(postId, shareId, heartBTN);
    
})

$(document).on('click', '.share-btn', function() {
    const postId = $(this).closest('.posts').data('id');
    
    let html = `
        <div class="position-absolute screen center z-5 share-caption-card" data-id="${postId}" id="share-card"}>
            <div class="share-card main-bg-color rounded">
                <div class="d-flex align-items-center justify-content-between p-1 pl-3 pr-3 col6A041D">
                    <div>
                        <h3>Add Caption</h3>
                    </div>
                    <div>
                        <button class="btn col6A041D" id="x-btn"><i class="fa-solid fa-x"></i></button>
                    </div>
                </div>

                <div class="p-3">
                    <textarea class="form-control" style="resize: none; height: 50vh;" id="share-caption"></textarea>
                    <button class="form-control bg-col6A041D colWhite share-now-btn" id="share-now-btn">Share Now</button>
                </div>
            </div>
        </div>
    `;

    $('#temp-body').append(html);

    $('#x-btn').on('click', function() {
        $('#share-card').remove();
    });
})

// Function to hash user ID
function hashUserId(userId) {
    return CryptoJS.SHA256(userId.toString()).toString(CryptoJS.enc.Hex);
}

// Use event delegation to attach the event listener
$(document).on('click', '#view-profile', function() {
    const userId = $(this).closest('[data-id]').data('id'); // Retrieve the data-id attribute from the closest parent
    // window.location.href = `/user/${userId}`;

    console.log("id", userId)
    $.ajax({
        url: `/user/${hashUserId(userId)}`,
        data: {id: userId},
        type: 'GET',
        success: function(response) {
            console.log(response);
            // Store the response data in session storage
            sessionStorage.setItem('userProfile', JSON.stringify(response));
            // Redirect to the profile view
            window.location.href = `/profile/${hashUserId(userId)}`;
        },
        error: function(xhr) {
            console.error(xhr.responseText);
        }
    });
});