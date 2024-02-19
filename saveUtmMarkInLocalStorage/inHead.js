//it is recommended to insert this script into the head of the page

let params = window
    .location
    .search
    .replace('?','')
    .split('&')
    .reduce(
        function(p,e){
            var a = e.split('=');
            p[ decodeURIComponent(a[0])] = decodeURIComponent(a[1]);
            return p;
        },
        {}
    );

const utmLocalStorage = localStorage.getItem("utm");
let utm = ""
if(params["utm_source"] !== undefined && utmLocalStorage === null) {
    localStorage.setItem("utm", params["utm_source"]);
    utm = params["utm_source"];
}else if(params["utm_source"] !== utmLocalStorage && params["utm_source"] !== undefined) {
    localStorage.setItem("utm", params["utm_source"]);
    utm = params["utm_source"];
}else if(params["utm_source"] === undefined && utmLocalStorage !== null) {
    utm = utmLocalStorage;
}