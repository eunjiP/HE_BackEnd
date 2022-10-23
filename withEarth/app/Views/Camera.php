<?php 
    include_once('header.php');
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/camera.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@1.3.1/dist/tf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@0.8/dist/teachablemachine-image.min.js"></script>
    <script src="/js/camera.js"></script>
    <title>Document</title>
</head>
<body>
    <div id="webcam-container"></div>
    <div id="label-container"></div>
    <div class="loading">로딩중입니다.</div>
    <button class="pickCamera d-none">checkCamera</button>
    <script>
        init();
        pickCamera();
    </script>
</body>
</html>

<?php include_once('footer.php'); ?>