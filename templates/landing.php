<!DOCTYPE html>
<html>
<head>
  <title>RESTFul Emoji API</title>
  <link href='https://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" type="text/css" href="/css/style.css">
  <script type="text/javascript" src='/js/nanoajax.min.js'></script>
  <script type="text/javascript" src='/js/app.js'></script>
</head>
<body>
	<div class="content">
    <h1 class="centered">RestMoji</h1>
    <p class="centered">
      Are you authenticated?
    </p>
    <br>
    <div class="centered">
      <input type="text" placeholder=" username" id="username" />
        <br><br>
      <button id="get_token" onclick="getToken()">Get Token</button>
    </div>

    <!-- Render login JSON once available -->
    <div id="display" class="centered">
      
    </div>

    <!-- Show some of the API methods -->
    <div class="centered">
      <table class="centered">
        <thead>
          <th>Method</th>
          <th>URL</th>
          <th>Function</th>
          <th>Publicly accessible</th>
        </thead>
        <tbody>
          <tr>
            <td>POST</td>
            <td>/auth/login</td>
            <td>Logs in a user.</td>
            <td>TRUE</td>
          </tr>
          <tr>
            <td>GET</td>
            <td>/auth/logout</td>
            <td>Logs a user out</td>
            <td>FALSE</td>
          </tr>
          <tr>
            <td>POST</td>
            <td>/emojis</td>
            <td>Create an emoji</td>
            <td>FALSE</td>
          </tr>
          <tr>
            <td>GET</td>
            <td>/emojis/</td>
            <td>Get all the emojis</td>
            <td>TRUE</td>
          </tr>
          <tr>
            <td>GET</td>
            <td>/emojis/{id}</td>
            <td>Retreive an emoji of {id}</td>
            <td>TRUE</td>
          </tr>
          <tr>
            <td>PATCH</td>
            <td>/emojis/{id}</td>
            <td>Partially update an emoji of {id}</td>
            <td>FALSE</td>
          </tr>
          <tr>
            <td>PUT</td>
            <td>/emojis/{id}</td>
            <td>Fully update an emoji of {id}</td>
            <td>FALSE</td>
          </tr>
          <tr>
            <td>DELETE</td>
            <td>/emojis/{id}</td>
            <td>Delete an emoji of {id}</td>
            <td>FALSE</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
