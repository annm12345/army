<?php
require('top.php');
?>
<meta name="viewport" content="width=device-width, initial-scale=1">

        <main>
            <!--=============== HOME ===============-->
            <section class="container section section__height" id="home">
                <div class="search-container">
                    <h2>သိလိုသောအကြောင်းအရာ၊ ခိုင်းစေလိုသောအကြောင်းအရာများအား စာဖြင့်ဖြစ်စေ ၊ command voice ဖြင့်ဖြစ်စေ ရှာဖွေခိုင်းစေနိုင်သည်။</h2>
                </div>
                <div class="search-container">
                    <textarea class="search-input" placeholder="Search..."></textarea>
                    <i class="fa-solid fa-paper-plane"></i>
                    <i class="fa-solid fa-microphone" id="microphone" style="font-size:20px;"></i>
                    <div id="voice-recorder" class="voice-recorder hidden">
                        <p class="heading">Command By Voice</p>
                        <div class="line"></div>
                        <button id="startBtn" style="border:none;">
                            <div class="icon">
                                <ion-icon name="mic-outline" style="color:blue;background:lightgray;padding:1rem;border-radius:50%;"></ion-icon>
                                <!-- <div class="voice-wave"></div> Added voice-wave element -->
                            </div>
                        </button>
                        <p class="recording-status">Click to Start Recording</p>
                        <p class="heading" id="output">Result :</p>
                    </div>      
                    
                </div>
                <div class="category-container">
                     <div class="category">
                        <a href="">တပ်များ</a>
                     </div> 
                     <div class="category">
                        <a href="">စစ်ဦးစီး</a>
                     </div>
                     <div class="category">
                        <a href="">စစ်ရေး</a>
                     </div>
                     <div class="category">
                        <a href="">စစ်ထောက်</a>
                     </div>
                     <div class="category">
                        <a href="">စစ်ရေးသတင်းများ</a>
                     </div> 
                     <div class="category">
                        <a href="">ညွန်ကြားချက်များ</a>
                     </div>  
                     <div class="category">
                        <a href="">စစ်ဆင်ရေးမြေပုံ</a>
                     </div> 
                     <div class="category">
                        <a href="">လုပ်ဆောင်ချက်များ</a>
                     </div>
                    
                </div>
                
            </section>
            <!-- IONICONS -->

                <script
                type="module"
                src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"
            ></script>
            <script
                nomodule
                src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"
            ></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script>
                const recordingStatus = document.querySelector('.recording-status');
                const finalResult = document.querySelector('.result');

                document.getElementById('microphone').addEventListener('click', function(event) {
                    event.preventDefault(); // Prevent default touch behavior
                    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                        // Toggle the visibility of the voice recorder
                        document.getElementById('voice-recorder').classList.toggle('hidden');
                    } else {
                        console.error('getUserMedia is not supported in this browser.');
                        // Display an error message to the user
                        recordingStatus.textContent = 'Error: Microphone access is not supported in this browser.';
                    }
                });
                const startBtn = document.getElementById('startBtn');
                const output = document.getElementById('output');
                const recognition = new webkitSpeechRecognition(); // For Chrome, you might need to use webkit prefix.

                recognition.lang = 'my-MM'; // Setting language to Burmese

                startBtn.addEventListener('click', () => {
                startBtn.style.display = 'none';
                recordingStatus.textContent = 'Listening for speech...';
                recognition.start();
                });

                recognition.onresult = (event) => {
                const result = event.results[0][0].transcript;
                output.textContent = result;
                sendData(result); // Send the recognized text to the PHP script
                };

                recognition.onend = () => {
                startBtn.style.display = 'inline-block'; // Show the start button again after stopping recording
                };

                recognition.onerror = (event) => {
                console.error('Speech recognition error detected: ' + event.error);
                };

                function sendData(transcript) {
                $.ajax({
                    url: 'text.php',
                    type: 'GET',
                    data: { transcript: transcript },
                    success: function(response) {
                    // Assuming your response contains the predictedLabel
                    const predictedLabel = response.predictedLabel;
                    console.log('Predicted label:', predictedLabel);
                    
                    // Do something with the predictedLabel
                    // For example, updating an element with the predicted label
                    if(predictedLabel === 'မြေပုံ') {
                        window.location.href = 'mm.php';
                    } else if(predictedLabel === 'ကြေးနန်း') {
                        window.location.href = 'telegraph.php';
                    } 
                    },
                    error: function(xhr, status, error) {
                    console.error('Error:', error);
                    }
                });
                }

                // function startSpeechToText() {
                //     if (window.SpeechRecognition || window.webkitSpeechRecognition) {
                //         const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
                //         recognition.lang = 'my'; // Set language to Burmese (Myanmar)
                        
                //         recognition.onstart = function() {
                //             console.log('Speech recognition started.');
                //             recordingStatus.textContent = 'Listening for speech...';
                //         };
                        
                //         recognition.onresult = function(event) {
                //             const transcript = event.results[0][0].transcript;
                //             console.log('Speech recognition result:', transcript);
                            
                //             // Sending the transcript to text.php using AJAX
                //             $.ajax({
                //                 url: 'text.php',
                //                 type: 'GET',
                //                 data: { transcript: transcript },
                //                 success: function(response) {
                //                     // Assuming your response contains the predictedLabel
                //                     const predictedLabel = response.predictedLabel;
                //                     console.log('Predicted label:', predictedLabel);
                                    
                //                     // Do something with the predictedLabel
                //                     // For example, updating an element with the predicted label
                //                     if(predictedLabel=='မြေပုံ'){
                //                         window.location.href = 'mm.php';
                //                     } else if(predictedLabel=='ကြေးနန်း'){
                //                         window.location.href = 'telegraph.php';
                //                     } 
                //                 },
                //                 error: function(xhr, status, error) {
                //                     console.error('Error:', error);
                //                 }
                //             });
                //         };



                //         recognition.onerror = function(event) {
                //             console.error('Speech recognition error:', event.error);
                //             recordingStatus.textContent = 'Error: Speech recognition failed.';
                //         };
                        
                //         // Start speech recognition
                //         recognition.start();
                //     } else {
                //         console.error('Speech recognition is not supported in this browser.');
                //         // Display an error message to the user
                //         recordingStatus.textContent = 'Error: Speech recognition is not supported in this browser.';
                //     }
                // }



                // Check for browser support
                // if ('SpeechRecognition' in window || 'webkitSpeechRecognition' in window) {
                //     const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
                //     const interimResult = document.querySelector('.interim');
                //     const finalResult = document.querySelector('.result');
                //     const recordingStatus = document.querySelector('.recording-status'); // Get the recording status element

                //     recognition.continuous = true;
                //     recognition.interimResults = true;
                //     recognition.lang = 'my-MM'; // Set language to Burmese

                //     recognition.onstart = function() {
                //         console.log('Speech recognition started');
                //         recordingStatus.textContent = 'Recording Started'; // Update recording status
                //     };

                //     recognition.onresult = function(event) {
                //         let interimTranscript = '';
                //         let finalTranscript = '';

                //         for (let i = event.resultIndex; i < event.results.length; i++) {
                //             const transcript = event.results[i][0].transcript;
                //             if (event.results[i].isFinal) {
                //                 finalTranscript += transcript;
                //             } else {
                //                 interimTranscript += transcript;
                //             }
                //         }

                //         interimResult.textContent = interimTranscript;
                //         finalResult.textContent = finalTranscript;

                //         // Redirect to go.php once speech recognition ends and final transcript is available
                //         if (event.results.length && event.results[event.results.length - 1].isFinal) {
                //             // Remove empty spaces, dots, and commas from the transcript
                //             const cleanedTranscript = finalResult.textContent.trim().replace(/[.,\s]/g, '');
                            
                //             // Encode the cleaned transcript and redirect
                //             window.location.href = 'text.php?transcript=' + encodeURIComponent(cleanedTranscript);
                //         }
                //     };

                //     recognition.onend = function() {
                //         console.log('Speech recognition ended');
                //         recordingStatus.textContent = 'Click to Start Recording'; // Update recording status
                //     };

                //     recognition.onerror = function(event) {
                //         console.error('Speech recognition error:', event.error);
                //     };

                //     let isRecording = false; // Variable to track recording state

                //     document.querySelector('.record').addEventListener('click', function() {
                //         const iconContainer = document.querySelector('.record');
                //         iconContainer.classList.toggle('active');

                //         if (!isRecording) {
                //             // Start recording
                //             recognition.start();
                //             isRecording = true;
                //         } else {
                //             // Stop recording
                //             recognition.stop();
                //             isRecording = false;
                //         }
                //     });
                // } else {
                //     console.error('Speech recognition not supported');
                // }
            </script>
            
            

            <!--=============== ABOUT ===============-->
            <section class="container section section__height" id="about">
                <h2 class="section__title">About</h2>
            </section>

            <!--=============== SKILLS ===============-->
            <section class="container section section__height" id="skills">
                <h2 class="section__title">Skills</h2>
            </section>

            <!--=============== PORTFOLIO ===============-->
            <section class="container section section__height" id="portfolio">
                <h2 class="section__title">Portfolio</h2>
            </section>

            <!--=============== CONTACTME ===============-->
            <section class="container section section__height" id="contactme">
                <h2 class="section__title">Contactme</h2>
            </section>
        </main>
        
<?php
require('foot.php')
 ?>