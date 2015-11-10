public class fragment1 
{
	public static void main(String[] args)
	{
		System.out.println("100 samples took " + timer(100) + " nanoseconds.");
		System.out.println("1,000 samples took " + timer(1000) + " nanoseconds.");
		System.out.println("10,000 s1amples took " + timer(10000) + " nanoseconds.");
		System.out.println("100,000 samples took " + timer(100000) + " nanoseconds.");
		System.out.println("500,000 samples took " + timer(500000) + " nanoseconds.");
	}
	
	public static long timer (double n)
	{
		long start = System.nanoTime();
		
		int sum = 0;
		
		for( int i = 0; i < n; i++ )
		{
			sum++;
		}
		
		long end = System.nanoTime();
		
		return end - start;
	}
}
