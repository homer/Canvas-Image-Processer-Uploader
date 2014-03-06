<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <title>File Uploader</title>
    <style>
        .drop-area{
            position: relative;
            width:300px;
            height:300px;
            color:#961F30;
            background-color: #CC2A41;
            text-align: center;
            border: 10px dashed #961F30;
        }
        .drop-area.active{
            cursor:copy;
            color:#424254;
            border: 10px dashed #424254;
            background-color: #6E6E8C;
        }
        #dropImg{
            max-height: 100%;
            max-width: 100%;
        }
        .is-hidden{
            display: none !important;
        }
        #rawImage,#canvas-large,#canvas-thumb{
            display: none;
        }
    </style>
</head>

<body>
    <form method="post" action="upload.php">
        <h1>Hello World!</h1>

        <label for="filename">File Name:</label>
        <input id="filename" type="text" name="filename"/><br/>

        <label for="filetype">File Type:</label>
        <input id="filetype" type="text" name="filetype"/><br/>

        <label for="filesize">File Size</label>
        <input id="filesize" type="number" name="filesize"/><br/>

        <label for="filewidth">Original Dimensions</label>
        <input id="filewidth" type="text" name="filewidth"/> x <input id="fileheight" type="text" name="fileheight"/>

        <div id="dropzone" class="drop-area">
            <img id="dropImg" class="is-hidden" src="">
        </div>

        <input id="thumbData" type="hidden" name="imgthumb"/>
        <input id="largeData"type="hidden" name="imglarge"/>

        <input type="submit" value="Gonder"/>
    </form>

    <button id="btn-resize">Resize Images</button>
    <br/>
    <img id="thumb"/>
    <img id="large"/>
    <canvas id="canvas-thumb"></canvas>
    <canvas id="canvas-large"></canvas>


</body>
<script>
    $(function(){
        $dropzone = $("#dropzone");

        var originalWidth;
        var originalHeight;
        var resizedWidth = 1200;
        var resizedHeight;
        var resizedThumbWidth = 500;
        var resizedThumbHeight;

        function makeCanvasForWidth() {
            resizedHeight = Math.round( (resizedWidth * originalHeight) / originalWidth );
            resizedThumbHeight = Math.round( (resizedThumbWidth * originalHeight) / originalWidth );

            var canvasLarge = document.getElementById("canvas-large");
            canvasLarge.width = resizedWidth;
            canvasLarge.height = resizedHeight;

            var canvasThumb = document.getElementById("canvas-thumb");
            canvasThumb.width = resizedThumbWidth;
            canvasThumb.height = resizedThumbHeight;
        }
        function handleDragEnter(e){
            $("#drop-icon").addClass("is-hidden");
            $dropzone.addClass("active");
        }
        function handleDragLeave(e){
            $("#drop-icon").removeClass("is-hidden");
            $dropzone.removeClass("active");
        }
        function handleDragOver(e){
            e.stopPropagation();
            e.preventDefault();
        }
        function handleDrop(e){
            e.stopPropagation();
            e.preventDefault();
            $dropzone.removeClass("active");

            var thefile = e.dataTransfer.files[0];

            $("#filename").val(e.dataTransfer.files[0].name);
            $("#filetype").val(e.dataTransfer.files[0].type);
            $("#filesize").val(e.dataTransfer.files[0].size);

            if(!thefile.type.match("image.*")){ return; }

            var reader = new FileReader();
            reader.onload = function (evt){
                var imgBox = document.getElementById('dropImg');
                imgBox.src = evt.target.result;
                imgBox.className = "";

                var img = new Image;
                img.src = evt.target.result;
                img.onload = function() {
                    originalWidth = img.width;
                    originalHeight = img.height;
                    $("#filewidth").val(originalWidth);
                    $("#fileheight").val(originalHeight);

                    makeCanvasForWidth();

                    this.id = "rawImage";
                    this.width = resizedWidth;
                    this.height= resizedHeight;
                    $(this).appendTo("body");
                };
            }
            reader.readAsDataURL(thefile);
        }
        document.getElementById('dropzone').addEventListener('dragenter',handleDragEnter,false);
        document.getElementById('dropzone').addEventListener('dragleave',handleDragLeave,false);
        document.getElementById("dropzone").addEventListener("dragover",handleDragOver,false);
        document.getElementById('dropzone').addEventListener('drop',handleDrop,false);


        $("#btn-resize").on("click",function(){
            var canvas = document.getElementById("canvas-large");
            var context = canvas.getContext("2d");

            var canvasThumb = document.getElementById("canvas-thumb");
            var contextThumb = canvasThumb.getContext("2d");

            var img = document.getElementById("rawImage");

            context.drawImage(img,0,0,resizedWidth,resizedHeight);
            contextThumb.drawImage(img,0,0,resizedThumbWidth,resizedThumbHeight);

            var newCanvasData = canvas.toDataURL("image/jpeg",0.8);
            var newThumbCanvasData = canvasThumb.toDataURL("image/jpeg",0.8);

            $("#thumbData").val(newThumbCanvasData);
            $("#largeData").val(newCanvasData);

            $("img#large").attr("src",newCanvasData);
            $("img#thumb").attr("src",newThumbCanvasData);
        });
    });
</script>
</html>