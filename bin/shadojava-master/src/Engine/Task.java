package Engine;
import java.util.*;
import Input.loadparam;

/***************************************************************************
 *
 * 	FILE: 			Task.java
 *
 * 	AUTHOR:			ROCKY LI
 *
 * 	LATEST EDIT:	2017/5/24
 *
 * 	VER: 			1.1
 *
 * 	Purpose: 		generate task objects.
 *
 **************************************************************************/

public class Task implements Comparable<Task> {

//Task specific variables.

	private int Type;
	private int Phase;
	private int Priority;
	private double prevTime;
	private double arrTime;
	private double serTime;
	private double expTime;
	private double elapsedTime;
	private double beginTime;
	private double endTime;
	private int[] opNums;
	private loadparam parameters;
	private String name;
	private int trainID;
	private boolean expired;

	private double lvl_SOME = 0.7;
	private double lvl_FULL = 0.3;
	private double lvl_None = 1.0;
	// This adds functionalities of the Dispatcher

	private boolean isLinked;

	// This adds the ability for task to track queue retroactively

	private int queued;

// Mutators
	public boolean checkexpired() { return expired; }

	public void setArrTime(double time) { arrTime = time;}

	public void setexpired() {
		expired = true;
	}

	public void setELStime (double time){
		elapsedTime = time;
	}

	public void setID(int id){
		trainID = id;
	}

	public void setQueue(int q){
		queued = q-1;
	}

	public void setEndTime(double time){
		endTime = time;
	}

	public void setBeginTime(double time){
		beginTime = time;
	}

	/****************************************************************************
	 *
	 *	Main Object:	Task
	 *
	 *	Purpose:		Generate a new task on completion of old task. And return
	 *					it's parameters.
	 *
	 ****************************************************************************/

	public Task(int type, double PrevTime, loadparam Param, boolean fromPrev ) {

		Type = type;
		parameters = Param;
		prevTime = PrevTime;
		if (parameters.arrPms[type][0] != 0) {
			Phase = getPhase(PrevTime, parameters.numHours);
		} else {
			Phase = getPhase(31, parameters.numHours);
		}

		Priority = Param.taskPrty[Type][Phase];
		if (fromPrev == true) {
			arrTime = genArrTime(PrevTime);
		} else {
			arrTime = PrevTime;
		}
		//SCHEN 12/10/17 Fleet Autonomy, Team Coord and Exogenous factor added
//		arrTime *= getFleetAutonomy();
		int teamCoordParam = parameters.teamCoordAff[Type];
		serTime = genSerTime();
		if(teamCoordParam == 1)
			changeServTime(lvl_SOME);
		else if(teamCoordParam == 2)
			changeServTime(lvl_FULL);
		applyExogenousFactor();

		expTime = genExpTime();
		beginTime = arrTime;
		opNums = parameters.opNums[Type];
		name = parameters.taskNames[Type];
		isLinked = parameters.linked[Type] == 1;
		elapsedTime = 0;
		expired = false;

	}

	/****************************************************************************
	 *
	 *	Main Object:	Task overload with AI
	 *
	 *	Purpose:		Generate a new task on completion of old task. And return
	 *					it's parameters.
	 *
	 ****************************************************************************/

	public Task(int type, double PrevTime, loadparam Param, boolean fromPrev, boolean hasAI ) {

		Type = type;
		parameters = Param;
		prevTime = PrevTime;
		if (parameters.arrPms[type][0] != 0) {
			Phase = getPhase(PrevTime, parameters.numHours);
		} else {
			Phase = getPhase(31, parameters.numHours);
		}

		Priority = Param.taskPrty[Type][Phase];
		if (fromPrev == true) {
			arrTime = genArrTime(PrevTime);
		} else {
			arrTime = PrevTime;
		}
		//SCHEN 12/10/17 Fleet Autonomy, Team Coord and Exogenous factor added
//		arrTime *= getFleetAutonomy();
		int teamCoordParam = parameters.teamCoordAff[Type];
		serTime = genSerTime();
		if(teamCoordParam == 1)
			changeServTime(lvl_SOME);
		else if(teamCoordParam == 2)
			changeServTime(lvl_FULL);
		applyExogenousFactor();
		applyAI();

		// Use Service time to calculate ExpTime
		expTime = genExpTime();
		beginTime = arrTime;
		opNums = parameters.opNums[Type];
		name = parameters.taskNames[Type];
		isLinked = parameters.linked[Type] == 1;
		elapsedTime = 0;
		expired = false;

	}



	/****************************************************************************
	 *
	 *	Method:			compareTo
	 *
	 *	Purpose:		Compare two task based on their priority
	 *
	 ****************************************************************************/

	@Override
	public int compareTo(Task other){
		if (this.Priority != other.Priority){
			return other.Priority - this.Priority;
		} else {
			if (this.arrTime - other.arrTime > 0){
				return 1;
			} else {
				return -1;
			}
		}
	}

	// The following are inspector functions.

	public int getTrain() {return this.trainID;}

	public String getName() {return this.name;}

	public int getQueued() {return this.queued;}

	public boolean linked() {return this.isLinked;}

	public int getType() {return this.Type;}

	public int getPriority(){return this.Priority;}

	public double getPrevTime(){return this.prevTime;}

	public double getArrTime(){return this.arrTime;}

	public double getSerTime(){return this.serTime;}

	public double getEndTime(){return this.endTime;}

	public double getExpTime() {return this.expTime;}

	public double getELSTime() {return this.elapsedTime;}

	public double getBeginTime() {return this.beginTime;}

	public int[] getOpNums() {return this.opNums;}


	/****************************************************************************
	 *
	 *	Method:			GetPhase
	 *
	 *	Purpose:		Return the Phase
	 *
	 ****************************************************************************/


	public int getPhase(double time, double hours){

		if (time<30){
			return 0;
		} else if (time >= 30 && time < hours * 60 - 30) {
			return 1;
		} else return 2;

	}

	/****************************************************************************
	 *
	 *	Method:			Exponential
	 *
	 *	Purpose:		Return an exponential distributed random number with input
	 *					parameter lambda.
	 *
	 ****************************************************************************/

	private double Exponential(double lambda){

		if (lambda == 0){
			return Double.POSITIVE_INFINITY;
		}
		double result = Math.log(1-Math.random())/(-lambda);
//		System.out.println("Exponential: return " + result);
		return result;


	}

	/****************************************************************************
	 *
	 *	Method:			Lognormal
	 *
	 *	Purpose:		Return a lognormal distributed random number with input
	 *					mean and standard deviation.
	 *
	 ****************************************************************************/

	private double Lognormal(double mean, double stddev){

		Random rng = new Random();
		double normal = rng.nextGaussian();
		double l = Math.exp(mean + stddev * normal);

		return l;

	}

	/****************************************************************************
	 *
	 *	Method:			Uniform
	 *
	 *	Purpose:		Return a uniform distribution with input minimum and maximum
	 *
	 ****************************************************************************/

	private double Uniform(double min, double max){

		return min + (max-min)*Math.random();

	}

	/****************************************************************************
	 *
	 *	Method:			genTime
	 *
	 *	Purpose:		Generate a new time with the specified type and parameters.
	 *
	 ****************************************************************************/

	private double GenTime (char type, double start, double end){
		switch (type){
			case 'E':
				return Exponential(start);
			case 'L':
				return Lognormal(start, end);
			case 'U':
				return Uniform(start, end);
			default:
				throw new IllegalArgumentException("Wrong Letter");
		}
	}

	/****************************************************************************
	 *
	 *	Method:			genArrTime
	 *
	 *	Purpose:		Generate a new exponentially distributed arrival time by phase.
	 *
	 ****************************************************************************/

	private double genArrTime(double PrevTime){
		//SCHEN 12/16/17 Add fleet autonomy function by decreasing the arrival rate
		double arrivalRate = changeArrivalRate(getFleetAutonomy());
		double TimeTaken = Exponential(arrivalRate);

		if (TimeTaken == Double.POSITIVE_INFINITY){
			return Double.POSITIVE_INFINITY;
		}

		double newArrTime = TimeTaken + prevTime;

		if (parameters.affByTraff[Type][Phase] == 1 && loadparam.TRAFFIC_ON){

			double budget = TimeTaken;
			double currTime = prevTime;
			int currHour = (int) currTime/60;
			double traffLevel = parameters.traffic[currHour];
			double TimeToAdj = (currHour+1)*60 - currTime;
			double adjTime = TimeToAdj * traffLevel;

			while (budget > adjTime){

				budget -= adjTime;
				currTime += TimeToAdj;
				currHour ++;

				if (currHour >= parameters.traffic.length){
					return Double.POSITIVE_INFINITY;
				}

				traffLevel = parameters.traffic[currHour];
				TimeToAdj = (currHour + 1)*60 - currTime;
				adjTime = TimeToAdj * traffLevel;

			}

			newArrTime = currTime + budget/traffLevel;
		}

		return newArrTime;
	}

	/****************************************************************************
	 *
	 *	Method:			genSerTime
	 *
	 *	Purpose:		Generate a new service time.
	 *
	 ****************************************************************************/

	private double genSerTime(){

		char type = parameters.serDists[Type];
		double start = parameters.serPms[Type][0];
		double end = parameters.serPms[Type][1];
//		System.out.println("genSerTime: Sertime " +start+ " " +end);
		return GenTime(type, start, end);

	}

	/****************************************************************************
	 *
	 *	Method:			genExpTime
	 *
	 *	Purpose:		Generate a new Expiration time.
	 *
	 ****************************************************************************/

	private double genExpTime(){

		double param;
		double expiration = 0;
		int hour = (int) arrTime/60;
		if (hour >= parameters.traffic.length){
			return arrTime;
		} else if (parameters.traffic[hour] == 2){
			param = parameters.expPmsHi[Type][Phase];
		} else {
			param = parameters.expPmsLo[Type][Phase];
		}
		expiration = GenTime(parameters.expDists[Type], param, 0);
		return arrTime + 2*serTime + expiration;

	}

	/****************************************************************************
	 *
	 *	Method:			getFleetAutonomy
	 *
	 *	Purpose:		Fetch fleet autonomy level
	 *					0: default
	 *					1: Some 70% of arrival rate
	 *					2: Full 30% of arrival rate
	 *
	 ****************************************************************************/

	private double getFleetAutonomy(){
		//SCHEN 12/10/17: Add Fleet autonomy -> adjust arrival rate
		double autoLevel = 1;

		if(parameters.autolvl == 1) autoLevel = lvl_SOME;
		if(parameters.autolvl == 2) autoLevel = lvl_FULL;

		return  autoLevel;
	}

//	private  double getTeamComm(){
//		double teamComm = 1;
//		if(parameters.teamCoordAff == 1) teamComm = 0.7;
//		if(parameters.autolvl == 2) teamComm = 0.3;
//
//		return  teamComm;
//	}
	/****************************************************************************
	 *
	 *	Method:			changeServTime, changeArrivalRate
	 *
	 *	Purpose:		change Service time and arrival rate by multiply by a number
	 *
	 ****************************************************************************/
	private double changeServTime(double num){
		return serTime * num;
	}

	private double changeArrivalRate(double num){
		return parameters.arrPms[Type][Phase] * num;
	}

	private void applyExogenousFactor(){

		if(parameters.hasExogenous[0] == 1){
			int numExo = parameters.hasExogenous[1];
			for(int i = 0; i < numExo; i++){
				if(parameters.exTypes[i].equals("long_serv")){
					changeServTime(1.1);
				}
				if (parameters.exTypes[i].equals("add_task")) {
					//TODO: additional Task function
				}
				if(parameters.exTypes[i].equals("inc_arrival")){
					changeArrivalRate(1.1);
				}
			}
		}
	}	//END applyExogenousFactor()

	private void applyAI(){
		changeServTime(0.7);
	}
}


