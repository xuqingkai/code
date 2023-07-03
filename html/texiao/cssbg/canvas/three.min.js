<!DOCTYPE html>
<html lang="zh-cn" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
    <title>css background</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        #canvas {
            width: 100%;
            height: auto;
            overflow: hidden;
            position: absolute;
            top: 0;
            left: 0;
            background-color: #1a1724;
        }

        .canvas-wrap {
            position: relative;

        }

        div.canvas-content {
            position: relative;
            z-index: 2000;
            color: #fff;
            text-align: center;
            padding-top: 30px;
        }
    </style>
</head>
<body>
    
    <div id="canvas" style="background: -webkit-gradient(linear, 0% 0%, 100% 0%, from(rgb(255, 13, 196)), to(rgb(182, 117, 84)));"></div>
	<script src="./canvas/three.min.js"></script>
	<script src="./canvas/canvas-renderer.js"></script>
	<script src="./canvas/3d-lines-animation.js"></script>
</body>
</html>
