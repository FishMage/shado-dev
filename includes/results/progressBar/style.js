jQuery.noConflict()(function ($) {
    jQuery(document).ready(init());
});

function init() {
    console.log("Called!")
    var i = 1;
    // jQuery('.progress .circle').removeClass().addClass('circle');
    // jQuery('.progress .bar').removeClass().addClass('bar');

    var check = 0;
    var temp = setInterval(function() {
      jQuery('.progress .circle:nth-of-type(' + i + ')').addClass('active');
      jQuery('.progress .circle:nth-of-type(' + (i-1) + ')').removeClass('active').addClass('done');
      jQuery('.progress .circle:nth-of-type(' + (i-1) + ') .label').html('&#10003;');
      jQuery('.progress .bar:nth-of-type(' + (i-1) + ')').addClass('active');
      jQuery('.progress .bar:nth-of-type(' + (i-2) + ')').removeClass('active').addClass('done');
      console.log(i);
      i++;
      if (i < 6)
        if (Math.random() > 0.6)
              i = i - 1;

     if (i == 7) {
    	 check = 1;
    	 console.log("done");
         window.open('view_results.php', '_self');
    	 clearInterval(temp);
     }

    //   if (i == 0) {
    //     jQuery('.progress .bar').removeClass().addClass('bar');
    //     jQuery('.progress div.circle').removeClass().addClass('circle');
    //     i = 1;
    //   }
    }, 1000);
}
