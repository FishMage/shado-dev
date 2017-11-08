package Engine;
import java.util.*;
import Input.loadparam;

/***************************************************************************
 *
 * 	FILE: 			Operator.java
 *
 * 	AUTHOR: 		ROCKY LI
 *
 * 	LATEST EDIT:	2017/5/24
 *
 * 	VER: 			1.0
 *
 * 	Purpose: 		generate operator that wraps Queue objects. This is where
 * 					the distinction between an operator and a dispatcher is made.
 *
 **************************************************************************/

public class Operator {

	public int opId;

	public int dpID;

	public String name;

	public int[] taskType;

	private Queue myQueue;

	private loadparam parameters;

	// Inspector

	public Queue getQueue(){
		return this.myQueue;
	}

	/****************************************************************************
	 *
	 *	Main Object:	Operator
	 *
	 *	Purpose:		Generate an operator object from the parameter file imported
	 *
	 ****************************************************************************/

	public Operator (int opid, loadparam param){

		parameters = param;
		opId = opid;
		taskType = parameters.opTasks[opid];
		name = parameters.opNames[opid];

		// Next line generates an empty queue.

		myQueue = new Queue();
	}

	/****************************************************************************
	 *
	 *	Main Object:	Dispatcher
	 *
	 *	Purpose:		Generate a Dispatcher from the parameter file imported
	 *
	 ****************************************************************************/

	public Operator(int dpid, int[] task) {

		taskType = task;
		name = "Dispatcher " + Integer.toString(dpid);
		myQueue = new Queue();
		dpID = dpid;

	}
}
