package Engine;

import Engine.Dispatch;
import Engine.Simulation;
import Engine.Task;
import Engine.VehicleSim;
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

    private VehicleSim[][] vehicles;

    private Dispatch control;

    // Inspectors:

    public VehicleSim[][] getvehicles() {
        return vehicles;
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
                vehicles[i][j] = new VehicleSim(parameters, i*10 + j);
                vehicles[i][j].genbasis();
            }

        }

        // Add linked tasks to vehicles.
        for(int i = 0; i < parameters.fleetTypes; i++) {
            for (Task each : linked) {

                int vehicleid = each.getvehicle();
                each = new Task(each.getType(), each.getBeginTime(), parameters, false);
                each.setID(vehicleid);
                if (each.getArrTime() < parameters.numHours * 60) {
//                    System.out.println("Getting vehicle id: "+i+", "+vehicleid+" =>"+ vehicleid%10 );
                    vehicles[i][vehicleid%10].linktask(each);
                }
            }
        }
        // Run each vehicle
        for(int i = 0; i< parameters.fleetTypes; i++){
            for (VehicleSim each : vehicles[i]) {
                each.run();
            }
        }

    }
}
