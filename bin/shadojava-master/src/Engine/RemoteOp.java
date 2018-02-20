package Engine;
import java.util.*;
import Input.loadparam;

/***************************************************************************
 *
 * 	FILE: 			RemoteOp.java
 *
 * 	AUTHOR:			ROCKY LI
 *
 * 	DATE:			2017/6/12
 *
 * 	VER: 			1.0
 *
 * 	Purpose: 		Create simulation for multiple vehicle and RemoteOp
 *
 **************************************************************************/

public class RemoteOp {

    public loadparam parameters;

    public VehicleSim[] vehicles;

    private ArrayList<Task> linkedtasks;

    private Operator[] RemoteOpers;

    private int[] linked;

    private ArrayList<Task> proctasks;

    private ArrayList<Task> tovehicle;

    private ArrayList<Task> globalTasks;

    // Constructor is HERE

    public RemoteOp(loadparam Param, ArrayList<Task> globalTasks) {
        parameters = Param;
        this.globalTasks = globalTasks;
    }

    // Inspectors:

    public ArrayList<Task> getalltasks() {
        return proctasks;
    }

    public ArrayList<Task> gettasks() {
        return tovehicle;
    }

    public Operator[] getRemoteOp() {
        return RemoteOpers;
    }

    /****************************************************************************
     *
     *	Method:			genRemoteOp
     *
     *	Purpose:		Generate RemoteOperators
     *
     ****************************************************************************/

    public void genRemoteOp() {
        // SCHEN 11/20/17
        // Note: RemoteOper is a 1d array, to fit in the data structure,
        // change it to 2d array with each subarray with length == 1
        RemoteOpers = new Operator[parameters.teamSizeTotal];
        int cnt = 0;
        for (int i = 0; i < parameters.opTasks.length; i++) {
            //TODO[COMPLETE] generate Operator base on different types of remote Ops
            for (int j = 0; j < parameters.teamSize[i]; j++) {
                RemoteOpers[cnt++] = new Operator(i * 10 + j,parameters.opNames[i], parameters.opTasks[i]);
                //DEBUG
//                System.out.println("New "+parameters.opNames[i]+", ID: "+ (i*10 + j)+" With Task: " + Arrays.toString(parameters.opTasks[i]));
            }
        }
    }
    /****************************************************************************
     *
     *	Main Method:	run
     *
     *	Purpose:		Wraps the entire objects functionality.
     *
     ****************************************************************************/

    public void run() {
//        linkedgen();
        genRemoteOp();
//        runRemoteOp();
    }

//    /****************************************************************************
//     *
//     *	Method:			linkedgen
//     *
//     *	Purpose:		Generate all the linked tasks that requires both RemoteOper and
//     *					operator input.
//     *
//     ****************************************************************************/

//    public void linkedgen() {
//
//        // Creates a new task arraylist of the tasks that are linked
//        ArrayList<Integer> linkedt = new ArrayList<Integer>();
//        linkedtasks = new ArrayList<Task>();
//
//        // Discrete Tasks owned by the RemoteOper:
//        for (int la : parameters.RemoteOpTasks) {
//
//            // Create a new empty list of Tasks
//            ArrayList<Task> indlist = new ArrayList<Task>();
//
//            // Start a new task with PrevTime = 0
//            Task newTask = new Task(la, 0, parameters, true);
//
//            if (newTask.linked())
//                continue;
//
//            // Set vehicle ID.
//            newTask.setID(-1);
//            indlist.add(newTask);
//
//            // While the next task is within the time frame, generate.
//            while (newTask.getArrTime() < parameters.numHours * 60) {
//                newTask = new Task(la, newTask.getArrTime(), parameters, true);
//                newTask.setID(-1);
//                indlist.add(newTask);
//            }
//
//            // Put all task into the master tasklist.
//
//            linkedtasks.addAll(indlist);
//
//        }
//
//        // For each vehicle:
//
//        //SCHEN 11/10/17 Modify the functionality to fit fleet heterogeneity
//        //for (int j = 0; j < parameters.numvehicles; j++) {
//        for (int k = 0; k < parameters.fleetTypes; k++) {
//
//            //For each vehicle
//            for (int j = 0; j < parameters.numvehicles[k]; j++) {
//
//                // For each type of tasks:
//                for (int i = 0; i < parameters.numTaskTypes; i++) {
//
//                    // Create a new empty list of Tasks
//                    ArrayList<Task> indlist = new ArrayList<Task>();
//
//                    // Start a new task with PrevTime = 0
//                    Task newTask = new Task(i, 0, parameters, true);
//                    if (!newTask.linked()) {
//                        continue;
//                    }
//                    linkedt.add(i);
//
//                    // Set vehicle ID.
//                    //SCHEN 11/10/17 vehicle id for 2d array
////                    System.out.println("vehicle id: " + (k*10 +j));
//                    int id = k*10 +j;
//                    newTask.setID(id);
//
//                    indlist.add(newTask);
//
//                    // While the next task is within the time frame, generate.
//                    while (newTask.getArrTime() < parameters.numHours * 60) {
//                        newTask = new Task(i, newTask.getArrTime(), parameters, true);
//                        newTask.setID(j);
//                        indlist.add(newTask);
//                    }
//
//                    // Put all task into the master tasklist.
//                    linkedtasks.addAll(indlist);
//                }
//            }
//
//            linked = linkedt.stream().mapToInt(Integer::intValue).toArray();
//        }
//    }



//    /****************************************************************************
//     *
//     *	Method:			runRemoteOp
//     *
//     *	Purpose:		generate the final state of the RemoteOper and their tasks.
//     *
//     ****************************************************************************/
//
//    public void runRemoteOp() {
//
//        VehicleSim RemoteOpSim = new VehicleSim(parameters, RemoteOpers, linkedtasks);
//        RemoteOpSim.run();
//        proctasks = new ArrayList<Task>();
//        tovehicle = new ArrayList<Task>();
//        //SCHEN 11/20/17 Changes for 2d array in VehicleSim Object
//         for(int i = 0; i < parameters.numRemoteOp; i++) {
//             for (Operator RemoteOp : RemoteOpSim.operators) {
//                 proctasks.addAll(RemoteOp.getQueue().records());
//             }
//             for (Task each : proctasks) {
//                 if (!each.checkexpired()) {
//                     if (each.linked()) {
//                         tovehicle.add(each);
//                     }
//                 }
//             }
//         }
//    }



}
