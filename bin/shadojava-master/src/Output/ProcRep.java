package Output;

import Engine.*;

import Input.FileWizard;
import Output.ProcData;
import java.io.*;
import java.io.BufferedOutputStream;
import java.io.FileOutputStream;
import java.io.PrintStream;
import java.util.ArrayList;

/***************************************************************************
 *
 * 	FILE: 			ProcRep.java
 *
 * 	AUTHOR: 		ROCKY LI
 * 	                Richard Chen
 *
 * 	DATE:			2017/9/10, 201712/2
 *
 * 	VER: 			1.0
 *
 * 	Purpose: 		Process each replication in Data individually
 *
 **************************************************************************/

public class ProcRep {

    private Data[] dispatchdata;

    private Data[] operatordata;

    private Replication rep;

    private VehicleSim[][] vehicles;

    private int repID;

    private int numdispatch;

    private int numoperator;

    private int numtasktypes;

    private double hours;

    private Data[] repdisdata;

    private Data[] repopsdata;

    private int[] completed;

    private int[] expired;

    // INSPECTORS

    public int[] getExpired() { return expired; }

    public int[] getCompleted() { return completed; }

    /****************************************************************************
     *
     *	Main Object:	ProcRep
     *
     *	Purpose:		Create a ProcRep Object with a Data object and Replication
     *                  object as input
     *
     ****************************************************************************/

    public ProcRep(Data[] dis, Data[] ops, Replication rep){

        this.rep = rep;
        dispatchdata = dis;
        operatordata = ops;
        vehicles = rep.getvehicles();
        repID = rep.getRepID();
        numdispatch = rep.parameters.numDispatch;
        numoperator = rep.parameters.numOps;
        numtasktypes = rep.parameters.numTaskTypes;
        hours = rep.parameters.numHours;
        expired = new int[numtasktypes];
        completed = new int[numtasktypes];


    }

    /****************************************************************************
     *
     *	Method:			tmpData
     *
     *	Purpose:		creating temporary Data object to be appended.
     *
     ****************************************************************************/

    public void tmpData(){

        repdisdata = new Data[numdispatch];
        for (int i = 0; i < numdispatch; i++){
            repdisdata[i] = new Data(numtasktypes,(int) hours*6, 1);
        }

        repopsdata = new Data[numoperator];
        for (int i = 0; i < numoperator; i++) {
            for (int j = 0; j < rep.parameters.fleetTypes; j++) {
                repopsdata[i] = new Data(numtasktypes, (int) hours * 6, vehicles[j].length);
            }
        }
    }

    /****************************************************************************
     *
     *	Method:			fillRepDataCell
     *
     *	Purpose:		Fill the Rep Data object with simulated data.
     *
     ****************************************************************************/

    public void fillRepDataCell(Operator operator, Data incremented, int vehicleID){

        // Get Operator's task record.

        ArrayList<Task> records = operator.getQueue().records();

        // Cycle through records of each operator in 10 minutes intervals.

        for (Task each: records){

            if (each.checkexpired()){
                expired[each.getType()]++;
                continue;
            } else {
                completed[each.getType()]++;
            }

            double beginscale = (each.getEndTime() - each.getSerTime()) / 10;
            double endscale = each.getEndTime() / 10;

            boolean startcheck = false;

            for (int i = 1; i < (int) hours*6 + 1; i++) {

                // If task hasn't began yet

                if (beginscale > i) {
                    continue;
                }

                // If task began but not finished in this interval.

                if (endscale > i) {
                    if (!startcheck) {
                        incremented.datainc(each.getType(), i - 1, vehicleID, i - beginscale);
                        startcheck = true;
                    } else {
                        incremented.datainc(each.getType(), i - 1, vehicleID, 1);
                    }
                } else {
                    if (!startcheck) {
                        incremented.datainc(each.getType(), i - 1, vehicleID, endscale - beginscale);
                        break;
                    } else {
                        incremented.datainc(each.getType(), i - 1, vehicleID, endscale - i + 1);
                        break;
                    }
                }
            }
        }

    }

    /****************************************************************************
     *
     *	Method:			fillRepData
     *
     *	Purpose:		Call fillRepDataCell on appropriate Data objects.
     *
     ****************************************************************************/

    public void fillRepData(){
        //SCHEN 11/29/17
        //TODO: output operator's data
        Operator[] dispatchers = rep.getDispatch().getDispatch();

        for (int i = 0; i < numdispatch; i++){
            fillRepDataCell(dispatchers[i], repdisdata[i], 0);
        }
        for(int i = 0; i < rep.parameters.fleetTypes;i++) {
//            for(int j = 0 ; j < vehicles[i].length; j++){
                for (VehicleSim vehicle : vehicles[i]) {
//                    System.out.println("Op calculation for vehicle: " + i);
                    Operator[] operators = vehicle.operators;
                    for (int j = 0; j < 2; j++) {
//                        System.out.println("fillRepDataCell for vehicleID: " + vehicle.getvehicleID()%10);
                        fillRepDataCell(operators[j], repopsdata[j], vehicle.getvehicleID()%10);
                    }
                }
//            }
        }
        for (Data each: repopsdata){
            each.avgdata();
        }

    }

    /****************************************************************************
     *
     *	Method:			appendData
     *
     *	Purpose:		Add the data of the replication to the main data field
     *
     ****************************************************************************/

    public void appendData(){

        // Process the dispatch data

        for (int i = 0; i < numdispatch; i++){
            Data processed = dispatchdata[i];
            for (int x = 0; x < processed.data.length; x++){
                for (int y = 0; y < processed.data[0].length; y++){
                    processed.datainc(x, y, repID, repdisdata[i].dataget(x, y, 0));
                }
            }
        }

        // Process the operator data

        for (int i = 0; i < numoperator; i++){
            Data processed = operatordata[i];
            for (int x = 0; x < processed.data.length; x++){
                for (int y = 0; y < processed.data[0].length; y++){
                    processed.datainc(x, y, repID, repopsdata[i].avgget(x, y));
                }
            }
        }
    }

    /****************************************************************************
     *
     *	Method:			testClass
     *
     *	Purpose:		Test the ProcRep class.
     *
     ****************************************************************************/

    public void testProcRep(int currRep) throws IOException {
        int numdisp = 0;
        for (Data each: repdisdata){
            each.avgdata();
            System.out.println("FOR Replication \n"+ (currRep -1));
            sepCSV(each,currRep,numdisp);
//            numRep++;
            numdisp++;
//            each.outputdata();
        }

        for (Data each: repopsdata){
//            System.out.println(" FOR OPERATOR \n");
//            each.outputdata();
            each.avgdata();
//            sepCSV(each,currRep);
        }

    }

    /****************************************************************************
     *
     *	Method:			Run
     *
     *	Purpose:		A wrapper that runs the ProcRep class.
     *
     ****************************************************************************/

    public void run(int currRep){

        tmpData();
        fillRepData();
        appendData();
       try{
           testProcRep(currRep);
       }catch(Exception e){
           System.out.println("JAVA IO EXCEPTION");
       };


    }
    /****************************************************************************
     *
     *	Method:			SepCSV
     *
     *	Purpose:		output CSV for every replication
     *
     ****************************************************************************/
    public void sepCSV(Data dispatchout, int repNum,int numdip)throws IOException{
        String  file_head = FileWizard.getabspath();
        //SCHEN 11/30/17
        //Make dispatcher dir if not exists
        String directoryName = "/out/repCSV/dispatcher_"+numdip;
        File directory = new File(directoryName);
        if (!directory.exists()){
            directory.mkdir();
            // If you require it to make the entire directory path including parents,
            // use directory.mkdirs(); here instead.
            System.out.println("mkdir");
        }

        String file_name = file_head + directoryName + "_rep_"+ repNum + ".csv";
        System.setOut(new PrintStream(new BufferedOutputStream(
                new FileOutputStream(file_name, false)), true));
        dispatchout.outputdata();

    }

}
