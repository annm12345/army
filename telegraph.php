<?php
require('top.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    ?>
    <script>
        window.location.href = 'print_telegraph.php?<?php echo http_build_query($_POST); ?>';
    </script>
    <?php
    exit();
}


?>
<style>
    .telegraph-form {
        width: 21cm; /* A4 width */
        height: 29.7cm; /* A4 height */
        margin: 75px auto;
        padding: 20px;
        border: none;
        border-radius: 5px;
        overflow-x: auto; /* Add horizontal scrollbar if needed */
        background-color:#fff;
    }
    .telegraph-form p{
        text-align: center;
        font-size: 15px;
    }

    .top{
        position: relative;
        overflow-y: auto; /* Add vertical scrollbar if needed */
        max-height: 60vh; /* Maximum height to limit vertical scrollbar */
    }
    .top_left{
        display: flex;
        flex-direction: column;
        gap:10px;
    }
    .top_left div{
        display: flex;
        align-items: center;
        gap: 20px;
    }
    .top_left label{
        padding-top:10px;
    }

    .top_right{
        position: absolute;
        top:0px;
        right: 20px;
        display: flex;
        gap: 10px;
        align-items: center;
    }

    input[type="text"] {
        width: calc(100% - 35px); /* Adjusted width for better alignment */
        padding: 10px;
        border: none;
        outline: none;
        border-radius: 5px;
        font-size: 15px;
    }

    label {
        font-size: 15px;
    }

    button {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-bottom:5rem;
    }

    button:hover {
        background-color: #0056b3;
    }

    /* Hide button when printing */
    @media print {
        button {
            display: none;
        }
    }

    /* Additional styles for mobile */
    @media (max-width: 768px) {
        .telegraph-form {
            width: 100%;
            overflow-x: auto;
            overflow-y: auto;
            margin: 50px auto;
        }
    }
    /* Adjust .body style */
    .body {
        margin-top: 20px;
    }
    .body input[type="text"],
    .body textarea {
        width: 100%;
        padding: 10px;
        border: none;
        outline: none;
        border-radius: 5px;
        font-size: 15px;
    }
    .body label {
        font-size: 15px;
    }
    .body div {
        display: flex;
        gap: 20px;
    }
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        text-align: center;
    }

    .close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
    }

    .modal button {
        padding: 10px 20px;
        margin: 10px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .modal button:hover {
        background-color: #45a049;
    }

    .modal button:focus {
        outline: none;
    }


</style>

    <form class="telegraph-form" id="telegraphForm" method="post">
        <p>မှတ်ပုံတင်ကြေးနန်းစာပုံစံ(အစား)</p>
        <div class="top">
            <div class="top_left">
                <div>
                    <label for="firstInput">(ပ)</label><input type="text" id="firstInput" name="firstInput" placeholder="ရတခလရ" style="width: 150px;">
                </div>
                <div>
                    <label for="secondInput">(လ)</label><input type="text" id="secondInput" name="secondInput" placeholder="ရတတမခ" style="width: 150px;">
                </div>
                <div>
                    <label for="thirdInput">(တ)</label><input type="text" id="thirdInput" name="thirdInput" placeholder="တမခ" style="width: 150px;">
                </div>
            </div>
            <div class="top_right">
                <input type="text" id="fourthInput" name="fourthInput" placeholder="၂၀၂၄မေ၀၇၁၆၀၀" style="width: 130px;"> <label for="fourthInput">ချိန်</label>
            </div>
        </div>
        <div class="body">
            <input type="text" id="fiveInput"  name="fiveInput" placeholder="၁ ဦး ၁ လဝ၂။" style="width: 150px;">
            
        </div>
        <div class="body" style="margin-top: 1.3rem;">
            <div>
                <label for="sixInput" style="padding-top: 10px;">၁။</label><textarea type="text" id="sixInput" name="sixInput" placeholder="အကြောင်းအရာအားတိုတိလိုရှင်းရေးသားပါ" style="min-height: 100px;width: 150%;"></textarea>
            </div>
            <div>
                <label for="sevenInput" style="padding-top: 10px;">၂။</label><textarea type="text" id="sevenInput"  name="sevenInput"  placeholder="ရကြောင်းပြန်/သိရှိနိုင်ပါရန်နှင့်လိုအပ်သည်များညွန်ကြားပေးနိုင်ပါရန်တင်ပြအပ်" style="min-height: 100px;width: 100%;"></textarea>
            </div>
        </div>
        <div class="body" style="margin-top: 1.3rem;">
            <div>
                <textarea type="text" id="eigthInput" name="eigthInput" placeholder="စရဖအရာရှိ" ></textarea>
            </div>
            <div>
                <textarea type="text" id="nineInput" name="nineInput" placeholder="ရတခလရ" ></textarea>
            </div>
        </div>
        
    </form>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
        
            <button id="manual">Manual Input</button>
            <button id="voice">Command voice</button>
        </div>
    </div>

    <button onclick="document.querySelector('#telegraphForm').submit()">To Print</button>

    <script>
        // Get the modal
        var modal = document.getElementById("myModal");
        var manualButton = document.getElementById("manual");
        var voiceButton = document.getElementById("voice");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the page finishes loading, open the modal
        window.onload = function() {
            modal.style.display = "block";
        };

        // When the user clicks on <span> (x) or manual button, close the modal
        span.onclick = manualButton.onclick = function() {
            modal.style.display = "none";
        };

        // When the user clicks on the "Command voice" button
        voiceButton.onclick = function() {
            // Start speech-to-text input for each input field sequentially
            modal.style.display = "none";
            speechToTextForInput("firstInput");
        };

        function speechToTextForInput(inputId) {
            recognition = new webkitSpeechRecognition();
            recognition.lang = 'my-MM'; // Specify Burmese language
            recognition.continuous = true; // Enable continuous recognition

            
            recognition.onresult = function(event) {
                var transcript = event.results[0][0].transcript.trim();
                document.getElementById(inputId).value = transcript;
                
                // If there are more inputs, proceed to the next one
                switch (inputId) {
                    case "firstInput":
                        speechToTextForInput("fourthInput");
                        break;
                    case "fourthInput":
                        speechToTextForInput("secondInput");
                        break;
                    case "secondInput":
                        speechToTextForInput("thirdInput");
                        break;
                    // Add more cases for additional inputs if needed
                }
            };
            
            recognition.onerror = function(event) {
                console.error('Speech recognition error:', event.error);
            };
            
            recognition.start();
        }
    </script>
<?php
require('foot.php');
?>