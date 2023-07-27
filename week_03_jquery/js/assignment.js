$(document).ready(function(){
	$("#fade_button").click(function(){
		$("#fade_text").fadeOut();
	});

	$("#heading_button").click(function(){
		$("#heading").text("This is a new heading changed with jQuery");
	});

	$("body").append("<ul><li>Bulleted list item 1</li><li>Bulleted list item 2</li><li>Bulleted list item 3</li></ul>");

	$(".my_image").css("width", "700px");
	$(".my_image").css("height", "400px");

	$("#paragraph_button").click(function(){
		$(".paragraphs").css("color", "blue");
		$(".paragraphs").css("font-weight", "bold");
	});
});