public class fragment6 
{
	public static void main(String[] args)
	{
		System.out.println("100 samples took " + timer(100) + " nanoseconds.");
		System.out.println("200 samples took " + timer(200) + " nanoseconds.");
		System.out.println("400 samples took " + timer(400) + " nanoseconds.");
		System.out.println("800 samples took " + timer(800) + " nanoseconds.");
		System.out.println("1,000 samples took " + timer(1000) + " nanoseconds.");
	}
	
	public static long timer(double n)
	{
		long start = System.nanoTime();
		
		int sum = 0;
		for( int i = 1; i < n; i++ )
		{
			for( int j = 1; j < i * i; j++ )
			{
				if( j % i == 0 )
				{
					for( int k = 0; k < j; k++ )
					{
						sum++;
					}
				}
			}
		}
		
		long end = System.nanoTime();
		
		return end - start;
	}
}
