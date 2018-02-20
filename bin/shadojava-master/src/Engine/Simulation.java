package Engine;
import Input.FileWizard;
import Input.loadparam;
import Output.ProcRep;

import java.io.*;
import java.util.ArrayList;

/***************************************************************************
 *
 * 	FILE: 			Simulation.java
 *
 * 	AUTHOR: 		ROCKY LI
 *
 * 	LATEST EDIT:	2017/9/12
 *
 * 	VER: 			1.1
 *
 * 	Purpose: 		Wraps the simulation, included intra-thread data processing to
 * 	                relieve cost on memory size.
 *
 **************************************************************************/

public class Simulation {

	private loadparam vars;

    private int[] expiredtaskcount;

    private int[] completedtaskcount;

    private Data[] operatoroutput;

    private Data[] RemoteOpoutput;

    private int repnumber;

    private int totalRemoteOp;

    public int[] getExpiredtask() {
        return expiredtaskcount;
    }

    public int[] getCompletedtaskcount() {
        return completedtaskcount;
    }

    public Data getOperatoroutput(int i) {
        return operatoroutput[i];
    }

    public Data getRemoteOpoutput(int i) {
        return RemoteOpoutput[i];
    }

    public Data[] getopsdata() { return operatoroutput; }

    public Data[] getdisdata() { return RemoteOpoutput; }

    /****************************************************************************
     *
     *	Main Object:	Simulation
     *
     *	Purpose:		Create the simulation Object.
     *
     ****************************************************************************/

    public Simulation(loadparam param) {

        // Get overall vars

        vars = param;
        repnumber = param.numReps;
        System.out.println("NumReps: " + repnumber);
        // Generate overall data field

        operatoroutput = new Data[param.numOps];
        for (int i = 0; i < param.numOps; i++) {
            operatoroutput[i] = new Data(param.numTaskTypes, (int) param.numHours * 6, param.numReps);
        }
        setTotalRemoteOps();
        RemoteOpoutput = new Data[totalRemoteOp];
        for (int i = 0; i < totalRemoteOp; i++) {
            RemoteOpoutput[i] = new Data(param.numTaskTypes, (int) param.numHours * 6, param.numReps);
        }

        expiredtaskcount = new int[param.numTaskTypes];
        completedtaskcount = new int[param.numTaskTypes];

    }

    /****************************************************************************
     *
     *	Method:			processReplication
     *
     *	Purpose:		process a SINGLE replication, and then remove the reference.
     *
     ****************************************************************************/

    public void processReplication(int repID){

        Replication processed = new Replication(vars, repID);
        processed.run();
        vars.reps[repID] = processed;
//        vars.currRepnum = repID;
//        ProcRep process = new ProcRep(RemoteOpoutput, operatoroutput, processed);
//
//        process.run(repID);
//
//        for (int i = 0; i < vars.numTaskTypes; i++) {
//            expiredtaskcount[i] += process.getExpired()[i];
//            completedtaskcount[i] += process.getCompleted()[i];
//        }
    }

    /****************************************************************************
     *
     *	Method:			run
     *
     *	Purpose:		Run Simulation
     *
     ***************************************************************************/

    public void run() throws IOException {

        for (int i = 0; i < repnumber; i++) {

            processReplication(i);
            vars.replicationTracker ++;
            if (i%10 == 0)
                System.out.println("we're at " + i + " repetition");
        }
        //Data Processing for Replications
        for(int i = 0; i < repnumber; i++){
            ProcRep process = new ProcRep(RemoteOpoutput, operatoroutput, vars.reps[i],vars);
            process.run(i);
            vars.currRepnum++;
            for (int j = 0; j < vars.numTaskTypes; j++) {
                expiredtaskcount[j] += process.getExpired()[j];
                completedtaskcount[j] += process.getCompleted()[j];
            }
        }

        for (Data each: RemoteOpoutput){
            each.avgdata();
        }
        for (Data each: operatoroutput){
            each.avgdata();
        }
    }
    private void setTotalRemoteOps(){
        for(int i : vars.teamSize){
            totalRemoteOp += i;
        }
    }
}
