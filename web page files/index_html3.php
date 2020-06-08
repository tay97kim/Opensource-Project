<?
/*exec("cd /var/www/html/ai && python3 attendance_info_Baek.py", $out, $return);
exec("cd /var/www/html/ai && python3 attendance_info_Kim.py", $out, $return);
exec("cd /var/www/html/ai && python3 attendance_info_Sin.py", $out, $return);
exec("cd /var/www/html/ai && python3 schedule_info_Baek.py", $out, $return);
exec("cd /var/www/html/ai && python3 schedule_info_Kim.py", $out, $return);
exec("cd /var/www/html/ai && python3 schedule_info_Sin.py", $out, $return);
*/
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
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
        const URL = "./my_model/";
        let model, webcam, labelContainer, maxPredictions;
        var sName;
        var allText = {};
        async function init() {
            const modelURL = URL + "model.json";
            const metadataURL = URL + "metadata.json";
            model = await tmImage.load(modelURL, metadataURL);
            maxPredictions = model.getTotalClasses();

            const flip = true; 
            webcam = new tmImage.Webcam(320, 320, flip); 
            await webcam.setup();
            await webcam.play();
	    window.requestAnimationFrame(loop);

            document.getElementById("webcam-container").appendChild(webcam.canvas);
            labelContainer = document.getElementById("label-container");
            for (let i = 0; i < maxPredictions; i++) { 
                labelContainer.appendChild(document.createElement("div"));
            }
        }

        async function loop() {
	        webcam.update();
	        const prediction = await model.predict(webcam.canvas);

            if(prediction[0].className == "BaekDH" && prediction[0].probability.toFixed(2) >= 0.90) {
                labelContainer.childNodes[0].innerHTML = "BaekDH"
                var result1 = confirm('baek?');
		if (result1 == true ){
			var result11 = confirm('true = attendance information / false = schedule information');
			if(result11 == true) {
				readTextFile("attendance_output_Baek.txt")
			} else {
				readTextFile("schedule_output_Baek.txt")
			}	
		}
		else{
			webcam.update();
			window.requestAnimationFrame(loop);
		}
			
	        } else if(prediction[1].className == "SinGS" && prediction[1].probability.toFixed(2) >= 0.90) {
            		labelContainer.childNodes[0].innerHTML = "SinGS"
		        var result2 = confirm('Sin?');
	    		if (result2 == true ){
		    		var result22 = confirm('true = attendance information / false = schedule information');
				if(result22 == true){
					readTextFile("attendance_output_Sin.txt")
				} else {
					readTextFile("schedule_output_Sin.txt")
				}
			}
		        else{
			        webcam.update();
			        window.requestAnimationFrame(loop);
			}
            } else if(prediction[2].className == "KimTs" && prediction[2].probability.toFixed(2) >= 0.90) {
                labelContainer.childNodes[0].innerHTML = "KimTS"
		var result3 = confirm('kim?');
		if (result3 == true ){
			var result33 = confirm('true = attendance information / false = schedule information');
			if(result33 == true) {
				readTextFile("attendance_output_Kim.txt")
			}else {
				readTextFile("attendance_output_Kim.txt")
			}
		}
		else{
			webcam.update();
			window.requestAnimationFrame(loop);
		}
            }
	         else{          
                window.requestAnimationFrame(loop);
            }
        }
        async function readTextFile(file)
        {
            var rawFile = new XMLHttpRequest();
            rawFile.open("GET", file, false);
            rawFile.onreadystatechange = function ()
            {
            if(rawFile.readyState === 4)
            {
                if(rawFile.status === 200 || rawFile.status == 0)
                {
                    allText.test = rawFile.responseText;
                    //alert(allText);
			                    
                }
            }
        }
    rawFile.send(null);
    }
    }   
    </script>
    <center> <button type="button" style="padding:10px 150px;" onclick="init()">Start</button> </center> <br/>
    <div id="asd"></div>
  <!-- Footer -->
      <footer>
        <div class="container">
          <div class="">
          </div>
        </div>
      </footer>
    </div>
    
</body>
