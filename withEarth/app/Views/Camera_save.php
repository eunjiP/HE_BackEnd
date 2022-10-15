<?php include_once('header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!--<button type="button" onclick="init()"></button>-->
    <div id="webcam-container"></div>
    <div id="label-container"></div>
    <div id="recognize-product"></div>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@1.3.1/dist/tf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@0.8/dist/teachablemachine-image.min.js"></script>

    <script type="text/javascript">
        // More API functions here:
        // https://github.com/googlecreativelab/teachablemachine-community/tree/master/libraries/image

        // the link to your model provided by Teachable Machine export panel
        const URL = "https://teachablemachine.withgoogle.com/models/f1egbWt37/";

        let model, webcam, labelContainer, maxPredictions;

        // Load the image model and setup the webcam
        window.onload = async function() { // 사진(영상)을 인식
            const modelURL = URL + "model.json";
            const metadataURL = URL + "metadata.json";

            // load the model and metadata
            // Refer to tmImage.loadFromFiles() in the API to support files from a file picker
            // or files from your local hard drive
            // Note: the pose library adds "tmImage" object to your window (window.tmImage)
            model = await tmImage.load(modelURL, metadataURL);
            maxPredictions = model.getTotalClasses();

            // Convenience function to setup a webcam
            const flip = true; // whether to flip the webcam
            webcam = new tmImage.Webcam(200, 200, flip); // width, height, flip
            await webcam.setup(); // request access to the webcam
            await webcam.play();
            window.requestAnimationFrame(loop);

            // append elements to the DOM
            document.getElementById("webcam-container").appendChild(webcam.canvas);
            labelContainer = document.getElementById("label-container");
            recognizeProduct = document.getElementById("recognize-product");
            for (let i = 0; i < maxPredictions; i++) { // and class labels
                labelContainer.appendChild(document.createElement("div"));
            }
        }

        async function loop() { //반복해서 사진을 인식
            webcam.update(); // update the webcam frame
            await predict();
            window.requestAnimationFrame(loop);
        }

        // run the webcam image through the image model
        async function predict() { //loop함수를 통해 보여지는 사진을 예측
            // predict can take in an image, video or canvas html element
            const prediction = await model.predict(webcam.canvas);
            //prdiction은 배열형, className은 설정한 이름, probability는 설정한 이름의 확률
            console.log(prediction[0].className);

            for (let i = 0; i < maxPredictions; i++) {
                const classPrediction =
                    prediction[i].className + ": " + prediction[i].probability.toFixed(2);
                labelContainer.childNodes[i].innerHTML = classPrediction;

                //결과에 따라 물품 출력
                if(prediction[i].probability > 0.9){
                    recognizeProduct.innerHTML = "지금 물품은 " + prediction[i].className + "입니다.";
                    // const  = setTimeout(() => {
                    //  location.href = "result?product="+prediction[i].className;
                    // }, 3000);
                }
                
            }
            
        
        }
    </script>
</body>
</html>

<?php include_once('footer.php'); ?>