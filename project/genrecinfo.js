function objToString(obj) {
  return Object.entries(obj).reduce((str, [p, val]) => {
    return `${str}${p}::${val}\n`;
  }, '');
}

function get(name) {
  if (name = (new RegExp('[?&]' + encodeURIComponent(name) + '=([^&]*)')).exec(location.search))
    return decodeURIComponent(name[1]);
  //https://stackoverflow.com/questions/831030/how-to-get-get-request-parameters-in-javascript
}

function getinfo() {
  var xyz = get('recipeid');
  if (typeof get('recipeid') == 'undefined') {
    xyz = "1";
  }
  var xhr = new XMLHttpRequest();
  //var url = "https://x8.csdcso.org/api/getRecipeInfo.php?recipeid=1";//is url the server url?
  var url = "https://x8.csdcso.org/api/getRecipeInfo.php?recipeid=" + xyz;
  xhr.open("GET", url, true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var rec = JSON.parse(xhr.responseText);
      y = rec.name;
      document.getElementById("recipename").innerHTML = y;
      y = rec.time;
      document.getElementById("recipetime").innerHTML = y;
      y = rec.calorie;
      document.getElementById("recipecals").innerHTML = y;
      y = rec.description;
      document.getElementById("recipedesc").innerHTML = y;
      y = "figure out how to read ingredients from database";
      document.getElementById("ingredients").innerHTML = y;
      y = "figure out how to read steps from database";
      document.getElementById("instructions").innerHTML = y;
    }
  };
  xhr.send();

  var xhr = new XMLHttpRequest();
  var url = "https://x8.csdcso.org/api/getRecipe.php?recipeid=1";//is url the server url?
  xhr.open("GET", url, true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      y = xhr.responseText;
      document.getElementById("instructions").innerHTML = y;
    }
  };
  xhr.send();
}
