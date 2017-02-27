import java.io.File;
import java.io.FileNotFoundException;
import java.util.ArrayList;
import java.util.Scanner;

/**
 * Created by Corey McM on 2/24/2017.
 * For I have dipped my hands in muddied waters, and, withdrawing them,
 * find 'tis better to be a commander than a common man ~Bartholomew Roberts
 */

public class Marathon {

    public static void main(String [] args) {

        /**
         * Runner class holds data on each runner
         * @param fName First name of runner
         * @param lname Last name of runner
         * @param runTime The time the runner took to finish the marathon
         * @param age The age of the runner. Used to classify runners into age groups
         */
        class Runner{

            private String fName;
            private String lName;
            private double runTime;
            private int age;

            public Runner(){
                this.setfName("");
                this.setlName("");
                this.setRunTime(0.0);
                this.setAge(0);
            }


            /**
             *
             * @return first name of runner
             */
            public String getfName() {
                return fName;
            }

            /**
             * Sets first name of runner
             * @param fName
             */
            public void setfName(String fName) {
                this.fName = fName;
            }

            /**
             *
             * @return last name of runner
             */
            public String getlName() {
                return lName;
            }

            /**
             * Sets last name of runner
             * @param lName
             */
            public void setlName(String lName) {
                this.lName = lName;
            }

            /**
             *
             * @return marathon finish time of runner
             */
            public double getRunTime() {
                return runTime;
            }

            /**
             * Sets marathon finish time of runner
             * @param runTime
             */
            public void setRunTime(double runTime) {
                this.runTime = runTime;
            }

            /**
             *
             * @return age of runner
             */
            public int getAge() {
                return age;
            }

            /**
             * Sets age of runner
             * @param age
             */
            public void setAge(int age) {
                this.age = age;
            }

            /**
             *
             * @return runner data
             */
            public String toString(){
                return getfName() + " " + getlName() /*+ " " + getRunTime() + " " + getAge()*/;
            }
        }


        ArrayList<Runner> runners = new ArrayList<>(); // All runners
        ArrayList<Runner> youngsters = new ArrayList<>(); // 18-35
        ArrayList<Runner> midsters = new ArrayList<>(); // 36-53
        ArrayList<Runner> oldies = new ArrayList<>(); // 54-71
        ArrayList<Runner> geezers = new ArrayList<>(); // 72 and up

        Runner youngGold = new Runner(), // Youngster Gold Medalist
                youngSilver = new Runner(), // Youngster Silver Medalist
                youngBronze = new Runner(), // Youngster Bronze Medalist

                midGold = new Runner(), // Midster Gold Medalist
                midSilver = new Runner(), // Midster Silver Medalist
                midBronze = new Runner(), // Midster Bronze Medalist

                oldGold = new Runner(), // Oldie Gold Medalist
                oldSilver = new Runner(), // Oldie Silver Medalist
                oldBronze = new Runner(), // Oldie Bronze Medalist

                geezGold = new Runner(), // Geezer Gold Medalist
                geezSilver = new Runner(), // Geezer Silver Medalist
                geezBronze = new Runner(); // Geezer Bronze Medalist

        double youngFirst = 15, // Checks to see who is currently in first place
                youngSecond = 15, // Checks to see who is currently in second place
                youngThird = 15, // Checks to see who is currently in third place

                midFirst = 15, // Checks to see who is currently in first place
                midSecond = 15, // Checks to see who is currently in second place
                midThird = 15, // Checks to see who is currently in third place

                oldFirst = 15, // Checks to see who is currently in first place
                oldSecond = 15, // Checks to see who is currently in second place
                oldThird = 15, // Checks to see who is currently in third place

                geezFirst = 15, // Checks to see who is currently in first place
                geezSecond = 15, // Checks to see who is currently in second place
                geezThird = 15; // Checks to see who is currently in third place

        File file = new File("marathonresults.txt"); // The file containing runner data

        try {
            Scanner input = new Scanner(file);

            while(input.hasNext()){                     // While the file has more data
                Runner runner = new Runner();           // Create a new runner object
                runner.setfName(input.next());          // Set the runner's first name
                runner.setlName(input.next());          // Set the runner's last name
                runner.setRunTime(input.nextDouble());  // Set the runner's finish time
                runner.setAge(input.nextInt());         // Set the runner's age

                runners.add(runner);                    // Add the runner to the array list of runners
            }

            // Sorts the runners into their age groups
            for (int McM = 0; McM < runners.size(); McM++) {
                if (runners.get(McM).getAge() <= 35)
                    youngsters.add(runners.get(McM));
                else if (runners.get(McM).getAge() <= 53 && runners.get(McM).getAge() >= 36)
                    midsters.add(runners.get(McM));
                else if (runners.get(McM).getAge() <= 71 && runners.get(McM).getAge() >= 54)
                    oldies.add(runners.get(McM));
                else
                    geezers.add(runners.get(McM));
            }

            // Sorts the youngster age group of runners into first, second, and third place
            for(int mc = 0; mc < youngsters.size(); mc++) {

                if(youngsters.get(mc).getRunTime() < youngFirst){           // If the runner's time is less than the current first place time
                    youngGold = youngsters.get(mc);                         // Set the runner as the gold medalist
                    youngFirst = youngsters.get(mc).getRunTime();           // Set new best time to check against

                } else if (youngsters.get(mc).getRunTime() < youngSecond){  // If the runner's time is less than the current second place time
                    youngSilver = youngsters.get(mc);                       // Set the runner as the silver medalist
                    youngSecond = youngsters.get(mc).getRunTime();          // Set the new second best time to check against

                } else if (youngsters.get(mc).getRunTime() < youngThird){   // If the runner's time is less than the current third place time
                    youngBronze = youngsters.get(mc);                       // Set the runner as the bronze medalist
                    youngThird = youngsters.get(mc).getRunTime();           // Set the new third best time to check against
                }

            }
            // Print out the gold, silver, and bronze medalists
            System.out.println("---Youngster Age Group Winners---" + "\n" + "Gold: " + youngGold.toString() + "\n" +
                    "Silver: " + youngSilver.toString() + "\n" + "Bronze: " + youngBronze.toString());

            System.out.println(); // Add a empty line for readability

            // Sorts the midster age group of runners into first, second, and third place
            for(int mi = 0; mi < midsters.size(); mi++){

                if(midsters.get(mi).getRunTime() < midFirst){
                    midGold = midsters.get(mi);
                    midFirst = midsters.get(mi).getRunTime();

                } else if (midsters.get(mi).getRunTime() < midSecond){
                    midSilver = midsters.get(mi);
                    midSecond = midsters.get(mi).getRunTime();

                } else if (midsters.get(mi).getRunTime() < midThird){
                    midBronze = midsters.get(mi);
                    midThird = midsters.get(mi).getRunTime();
                }

            }
            System.out.println("---Midster Age Group Winners---" + "\n" + "Gold: " + midGold.toString() + "\n" +
                    "Silver: " + midSilver.toString() + "\n" + "Bronze: " + midBronze.toString());

            // Add a empty line for readability
            System.out.println();

            // Sorts the oldie age group of runners into first, second, and third place
            for(int ll = 0; ll < oldies.size(); ll++){

                if(oldies.get(ll).getRunTime() < oldFirst){
                    oldGold = oldies.get(ll);
                    oldFirst = oldies.get(ll).getRunTime();

                } else if (oldies.get(ll).getRunTime() < oldSecond){
                    oldSilver = oldies.get(ll);
                    oldSecond = oldies.get(ll).getRunTime();

                } else if (oldies.get(ll).getRunTime() < oldThird){
                    oldBronze = oldies.get(ll);
                    oldThird = oldies.get(ll).getRunTime();
                }

            }
            System.out.println("---Oldie Age Group Winners---" + "\n" + "Gold: " + oldGold.toString() + "\n" +
                    "Silver: " + oldSilver.toString() + "\n" + "Bronze: " + oldBronze.toString());

            // Add a empty line for readability
            System.out.println();

            // Sorts the geezer age group of runners into first, second, and third place
            for(int an = 0; an < geezers.size(); an++){
                if(geezers.get(an).getRunTime() < geezFirst){
                    geezGold = geezers.get(an);
                    geezFirst = geezers.get(an).getRunTime();

                } else if (geezers.get(an).getRunTime() < geezSecond){
                    geezSilver = geezers.get(an);
                    geezSecond = geezers.get(an).getRunTime();

                } else if (geezers.get(an).getRunTime() < geezThird){
                    geezBronze = geezers.get(an);
                    geezThird = geezers.get(an).getRunTime();
                }

            }
            System.out.println("---Geezer Age Group Winners---" + "\n" + "Gold: " + geezGold.toString() + "\n" +
                    "Silver: " + geezSilver.toString() + "\n" + "Bronze: " + geezBronze.toString());

        } catch (FileNotFoundException e) {
            e.printStackTrace();
        }
    }

}
