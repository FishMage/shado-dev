package Output;

import java.io.*;

import Engine.*;
import Input.FileWizard;
import Input.loadparam;


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
            String file_name = file_head + "/out/" + "RemoteOper" + ".csv";
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

        String file_name = file_head + "/out/" + "expiredtask_" + ".csv";
        System.setOut(new PrintStream(new BufferedOutputStream(
                new FileOutputStream(file_name, false)), true));
        for (int i = 0; i < parameter.numTaskTypes; i++) {
            System.out.println("Task name: " + parameter.taskNames[i]);
            System.out.println("expired: " + sim.getExpiredtask()[i]);
            System.out.println("completed: " + sim.getCompletedtaskcount()[i]);

        }
    }

    }


