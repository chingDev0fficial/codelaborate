function fetchData() {
    $.ajax({
        url: "{{ route('fetch.posts') }}", // URL for the AJAX request
        method: 'GET',
        success: function(data) {
            $('#data-table tbody').empty(); // Clear the table body

            // Loop through the data and append it to the table
            data.forEach(function(item) {
                $('#news-feed #post-container #post').append(`
                    <div>
                        <div class="d-flex align-items-center">
                             <img class="profile-pic mr-1" src="{{ asset('storage/' . ${item.profile_picture}) }}" alt="">
                            <p class="bold-font" style="margin: 0; margin-right: 5px;">${item.name}</p>
                        </div>
                    </div>

                    <div class="d-flex">
                        <div>
                            <div class="p-3">
                                ${body}
                            </div>
                            <div>
                                <div><button class="btn bg-transparent"><i class="fa-solid fa-heart"></i> Heart</button></div>
                                <div><button class="btn bg-transparent"><i class="fa-solid fa-comment"></i> Comment</button></div>
                                <div><button class="btn bg-transparent"><i class="fa-solid fa-share"></i> Share</button></div>
                            </div>
                        </div>

                        <div>
                            <img class="img-post-size rounded" src="{{ asset('storage/' . ${item.image}) }}" alt="">
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
setInterval(fetchData, 5000);

// Initial data fetch
$(document).ready(function() {
    fetchData();
});