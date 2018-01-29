package Engine;
import java.util.*;
import java.util.stream.*;
import Input.loadparam;

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

    public Operator[] dispatchers;

    public int vehicleID;

    // NEW feature: AI Assistant
    // SCHEN 1/20/18 whether AI is present in this fleetType
    public boolean hasAI;

    // This is an arraylist of ALL tasks in the order that they're arriving.

    public ArrayList<Task> tasktime;

    // Inspectors

    public int getvehicleID() {
        return vehicleID;
    }

    public double getTotalTime() {
        return parameters.numHours * 60;
    }

    // Mutator

    public void linktask(Task task) {
        tasktime.add(task);
    }

    //SCHEN 12/16/17 Modify fleet heterogeniety, fix bug: all vehicle has all operator settings
    public int vehicleType;
    /****************************************************************************
     *
     *	Side Object:	VehicleSim
     *
     *	Purpose:		Create a simulation for Dispatcher using the same logic
     *
     ****************************************************************************/

    public VehicleSim(loadparam param, Operator[] dis, ArrayList<Task> list) {
        tasktime = list;
        operators = dis;
        parameters = param;
    }

    /****************************************************************************
     *
     *	Main Object:	VehicleSim
     *
     *	Purpose:		Create a simulation for a single vehicle.
     *
     ****************************************************************************/

    public VehicleSim(loadparam param, int vehicleid) {
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
        tasktime = new ArrayList<Task>();

        // TODO[COMPLETED] add AI assitant to shorter the service time.
        // For each type of tasks:

        //If teamCoord Presents task number = total tasknum -1
        for (int i = 0; i < parameters.numTaskTypes + checkTeamCoord(); i++) {

            // Create a new empty list of Tasks

            ArrayList<Task> indlist = new ArrayList<Task>();

            // Start a new task with PrevTime = 0

            Task origin;
            // TODO[COMPLETED] add Internal communication task

            // if hasAI, use overloaded constructor
            if (parameters.arrPms[i][0] == 0){ //First task
                if(checkAI()) {
                    origin = new Task(i, 30 + Math.random(), parameters, false, true, parameters.teamComm[0]); //New Task
                }
                else
                    origin = new Task (i, 30 + Math.random(), parameters, false); //Old task
            } else {
                if(checkAI()) {
                    origin = new Task(i, 0, parameters, true, true, parameters.teamComm[0]);
                }
                else
                    origin = new Task(i, 0, parameters, true);
            }

            if (origin.linked()) {
                continue;
            }

            origin.setID(vehicleID);
            indlist.add(origin);

            // While the next task is within the time frame, generate.

            while (origin.getArrTime() < parameters.numHours * 60) {
                origin = new Task(i, origin.getArrTime(), parameters, true);
                origin.setID(vehicleID);
                indlist.add(origin);
            }

            // Put all task into the master tasklist.

            tasktime.addAll(indlist);
        }
        System.out.println("    - Number of Task: " + tasktime.size());

    }

    public void sortTask() {

        // Sort task by time.

        Collections.sort(tasktime, (o1, o2) -> Double.compare(o1.getArrTime(), o2.getArrTime()));
    }

    public void addTriggered() {

        for (Task each : tasktime) {
            int i = each.getType();

            if (parameters.trigger[i][0] != -1) {
                for (Integer that : parameters.trigger[i]) {
                    tasktime.add(new Task(that, each.getArrTime(), parameters, false));
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
        //TODO[COMPLETE]: Create Different Operatorset for different types of vehicles
//        operators = new Operator[parameters.ops.length];
        int fleetType = vehicleID/10;
        operators = new Operator[parameters.numOps];
//        System.out.println("****FleetType:****");
//        for (int i = 0; i < parameters.fleetTypes; i++) {
            for(int j = 0; j < parameters.numOps; j++) {
//                System.out.print(parameters.fleetHetero[i][j]+ ", ");
                operators[j] = new Operator(j, parameters);
                if(operators[j].getName().equals("Artificially Intelligent Agent")) hasAI = true;
            }
//            System.out.println();
//        }
//        System.out.println("-----Single Rep Scan Complete------");
    }

    /****************************************************************************
     *
     *	Method:			puttask
     *
     *	Purpose:		putting tasks into the operator that can operate the task
     * 					with the least queue.
     *
     ****************************************************************************/

    public void puttask(Task task) {

        // Create a new arraylist of queue:

        ArrayList<Queue> proc = new ArrayList<Queue>();

        ArrayList<Operator> working = new ArrayList<>(proc.size());

        // If the task can be operated by this operator, get his queue.

//        for (int i = 0; i < operators.length; i++) {
            for(int j = 0; j < operators.length; j++ ){
                if(operators[j] != null) {
                    if (IntStream.of(operators[j].taskType).anyMatch(x -> x == task.getType())) {
                        proc.add(operators[j].getQueue());
                        working.add(operators[j]);
                    }
                }
//            }
        }

        // Sort queue by tasks queued.
        Collections.sort(proc);

        // Before inserting new tasks, make sure all the tasks that can be finished
        // before the arrival of the new tasks is finished.
        // NEW FEATURE: AI Assistant

        while (proc.get(0).getfinTime() < task.getArrTime()) {
            proc.get(0).done();
        }
        // add task to queue.
        // **** I'm setting the operator so that we can access the data arrays of each operator ****
        proc.get(0).operator = working.get(0);
        proc.get(0).add(task);

    }

    /****************************************************************************
     *
     *	Method:			genbasis
     *
     *	Purpose:		Generate the base set of data in VehicleSim object.
     *
     ****************************************************************************/

    public void genbasis() {
        // Generate stuff
        checkAI();
        taskgen();
        operatorgen();
    }
    /****************************************************************************
     *
     *	Method:			checkAI
     *
     *	Purpose:	    check Whether AI is present in this FleetType
     *
     ****************************************************************************/
    public boolean checkAI(){
        return this.hasAI;
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
        for (Task task : tasktime) {
            puttask(task);
        }

        // Finish tasks if no new tasks comes in.

        double totaltime = parameters.numHours * 60;
//        for(int i = 0; i < operators.length; i++) {
            for (Operator each : operators) {
                if (each != null) {
                    while (each.getQueue().getfinTime() < totaltime) {
                        each.getQueue().done();
                    }
                }
        }
    }

}
