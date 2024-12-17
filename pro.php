<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Radio Button Toggle with CSS</title>
    <style>
        .content-div {
            display: none;
        }

        #option1:checked ~ #content-container #div1 {
            display: block;
        }
        #option2:checked ~ #content-container #div2 {
            display: block;
        }
        #option3:checked ~ #content-container #div3 {
            display: block;
        }
    </style>
</head>
<body>

<div id="main-container">
    <input type="radio" name="option" id="option1" value="1">
    <label for="option1">Option 1</label><br>
    <input type="radio" name="option" id="option2" value="2">
    <label for="option2">Option 2</label><br>
    <input type="radio" name="option" id="option3" value="3">
    <label for="option3">Show Both</label><br>

    <div id="content-container">
        <div id="div1" class="content-div">
            This is the content of Div 1.
        </div>
        <div id="div2" class="content-div">
            This is the content of Div 2.
        </div>
        <div id="div3" class="content-div">
            <div id="div1-inner">
                This is the content of Div 1 inside Div 3.
            </div>
            <div id="div2-inner">
                This is the content of Div 2 inside Div 3.
            </div>
        </div>
    </div>
</div>

</body>
</html>