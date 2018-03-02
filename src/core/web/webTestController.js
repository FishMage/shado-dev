var total_num_fleet = 0;
var total_num_team = 0;
var total_num_exo = 0;
var total_num_task= 0;
var num_phases = 2;
var operator_names=["Dispatcher","Operations Management Specialist","Artificially Intelligent Agent"];
var task_names = ["Communicating","Actuation","Directive_Mandatory","Directive_Courtesy_1","Directive_Courtesy_2","Record Keeping","Referencing"];
var priorities = [[4,7],[5,5],[2,5],[5,3],[3,4],[3,2],[3,4],[3,2],[3,1]];
function submit(){
  alert("JSON SUBMITTED!");
}

function popFleetTypes(){
  var num_fleet = document.getElementById("num_fleet_types");
  var selected_fleet_num = num_fleet.options[num_fleet.selectedIndex].value;
  // if(document.getElementById("header_fleet_type").isHidden)
  if(total_num_fleet!=0){
    for(var i = 0; i < total_num_fleet; i++){
      var fid = "fleet_type_"+i;
      var lid = "lbl_fleet_"+i
      var fsid = "lbl_fleet_size"+i;
      var lsid = "lbl_fleet_size"+i
      if(document.getElementById(fid)!=null)
      document.getElementById(fid).remove();
      if (document.getElementById(lid)!=null)
      document.getElementById(lid).remove();
      if(document.getElementById(fsid)!=null)
      document.getElementById(fsid).remove();
      if(document.getElementById(lsid)!=null)
      document.getElementById(lsid).remove();
    }
  }
  total_num_fleet = selected_fleet_num;
  // alert("total_num_fleet"+total_num_fleet);
  for(var i = 0; i < total_num_fleet; i++){
    $( ".fleet_option" ).append( "<lable id='lbl_fleet_"+i+"' value ='Fleet Type"+i+"'>Fleet Type"+i+"'s Tasks </label> "+
    " <input id='fleet_type_"+i+"' placeholder='0,1,2,3,4,5,6,7'></input>"+
    "   <lable id='lbl_fleet_size"+i+"' value ='Fleet Type"+i+"'>   size </label> "+
    "<input id='fleet_type_size"+i+"' placeholder='2'></input><br><br>");
  }

}


function popTeamTypes(){
  var num_teams = document.getElementById("num_teams");
  var selected_num_teams = num_teams.options[num_teams.selectedIndex].value;
  // if(document.getElementById("header_fleet_type").isHidden)
  if(total_num_team!=0){
    for(var i = 0; i < total_num_team; i++){
      var fid = "team_type_"+i;
      var lid = "lbl_team_"+i
      var fsid = "lbl_team_size"+i;
      var lsid = "lbl_team_"+i
      var tnid = "lbl_team_name_"+i;
      var ltnid = "lbl_team_name_"+i;
      var tcomid = "select_team_comm_"+i;
      var tstid = "select_team_strat_"+i;
      if(document.getElementById(fid)!=null)
      document.getElementById(fid).remove();
      if (document.getElementById(lid)!=null)
      document.getElementById(lid).remove();
      if(document.getElementById(fsid)!=null)
      document.getElementById(fsid).remove();
      if(document.getElementById(lsid)!=null)
      document.getElementById(lsid).remove();
      if(document.getElementById(tnid)!=null)
      document.getElementById(tnid).remove();
      if(document.getElementById(ltnid)!=null)
      document.getElementById(ltnid).remove();
      if(document.getElementById(tcomid)!=null)
      document.getElementById(tcomid).remove();
      if(document.getElementById(tstid)!=null)
      document.getElementById(tstid).remove();
    }
  }
  total_num_team = selected_num_teams;
  // alert("total_num_fleet"+total_num_fleet);
  for(var i = 0; i < total_num_team; i++){
    $( ".team_option" ).append( "<lable id='lbl_team_name_"+i+"' value =''>  Operator Team "+i+"'s Name </label> "+
    "<input id='team_name_"+i+"' value='"+operator_names[i]+"' placeholder='"+operator_names[i]+"'></input>"+
    "<lable id='lbl_team_"+i+"' value =''> Tasks </label> "+
    " <input id='team_type_"+i+"' value='0,1,2,3,4,5,6,7' placeholder='0,1,2,3,4,5,6,7'></input>"+
    "   <lable id='lbl_team_size"+i+"' value =''>   size </label> "+
    "<input id='team_type_size"+i+"' value='2'placeholder='2'></input>"+
    "  <select id='select_team_comm_"+i+"'> "+
    "<option selected disabled hidden>Choose Team Communication</option>"+
    "<option value='N'>None</option> "+
    "<option value='L'>Low</option>"+
    "<option value='F'>Full</option> </select> "+
    "<select id='select_team_strat_"+i+"'> "+
    "<option selected disabled hidden>Choose Team Strategy</option>"+
    "<option value='N'>FIFO</option> "+
    "<option value='L'>Shortest Tast First</option>"+
    "<option value='F'>Priority</option> </select><br><br>"
  );
}
}


function popExoFactor(){
  var num_exo = document.getElementById("num_exo");
  var selected_num_exo = num_exo.options[num_exo.selectedIndex].value;
  // if(document.getElementById("header_fleet_type").isHidden)
  if(total_num_exo!=0){
    for(var i = 0; i < total_num_exo; i++){
      var fid = "exo_type_"+i;
      var lid = "lbl_exo_"+i
      var fsid = "lbl_exo_size"+i;
      var lsid = "lbl_exo_size"+i
      if(document.getElementById(fid)!=null)
      document.getElementById(fid).remove();
      if (document.getElementById(lid)!=null)
      document.getElementById(lid).remove();
      if(document.getElementById(fsid)!=null)
      document.getElementById(fsid).remove();
      if(document.getElementById(lsid)!=null)
      document.getElementById(lsid).remove();
    }
  }
  total_num_exo = selected_num_exo;
  // alert("total_num_fleet"+total_num_fleet);
  for(var i = 0; i < total_num_exo; i++){
    $( ".exo_option" ).append( "<lable id='lbl_exo_"+i+"' value ='Exogenous Factor Type"+i+"'>Exo Type"+i+"'s Name </label> "+
    " <input id='exo_type_"+i+"' placeholder='Medical'></input>"+
    "   <lable id='lbl_exo_size"+i+"' value =''>   type </label> "+
    "<input id='exo_type_size"+i+"' placeholder='add_task'></input><br><br>");
  }
}

function popTask(){
  var num_task = document.getElementById("num_task");
  var selected_num_task = num_task.options[num_task.selectedIndex].value;


  if(total_num_task!=0){
    for(var i = 0; i < total_num_task; i++){
      var a = "lbl_name_"+i;
      var b = "txt_task_name"+i
      var c = "lbl_priority_"+i;
      var d = "txt_priority_"+i
      var e = "lbl_arr_pm_dist_"+i;
      var f = "txt_arr_pm_dist_"+i;
      var g = "lbl_serv_pm_dist_"+i;
      var h = "txt_serv_pm_dist_"+i;
      if(document.getElementById(a)!=null)
      document.getElementById(a).remove();
      if (document.getElementById(b)!=null)
      document.getElementById(b).remove();
      if(document.getElementById(c)!=null)
      document.getElementById(c).remove();
      if(document.getElementById(d)!=null)
      document.getElementById(d).remove();
      if(document.getElementById(e)!=null)
      document.getElementById(e).remove();
      if(document.getElementById(f)!=null)
      document.getElementById(f).remove();
      if(document.getElementById(g)!=null)
      document.getElementById(g).remove();
      if(document.getElementById(h)!=null)
      document.getElementById(h).remove();
    }
  }
  total_num_task = selected_num_task;
  for(var i = 0; i < total_num_task; i++){
    $( ".task_option" ).append( "<lable id='lbl_name_"+i+"' value ='Exogenous Factor Type"+i+"'>Name </label> "+
    "<input id='txt_task_name"+i+"' value='"+task_names[i]+"'placeholder='"+task_names[i]+"'></input>"+
    "<lable id='lbl_priority_"+i+"' value ='Exogenous Factor Type"+i+"'>Priority </label> "+
    "<input id='txt_priority_"+i+"' value='"+priorities[i]+"' placeholder='"+priorities[i]+"'></input>"+
    "<lable id='lbl_arr_pm_dist_"+i+"' value ='Arrival Dist"+i+"'>Arrival Dist </label>"+
    "<input id='txt_arr_pm_dist_"+i+"' value='E' placeholder='E'></input>"+
    "<lable id='lbl_serv_pm_dist_"+i+"' value ='Service Dist"+i+"'>Service Dist </label>"+
    "<input id='txt_serv_pm_dist_"+i+"' value='U' placeholder='U'></input><br>");
  }
}
