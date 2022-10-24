
    // More API functions here:
    // https://github.com/googlecreativelab/teachablemachine-community/tree/master/libraries/image

    // the link to your model provided by Teachable Machine export panel
    // 재촬영후 URL 수정 해야됨
    const URL = "https://teachablemachine.withgoogle.com/models/f1egbWt37/";

    // 로딩
    const loading = () => {
        const Loading = document.querySelector(".loading");
        const pickCamera = document.querySelector(".pickCamera");
        Loading.classList.toggle('d-none');
        pickCamera.classList.toggle('d-none');
    }

    // 이미지 모델 관련 변수 선언
    let model, webcam, labelContainer, maxPredictions;

    // 이미지 모델 불러오기, 웹캠 띄우기
    // Load the image model and setup the webcam
    async function init() {
        const modelURL = URL + "model.json";
        const metadataURL = URL + "metadata.json";

        // load the model and metadata
        // Refer to tmImage.loadFromFiles() in the API to support files from a file picker
        // or files from your local hard drive
        // Note: the pose library adds "tmImage" object to your window (window.tmImage)
        model = await tmImage.load(modelURL, metadataURL);
        maxPredictions = model.getTotalClasses(); // 이미지 모델 갯수

        // Convenience function to setup a webcam
        // 웹캠 셋업
        const flip = true; // whether to flip the webcam
        webcam = new tmImage.Webcam(200, 200, flip); // width, height, flip
        await webcam.setup(); // request access to the webcam
        await webcam.play();
        window.requestAnimationFrame(loop);
        loading();

        // 웹캠 생성
        document.getElementById("webcam-container").appendChild(webcam.canvas);
        labelContainer = document.getElementById("label-container");
        for (let i = 0; i < maxPredictions; i++) { // and class labels
            labelContainer.appendChild(document.createElement("div"));
        }
    }

    // 웹캠 루프
    async function loop() {
        webcam.update(); // update the webcam frame
        await predict();
        window.requestAnimationFrame(loop);
    }

    // run the webcam image through the image model
    // 각 이미지별 확률 분석한 걸 div에 출력 (사용 안해도 될거 같긴함, loop 함수에서 await로 사용해서 일단 냅둠)
    async function predict() {
        // predict can take in an image, video or canvas html element
        const prediction = await model.predict(webcam.canvas);
        // for (let i = 0; i < maxPredictions; i++) {
        //     const classPrediction =
        //         prediction[i].className + ": " + prediction[i].probability.toFixed(2);
        //     labelContainer.childNodes[i].innerHTML = classPrediction;
        // }
    }

    // 버튼 누르면 인식 -> 결과 전송 및 페이지 전환
    const pickCamera = () => {
        const pickCamera = document.querySelector(".pickCamera");
        pickCamera.addEventListener("click", async () => {
            let pickPre = await model.predict(webcam.canvas);
            // console.log(pickPre);
            // for (let i = 0; i < maxPredictions; i++) {
            //     if(pickPre[i].probability > 0.8){
            //         location.href = "result?product="+pickPre[i].className;
            //         console.log(pickPre[i]);
            //     } else {
            //         console.log("물품을 더 가까이 접근시켜주세요");
            //     }
            // }
            if(pickPre[0].probability > 0.8){
                location.href = "result?product="+pickPre[0].className;
            } else if (pickPre[1].probability > 0.8){
                location.href = "result?product="+pickPre[1].className;
            } else if (pickPre[2].probability > 0.8){
                location.href = "result?product="+pickPre[2].className;
            } else {
                console.log("물품을 더 가까이 접근시켜주세요");
            }
            
            }   
        )
    }
        
    