package Engine;

import Engine.Dispatch;
import Engine.Simulation;
import Engine.Task;
import Engine.TrainSim;
import Input.loadparam;

import java.util.ArrayList;

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

    private TrainSim[][] trains;

    private Dispatch control;

    // Inspectors:

    public TrainSim[][] getTrains() {
        return trains;
    }

    public Dispatch getDispatch() {
        return control;
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

        control = new Dispatch(parameters);
        control.run();
        linked = control.gettasks();

        // Initialize trains.
//        for(int i = 0; i < parameters.fleetTypes; i++) {
//            System.out.println("trains.length: "+parameters.numTrains[i]);
//            trains[i] = new TrainSim[parameters.numTrains[i]];
//        }

        //SCHEN 11/10/17 For this version of Fleet hetero, assume each batch has 10 trains
        trains = new TrainSim[parameters.fleetTypes][parameters.numTrains[0]];

        for (int i = 0; i < parameters.fleetTypes; i++) {
            for(int j = 0; j < parameters.numTrains[i]; j++) {
                trains[i][j] = new TrainSim(parameters, j);
                trains[i][j].genbasis();
            }

        }

        // Add linked tasks to trains.
        for(int i = 0; i < parameters.fleetTypes; i++) {
            for (Task each : linked) {

                int trainid = each.getTrain();
                each = new Task(each.getType(), each.getBeginTime(), parameters, false);
                each.setID(trainid);
                if (each.getArrTime() < parameters.numHours * 60) {
//                    System.out.println("Getting Train id: "+i+", "+trainid+" =>"+ trainid%10 );
                    trains[i][trainid%10].linktask(each);
                }
            }
        }
        // Run each train
        for(int i = 0; i< parameters.fleetTypes; i++){
            for (TrainSim each : trains[i]) {

                each.run();

            }
        }

    }
}
