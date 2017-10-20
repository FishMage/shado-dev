/****************************************************************************
*																			*
*	File:		basic_settings.js  											*
*																			*
*	Author:		Branch Vincent												*
*																			*
*	Date:		Sep 9, 2016
*
* 	Editor:		Rocky Li, edited Sep 26, 2017
*
*	Purpose:	This file makes calculations for the basic input settings
*				page.														*
*																			*
****************************************************************************/
var numBatch =  localStorage.getItem('numBatch');
if (numBatch === null){
    // alert("numBatch is null, set to 1");
    localStorage.setItem('numBatch', '1');
    numBatch = 1;
}


jQuery.noConflict()(function ($) {
    $(document).ready(init());
});

/****************************************************************************
*																			*
*	Function:	init														*
*																			*
*	Purpose:	To initialize the page with the correct traffic table size 	*
*																			*
****************************************************************************/

function init() {
	console.log("Window has loaded!");
	// calculate_time();
    init_hour_labels();
    toggle_custom_settings();
}

/****************************************************************************
 *
 *	Function:	calculate_train
 *
 *	Purpose:	Calcuate the amount of trains given input
 *
 ****************************************************************************/

function calculate_train() {
	var numtrains = jQuery('#TrainNum').val();
	jQuery('#train_num').val(numtrains);
}

/****************************************************************************
 *
 *	Function:	calculate_train
 *
 *	Purpose:	Calcuate the amount of trains given input
 *
 ****************************************************************************/

function calculate_dispatch(){
	var dispatchnum = jQuery('#DispatchNum').val();
	jQuery('#dispatch_num').val(dispatchnum);
}

/****************************************************************************
*																			*
*	Function:	calculate_time												*
*																			*
*	Purpose:	To calculate the time difference between the provided 		*
*				inputs														*
*																			*
****************************************************************************/

function calculate_time() {

//	Get times and calculate hour difference

	var begin_time = get_date('begin');
	var end_time = get_date('end');
	var hours = get_hour_diff(begin_time, end_time);
	console.log("Hours = " + hours);

//	Store new times

	jQuery('#begin_time').val(begin_time.format("h:mm A"));
	jQuery('#end_time').val(end_time.format("h:mm A"));
	jQuery('#num_hours').val(hours);

//	Empty traffic table

	jQuery('#table').empty();
	var table = document.getElementById('table');
	var row = table.insertRow(0);

//	Insert hour columns

	for (i = 0; i < hours; i++) {
		var cell = row.insertCell(i);
		cell.innerHTML = "";
		cell.innerHTML += "<input type='radio' name=traffic_level_" + i + " value='h'>High</input>"
		cell.innerHTML += "<br><input type='radio' name=traffic_level_" + i + " value='m' checked>Med</input>"
		cell.innerHTML += "<br><input type='radio' name=traffic_level_" + i + " value='l'>Low</input>";
	}

//	Change hour labels

	var hour_label = begin_time;
	var row = table.insertRow(1);
	for (i = 0; i < hours; i++) {
		var cell = row.insertCell(i);
		cell.innerHTML = hour_label.format("h A");
		hour_label.add(1, 'hour');
	}

//  Add animation to custom assistant

    // var custom = jQuery('#custom_assistant');
    // custom.onclick = function() {
    //     jQuery('#custom_assistant_settings').toggleClass('hide');
    // }
}

/****************************************************************************
*																			*
*	Function:	init_hour_labels										    *
*																			*
*	Purpose:	To toggle the visibility of the custom operator settings 	*
*																			*
****************************************************************************/

function init_hour_labels() {
    var begin_time = jQuery('#begin_time').val();
    console.log(begin_time);
    var hour_label = moment("2016-01-01 " + begin_time, "YYYY-MM-DD HH:mm A");
    var traffic_table = document.getElementById('traffic_level_labels');
    for (var i = 0; i < jQuery('#num_hours').val(); i++) {
        var cell = traffic_table.insertCell(i);
        cell.innerHTML = hour_label.format("h A");
        hour_label.add(1, 'hour');
    }
    jQuery('#table').removeClass('remove');
}
/****************************************************************************
*																			*
*	Function:	get_date													*
*																			*
*	Purpose:	To create a date from the current input in the specified 	*
*				html division		 										*
*																			*
****************************************************************************/

function get_date(html_div) {
	var hr = jQuery('#' + html_div + 'Hour').val();
	var min = jQuery('#' + html_div + 'Min').val();
	var md = jQuery('#' + html_div + 'Md').val();
	time = hr + ':' + min + ' ' + md;
	return moment("2016-01-01 " + time, "YYYY-MM-DD HH:mm A");
}

/****************************************************************************
*																			*
*	Function:	get_hour_diff												*
*																			*
*	Purpose:	To calculate the number of hours between the two 			*
*				specified dates 											*
*																			*
****************************************************************************/

function get_hour_diff(date1, date2) {
	if (date1 >= date2) date2.add(1, 'day');
	var mins = date2.diff(date1, 'minutes');
	return Math.ceil(mins / 60);
}

/****************************************************************************
*																			*
*	Function:	toggle_custom_settings										*
*																			*
*	Purpose:	To toggle the visibility of the custom operator settings 	*
*																			*
****************************************************************************/

function toggle_custom_settings() {
    var checked_1 = jQuery('#custom_assistant').prop('checked') ;
    var checked_2 = jQuery('#custom_assistant_2').prop('checked') ;
    var checked_3 = jQuery('#custom_assistant_3').prop('checked') ;
    if (checked_1)
        jQuery('#custom_assistant_settings').removeClass('remove');
    else
        jQuery('#custom_assistant_settings').addClass('remove');

    if (checked_2)
        jQuery('#custom_assistant_settings_2').removeClass('remove');
    else
        jQuery('#custom_assistant_settings_2').addClass('remove');
    if (checked_3)
        jQuery('#custom_assistant_settings_3').removeClass('remove');
    else
        jQuery('#custom_assistant_settings_3').addClass('remove');
    // console.log(test);
    // if (jQuery('#custom_assistant'))
    // jQuery('#custom_assistant_settings').toggleClass('hide');
}

// function addBatch() {
//     var b2 = document.getElementById('batch_2');
//     var b3 = document.getElementById('batch_3');
//     var text = document.getElementById('addBatchText');
//     var button = document.getElementById('addTaskButton');
//     if (b2.style.display === 'none' && b3.style.display === 'none') {
//         b2.style.display = 'block';
//         localStorage.setItem('numBatch', '2');
//     } else if(b2.style.display === 'block'&&  b3.style.display === 'none') {
//         b3.style.display = 'block';
//         button.style.backgroundColor = '#909090';
//         text.style.color = '#909090';
//         button.style.cursor = 'not-allowed';
//         burron.disabled = true;
//         localStorage.setItem('numBatch', '3');
//     }
//
//
// }

function calculate_dispatch(){
    var dispatchnum = jQuery('#DispatchNum').val();
    jQuery('#dispatch_num').val(dispatchnum);
}
//Function for Tab Controller
function switchBatch(evt, batchName) {
    var i, tabcontent, tablinks;

    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(batchName).style.display = "block";

    evt.currentTarget.className += " active";

}
function changeNumSec(evt) {
    var numSec = jQuery('#SecNum').val();
    // jQuery('#sector_num').val(SecNum);
    // alert("Onchange: to "+ numSec);
    if(numSec == 1){
        document.getElementById("btn_batch_2").style.cursor = "not-allowed";
        document.getElementById("btn_batch_3").style.cursor = "not-allowed";
        // document.getElementById("btn_batch_2").style.display = "none";
        document.getElementById("btn_batch_2").disabled = true;
        document.getElementById("btn_batch_3").disabled = true;
        document.getElementById("btn_batch_2").style.color = '#c8c8c8';
        document.getElementById("btn_batch_3").style.color = '#c8c8c8';
        localStorage.setItem('numBatch', '1');
    }
    else if(numSec == 2){
        document.getElementById("btn_batch_2").style.cursor = "pointer";
        document.getElementById("btn_batch_3").style.cursor = "not-allowed";
        document.getElementById("btn_batch_2").disabled = false;
        document.getElementById("btn_batch_3").disabled = true;
        document.getElementById("btn_batch_3").style.color = '#c8c8c8';
        document.getElementById("btn_batch_2").style.color = 'black';
        localStorage.setItem('numBatch', '2');
    }
    else if (numSec == 3){
        document.getElementById("btn_batch_1").style.cursor = "pointer";
        document.getElementById("btn_batch_2").style.cursor = "pointer";
        document.getElementById("btn_batch_3").style.cursor = "pointer";
        document.getElementById("btn_batch_1").disabled = false;
        document.getElementById("btn_batch_2").disabled = false;
        document.getElementById("btn_batch_3").disabled = false;
        document.getElementById("btn_batch_1").style.color = 'black';
        document.getElementById("btn_batch_2").style.color = 'black';
        document.getElementById("btn_batch_3").style.color = 'black';
        // document.getElementById("btn_batch_3").style.color = '#c8c8c8';
        localStorage.setItem('numBatch', '3');

    }
    // var numSector = jQuery('#SecNum').val();
    // jQuery('#sector_num').val(numSector);

}

//Display default content when there is no tab selected
function displayDefault() {

    jQuery('#SecNum').val(parseInt(numBatch));
    if (numBatch == '1') {
        // alert("numbatch 1");
        // document.getElementById("btn_batch_1").style.cursor = "not-allowed";
        document.getElementById("btn_batch_2").style.cursor = "not-allowed";
        document.getElementById("btn_batch_3").style.cursor = "not-allowed";
        // document.getElementById("btn_batch_2").style.display = "none";
        // document.getElementById("btn_batch_1").disabled = true;
        document.getElementById("btn_batch_2").disabled = true;
        document.getElementById("btn_batch_3").disabled = true;
        // document.getElementById("btn_batch_1").style.color = '#c8c8c8';
        document.getElementById("btn_batch_2").style.color = '#c8c8c8';
        document.getElementById("btn_batch_3").style.color = '#c8c8c8';
    }
    if(numBatch == '2'){
        document.getElementById("btn_batch_3").style.cursor = "not-allowed";
        document.getElementById("btn_batch_3").disabled = true;
        document.getElementById("btn_batch_3").style.color = '#c8c8c8';
    }
    if(numBatch == '3'){
        document.getElementById("btn_batch_1").style.cursor = "allowed";
        document.getElementById("btn_batch_2").style.cursor = "allowed";
        document.getElementById("btn_batch_3").style.cursor = "allowed";
    }

}