/****************************************************************************
*																			*
*	File:		global_styles.php  											*
*																			*
*	Author:		Branch Vincent												*
*																			*
*	Date:		Sep 9, 2016													*
*																			*
*	Purpose:	This file defines the global stying of the webpages.		*
*																			*
****************************************************************************/

<?php
	$color_theme_dark_blue = '#467FC9';
	$color_theme_light_blue = '#75D3FE';
?>

/****************************************************************************
*																			*
*	Section:	Page Parts													*
*																			*
*	Purpose:	This section defines the general page styles 				*
*																			*
****************************************************************************/
*{
    font-family: "Lucida Grande";
}
h1, h2, h3, h4, h5, h6 {
   /*font-size: 1em !important;*/
   /*color: #000 !important;*/
   font-family: "Open Sans";
   /*!important;*/
}

/*	Page Body	*/

body {
	margin: 0;
	font-family: "Open Sans";
}

#main {
	margin-top: 168px;
	margin-bottom: 20px;
}

h1 {
	color: #19334d;
	/*font-family: Verdana, Geneva, sans-serif;*/
	font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif
	font-size: 32px;
}

#title {
	background: <?php echo $color_theme_dark_blue; ?>;
	height:120px;
}

#title h1 {
	color: white;
}

/*	Page Header	*/

#fixedHead {
	position: fixed;
	top: 0;
	text-align: center;
	width: 100%;
	z-index: 999;
}

#fixedHead h1 {
	margin: 0;
	padding: 40px;
	padding-bottom: 0;
}

#halLogo {
	position: absolute;
	left: 0;
	padding: 20px 20px;
	width: 250px;
}
#underConstruction {
    position: absolute;
    right: 0;
    padding: 20px 20px;
    width: 250px;
}

/*	Page Body	*/

#fixedBody {
	position: fixed;
	top: 0;
	width: 100%;
	height: 100%;
	background-image: url("../images/rail.jpg");
	z-index: -999;
}

/*	Top Navigation	*/

#topNav ul {
	list-style-type: none;
	margin: 0;
	padding: 0px;
	overflow: hidden;
	background-color: #555;
	border-top: 1px solid black;
	border-bottom: 1px solid black;
}

#topNav li {
	/*display: inline-block;*/
	float: left;
	margin: 0;
	padding: 0px;
	font-size: 18px;
}

#topNav li a {
	display: inline-block;
	color: white;
	text-align: center;
	padding: 12px 17px;
	text-decoration: none;
}

#topNav li a:hover:not(.active) {
	/*background-color: #ddd;*/
	color: white;
	background-color: black;
}

#topNav li a.active {
	background-color: <?php echo $color_theme_light_blue; ?>;
}

/*	Side Navigation	*/

#sideNav ul {
    list-style-type: none;
    margin-top: 0px;
	padding: 20px 0px;
	height: 100%;
    /*padding: 0;*/
    width: 220px;
    background-color: #f1f1f1;
    position: fixed;
    /*height: 90%;*/
    overflow: auto;
	border-right: 1px solid black;
}

#sideNav li a, #sideNav li button {
    display: block;
    color: #000;
    padding: 8px 16px;
    text-decoration: none;
	font-size: 14;
	font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
}

#sideNav li a.active{
	color: white;
	background-color: <?php echo $color_theme_light_blue; ?>;
}

#sideNav li button #accordion-content.active {
	/*background-color: */
}

#sideNav li a:hover:not(.active), #sideNav li button:hover {
    background-color: #ddd;
}

li button.accordion {
    background-color: #eee;
    color: #444;
    cursor: pointer;
    /*padding: 18px;*/
    width: 100%;
    border: none;
    text-align: left;
    outline: none;
    /*font-size: 15px;*/
    transition: 0.4s;
}

li button.accordion:after {
    content: '\25B8';
	/*'\276F';*/
	/*'\02795';*/
    /*color: #777;*/
    float: right;
	/*padding-left: 5px;*/
	/*vertical-align: middle;*/
	/*border: 1px solid red;*/
	/*vertical-align: -50%;*/
    /*margin-right: 5px;*/
}

li button.accordion.active:after {
    content: '\25BE';
	/*'\25B8';*/
	/*'\2796';*/
}

div.accordion-content {
    /*padding: 0 18px;*/
	/*margin-left: 18px;*/
    background-color: white;
	color: white;
	text-indent: 20px;
    max-height: 0;
    overflow: hidden;
    transition: 0.3s ease-in-out;
    opacity: 0;
	/*border: 1px solid red;*/
}

div.accordion-content.show {
    opacity: 1;
    max-height: 500px;
}

/*	Bottom Navigation	*/

#bottomNav {
	display: table;
	margin: auto;
	/*border: 1px solid red;*/
}

#bottomNav ul {
	list-style-type: none;
	margin: auto;
	padding: 0;
	/*overflow: hidden;*/
	/*background-color: #555;*/
}

#bottomNav li {
	display: inline-block;
	/*text-align: center;*/
	/*float: right;*/
	margin: auto;
	padding: 20px;
	font-size: 18px;
	/*border: 1px solid red;*/
}

/*	Page Footer	*/

/*#fixedFooter {
	position: fixed;
	bottom: 0;
	background-color: rgba(255,255,255, 0.8);
	width: 100%;
	height: 70px;
	padding-top: 10px;
	padding-left: 10px;
	border-top: 1px solid black;
}

#fixedFooter #footerLogo {
	position: absolute;
	top: 10px;
	right: 20px;
}

#fixedFooter .noteLabel {
	display: inline-block;
	vertical-align: top;
	margin-top: 20px;
	font-weight: bold;
}

#fixedFooter .note {
	display: inline-block;
}

#fixedFooter .note p {
	margin-top: 20px;
	margin-bottom: 5px;
}*/

/****************************************************************************
*																			*
*	Section:	General														*
*																			*
*	Purpose:	This section defines...										*
*																			*
****************************************************************************/

.printPdf {
	background-image: url("../images/print.png");
	height: 50px;
	width: 50px;
	background-size: 50px;
	margin-top: 10px;
	margin-left: 10px;
	position:fixed;
  right:10px;
}

@media print {
	.page {
		margin-left: 0 !important;
		/*background-color: red;*/
	}

	.no-page-break {
		page-break-inside: avoid;
	}
}

.page {
	margin-left: 230px;
	<!-- margin-right: 30px; -->
	margin-top: 10px;
	padding-top: 20px;
}

#homePage, #contactPage, #versionPage {
	margin-left: 30px;
}

.pageTitle {
	text-align: center;
}

.centerOuter {
	margin-left: auto;
	margin-right: auto;
	text-align: center;
}
.leftAlign{
    /*padding-left: 5%;
    margin-left: 10px;
    margin-right: auto;
    */
    margin-left: 15%;
    transform:  translate(-140px,-100px) scale(0.7);

}

.stepCircle {
	color: <?php echo $color_theme_dark_blue; ?>;
	border: 3px solid <?php echo $color_theme_dark_blue; ?>;
	background-color: #eee;
	width: 30px;
	height: 30px;
	font-size: 24px;
	border-radius: 18px;
	text-align: center;
	font-weight: bold;
	position: absolute;
	top: 8px;
	left: 5px;
    transform: scale(0.8);
}

.stepBox {
/*	border: 1px dashed #888;*/
	border-radius: 5px;
	position: relative;
	padding-top: 25px;
	padding-bottom: 20px;
	padding-left:  50px;
	padding-right: 120px;
/*    text-align: center;*/
	background-color: rgba(255, 255, 255, 0.6);
    box-shadow: 0px 8px 8px 0px rgba(0,0,0,0.2);

}

.formBox{
    border: 3px solid #7cd0ff;
    border-radius: 5px;
    position: relative;
    margin-bottom: 30px;
    margin-right: 20px;
    padding-top: auto;
    padding-bottom: 2%;
    padding-left: 5%;
    padding-right: 5%  ;
/*    background-color: rgba(255, 255, 255, 0.6);*/
    background-color: rgba(240, 240, 240, 0);
    box-shadow: 2px 8px 16px 2px rgba(0,0,0,0.1);
    text-align: center;
/*    -webkit-filter: blur(10px);*/
/*    filter: url('/media/blur.svg#blur');*/
/*    filter: blur(10px);*/
}
.fromBox-bg{
    position: absolute;
    top: 0px;
    right: 0px;
    bottom: 0px;
    left: 0px;
    z-index: 99;

    /* Pull the background 70px higher to the same place as #bg's */
    background-position: center -70px;

    -webkit-filter: blur(10px);
/*    filter: url('/media/blur.svg#blur');*/
    filter: blur(10px);
}
#container{
    width: 350px;
    height: 500px;
    background: inherit;
    position: absolute;
    overflow: hidden;
    top: 50%;
    left: 50%;
    margin-left: -175px;
    margin-top: -250px;
    border-radius: 8px;
}
#container:before{
    width: 400px;
    height: 550px;
    content: "";
    position: absolute;
    top: -25px;
    left: -25px;
    bottom: 0;
    right: 0;
    background: inherit;
    box-shadow: inset 0 0 0 200px rgba(255,255,255,0.2);
    filter: blur(10px);
}
/****************************************************************************
*																			*
*	Section:	Richard 													*
*																			*
*	Purpose:	Tab.					                					*
*																			*
****************************************************************************/
/* Style the tab */
div.tab {
/*    margin-left: 30%;*/
    width: 418.5px;
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
}
.tabpage h3{
    box-shadow: 0px 8px 8px 0px rgba(0,0,0,0.2);
}
/* Style the buttons inside the tab */
div.tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 17px;
}

/* Change background color of buttons on hover */
div.tab button:hover:enabled {
    background-color: #ddd;
}

/* Create an active/current tablink class */
div.tab button.active:enabled {
    background-color: #ccc;

}

/* Style the tab content */
.tabcontent {
    display: none;
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;
}

/****************************************************************************
*																			*
*	Section:	Run Sim														*
*																			*
*	Purpose:	This section defines...										*
*																			*
****************************************************************************/

/*.centerText {
	text-align: center;
}*/
.dropbtn {
    background-color: #4CAF50;
    color: white;
    padding: 16px;
    font-size: 16px;
    border: none;
    cursor: pointer;
}

.dropdown {
    position: absolute;
/*    display: inline-block;*/
}

.dropdown-content {
    width: auto;
    display: none;
    position: relative;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown-content button {
    width: 100%;
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    border: none;
    background-color: white;
    transition: all 0.5s;
    cursor: pointer;
}
.dropdown-content button span{
    cursor: pointer;
    display: inline-block;
    position: ;
    transition: 0.5s;
}
.dropdown-content button span:after{
    content: '\00bb';
    position: relative;
    opacity: 0;
    top: 0;
    right: -20px;
    transition: 0.5s;
}
.dropdown-content button:hover{
    padding-right: 25px;
}
.dropdown-content button:hover :after{
    opacity: 1;
    right: 0;
}

.dropdown-content a:hover {background-color: rgba(240,240,240,0.52)}

.dropdown:hover .dropdown-content {
/*    down:20px;*/
/*    transition: 0.5s;*/
    display: block;
}

.dropdown:hover .dropbtn {
    background-color: #3e8e41;
}
.startEndTime {
	width: 300px;
	display: inline-block;
	margin: 20px;
	position: relative;
	padding-top: 25px;
	padding-bottom: 20px;
	padding-left:  35px;
	padding-right: 35px;
	text-align: center;
}

.startEndTime h3, .trafficTableStepOuter h3, .assistantsSelectStepOuter h3 {
/*    background-color: rgba(71,119,199,0.85);*/
/*	padding: 3px;*/
/*    padding-top: 5px;*/
/*    padding-bottom: 5px;*/
    text-wrap: none;
	margin:  auto;

	margin-bottom: 10px;
/*    margin-top:10px;*/
    font-family: "Lucida Grande";

}

.startEndTime h3 {
	width: auto;
    font-size: small;
}

.trafficTableStepOuter h3 {
	width: auto;
}

.assistantsSelectStepOuter h3 {
	width: 350px;
    text-align: center;
/*    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);*/
}

.trafficTableStepOuter {
	display: inline-block;
	padding-left:  70px;
	padding-right: 70px;
}

.trafficTable {
	border-collapse: collapse;
	margin-left: auto;
	margin-right: auto;
}

.trafficTable .tableTrafficHour {
	text-align: center;
}

.assistantsSelectStepOuter {
/*	width: 600px;*/
/*    text-align: center;*/
}

#assistantsTable {
	margin-left: auto;
	margin-right: auto;
}

p {
	font-size: 20px;
}

.whiteFont {
	color: white;
}

/****************************************************************************
*																			*
*	Section:	Tables														*
*																			*
*	Purpose:	This section defines...										*
*																			*
****************************************************************************/

table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
    white-space: nowrap;
}

th, td {
    padding: 10px;
}

tr:nth-child(even){
	background-color: #f1f1f1;
}

tr:nth-child(odd){
	background-color: white;
}

th {
    background-color: <?php echo $color_theme_dark_blue; ?>;
    color: white;
}

<!-- #howTab, #whenTab{
 	padding:5px 15px;
 	width:fit-content;
 	width:-webkit-fit-content;
 	width:-moz-fit-content;
 	/*border: 3px solid #5D7B85;*/
 	cursor:pointer;
 	-webkit-border-radius: 5px;
 	border-radius: 25px;
 	display: inline-block;
 	margin: 20px;
 	text-align: left;
 	
 } -->

 #conductor_summary{
	position: relative;
	top: 50px;

 }

/****************************************************************************
*																			*
*	Section:	Tool Tips													*
*																			*
*	Purpose:	This section defines...										*
*																			*
****************************************************************************/

/* Tooltip container */
.tooltip1 {
    position: relative;
    display: inline-block;
    border-bottom: 1px dotted black; /* If you want dots under the hoverable text */
}

/* Tooltip text */
.tooltip1 .tooltiptext1 {
    visibility: hidden;
    width: 120px;
    background-color: black;
    color: #fff;
    text-align: center;
    padding: 5px 0;
    border-radius: 6px;

    /* Position the tooltip text - see examples below! */
    position: absolute;
    z-index: 1;
}

/* Show the tooltip text when you mouse over the tooltip container */
.tooltip1:hover .tooltiptext1 {
    visibility: visible;
}

.button {
	background-color: #e7e7e7;
/*	border: 1px solid black;*/
    /*border: none;*/
    color: white;
    padding: 10px 15px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
	border-radius: 8px;
}

/****************************************************************************
*																			*
*	Section:	Operator Summary											*
*																			*
*	Purpose:	This section defines...										*
*																			*
****************************************************************************/

.operatorSummaryOuter {
	text-align: center;
}

.operators{
	padding:5px 15px;
	width:fit-content;
	width:-webkit-fit-content;
	width:-moz-fit-content;
	border: 3px solid #5D7B85;
	cursor:pointer;
	-webkit-border-radius: 5px;
	border-radius: 25px;
	display: inline-block;
	width: 450px;
	margin: 20px;
	text-align: left;
	background-color: rgba(255, 255, 255, 0.6);
}

/*button*/
#summaryButton {
	padding:5px 15px;
    border: 2px solid #5D7B85;
    cursor:pointer;
    -webkit-border-radius: 5px;
    border-radius: 25px;
}

.roundButton {
    height: 28px;
    width: 28px;
    border-radius: 100px;
	/*padding: 5px 10px;*/
	border: none;
	cursor: pointer;
	color: white;
	font-size: 18;
	text-align: center;
}


/****************************************************************************
*																			*
*	Section:	Graph Text Boxes											*
*																			*
*	Purpose:	This section defines...										*
*																			*
****************************************************************************/

#graphNav ul {
	list-style-type: none;
	margin: 0;
	padding: 0px;
	overflow: hidden;
	background-color: #f1f1f1;
	border: 1px solid black;
	display: inline-block;

}

#graphNav li {
	float: left;
	display: inline-block;
	margin: 0;
	padding: 0px 50px;
	font-size: 18px;
}

#graphNav li a {
	color: #555;
	text-align: center;
	padding: 12px 20px;
	text-decoration: none;
	display: inline-block;
}

#graphTextBox{
 	width: 1170px;
 	border: 3px solid #5D7B85;
 	cursor:pointer;
 	-webkit-border-radius: 5px;
 	border-radius: 25px;
 	min-width: 600px;
 	/*width: 1200px;*/
 	/*margin: 0 auto;*/
 	margin-left: auto ;
	margin-right: auto ;
 	text-align: center;
 	background-color: rgba(255, 255, 255, 0.6);
}

#text_box{
 	padding:5px 15px;
 	width:fit-content;
 	width:-webkit-fit-content;
 	width:-moz-fit-content;
 	/*border: 3px solid #5D7B85;*/
 	cursor: pointer;
 	-webkit-border-radius: 5px;
 	border-radius: 25px;
 	display: inline-block;
 	/*width: 1200px;*/
 	/*margin: 0 auto;*/
 	margin: 20px;
 	text-align: left;

}


/****************************************************************************
*																			*
*	Section:	D3 Visuals													*
*																			*
*	Purpose:	This section defines...										*
*																			*
****************************************************************************/

.operator{
	text-align: center;
}

.engineer{
	text-align: center;
}

.conductor{
	text-align: center;
}

#graph_Conductor, #graph_Engineer, #graph{
	padding:30px 30px;
	width:fit-content;
	width:-webkit-fit-content;
	width:-moz-fit-content;
	border: 3px solid #5D7B85;
	cursor:pointer;
	-webkit-border-radius: 5px;
	border-radius: 25px;
	display: inline-block;
	/*margin: 0 auto;*/
	margin: 20px;
	text-align: left;
	background-color: rgba(255, 255, 255, 0.6);
	overflow: auto;
}

.axis path,
.axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}

.bar {
  fill: steelblue;
}

.x.axis path {
  display: none;
}

div.tooltip {
    position: absolute;
    width:fit-content;
	width:-webkit-fit-content;
	width:-moz-fit-content;
    height:fit-content;
	height:-webkit-fit-content;
	height:-moz-fit-content;
    padding: 5px;
    font: 15px sans-serif;
    background: lightsteelblue;
    border: 0px;
    border-radius: 8px;
    pointer-events: none;
}

.node.active {
  fill: blue;
}

#custom_assistant_settings{
	/*display: block;*/
}

.custom{
	width: 312px;
	margin-left: auto;
	margin-right: auto;
	text-align: center;
	border: 1px dashed #888;
	border-radius: 15px;
	position: relative;
	padding-top: 25px;
	padding-bottom: 20px;
	padding-left:  55px;
	padding-right: 30px;
	background-color: rgba(255, 255, 255, 0.6);
}

#custom_heading{
/*	background-color: #467FC9;*/
/*	padding: 10px;*/
    font-family: "Lucida Grande";
}

#custom_table{
	padding: 10px;
	margin: 0 auto;
	border-collapse: collapse;
	margin-left: auto;
	margin-right: auto;
}

#custom_table td {
	padding: 5px;
}

.remove {
	display: none;
}
.hide {
	visibility: hidden;
}
