export function dateFormat(date, options = {}) {
    return new Date(date).toLocaleString('en-US', options);
}

export function shareTemplate(shared_post, user, data, currentUserId, sharedDate, originalDate) {
    const html = `
        <div class="shared-posts bg-colWhite" data-id="${shared_post.id}">
            <div class="p-3 d-flex align-items-center justify-content-between">    
                <div class="d-flex align-items-center" data-id="${shared_post.user_id}">
                    <img id="view-profile" class="profile-pic mr-1" src="http://127.0.0.1:8000/storage/${shared_post.user.profile_picture}" alt="">
                    <p style="margin: 0; margin-right: 5px;"><strong id="view-profile">${shared_post.user.name}</strong></br><i>${sharedDate}</i></p>
                </div>
                <div class="relative">
                    <button class="btn round-btn center post-option-btn mb-2">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                    <div class="post-options p-2 rounded">
                        ${shared_post.user_id == currentUserId ? `
                            <button class="btn mb-1 bg-col6A041D colWhite bold-font edit-btn" style="width:100%;"><i class="fa-solid fa-pen-to-square"></i> Edit Post</button>
                            <button type="submit" class="btn mb-1 bg-col6A041D colWhite bold-font delete-btn" style="width:100%;"><i class="fa-solid fa-trash"></i> Delete Post</button>
                        ` : `
                            <button class="btn mb-1 bg-col6A041D colWhite bold-font edit-btn" style="width:100%;"><i class="fa-solid fa-floppy-disk"></i> Save Post</button>
                            <button type="submit" class="btn mb-1 bg-col6A041D colWhite bold-font delete-btn" style="width:100%;"><i class="fa-solid fa-eye-slash"></i> Hide Post</button>
                            <button type="submit" class="btn bg-col6A041D colWhite bold-font report-btn" style="width:100%;"><i class="fa-solid fa-bug"></i> report Post</button>
                        `}
                    </div>
                </div>
            </div>
            <hr>
            <div class="posts" data-id="${shared_post.post_id}">
                <div class="p-3 mb-3 bg-white rounded">
                    <div class="d-flex">
                        <div style="width:40%;">
                            <div class="p-3 caption">
                                ${shared_post.body != null ? shared_post.body : ''}
                            </div>
                            <div>
                                <div>
                                    <button class="btn bg-transparent col6A041D heart-btn">
                                    ${shared_post.isHeartedByCurrentUser ? `
                                        <i class="fa-solid fa-heart"></i> Heart ${shared_post.numberOfHearts}
                                    ` : `
                                        <i class="fa-regular fa-heart"></i> Heart ${shared_post.numberOfHearts}
                                    `}
                                    </button>
                                </div>
                                <div><button class="btn bg-transparent col6A041D comment-btn"><i class="fa-regular fa-comment"></i> Comment</button></div>
                                <div><button class="btn bg-transparent col6A041D share-btn"><i class="fa-solid fa-share"></i> Share</button></div>
                            </div>
                        </div>

                        <div>
                            <div class="d-flex align-items-center" data-id="${data.user_id}">
                                <img id="view-profile" class="profile-pic mr-1" src="http://127.0.0.1:8000/storage/${user.profile_picture}" alt="">
                                <p style="margin: 0; margin-right: 5px;"><strong id="view-profile">${user.name}</strong></br><i>${originalDate}</i></p>
                            </div>
                            <div class="p-3">
                                ${data.body}
                            </div>
                            <div class="btn share-image-container comment-btn rounded">
                                <img class="img-post-size" src="http://127.0.0.1:8000/storage/${data.image}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

    return html;
}

export function postTemplate(data, currentUserId, formattedDate) {
    const html = `
        <div class="posts" data-id="${data.id}">
            <div class="p-3 mb-3 bg-white rounded">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center" data-id="${data.user_id}">
                            <img id="view-profile" class="profile-pic mr-1" src="http://127.0.0.1:8000/storage/${data.user.profile_picture}" alt="">
                            <p style="margin: 0; margin-right: 5px;"><strong id="view-profile">${data.user.name}</strong></br><i>${formattedDate}</i></p>
                        </div>
                        
                        <div class="relative">
                            <button class="btn round-btn center post-option-btn mb-2">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                            <div class="post-options p-2 rounded">
                                ${data.user_id == currentUserId ? `
                                    <button class="btn mb-1 bg-col6A041D colWhite bold-font edit-btn" style="width:100%;"><i class="fa-solid fa-pen-to-square"></i> Edit Post</button>
                                    <button type="submit" class="btn mb-1 bg-col6A041D colWhite bold-font delete-btn" style="width:100%;"><i class="fa-solid fa-trash"></i> Delete Post</button>
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

                    <div class="d-flex pt-5">
                        <div style="width:40%;">
                            <div class="p-3 caption">
                                ${data.body}
                            </div>
                            <div>
                                <div>
                                    <button class="btn bg-transparent col6A041D heart-btn">
                                    ${data.isHeartedByCurrentUser ? `
                                        <i class="fa-solid fa-heart"></i> Heart ${data.numberOfHearts}
                                    ` : `
                                        <i class="fa-regular fa-heart"></i> Heart ${data.numberOfHearts}
                                    `}
                                    </button>
                                </div>
                                <div><button class="btn bg-transparent col6A041D comment-btn"><i class="fa-regular fa-comment"></i> Comment</button></div>
                                <div><button class="btn bg-transparent col6A041D share-btn"><i class="fa-solid fa-share"></i> Share</button></div>
                            </div>
                        </div>

                        <div class="btn image-container comment-btn rounded">
                            <img class="img-post-size" src="http://127.0.0.1:8000/storage/${data.image}" alt="">
                        </div>
                    </div>
            </div>
        </div>
                `;

    return html;
}