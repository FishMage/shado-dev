package Output;

import java.lang.reflect.Parameter;
import java.util.*;

import Engine.Data;
import Engine.Operator;
import Engine.Task;
import Engine.Simulation;
import Input.loadparam;

/***************************************************************************
 * 
 * 	FILE: 			ProcData.java
 * 
 * 	AUTHOR: 		ERIN SONG
 * 	
 * 	DATE:			2017/6/5
 * 
 * 	VER: 			1.0
 * 
 * 	Purpose: 		This is legacy code, it was discarded in favor of faster
 * 					processing, namely real time data processing.
 * 
 **************************************************************************/

// TEMPLATES:

/***************************************************************************
 *
 * 	FILE: 			.java
 *
 * 	AUTHOR: 		ROCKY LI
 *
 * 	DATE:			2017/9/12
 *
 * 	VER: 			1.0
 *
 * 	Purpose:
 *
 **************************************************************************/


    /****************************************************************************
     *
     *	Main Object:
     *
     *	Purpose:
     *
     ****************************************************************************/


    /****************************************************************************
     *
     *	Method:
     *
     *	Purpose:
     *
     ****************************************************************************/



public class ProcData {

//
//	private ArrayList<Task> Dataset;
//
//	public ProcData (ArrayList<Task> thisone){
//		Dataset = thisone;
//	}

	// Wrapper.

//	public void store(double time, Operator ops, int trainID, Simulation sim, int repID) {
//		countExpired(sim);
//		trim(time);
//		outpututilization(ops, time, trainID);
//		output(ops, sim, repID);
//
//	}

//	public void countExpired(Simulation o) {
//		for (Task each : Dataset) {
//			if (each.checkexpired() == true) {
//
//				o.getExpiredtaskinc(each.getType(), 1);
//			} else {
//				o.getCompletedtaskinc(each.getType(), 1);
//			}
//		}
//	}

	// trim the tasklist of the expired tasks.

//	public void trim(double time) {
//
//		ArrayList<Task> newset = new ArrayList<Task>();
//		for (Task each : Dataset) {
//			if (each.checkexpired() == false) {
//				if (each.getEndTime() < time) {
//					newset.add(each);
//				}
//			}
//		}
//
//		Dataset = newset;
//	}
//
//	public double load(){
//
//		double worktime = 0;
//
//		if (Dataset != null) {
//			for (Task each : Dataset) {
//				worktime += each.getELSTime();
//			}
//		}
//		return worktime;
//
//	}

	// Put operator's task into 10 minute packs.

//	public void outpututilization(Operator operator, double time, int trainID) {
//
//        int i = 1;
//
//			for (Task each : Dataset) {
//
//                if (i > (int) (time / 10) + 1) {
//                    break;
//                }
//
//				double beginscale = each.getBeginTime() / 10;
//				double endscale = each.getEndTime() / 10;
//                int endINT = (int) endscale + 1;
//
//				double percBusy = 0;
//
//				if (i > endscale) {
//
//						percBusy = each.getSerTime() / 10;
//
//						operator.getUtilization().datainc(each.getType(), i - 1, trainID, percBusy);
//
//
//				} else {
//
//                    if (i > beginscale) {
//                        percBusy = i - beginscale;
//                        operator.getUtilization().datainc(each.getType(), i - 1, trainID, percBusy);
//						percBusy = endscale - i;
//						operator.getUtilization().datainc(each.getType(), i, trainID, percBusy);
//
//                    }
//
//                    i = endINT;
//
//					percBusy = each.getSerTime() / 10;
//
//					operator.getUtilization().datainc(each.getType(), i - 1, trainID, percBusy);
//
//				}
//			}
//
//
//		operator.getUtilization().avgdata();
//
//		// was in the process of debugging
//		/*for (int x = 0; x < operator.getUtilization().avg.length; x++) {
//			for (int y = 0; y < operator.getUtilization().avg[x].length; y++) {
//				operator.getOutput().datainc(x, y, i, operator.getUtilization().avgget(x, y));
//			}
//		}*/
//
//	}

//
//	public void output(Operator operator, Simulation o, int rep) {
//		Data data;
//		if (operator.name.contains("Dispatcher")) {
//			data = o.getDispatchoutput(operator.dpID);
//		} else {
//			data = o.getOperatoroutput(operator.opId);
//		}
//
//		for (int x = 0; x < operator.getUtilization().avg.length; x++) {
//			for (int y = 0; y < operator.getUtilization().avg[x].length; y++) {
//				data.datainc(x, y, rep, operator.getUtilization().avgget(x, y));
//
//			}
//		}
//
//		data.avgdata();



		/*for (double[] x : operator.getOutput().avg) {
			for (double y : x) {

				System.out.print(y + ",");

			}
			System.out.println();

		}*/
//	}



//	public void debug() {
//
//		for (Task each : Dataset){
//			System.out.println(each.getBeginTime() + " " + each.getELSTime() + " " + each.getEndTime()
//					+ " " + each.getName() + " and " + each.getQueued() + " are in the queue. " + each.getSerTime());
//		}
//
//	}
	
	
}