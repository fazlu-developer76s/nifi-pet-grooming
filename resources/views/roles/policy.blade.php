<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Terms and Conditions</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      line-height: 1.6;
      margin: 0;
      padding: 0;
      background-color: #f8f9fa;
    }

    .container {
      max-width: 800px;
      margin: 50px auto;
      background-color: #ffffff;
      padding: 30px 40px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
    }

    h1, h2 {
      color: #343a40;
    }

    p {
      color: #555;
      margin-bottom: 1em;
    }

    ul {
      margin-left: 20px;
    }

    footer {
      text-align: center;
      margin-top: 50px;
      font-size: 14px;
      color: #888;
    }
    h1{
        text-align:center;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>{{ $page->title }}</h1>
    <div>
      {!! $page->paragraph !!}



    </div>




  </div>

  <footer>
    &copy; 2025 Royal Pet Grooming . All rights reserved.
  </footer>
</body>
</html>
