import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

import java.io.BufferedWriter;
import java.io.File;
import java.io.FileWriter;
import java.io.IOException;
import java.sql.Date;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.sql.Statement;
import java.text.DateFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.concurrent.TimeUnit;

public class canvas {
    /**
     * @param args
     * @throws IOException
     * @throws ClassNotFoundException
     * @throws IllegalAccessException
     * @throws InstantiationException
     * @throws SQLException
     * @throws ParseException
     */
    public static void main(String[] args) throws IOException, InstantiationException, IllegalAccessException, ClassNotFoundException, SQLException, ParseException {
        //Many things are commented out in this sample program. Uncomment to explore more if needed.
        // Need Jsoup jar files to run this sample program. You may also need to rebuild path, etc.
        // There are many pages that show 15 EDX courses on a webpage as constrained by ?page=some_number.
        //In this sample program, we show the first 6 pages.
        String url1 = "https://www.canvas.net/"; // canvas

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
            Elements ele = doc.select("div[id=home-page]");
            Elements crspg = ele.select("div.col-md-3 col-sm-6");
            Elements link = crspg.select("a[href]");
            
            
            ///Saves to text file
            BufferedWriter writer = null;
            try {
                //create a temporary file
                String timeLog = new SimpleDateFormat("yyyyMMdd_HHmmss").format(Calendar.getInstance().getTime());
                File logFile = new File(timeLog);
                

                //outputs path to where it will write to
                System.out.println(logFile.getCanonicalPath());

                writer = new BufferedWriter(new FileWriter(logFile));
                writer.write(String.valueOf(ele));


            } catch (Exception e) {
                e.printStackTrace();
            } finally {
                try {
                    // Close the writer regardless of what happens...
                    writer.close();
                } catch (Exception e) {
                }
            }


            for (int j = 0; j < link.size(); j++) {
                Statement statement = connection.createStatement();

                String crsurl = "https://canvas.net" + link.get(j).attr("href"); //Get the Course Url from href tag and add to www.edx.org to get the full URL to the course
                System.out.println("crsurl: " + crsurl);

                /** Course Name **/
                String CourseName;
                try {
                    CourseName = crspg.select("h3").get(j).text(); //Get the Course Name from H1 Tag
                    CourseName = CourseName.replace("'", "''");
                    CourseName = CourseName.replace(",", "");
                } catch (Exception e) {
                    CourseName = "N/A";
                }
                System.out.println("CourseName: " + CourseName); // DELETE ME

                /** Short Course Description **/
                String SCrsDesrpTemp;
                try {
                    SCrsDesrpTemp= crspg.select("div.product-description").get(j).text();
                    SCrsDesrpTemp = SCrsDesrpTemp.replace("?", "");
                    //String SCrsDesrp = SCrsDesrpTemp.substring(0, (SCrsDesrpTemp.length()-5)); //To get the course description and remove the extra characters at the end.
                    SCrsDesrpTemp = SCrsDesrpTemp.replace("'", "''");
                    SCrsDesrpTemp = SCrsDesrpTemp.replace(",", "");
                } catch (Exception e) {
                    SCrsDesrpTemp = "N/A";
                }
                System.out.println("SCrsDesrpTemp: " + SCrsDesrpTemp); // DELETE ME

                /** Course Image **/
                String CrsImg;
                if (a == 0 || a == 1) {
                    CrsImg = crspg.select("img[border=0]").get(j).absUrl("src"); //Grabs the course image from the img class
                } else {
                    CrsImg = "N/A"; //To get the course image - FOR URL4
                }
                System.out.println("CrsImg: " + CrsImg); // DELETE ME

                Document crsdoc = Jsoup.connect(crsurl).get();
                Elements crsheadele = crsdoc.select("section[class=course-header clearfix]");
                String youtube;

                /** Youtube **/
                try {
                    youtube = crsdoc.select("iframe[width=510]").get(0).absUrl("src"); //Youtube link
                } catch (Exception e) {
                    youtube = "N/A";
                }
                System.out.println("youtube: " + youtube); // DELETE ME

                Elements crsbodyele = crsdoc.select("section[class=course-detail clearfix]");

                /** Course Description **/
                String CrsDes;
                try {
                    CrsDes = crsdoc.select("div.course-details").text(); //Course Description Element
                    CrsDes = CrsDes.replace("'", "''");
                    CrsDes = CrsDes.replace(",", "");
                    if (CrsDes.contains("?")) {
                        CrsDes = CrsDes.replace("?", "");
                    }
                } catch (Exception e) {
                    CrsDes = "N/A";
                }
                System.out.println("CrsDes: " + CrsDes); // DELETE ME

                /** Start Date **/
                java.sql.Date sqlStrDate;
                java.util.Date dStrDate = new java.util.Date();
                try {
                    String tempStrDate = crsdoc.select("h5").get(0).text(); // only get start dd/mm/yyyy
                    //String lengthStrDate = tempStrDate.substring(7);
                    //String realStrDate = tempStrDate.substring(7,tempStrDate.length() + lengthStrDate.length());
                    String realStrDate = tempStrDate.substring(7, tempStrDate.indexOf(" ", tempStrDate.indexOf(" ") + 1));
                    int month = month(realStrDate);
                    String[] ddyy = realStrDate.split(", " );
                    System.out.println("strDate: " + month + tempStrDate); // DELETE ME
                    SimpleDateFormat sdf = new SimpleDateFormat("dd/MM/yyyy");
                    dStrDate = sdf.parse(ddyy[0]+ "/" + month + "/" +ddyy[1]);
                    sqlStrDate = new Date(dStrDate.getTime());
                    //String strDate = sqlStrDate.toString().replace("-", "");
                } catch (Exception e) {
                    sqlStrDate = new java.sql.Date(0);
                }
                System.out.println("sqlStrDate: " + sqlStrDate); // DELETE ME

                /** Duration **/
                int crsduration;
                try {
                    String tempEndDate = crsdoc.select("strong").get(1).text();
                    String realEndDate = tempEndDate.substring(tempEndDate.indexOf("-") + 1);
                    int month = month(realEndDate);
                    String[] ddyy = realEndDate.split(", ");
                    System.out.println("endDate: " + month + tempEndDate); // DELETE ME
                    SimpleDateFormat sdf = new SimpleDateFormat("dd/MM/yyyy");
                    java.util.Date dEndDate = sdf.parse(ddyy[0] + "/" + month + "/" + ddyy[1]);
                    long dateDiff = dEndDate.getTime() - dStrDate.getTime();
                    crsduration = (int) TimeUnit.DAYS.convert(dateDiff, TimeUnit.MILLISECONDS);
                } catch (Exception e) {
                    crsduration = 0;
                }
                System.out.println("crsduration: " + crsduration); // DELETE ME

                //The following is used to insert scraped data into your database table. Need to uncomment all database related code to run this.
                String query = "insert into course_data values(null,'" + CourseName + "','" + SCrsDesrpTemp + "','" + CrsDes + "','" + crsurl + "','" + youtube + "','" + sqlStrDate + "'," + crsduration + ",'" + CrsImg + "','','Open2Study')";
                System.out.println("query: " + query); // DELETE ME
                System.out.println(query);
                statement.executeUpdate(query);// skip writing to database; focus on data printout to a text file instead.
                statement.close();
            }
        }
        connection.close();
    }

    public static int month(String month){
        int monthNum;

        switch(month)
        {
            case "January":
                monthNum = 1;
                break;
            case "Jan":
                monthNum = 1;
                break;
            case "February":
                monthNum = 2;
                break;
            case "Feb":
                monthNum = 2;
                break;
            case "March":
                monthNum = 3;
                break;
            case "Mar":
                monthNum = 3;
                break;
            case "April":
                monthNum = 4;
                break;
            case "Apr":
                monthNum = 4;
                break;
            case "May":
                monthNum = 5;
                break;
            case "June":
                monthNum = 6;
                break;
            case "Jun":
                monthNum = 6;
                break;
            case "July":
                monthNum = 7;
                break;
            case "Jul":
                monthNum = 7;
                break;
            case "August":
                monthNum = 8;
                break;
            case "Aug":
                monthNum = 8;
                break;
            case "Septemeber":
                monthNum = 9;
                break;
            case "Sept":
                monthNum = 9;
                break;
            case "Octobor":
                monthNum = 10;
                break;
            case "Oct":
                monthNum = 10;
                break;
            case "November":
                monthNum = 11;
                break;
            case "Nov":
                monthNum = 11;
                break;
            case "December":
                monthNum = 12;
                break;
            case "Dec":
                monthNum = 12;
                break;
            default:
                monthNum = 0;
                break;
        }
        return monthNum;
    }
}
