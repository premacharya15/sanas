jQuery(document).ready(function($) {
    $('#add-rsvp').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData($(this)[0]);
        formData.append('action', 'handle_video_upload');
        formData.append('nonce', videoUpload.nonce);

        $.ajax({
            url: videoUpload.ajax_url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                setupDeleteButton(); 
            },
            error: function(response) {
                $('#form-message').html('<p>There was an error uploading the video.</p>');
            }
        });
    });

    $('#upload-link').on('click', function(e) {
        e.preventDefault();
        $('#video-upload').click();
    });

    $('#video-upload').on('change', function(e) {
       const file = event.target.files[0];
        if (file) {
            if (file.size <= 50 * 1024 * 1024) { 
                showPreloader("Uploading Video");  
                uploadVideo(file);
                
            } else {
                alert('Upload an video with a maximum size of 50 MB.');

            }
        }
    });
    function uploadVideo(file) {
        var formData = new FormData();
        formData.append('action', 'handle_video_upload');
        formData.append('nonce', videoUpload.nonce);
        formData.append('video', file);

        $.ajax({
            url: videoUpload.ajax_url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                displayUploadedVideo(response);
                setupDeleteButton(); 
            },
            error: function(response) {
                $('#form-message').html('<p>There was an error uploading the video.</p>');
            },
            complete: function() {
                hidePreloader(); // Hide loading indicator after the call completes
            }
        });
    }

    function displayUploadedVideo(videoUrl) {
        var videoElement = $('#uploaded-video');
        videoElement.attr('src', videoUrl);
        videoElement.show();
        $('#drop-zone').addClass('video-uploaded');
        $('.video-inner-box').addClass('hide-part');
         $('.delete-btn').css('display', 'block');
    } 

    function setupDeleteButton() {
        $('.deleteRowBtn').off('click').on('click', function() {
            $('#uploaded-video').attr('src', '');
            $('#uploaded-video').hide();
            $('.video-inner-box').removeClass('hide-part');
            $('#drop-zone').removeClass('video-uploaded');
            $('.delete-btn').css('display', 'none');
        });
        $('.iframe-btn .deleteRowBtn').off('click').on('click', function() {
            $('#uploaded-video').attr('src', '');
            $('#uploaded-video').hide();
            $('.video-inner-box').removeClass('hide-part');
            $('#drop-zone').removeClass('video-uploaded');
        });
    }

if(document.getElementById('drop-zone') !=null)
{
    var initialDropZoneContent = document.getElementById('drop-zone').innerHTML;

}



    // function getYouTubeVideoID(url) {
    //     var regex = /[?&]v=([^&#]*)/;
    //     var match = url.match(regex);
    //     return (match && match[1]) ? match[1] : null;
    // }
    function getYouTubeVideoID(url) {
        var regex = /(?:youtube\.com.*[?&]v=|youtu\.be\/|youtube\.com\/embed\/)([^&#?]+)/;
        var match = url.match(regex);
        return (match && match[1]) ? match[1] : null;
    }
    function playYouTubeVideo() {
        var url = document.getElementById('youtube-url').value;
        var videoID = getYouTubeVideoID(url);
        if (videoID) {
            var container = document.getElementById('drop-zone');
            var existingIframe = document.getElementById('youtube-iframe'); // Check if iframe already exists
            
            if (existingIframe) {
                // If iframe exists, update the src
                existingIframe.src = 'https://www.youtube.com/embed/' + videoID;
                document.querySelector('.youtube-container').style.display = "block";
                document.querySelector('.youtube-container .youtube-iframe').src="";
                document.querySelector('.youtube-container .delete-btn').style.display = "block";
                
            } else {
                // If iframe doesn't exist, create a new one
                var iframe = document.createElement('iframe');
                iframe.id = 'youtube-iframe';
                iframe.width = '800';
                iframe.height = '490';
                iframe.src = 'https://www.youtube.com/embed/' + videoID;
                iframe.frameBorder = '0';
                iframe.allow = 'accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture';
                iframe.allowFullscreen = true;
            
                container.innerHTML = ''; // Clear any previous content
                container.appendChild(iframe); // Add the new iframe
            }
            

            // Create and append the delete button
            var deleteButtonContainer = document.createElement('div');
            deleteButtonContainer.className = 'iframe-btn delete-btn';

            var deleteButton = document.createElement('button');
            deleteButton.className = 'deleteRowBtn';
            deleteButton.innerHTML = '<i class="fa-regular fa-trash-can"></i>';
            deleteButton.setAttribute('fdprocessedid', '2e3wg'); // Add fdprocessedid attribute
            deleteButton.onclick = function() {
                container.innerHTML = initialDropZoneContent; // Restore initial content
                document.getElementById('generate-youtube-video').onclick = playYouTubeVideo;
            };

            deleteButtonContainer.appendChild(deleteButton);
            container.appendChild(deleteButtonContainer);
        } else {
            alert('Invalid YouTube URL');
        }
    }
if(document.getElementById('drop-zone') !=null)
{
   document.getElementById('generate-youtube-video').onclick = playYouTubeVideo;    
}

if(document.getElementById('rsvpcanvasElement') !=null)
{
    
    // Initially set the background image based on the PHP code
    var initialImgSrc = $('#rsvpcanvasElement').css('background-image');
    initialImgSrc = initialImgSrc.replace('url("', '').replace('")', ''); // Clean up the URL format

    // Change the background image when an image is clicked
    $('.bg-img-iteam img').click(function () {
        var newImgSrc = $(this).attr('src');
        $('#rsvpcanvasElement').css('background-image', 'url("' + newImgSrc + '")');
        $('.bg-img-iteam').removeClass('active');
        $(this).parent().addClass('active');
    });
}     
});