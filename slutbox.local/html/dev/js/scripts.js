(function(){

	var header = document.getElementById("main-header");
	header.className += "loaded";

	window.addEventListener("DOMContentLoaded", function(){
		var main = document.getElementById("main");
		main.setAttribute("style", "display:block;");
	});

})();