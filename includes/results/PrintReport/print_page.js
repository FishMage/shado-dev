jQuery.noConflict()(function ($) {
    $(document).ready(init());
});

function init() {
    jQuery('#submit1').addClass('remove');
    jQuery('#submit2').addClass('remove');
}

document.addEventListener("DOMContentLoaded",function() {
	// document.getElementByClassName('text_box').style.display="block";
	var why_tab = document.getElementsByClassName('why_tab')
	console.log(why_tab);
	for (i = 0; i < why_tab.length; i++) {
		why_tab[i].style.display="block";
	}
	// tab[0].style.display="block";
	// document.getElementById('howTab').style.display="block";
	// document.getElementById('whenTab').style.display="block";
	// document.getElementById('operator2').style.display="none";}
});

function printDiv(divName) {
 	var printContents = document.getElementById(divName).innerHTML;
 	var originalContents = document.body.innerHTML;
 	document.body.innerHTML = printContents;
 	window.print();
 	document.body.innerHTML = originalContents;
}
