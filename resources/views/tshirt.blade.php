<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>T-Shirt Customizer</title>
    <style>
        #tshirt-container {
            position: relative;
            width: 300px; /* Adjust as needed */
            height: 400px; /* Adjust as needed */
            background: url('/path/to/your/tshirt-image.png') no-repeat center center;
            background-size: cover;
        }
        .logo {
            position: absolute;
        }
    </style>
</head>
<body>
    <div id="tshirt-container">
        <img id="logo" class="logo" src="" alt="Logo" style="display: none;">
    </div>

    <form id="customize-form">
        <label for="logo-upload">Upload Logo:</label>
        <input type="file" id="logo-upload" accept="image/*"><br>

        <label for="position">Position:</label>
        <select id="position">
            <option value="front">Front</option>
            <option value="back">Back</option>
            <option value="sleeve">Sleeve</option>
        </select><br>

        <label for="size">Size:</label>
        <input type="number" id="size" min="10" max="100" value="50"><br>

        <label for="color">Color:</label>
        <input type="color" id="color" value="#ffffff"><br>

        <button type="button" id="apply">Apply Changes</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#logo-upload').change(function(e) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#logo').attr('src', e.target.result).show();
                };
                reader.readAsDataURL(e.target.files[0]);
            });

            $('#apply').click(function() {
                const position = $('#position').val();
                const size = $('#size').val();
                const color = $('#color').val();

                // Apply logo size and color
                $('#logo').css({
                    'width': size + 'px',
                    'height': size + 'px',
                    'background-color': color
                });

                // Adjust logo position
                let top, left;
                switch(position) {
                    case 'front':
                        top = '20px'; left = '50px'; // Adjust as needed
                        break;
                    case 'back':
                        top = '20px'; left = '150px'; // Adjust as needed
                        break;
                    case 'sleeve':
                        top = '20px'; left = '250px'; // Adjust as needed
                        break;
                }

                $('#logo').css({
                    'top': top,
                    'left': left
                });
            });
        });
    </script>
</body>
</html>
