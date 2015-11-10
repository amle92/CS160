public class fragment5 
{
	public static void main(String[] args)
	{
		System.out.println("100 samples took " + timer(100) + " nanoseconds.");
		System.out.println("500 samples took " + timer(500) + " nanoseconds.");
		System.out.println("1,000 samples took " + timer(1000) + " nanoseconds.");
		System.out.println("1,500 samples took " + timer(1500) + " nanoseconds.");
		System.out.println("2,000 samples took " + timer(2000) + " nanoseconds.");
	}
	
	public static long timer(double n)
	{
		long start = System.nanoTime();
		
		int sum = 0;
		for( int i = 0; i < n; i++ )
		{
			for( int j = 0; j < i * i; j++ )
			{
				for( int k = 0; k < j; k++ )
				{
					sum++;
				}
			}
		}
		
		long end = System.nanoTime();
		
		return end - start;
	}
}
