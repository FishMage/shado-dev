package Engine;
import java.util.*;
import Input.loadparam;

/***************************************************************************
 *
 * 	FILE: 			Dispatch.java
 *
 * 	AUTHOR:			ROCKY LI
 *
 * 	DATE:			2017/6/12
 *
 * 	VER: 			1.0
 *
 * 	Purpose: 		Create simulation for multiple vehicle and dispatch
 *
 **************************************************************************/

public class Dispatch {

    public loadparam parameters;

    public VehicleSim[] vehicles;

    private ArrayList<Task> linkedtasks;

    private Operator[] dispatchers;

    private int[] linked;

    private ArrayList<Task> proctasks;

    private ArrayList<Task> tovehicle;

    // Constructor is HERE

    public Dispatch(loadparam Param) {
        parameters = Param;
    }

    // Inspectors:

    public ArrayList<Task> getalltasks() {
        return proctasks;
    }

    public ArrayList<Task> gettasks() {
        return tovehicle;
    }

    public Operator[] getDispatch() {
        return dispatchers;
    }

    /****************************************************************************
     *
     *	Method:			linkedgen
     *
     *	Purpose:		Generate all the linked tasks that requires both dispatcher and
     *					operator input.
     *
     ****************************************************************************/

    public void linkedgen() {

        // Creates a new task arraylist of the tasks that are linked
        ArrayList<Integer> linkedt = new ArrayList<Integer>();
        linkedtasks = new ArrayList<Task>();

        // Discrete Tasks owned by the Dispatcher:
        for (int la : parameters.DispatchTasks) {

            // Create a new empty list of Tasks
            ArrayList<Task> indlist = new ArrayList<Task>();

            // Start a new task with PrevTime = 0
            Task origin = new Task(la, 0, parameters, true);

            if (origin.linked())
                continue;

            // Set vehicle ID.
            origin.setID(-1);
            indlist.add(origin);

            // While the next task is within the time frame, generate.
            while (origin.getArrTime() < parameters.numHours * 60) {
                origin = new Task(la, origin.getArrTime(), parameters, true);
                origin.setID(-1);
                indlist.add(origin);
            }

            // Put all task into the master tasklist.

            linkedtasks.addAll(indlist);

        }

        // For each vehicle:

        //SCHEN 11/10/17 Modify the functionality to fit fleet heterogeneity
        //for (int j = 0; j < parameters.numvehicles; j++) {
        for (int k = 0; k < parameters.fleetTypes; k++) {

            //For each vehicle
            for (int j = 0; j < parameters.numvehicles[k]; j++) {

                // For each type of tasks:
                for (int i = 0; i < parameters.numTaskTypes; i++) {

                    // Create a new empty list of Tasks
                    ArrayList<Task> indlist = new ArrayList<Task>();

                    // Start a new task with PrevTime = 0
                    Task origin = new Task(i, 0, parameters, true);
                    if (!origin.linked()) {
                        continue;
                    }
                    linkedt.add(i);

                    // Set vehicle ID.
                    //SCHEN 11/10/17 vehicle id for 2d array
//                    System.out.println("vehicle id: " + (k*10 +j));
                    int id = k*10 +j;
                    origin.setID(id);

                    indlist.add(origin);

                    // While the next task is within the time frame, generate.
                    while (origin.getArrTime() < parameters.numHours * 60) {
                        origin = new Task(i, origin.getArrTime(), parameters, true);
                        origin.setID(j);
                        indlist.add(origin);
                    }

                    // Put all task into the master tasklist.
                    linkedtasks.addAll(indlist);
                }
            }

            linked = linkedt.stream().mapToInt(Integer::intValue).toArray();
        }
    }

    /****************************************************************************
     *
     *	Method:			genDispatch
     *
     *	Purpose:		Generate dispatchers
     *
     ****************************************************************************/

    public void genDispatch() {
        // SCHEN 11/20/17
        // Note: Dispatcher is a 1d array, to fit in the data structure,
        // change it to 2d array with each subarray with length == 1
        dispatchers = new Operator[parameters.numDispatch];

        for (int i = 0; i < parameters.numDispatch; i++) {
            dispatchers[i] = new Operator(i, parameters.DispatchTasks);
        }
    }

    /****************************************************************************
     *
     *	Method:			runDispatch
     *
     *	Purpose:		generate the final state of the dispatcher and their tasks.
     *
     ****************************************************************************/

    public void runDispatch() {

        VehicleSim DispatchSim = new VehicleSim(parameters, dispatchers, linkedtasks);
        DispatchSim.run();
        proctasks = new ArrayList<Task>();
        tovehicle = new ArrayList<Task>();
        //SCHEN 11/20/17 Changes for 2d array in VehicleSim Object
         for(int i = 0; i < parameters.numDispatch; i++) {
             for (Operator dispatcher : DispatchSim.operators) {
                 proctasks.addAll(dispatcher.getQueue().records());
             }
             for (Task each : proctasks) {
                 if (!each.checkexpired()) {
                     if (each.linked()) {
                         tovehicle.add(each);
                     }
                 }
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

        linkedgen();
        genDispatch();
        runDispatch();

    }
}
