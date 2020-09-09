function downloadHTML(url, callbackFunction) {
    var XMLHttpRequestObject = false;
    if (window.XMLHttpRequest) {
        XMLHttpRequestObject = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
    }
    if (XMLHttpRequestObject) {
        XMLHttpRequestObject.open("GET", url, true);
        XMLHttpRequestObject.onreadystatechange = function () {
            var status = XMLHttpRequestObject.status;

            if (XMLHttpRequestObject.readyState == 4 && (status === 0 || (status >= 200 && status < 400))) {
                callbackFunction(XMLHttpRequestObject.responseText);
                delete XMLHttpRequestObject;
                XMLHttpRequestObject = null;
            }
        };
        XMLHttpRequestObject.send(null);
    }
    return XMLHttpRequestObject.responseText;
}

function downloadHTMLPost(url, data, callbackFunction) {
    var XMLHttpRequestObject = false;
    if (window.XMLHttpRequest) {
        XMLHttpRequestObject = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        XMLHttpRequestObject = new
        ActiveXObject("Microsoft.XMLHTTP");
    }
    if (XMLHttpRequestObject) {
        XMLHttpRequestObject.open("POST", url, true);
        XMLHttpRequestObject.onreadystatechange = function () {
            var status = XMLHttpRequestObject.status;

            if (XMLHttpRequestObject.readyState == 4 && (status === 0 || (status >= 200 && status < 400))) {
                callbackFunction(XMLHttpRequestObject.responseText);
                delete XMLHttpRequestObject;
                XMLHttpRequestObject = null;
            }
        };
        XMLHttpRequestObject.send(data);
    }
}