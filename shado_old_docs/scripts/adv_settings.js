/****************************************************************************
*																			*
*	File:		adv_settings.js  											*
*																			*
*	Author:		Branch Vincent												*
*																			*
*	Date:		Sep 9, 2016													*
*																			*
*	Purpose:	This file makes calculations for the advanced input 	 	*
*				settings page.												*
*																			*
****************************************************************************/

var current_task = 0;

/****************************************************************************
*																			*
*	Function:	updateSerDist												*
*																			*
*	Purpose:	To toggle the visibility of the service distribution field 	*
*				depending on the selected type 								*
*																			*
****************************************************************************/

function updateSerDist(task_num) {

	var item = document.getElementById("t" + task_num + "_serTimeDist");
	var dist = item.options[item.selectedIndex].value;

	if (dist == "E") {
		document.getElementById("t" + task_num + "_expPms").style.display = 'inline-block';
		document.getElementById("t" + task_num + "_logPms").style.display = 'none';
		document.getElementById("t" + task_num + "_uniPms").style.display = 'none';
	} else if (dist == "L") {
		document.getElementById("t" + task_num + "_expPms").style.display = 'none';
		document.getElementById("t" + task_num + "_logPms").style.display = 'inline-block';
		document.getElementById("t" + task_num + "_uniPms").style.display = 'none';
	} else {
		document.getElementById("t" + task_num + "_expPms").style.display = 'none';
		document.getElementById("t" + task_num + "_logPms").style.display = 'none';
		document.getElementById("t" + task_num + "_uniPms").style.display = 'inline-block';
	}
}

/****************************************************************************
*																			*
*	Function:	addTask														*
*																			*
*	Purpose:	To show the specified task on the page 						*
*																			*
****************************************************************************/

function addTask(batch_num,task_num) {
    var batch_task = "";
	if(batch_num == 0)
		 batch_task = "task_";
	else{
		batch_task = 'b'+batch_num+"_task_";
	}
	console.log(batch_task);

	if (current_task == 0)
		current_task = task_num;
	else if (current_task == 14) {
		console.log(jQuery('#taskAdder'));
		jQuery('#taskAdder').addClass('remove');
	}
	else
		current_task++;

	console.log("Adding task " + current_task);
	document.getElementById(batch_task + current_task).style.display = "block";
	var current_tasks = document.getElementById('current_tasks').value; //.split(",").map(Number);
	current_tasks = JSON.parse("[" + current_tasks + "]");
	current_tasks.push(current_task);
	document.getElementById("current_tasks").value = current_tasks;
}

/****************************************************************************
*																			*
*	Function:	deletTask													*
*																			*
*	Purpose:	To hide the specified task on the page					 	*
*																			*
****************************************************************************/

function deleteTask(task_num) {

//	Remove task

	console.log("Removing task " + task_num);
	document.getElementById("task_" + task_num).style.display = "none";
	current_tasks = document.getElementById('current_tasks').value.split(",").map(Number);

	console.log(current_tasks);
	var index = current_tasks.indexOf(task_num);
	console.log("Index = " + index);
	if (index > -1) current_tasks.splice(index, 1);
	console.log(current_tasks);
	document.getElementById("current_tasks").value = current_tasks;

	// var task = document.getElementById("task_" + task_num);
	// task.parentElement.removeChild(task);
}

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

function displayDefault(){
	var numBatch =  localStorage.getItem('numBatch');
    document.getElementById("btn_dispatcher").click();
    // document.getElementById("btn_batch_2").style.backgroundColor = '#000000';
    if(numBatch == '1'){
        document.getElementById("btn_batch_2").style.cursor = "not-allowed";
        document.getElementById("btn_batch_3").style.cursor = "not-allowed";
        // document.getElementById("btn_batch_2").style.display = "none";
        document.getElementById("btn_batch_2").disabled = true;
        document.getElementById("btn_batch_3").disabled = true;
        document.getElementById("btn_batch_2").style.color = '#c8c8c8';
        document.getElementById("btn_batch_3").style.color = '#c8c8c8';
	}
	if(numBatch == '2'){
            document.getElementById("btn_batch_3").style.cursor = "not-allowed";
			document.getElementById("btn_batch_3").disabled = true;
        	document.getElementById("btn_batch_3").style.color = '#c8c8c8';
	}
}
