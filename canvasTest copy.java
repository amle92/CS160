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


            for (int j = 0; j < link.size(); j++) {
                Statement statement = connection.createStatement();
                String furl = (String) link.get(j);
                Document doc = Jsoup.connect(furl).get();
            	//System.out.println(link.get(j));
                //THE FOLLOWING PIECE OF CODE IS FOR COURSEDETAILS SCHEMA
                //for the professor name
                String profName;
                try{
                	Element profN = doc.select("div.instructors>img[alt]").first();
                	profName = profN.attr("alt");
                	System.out.println("Professor Name: " + profName);
                	//this if statement deals with if the img don't have the alt because the alt stores the professor's
                	//name in a more neat manner
                	if(profName == ""){
                		profName = doc.select("div.instructors>h3").text();
                    	System.out.println("Professor Name: " + profName);
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
                	System.out.println("Professor Image: " + profImg);
                }
                catch(Exception e){
                	profImg = "N/A";
                }

                //THE FOLLOWING PIECE OF CODE IS FOR COURSE_DATA SCHEMA
                //Course Name
                String courseName;
                try{
                	courseName = doc.select("h2").get(0).text();
                	System.out.println("title: " + courseName);	
                }
                catch(Exception e){
                	courseName = "N/A";
                }
                
                //Long course description
                String courseDesLong;
                try{
                	courseDesLong = doc.select("div.course-details>p").text();
                	System.out.println("Long Description: " + courseDesLong);
                }
                catch(Exception e){
                	courseDesLong = "N/A";
                }
                
                //course's fee
                String courseFee;
                try{
                	courseFee = doc.select("div.product-image>div.product-flag.product-flag-free").text();
                	System.out.println("Fee: " + courseFee);
                }
                catch(Exception e){
                	
                }
                
                //course url
                String courseLink;
                courseLink = link.get(j);
                System.out.println("URL: " + courseLink);

                
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