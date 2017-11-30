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

	private loadparam parameters;

    private int[] expiredtaskcount;

    private int[] completedtaskcount;

    private Data[] operatoroutput;

    private Data[] dispatchoutput;

    private int repnumber;

    public int[] getExpiredtask() {
        return expiredtaskcount;
    }

    public int[] getCompletedtaskcount() {
        return completedtaskcount;
    }

    public Data getOperatoroutput(int i) {
        return operatoroutput[i];
    }

    public Data getDispatchoutput(int i) {
        return dispatchoutput[i];
    }

    public Data[] getopsdata() { return operatoroutput; }

    public Data[] getdisdata() { return dispatchoutput; }

    /****************************************************************************
     *
     *	Main Object:	Simulation
     *
     *	Purpose:		Create the simulation Object.
     *
     ****************************************************************************/

    public Simulation(loadparam param) {

        // Get overall parameters

        parameters = param;
        repnumber = param.numReps;
        System.out.println("NumReps: " + repnumber);
        // Generate overall data field

        operatoroutput = new Data[param.numOps];
        for (int i = 0; i < param.numOps; i++) {
            operatoroutput[i] = new Data(param.numTaskTypes, (int) param.numHours * 6, param.numReps);
        }

        dispatchoutput = new Data[param.numDispatch];
        for (int i = 0; i < param.numDispatch; i++) {
            dispatchoutput[i] = new Data(param.numTaskTypes, (int) param.numHours * 6, param.numReps);
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

        Replication processed = new Replication(parameters, repID);
        processed.run();
        ProcRep process = new ProcRep(dispatchoutput, operatoroutput, processed);

        process.run(repID);

        for (int i = 0; i < parameters.numTaskTypes; i++) {
            expiredtaskcount[i] += process.getExpired()[i];
            completedtaskcount[i] += process.getCompleted()[i];
        }
    }

    /****************************************************************************
     *
     *	Method:			run
     *
     *	Purpose:		Run Simulation
     *
     ****************************************************************************/

    public void run() throws IOException {

        for (int i = 0; i < repnumber; i++) {

            processReplication(i);
            if (i%10 == 0){
                System.out.println("we're at " + i + " repetition");
            }
        }

        int repNum = 0;
        for (Data each: dispatchoutput){
//            sepCSV(each,repNum);
//            repNum++;
            each.avgdata();
        }
        for (Data each: operatoroutput){
            each.avgdata();
        }
    }
    /****************************************************************************
     *
     *	Method:			sepCSV
     *
     *  Author:         Richard Chen
     *
     *	Purpose:		Generate separated CSV file for each replication
     *
     ****************************************************************************/
	public void sepCSV(Data dispatchout, int repNum) throws IOException {
	        String  file_head = FileWizard.getabspath();
            String file_name = file_head + "/out/repCSV/" + "rep_"+ repNum + ".csv";
            System.setOut(new PrintStream(new BufferedOutputStream(
                    new FileOutputStream(file_name, false)), true));
            dispatchout.outputdata();
    }
}
