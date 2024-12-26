var canvas = new fabric.Canvas('canvas');
fabric.Object.prototype.transparentCorners = false;
fabric.Object.prototype.cornerColor = '#511F1B';
fabric.Object.prototype.cornerStyle = 'circle';
fabric.Object.prototype.cornerSize = 14;
fabric.Object.prototype.borderScaleFactor = 3;
fabric.Object.prototype.borderColor = 'yellow';
var customControls = {
    deleteControl: new fabric.Control({
        x: 0.5,
        y: -0.5,
        offsetY: -16,
        cursorStyle: 'pointer',
        mouseUpHandler: deleteObject,
        render: renderIcon,
        cornerSize: 24
    }),
    duplicateControl: new fabric.Control({
        x: -0.5,
        y: 0.5,
        offsetY: 16,
        cursorStyle: 'pointer',
        mouseUpHandler: duplicateObject,
        render: renderIcon,
        cornerSize: 24
    })
};
customControls.deleteControl.icon = 'deleteIcon';
customControls.duplicateControl.icon = 'duplicateIcon';
function renderIcon(ctx, left, top, styleOverride, fabricObject) {
    var size = this.cornerSize;
    ctx.save();
    ctx.translate(left, top);
    ctx.rotate(fabric.util.degreesToRadians(fabricObject.angle));
    ctx.drawImage(document.getElementById(this.icon), -size / 2, -size / 2, size, size);
    ctx.restore();
}
// Load All Google Font
// Function to add text to the canvas
function addText(event) {

    // Create a new text object
    const text = new fabric.IText('Add text', {
        left: 50,
        top: 50,
        fontFamily: 'Arial',
        fontSize: 40,  // Default font size
        fill: '#000000',
        textAlign: 'left',
        hoverCursor: 'pointer'
    });
    // Add custom controls to the text object
    text.controls = Object.assign({}, text.controls, customControls);
    // Add the text object to the canvas
    canvas.add(text);
    // Render the canvas to apply changes
    canvas.requestRenderAll();
}
// async function loadGoogleFonts() {
//     const apiKey = 'AIzaSyBkb0XQYNcyOA_E9xSGAAAebeo6oXCD1wY'; // Replace with your Google Fonts API key
//     const apiUrl = `https://www.googleapis.com/webfonts/v1/webfonts?key=${apiKey}`;
//     try {
//         const response = await fetch(apiUrl);
//         if (!response.ok) {
//             throw new Error('Failed to fetch Google Fonts');
//         }
//         const data = await response.json();
//         const fonts = data.items;
//         const select = document.getElementById('fontFamily');
//         fonts.forEach(font => {
//             const option = document.createElement('option');
//             option.text = font.family;
//             option.value = font.family.replace(/ /g, '+'); // Replace spaces with '+'
//             select.appendChild(option);
//         });
//         canvas.renderAll();
//     } catch (error) {
//         console.error('Error fetching Google Fonts:', error);
//     }
// }
async function loadGoogleFonts() {
    const apiKey = 'AIzaSyB0FLGd0rxWqu7vC0nRvxjehyNge4SSFbE'; // Replace with your Google Fonts API key
    const apiUrl = `https://www.googleapis.com/webfonts/v1/webfonts?key=${apiKey}`;
  
    try {
      const response = await fetch(apiUrl);
      if (!response.ok) {
        throw new Error('Failed to fetch Google Fonts');
      }
      const data = await response.json();
      const fonts = data.items;
  
      const selectElement = document.getElementById('fontFamily');
      const choices = new Choices(selectElement, {
        shouldSort: false,
        removeItemButton: true,
        position: 'bottom'
    });
      const options = fonts.map(font => ({
        value: font.family.replace(/ /g, '+'),
        label: font.family
      }));
  
      // Set choices dynamically
      choices.setChoices(options);
  
    } catch (error) {
      console.error('Error fetching Google Fonts:', error);
    }
  }

window.onload = function () {
    loadGoogleFonts();
    canvas.renderAll();
};
window.loadGoogleFonts = loadGoogleFonts;
// chnage font family
function changeFont() {
    const activeObject = canvas.getActiveObject();
    if (activeObject && activeObject.type === 'i-text') {
        const fontFamily = document.getElementById('fontFamily').value.replace(/\+/g, ' ');
        WebFont.load({
            google: {
                families: [fontFamily]
            },
            fontactive: function (familyName, fvd) {
                if (familyName === fontFamily) {
                    activeObject.set({ fontFamily: familyName });
                    canvas.renderAll();
                }
            }
        });
    }
    console.log('fontFamily - forntend-canvas-editor.js', fontFamily);
}
window.changeFont = changeFont;
// Change font weight of selected text
function changeFontWeight() {
    const activeObject = canvas.getActiveObject();
    if (activeObject && activeObject.type === 'i-text') {
        const fontWeight = document.getElementById('fontWeight').value;
        activeObject.set({ fontWeight: fontWeight });
        canvas.renderAll();
    }
}
window.changeFontWeight = changeFontWeight;
// Change font size of selected text
function changeFontSize() {
    const activeObject = canvas.getActiveObject();
    if (activeObject && activeObject.type === 'i-text') {
        const fontSize = document.getElementById('fontSize').value;
        activeObject.set({ fontSize: parseInt(fontSize, 10) });
        canvas.renderAll();
    }
    document.getElementById('fontSize').focus();
}
window.changeFontSize = changeFontSize;
// Change color of selected text
function changeColor(color) {
    const activeObject = canvas.getActiveObject();
    if (activeObject && activeObject.type === 'i-text') {
        activeObject.set('fill', color);
        canvas.renderAll();
    }
}
// Event listener for the color picker input
document.addEventListener('DOMContentLoaded', function () {
    if (jQuery('#colorPicker').length) {
        const colorPicker = document.getElementById('colorPicker');
        if (colorPicker) {
            colorPicker.addEventListener('change', function () {
                const color = this.value;
                document.querySelector('.color-target-code').textContent = color;
                changeColor(color);
            });
        } else {
            console.error('Element with ID "colorPicker" not found.');
        }
    }
});
// Event listeners for the color squares
if (jQuery('.color-squr').length) {
    document.querySelectorAll('.color-squr span').forEach(span => {
        span.addEventListener('click', function () {
            const color = this.getAttribute('color-hex-value');
            changeColor(color);
            if (jQuery('#colorPicker').length) {
                document.getElementById('colorPicker').value = color;
            }
            document.querySelector('.color-target-code').textContent = color;
        });
    });
}
// Event listeners for the color squares
if (jQuery('.color-squr').length) {
    document.querySelectorAll('.color-squr span').forEach(span => {
        span.addEventListener('click', function () {
            const color = this.getAttribute('color-hex-value');
            changeColor(color);
            if (jQuery('#colorPicker').length) {
                document.getElementById('colorPicker').value = color;
            }
            document.querySelector('.color-target-code').textContent = color;
        });
    });
}
window.changeColor = changeColor;
// Change text alignment of selected text
function changeAlign(align) {
    const activeObject = canvas.getActiveObject();
    if (activeObject && activeObject.type === 'i-text') {
        switch (align) {
            case 'left':
                activeObject.set('textAlign', 'left');
                break;
            case 'center':
                activeObject.set('textAlign', 'center');
                break;
            case 'right':
                activeObject.set('textAlign', 'right');
                break;
        }
        canvas.renderAll();
    }
}
window.changeAlign = changeAlign;
// Extend the IText prototype with custom controls
fabric.IText.prototype.controls = Object.assign({}, fabric.IText.prototype.controls, customControls);
fabric.Image.prototype.controls = Object.assign({}, fabric.Image.prototype.controls, customControls);
function changeLetterSpacing() {
    const activeObject = canvas.getActiveObject();
    if (activeObject && activeObject.type === 'i-text') {
        const letterSpacing = parseInt(document.getElementById('letterSpacing').value, 10);
        activeObject.set({ charSpacing: letterSpacing });
        canvas.renderAll();
        // Update the displayed value next to the range input
        document.getElementById('letterSpacingValue').textContent = letterSpacing;
    }
}
document.getElementById('letterSpacing').addEventListener('input', changeLetterSpacing);
window.changeLetterSpacing = changeLetterSpacing;
// Update textarea when text is input in the textarea
if (jQuery('#myTextarea').length) {
    document.getElementById('myTextarea').addEventListener('input', function () {
        const activeObject = canvas.getActiveObject();
        if (activeObject && activeObject.type === 'i-text') {
            activeObject.set({ text: this.value });
            canvas.renderAll();
        }
    });
}
// Change text style (bold, italic, underline) of selected text
function changeTextStyle(style) {
    const activeObject = canvas.getActiveObject();
    if (activeObject && activeObject.type === 'i-text') {
        switch (style) {
            case 'italic':
                activeObject.set('fontStyle', activeObject.fontStyle === 'italic' ? 'normal' : 'italic');
                break;
            case 'underline':
                activeObject.set('underline', !activeObject.underline);
                break;
        }
        canvas.renderAll();
    }
}
window.changeTextStyle = changeTextStyle;
// Function to set an image as the canvas background
function setBackgroundImage(imgSrc) {
    fabric.Image.fromURL(imgSrc, function (img) {
        // Scale the image to fit the canvas
        const scaleX = canvas.width / img.width;
        const scaleY = canvas.height / img.height;
        // Set the background image without affecting the existing controls
        canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas), {
            scaleX: scaleX,
            scaleY: scaleY
        });
        // Reapply custom controls to each object to ensure they stay intact
        canvas.renderAll();
    });
}
// Event listener for template image clicks
jQuery(document).ready(function ($) {
    $('.tamplate-iteam img').click(function () {
        var imgSrc = $(this).attr('src');
        setBackgroundImage(imgSrc);
    });
});
// Function to update the active alignment button
function updateAlignmentButtons(alignment) {
    // Remove 'active' class from all alignment buttons
    const alignmentButtons = document.querySelectorAll('.text-style-btn a');
    alignmentButtons.forEach(button => button.classList.remove('active'));
    // Add 'active' class to the correct button
    const activeButton = document.getElementById(`text-align-${alignment}`);
    if (activeButton) {
        activeButton.classList.add('active');
    }
}
function updatestyleButtons(style) {
    // Remove 'active' class from all style buttons
    const styleButtons = document.querySelectorAll('.text-style-btn-1 a');
    styleButtons.forEach(button => button.classList.remove('active'));
    // Add 'active' class to the correct button based on the style
    const activeButton = document.getElementById(`text-${style}`);
    if (activeButton) {
        activeButton.classList.add('active');
    }
}
function handleObjectSelection() {
    const activeObject = canvas.getActiveObject();
    if (activeObject && activeObject.type === 'i-text') {
        if (jQuery('#myTextarea').length) {
            document.getElementById('myTextarea').value = activeObject.text;
            document.getElementById('myTextarea').removeAttribute("disabled");
        }
        if (jQuery('#fontSize').length) {
            document.getElementById('fontSize').value = activeObject.fontSize;
        }
        if (jQuery('#fontWeight').length) {
            document.getElementById('fontWeight').value = activeObject.fontWeight;
        }
        if (jQuery('#colorPicker').length) {
            document.getElementById('colorPicker').value = activeObject.fill;
        }
        if (jQuery('#letterSpacing').length) {
            document.getElementById('letterSpacing').value = activeObject.charSpacing;
        }
        if (jQuery('#letterSpacingValue').length) {
            document.getElementById('letterSpacingValue').textContent = activeObject.charSpacing;
        }
        const formattedFontFamily = activeObject.fontFamily.replace(/ /g, '+');
        document.getElementById('fontFamily').value = formattedFontFamily;
        // Update alignment buttons
        updateAlignmentButtons(activeObject.textAlign);
        const isBold = activeObject.fontWeight === 'bold';
        const isItalic = activeObject.fontStyle === 'italic';
        const isUnderline = activeObject.underline === true;
        if (isItalic) {
            updatestyleButtons('italic');
        } else if (isUnderline) {
            updatestyleButtons('underline');
        } else {
            updatestyleButtons('');
        }
    } else {
        document.getElementById('myTextarea').value = '';
        document.getElementById('myTextarea').setAttribute("disabled", true);
        document.getElementById('fontSize').value = '';
        document.getElementById('fontWeight').value = '';
        document.getElementById('fontFamily').value = '';
        document.getElementById('colorPicker').value = '';
        document.getElementById('letterSpacing').value = '';
        document.getElementById('letterSpacingValue').value = '';
        updatestyleButtons('');
        updateAlignmentButtons('');
    }
}
// Update textarea when the text in the canvas object is modified
function handleObjectModified() {
    const activeObject = canvas.getActiveObject();
    if (activeObject && activeObject.type === 'i-text') {
        if (jQuery('#myTextarea').length) {
            document.getElementById('myTextarea').value = activeObject.text;
        }
        if (jQuery('#fontSize').length) {
            document.getElementById('fontSize').value = activeObject.fontSize;
        }
        if (jQuery('#fontWeight').length) {
            document.getElementById('fontWeight').value = activeObject.fontWeight;
        }
        if (jQuery('#fontFamily').length) {
            document.getElementById('fontFamily').value = activeObject.fontFamily;
        }
        if (jQuery('#colorPicker').length) {
            document.getElementById('colorPicker').value = activeObject.fill;
        }
        if (jQuery('#letterSpacing').length) {
            document.getElementById('letterSpacing').value = activeObject.charSpacing;
        }
        if (jQuery('#letterSpacingValue').length) {
            document.getElementById('letterSpacingValue').textContent = activeObject.charSpacing;
        }
        const formattedFontFamily = activeObject.fontFamily.replace(/ /g, '+');
        document.getElementById('fontFamily').value = formattedFontFamily;
        // Update alignment buttons
        updateAlignmentButtons(activeObject.textAlign);
        const isBold = activeObject.fontWeight === 'bold';
        const isItalic = activeObject.fontStyle === 'italic';
        const isUnderline = activeObject.underline === true;
        if (isItalic) {
            updatestyleButtons('italic');
        } else if (isUnderline) {
            updatestyleButtons('underline');
        } else {
            updatestyleButtons('');
        }
    }
}
canvas.on('selection:created', handleObjectSelection);
canvas.on('selection:updated', handleObjectSelection);
canvas.on('selection:cleared', function () {
    document.getElementById('myTextarea').value = '';
    document.getElementById('fontSize').value = '';
    document.getElementById('fontWeight').value = '';
    document.getElementById('fontFamily').value = '';
    document.getElementById('colorPicker').value = '';
    document.getElementById('letterSpacing').value = '';
    document.getElementById('letterSpacingValue').value = '';
    // Reset alignment buttons
    updateAlignmentButtons('');
    updateAlignmentButtons('');
});
canvas.on('object:modified', handleObjectModified);
// Set background image of the canvas
// Get base64 image data and set to img tag
function getImageData() {
    const originalWidth = canvas.getWidth();
    const originalHeight = canvas.getHeight();
    const scaleFactor = 2; // Increase this value to improve quality
    canvas.setWidth(originalWidth * scaleFactor);
    canvas.setHeight(originalHeight * scaleFactor);
    canvas.setZoom(scaleFactor);
    // Render the canvas in higher resolution
    const dataURL = canvas.toDataURL({
        format: 'png',
        quality: 1.0
    });
    // Reset canvas dimensions and zoom
    canvas.setWidth(originalWidth);
    canvas.setHeight(originalHeight);
    canvas.setZoom(1);
    // Render the canvas back in original resolution
    canvas.renderAll();
    // Set the base64 image data to the textarea
    document.getElementById('base64Output').value = dataURL;
    // Set the src of the image tag to display the image
    document.getElementById('imagePreview').src = dataURL;
}
// Serialize canvas data and save it to the backend
function saveCanvasData() {
    const canvasData = JSON.stringify(canvas.toJSON());
    console.log("Serialized Canvas Data:", canvasData);
    // Display the serialized data in an alert box
    //alert(canvasData);
}
// Define custom controls
// Function to add a new text object
// Add event listener for button click
// Function to delete the object
function deleteObject(eventData, transform) {
    var target = transform.target;
    canvas.remove(target);
    canvas.requestRenderAll();
}


// Function to load an uploaded image as the background
function uploadBackgroundImage() {
    const input = document.getElementById('backgroundImageUpload');
    const file = input.files[0];
    const reader = new FileReader();
    
    reader.onload = function(event) {
        const imgObj = new Image();
        imgObj.src = event.target.result;

        imgObj.onload = function() {
            const img = new fabric.Image(imgObj);
            img.set({
                scaleX: canvas.width / img.width,
                scaleY: canvas.height / img.height
            });
            canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas));
        }
    };
    
    if (file) {
        reader.readAsDataURL(file);
    }
}


// Function to duplicate the object
function duplicateObject(eventData, transform) {
    var target = transform.target;
    var clone;
    target.clone(function (cloned) {
        clone = cloned.set({
            left: target.left + 10,
            top: target.top + 10,
            angle: target.angle
        });
        // Ensure the duplicated object has the custom controls
        clone.controls = Object.assign({}, fabric.IText.prototype.controls, customControls);
        canvas.add(clone);
    });
    canvas.requestRenderAll();
}
// Function to render the control icons
window.addImageToCanvas = addImageToCanvas;
window.loadCanvasFromJSON = loadCanvasFromJSON;

jQuery(document).ready(function ($) {
    loadCanvasData();

    function loadFonts(fonts, callback) {
        WebFont.load({
            google: {
                families: fonts
            },
            active: callback
        });
    }

    function loadCanvasData() {
        console.log(canvasss);
        // Replace 'canvasss' with your actual canvas data
        let canvasData = canvasss;

        try {
            let data = parseCanvasData(canvasData); // Try parsing the canvas data

            // Extract the unique fonts from the canvas data
            const fonts = new Set();
            data.objects.forEach(obj => {
                if (obj.type === 'i-text' && obj.fontFamily) {
                    fonts.add(obj.fontFamily);
                }
            });

            if (fonts.size > 0) {
                // Load the fonts before rendering the canvas
                loadFonts(Array.from(fonts), () => {
                    canvas.loadFromJSON(canvasData, () => {
                        canvas.renderAll();
                    });
                });
            } else {
                // If no fonts to load, just render the canvas
                canvas.loadFromJSON(canvasData, () => {
                    canvas.renderAll();
                });
            }
        } catch (error) {
            console.error("Error parsing canvas data:", error.message);
            console.log("Attempting to fix the canvas data format...");

            try {
                // Try fixing common JSON issues and re-parsing
                canvasData = fixCanvasData(canvasData);
                let data = parseCanvasData(canvasData); // Re-parse after fix

                // Proceed with the same font loading and canvas rendering logic
                const fonts = new Set();
                data.objects.forEach(obj => {
                    if (obj.type === 'i-text' && obj.fontFamily) {
                        fonts.add(obj.fontFamily);
                    }
                });

                if (fonts.size > 0) {
                    loadFonts(Array.from(fonts), () => {
                        canvas.loadFromJSON(canvasData, () => {
                            canvas.renderAll();
                        });
                    });
                } else {
                    canvas.loadFromJSON(canvasData, () => {
                        canvas.renderAll();
                    });
                }
            } catch (fixError) {
                console.error("Failed to fix and parse canvas data:", fixError.message);
            }
        }
    }

    function parseCanvasData(data) {
        return JSON.parse(data); // Simple JSON parsing
    }

    function fixCanvasData(data) {
        // Fix common JSON issues such as trailing commas, missing quotes, etc.
        // Example regex fixes:
        data = data.replace(/,\s*}/g, '}'); // Remove trailing commas before closing curly braces
        data = data.replace(/,\s*]/g, ']'); // Remove trailing commas before closing square brackets

        return data;
    }
});


function addImageToCanvas(imgSrc) {
    fabric.Image.fromURL(imgSrc, function (img) {
        const scale = 0.2; // Adjust this value to scale the image to your desired size
        img.set({
            left: 100,
            top: 100,
            angle: 0,
            opacity: 1,
            scaleX: scale,
            scaleY: scale
        });
        // Add custom controls to the image object
        img.controls = Object.assign({}, img.controls, customControls);
        canvas.add(img);
        canvas.renderAll();
    });
}
var customControls = {
    deleteControl: new fabric.Control({
        x: 0.5,
        y: -0.5,
        offsetY: -16,
        cursorStyle: 'pointer',
        mouseUpHandler: deleteObject,
        render: renderIcon,
        cornerSize: 24
    }),
    duplicateControl: new fabric.Control({
        x: -0.5,
        y: 0.5,
        offsetY: 16,
        cursorStyle: 'pointer',
        mouseUpHandler: duplicateObject,
        render: renderIcon,
        cornerSize: 24
    })
};
// Function to delete the object
function deleteObject(eventData, transform) {
    var target = transform.target;

    var objects = canvas.getObjects();
    // Check if there is only one object left on the canvas
    if (objects.length <= 1) {
        // If there's only one object, show an alert and do not delete
        show_alert_message('Error', 'Cannot delete the last text box.');
        return;
    }

    canvas.remove(target);
    canvas.requestRenderAll();
}
// Function to duplicate the object
function duplicateObject(eventData, transform) {
    var target = transform.target;
    var clone;
    target.clone(function (cloned) {
        clone = cloned.set({
            left: target.left + 10,
            top: target.top + 10,
            angle: target.angle
        });
        // clone.controls = Object.assign({}, customControls);
        canvas.add(clone);
        canvas.requestRenderAll();
    });
}
customControls.deleteControl.icon = 'deleteIcon'; // Set the ID of the delete icon image
customControls.duplicateControl.icon = 'duplicateIcon'; // Set the ID of the duplicate icon image
// Function to render the control icons
// Function to load canvas from JSON
function loadCanvasFromJSON(json) {
    canvas.loadFromJSON(json, function () {
        // After loading, apply custom controls to each object
        canvas.getObjects().forEach(function (obj) {
            if (obj.type === 'image' || obj.type === 'i-text') {
                obj.controls = Object.assign({}, obj.controls, customControls);
            }
        });
        canvas.getObjects().forEach(function (obj) {
            if (obj.type === 'image' || obj.type === 'i-text') {
                if (obj.fontFamily) {
                    WebFont.load({
                        google: {
                            families: [obj.fontFamily]
                        },
                        fontactive: function (familyName, fvd) {
                            if (familyName === obj.fontFamily) {
                                obj.set({ fontFamily: familyName });
                                canvas.renderAll();
                            }
                        }
                    });
                }
            }
        });
        canvas.renderAll();
    });
}
// Event listener for saving canvas data
// Event listener for image clicks in the elements container 
jQuery(document).ready(function ($) {
    if (jQuery('.canavas-editor-btn').length) {
        document.querySelector('.canavas-editor-btn').addEventListener('click', function (event) {
            addText(event);
        });
    }
     if (jQuery('.elements-iteam img').length) {

    $('.elements-iteam img').on('click', function () {
        var imgSrc = $(this).attr('src');
        addImageToCanvas(imgSrc);
        $('.stiker-add').fadeIn();
        $('.stiker-add img').css('min-width', '10px'); // Ensure this is correct
    });
    }
});
jQuery(document).ready(function ($) {

jQuery('#save-back-canvas-db-admin').on('click', function () {
    var canvasData = canvas.toJSON();  // Convert canvas data to JSON
    var cardId = $(this).attr('card-id');  // Get the card ID from the button's attribute
    var rsvpURL = $(this).attr('btn-url');  // Redirect URL after saving

    // Get image data as a PNG
    var imageDataURL = canvas.toDataURL({
        format: 'png',
        quality: 1.0
    });

    // Show preloader during the save process
    showPreloader("Saving Card");

    // Send AJAX request to save canvas data and image
    jQuery.ajax({
        url: ajax_login_object.ajaxurl,
        type: 'POST',
        data: {
            action: 'sanas_save_back_canvas_data_callback_admin',  // Server-side action
            security: jQuery('#sanasbackpagesecurity').val(),  // Security nonce
            canvas_data: JSON.stringify(canvasData),  // Canvas data
            card_id: cardId,  // Card ID
            image_data: imageDataURL  // Send image data as base64 string
        },
        success: function (response) {
            hidePreloader();  // Hide preloader when done
            
            if (response.success) {
                // If the save is successful, redirect to RSVP URL
                window.location.href = rsvpURL;
            } else {
                // If there's an error in the server response
                show_alert_message('Error', response.data.message || 'An error occurred.');
            }
        },
        error: function (xhr, status, error) {
            // Handle error case
            hidePreloader();  // Hide preloader
            show_alert_message('Info', 'Please wait a moment and try again.');
        }
    });
});


    jQuery('#save-back-canvas-db').click(function () {
        canvas.renderAll();
        var canvasData = canvas.toJSON();
        var cardId = $(this).attr('card-id'); // Get the card ID from the button attribute
        var eventNo = $(this).attr('event-id');  // Use PHP to insert event_no
        var rsvpURL = $(this).attr('btn-url');   // Use PHP to insert event_no    
        var stepId = $(this).attr('step-id');  // Use PHP to insert event_no    

        var colorbg = $('#colorPicker').val();

        var imageDataURL = canvas.toDataURL({
            format: 'png',
            quality: 1.0
        });
        var canvasElement = $('#canvasElement');
        var backgroundImage = canvasElement.css('background-image');


        var colorbg = canvasElement.css('background-color');

        // Extract URL from background-image CSS property
        var imageUrl = backgroundImage.replace(/^url\(["']?/, '').replace(/["']?\)$/, '');
        var redirectToNext = true;
        if (isInitialLoad === 'true') {
            if (JSON.stringify(canvas.toJSON()) === phpbackCanvasData) {
                show_alert_message('Cover', 'Please modify the info card.');
                redirectToNext = false;
            }
        }
        if (redirectToNext) {
            showPreloader("Saving Card");
            $.ajax({
                url: ajax_login_object.ajaxurl,
                type: 'POST',
                data: {
                    action: 'sanas_save_back_canvas_data_callback',
                    'security': $('#sanasbackpagesecurity').val(),
                    canvas_data: JSON.stringify(canvasData),
                    card_id: cardId,
                    step_id: stepId,
                    event_no: eventNo,
                    imageUrl: imageUrl,
                    colorbg: colorbg,
                    image_data: imageDataURL
                },
                success: function (response) {
                    // alert(response.data.message);
                    hidePreloader();
                    var triggercall = $("#triggercall").val();
                    if (triggercall) {
                        window.location.href = triggercall;
                    } else {
                        window.location.href = rsvpURL;
                    }
                },
                error: function (xhr, status, error) {
                    //alert('please wait some movement try after some time ');
                    show_alert_message('Info', 'please wait some movement try after some time.');
                }
            });
        }
    });
});
function adduploadImageToCanvas(imgSrc) {
    fabric.Image.fromURL(imgSrc, function (img) {
        const scale = 0.2; // Adjust this value to scale the image to your desired size
        // Define target dimensions
        var targetWidth = 150;
        var targetHeight = 150;
        // Calculate the scaling factors
        var scaleX = targetWidth / img.width;
        var scaleY = targetHeight / img.height;
        // Use the smaller scale factor to maintain aspect ratio
        var scaleFactor = Math.min(scaleX, scaleY);
        // Apply the scaling factor

        img.set({
            left: (canvas.width - (img.width * scaleFactor)) / 2,
            top: (canvas.height - (img.height * scaleFactor)) / 2,
            opacity: 1,
            scaleX: scaleFactor,
            scaleY: scaleFactor,
        });
        // Add custom controls to the image object
        img.controls = Object.assign({}, img.controls, customControls);
        canvas.add(img);
        canvas.renderAll();
    });
}
// Event listener for image clicks in the elements container
jQuery(document).ready(function ($) {
    // Add event listener to all images with class 'canvas-image'
    $('.canvas-upload-image img').click(function () {
        var imgSrc = $(this).attr('src');
        adduploadImageToCanvas(imgSrc);
        $('.stiker-add').fadeIn();
        $('.stiker-add img').css('min-width', '10px'); // Ensure this is correct
    });
});
// image upload from gallary   
if (jQuery('#uploadbackImageBtn').length) {
    document.getElementById('uploadbackImageBtn').addEventListener('click', function () {
        document.getElementById('imageUpload').click();
    });
}
if (jQuery('#imageUpload').length) {
    document.getElementById('imageUpload').addEventListener('change', function (event) {
        var file = event.target.files[0];
        var reader = new FileReader();
        if (file) {
            if (file.size <= 20 * 1024 * 1024) {
                reader.onload = function (e) {
                    var imgElement = new Image();
                    imgElement.src = e.target.result;

                    var formData = new FormData();
                    var userId = document.getElementById('event_user_id').value;

                    formData.append('image', file);
                    formData.append('user_id', userId);
                    formData.append('action', 'sanas_backend_upload_image');
                    showPreloader("Uploading Image");
                    jQuery.ajax({
                        url: ajax_login_object.ajaxurl, // WordPress AJAX URL
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if (response.success) {
                                var html_inner = '<div class="canvas-upload-image"><img src="' + response.data.image_url + '" alt="Uploaded Image"></div>';
                                jQuery('#imagePreviewContainernew').prepend(html_inner);
                            } else {
                                //alert('Error: ' + response.data.message);
                            }
                            //$('#upload-message').text(response.message);
                        },
                        error: function () {
                            show_alert_message('Upload', 'Upload an image issue to save in server data.');
                        },
                        complete: function () {
                            hidePreloader(); // Hide loading indicator after the call completes
                        }
                    });



                    imgElement.onload = function () {
                        // Create a Fabric.js image instance
                        var imgInstance = new fabric.Image(imgElement, {
                            left: 0,
                            top: 0
                        });
                        // Define target dimensions
                        var targetWidth = 150;
                        var targetHeight = 150;
                        // Calculate the scaling factors
                        var scaleX = targetWidth / imgInstance.width;
                        var scaleY = targetHeight / imgInstance.height;
                        // Use the smaller scale factor to maintain aspect ratio
                        var scaleFactor = Math.min(scaleX, scaleY);
                        // Apply the scaling factor
                        imgInstance.set({
                            scaleX: scaleFactor,
                            scaleY: scaleFactor,
                            left: (canvas.width - (imgInstance.width * scaleFactor)) / 2,
                            top: (canvas.height - (imgInstance.height * scaleFactor)) / 2
                        });
                        // Add custom controls if needed
                        imgInstance.controls = Object.assign({}, imgInstance.controls, customControls);
                        canvas.add(imgInstance);
                        canvas.renderAll();
                    };
                };
                reader.readAsDataURL(file);
            } else {
                show_alert_message('Info', 'Upload an image with a maximum size of 20 MB.');
            }
        }
    });
}
jQuery(document).ready(function ($) {
    $('#front-page-redirect').on('click', function () {
        var canvasData = canvas.toJSON();
        var cardId = $(this).attr('card-id'); // Get the card ID from the button attribute
        var eventNo = $(this).attr('event-id');  // Use PHP to insert event_no
        var rsvpURL = $(this).attr('btn-url');   // Use PHP to insert event_no    
        var stepId = $(this).attr('step-id'); // Use PHP to insert event_no    
        var imageDataURL = canvas.toDataURL({
            format: 'png',
            quality: 1.0
        });

        var colorbg = $('#colorPicker').val();

        var canvasElement = $('#canvasElement');
        var backgroundImage = canvasElement.css('background-image');


        var colorbg = canvasElement.css('background-color');
        // Extract URL from background-image CSS property
        var imageUrl = backgroundImage.replace(/^url\(["']?/, '').replace(/["']?\)$/, '');
        var redirectToNext = true;
        if (isInitialLoad === 'true') {
            if (JSON.stringify(canvas.toJSON()) === phpbackCanvasData) {
                show_alert_message('Info', 'Please modify the front card information with event.');
                redirectToNext = false;
            }
        }
        if (redirectToNext) {

            showPreloader("Saving Card");
            $.ajax({
                url: ajax_login_object.ajaxurl,
                type: 'POST',
                data: {
                    action: 'sanas_save_back_canvas_data_callback',
                    'security': $('#sanasbackpagesecurity').val(),
                    canvas_data: JSON.stringify(canvasData),
                    card_id: cardId,
                    step_id: stepId,
                    event_no: eventNo,
                    imageUrl: imageUrl,
                    colorbg: colorbg,
                    image_data: imageDataURL
                },
                success: function (response) {
                    // alert(response.data.message);
                    hidePreloader();
                    window.location.href = rsvpURL + '&card_id=' + cardId + '&event_id=' + eventNo;
                },
                error: function (xhr, status, error) {
                    alert('please wait some movement try after some time ');
                }
            });
        }
    });
});


jQuery(document).ready(function ($) {
    if (jQuery('#load_back_json').val()=='yes') {

    var card_id = jQuery('#card_id').val(); 

    jQuery.ajax({
        url: ajax_login_object.ajaxurl,
        method: 'POST',
        data: { 
            action: 'sanas_load_fabric_js_data_back',
            card_id: card_id
        },
        success: (response) => {
            if (response.success && response.data.json_data) {
                canvas.loadFromJSON(response.data.json_data, () => {
                    canvas.renderAll();
                });
            }
        }
    });

  }


    if (jQuery('#user_load_back_json').val()=='yes') {


 
    var card_id = jQuery('#card_id').val();
    var event_id = jQuery('#event_id').val(); 

    jQuery.ajax({
        url: ajax_login_object.ajaxurl,
        method: 'POST',
        data: { 
            action: 'sanas_load_fabric_js_data_back_user',
            card_id: card_id,
            event_id: event_id
        },
        success: (response) => {
            if (response.success && response.data.json_data) {
                canvas.loadFromJSON(response.data.json_data, () => {
                    canvas.renderAll();
                });
            }
        }
    })

     }

});