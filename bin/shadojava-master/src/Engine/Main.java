package Engine;

import Input.FileWizard;
import Input.loadparam;
import Output.DataWrapper;
//import Output.OutputTest;
import Output.ProcRep;

import java.io.*;
import java.lang.reflect.Array;
import java.util.Arrays;


/***************************************************************************
 * 	FILE: 			Main.java
 *
 * 	AUTHOR: 		ROCKY LI
 * 	LATEST_EDIT:	2017/9/12
 *
 * 	VER: 			1.2
 * 	Purpose: 		Entry point.
 **************************************************************************/


public class Main {

	public static void main(String[] args) throws IOException {

		// LOAD the parameter file.

		String head = FileWizard.getabspath();

		loadparam data;

		if (args.length == 0){
			data =  new loadparam(head + "/in/params.txt");
		} else {
			data = new loadparam(args[0]);
		}
//		SCHEN 11/10/17 Test for Reading Fleet Hetero
//		String strHetero = data.fleetHetero.toString();

//		printBasicInfo(data);


		// Runs simulation

		Simulation sim = new Simulation(data);
		sim.run();
        System.out.println("Failed Tasks: "+ data.failTaskCount);
//
//		// Generate Output
//
		DataWrapper analyze = new DataWrapper(sim, data);
		analyze.output();

	}
	private static void printBasicInfo(loadparam data){
		System.out.println("FleetHetero: "+ Arrays.deepToString(data.fleetHetero));
		System.out.println("Fleet Types: "+ data.fleetTypes);
		System.out.println("numvehicles: "+ Arrays.toString(data.numvehicles));
		System.out.println("autoLevel: "+ data.autolvl);
		System.out.println("team Communication: "+ Arrays.toString(data.teamComm));
		System.out.println("hasExo: "+ Arrays.toString(data.hasExogenous));
		System.out.println("exNames: "+ Arrays.toString(data.exNames));
		System.out.println("exTypes: "+ Arrays.toString(data.exTypes));
		System.out.println("Total Number of Remote Ops: "+ data.teamSizeTotal);
		System.out.println("Remote Ops taskType"+ Arrays.deepToString(data.opTasks));
		System.out.println("Human Error Input: "+ Arrays.deepToString(data.humanError));
	}

}
