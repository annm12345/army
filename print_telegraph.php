
<?php
require('top.php');
// Retrieve the form data
$firstInput = $_GET['firstInput'] ?? '';
$secondInput = $_GET['secondInput'] ?? '';
$thirdInput = $_GET['thirdInput'] ?? '';
$fourthInput = $_GET['fourthInput'] ?? '';
$fiveInput = $_GET['fiveInput'] ?? '';
$sixInput = $_GET['sixInput'] ?? '';
$sevenInput = $_GET['sevenInput'] ?? '';
$eigthInput = $_GET['eigthInput'] ?? '';
$nineInput = $_GET['nineInput'] ?? '';

// You can now use these variables to display the data as needed.
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
</style>

    <form  class="telegraph-form"  id="telegraphForm" method="post">
        <p>မှတ်ပုံတင်ကြေးနန်းစာပုံစံ(အစား)</p>
        <div class="top">
            <div class="top_left">
                <div>
                    <label for="firstInput">(ပ)</label> <label><?php echo $firstInput; ?></label>
                </div>
                <div>
                    <label for="secondInput">(လ)</label><label><?php echo $secondInput; ?></label>
                </div>
                <div>
                    <label for="thirdInput">(တ)</label><label><?php echo $thirdInput; ?></label>
                </div>
            </div>
            <div class="top_right">
                <label><?php echo $fourthInput; ?></label> <label for="fourthInput">ချိန်</label>
            </div>
        </div>
        <div class="body">
            <label><?php echo $fiveInput; ?></label>            
        </div>
        <div class="body" style="margin-top: 1.3rem;">
            <div>
                <label for="sixInput" style="padding-top: 10px;">၁။</label><p><?php echo $sixInput; ?></p>
            </div>
            <div>
                <label for="sevenInput" style="padding-top: 10px;">၂။</label><p><?php echo $sevenInput; ?></p>
            </div>
        </div>
        <div class="body" style="margin-top: 1.3rem;">
            <div>
                <p><?php echo $eigthInput; ?></p>
            </div>
            <div>
                <p><?php echo $nineInput; ?></p>
            </div>
        </div>
        
    </form >
    <script>
        function printForm() {
            document.querySelector("header").style.display = "none";
            // Hide the button before printing
            document.querySelector("button").style.display = "none";
            
            // Print the form
            window.print();
            
            // Restore the hidden elements and button after printing
            document.querySelector("header").style.display = "block";
            document.querySelector("button").style.display = "block";
        }
    </script>
    <!-- Call the printForm() function when clicking -->
    <button onclick="printForm()">Save as Word</button>
    
<?php
require('foot.php');
?>
