<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <script src="dragscript.js"></script>
    <link rel="stylesheet" href="drapstyle.css"/>
    <title>File Uploader</title>

</head>

<body>
    <form method="post" action="upload.php">
        <h1>Obsilaratory Ex.</h1>

        <label for="filename">File Name:</label>
        <input id="filename" type="text" name="filename"/><br/>

        <label for="filetype">File Type:</label>
        <input id="filetype" type="text" name="filetype"/><br/>

        <label for="filesize">File Size</label>
        <input id="filesize" type="number" name="filesize"/><br/>

        <label for="filewidth">Original Dimensions</label>
        <input id="filewidth" type="text" name="filewidth"/>x
        <input id="fileheight" type="text" name="fileheight"/>

        <div id="dropzone" class="drop-area">
            <img id="dropImg" class="is-hidden" src="">
        </div>

        <input id="thumbData" type="hidden" name="imgthumb"/>
        <input id="largeData"type="hidden" name="imglarge"/>

        <input type="submit" value="Gonder"/>
    </form>

    <button id="btn-resize">Resize Images</button>
    <br/>
    <img id="imgthumbData"/>
    <img id="imglargeData"/>
    <canvas id="canvas-thumb"></canvas>
    <canvas id="canvas-large"></canvas>
</body>
</html>