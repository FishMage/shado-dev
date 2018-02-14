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

    public loadparam parameter;

    private Simulation sim;

    private String file_head;

    public void setFileHead(){
        file_head = FileWizard.getabspath();
    }

    public DataWrapper(Simulation o, loadparam param) {
        parameter = param;
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

        for (int i = 0; i < parameter.numRemoteOp; i++) {
            String file_name = file_head + "/out/" + "RemoteOperator" + ".csv";
            System.setOut(new PrintStream(new BufferedOutputStream(
                    new FileOutputStream(file_name, false)), true));
            sim.getRemoteOpoutput(i).outputdata();
        }

        for (int j = 0; j < parameter.numOps; j++) {
            String file_name = file_head + "/out/" + parameter.opNames[j] + ".csv";
            System.setOut(new PrintStream(new BufferedOutputStream(
                    new FileOutputStream(file_name, false)), true));
            sim.getOperatoroutput(j).outputdata();

        }

        // Expired Tasks

        String file_name = file_head + "/out/repCSV/" + "Simulation_Summary_" + ".csv";
        System.setOut(new PrintStream(new BufferedOutputStream(
                new FileOutputStream(file_name, false)), true));
        for (int i = 0; i < parameter.numTaskTypes; i++) {
            System.out.println("Task name: " + parameter.taskNames[i]);
            System.out.println("expired: " + sim.getExpiredtask()[i]);
            System.out.println("completed: " + sim.getCompletedtaskcount()[i]);


        }
        System.out.println("*** FAILED TASKS ***");
//            System.out.println("Operator "+ p.getKey().getName()+" Failed: "+p.getValue().getName());
            for(int i = 0 ; i< parameter.numReps; i++){
                HashMap<Integer,Integer> failCnt = parameter.failTaskCount;
                int currFailCnt = failCnt.get(i);
                System.out.println("In Replication " + i +": "+ "Number of Fail Tasks: "+currFailCnt);
            }

        for(int i = 0; i < parameter.numReps;i++) {
            String summary_file_name = file_head + "/out/repCSV/" + "Replication_Summary_" +i+ ".csv";
            System.setOut(new PrintStream(new BufferedOutputStream(
                    new FileOutputStream(summary_file_name, false)), true));
            System.out.println("Fail Task Detail: ");
            ArrayList<Pair<Operator,Task>> failList = parameter.rep_failTask.get(i);
            for(int k = 0 ; k < failList.size(); k++){
                String opName = failList.get(k).getKey().getName();
                String tName = failList.get(k).getValue().getName();
                System.out.print(opName+" Fails" +tName);
                if(failList.get(k).getValue().getFail()){
                    System.out.print(" But still proceed by the Operator");
                }
                System.out.println();
            }


        }
    }

    }


