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
 * 	Purpose: 		Create simulation for multiple train and dispatch
 *
 **************************************************************************/

public class Dispatch {

    public loadparam parameters;

    public TrainSim[] trains;

    private ArrayList<Task> linkedtasks;

    private Operator[][] dispatchers;

    private int[] linked;

    private ArrayList<Task> proctasks;

    private ArrayList<Task> totrain;

    // Constructor is HERE

    public Dispatch(loadparam Param) {
        parameters = Param;
    }

    // Inspectors:

    public ArrayList<Task> getalltasks() {
        return proctasks;
    }

    public ArrayList<Task> gettasks() {
        return totrain;
    }

    public Operator[][] getDispatch() {
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

            // Set train ID.
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

        // For each train:

        //SCHEN 11/10/17 Modify the functionality to fit fleet heterogeneity
        //for (int j = 0; j < parameters.numTrains; j++) {
        for (int k = 0; k < parameters.fleetTypes; k++) {

            //For each train
            for (int j = 0; j < parameters.numTrains[k]; j++) {

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

                    // Set train ID.
                    //SCHEN 11/10/17 Train id for 2d array
//                    System.out.println("train id: " + (k*10 +j));
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
        dispatchers = new Operator[parameters.numDispatch][1];

        for (int i = 0; i < parameters.numDispatch; i++) {
            dispatchers[i][0] = new Operator(i, parameters.DispatchTasks);
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

        TrainSim DispatchSim = new TrainSim(parameters, dispatchers, linkedtasks);
        DispatchSim.run();
        proctasks = new ArrayList<Task>();
        totrain = new ArrayList<Task>();
        //SCHEN 11/20/17 Changes for 2d array in trainSim Object
         for(int i = 0; i < parameters.numDispatch; i++) {
             for (Operator dispatcher : DispatchSim.operators[i]) {
                 proctasks.addAll(dispatcher.getQueue().records());
             }
             for (Task each : proctasks) {
                 if (!each.checkexpired()) {
                     if (each.linked()) {
                         totrain.add(each);
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
