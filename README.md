GoogleApiProxy
==============
```
var proxy = 'https://im007boy.com/sendRequest.php';
var oauthToken = gapi.auth.getToken();
return $.ajax({
    url: proxy,
    type: 'POST',
    data: JSON.stringify({
        "Method":"GET",
        "absoluteURI":uri,
        //"absoluteURI":"https://picasaweb.google.com/data/feed/api/user/default/albumid/{albmId}",
        "headers":{
            "GData-Version": "2",
            "Authorization": 'Bearer ' + oauthToken.access_token
        }
    })
});
```