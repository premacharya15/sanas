var backcanvas = new fabric.Canvas('backcanvas');
fabric.Object.prototype.transparentCorners = false;
fabric.Object.prototype.cornerColor = '#511F1B';
fabric.Object.prototype.cornerStyle = 'square';
fabric.Object.prototype.cornerSize = 14;
fabric.Object.prototype.borderScaleFactor = 3;
fabric.Object.prototype.borderColor = 'yellow';
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
        const select = document.getElementById('backfontFamily');
        fonts.forEach(font => {
            const option = document.createElement('option');
            option.text = font.family;
            option.value = font.family.replace(/ /g, '+'); // Replace spaces with '+'
            select.appendChild(option);
        });
    } catch (error) {
        console.error('Error fetching Google Fonts:', error);
    }
}

window.onload = function() {
    loadGoogleFonts();
};

function backchangeFont() {
    const activeObject = backcanvas.getActiveObject();
    if (activeObject && activeObject.type === 'i-text') { 
        const fontFamily = document.getElementById('backfontFamily').value.replace(/\+/g, ' ');
        WebFont.load({
            google: {
                families: [fontFamily]
            },
            fontactive: function(familyName, fvd) {
                if (familyName === fontFamily) {
                    activeObject.set({ fontFamily: familyName });  
                    backcanvas.renderAll();
                }
            }
        });
    }
}


function backaddText() {
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
    backcanvas.add(text);
    // Render the canvas to apply changes
    backcanvas.requestRenderAll();
}
// Canvas Textarea 
document.getElementById('backmyTextarea').addEventListener('input', function() {
    const activeObject = backcanvas.getActiveObject();
    if (activeObject && activeObject.type === 'i-text') {
        activeObject.set({ text: this.value });
        backcanvas.renderAll();
    }
});
// Update textarea when an object is selected
function handleObjectSelection() {
    const activeObject = backcanvas.getActiveObject();
    if (activeObject && activeObject.type === 'i-text') {
        document.getElementById('backmyTextarea').value = activeObject.text;
    } else {
        document.getElementById('backmyTextarea').value = '';
    }
}
// Update textarea when the text in the canvas object is modified
function handleObjectModified() {
    const activeObject = backcanvas.getActiveObject();
    if (activeObject && activeObject.type === 'i-text') {
        document.getElementById('backmyTextarea').value = activeObject.text;
    }
}
// Attach event listeners for selection and modification changes
backcanvas.on('selection:created', handleObjectSelection);
backcanvas.on('selection:updated', handleObjectSelection);
backcanvas.on('selection:cleared', function() {
    document.getElementById('backmyTextarea').value = '';
});
backcanvas.on('object:modified', handleObjectModified);
// Change font weight of selected text

function backchangeFontWeight() {
    const activeObject = backcanvas.getActiveObject();
    if (activeObject && activeObject.type === 'i-text') {
        const fontWeight = document.getElementById('backfontWeight').value;
        activeObject.set({ fontWeight: fontWeight });
        backcanvas.renderAll();
    }
}

// Change font size of selected text
function backchangeFontSize() {
    const activeObject = backcanvas.getActiveObject();
    if (activeObject && activeObject.type === 'i-text') {
        const fontSize = document.getElementById('backfontSize').value;
        activeObject.set({ fontSize: parseInt(fontSize, 10) });
        backcanvas.renderAll();
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
// Change font spacing of selected text

function backchangeLetterSpacing() {
    const activeObject = backcanvas.getActiveObject();
    if (activeObject && activeObject.type === 'i-text') {
        const letterSpacing = parseInt(document.getElementById('backletterSpacing').value, 10);
        activeObject.set({ charSpacing: letterSpacing });
        backcanvas.renderAll();
        // Update the displayed value next to the range input
        document.getElementById('backletterSpacingValue').textContent = letterSpacing;
    }
}

document.getElementById('backletterSpacing').addEventListener('input', backchangeLetterSpacing);
window.backchangeLetterSpacing = backchangeLetterSpacing;

// Change text alignment of selected text
function backchangeAlign() {
    // Get the selected value from the dropdown
    const align = document.getElementById('backtextAlign').value;
    
    // Get the active object from the canvas
    const activeObject = backcanvas.getActiveObject();
    
    // Check if the active object exists and is of type 'i-text'
    if (activeObject && activeObject.type === 'i-text') {
        // Apply the selected text alignment
        activeObject.set('textAlign', align);
        // Render the canvas to reflect the changes
        backcanvas.renderAll();
    }
}
window.backchangeAlign = backchangeAlign;

// Change text style (bold, italic, underline) of selected text
function backchangeTextStyle() {
    const style = document.getElementById('backtextStyles').value;
    const activeObject = backcanvas.getActiveObject();
    
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
        backcanvas.renderAll();
    }
}

window.backchangeTextStyle = backchangeTextStyle;


// Change color of selected text
function backchangeColor() {
    const color = document.getElementById('backfontColor').value;
    const activeObject = backcanvas.getActiveObject();
    
    if (activeObject && activeObject.type === 'i-text') {
        activeObject.set('fill', color);
        backcanvas.renderAll();
    }
}
jQuery(document).ready(function($) {

function backsaveCanvasData() {
    const canvasData = JSON.stringify(backcanvas.toJSON());
    console.log("Serialized Canvas Data:", canvasData);
    $('#backbase64Output').val(canvasData);
    $("textarea[name='sanas_metabox[sanas_back_canavs_image]']").val(canvasData);
    backcanvas.loadFromJSON(canvasData, function() {
        backcanvas.renderAll();
        console.log('Canvas loaded successfully');
    });
}
    $('button#backsaveCanvasButton').on('click', function(e) {
        e.preventDefault();
        backsaveCanvasData();
        window.backsaveCanvasData = backsaveCanvasData ;
        
    });
});

window.backchangeColor = backchangeColor;

// Set background image of the canvas
function backsetBackgroundImage() { 
    const input = document.getElementById('backbgImage');
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();  
        reader.onload = function(event) {
            const imgObj = new Image();
            imgObj.src = event.target.result;
            imgObj.onload = function() {
                const imgInstance = new fabric.Image(imgObj, {
                    scaleX: backcanvas.width / imgObj.width,
                    scaleY: backcanvas.height / imgObj.height
                });
                backcanvas.setBackgroundImage(imgInstance, backcanvas.renderAll.bind(backcanvas));
            }
        }
        reader.readAsDataURL(file);
    }
}



function backgetImageData() {
    const originalWidth = backcanvas.getWidth();
    const originalHeight = backcanvas.getHeight();
    const scaleFactor = 2; // Increase this value to improve quality
    backcanvas.setWidth(originalWidth * scaleFactor);
    backcanvas.setHeight(originalHeight * scaleFactor);
    backcanvas.setZoom(scaleFactor);
    // Render the canvas in higher resolution
    const dataURL = backcanvas.toDataURL({
        format: 'png',
        quality: 1.0
    });
    // Reset canvas dimensions and zoom
    backcanvas.setWidth(originalWidth);
    backcanvas.setHeight(originalHeight);
    backcanvas.setZoom(1);
    // Render the canvas back in original resolution
    backcanvas.renderAll();
    // Set the base64 image data to the textarea
    document.getElementById('backbase64Output').value = dataURL;
    // Set the src of the image tag to display the image
    // document.getElementById('imagePreview').src = dataURL;
} 
jQuery(document).ready(function($) {
    backloadCanvasData(); // Load canvas data on document ready

    function backloadCanvasData() {
        // Get the value of the textarea
        let canvasData = $("textarea[name='sanas_metabox[sanas_back_canavs_image]']").val();
        
        // Parse the canvas data if it exists
        if (canvasData) {
            try {
                canvasData = JSON.parse(canvasData); // Parse JSON string
                backcanvas.loadFromJSON(canvasData, function() {
                    backcanvas.renderAll();
                    console.log('Canvas loaded successfully');
                });
            } catch (e) {
                console.error('Error parsing canvas data:', e);
            }
        }
    }
});



