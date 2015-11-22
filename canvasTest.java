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
import org.joda.time.DateTime;
import org.joda.time.Days;
import org.joda.time.Instant;
import org.joda.time.Interval;
import org.joda.time.ReadableInstant;

public class canvasTest {
	public ArrayList<String> link;
	private static final String defaultStartDateStr = "31/12/2020";
	private static final String iowaStatic1 = "17/11/2015";
	private static final String iowaStatic2 = "16/12/2015";


	/**
	 * @param args
	 * @throws IOException
	 * @throws ClassNotFoundException
	 * @throws IllegalAccessException
	 * @throws InstantiationException
	 * @throws SQLException
	 * @throws ParseException
	 */
	public static void main(String[] args) throws IOException, InstantiationException, IllegalAccessException,
			ClassNotFoundException, SQLException, ParseException {
		// The following few lines of code are used to connect to a database so
		// the scraped course content can be stored.
		Class.forName("com.mysql.jdbc.Driver").newInstance();
		java.sql.Connection connection = DriverManager.getConnection("jdbc:mysql://localhost:3307/moocs160", "root",
				"");
		// make sure you create a database named scrapedcourse in your local
		// mysql database before running this code
		// default mysql database in your local machine is ID:root with no
		// password
		// you can download scrapecourse database template from your Canvas
		// account->modules->Team Project area
		// String furl = (String) pgcrs.get(a);
		// Document doc = Jsoup.connect(furl).get();
		// Elements ele = doc.select("div[id=home-page]");
		// Elements crspg = ele.select("div.col-md-3 col-sm-6");
		// Elements link = crspg.select("a[href]");
		// created this object to access the arraylist
		canvas_json object = new canvas_json();
		object.getCourseInfo();
		ArrayList<String> link = object.crsLinks;
		ArrayList<String> shortcrsDes = object.shortcrsDes;
		ArrayList<String> universityList = object.university;
		ArrayList<String> categoryL = object.crsCategory;
		ArrayList<String> courseImg = object.crsImg;
		String site = "canvas";
		String language = "English";
		ReadableInstant oldTime = null;
		int crsDuration = 0;
		// Interval interval = new Interval(oldTime, new Instant());
		// DateTime end = null;
		// DateTime start = null;
		System.out.println(link.size());
		for (int j = 0; j < link.size(); j++) {
			Statement statement = connection.createStatement();
			// the url
			String furl = (String) link.get(j);
			// the short description of the course
			String shortDescription = (String) shortcrsDes.get(j);
			String shrtDes = shortDescription.replace("'", "''");
			// the university
			String university = (String) universityList.get(j);
			university = university.replace("'", "''");

			// category
			String category = "";
			// course's image
			String courseImage = (String) courseImg.get(j);

			Document doc = Jsoup.connect(furl).get();
			// System.out.println(link.get(j));

			// THE FOLLOWING PIECE OF CODE IS FOR COURSEDETAILS SCHEMA
			// for the professor name
			String profName;
			// WORKS: System.out.println("Short course description: " +
			// shortDescription);
			// WORKS: System.out.println("University: " + university);
			// WORKS: System.out.println("Category: " + category);
			try {
				Element profN = doc.select("div.instructors>img[alt]").first();
				profName = profN.attr("alt");
				System.out.println("Professor Name: " + profName);
				// this if statement deals with if the img don't have the alt
				// because the alt stores the professor's
				// name in a more neat manner
				if (profName == "") {
					profName = doc.select("div.instructors>h3").text();
					// WORKS: System.out.println("Professor Name: " + profName);
				}

			} catch (Exception e) {
				profName = "";
			}

			// for the professor image
			String profImg;
			try {
				Element e = doc.select("div.instructors>img[src]").first();
				profImg = e.attr("src");
				// WORKS: System.out.println("Professor Image: " + profImg);
			} catch (Exception e) {
				profImg = "";
			}

			//
			//
			//
			//
			// THE FOLLOWING PIECE OF CODE IS FOR COURSE_DATA SCHEMA
			// Course Name
			String courseName;
			try {
				courseName = doc.select("h2").get(0).text();
				courseName = courseName.replace("'", "''");

				// courseName.replace("'", " ");
				// WORKS: System.out.println("title: " + courseName);
			} catch (Exception e) {
				courseName = "";
			}

			// Long course description
			String courseDesLong;
			try {
				courseDesLong = doc.select("div.course-details>p").text();
				// WORKS: System.out.println("Long Description: " +
				// courseDesLong);
				courseDesLong = courseDesLong.replace("'", "''");
			} catch (Exception e) {
				courseDesLong = "";
			}

			// course's fee
			String courseFee;
			int crsFee = 0;
			try {
				courseFee = doc.select("div.product-image>div.product-flag.product-flag-free").text();
				if (courseFee.equals("Free")) {
					crsFee = 0;
				}
				// WORKS: System.out.println("Fee: " + courseFee);
			} catch (Exception e) {
				crsFee = -1;
			}
			/** Start Date and Duration **/
			java.sql.Date sqlStrDate = null;
			java.util.Date dStrDate = new java.util.Date();
			DateTime start;
			DateTime end;
			Days days;
			try {
				sqlStrDate = new Date(dStrDate.getTime());
				String tempStrDate = doc.select("h5").get(0).text(); // only get
																		// start
																		// dd/mm/yyyy
				//if the date starts with available beginning
				if (tempStrDate.startsWith("Available beginning")) {
					String realStrDate2 = tempStrDate.substring(20);
					String toParseDate2 = realStrDate2.replace(",", "");
					// this gets the month
					String extractedMonth = toParseDate2.substring(0, toParseDate2.indexOf(" "));
					int month = month(extractedMonth);
					String[] ddyy = toParseDate2.split(" ");
					SimpleDateFormat sdf = new SimpleDateFormat("dd/MM/yyyy");
					dStrDate = sdf.parse(ddyy[1] + "/" + month + "/" + ddyy[2]);
					sqlStrDate = new Date(dStrDate.getTime());
					crsDuration = 0;					
				} else if(tempStrDate.startsWith("Starts")) {
					String realStrDate = tempStrDate.substring(7,
							tempStrDate.indexOf(" ", tempStrDate.indexOf(" ") + 1));
					String toParseDate = tempStrDate.replace(",", " ");
					int month = month(realStrDate);
					// System.out.println(month);
					String[] ddyy = toParseDate.substring(7).split(" ");
					SimpleDateFormat sdf = new SimpleDateFormat("dd/MM/yyyy");
					dStrDate = sdf.parse(ddyy[1] + "/" + month + "/" + ddyy[3]);
					sqlStrDate = new Date(dStrDate.getTime());
					int year = (Integer.parseInt(ddyy[3]));
					int day = (Integer.parseInt(ddyy[1]));
					

					start = new DateTime(year, month, day, 0, 0, 0, 0);

					// String strDate = sqlStrDate.toString().replace("-", "");

					// System.out.println("start"+ start.toString());

					// End date
					String tempEndDate = doc.select("strong").get(0).text();
					String realEndDate = tempEndDate.substring(tempEndDate.indexOf("-") + 1);
					String[] realStrMonth = realEndDate.split(" ");
					int endMonth = month(realStrMonth[1]);
					String toParseEndDate = realEndDate.replace(",", " ");
					String[] ddyyEnd = toParseEndDate.split(" ");
					int yearEnd = (Integer.parseInt(ddyyEnd[4]));
					int dayEnd = (Integer.parseInt(ddyyEnd[2]));
					end = new DateTime(yearEnd, endMonth, dayEnd, 0, 0, 0, 0);

					days = Days.daysBetween(start, end);
					crsDuration = days.getDays();
				}
				else if(tempStrDate.startsWith("Available")){
					try{
					String toParseDate = tempStrDate.replace(",", " ");
					toParseDate = toParseDate.replace("\u00A0", " ");
					String ddyy[] = toParseDate.split(" ");
					System.out.println();
					String startingMonth = ddyy[1];
					String endingMonth = ddyy[6];
					int startMonth = month(startingMonth);
					int endMonth = month(endingMonth);
					int startDay = (Integer.parseInt(ddyy[2]));
					int endDay = (Integer.parseInt(ddyy[7]));
					int startYear = (Integer.parseInt(ddyy[4]));
					int endYear = (Integer.parseInt(ddyy[9]));
					
					SimpleDateFormat sdf = new SimpleDateFormat("dd/MM/yyyy");
					dStrDate = sdf.parse(startDay + "/" + startMonth + "/" + startYear);
					sqlStrDate = new Date(dStrDate.getTime());
					System.out.println(sqlStrDate);
					start = new DateTime(startYear, startMonth, startDay, 0, 0, 0, 0);
					end = new DateTime(endYear, endMonth, endDay, 0, 0, 0, 0);
					days = Days.daysBetween(start, end);
					crsDuration = days.getDays();
					

					}
					catch(Exception e){
						e.printStackTrace();
					}
					
				}
				//if course starts with opens
				else if(tempStrDate.startsWith("Opens")){
					crsDuration = 0;
					String toParseDate = tempStrDate.replace(",", " ");
					String ddyy[] = toParseDate.split(" ");
					String startingMonth = ddyy[1];
					int month = month(startingMonth);
					int day = Integer.parseInt(ddyy[2]);
					int year = Integer.parseInt(ddyy[4]);
					SimpleDateFormat sdf = new SimpleDateFormat("dd/MM/yyyy");
					dStrDate = sdf.parse(day + "/" + month + "/" + year);
					sqlStrDate = new Date(dStrDate.getTime());
					
					
					
				}
				else{
					if(courseName.equals("Iowa Presidential Caucuses")){
						System.out.println("HELLO");
						SimpleDateFormat sdf = new SimpleDateFormat("dd/MM/yyyy");
						dStrDate = sdf.parse(iowaStatic1);
						sqlStrDate = new java.sql.Date(dStrDate.getTime());
						crsDuration = 29;
						
					}
				else if(!tempStrDate.equals("Self-paced")){
						
						String toParseDate = tempStrDate.replace(",", " ");
						System.out.println(toParseDate);
						toParseDate = toParseDate.replace("\u00A0", " ");
						String[] ddyy = toParseDate.split(" ");
						String startingMonth = ddyy[0];
						String endingMonth = ddyy[6];
						int startMonth = month(startingMonth);

						int endMonth = month(endingMonth);

						int startDay = Integer.parseInt(ddyy[1]);

						int endDay = Integer.parseInt(ddyy[7]);
						System.out.println(endDay);

						int startYear = Integer.parseInt(ddyy[3]);

						int endYear = Integer.parseInt(ddyy[9]);

						SimpleDateFormat sdf = new SimpleDateFormat("dd/MM/yyyy");
						dStrDate = sdf.parse(startDay + "/" + startMonth + "/" + startYear);
						sqlStrDate = new Date(dStrDate.getTime());
						start = new DateTime(startYear, startMonth, startDay, 0, 0, 0, 0);
						end = new DateTime(endYear, endMonth, endDay, 0, 0, 0, 0);
						days = Days.daysBetween(start, end);
						crsDuration = days.getDays();
					}
					//if the course is self paced
					else if(tempStrDate.equals("Self-paced")){
						System.out.println("HELLO");
						String date = doc.select("strong").get(0).text();
						if(!(date.equals("Self-paced"))){
							crsDuration = 0;
							String toParseDate = date.replace(",", " ");
							String[] ddyy = toParseDate.split(" ");
							String startingMonth = ddyy[1];
							int startMonth = month(startingMonth);
							int day = Integer.parseInt(ddyy[2]);
							int year = Integer.parseInt(ddyy[4]);
							SimpleDateFormat sdf = new SimpleDateFormat("dd/MM/yyyy");
							dStrDate = sdf.parse(day + "/" + startMonth + "/" + year);
							sqlStrDate = new Date(dStrDate.getTime());
						}
						else{
							SimpleDateFormat sdf = new SimpleDateFormat("dd/MM/yyyy");
							dStrDate = sdf.parse(defaultStartDateStr);
							sqlStrDate = new java.sql.Date(dStrDate.getTime());
						}
					}
					
				}
			} catch (Exception e) {
				days = null;

			}
			String certificate = "no";
			try {
				String desc = doc.select("div.course-details>p").text();
				if (desc.contains("certifica")) {
					certificate = "yes";
				}
				// WORKS: System.out.println("Certificate " + certificate);
			} catch (Exception e) {
				certificate = "no";
			}

			// PROGRAM A WAY TO EXTRACT THE LANGUAGE RATHER THAN HARD CODING IT
			if (courseName.equals("Creative Box")) {
				language = "French";
			} else if (courseName.equals("Metadatos para recursos educativos")) {
				language = "Spanish";
			} else {
				language = "English";
			}

			// course url
			String courseLink;
			courseLink = link.get(j);
			// WORKS: System.out.println("URL: " + courseLink);

			// time scraped
			java.util.Date dt = new java.util.Date();

			java.text.SimpleDateFormat sdf = new java.text.SimpleDateFormat("yyyy-MM-dd HH:mm:ss");

			String currentTime = sdf.format(dt);

			// insert into the couse_data schema
			// System.out.println("Course Name: " + courseName);
			String query = "insert into course_data values(null,'" + courseName + "','" + shrtDes + "','"
					+ courseDesLong + "','" + courseLink + "','" + "" + "','" + sqlStrDate + "','" + crsDuration
					+ "','" + courseImage + "','" + category + "'," + "'Canvas'," + crsFee + ",'" + language + "','"
					+ certificate + "','" + university + "','" + currentTime + "')";
			//System.out.println(query);
					statement.executeUpdate(query);
					
					 System.out.println("Course Name: " + courseName);
					  System.out.println("shrtDes: " + shrtDes);
					  System.out.println("courseDesLong: " + courseDesLong);
					  System.out.println("courseLink:" + courseLink);
					  System.out.println("sqlStrDate: " + sqlStrDate);
					  System.out.println("crsDuration: " + crsDuration);
					  System.out.println("courseImage: " + courseImage);
					  System.out.println("category: " + category);
					  System.out.println("crsFee: " + crsFee);
					  System.out.println("language: " + language);
					  System.out.println("certificate: " + certificate);
					  System.out.println("university: " + university);
					  System.out.println("currentTime: " + currentTime);
					 

			//insert into the coursedetails schema
			String query2 = "insert into coursedetails values(null,'" + profName + "','" + profImg + "'," + "null)";
			statement.executeUpdate(query2);
			String youtube = "null";

			statement.close();
		}

		// connection.close();
	}

	public static int month(String month) {
		int monthNum;

		switch (month) {
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
		case "September":
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
		case " to December":
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