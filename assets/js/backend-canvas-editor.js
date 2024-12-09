var canvas = new fabric.Canvas('canvas');
fabric.Object.prototype.transparentCorners = false;
fabric.Object.prototype.cornerColor = '#511F1B';
fabric.Object.prototype.cornerStyle = 'circle';
fabric.Object.prototype.cornerSize = 14;
fabric.Object.prototype.borderScaleFactor = 3;
fabric.Object.prototype.borderColor = 'yellow';
// Load All Google Fonts
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
        const select = document.getElementById('fontFamily');
        fonts.forEach(font => {
            const option = document.createElement('option');
            option.text = font.family;
            option.value = font.family.replace(/ /g, '+'); // Replace spaces with '+'
            select.appendChild(option);
        });
        jQuery('#mySelect').selectpicker('refresh');
    } catch (error) {
        console.error('Error fetching Google Fonts:', error);
    }  
}

// Call the function to load Google Fonts when the page loads
window.onload = function() {
    loadGoogleFonts();
};

// Change the font of the active text object on the canvas
function changeFont() {
    const activeObject = canvas.getActiveObject();
    if (activeObject && activeObject.type === 'i-text') { 
        const fontFamily = document.getElementById('fontFamily').value.replace(/\+/g, ' ');
        // Load the font using WebFont Loader
        WebFont.load({
            google: {
                families: [fontFamily]
            },
            fontactive: function(familyName, fvd) {
                // Apply the font to the active object after it has been loaded
                if (familyName === fontFamily) {
                    activeObject.set({ fontFamily: familyName });  
                    canvas.renderAll();
                }
            }
        });
    }
}

// Change font weight of selected text
function changeFontWeight() {
    const activeObject = canvas.getActiveObject();
    if (activeObject && activeObject.type === 'i-text') {
        const fontWeight = document.getElementById('fontWeight').value;
        activeObject.set({ fontWeight: fontWeight });
        canvas.renderAll();
    }
}
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
// Change color of selected text
function changeColor() {
    const color = document.getElementById('fontColor').value;
    const activeObject = canvas.getActiveObject();
    
    if (activeObject && activeObject.type === 'i-text') {
        activeObject.set('fill', color);
        canvas.renderAll();
    }
}


// Change text alignment of selected text
function changeAlign() {
    // Get the selected value from the dropdown
    const align = document.getElementById('textAlign').value;
    
    // Get the active object from the canvas
    const activeObject = canvas.getActiveObject();
    
    // Check if the active object exists and is of type 'i-text'
    if (activeObject && activeObject.type === 'i-text') {
        // Apply the selected text alignment
        activeObject.set('textAlign', align);
        // Render the canvas to reflect the changes
        canvas.renderAll();
    }
}
// Update textarea when text is input in the textarea
document.getElementById('myTextarea').addEventListener('input', function() {
    const activeObject = canvas.getActiveObject();
    if (activeObject && activeObject.type === 'i-text') {
        activeObject.set({ text: this.value });
        canvas.renderAll();
    }
});
// Update textarea when an object is selected
function handleObjectSelection() {
    const activeObject = canvas.getActiveObject();
    if (activeObject && activeObject.type === 'i-text') {
        document.getElementById('myTextarea').value = activeObject.text;
        document.getElementById('myTextarea').removeAttribute("disabled");
    } else {
        document.getElementById('myTextarea').value = '';
        document.getElementById('myTextarea').setAttribute("disabled", true);
    }
}
// Update textarea when the text in the canvas object is modified
function handleObjectModified() {
    const activeObject = canvas.getActiveObject();
    if (activeObject && activeObject.type === 'i-text') {
        document.getElementById('myTextarea').value = activeObject.text;
    }
}
// Attach event listeners for selection and modification changes
canvas.on('selection:created', handleObjectSelection);
canvas.on('selection:updated', handleObjectSelection);
canvas.on('selection:cleared', function() {
    document.getElementById('myTextarea').value = '';
});
canvas.on('object:modified', handleObjectModified);
// Change text style (bold, italic, underline) of selected text
function changeTextStyle() {
    const style = document.getElementById('textStyles').value;
    const activeObject = canvas.getActiveObject();
    
    if (activeObject && activeObject.type === 'i-text') {
        switch (style) {
            case 'bold':
                activeObject.set('fontWeight', activeObject.fontWeight === 'bold' ? 'normal' : 'bold');
                break;
            case 'italic':
                activeObject.set('fontStyle', activeObject.fontStyle === 'italic' ? 'normal' : 'italic');
                break;
            case 'underline':
                activeObject.set('underline', !activeObject.underline);
                break;
            case 'normal':
                activeObject.set('fontWeight', 'normal');
                activeObject.set('fontStyle', 'normal');
                activeObject.set('underline', false);
                break;
        }
        canvas.renderAll();
    }
}

// Set background image of the canvas
function setBackgroundImage() {
    const input = document.getElementById('bgImage');
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            const imgObj = new Image();
            imgObj.src = event.target.result;
            imgObj.onload = function() {
                const imgInstance = new fabric.Image(imgObj, {
                    scaleX: canvas.width / imgObj.width,
                    scaleY: canvas.height / imgObj.height
                });
                canvas.setBackgroundImage(imgInstance, canvas.renderAll.bind(canvas));
            }
        }
        reader.readAsDataURL(file);
    }
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

// Define custom controls
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
// Extend the IText prototype with custom controls
fabric.IText.prototype.controls = Object.assign({}, fabric.IText.prototype.controls, customControls);
function changeLetterSpacing() {
    const activeObject = canvas.getActiveObject();
    if (activeObject && activeObject.type === 'i-text') {
        const letterSpacing = parseInt(document.getElementById('letterSpacing').value, 10);
        activeObject.set({ charSpacing: letterSpacing });
        canvas.renderAll();
        document.getElementById('letterSpacingValue').textContent = letterSpacing;
    }
}
// Function to add a new text object
// function addText() {

//     // Create a new text object
//     const text = new fabric.IText('Add text', {
//         left: 50,
//         top: 50,
//         fontFamily: 'Arial',
//         fontSize: 40,  // Default font size
//         fill: '#000000',
//         textAlign: 'left',
//         hoverCursor: 'pointer'
//     });
//     // Add custom controls to the text object
//     text.controls = Object.assign({}, text.controls, customControls);
//     // Add the text object to the canvas
//     canvas.add(text);
//     // Render the canvas to apply changes
//     canvas.requestRenderAll();
// }
// Function to delete the object
function deleteObject(eventData, transform) {
    var target = transform.target;
    canvas.remove(target);
    canvas.requestRenderAll();
}
// Function to duplicate the object
function duplicateObject(eventData, transform) {
    var target = transform.target;
    var clone;
    target.clone(function(cloned) {
        clone = cloned.set({
            left: target.left + 10,
            top: target.top + 10
        });
        // Ensure the duplicated object has the custom controls
        clone.controls = Object.assign({}, fabric.IText.prototype.controls, customControls);
        canvas.add(clone);
    });
    canvas.requestRenderAll();
}
// Function to render the control icons
function renderIcon(ctx, left, top, styleOverride, fabricObject) {
    var size = this.cornerSize;
    ctx.save();
    ctx.translate(left, top);
    ctx.rotate(fabric.util.degreesToRadians(fabricObject.angle));
    ctx.drawImage(document.getElementById(this.icon), -size / 2, -size / 2, size, size);
    ctx.restore();
}
// Add icons for the custom controls
customControls.deleteControl.icon = 'deleteIcon';
customControls.duplicateControl.icon = 'duplicateIcon';
document.getElementById('letterSpacing').addEventListener('input', changeLetterSpacing);
window.changeLetterSpacing = changeLetterSpacing;
jQuery(document).ready(function($) {

function saveCanvasData() {
    const canvasData = JSON.stringify(canvas.toJSON());
    console.log("Serialized Canvas Data:", canvasData);
    $('#base64Output').val(canvasData);
    $("textarea[name='sanas_metabox[sanas_front_canavs_image]']").val(canvasData);
    canvas.loadFromJSON(canvasData, function() {
        canvas.renderAll();
        console.log('Canvas loaded successfully');
    });
}

// jQuery document ready function
    // Bind the click event to the button
    $('button#saveCanvasButton').on('click', function(e) {
        e.preventDefault();
        saveCanvasData();
        window.saveCanvasData = saveCanvasData ;
        
    });
});

window.changeColor = changeColor;
window.changeAlign = changeAlign;
window.changeTextStyle = changeTextStyle;

// Define saveCanvasData in the global scope


jQuery(document).ready(function($) {
    loadCanvasData(); // Load canvas data on document ready

    function loadCanvasData() {
        // Get the value of the textarea
        let canvasData = $("textarea[name='sanas_metabox[sanas_back_canavs_image]']").val();
        
        // Parse the canvas data if it exists
        if (canvasData) {
            try {
                canvasData = JSON.parse(canvasData); // Parse JSON string
                canvas.loadFromJSON(canvasData, function() {
                    canvas.renderAll();
                    console.log('Canvas loaded successfully');
                });
            } catch (e) {
                console.error('Error parsing canvas data:', e);
            }
        }
    }
});
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

// Function to add image to canvas with custom controls
function addImageToCanvas(imgSrc) {
    fabric.Image.fromURL(imgSrc, function(img) {
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

// Function to delete the object
function deleteObject(eventData, transform) {
    var target = transform.target;
    canvas.remove(target);
    canvas.requestRenderAll();
}

// Function to duplicate the object
function duplicateObject(eventData, transform) {
    var target = transform.target;
    var clone;
    target.clone(function(cloned) {
        clone = cloned.set({
            left: target.left + 10,
            top: target.top + 10
        });

        // Ensure the duplicated object has the custom controls
        clone.controls = Object.assign({}, fabric.IText.prototype.controls, customControls);

        canvas.add(clone);
        canvas.requestRenderAll();
    });
}

// Function to render the control icons
function renderIcon(ctx, left, top, styleOverride, fabricObject) {
    var size = this.cornerSize;
    ctx.save();
    ctx.translate(left, top);
    ctx.rotate(fabric.util.degreesToRadians(fabricObject.angle));
    ctx.drawImage(document.getElementById(this.icon), -size / 2, -size / 2, size, size);
    ctx.restore();
}

// Add icons for the custom controls
customControls.deleteControl.icon = 'deleteIcon'; // Set the ID of the delete icon image
customControls.duplicateControl.icon = 'duplicateIcon'; // Set the ID of the duplicate icon image

// Event listener for image clicks in the elements container
jQuery(document).ready(function($) {
    $('.elements-iteam img').click(function() {
        var imgSrc = $(this).attr('src');
        addImageToCanvas(imgSrc);
        $('.stiker-add').fadeIn();
        $('.stiker-add img').css('max-width', '10px'); // Ensure this is correct
    });
    $('#save-canvas-db').click(function() {
        // Get the JSON representation of the canvas
        var canvasData = canvas.toJSON();
        
        // Display the JSON data in an alert box
        // alert(JSON.stringify(canvasData, null, 2));
        
        // Log the JSON data to the console
        console.log(canvasData);
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
});