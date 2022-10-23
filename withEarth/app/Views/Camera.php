<?php 
    include_once('header.php');
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@1.3.1/dist/tf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@0.8/dist/teachablemachine-image.min.js"></script>
    <script src="/js/camera.js"></script>
</head>
<body>
    <div id="webcam-container"></div>
    <div id="label-container"></div>
    <div id="loading"></div>
    <button class="pickCamera">checkCamera</button>
    <script>
        init();
        showLoading();
        pickCamera();
    </script>
</body>
</html>

<?php include_once('footer.php'); ?>