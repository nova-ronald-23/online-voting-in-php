<!DOCTYPE html>
<html lang="en">
<head>
    <title>SJC</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="popup.css"/>
</head>
<body>
    <div class="container">
        <div class="popup">
            <img src="tick.png">
            <h2>Thank you!</h2>
            <p>You have Successfully Voted for Representative Election</p>
            <a href="logout.php">
                <button type="button" class="btn btn-outline-primary"> OK </button>
            </a>
        </div>
    </div>

    <script>
        function openPopup(){
            var popup = document.querySelector(".popup");
            popup.classList.add("open-popup");
        }

        function closePopup(){
            var popup = document.querySelector(".popup");
            popup.classList.remove("open-popup");
        }

        setTimeout(function() {
            window.location.href = "login.php"; 
        }, 2000); 
    </script>
</body>
</html>
