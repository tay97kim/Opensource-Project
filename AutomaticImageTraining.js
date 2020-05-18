<div>DaeguUniv Automatic Login System</div>
//<button type="button" onclick="init()">Start</button>
<div id="webcam-container"></div>
<div id="label-container"></div>
<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@1.3.1/dist/tf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@0.8/dist/teachablemachine-image.min.js"></script>
<script type="text/javascript">

    const URL = "./my_model/";

    let model, webcam, labelContainer, maxPredictions;

    //이미지 모델을 불러오고 웹 카메라를 구동 (DroidCamApp으로 바꿀 예정)
    async function init() {
        const modelURL = URL + "model.json";
        const metadataURL = URL + "metadata.json";

        //modelURL과 metadataURL 불러오기
        model = await tmImage.load(modelURL, metadataURL);
        maxPredictions = model.getTotalClasses();

        //웹 카메라 셋팅
        const flip = true; // whether to flip the webcam
        webcam = new tmImage.Webcam(400, 400, flip); // width, height, flip
        await webcam.setup(); // request access to the webcam
        await webcam.play();
        window.requestAnimationFrame(loop);

        // 샘플 추가
        document.getElementById("webcam-container").appendChild(webcam.canvas);
        labelContainer = document.getElementById("label-container");
        for (let i = 0; i < maxPredictions; i++) { // and class labels
            labelContainer.appendChild(document.createElement("div"));
        }
    }

    async function loop() {
        webcam.update(); // webcam 루프
        await predict();
        window.requestAnimationFrame(loop);
    }

    //이미지 모델과 웹 카메라 상의 이미지 비교
    async function predict() {
        const prediction = await model.predict(webcam.canvas);
        for (let i = 0; i < maxPredictions; i++) {
            const classPrediction =
                prediction[i].className + ": " + prediction[i].probability.toFixed(2);
            labelContainer.childNodes[i].innerHTML = classPrediction;
        }
    }
</script>
<button type="button" onclick="init()">Start</button>
