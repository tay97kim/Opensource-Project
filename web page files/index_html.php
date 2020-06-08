<?
exec("cd /var/www/html/ai && python3 attendance_info_Baek.py", $out, $return);
exec("cd /var/www/html/ai && python3 attendance_info_Kim.py", $out, $return);
exec("cd /var/www/html/ai && python3 attendance_info_Sin.py", $out, $return);
exec("cd /var/www/html/ai && python3 schedule_info_Baek.py", $out, $return);
exec("cd /var/www/html/ai && python3 schedule_info_Kim.py", $out, $return);
exec("cd /var/www/html/ai && python3 schedule_info_Sin.py", $out, $return);
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
        .cam-box{width : 320px; height : 320px; border : 1px solid; padding : 5px; margin : 10 10 10 10;}
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
        var person = {};
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
                var result1 = confirm('백대현 님이 맞습니까?');
                if (result1 == true ){
                    person.name = "백대현";
                    document.getElementById('dialog-message').setAttribute('title', person.name + '>님이 로그인 되었습니다.');
                    crayBtn1();
                }
                else{
                    webcam.update();
                    window.requestAnimationFrame(loop);
                }

            } else if(prediction[1].className == "SinGS" && prediction[1].probability.toFixed(2) >= 0.90) {
                var result2 = confirm('신규섭 님이 맞습니까?');
                if (result2 == true ){
                    person.name = "신규섭";
                    document.getElementById('dialog-message').setAttribute('title', person.name + '님이 로그인 되었습니다.');
                    crayBtn2();
                }
                else{
                    webcam.update();
                    window.requestAnimationFrame(loop);
                }
            } else if(prediction[2].className == "KimTs" && prediction[2].probability.toFixed(2) >= 0.90) {
                var result3 = confirm('김태성 님이 맞습니까?');
                if (result3 == true ){
                    person.name = "김태성";
                    document.getElementById('dialog-message').setAttribute('title', person.name + '>님이 로그인 되었습니다.');
                    crayBtn3();
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

    function crayBtn1() {
        $('#dialog-message').dialog({
            modal: true,
            width : 330,
            height: 200,
            buttons: {
                "출석정보": function() {
                    readTextFile("attendance_output_Baek.txt");
                    console.log('attendance');
                    alert(allText.test);
                },
                "일정": function() {
                    readTextFile("schedule_info_Baek.txt");
                    console.log('schedule');
                    alert(allText.test);
                },
                    "취소": function() {
                    $(this).dialog('close');
                }
            }
        });
    }
    function crayBtn2() {
        $('#dialog-message').dialog({
            modal: true,
            buttons: {
                "출석정보": function() {
                    readTextFile("attendance_output_Sin.txt");
                    alert(allText.test);
                },
                "일정": function() {
                    readTextFile("schedule_output_Sin.txt");
                    alert(allText.test);
                },
                    "취소": function() {
                    $(this).dialog('close');
                }
            }
        });
    }
    function crayBtn3() {
        $('#dialog-message').dialog({
            modal: true,
            buttons: {
                "출석정보": function() {
                    readTextFile("attendance_output_Kim.txt");
                    alert(allText.test);
                },
                "일정": function() {
                    readTextFile("schedule_output_Kim.txt");
                    alert(allText.test);
                },
                "취소": function() {
                    $(this).dialog('close');
                }
            }
        });
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

    <div id="dialog-message" title="" style='display:none'>원하는 작업을 선택하세요.</div>

</body>