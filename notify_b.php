<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notify Users</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-box {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        input, button {
            margin: 10px 0;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .notification {
            display: none;
            margin-top: 10px;
            font-size: 16px;
            color: green;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="form-box">
    <h2>Notify Students for Bill Payment</h2>
    <form id="notifyForm">
        <input type="number" name="month" placeholder="Month (1-12)" min="1" max="12" required>
        <input type="number" name="year" placeholder="Year (e.g. 2024)" required>
        <button type="submit">Send Notifications</button>
        <p class="notification"></p>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#notifyForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the form from submitting traditionally

            $.ajax({
                url: 'notifyb.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    let res = JSON.parse(response);
                    if (res.status === 'success') {
                        $('.notification').text(res.message).css('color', 'green').fadeIn();
                    } else {
                        $('.notification').text(res.message).css('color', 'red').fadeIn();
                    }
                },
                error: function() {
                    $('.notification').text('Error sending notifications.').css('color', 'red').fadeIn();
                }
            });
        });
    });
</script>

</body>
</html>
