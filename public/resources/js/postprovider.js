function fetchData() {
    $.ajax({
        url: '/fetch-data', // URL for the AJAX request
        method: 'GET',
        success: function(data) {
            $('#news-feed #post-container #posts').empty(); // Clear the table body   
            
            const currentUserId = data.currentUserId;
            const posts = data.post;

            // Loop through the data and append it to the table
            posts.forEach(function(item) {
                // Create a Date object
                const date = new Date(item.created_at);

                // Format the date as desired
                const options = { 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric', 
                    hour: '2-digit', 
                    minute: '2-digit', 
                    second: '2-digit'
                };

                const formattedDate = date.toLocaleString('en-US', options);
                
                $('#news-feed #post-container').append(`
                    <div class="posts" data-id="${item.id}">
                        <div class="p-3 mb-3 bg-white rounded">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <img class="profile-pic mr-1" src="http://127.0.0.1:8000/storage/${item.user.profile_picture}" alt="">
                                        <p style="margin: 0; margin-right: 5px;"><strong>${item.user.name}</strong></br><i>${formattedDate}</i></p>
                                    </div>
                                    
                                    ${item.user_id == currentUserId ? `
                                    <button class="btn round-btn center">
                                        <i class="fa-solid fa-bars"></i>
                                    </button>` : ''}
                                </div>

                                <div class="d-flex">
                                    <div style="width:60%;">
                                        <div class="p-3 caption">
                                            ${item.body}
                                        </div>
                                        <div>
                                            <div><button class="btn bg-transparent col6A041D like-btn"><i class="fa-regular fa-heart"></i> Heart</button></div>
                                            <div><button class="btn bg-transparent col6A041D comment-btn"><i class="fa-regular fa-comment"></i> Comment</button></div>
                                            <div><button class="btn bg-transparent col6A041D share-btn"><i class="fa-solid fa-share"></i> Share</button></div>
                                        </div>
                                    </div>

                                    <div>
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