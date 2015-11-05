import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

import java.io.BufferedWriter;
import java.io.File;
import java.io.FileWriter;
import java.io.IOException;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;

public class open2study {

    /**
     * @param args
     * @throws IOException
     * @throws ClassNotFoundException
     * @throws IllegalAccessException
     * @throws InstantiationException
     * @throws SQLException
     */
    public static void main(String[] args) throws IOException, InstantiationException, IllegalAccessException, ClassNotFoundException, SQLException {
        //Many things are commented out in this sample program. Uncomment to explore more if needed.
        // Need Jsoup jar files to run this sample program. You may also need to rebuild path, etc.
        // There are many pages that show 15 EDX courses on a webpage as constrained by ?page=some_number.
        //In this sample program, we show the first 6 pages.
        String url1 = "https://www.open2study.com/courses"; // open2study courses
        //String url2 = "https://www.canvas.net/"; // canvas courses


        ArrayList<String> pgcrs = new ArrayList<String>(); //Array which will store each course URLs
        pgcrs.add(url1);
        //pgcrs.add(url2);

        //The following few lines of code are used to connect to a database so the scraped course content can be stored.
        Class.forName("com.mysql.jdbc.Driver").newInstance();
        java.sql.Connection connection = DriverManager.getConnection("jdbc:mysql://localhost/moocs160", "root", "");
        //make sure you create a database named scrapedcourse in your local mysql database before running this code
        //default mysql database in your local machine is ID:root with no password
        //you can download scrapecourse database template from your Canvas account->modules->Team Project area
        for (int a = 0; a < pgcrs.size(); a++) {
            String furl = (String) pgcrs.get(a);
            Document doc = Jsoup.connect(furl).get();
            Elements ele = doc.select("div[class*=views-row]");
            Elements crspg = ele.select("span.field-content");
            Elements link = crspg.select("a[href]");

            /*
            ///Saves to text file
            BufferedWriter writer = null;
            try {
                //create a temporary file
                String timeLog = new SimpleDateFormat("yyyyMMdd_HHmmss").format(Calendar.getInstance().getTime());
                File logFile = new File(timeLog);
                

                //outputs path to where it will write to
                System.out.println(logFile.getCanonicalPath());

                writer = new BufferedWriter(new FileWriter(logFile));
                writer.write(String.valueOf(crspg));


            } catch (Exception e) {
                e.printStackTrace();
            } finally {
                try {
                    // Close the writer regardless of what happens...
                    writer.close();
                } catch (Exception e) {
                }
            }
            */
            
            for (int j = 0; j < link.size(); j++) {
                //Statement statement = connection.createStatement();

                String crsurl = "https://www.open2study.com" + link.get(j).attr("href"); //Get the Course Url from href tag and add to www.edx.org to get the full URL to the course
                System.out.println("crsurl: " + crsurl);
                String CourseName = crspg.select("h2").get(j).text(); //Get the Course Name from H1 Tag
                CourseName = CourseName.replace("'", "''");
                CourseName = CourseName.replace(",", "");
                	System.out.println("CourseName: " + CourseName); // DELETE ME
                String SCrsDesrpTemp = crspg.select("div.adblock_course_body").get(j).text();
                SCrsDesrpTemp = SCrsDesrpTemp.replace("?", "");
                //String SCrsDesrp = SCrsDesrpTemp.substring(0, (SCrsDesrpTemp.length()-5)); //To get the course description and remove the extra characters at the end.
                SCrsDesrpTemp = SCrsDesrpTemp.replace("'", "''");
                SCrsDesrpTemp = SCrsDesrpTemp.replace(",", "");
                	System.out.println("SCrsDesrpTemp: " + SCrsDesrpTemp); // DELETE ME
                String CrsImg;
                /** HTML section to grab image
                 <figure><img typeof="foaf:Image" class="image-style-course-logo-subjects-block"
                 src="https://www.open2study.com/sites/default/files/styles/course_logo_subjects_block/public/Course_TIle_agriculture.jpg?itok=tB9Z_fdZ" width="260"
                 height="140" alt="Agriculture and the World We Live In" title="Agriculture and the World We Live In" /></figure>
                 */
                if (a == 0 || a == 1) {
                    CrsImg = crspg.select("img[].image-style-course-logo-subjects-block").get(j); //Grabs the course image from the img class
                } else {
                    CrsImg = "N/A"; //To get the course image - FOR URL4
                }
                	System.out.println("CrsImg: " + CrsImg); // DELETE ME
                Document crsdoc = Jsoup.connect(crsurl).get();
                Elements crsheadele = crsdoc.select("section[class=course-header clearfix]");
                String youtube = crsdoc.select("iframe.media-youtube-player[src]").text(); //Youtube link
                	System.out.println(youtube); // DELETE ME
                Elements crsbodyele = crsdoc.select("section[class=course-detail clearfix]");
                String CrsDes = "write your own code"; //Course Description Element
                CrsDes = CrsDes.replace("'", "''");
                CrsDes = CrsDes.replace(",", "");
                if (CrsDes.contains("?")) {
                    CrsDes = CrsDes.replace("?", "");
                }
                	System.out.println("CrsDes: " + CrsDes); // DELETE ME
                String Date = crsdoc.select("div[class=startdate]").text();
                String StrDate = Date.substring(Date.indexOf(":") + 1, Date.length()); //Start date after the :
                String datechk = StrDate.substring(0, StrDate.indexOf(" "));
                if (!datechk.matches(".*\\d.*")) {
                    if (StrDate.contains("n/a")) {
                        StrDate = "write you own code";
                    } else {
                        StrDate = "write your own code";
                    }
                } else {
                    String date = StrDate.substring(0, StrDate.indexOf(" "));
                    String month = StrDate.substring(StrDate.indexOf(" ") + 1, StrDate.indexOf(" ") + 4);
                    String year = StrDate.substring(StrDate.length() - 4, StrDate.length());
                    StrDate = "write your own code";
                }
                Element chk = crsdoc.select("div[class=effort last]").first();
                Element crslenschk = crsdoc.select("div[class*=duration]").first();
                String crsduration;
                if (crslenschk == null) {
                    crsduration = "0";
                } else if (StrDate.contains("n/a self-paced")) {
                    crsduration = "0";
                } else {
                    try {
                        String crsdurationtmp = crsdoc.select("div[class*=duration]").text();
                        int start = crsdurationtmp.indexOf(":") + 1;
                        int end = crsdurationtmp.indexOf((" "), crsdurationtmp.indexOf(":"));
                        crsduration = crsdurationtmp.substring(start, end);
                    } catch (Exception e) {
                        crsduration = "0";
                        System.out.println("Exception");
                    }
                }
                //The following is used to insert scraped data into your database table. Need to uncomment all database related code to run this.
                String query = "insert into course_data values(null,'" + CourseName + "','" + SCrsDesrpTemp + "','" + CrsDes + "','" + crsurl + "','" + youtube + "'," + StrDate + "," + crsduration + ",'" + CrsImg + "','','Edx')";
                System.out.println(query);
                //statement.executeUpdate(query);// skip writing to database; focus on data printout to a text file instead.
                //statement.close();
            }
        }
        connection.close();
    }

//    public static void print(){
//        BufferedWriter writer = null;
//        try {
//            //create a temporary file
//            String timeLog = new SimpleDateFormat("yyyyMMdd_HHmmss").format(Calendar.getInstance().getTime());
//            File logFile = new File(timeLog);
//
//            // This will output the full path where the file will be written to...
//            System.out.println(logFile.getCanonicalPath());
//
//            writer = new BufferedWriter(new FileWriter(logFile,true));
//
//            for (Element e : ele) {
//                writer.write(String.valueOf(e));
//            }
//
//        } catch (Exception e) {
//            e.printStackTrace();
//        } finally {
//            try {
//                // Close the writer regardless of what happens...
//                writer.close();
//            } catch (Exception e) {
//            }
//        }
//    }
}
