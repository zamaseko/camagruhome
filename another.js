<script>
              document.getElementById('browse').onchange = function(e) {
              var img = new Image();
              img.onload = draw;
              img.onerror = failed;
              img.src = URL.createObjectURL(this.files[0]);
              };
              function draw() {
              var canvas = document.getElementById('upload');
              canvas.width = this.width;
              canvas.height = this.height;
              var ctx = canvas.getContext('2d');
              ctx.drawImage(this, 0,0);
              }
              function failed() {
              console.error("The provided file couldn't be loaded as an Image media");
              }
              var stickerCanvas = document.getElementById("stickers");
              var ctx = stickerCanvas.getContext("2d");
              function DrawCadre() {
                  var sticker = document.getElementsByTagName("img");
                  var cadre = sticker[0];
                  ctx.drawImage(cadre, 5, 5, 40, 40);
              }
              function DrawCig() {
                  var sticker = document.getElementsByTagName("img");
                  var Cig = sticker[1];
                  ctx.drawImage(Cig, 100, 90, 40, 40);
              }
              function DrawHat() {
                  var sticker = document.getElementsByTagName("img");
                  var Hat = sticker[2];
                  ctx.drawImage(Hat, 100, 0, 40, 40);
              }
