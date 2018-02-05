package Input;
import Engine.Operator;
import Engine.Task;
import javafx.util.Pair;

import java.io.*;
import java.util.*;

/***************************************************************************
 * 
 * 	FILE: 			loadparam.java
 * 
 * 	AUTHOR: 		BRANCH VINCENT
 * 
 * 	TRANSLATOR: 	ROCKY LI, RICHARD CHEN
 * 	
 * 	LATEST EDIT:	2017/12/2
 * 
 * 	VER: 			1.0 SHOW
 * 					1.1 SHADO
 *
 * 	Purpose: 		Load parameter in text.
 * 
 **************************************************************************/

public class loadparam {
	
	// General input variables
	public String outputPath;
	public double numHours;
    public double[] traffic;
    public int numReps;
    public int[] ops;
    //SCHEN 11/10/17 Change numvehicles to array
	//public int numvehicles;
    public int[] numvehicles;

    public int numRemoteOp;
    public int[] RemoteOpTasks;
    public List<Pair<Operator, Task>> failedTasks = new ArrayList<>();
    public int failTaskCount;
    //SCHEN 12/4/17 Fleet Autonomy level param
	// None-> default,
	// Some ->70%
	// Full-> 30%

	public int autolvl;
	public int [] hasExogenous;
	public String opStrats;

	// SCHEN 11/10/17 Fleet heterogeneity
	public int fleetTypes;
	public int[][] fleetHetero;

	//	//SCHEN 12/10/17 Team Corrdination
	public String[] exNames;
	public String[] exTypes;

    // Operator settings

	//Global count for number of operators
	public int teamSizeTotal;
    public int numOps;
	public String[] opNames;
	public int[][] opTasks;

    public char[] teamComm;
    public int[] teamSize;

	// Task Settings
		
	public int numTaskTypes;
    public String[] taskNames;
    public int[][] taskPrty;
    public char[] arrDists;
    public double[][] arrPms;
    public char[] serDists;
    public double[][] serPms;
    public char[] expDists;
   	public double[][] expPmsLo;
    public double[][] expPmsHi;
	public int[][] affByTraff;
	public int[][] opNums;
	public int[][] trigger;
	//SCHEN 12/10/17 Added: whether the task is affected by team coordination
	public int[] teamCoordAff;
	// Adding isLinked
    public int numPhases;
	public int[] linked;
	public double[][] humanError;

	// Toggle Global Variables
	
	public static boolean TRAFFIC_ON = true;
	public static boolean FATIGUE_ON = true;
	public static boolean DEBUG_ON = false;
	public static boolean OUTPUT_ON = true;
	public static boolean RAND_RUN_ON = true;

	//SCHEN 11/15/17 test separated replication
	public int currRepnum =0;
	
	/****************************************************************************
	*																			
	*	Main Object:	loadparameter													
	*																			
	*	Purpose:		Load ALL parameter in text
	*																			
	****************************************************************************/
		
	public loadparam(String file) throws FileNotFoundException{
		
		//Declare a scanner for the file
		
		Scanner in = new Scanner(new File(file));
		
		//Read the header of the file
		
		outputPath = readString(in);
		numHours = readDouble(in);
		traffic = readTraff(in);
		numReps = readInt(in);
		//SCHEN 11/10/17 fleetTypes represents the combination of different vehicles
		fleetTypes = readInt(in);
        failTaskCount = 0;
		//SCHEN 11/10/17 Read numvehicles Array
//		numvehicles = readInt(in);
		numvehicles = readIntArr(in);
		numOps = readInt(in);
		numRemoteOp = readInt(in);
		RemoteOpTasks = readIntArr(in);
		numTaskTypes = readInt(in);
        numPhases = readInt(in);
		//SCHEN 12/4/15 Fleet Autonomous level
		autolvl = readInt(in);
//		teamComm = readInt(in);
		hasExogenous = readIntArr(in);
        opStrats = readString(in);

		//Has exo-factors
		int numExos = hasExogenous[1];
        exNames = new String[numExos];
        exTypes = new String[numExos];
        for(int i = 0; i < numExos; i++){
            exNames[i] = readString(in);
            exTypes[i] = readString(in);
        }


		//SCHEN 11/10/2017
		//Load Fleet Heterogeneity info

		fleetHetero = new int[fleetTypes][];
		for(int i = 0 ; i < fleetTypes; i++){
			fleetHetero[i] = readIntArr(in);
		}


        //SCHEN 1/20/2018 Individualize team_comm to each operator type
		teamSizeTotal = 0;
		opNames = new String[numOps];
		opTasks = new int[numOps][];
		teamComm = new char[numOps];
        teamSize = new int[numOps];
        ops = new int[numOps];
		for (int i = 0; i < numOps; i++){
			opNames[i] = readString(in);
			opTasks[i] = readIntArr(in);

            //Team settings
            teamSize[i] = readInt(in);
            teamSizeTotal += teamSize[i];
			teamComm[i] = readChar(in);
			ops[i] = i;
		}


		//Initiate array sizes
		

		taskNames = new String[numTaskTypes];
		taskPrty = new int[numTaskTypes][];
		arrDists = new char[numTaskTypes];
		arrPms = new double[numTaskTypes][];
		serDists = new char[numTaskTypes];
		serPms = new double[numTaskTypes][];
		expDists = new char[numTaskTypes];
	   	expPmsLo = new double[numTaskTypes][];
	    expPmsHi = new double[numTaskTypes][];
		affByTraff = new int[numTaskTypes][];
		opNums = new int[numTaskTypes][];
		linked = new int[numTaskTypes];
		trigger = new int[numTaskTypes][];
		teamCoordAff = new int[numTaskTypes];
		humanError = new double[numTaskTypes][];

		// Read in vehicle operators by vehicle ID.
//		for ()

		//Read in agent type and tasks they can do

		//Read in the task parameters
		
		for (int i = 0; i< numTaskTypes; i++){
			
			taskNames[i] = readString(in);
			taskPrty[i] = readIntArr(in);
			arrDists[i] = readChar(in);
			arrPms[i] = readDoubleArr(in);
			serDists[i] = readChar(in);
			serPms[i] = readDoubleArr(in);
			expDists[i] = readChar(in);
			expPmsLo[i] = readDoubleArr(in);
			expPmsHi[i] = readDoubleArr(in);
			affByTraff[i] = readIntArr(in);
			linked[i] = readInt(in);
			trigger[i] = readIntArr(in);
			teamCoordAff[i] = readInt(in);
			humanError[i] = readDoubleArr(in);

		}
		
		for (int i = 0; i < numTaskTypes; i++){
			ArrayList<Integer> wha = new ArrayList<Integer>();
			for (int j = 0; j < numOps; j++){
				if (Arrays.asList(opTasks[j]).contains(i)){
					wha.add(j);
				}
			}
			opNums[i] = wha.stream().mapToInt(Integer::intValue).toArray();
		}
	}
	
	/****************************************************************************
	*																			
	*	Method:		ridparametername													
	*																			
	*	Purpose:	Read a line in the text and remove the parameter name, also 
	*				returns the line as a scanner while moving the main scanner to
	*				the next line. Also ignore lines if it's empty.
	*
	*	NOTE:		ALL OF THE FOLLOWING METHODS include this method to skip the 
	*				name in the file read.
	*																			
	****************************************************************************/
	
	public Scanner ridparametername(Scanner in){
		
		//get rid of the parameter name in source file.
		String line = "";
		while (true){
			line = in.nextLine();
			if (!line.isEmpty())
				break;
		}
		Scanner input = new Scanner(line);
		input.next();
		return input;
		
	}
	
	/****************************************************************************
	*																			
	*	Method:		readString													
	*																			
	*	Purpose:	Read a string line in text and return string
	*																			
	****************************************************************************/
	
	public String readString(Scanner in){
		
		//Read string object
		
		Scanner input = ridparametername(in);
		String ret = input.nextLine();
		ret = ret.trim();
		input.close();
		return ret;
		
	}
	
	/****************************************************************************
	*																			
	*	Method:		readTraff													
	*																			
	*	Purpose:	Read traffic line in text and return a double array
	*
	****************************************************************************/
	
	public double[] readTraff(Scanner in){
		
		Scanner input = ridparametername(in);
		
		ArrayList<String> traff = new ArrayList<String>();
		ArrayList<Double> traffic = new ArrayList<Double>();
		
		while (input.hasNext()){
			traff.add(input.next());
		}
		
		for (int i = 0; i<traff.size() ; i++){
			String get = traff.get(i);
			double myDouble = 0;
			switch(get){
			case "l": myDouble = 0.5; break;
			case "m": myDouble = 1.0; break;
			case "h": myDouble = 2.0; break;
			}
			traffic.add(myDouble);
		}
		input.close();
		
		return traffic.stream().mapToDouble(Double::doubleValue).toArray();
		
	}
	
	/****************************************************************************
	*																			
	*	Method:		readInt													
	*																			
	*	Purpose:	Read a integer line in text and return ONE int value
	*																			
	****************************************************************************/
	
	public int readInt(Scanner in){
		
		Scanner input = ridparametername(in);
		return input.nextInt();
		
	}
	
	/****************************************************************************
	*																			
	*	Method:		readDouble													
	*																			
	*	Purpose:	Read a integer line in text and return ONE int value
	*																			
	****************************************************************************/
	
	public double readDouble(Scanner in){
		
		Scanner input = ridparametername(in);
		return Double.parseDouble(input.next());
		
	}
	
	/****************************************************************************
	*																			
	*	Method:		readIntArr													
	*																			
	*	Purpose:	read an integer array from one line
	*																			
	****************************************************************************/
	
	public int[] readIntArr(Scanner in){
		
		Scanner input = ridparametername(in);
		ArrayList<Integer> ints = new ArrayList<Integer>();
		while (input.hasNextInt()){
			ints.add(input.nextInt());
		}
		input.close();
		return ints.stream().mapToInt(Integer::intValue).toArray();
		
	}
	
	/****************************************************************************
	*																			
	*	Method:		readDuobleArr													
	*																			
	*	Purpose:	read a double array from one line
	*																			
	****************************************************************************/
	
	public double[] readDoubleArr(Scanner in){
		
		Scanner input = ridparametername(in);
		ArrayList<Double> doubs = new ArrayList<Double>();
		while (input.hasNext()){
			double myDouble = Double.parseDouble(input.next());
			doubs.add(myDouble);
		}
		input.close();
		return doubs.stream().mapToDouble(Double::doubleValue).toArray();
		
	}
	
	/****************************************************************************
	*																			
	*	Method:		readChar													
	*																			
	*	Purpose:	read a character from one line
	*																			
	****************************************************************************/
	
	public char readChar(Scanner in){
		
		Scanner input = ridparametername(in);
		char myChar = input.next().charAt(0);
		input.close();
		return myChar;
		
	}
	
	/****************************************************************************
	*																			
	*	Method:		invertArr													
	*																			
	*	Purpose:	read a double array and invert each element of it unless 0
	*																			
	****************************************************************************/
	
	public double[] invertArr(double[] input){
		
		for (int i = 0; i<input.length ; i++){
			if (input[i] != 0.0){
				input[i] = 1.0/input[i];
			}
		}
		return input;
		
	}
}
