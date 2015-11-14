package testJsoup;
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
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class canvasTest {
	public ArrayList<String> link;
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
        String url1 = "https://www.canvas.net"; // canvas

        //ArrayList<String> pgcrs = new ArrayList<String>(); //Array which will store each course URLs
        //.add(url1);
        //pgcrs.add(url2);

        //The following few lines of code are used to connect to a database so the scraped course content can be stored.
        Class.forName("com.mysql.jdbc.Driver").newInstance();
        java.sql.Connection connection = DriverManager.getConnection("jdbc:mysql://localhost:3307/moocs160", "root", "");
        //make sure you create a database named scrapedcourse in your local mysql database before running this code
        //default mysql database in your local machine is ID:root with no password
        //you can download scrapecourse database template from your Canvas account->modules->Team Project area
            //String furl = (String) pgcrs.get(a);
            //Document doc = Jsoup.connect(furl).get();
            //Elements ele = doc.select("div[id=home-page]");
            //Elements crspg = ele.select("div.col-md-3 col-sm-6");
            //Elements link = crspg.select("a[href]");
        //created this object to access the arraylist
            canvas_json object = new canvas_json();
            object.getCourseInfo();
            ArrayList<String> link = object.crsLinks;
            ArrayList<String> shortcrsDes = object.shortcrsDes;
            ArrayList<String> universityList = object.university;
            ArrayList<String> categoryL = object.crsCategory;
            ArrayList<String> courseImg = object.crsImg;
            String site = "canvas";


            for (int j = 0; j < link.size(); j++) {
                Statement statement = connection.createStatement();
                //the url
                String furl = (String) link.get(j);
                //the short description of the course
                String shortDescription = (String)shortcrsDes.get(j);
                //the university
                String university = (String)universityList.get(j);
                //category
                String category = (String)categoryL.get(j);
                //course's image
                String courseImage = (String)courseImg.get(j);
                
                Document doc = Jsoup.connect(furl).get();
            	//System.out.println(link.get(j));
                
                //THE FOLLOWING PIECE OF CODE IS FOR COURSEDETAILS SCHEMA
                //for the professor name
                String profName;
                //WORKS: System.out.println("Short course description: " + shortDescription);
                //WORKS: System.out.println("University: " + university);
                //WORKS: System.out.println("Category: " + category);
                try{
                	Element profN = doc.select("div.instructors>img[alt]").first();
                	profName = profN.attr("alt");
                	System.out.println("Professor Name: " + profName);
                	//this if statement deals with if the img don't have the alt because the alt stores the professor's
                	//name in a more neat manner
                	if(profName == ""){
                		profName = doc.select("div.instructors>h3").text();
                    	//WORKS: System.out.println("Professor Name: " + profName);
                	}
                	
                }
                catch(Exception e){
                	profName = "N/A";
                }
                
                //for the professor image
                String profImg;
                try{
                	Element e = doc.select("div.instructors>img[src]").first();
                	profImg = e.attr("src");
                	//WORKS: System.out.println("Professor Image: " + profImg);
                }
                catch(Exception e){
                	profImg = "N/A";
                }

                //
                //
                //
                //
                //THE FOLLOWING PIECE OF CODE IS FOR COURSE_DATA SCHEMA
                //Course Name
                String courseName;
                try{
                	courseName = doc.select("h2").get(0).text();
                	//WORKS: System.out.println("title: " + courseName);	
                }
                catch(Exception e){
                	courseName = "N/A";
                }
                
                //for getting the course's image
                /**String courseImg;
                String finalcourseImg;
                try{
                	Element courseI = doc.select("div.image-container>span[style]").first();
                	courseImg = courseI.attr("style");
                	//courseImg = doc.select("div.image-container>img").text();
                	Matcher m = Pattern.compile("\\(([^)]+)\\)").matcher(courseImg);
                	 while(m.find()) {
                		   finalcourseImg = (m.group(1));
                	       //WORKS: System.out.println("course image: " + finalcourseImg);    
                	     }
                	//System.out.println("Course image: " + courseImg);
                	//System.out.println("hello");
                	
                }
                catch(Exception e){
                	courseImg = "n/a";
                }*/
                
                //Long course description
                String courseDesLong;
                try{
                	courseDesLong = doc.select("div.course-details>p").text();
                	//WORKS: System.out.println("Long Description: " + courseDesLong);
                }
                catch(Exception e){
                	courseDesLong = "N/A";
                }
                
                //course's fee
                String courseFee;
                try{
                	courseFee = doc.select("div.product-image>div.product-flag.product-flag-free").text();
                	//WORKS: System.out.println("Fee: " + courseFee);
                }
                catch(Exception e){
                	courseFee = "N/A";
                }          
                /** Start Date **/
                java.sql.Date sqlStrDate;
                java.util.Date dStrDate = new java.util.Date();
                try {
                    String tempStrDate = doc.select("h5").get(0).text(); // only get start dd/mm/yyyy
                    //String lengthStrDate = tempStrDate.substring(7);
                    //String realStrDate = tempStrDate.substring(7,tempStrDate.length() + lengthStrDate.length());
                    String realStrDate = tempStrDate.substring(7, tempStrDate.indexOf(" ", tempStrDate.indexOf(" ") + 1));
                    String toParseDate = tempStrDate.replace(","," ");
                    int month = month(realStrDate);
                    String[] ddyy = toParseDate.substring(7).split(" ");
                    SimpleDateFormat sdf = new SimpleDateFormat("dd/MM/yyyy");
                    dStrDate = sdf.parse(ddyy[1] + "/" + month + "/" + ddyy[3]);
                    sqlStrDate = new Date(dStrDate.getTime());
                    //String strDate = sqlStrDate.toString().replace("-", "");
                } catch (Exception e) {
                    sqlStrDate = new java.sql.Date(0);
                }

                /** Duration **/
                int crsduration;
                try {
                    String tempEndDate = doc.select("strong").get(1).text();
                    String realEndDate = tempEndDate.substring(tempEndDate.indexOf("-") + 1);
                    int month = month(realEndDate);
                    String[] ddyy = realEndDate.split(", ");
                	//System.out.println("hello");
                    //System.out.println("endDate: " + month + tempEndDate); // DELETE ME
                    SimpleDateFormat sdf = new SimpleDateFormat("dd/MM/yyyy");
                    java.util.Date dEndDate = sdf.parse(ddyy[0] + "/" + month + "/" + ddyy[1]);
                    long dateDiff = dEndDate.getTime() - dStrDate.getTime();
                    crsduration = (int) TimeUnit.DAYS.convert(dateDiff, TimeUnit.MILLISECONDS);
                } catch (Exception e) {
                	e.printStackTrace();
                    crsduration = 0;
                }

                /** Certificate **/
                Boolean certificate = false;
                try{
                    String desc = doc.select("div.course-details>p").text();
                    if (desc.contains("certifica")){
                        certificate = true;
                    }
                    //WORKS: System.out.println("Certificate " + certificate);
                }
                catch(Exception e){
                    certificate = false;
                }
                
                //course url
                String courseLink;
                courseLink = link.get(j);
                //WORKS: System.out.println("URL: " + courseLink);
                
                //time scraped
                java.util.Date dt = new java.util.Date();

                java.text.SimpleDateFormat sdf = 
                     new java.text.SimpleDateFormat("yyyy-MM-dd HH:mm:ss");

                String currentTime = sdf.format(dt);
                
                //insert into the couse_data schema
                String query = "insert into course_data values(null,'" + courseName + "','"
                        + shortDescription + "','" + courseDesLong + "','" + courseLink + "','" 
                                + "'N/A'" + "','" + sqlStrDate + "','" + crsduration + "','" 
                        + courseImage + "','" + category + "'," + "'Canvas'," + courseFee
                        + ", 'English', 'Yes','" + university + "','" + currentTime + "')";
                //statement.executeUpdate(query);
                System.out.println(query);
                
                //insert into the coursedetails schema
                String query2 = "insert into coursedetails values(null,'"+ profName + 
                		"','" + profImg + "'," + "null)" ; 
                //statement.executeUpdate(query2);
                System.out.println(query2);
                statement.close();            
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
            case "October":
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