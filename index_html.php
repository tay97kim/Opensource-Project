<!DOCTYPE html>
<?
exec("cd /opt/lampp/htdocs/ai && python3 test.py", $out, $status);
$temp = $out[0]
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
	<style type="text/css">
	.cam-box{width : 320px; height : 380px; border : 1px solid; padding : 5px; margin : 10 10 10 10;}
	</style>
</head>
<body> 
    <div style="font-size:1.2em; color:green;"> <center>< DaeguUniv Automatic Login Service ></center></div>  <br>
    <center><div class="cam-box">
	<div id="webcam-container"></div>
	<div id="label-container"></div>
	</div><center>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@1.3.1/dist/tf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@0.8/dist/teachablemachine-image.min.js"></script>
    <script type="text/javascript">
	
	
        // More API functions here:
        // https://github.com/googlecreativelab/teachablemachine-community/tree/master/libraries/image
    
        // the link to your model provided by Teachable Machine export panel
        const URL = "./my_model/";
    
        let model, webcam, labelContainer, maxPredictions;
	var sName;
        // Load the image model and setup the webcam
        async function init() {
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
            webcam = new tmImage.Webcam(320, 320, flip); // width, height, flip
            await webcam.setup(); // request access to the webcam
            await webcam.play();
            window.requestAnimationFrame(loop);
    
            // append elements to the DOM
            document.getElementById("webcam-container").appendChild(webcam.canvas);
            labelContainer = document.getElementById("label-container");
            for (let i = 0; i < maxPredictions; i++) { // and class labels
                labelContainer.appendChild(document.createElement("div"));
            }
        }

        async function loop() {
	webcam.update(); // update the webcam frame
//async function predict() {
        // predict can take in an image, video or canvas html element
		
	const prediction = await model.predict(webcam.canvas);

        if(prediction[0].className == "BaekDH" && prediction[0].probability.toFixed(2) >= 0.95) {
            labelContainer.childNodes[0].innerHTML = "BaekDH"
		var result = confirm('baek?');
		if (result == true ){
		var test = '<?= $temp?>'
		 labelContainer.childNodes[1].innerHTML = test
		}
		else{
			webcam.update();
			window.requestAnimationFrame(loop);
		}
			
	} else if(prediction[1].className == "SinGS" && prediction[1].probability.toFixed(2) >= 0.95) {
            labelContainer.childNodes[0].innerHTML = "SinGS"
		confirm('Sin?');
		if (result == true ){
		var test = '<?= $temp?>'
		 labelContainer.childNodes[1].innerHTML = test
		}
		else{
			webcam.update();
			window.requestAnimationFrame(loop);
		}
        } else if(prediction[2].className == "KimTs" && prediction[2].probability.toFixed(2) >= 0.95) {
            labelContainer.childNodes[0].innerHTML = "KimTS"
		confirm('kim?');
		if (result == true ){
		var test = '<?= $temp?>'
		 labelContainer.childNodes[1].innerHTML = test
		}
		else{
			webcam.update();
			window.requestAnimationFrame(loop);
		}
        }
	 else{          
	//await predict();
            window.requestAnimationFrame(loop);
        }



        // run the webcam image through the image model
        /*async function predict() {
        // predict can take in an image, video or canvas html element
        const prediction = await model.predict(webcam.canvas);
        if(prediction[0].className == "BaekDH" && prediction[0].probability.toFixed(2) >= 0.95) {
            labelContainer.childNodes[0].innerHTML = "BaekDH"
		setTimeout(function() {
		confirm('baek?');
		}, 3000);
	} else if(prediction[1].className == "SinGS" && prediction[1].probability.toFixed(2) >= 0.95) {
            labelContainer.childNodes[0].innerHTML = "SinGS"
		setTimeout(function() {
		confirm('Sin?');
		}, 3000);
        } else if(prediction[2].className == "KimTs" && prediction[2].probability.toFixed(2) >= 0.95) {
            labelContainer.childNodes[0].innerHTML = "KimTS"
		setTimeout(function() {
		confirm('kim?');
		}, 3000);
        }
	 else {
		labelContainer.childNodes[0].innerHTML = "asd"
		setTimeout(function() {
		confirm('asd?');
		}, 3000);
	}*/
        // for (let i = 0; i < maxPredictions; i++) {
        //     const classPrediction =
        //         prediction[i].className + ": " + prediction[i].probability.toFixed(2);
        //     labelContainer.childNodes[i].innerHTML = classPrediction;
        // }
    }
    </script>
	<center> <button type="button" style="padding:10px 150px;" onclick="init()">Start</button> </center>
  <!-- Footer -->
      <footer>
        <div class="container">
          <div class="">
          </div>
        </div>
      </footer>
    </div>
</body>
