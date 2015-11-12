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

public class canvas_api {
	private String baseUrl = "https://www.canvas.net/";
	
	public static void main(String[] args) {
		canvas_api canvas = new canvas_api();
		
		canvas.getCourseInfo();
	}
	
	public void getCourseInfo() {
		URL urlObj = null;
		try {
			urlObj = new URL(baseUrl + "?" + "/api/v1/courses/702");
		} catch (MalformedURLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		HttpURLConnection con = null;
		
		try {
			con = (HttpURLConnection) urlObj.openConnection();
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		try {
			con.setRequestMethod("GET");
		} catch (ProtocolException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		try {
			int responseCode = con.getResponseCode();
			System.out.println("\nSending 'GET' request to URL : " + urlObj);
			System.out.println("Response Code : " + responseCode);
	
			BufferedReader in = new BufferedReader(
			        new InputStreamReader(con.getInputStream()));
			String inputLine;
			StringBuffer response = new StringBuffer();
	
			while ((inputLine = in.readLine()) != null) {
				response.append(inputLine);
			}
			in.close();

			//print result
			System.out.println(response.toString());
		} catch (Exception e) {
			e.printStackTrace();
		}
	}
}
