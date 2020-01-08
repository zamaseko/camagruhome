let width = 400;
let height = 400;

const video = document.getElementById("player");
const canvas = document.getElementById("canvas");
const capture = document.getElementById("capture");
const sticker = document.getElementById("sticker");

let stickers = {};
stickers.loser = document.getElementById("loser");
stickers.shrek = document.getElementById("shrek");
stickers.joker = document.getElementById("joker");
stickers.headshot = document.getElementById("headshot");
stickers.wassup = document.getElementById("wassup");

const loser = document.getElementById("loser");
const shrek = document.getElementById("shrek");
const joker = document.getElementById("joker");
const headshot = document.getElementById("headshot");
const wassup = document.getElementById("wassup");

let selected_stickers = [];

feed();

function feed() {
  var constrains = {
    video: { width: 300, height: 300 }
  };
  navigator.mediaDevices.getUserMedia(constrains).then(stream => {
    video.srcObject = stream;
  });
}

video.addEventListener(
  "canplay",
  e => {
    video.setAttribute("width", width);
    video.setAttribute("height", height);
    canvas.setAttribute("width", width);
    canvas.setAttribute("height", height);
  },
  false
);

var context = canvas.getContext("2d");

sticker.addEventListener("click", function() {
  var x = document.getElementById("stickers").value;
  if (x == "loser") context.drawImage(loser, 50, 50, 80, 80);
  else if (x == "shrek") context.drawImage(shrek, 50, 50, 80, 80);
  else if (x == "joker") context.drawImage(joker, 50, 50, 80, 80);
  else if (x == "headshot") context.drawImage(headshot, 50, 50, 80, 80);
  else if (x == "wassup") context.drawImage(wassup, 50, 50, 80, 80);
  else if (x == "none") context.drawImage(none, 50, 50, 80, 80);
  var selected_sticker = stickers[x];
  const sticker_path = selected_sticker.getAttribute('src');
  if (!selected_stickers.includes(sticker_path)) {
    selected_stickers.push(sticker_path);
  }
});

capture.addEventListener("click", function() {
  context.drawImage(video, 0, 0, canvas.width, canvas.height);
  const dataURI = canvas.toDataURL();
  // image.setAttribute('value', dataURI);
  document.getElementById("save").addEventListener("click", e => {
    save();
  });

  function save() {
    var xhttp = new XMLHttpRequest();
    var stickers_joined = selected_stickers.join();
    var data = "image=" + dataURI + "&stickers=" + stickers_joined;
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
      }
    };
    xhttp.open("POST", "test.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);
  }
});
 
