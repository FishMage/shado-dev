package Output;

import java.io.*;

import Engine.*;
import Input.FileWizard;
import Input.loadparam;
import java.util.*;
import com.sun.tools.doclets.formats.html.SourceToHTMLConverter;
import javafx.util.Pair;


/***************************************************************************
 *
 * 	FILE: 			DataWrapper.java
 *
 * 	AUTHOR: 		ROCKY LI
 *
 * 	DATE:			2017/6/5
 *
 * 	VER: 			1.0
 *
 * 	Purpose: 		Wrapping the data field for analysis.
 *
 **************************************************************************/

public class DataWrapper {

    public loadparam vars;

    private Simulation sim;

    private String file_head;

    public void setFileHead(){
        file_head = FileWizard.getabspath();
    }

    public DataWrapper(Simulation o, loadparam param) {
        vars = param;
        sim = o;
    }

    /****************************************************************************
     *
     *	Method:     output
     *
     *	Purpose:    Generate csv files
     *
     ****************************************************************************/

    public void output() throws IOException {

        setFileHead();

        // RemoteOp & Engineer timetables

        for (int i = 0; i < vars.numRemoteOp; i++) {
            String file_name = file_head + "/out/" + "RemoteOperator" + ".csv";
            System.setOut(new PrintStream(new BufferedOutputStream(
                    new FileOutputStream(file_name, false)), true));
            sim.getRemoteOpoutput(i).outputdata();
        }

        for (int j = 0; j < vars.numTeams; j++) {
            String file_name = file_head + "/out/" + vars.opNames[j] + ".csv";
            System.setOut(new PrintStream(new BufferedOutputStream(
                    new FileOutputStream(file_name, false)), true));
            sim.getOperatoroutput(j).outputdata();

        }

        // Expired Tasks

        String file_name = file_head + "/out/Summary/" + "Simulation_Summary_" + ".csv";
        System.setOut(new PrintStream(new BufferedOutputStream(
                new FileOutputStream(file_name, false)), true));
        for (int i = 0; i < vars.numTaskTypes; i++) {
            System.out.println("Task name: " + vars.taskNames[i]);
            System.out.println("expired: " + sim.getExpiredtask()[i]);
            System.out.println("completed: " + sim.getCompletedtaskcount()[i]);


        }
        System.out.println("*** FAILED TASKS ***");
//            System.out.println("Operator "+ p.getKey().getName()+" Failed: "+p.getValue().getName());
        for(int i = 0 ; i< vars.numReps; i++){
            HashMap<Integer,Integer> failCnt = vars.failTaskCount;
            int currFailCnt = failCnt.get(i);
            System.out.println("In Replication " + i +": "+ "Number of Fail Tasks: "+currFailCnt);
        }

        for(int i = 0; i < vars.numReps;i++) {
            String summary_file_name = file_head + "/out/Summary/" + "Error_Summary_Rep_" +i+ ".csv";
            System.setOut(new PrintStream(new BufferedOutputStream(
                    new FileOutputStream(summary_file_name, false)), true));
            System.out.println("Fail Task Detail: ");
            ArrayList<Pair<Operator,Task>> failList = vars.rep_failTask.get(i);
            for(int k = 0 ; k < failList.size(); k++){
                String opName = failList.get(k).getKey().getName();
                String tName = failList.get(k).getValue().getName();
                System.out.print(opName+" Fails " +tName+ ",");
                if(failList.get(k).getValue().getFail()){
                    System.out.print(" But still proceed by the Operator");
                }
                System.out.println();
            }


        }
        //Cross-Replication Summary for workloads
        String summary_file_name = file_head + "/out/Summary/" + "Workload_Summary.csv";
        System.setOut(new PrintStream(new BufferedOutputStream(
                new FileOutputStream(summary_file_name, false)), true));

        double[] workloads  = new double[3];
        double workloadSum = 0;
        int columnCnt;
        for(double[] x: vars.crossRepCount){
            columnCnt = 0;
            for(double y: x){
                workloads[columnCnt++] += y;
                workloadSum += y;
            }
            //System.out.println(Arrays.toString(vars.crossRepCount[i]));
        }
        double percentage_0 = (workloads[0]/workloadSum) * 100;
        double percentage_30 = workloads[1]/workloadSum * 100;
        double percentage_70 = workloads[2]/workloadSum * 100;
        System.out.println("Workload Summary");
        System.out.println("Percentage of utilization 0-30%,Percentage of utilization 30-70%,Percentage of utilization 70-100% ");
        System.out.println(percentage_0+"% ,"+percentage_30+"% ,"+percentage_70+"%,");
    }

}

