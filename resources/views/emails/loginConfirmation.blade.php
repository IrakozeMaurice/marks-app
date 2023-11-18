<!DOCTYPE html>
<html>

<head>
  <title>ItsolutionStuff.com</title>

  <style>
    a {

      border: 0;
      outline: 0;
      cursor: pointer;
      color: white;
      background-color: rgb(84, 105, 212);
      box-shadow: rgb(0 0 0 / 0%) 0px 0px 0px 0px, rgb(0 0 0 / 0%) 0px 0px 0px 0px, rgb(0 0 0 / 12%) 0px 1px 1px 0px, rgb(84 105 212) 0px 0px 0px 1px, rgb(0 0 0 / 0%) 0px 0px 0px 0px, rgb(0 0 0 / 0%) 0px 0px 0px 0px, rgb(60 66 87 / 8%) 0px 2px 5px 0px;
      border-radius: 4px;
      font-size: 14px;
      font-weight: 500;
      padding: 4px 8px;
      display: inline-block;
      min-height: 28px;
      transition: background-color .24s, box-shadow .24s;

      :hover {
        box-shadow: rgb(0 0 0 / 0%) 0px 0px 0px 0px, rgb(0 0 0 / 0%) 0px 0px 0px 0px, rgb(0 0 0 / 12%) 0px 1px 1px 0px, rgb(84 105 212) 0px 0px 0px 1px, rgb(0 0 0 / 0%) 0px 0px 0px 0px, rgb(60 66 87 / 8%) 0px 3px 9px 0px, rgb(60 66 87 / 8%) 0px 2px 5px 0px;
      }

    }
  </style>
</head>

<body>
  <h1>Click the button to continue</h1>
  <a href="{{ url('/auth/token', $token) }}" style="">
    Login to the app
  </a>
</body>

</html>
