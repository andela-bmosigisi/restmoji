// Receives syntaxHighlight(JSON.stringify(json))
function output(inp) {
  var display = document.getElementById('display');
  display.innerHTML = '';
  var pre = document.createElement('pre');
  pre.innerHTML = inp;
  display.appendChild(pre);
}

function syntaxHighlight(json) {
  json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
  return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
    var cls = 'number';
    if (/^"/.test(match)) {
      if (/:$/.test(match)) {
        cls = 'key';
      } else {
        cls = 'string';
      }
    } else if (/true|false/.test(match)) {
      cls = 'boolean';
    } else if (/null/.test(match)) {
      cls = 'null';
    }
    return '<span class="' + cls + '">' + match + '</span>';
  });
}

getToken = function() {
  var username = document.getElementById('username').value;
  if (!username) {
    output(syntaxHighlight('{"error" : "Provide a username"}'));
    return;
  }

  nanoajax.ajax(
    {
      url: '/auth/login',
      method: 'POST',
      body: 'username=' + username
    }, 
    function (code, responseText) {
      output(syntaxHighlight(responseText));  
    }
  );
};