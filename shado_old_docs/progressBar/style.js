var i = 1;
$('.progress .circle').removeClass().addClass('circle');
$('.progress .bar').removeClass().addClass('bar');

var check=0;
var temp=setInterval(function() {
  $('.progress .circle:nth-of-type(' + i + ')').addClass('active');
  $('.progress .circle:nth-of-type(' + (i-1) + ')').removeClass('active').addClass('done');
  $('.progress .circle:nth-of-type(' + (i-1) + ') .label').html('&#10003;');
  $('.progress .bar:nth-of-type(' + (i-1) + ')').addClass('active');
  $('.progress .bar:nth-of-type(' + (i-2) + ')').removeClass('active').addClass('done');
  console.log(i);
  i++;
  if(i<6){if(Math.random()>0.6){ i=i-1;}}



 if(i==7){
	 check=1;
	 console.log("done");
	window.open('view_results.php','_self');
	 clearInterval(temp);
 }

  if (i==0) {
    $('.progress .bar').removeClass().addClass('bar');
    $('.progress div.circle').removeClass().addClass('circle');
    i = 1;
  }
}, 1000);
