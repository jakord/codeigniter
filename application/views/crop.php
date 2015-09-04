<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="<?php base_url()?>/css/default.css">
    <link rel="stylesheet" type="text/css" href="<?php base_url()?>/css/default.css"
<body>

<div id="page">

    <div class="block_main rounded">
        <h2>Crop</h2>
        <p><img id="photo" src="<?php base_url()?>/image/<?php echo $img?>" alt="" title="" style="margin: 0 0 0 10px;" /></p>

        <form action="" method="post">
            <input type="hidden" name="x1" value="" />
            <input type="hidden" name="y1" value="" />
            <input type="hidden" name="x2" value="" />
            <input type="hidden" name="y2" value="" />
            <input type="hidden" name="w" value="" />
            <input type="hidden" name="h" value="" />
            <input type="submit" name="crop" value="Crop" />
        </form>


        <script type="text/javascript" src="<?php base_url()?>/js/jquery-1.5.1.min.js"></script>
        <script type="text/javascript" src="<?php base_url()?>/js/jquery.imgareaselect.pack.js"></script>
        <script type="text/javascript">
            function preview(img, selection) {
                var scaleX = 100 / (selection.width || 1);
                var scaleY = 100 / (selection.height || 1);
                $('#photo + div > img').css({
                    width: Math.round(scaleX * 600) + 'px',
                    height: Math.round(scaleY * 400) + 'px',
                    marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
                    marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
                });
            }
            $(document).ready(function () {
                $('<div><img src="<?php base_url()?>/image/<?php echo $img?>" style="position: relative;" /><div>') .css({
                    float: 'left',
                    position: 'relative',
                    overflow: 'hidden',
                    width: '120px',
                    height: '120px'
                }) .insertAfter($('#photo'));

                $('#photo').imgAreaSelect({
                    aspectRatio: '1:1',
                    handles: true,
                    onSelectChange: preview,
                    onSelectEnd: function ( image, selection ) {
                        $('input[name=x1]').val(selection.x1);
                        $('input[name=y1]').val(selection.y1);
                        $('input[name=x2]').val(selection.x2);
                        $('input[name=y2]').val(selection.y2);
                        $('input[name=w]').val(selection.width);
                        $('input[name=h]').val(selection.height);
                    }
                });
            });
        </script>