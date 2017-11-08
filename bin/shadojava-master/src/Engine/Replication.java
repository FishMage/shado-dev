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

    private TrainSim[] trains;

    private Dispatch control;

    // Inspectors:

    public TrainSim[] getTrains() {
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

        trains = new TrainSim[parameters.numTrains];

        for (int i = 0; i < parameters.numTrains; i++) {

            trains[i] = new TrainSim(parameters, i);
            trains[i].genbasis();

        }

        // Add linked tasks to trains.

        for (Task each : linked) {

            int trainid = each.getTrain();
            each = new Task(each.getType(), each.getBeginTime(), parameters, false);
            each.setID(trainid);
            if (each.getArrTime() < parameters.numHours*60) {
                trains[trainid].linktask(each);
            }
        }

        // Run each train

        for (TrainSim each : trains) {

            each.run();

        }

    }
}
