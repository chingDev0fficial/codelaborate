import {shareTemplate, postTemplate, dateFormat} from '../postTemplates_js/templates.js';

function fetchData() {
    const profileUserId = $('.profile-sidebar').data('id'); // Get ID outside of AJAX call
    
    $.ajax({
        url: '/fetch-data',
        method: 'GET',
        // data: { user_id: profileUserId }, // Pass user_id in request
        success: function(data) {
            $('.profile-content #user-posts').empty();
            
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

                console.log(profileUserId)
                
                if ( data.shares.length > 0 )
                    data.shares.forEach(function(shared_post) {
                        if ( shared_post.user.id == profileUserId )
                            post_and_shares[dateFormat(shared_post.created_at)] = shareTemplate(shared_post, data.user, data, currentUserId, dateFormat(shared_post.created_at, options), dateFormat(data.created_at, options));
                });
                
                if ( data.user.id == profileUserId )
                    post_and_shares[dateFormat(data.created_at, options)] = postTemplate(data, currentUserId, dateFormat(data.created_at, options));
            });

            Object.entries(post_and_shares).forEach(([key, post]) => {
                $('.profile-content #user-posts').append(post)
            })

        },
        error: function(xhr, status, error) {
            console.error("Error fetching data:", error);
        }
    });
}

function reloadUserProfile(userId) {
    $.ajax({
        url: `/user/${userId}`,
        data: {id: userId},
        type: 'GET',
        success: function(response) {
            sessionStorage.setItem('userProfile', JSON.stringify(response));
            const btn = $('.follow-btn');
            if (response.isFollowing) {
                btn.html('<i class="fas fa-user-check"></i> Following')
                   .removeClass('btn-success')
                   .addClass('btn-secondary');
            } else {
                btn.html('<i class="fas fa-user-plus"></i> Follow')
                   .removeClass('btn-secondary')
                   .addClass('btn-success');
            }
        },
        error: function(xhr) {
            console.error('Error fetching user profile:', xhr.responseText);
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    try {
        const userProfile = JSON.parse(sessionStorage.getItem('userProfile'));
        if (userProfile) {

            console.log('User profile:', userProfile);
            // Store the original logged-in user ID before updating sidebar
            const loggedInUserId = parseInt($('.profile-sidebar').attr('data-id'));
            
            // Now update the sidebar data-id to viewed profile's ID
            document.querySelector('.profile-sidebar').setAttribute('data-id', userProfile.id);
            
            // Update profile picture
            document.getElementById('profile-picture').src = `http://127.0.0.1:8000/storage/${userProfile.profile_picture}`;
            
            // Update user information
            // add the user id in data-id attribute
            document.getElementById('profile-name').textContent = userProfile.name;
            document.getElementById('profile-occupation').textContent = userProfile.occupation;
            document.getElementById('profile-email').querySelector('span').textContent = userProfile.email;
            document.getElementById('profile-birthday').querySelector('span').textContent = new Date(userProfile.birthday).toLocaleDateString();
            document.getElementById('profile-sex').querySelector('span').textContent = userProfile.sex;

            // Compare logged-in user ID with viewed profile ID
            if (loggedInUserId === parseInt(userProfile.id)) {
                $('.follow-btn, .message-btn').hide();
            } else {
                $('.follow-btn, .message-btn').show();
                // Set initial button state based on follow status
                const btn = $('.follow-btn');
                if (userProfile.isFollowing) {
                    btn.html('<i class="fas fa-user-check"></i> Following')
                       .removeClass('btn-success')
                       .addClass('btn-secondary');
                } else {
                    btn.html('<i class="fas fa-user-plus"></i> Follow')
                       .removeClass('btn-secondary')
                       .addClass('btn-success');
                }
            }
        }
    } catch (error) {
        console.error('Error loading user profile:', error);
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
});

$(document).on('click', '.follow-btn', function() {
    const profileId = $('.profile-sidebar').data('id');
    
    $.ajax({
        url: '/follow',
        type: 'POST',
        data: {
            user_id: profileId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                reloadUserProfile(profileId);
            } else {
                alert('Failed to follow user');
            }
        },
        error: function(xhr) {
            console.error('Error following user:', xhr.responseText);
            alert('Error following user');
        }
    });
});