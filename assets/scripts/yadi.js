// show hide menus

var pathname = window.location.pathname; // Returns path only (/path/example.html)
var url      = window.location.href;     // Returns full URL (https://example.com/path/example.html)
var origin   = window.location.origin;   // Returns base URL (https://example.com)

$('[href="'+url+'"]').parent().parent().parent().addClass('active');
$('[href="'+url+'"]').parent().addClass('active');
console.log(url);