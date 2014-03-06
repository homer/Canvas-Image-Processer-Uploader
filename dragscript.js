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
        $dropzone.addClass("active");
    }
    function handleDragLeave(e){
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

    function makeCanvasImageForId(idString,rawImage,rW,rH,inputElemId) {
        var canvas = document.getElementById(idString);
        var context = canvas.getContext("2d");
        context.drawImage(rawImage,0,0,rW,rH);
        var newCanvasData = canvas.toDataURL("image/jpeg",0.8);
        $("#"+inputElemId).val(newCanvasData);
        $("img#img"+inputElemId).attr("src",newCanvasData);
    }
    $("#btn-resize").on("click",function(){
        var img = document.getElementById("rawImage");
        makeCanvasImageForId("canvas-thumb",img,resizedThumbWidth,resizedThumbHeight,"thumbData");
        makeCanvasImageForId("canvas-large",img,resizedWidth,resizedHeight,"largeData");
    });
});