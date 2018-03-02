package Input;

import java.io.FileNotFoundException;
import java.io.IOException;

/**
 * Created by siyuchen on 11/13/17.
 */
public class testLoadParam {
    public static void main(String args[]) throws IOException{

        String head = FileWizard.getabspath();
        loadparam data;
        if (args.length == 0){
            data =  new loadparam(head + "/in/params.txt");
        } else {
            data = new loadparam(args[0]);
        }
        String strHetero = data.fleetHetero.toString();
        System.out.println(strHetero);
    }
}
