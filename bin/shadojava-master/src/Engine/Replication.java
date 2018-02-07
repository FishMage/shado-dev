package Engine;

import Engine.RemoteOp;
import Engine.Simulation;
import Engine.Task;
import Engine.VehicleSim;
import Input.loadparam;
import java.util.*;
//import org.javatuples.Tuple;
import java.util.stream.*;
import Input.loadparam;
import javafx.util.Pair;
import java.util.ArrayList;
import java.util.stream.IntStream;

/***************************************************************************
 *
 * 	FILE: 			Replication.java
 *
 * 	AUTHOR: 		Erin Song
 *
 * 	DATE:			2017/6/22
 *
 * 	VER: 			1.1
 *
 * 	Purpose: 		A wrapper that execute each replication.
 * 	                Styling and code streamlining are added by Rocky.
 *
 **************************************************************************/

public class Replication {

    public loadparam parameters;

    private int repID;

    private ArrayList<Task> linked;

    private VehicleSim[][] vehicles;

    private RemoteOp remoteOps;

    private ArrayList<Task> globalTasks;

    private ArrayList<Pair <Operator,Task>> failedTasks;

    // Inspectors:

    public VehicleSim[][] getvehicles() {
        return vehicles;
    }

    public RemoteOp getRemoteOp() {
        return remoteOps;
    }

    public int getRepID() {
        return repID;
    }

    /****************************************************************************
     *
     *	Main Object:    Replication
     *
     *	Purpose:		The object that contains a simulation run and all its data.
     *
     ****************************************************************************/

    public Replication(loadparam param, int id) {
        parameters = param;
        this.repID = id;
        parameters.failTaskCount.put(parameters.replicationTracker,0);
        failedTasks = new ArrayList<>();
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
        for(int j = 0; j < remoteOps.getRemoteOp().length; j++ ){
            if(remoteOps.getRemoteOp()[j] != null) {
                if (IntStream.of(remoteOps.getRemoteOp()[j].taskType).anyMatch(x -> x == task.getType())) {
                    //Put task in appropriate Queue
//                    System.out.println("    Adding Task "+task.getType()+" to-> "+remoteOps.getRemoteOp()[j].getName()
//                    +", Current queue Size: " + remoteOps.getRemoteOp()[j].getQueue().taskqueue.size());
//                        proc.add(operators[j].getQueue());
                    working.add(remoteOps.getRemoteOp()[j]);

                }
            }
//            }
        }
        if(working.size()==0)
            return;

        // Sort queue by tasks queued.
        //Collections.sort(proc);

        //SCHEN 2/7 Fix: to get the shortest Queue of Operators

        Operator optimal_op = working.get(0);
        for(Operator op: working){
            if(op.getQueue().taskqueue.size() <= optimal_op.getQueue().taskqueue.size()){
                if(op.getQueue().taskqueue.size() == optimal_op.getQueue().taskqueue.size()) {
                    if (Math.random() > 0.5)
                        optimal_op = op;
                }
                else
                    optimal_op = op;

            }
        }
//        System.out.println("Optimal Operator: " +optimal_op.getName());


        // Before inserting new tasks, make sure all the tasks that can be finished
        // before the arrival of the new tasks is finished.
        // NEW FEATURE: AI Assistant

        while (optimal_op.getQueue().getfinTime() < task.getArrTime()) {
            optimal_op.getQueue().done();
        }
        // add task to queue.
        // **** I'm setting the operator so that we can access the data arrays of each operator ****
//        proc.get(0).operator = working.get(0);
        if(!failTask(optimal_op,task, task.getType(),getTriangularDistribution(task.getType()))){
            optimal_op.getQueue().add(task);
        }
    }

    /****************************************************************************
     *
     *	Method:		    getTriangularDistribution
     *
     *	Purpose:	    generate a TriangularDistribution value
     *
     ****************************************************************************/
    private double getTriangularDistribution(int Type){
        double c = parameters.humanError[Type][0];
        double a = parameters.humanError[Type][1];
        double b = parameters.humanError[Type][2];

        double F = (c - a)/(b - a);
        double rand = Math.random();
//        System.out.print("Triangular Distribution: ");
        if (rand < F) {
//            System.out.println( a + Math.sqrt(rand * (b - a) * (c - a)));
            return a + Math.sqrt(rand * (b - a) * (c - a));
        } else {
//            System.out.println( b - Math.sqrt((1 - rand) * (b - a) * (b - c)));
            return b - Math.sqrt((1 - rand) * (b - a) * (b - c));

        }
    }
    /****************************************************************************
     *
     *	Method:		    failTask
     *
     *	Purpose:	    determined whethere the task is failed based on the failed param
     *                  add to a fail task map if fails
     *
     ****************************************************************************/
    private boolean failTask(Operator operator,Task task,int type, double distValue){
        double rangeMin = parameters.humanError[type][1];
        double rangeMax = parameters.humanError[type][2];
        Random r = new Random();
        double randomValue = rangeMin + (rangeMax - rangeMin) * r.nextDouble();
//        System.out.println("comparing" +distValue+" and "+randomValue);
        if(operator.getName().equals("Artificially Intelligent Agent"))
            return false;
        if(Math.abs(randomValue - distValue) <= 0.00001){
            HashMap<Integer,Integer> failCnt = parameters.failTaskCount;
            int currCnt = failCnt.get(parameters.replicationTracker);
            failCnt.put(parameters.replicationTracker,++currCnt);
//            System.out.println(operator.getName()+" fails " +task.getName()+", Total Fail "+ currCnt);
            this.failedTasks.add(new Pair <Operator,Task>(operator,task));
            return true;
        }
        return false;
    }

    /****************************************************************************
     *
     *	Method:		run
     *
     *	Purpose:	Run the simulation once given parameter.
     *
     ****************************************************************************/

    public void run() {

        // Initialize control center.

        //TODO 1.generate a global queue and can be modified
        //TODO 2. Switch to 2 Threads for production and consumption
        globalTasks = new ArrayList<Task>();

        remoteOps = new RemoteOp(parameters,globalTasks);
        remoteOps.run();
        linked = remoteOps.gettasks();
        // Initialize vehicles.
//        for(int i = 0; i < parameters.fleetTypes; i++) {
//            System.out.println("vehicles.length: "+parameters.numvehicles[i]);
//            vehicles[i] = new VehicleSim[parameters.numvehicles[i]];
//        }

        //SCHEN 11/10/17 For this version of Fleet hetero, assume each batch has 10 vehicles
        vehicles = new VehicleSim[parameters.fleetTypes][parameters.numvehicles[0]];

        for (int i = 0; i < parameters.fleetTypes; i++) {
            for(int j = 0; j < parameters.numvehicles[i]; j++) {
                //SCHEN 11/20/17 vehicleId change for 2d Array
                vehicles[i][j] = new VehicleSim(parameters,i*10 + j,remoteOps.getRemoteOp(),globalTasks);
                vehicles[i][j].genbasis();
            }

        }
        System.out.println("Total Tasks: "+globalTasks.size());
        for (Task task : globalTasks) {
            puttask(task);

        }
        // Add linked tasks to vehicles.
//        for(int i = 0; i < parameters.fleetTypes; i++) {
//            for (Task each : linked) {
//
//                int vehicleid = each.getvehicle();
//                each = new Task(each.getType(), each.getBeginTime(), parameters, false);
//                each.setID(vehicleid);
//                if (each.getArrTime() < parameters.numHours * 60) {
////                    System.out.println("Getting vehicle id: "+i+", "+vehicleid+" =>"+ vehicleid%10 );
//                    vehicles[i][vehicleid%10].linktask(each);
//                }
//            }
//        }
        // Run each vehicle
        for(int i = 0; i< parameters.fleetTypes; i++){
            for (VehicleSim each : vehicles[i]) {
                each.run();
            }
        }
        parameters.rep_failTask.put(parameters.replicationTracker,this.failedTasks);
        System.out.println("Curr Replication: " + parameters.replicationTracker);
//        parameters.replicationTracker++;

    }
}
