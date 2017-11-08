package Engine;
import java.util.*;

/***************************************************************************
 *
 * 	FILE: 			Queue.java
 *
 * 	AUTHOR: 		ROCKY LI
 *
 * 	DATE:			2017/6/5
 *
 * 	VER: 			1.1
 *
 * 	Purpose: 		Queue up each of the workers, and order tasks according
 * 	                to their priority and arrival time.
 *
 **************************************************************************/

public class Queue implements Comparable<Queue>{

    // The Queue is represented by a priority queue of task objects:

    public PriorityQueue<Task> taskqueue;

    // Operator ID.

    public Operator operator;

    // Set the time to move forward with general time. (Tracer variable)

    private double time;

    // See if the Queue is populated or not

    private boolean isBusy;

    // Expected time to complete the current task in queue

    private double finTime;

    // Number of tasks in the queue

    private int NumTask;

    // Record all done tasks for data analysis

    private ArrayList<Task> recordtasks = new ArrayList<>();

    // inspectors:

    public ArrayList<Task> records() {
        return recordtasks;
    }

    public double getfinTime() {
        return finTime;
    }

    public int getNumTask() {
        return NumTask;
    }

    public boolean getStatus() {
        return isBusy;
    }

    // Mutator:

    public void SetTime(double Time) {
        this.time = Time;
    }

    @Override
    public int compareTo(Queue other) {
        return this.NumTask - other.NumTask;
    }

    /****************************************************************************
     *
     *	Main Object:	Queue
     *
     *	Purpose:		Create an empty queue at the start
     *
     ****************************************************************************/

    public Queue() {
        taskqueue = new PriorityQueue<Task>();
        time = 0;
        finTime = Double.POSITIVE_INFINITY;
    }

    /****************************************************************************
     *
     *	Method:			Add
     *
     *	Purpose:		add a task to queue.
     *
     ****************************************************************************/

    public void add(Task task) {

        // Set the time of the queue to the arrival time of the task.

        SetTime(task.getArrTime());
        if (!taskqueue.isEmpty()) {
            if (task.getPriority() > taskqueue.peek().getPriority()) {
                taskqueue.peek().setELStime(task.getArrTime() - taskqueue.peek().getBeginTime());
            }
        }
        taskqueue.add(task);

        // If the task is processed as first priority, i.e. began immediately, then:

        if (taskqueue.peek().equals(task)) {
            taskqueue.peek().setBeginTime(time);
            finTime();
        }

        // Else since the task is put behind in the queue, no other queue attribute need to change
        // except numTask.

        numtask();
    }

    /****************************************************************************
     *
     *	Method:			done
     *
     *	Purpose:		remove a finished task from the queue when its finished
     *					 and update queue attributes
     *
     ****************************************************************************/

    public void done() {

        // This if statement avoids error when calling done on an empty queue.

        if (taskqueue.peek() != null) {

            // Set the end time of the task being finished.

            taskqueue.peek().setEndTime(finTime);

            taskqueue.peek().setQueue(NumTask);

            taskqueue.peek().setELStime(taskqueue.peek().getSerTime());

            // Remove the finished task from the queue and put it into record task list.

            recordtasks.add(taskqueue.poll());

            // Renew the queue time.

            SetTime(finTime);
        }

        // If there are ANOTHER task in the queue following the completion of this one:

        while (taskqueue.peek() != null) {

            if (taskqueue.peek().getExpTime() > time) {
                break;
            }

            // Add expired tasks to the record

            taskqueue.peek().setexpired();
            recordtasks.add(taskqueue.poll());

        }

        if (taskqueue.peek() != null) {

            // Set the beginTime of the Task in question to now, i.e. begin working on this task.

            taskqueue.peek().setBeginTime(time);
        }

        // Generate a new finTime for the Queue.

        finTime();

        // Generate a new numTask for the Queue.

        numtask();

    }

    /****************************************************************************
     *
     *	Method:			finTime
     *
     *	Purpose:		calculate the finish time of the present task and return it
     *					as an attribute of the queue at current time.
     *
     ****************************************************************************/

    private void finTime() {

        // If there is no current task, the finTime will be infinite.

        if (taskqueue.peek() == null) {
            finTime = Double.POSITIVE_INFINITY;
        }

        // Otherwise grab the current task and return a finish time.

        else {
            Task onhand = taskqueue.peek();
            finTime = onhand.getBeginTime() + onhand.getSerTime() - onhand.getELSTime();

            // Error checker

//            System.out.println(onhand.getArrTime() + "\t" + onhand.getName() + "\t" +
//            onhand.getBeginTime() + "\t" + onhand.getEndTime());

        }
    }

    /****************************************************************************
     *
     *	Method:			numtask
     *
     *	Purpose:		return the number of tasks in the queue and if there are no
     *					task return state of the current queue as NOT BUSY.
     *
     ****************************************************************************/

    private void numtask() {

        NumTask = taskqueue.size();
        if (NumTask == 0) {
            isBusy = false;
        } else {
            isBusy = true;
        }
    }


}
