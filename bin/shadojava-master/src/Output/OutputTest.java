//package Output;
//
//import Engine.*;
//
//import java.util.ArrayList;
//
///***************************************************************************
// *
// * 	FILE: 			OurputTest.java
// *
// * 	AUTHOR: 		ROCKY LI
// *
// * 	DATE:			2017/9/8
// *
// * 	VER: 			1.0
// *
// * 	Purpose: 		Showing console returns to determine model accuracy.
// *
// **************************************************************************/
//
//public class OutputTest {
//
//    public Replication sourcedata;
//
//    public OutputTest(Replication once){
//        sourcedata = once;
//    }
//
//    private Operator RemoteOp;
//
//    public void textinspect(){
//
//        RemoteOp = sourcedata.getRemoteOp().getRemoteOp()[0];
//        System.out.println(RemoteOp.name);
//        ArrayList<Task> tasklis = RemoteOp.getQueue().records();
//        double sumtim = 0;
//        for (Task tasks: tasklis){
//            System.out.println(tasks.getName() + "\t" + tasks.getBeginTime() +
//                    "\t" + tasks.getArrTime() + "\t" + tasks.getSerTime() + "\t" +
//                   + tasks.getEndTime() + "\t" + tasks.getQueued());
//            sumtim += tasks.getSerTime();
//        }
//        System.out.println(sumtim);
//
//        VehicleSim samplevehicle = sourcedata.getvehicles()[0];
//        Operator[] operators = samplevehicle.operators;
//        for (Operator each: operators){
//            System.out.println(each.name);
//            ArrayList<Task> tasklist = each.getQueue().records();
//            double sumtime = 0;
//            for (Task tasks: tasklist){
//                System.out.println(tasks.getName() + "\t" + tasks.getBeginTime() + "\t" + tasks.getSerTime() + "\t" +
//                        + tasks.getEndTime() + "\t"
//                        +  tasks.getQueued());
//                sumtime += tasks.getSerTime();
//            }
//            System.out.println(sumtime);
//        }
//    }
//}
