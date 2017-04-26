
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function myPrompt() {
  var sentence = prompt("Enter your new ToDo : ");
  sentence = sentence.trim();
  if (sentence != "") {
    var node = document.createElement("DIV");
    var textnode = document.createTextNode(sentence);
    node.appendChild(textnode);
    var list = document.getElementById('ft_list');
    list.insertBefore(node, list.childNodes[0]);
    // setCookie('todo', encodeURIComponent(sentence), 1);
    // console.log(document.cookie);
  }
}

function removeIt() {
  if (confirm("Are you sure you want to remove this item from your list?") == true) {
    var toremove = event.target;
    toremove.parentNode.removeChild(toremove);
  }
}
