<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enable/Disable Input Example</title>
    <script>
        function toggleInput() {
            // Get the selected value from the dropdown
            var selectElement = document.getElementById("options");
            var textInput = document.getElementById("textInput");

            // Enable or disable the text input based on the selected option
            if (selectElement.value === "enable") {
                textInput.disabled = false; // Enable the text input
            } else {
                textInput.disabled = true; // Disable the text input
                textInput.value = ""; // Clear the text input when disabled
            }
        }
    </script>
</head>
<body>

    <form>
        <label for="options">Select an Option:</label>
        <select id="options" onchange="toggleInput()">
            <option value="disable">Select an option</option>
            <option value="enable">Enable Text Input</option>
            <option value="other">Other Option</option>
        </select>

        <br><br>

        <label for="textInput">Text Input:</label>
        <input type="text" id="textInput" disabled> <!-- Initially disabled -->
    </form>

</body>
</html>
