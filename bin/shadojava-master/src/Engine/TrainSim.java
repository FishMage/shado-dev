package Engine;
import java.util.*;
import java.util.stream.*;
import Input.loadparam;

/***************************************************************************
 * 
 * 	FILE: 			TrainSim.java
 * 
 * 	AUTHOR: 		ROCKY LI
 * 	
 * 	DATA:			2017/6/2
 * 
 * 	VER: 			1.0
 * 
 * 	Purpose: 		Create and manage the simulation of a single train.
 * 
 **************************************************************************/


public class TrainSim {

    // The parameters loaded from file

    public loadparam parameters;

    public Operator[] operators;

    public int trainID;

    // This is an arraylist of ALL tasks in the order that they're arriving.

    public ArrayList<Task> tasktime;

    // Inspectors

    public int getTrainID() {
        return trainID;
    }

    public double getTotalTime() {
        return parameters.numHours * 60;
    }

    // Mutator

    public void linktask(Task task) {
        tasktime.add(task);
    }

    /****************************************************************************
     *
     *	Side Object:	TrainSim
     *
     *	Purpose:		Create a simulation for Dispatcher using the same logic
     *
     ****************************************************************************/

    public TrainSim(loadparam param, Operator[] dis, ArrayList<Task> list) {
        tasktime = list;
        operators = dis;
        parameters = param;
    }

    /****************************************************************************
     *
     *	Main Object:	TrainSim
     *
     *	Purpose:		Create a simulation for a single train.
     *
     ****************************************************************************/

    public TrainSim(loadparam param, int trainid) {
        parameters = param;
        trainID = trainid;
    }

    /****************************************************************************
     *
     *	Method:			taskgen
     *
     *	Purpose:		Generate a list of task based on time order.
     *
     ****************************************************************************/

    public void taskgen() {

        tasktime = new ArrayList<Task>();

        // For each type of tasks:

        for (int i = 0; i < parameters.numTaskTypes; i++) {

            // Create a new empty list of Tasks

            ArrayList<Task> indlist = new ArrayList<Task>();

            // Start a new task with PrevTime = 0

            Task origin;

            if (parameters.arrPms[i][0] == 0){
                origin = new Task (i, 30 + Math.random(), parameters, false);
            } else {
                origin = new Task(i, 0, parameters, true);
            }

            if (origin.linked()) {
                continue;
            }

            origin.setID(trainID);
            indlist.add(origin);

            // While the next task is within the time frame, generate.

            while (origin.getArrTime() < parameters.numHours * 60) {
                origin = new Task(i, origin.getArrTime(), parameters, true);
                origin.setID(trainID);
                indlist.add(origin);
            }

            // Put all task into the master tasklist.

            tasktime.addAll(indlist);
        }

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

        operators = new Operator[parameters.ops.length];
        for (int i = 0; i < parameters.ops.length; i++) {
            operators[i] = new Operator(i, parameters);
        }

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

        for (int i = 0; i < operators.length; i++) {
            if (IntStream.of(operators[i].taskType).anyMatch(x -> x == task.getType())) {
                proc.add(operators[i].getQueue());
                working.add(operators[i]);

            }
        }

        // Sort queue by tasks queued.

        Collections.sort(proc);

        // Before inserting new tasks, make sure all the tasks that can be finished
        // before the arrival of the new tasks is finished.

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
     *	Purpose:		Generate the base set of data in TrainSim object.
     *
     ****************************************************************************/

    public void genbasis() {

        // Generate stuff
        taskgen();
        operatorgen();

    }


    /****************************************************************************
     *
     *	Main Method:	run
     *
     *	Purpose:		run the simulation based on time order.
     *
     ****************************************************************************/

    public void run() {

//        addTriggered();

        sortTask();

        // Put tasks into queue at appropriate order.

        for (Task task : tasktime) {
            puttask(task);
        }

        // Finish tasks if no new tasks comes in.

        double totaltime = parameters.numHours * 60;
        for (Operator each : operators) {
            while (each.getQueue().getfinTime() < totaltime) {
                each.getQueue().done();
            }
        }

    }

}
