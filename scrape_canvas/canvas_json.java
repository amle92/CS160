import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.sql.Date;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.sql.Statement;
import java.text.DateFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.concurrent.TimeUnit;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.ProtocolException;
import java.net.URL;

import org.json.*;

/**
 * 
 * @author atsang
 *
 * Note: ONLY TESTED FOR USE WITH http://www.canvas.net
 * 		 THIS CODE STORES THE LINKS TO ALL OF CANVAS.NET's COURSES IN THE ARRAYLIST "crsLinks".
 * 		 	You should ONLY need access crsLinks.
 */
public class canvas_json {
	private String baseUrl = "https://www.canvas.net/";
	private String jsonGETpt1 = "/products.json?page=";
	private static int currentPageNum;
	private String jsonGETpt2 = "&query=";
	private static int jsonRemaining;
	public ArrayList<String> crsLinks = new ArrayList<String>();
	
	public static void main(String[] args) {
		canvas_json canvas = new canvas_json();
		currentPageNum = 1;
		jsonRemaining = 1; //overloaded
		canvas.getCourseInfo();
	}
	
	public URL getURL(int pageNum) {
		URL tempURL = null;
		try {
			tempURL = new URL(baseUrl + jsonGETpt1 + String.valueOf(pageNum) + jsonGETpt2);
		} catch (MalformedURLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return tempURL;
	}
	
	public HttpURLConnection openCon(URL urlToConnectTo) {
		HttpURLConnection tempCon = null;
		try {
			tempCon = (HttpURLConnection) urlToConnectTo.openConnection();
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return tempCon;
	}
	
	public int getResponseCode(HttpURLConnection tempCon) {
		int tempResponseCode = -1;
		try {
			tempResponseCode = tempCon.getResponseCode();
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return tempResponseCode;
	}
	
	public BufferedReader getHTTPbr(HttpURLConnection tempCon) {
		BufferedReader in = null;
		try {
			in = new BufferedReader(
			        new InputStreamReader(tempCon.getInputStream()));
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return in;
	}
	
	public StringBuffer getResponseBuffer(BufferedReader tempBreader) {
		String inputLine;
		StringBuffer tempResponse = new StringBuffer();

		try {
			while ((inputLine = tempBreader.readLine()) != null) {
				tempResponse.append(inputLine);
			}
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return tempResponse;
	}
	
	public void parseJSON(JSONObject tempJSON) {
		jsonRemaining = (int) tempJSON.get("remaining");
		// System.out.println(jsonRemaining); // prints the value of the "remaining" attribute in the current json
		JSONArray courses = tempJSON.getJSONArray("products");
		
		JSONObject crs = null;
		for(int i = 0; i < courses.length(); i++) {
			crs = courses.getJSONObject(i);
			// coursedata table attributes
			//System.out.println(coursedata.id); // AutoIncremented in SQL
			// WORKS System.out.println("title: " + crs.getString("title"));
			// WORKS System.out.println("short_desc: " + crs.getString("teaser"));
			// TO_DO System.out.println("long_desc: " + crs.getString("fixME")); 
				// full course desc
			// WORKS System.out.println("course_link: " + crs.getString("url"));
			// TO_DO System.out.println("video_link: " + crs.getString("fixMe")); 
				// "N/A"?
			// TO_DO System.out.println("start_date: " + crs.getString("fixMe")); 
				// div[class=course-details] h5
			// TO_DO System.out.println("course_length: " + crs.getString("fixMe")); 
				// course duration, calculate, or "self-paced"?
			// WORKS System.out.println("course_image: " + crs.getString("image"));
			// WORKS System.out.println("category: " + crs.getString("type")); 
				// they're all type "Course"... Fix if necessary
			// WORKS System.out.println("site: " + crs.getString("url"));
			// TO_DO System.out.println("course_fee: " + crs.getString("priceWithCurrency"));
				// substring to drop currency
			// TO_DO System.out.println("language: " + crs.getString("fixMe"));
				// can't assume english. "creative box" is in french...
			// TO_DO System.out.println("certificate: " + crs.getString("fixMe")); 
				// (SQL boolean) div[course-details]... 
				// if find "certification||certificate" (or certify?) set to true
			// WORKS System.out.println("university: " + crs.getJSONObject("logo").getString("label"));
			// TO_DO System.out.println("time_scraped: " + crs.getString("fixMe"));
			crsLinks.add(crs.getString("url"));
		}
	}
	
	public void getCourseInfo() {
		do {
			URL urlObj = getURL(currentPageNum);
			HttpURLConnection con = openCon(urlObj); 
			//System.out.println(con.getRequestMethod()); // Default Request Method = GET
			
			//int responseCode = getResponseCode(con);
			//System.out.println("\nSending 'GET' request to URL : " + urlObj);
			//System.out.println("Response Code : " + responseCode);

			BufferedReader breader = getHTTPbr(con);
			StringBuffer responseBuffer = getResponseBuffer(breader);
			
			try {
				breader.close();
			} catch (IOException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}

			//print result
			//System.out.println(responseBuffer.toString());
			
			JSONObject jsonOBJ = new JSONObject(responseBuffer.toString());
			parseJSON(jsonOBJ);
			currentPageNum++;
		} while (jsonRemaining > 0);
		
		// print out ArrayList crsLinks
		int tempCount = 1;
		for (String specificCrsLink : crsLinks) {
			System.out.print(tempCount++);
			System.out.println(": " + specificCrsLink);	
		}
	}
}
