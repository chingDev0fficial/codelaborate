// Event listener for liking a post
$(document).on('click', '.like-btn', function() {
    const postId = $(this).closest('.posts').data('id'); // Use closest to find the nearest post

});

// Event listener for commenting on a post
$(document).on('click', '.comment-btn', function() {
    const postId = $(this).closest('.posts').data('id'); // Get the post ID
    
    $.ajax({
        url: `/post/${postId}/comments`, // Laravel route to fetch comments
        type: 'GET',
        success: function(response) {
            comments = response.comments
            post = response.post

            console.log(comments)
            // console.log(post)

            let html = `
                <div class="position-absolute screen center z-5" id="comment">
                    <div class="comment-card main-bg-color rounded">
                        <div class="d-flex align-items-center justify-content-between p-1 pl-3 pr-3 col6A041D">
                            <div>
                                <h3>Comment</h3>
                            </div>
                            <div>
                                <button class="btn col6A041D" id="x-btn"><i class="fa-solid fa-x"></i></button>
                            </div>
                        </div>

                        <div class="scrollable p-3">
                            <div class="p-3 bg-colWhite">
                                <img src="http://127.0.0.1:8000/storage/${post.image}" alt="" style="width: 1000px; height: 500px;">
                            </div>

                            <div class="p-3">
                                <textarea class="form-control" style="resize: none;" name="input-comment" id="" placeholder="Write a comment..."></textarea>
                                <button class="form-control bg-col6A041D colWhite" type="submit">Comment</button>
                            </div>

                            <hr>

                            <div id="comments-list" class="p-3">
            `

            comments.forEach(function(comment) {
                html += `
                                <div class="bg-colWhite rounded mb-3">
                                    <div class="p-2 d-flex align-items-center">
                                        <img class="profile-pic mr-2" src="http://127.0.0.1:8000/storage/${comment.user.profile_picture}" alt="">
                                        <div class="bold-font">
                                            ${comment.user.name}
                                            ${post.user_id == comment.user.id ? `
                                                <i class="fa-solid fa-marker col6A041D"></i>
                                                ` : ''}
                                        </div>
                                    </div>
                                    
                                    <div class="p-3">
                                        ${comment.body}
                                    </div>
                                </div>
                `
            });

            html += `
                            </div>
                            
                        </div>
                        
                    </div>
                </div>
            `

            $('#comment-body').append(html)

            $('#x-btn').on('click', function() {
                $('#comment').remove(); // Remove the comment modal from the DOM
            });
        },
        error: function(xhr) {
            console.error(xhr.responseText);
        }
    });
});