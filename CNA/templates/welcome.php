
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CDD demo</title>
    <style>
        @import url(//fonts.googleapis.com/css?family=Lato:700);
        body {
            margin: 0;
            font-family: 'Lato', sans-serif;
            text-align: center;
            color: #999;
        }
        .welcome {
            width: 300px;
            height: 200px;
            position: absolute;
            left: 50%;
            top: 50%;
            margin-left: -150px;
            margin-top: -100px;
        }

        h1 {
            font-size: 32px;
            margin: 16px 0 0 0;
        }
    </style>
</head>
<body>
<div class="welcome">
    <h1><?php echo $msg; ?></h1>
</div>
</body>
</html>
