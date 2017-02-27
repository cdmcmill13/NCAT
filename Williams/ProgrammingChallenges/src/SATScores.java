import java.io.File;
import java.io.FileNotFoundException;
import java.util.ArrayList;
import java.util.Scanner;

/**
 * Created by corey on 2/26/2017.
 * For I have dipped my hands in muddied waters, and, withdrawing them,
 * find 'tis better to be a commander than a common man ~Bartholomew Roberts
 */

public class SATScores {

    public static void main(String [] args){

        /**
         * @param id ~~ The Test ID
         * @param score ~~ The Score of the Test
         * @param answers ~~ The Answers on Each Test
         */
        class Test{

            private int id;
            private int score;
            private ArrayList<String> answers;

            public Test(){
                this.setId(0);
                this.setAnswers(null);
                this.setScore(0);
            }

            /**
             *
             * @return
             */
            public int getId() {
                return id;
            }

            /**
             *
             * @param id
             */
            public void setId(int id) {
                this.id = id;
            }

            /**
             *
             * @return
             */
            public int getScore() {
                return score;
            }

            /**
             *
             * @param score
             */
            public void setScore(int score) {
                this.score = score;
            }

            /**
             *
             * @return
             */
            public ArrayList<String> getAnswers() {
                return answers;
            }

            /**
             *
             * @param answers
             */
            public void setAnswers(ArrayList<String> answers) {
                this.answers = answers;
            }
        }

        int numberOfTestTakers = 0; // The number of test
        int highestScore = 0;       // The highest score out of all tests
        int lowestScore = 100;      // The lowest score out of all tests
        int meanScore;              // The mean score
        int sum = 0;                // Used to calculate mean score
        int count = 0;              // Used to calculate mean score
        int bestTestId = 0;         // The test ID that produced the highest score
        int worstTestId = 0;        // The test ID that produced the lowest score



        try{

            // Create a new Test object to hold the answer key
            Test key = new Test();

            // Read from the key
            Scanner keyReader = new Scanner(new File("satkey.txt"));

            // While the answer key has text
            while(keyReader.hasNext()){

                // Set the test ID ~~ 9999
                key.setId(keyReader.nextInt());

                // Create an array list to temporarily hold the key answers
                ArrayList<String> ans = new ArrayList();

                // There are 100 answers in the test
                for (int McM = 0; McM < 100; McM++){

                    // Add the next answer to the array list
                    ans.add(keyReader.next());
                }

                // Set the answer key test object
                key.setAnswers(ans);

                // Set the number of total tests taken
                numberOfTestTakers = keyReader.nextInt();
            }

            // Read the file with the student tests
            Scanner testReader = new Scanner(new File("satscores.txt"));

            for (int cdm = 0; cdm < numberOfTestTakers; cdm++){

                // Create a new test object for each line
                Test studentTest = new Test();

                // Set the test's ID
                studentTest.setId(testReader.nextInt());

                // Create an array list to temporarily hold the answers
                ArrayList<String> answer = new ArrayList();

                // There are 100 answers in the test
                for (int McM = 0; McM < 100; McM++){

                    // Add the next answer to the array list
                    answer.add(testReader.next());
                }

                // Set the answer array list of the student's test object
                studentTest.setAnswers(answer);

                for(int mCm = 0; mCm < key.getAnswers().size(); mCm++){

                    // Check if the student's answer against the answer key
                    if(key.getAnswers().get(mCm).equals(studentTest.getAnswers().get(mCm))) {

                        // If the answer is correct, increase the student's score
                        studentTest.setScore(studentTest.getScore() + 1);

                    }

                }

                for (int mcm = 0; mcm < numberOfTestTakers; mcm++){

                    // Check to see which ID has the highest score
                    if(studentTest.getScore() > highestScore){

                        // Set the new highest score and the ID that produced it
                        highestScore = studentTest.getScore();
                        bestTestId = studentTest.getId();

                    }

                    // Check to see which ID has the lowest score
                    if(studentTest.getScore() < lowestScore){

                        // Set the new lowest score and the ID that produced it
                        lowestScore = studentTest.getScore();
                        worstTestId = studentTest.getId();

                    }

                    // Add each score to the sum of all scores
                    sum += studentTest.getScore();
                    count++;

                }

            }

            // Calculate the average score
            meanScore = sum / count;

            System.out.println("Average Score: " + meanScore + "\n" +
                    "Highest Score: " + highestScore + " by ID 00" + bestTestId + "\n" +
                    "Lowest Score: " + lowestScore + " by ID 00" + worstTestId);

        } catch (FileNotFoundException e) {
            e.printStackTrace();
        }

    }

}
