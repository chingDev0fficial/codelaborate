function fetchData() {
    $.ajax({
        url: '/fetch-data', // URL for the AJAX request
        method: 'GET',
        success: function(data) {
            $('#news-feed #post-container #posts').empty(); // Clear the table body   
            
            const currentUserId = data.currentUserId;
            const posts = data.post;

            posts.reverse();

            // Format the date as desired
            const options = { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric', 
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit'
            };

            // Loop through the data and append it to the table
            posts.forEach(function(item) {
                // Create a Date object
                const date = new Date(item.created_at);

                const formattedDate = date.toLocaleString('en-US', options);
                
                $('#news-feed #post-container').append(`
                    <div class="posts" data-id="${item.id}">
                        <div class="p-3 mb-3 bg-white rounded">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <img class="profile-pic mr-1" src="http://127.0.0.1:8000/storage/${item.user.profile_picture}" alt="">
                                        <p style="margin: 0; margin-right: 5px;"><strong>${item.user.name}</strong></br><i>${formattedDate}</i></p>
                                    </div>
                                    
                                    <div class="relative">
                                        <button class="btn round-btn center post-option-btn mb-2">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </button>
                                        <div class="post-options p-2 rounded">
                                            ${item.user_id == currentUserId ? `
                                                <button class="btn mb-1 bg-col6A041D colWhite bold-font edit-btn" style="width:100%;"><i class="fa-solid fa-pen-to-square"></i> Edit Post</button>
                                                <form action="#" method="POST">
                                                    <button type="submit" class="btn mb-1 bg-col6A041D colWhite bold-font delete-btn" style="width:100%;"><i class="fa-solid fa-trash"></i> Delete Post</button>
                                                </form>
                                            ` : `
                                                <button class="btn mb-1 bg-col6A041D colWhite bold-font edit-btn" style="width:100%;"><i class="fa-solid fa-floppy-disk"></i> Save Post</button>
                                                <form action="#" method="POST">
                                                    <button type="submit" class="btn mb-1 bg-col6A041D colWhite bold-font delete-btn" style="width:100%;"><i class="fa-solid fa-eye-slash"></i> Hide Post</button>
                                                </form>
                                                <button type="submit" class="btn bg-col6A041D colWhite bold-font report-btn" style="width:100%;"><i class="fa-solid fa-bug"></i> report Post</button>
                                            `}
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex">
                                    <div style="width:40%;">
                                        <div class="p-3 caption">
                                            ${item.body}
                                        </div>
                                        <div>
                                            <div><button class="btn bg-transparent col6A041D like-btn"><i class="fa-regular fa-heart"></i> Heart</button></div>
                                            <div><button class="btn bg-transparent col6A041D comment-btn"><i class="fa-regular fa-comment"></i> Comment</button></div>
                                            <div><button class="btn bg-transparent col6A041D share-btn"><i class="fa-solid fa-share"></i> Share</button></div>
                                        </div>
                                    </div>

                                    <div class="btn comment-btn">
                                        <img class="img-post-size rounded" src="http://127.0.0.1:8000/storage/${item.image}" alt="">
                                    </div>
                                </div>
                        </div>
                    </div>
                `);
            });
        },
        error: function(xhr, status, error) {
            console.error("Error fetching data:", error);
        }
    });
}

// Fetch data every 5 seconds
// setInterval(fetchData, 5000);

// Initial data fetch
$(document).ready(function() {
    fetchData();
});