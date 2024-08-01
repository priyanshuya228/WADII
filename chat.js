
var incomingid = document.querySelector('[name="incomingid"]').value;

function scrollToBottom() {
    var chatBox = document.getElementById('chat-box');
    chatBox.scrollTop = chatBox.scrollHeight;
}


function sendMessage() {
    var messageInput = document.getElementById('message-input');
    var message = messageInput.value;

    if (message !== '') {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'insert-chat.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        
        // Combine both parameters in a single string
        var data = 'incomingid=' + incomingid + '&message=' + message;

        xhr.onload = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {

                    console.log("success");
                    console.log(xhr.responseText);
                } else {

                    console.error('Error sending message. Status code: ' + xhr.status);
                }
            }
        };
        
        xhr.send(data); 

        // Clearing the input field
        messageInput.value = '';
    }
}


// Event listener for the message form
document.getElementById('message-form').addEventListener('submit', function (e) {
    e.preventDefault();
    sendMessage();
});

// Periodically updating the chat
setInterval(function () {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'get-chat.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var data = xhr.responseText;
                document.getElementById('chat-box').innerHTML = data;
                scrollToBottom();
            }
        }
    };

    xhr.send('incomingid=' + incomingid); 
}, 1000);

// Scrolling to the bottom when the page loads
window.onload = function () {
    scrollToBottom();
};
