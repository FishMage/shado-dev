package Engine;
import java.util.*;
import java.util.stream.*;
import Input.loadparam;
import javafx.util.Pair;

/***************************************************************************
 *
 * 	FILE: 			VehicleSim.java
 *
 * 	AUTHOR: 		ROCKY LI
 *
 * 	DATA:			2017/6/2
 *
 * 	VER: 			1.0
 *
 * 	Purpose: 		Create and manage the simulation of a single vehicle.
 *
 **************************************************************************/


public class VehicleSim {

    // The parameters loaded from file

    public loadparam parameters;

    public Operator[] operators;

    public Operator[] RemoteOpers;

    public int vehicleID;

    // NEW feature: AI Assistant
    // SCHEN 1/20/18 whether AI is present in this fleetType
    public boolean hasAI;

    // This is an arraylist of ALL tasks in the order that they're arriving.

    public ArrayList<Task> globalTasks;

    // Inspectors

    public int getvehicleID() {
        return vehicleID;
    }

    public boolean checkAI(){
        return this.hasAI;
    }

    public double getTotalTime() {
        return parameters.numHours * 60;
    }

    // Mutator

    public void linktask(Task task) {
        globalTasks.add(task);
    }

    //SCHEN 12/16/17 Modify fleet heterogeniety, fix bug: all vehicle has all operator settings
    public int vehicleType;
    /****************************************************************************
     *
     *	Side Object:	VehicleSim
     *
     *	Purpose:		Create a simulation for RemoteOper using the same logic
     *
     ****************************************************************************/

    public VehicleSim(loadparam param, Operator[] remoteOps, ArrayList<Task> list) {
        globalTasks = list;
        operators = remoteOps;
        parameters = param;
    }

    /****************************************************************************
     *
     *	Main Object:	VehicleSim
     *
     *	Purpose:		Create a simulation for a single vehicle.
     *
     ****************************************************************************/

    public VehicleSim(loadparam param, int vehicleid,  Operator[] remoteOps, ArrayList<Task> list) {
        globalTasks = list;
        operators = remoteOps;
        parameters = param;
        vehicleID = vehicleid;
    }

    /****************************************************************************
     *
     *	Method:			taskgen
     *
     *	Purpose:		Generate a list of task based on time order.
     *
     ****************************************************************************/

    public void taskgen() {
        System.out.println("TaskGen for vehicle ID: "+ vehicleID);


        // TODO[COMPLETED] add AI assitant to shorter the service time.
        // For each type of tasks:
        int fleetType = this.vehicleID/10;
        for(int i = 0; i < parameters.numRemoteOp; i++){
            if(operators[i].getName().equals("Artificially Intelligent Agent"))
                this.hasAI = true;
        }
        //If teamCoord Presents task number = total tasknum -1
        for (int i = 0; i < parameters.fleetHetero[fleetType].length; i++) {

            // Create a new empty list of Tasks

            ArrayList<Task> indlist = new ArrayList<Task>();

            // Start a new task with PrevTime = 0

            Task newTask;
            // if hasAI, use overloaded constructor

            int taskType = parameters.fleetHetero[fleetType][i];
            //DEBUG
//            System.out.println("Now Generating Task type: "+taskType +", Fleet Type:" + fleetType);
                if (parameters.arrPms[i][0] == 0) { //First task
                    if (checkAI()) {
                        newTask = new Task(taskType, 30 + Math.random(), parameters, false, true, parameters.teamComm[0]); //New Task
                    } else
                        newTask = new Task(taskType, 30 + Math.random(), parameters, false); //Old task
                } else {

                    if (checkAI()) {
                        newTask = new Task(taskType, 0, parameters, true, true, parameters.teamComm[0]);
                    } else
                        newTask = new Task(taskType, 0, parameters, true);

                }

                // While the next task is within the time frame, generate.

                while (newTask.getArrTime() < parameters.numHours * 60) {
                    newTask = new Task(i, newTask.getArrTime(), parameters, true);
                    newTask.setID(vehicleID);
                    // TODO if the queue is idle;
//                    globalTasks.add(newTask);
                    indlist.add(newTask);
                }


            // Put all task into the master tasklist.

//            globalTasks.addAll(indlist);
            System.out.println("    -Type :"+taskType+" Total Number of Task gen: " + indlist.size());
        }

    }

    public void sortTask() {

        // Sort task by time.

        Collections.sort(globalTasks, (o1, o2) -> Double.compare(o1.getArrTime(), o2.getArrTime()));
    }

    public void addTriggered() {

        for (Task each : globalTasks) {
            int i = each.getType();

            if (parameters.trigger[i][0] != -1) {
                for (Integer that : parameters.trigger[i]) {
                    globalTasks.add(new Task(that, each.getArrTime(), parameters, false));
                }
            }
        }
    }

    /****************************************************************************
     *
     *	Method:			operatorgen
     *
     *	Purpose:		Generate an array of operators.
     *
     ****************************************************************************/

    public void operatorgen() {

        // Create Operators
        //SCHEN 11/20/17:
        //TODO[COMPLETED]: Create Different Operatorset for different types of vehicles
//        operators = new Operator[parameters.ops.length];
        int fleetType = vehicleID/10;
        operators = new Operator[parameters.numOps];
//        System.out.println("****FleetType:****");
//        for (int i = 0; i < parameters.fleetTypes; i++) {
        for(int j = 0; j < parameters.numOps; j++) {
//                System.out.print(parameters.fleetHetero[i][j]+ ", ");
//            operators[j] = new Operator(j, parameters);
            if(operators[j].getName().equals("Artificially Intelligent Agent")) hasAI = true;
        }
//            System.out.println();
//        }
//        System.out.println("-----Single Rep Scan Complete------");
    }


    /****************************************************************************
     *
     *	Method:			genVehicleTask
     *
     *	Purpose:		Generate the base set of data in VehicleSim object.
     *
     ****************************************************************************/

    public void genVehicleTask() {
        taskgen();
    }

    /****************************************************************************
     *
     *	Method:			checkTeamCoord
     *
     *	Purpose:	    check Whether teamCoordination is present in this simulation
     *
     ****************************************************************************/
    public int checkTeamCoord(){
        for(char c: parameters.teamComm){
//            System.out.println("Team Coord presents");
            if(c != 'N') return 0;
        }
        return -1;
    }



    /****************************************************************************
     *
     *	Main Method:	run
     *
     *	Purpose:		run the simulation based on time order.
     *
     ****************************************************************************/

    public void run() {

        //  addTriggered();

        // SCHEN 1/20/18 Operator Strategies
        //if STF( "Shortest task first") Sort, else: FIFO
        if(parameters.opStrats.equals("STF"))
            sortTask();

        // Put tasks into queue at appropriate order.
//        System.out.println("Total Tasks: "+globalTasks.size());
//        for (Task task : globalTasks) {
//                puttask(task);
//
//        }

        // Finish tasks if no new tasks comes in.
        double totaltime = parameters.numHours * 60;
        for (Operator each : operators) {
            if (each != null) {
                while (each.getQueue().getfinTime() < totaltime) {
                    each.getQueue().done();
                }
            }
        }
    }
}
