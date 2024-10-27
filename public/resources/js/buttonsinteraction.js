// Step 1: Dynamically create the button and add it to the DOM
// const button = document.createElement('button');
// button.id = 'x-btn';
// button.innerText = 'Remove Div';
// document.body.appendChild(button); // Append the button to the body or another container

// Step 2: Attach the event listener to the dynamically created button
document.getElementById('x-btn').addEventListener('click', function() {
    const div = document.getElementById("comment");
    if (div) {
        div.remove();
    }
});