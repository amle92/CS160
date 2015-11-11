package testJsoup;
import org.joda.time.DateTime;
import org.joda.time.format.DateTimeFormat;
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
import java.time.format.DateTimeFormatter;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.concurrent.TimeUnit;

public class open2study {

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
        String url1 = "https://www.open2study.com/courses"; // open2study courses
        //String url2 = "https://www.canvas.net/"; // canvas courses


        ArrayList<String> pgcrs = new ArrayList<String>(); //Array which will store each course URLs
        pgcrs.add(url1);
        //pgcrs.add(url2);

        //The following few lines of code are used to connect to a database so the scraped course content can be stored.
        Class.forName("com.mysql.jdbc.Driver").newInstance();
        Statement stmt = null;
        java.sql.Connection connection = DriverManager.getConnection("jdbc:mysql://localhost:3307/moocs160", "root", "");
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
                Statement statement = connection.createStatement();

                String crsurl = "https://www.open2study.com" + link.get(j).attr("href"); //Get the Course Url from href tag and add to www.edx.org to get the full URL to the course
                System.out.println("crsurl: " + crsurl);
                //THE FOLLOWING CODE IS FOR THE TABLE COURSE_DETAILS. COULD NOT FIND ID AND COURSE_ID SO MANUALLY
                //INPUTTING AS N/A IN THE QUERY
                //Professor name
            	Document crsdoc = Jsoup.connect(crsurl).get();
            	String CrsProf;
                try {
                	CrsProf = crsdoc.select("h5").text();
                	//to delete 'by' in by author_name
                    CrsProf = CrsProf.replace("by", "");
                } catch (Exception e) {
                	CrsProf = "N/A";
                }
                System.out.println("Prof Name: " + CrsProf); // DELETE ME
                //professor's image
                String CrsImgProf;
                if (a == 0 || a == 1) {
                	//Grabs the professor's image
                    CrsImgProf = crsdoc.select("img.image-style-teacher-small-profile").get(0).absUrl("src");
                } else {
                    CrsImgProf = "N/A"; //To get the course image - FOR URL4
                }
                	System.out.println("CrsImg: " + CrsImgProf); // DELETE ME
                
                
                //THE FOLLOWING CODE IS FOR THE TABLE COURSE_DATA. MANUALLY INPUTTING FOLLOWING ELEMENTS IN THE QUERY:
                	//course_fee = free
                	//language = english
                	//certificate = yes because every course seems to offer certificate of achievement
                /** Course Name **/
                String CourseName;
                try {
	                CourseName = crspg.select("h2").get(j).text(); //Get the Course Name from H1 Tag
	                CourseName = CourseName.replace("'", "''");
	                CourseName = CourseName.replace(",", "");
                } catch (Exception e) {
                	CourseName = "N/A";
                }
                	System.out.println("CourseName: " + CourseName); // DELETE ME
                
                /** Short Course Description **/
                String SCrsDesrpTemp;
                try {
                	SCrsDesrpTemp= crspg.select("div.adblock_course_body").get(j).text();
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
                    CrsImg = crspg.select("img[width=260]").get(j).absUrl("src"); //Grabs the course image from the img class
                } else {
                    CrsImg = "N/A"; //To get the course image - FOR URL4
                }
                	System.out.println("CrsImg: " + CrsImg); // DELETE ME
                
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
                	CrsDes = crsdoc.select("div.readmore-container>div.full-body").text(); //Course Description Element
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
                	String tempStrDate = crsdoc.select("h2.offering_dates_date").get(0).text(); // only get start dd/mm/yyyy
                 		System.out.println("strDate: " + tempStrDate); // DELETE ME
	                SimpleDateFormat sdf = new SimpleDateFormat("dd/MM/yyyy");
	                dStrDate = sdf.parse(tempStrDate);
	                sqlStrDate = new Date(dStrDate.getTime());
	                //String strDate = sqlStrDate.toString().replace("-", "");
                } catch (Exception e) {
                	sqlStrDate = new java.sql.Date(0);
                }
                System.out.println("sqlStrDate: " + sqlStrDate); // DELETE ME
                
                /** Duration **/
                int crsduration;
                try {
	                String tempEndDate = crsdoc.select("h2.offering_dates_date").get(1).text();
	                	System.out.println("endDate: " + tempEndDate); // DELETE ME
	                SimpleDateFormat sdf = new SimpleDateFormat("dd/MM/yyyy");
	                java.util.Date dEndDate = sdf.parse(tempEndDate);
	                long dateDiff = dEndDate.getTime() - dStrDate.getTime();
	                crsduration = (int) TimeUnit.DAYS.convert(dateDiff, TimeUnit.MILLISECONDS);
                } catch (Exception e) {
                	crsduration = 0;
                }
                System.out.println("crsduration: " + crsduration); // DELETE ME
                
                //university's image
                String CrsImgUni;
                if (a == 0 || a == 1) {
                   //Grabs the professor's image
                    CrsImgUni = crsdoc.select("img.image-style-educator-details-logo").get(0).absUrl("src");
                  } else {
                     CrsImgUni = "N/A"; //To get the course image - FOR URL4
                   }
                   System.out.println("University: " + CrsImgUni); // DELETE ME 
                   
                   
                   
                //date scraped/ Day/Month/Year
                //java.util.Date date= new java.util.Date();
                //System.out.println(date);
                 //DateFormat df = new SimpleDateFormat("YYYY-MM-DD HH:mm:ss");
                 //String formattedDate = df.format(date);
                 //System.out.println(formattedDate);
                 //DateTime dateForSql = DateTime.parse(formattedDate, 
                   //      DateTimeFormat.forPattern("dd/MM/yyyy HH:mm:ss"));
                 //System.out.println(dt);
                   java.util.Date dt = new java.util.Date();

                   java.text.SimpleDateFormat sdf = 
                        new java.text.SimpleDateFormat("yyyy-MM-dd HH:mm:ss");

                   String currentTime = sdf.format(dt);
                   System.out.println(currentTime);
                
                //The following is used to insert scraped data into your database table. Need to uncomment all database related code to run this.
            
                String category = "null";
                   String query = "insert into course_data values(null,'" + CourseName + "','"
                           + SCrsDesrpTemp + "','" + CrsDes + "','" + crsurl + "','" 
                                   + youtube + "','" + sqlStrDate + "','" + crsduration + "','" 
                           + CrsImg + "','" + category + "'," + "'Open2Study', '0.00', 'English', 'Yes','" + CrsImgUni + "','" + currentTime + "')";
                	//System.out.println("query: " + query); // DELETE ME
                //System.out.println(query);
                statement.executeUpdate(query);// skip writing to database; focus on data printout to a text file instead.
                String query2 = "insert into coursedetails values(null,'"+ CrsProf + 
                		"','" + CrsImgProf + "'," + "null)" ; 
                
                //System.out.println(query2);
                statement.executeUpdate(query2);
                statement.close();
            }
        }
        connection.close();
    }
    
    public DateTime dateAndTimeToDateTime(java.sql.Date date, java.sql.Time time) {
        String myDate = date + " " + time;
        SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
        java.util.Date utilDate = new java.util.Date();
        try {
            utilDate = sdf.parse(myDate);
        } catch (ParseException pe){
            pe.printStackTrace();
        }
        DateTime dateTime = new DateTime(utilDate);

        return dateTime;
    }
}