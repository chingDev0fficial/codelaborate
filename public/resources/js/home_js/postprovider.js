import {shareTemplate, postTemplate, dateFormat} from '/resources/js/postTemplates_js/templates.js';

function fetchData() {
    $.ajax({
        url: '/fetch-data', // URL for the AJAX request
        method: 'GET',
        success: function(data) {
            $('#news-feed #post-container #posts').empty(); // Clear the table body
            
            const currentUserId = data.currentUserId;
            const posts = data.post;
            // const numberOfHearts = data.numberOfHearts;

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

            let post_and_shares = [];

            // Loop through the data and append it to the table
            posts.forEach(function(data) {
                console.log(data)
                
                if ( data.shares.length > 0 )
                    data.shares.forEach(function(shared_post) {
                        post_and_shares[dateFormat(shared_post.created_at)] = shareTemplate(shared_post, data.user, data, currentUserId, dateFormat(shared_post.created_at, options), dateFormat(data.created_at, options));
                    });
                
                post_and_shares[dateFormat(data.created_at, options)] = postTemplate(data, currentUserId, dateFormat(data.created_at, options));
            });

            Object.entries(post_and_shares).forEach(([key, post]) => {
                $('#news-feed #post-container').append(post)
            })

        },
        error: function(xhr, status, error) {
            console.error("Error fetching data:", error);
        }
    });
}

// Initial data fetch
$(document).ready(function() {
    fetchData();

    // Listen for PostCreated event
    window.Echo.channel('posts')
        .listen('PostCreated', (e) => {
            console.log('Post created:', e.post);
            fetchData(); // Fetch data again to update the posts
        });
});