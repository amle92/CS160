import java.awt.Rectangle;

public class findRectangle 
{
	public static void main(String[] args) 
	{
		Rectangle[] rect = new Rectangle[5];
		rect[0] = new Rectangle(1, 2);
		rect[1] = new Rectangle(3, 4);
		rect[2] = new Rectangle(2, 10);
		rect[3] = new Rectangle(5, 6);
		rect[4] = new Rectangle(1, 9);

		Rectangle largestArea = findMaxPerimeter(rect);
		Rectangle largestPerimeter = findMaxArea(rect);
		
		System.out.println("Largest area: \n" + "Width = " + largestArea.getWidth() +
				"\n" + "Height = " + largestArea.getHeight() + "\n");
		
		System.out.println("Largest perimeter: \n" + "Width = " + largestPerimeter.getWidth() +
				"\n" + "Height = " + largestPerimeter.getHeight() + "\n");
	}

	public static double getLength(Rectangle r) 
	{
		return r.getHeight();
	}

	public static double getWidth(Rectangle r) 
	{
		return r.getWidth();
	}

	public static Rectangle findMaxArea(Rectangle[] arr) 
	{
		int maxIndex = 0;

		for (int i = 1; i < arr.length - 1; i++) 
		{
			if ((arr[i + 1].getWidth()) * (arr[i + 1].getHeight()) > (arr[maxIndex]
					.getWidth()) * (arr[maxIndex].getHeight())) 
			{
				maxIndex = i + 1;
			}
		}
		return arr[maxIndex];
	}
	
	public static Rectangle findMaxPerimeter(Rectangle[] arr) 
	{
		int maxIndex = 0;
		
		for (int i = 1; i < arr.length - 1; i++) 
		{
			if ((arr[i + 1].getWidth() * 2) + (arr[i+1].getHeight() * 2) > (arr[maxIndex].getWidth() * 2) 
					+ (arr[maxIndex].getHeight() * 2)) 
			{
					maxIndex = i + 1;
			}
		}
		return arr[maxIndex];
	}
}
