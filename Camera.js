
var video = document.getElementById('video');
var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');

let constraintObj = {
    audio : false,
    video : true
}
/handle older browsers that might implement getUserMedia differently
if ( navigator.mediaDevices === undefined ) {
    navigator.mediaDevices = {};
    navigator.mediaDevices.getUserMedia = function( constraintObj ) {
        navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia 
        || navigator.mozGetUserMedia || navigator.oGetUserMedia || navigator.msGetUserMedia;
        if ( !getUserMedia ) {
            return Promise.reject( new Error( 'getUserMedia is not implemented in this browser' ) );
        }
        return new Promise( function( resolve, reject ) {
            getUserMedia.call( navigator, constraintObj, resolve, reject );
        } );
    }
} else {
    navigator.mediaDevices.enumerateDevices();
}

navigator.mediaDevices.getUserMedia( constraintObj ).then( function( mediaStreamObj ) {
//connecting the meadia stream to the video element
var video = document.querySelector( 'video' );
if ( 'srcObject' in video ) {
     //newer versions
     video.srcObject = mediaStreamObj;
} else {
     //old versions
     video.src = window.URL.createObjectURL( mediaStreamObj );
}

//auto show in the video element what is being shown in the video stream
video.onloadedmetadata = function ( ev ) {
     video.play();
};

} ).catch( function( err ) {
    console.log( err.name, err.message );
} );


//funtion to draw an image on the canvas once picture is taken
function snap() {
    var but = document.getElementById( 'image_saver' );
    but.setAttribute( 'type', 'submit' );
    canvas.width = video.clientWidth;
    canvas.height = video.clientHeight;
    context.drawImage( video, 0, 0, canvas.width, canvas.height);
}

//function that enable a draws a sticker onto the canvas
function draw( x, dx, dy ) {
    var image = document.getElementById(x);
    context.drawImage(image, canvas.width - dx, canvas.height - dy, 70, 70);
}

//function creates the image
function finalImage() {
    var element = document.getElementById( 'picture' );
    var img = canvas.toDataURL( 'image/jpeg' );
    element.setAttribute('value', img);
}

/*                          Old Work                                        */ 
const saveButton = document.getElementById('image_saver'); //save button

saveButton.addEventListener('click', function() {
                image = canvas.toDataURL('images/png');
                document.getElementById('hidden_data').value = image;
            });
