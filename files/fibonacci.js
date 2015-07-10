/*
	* Copyleft (ↄ) 2015 Hussain Khalil
	* You are free to reuse, modify, and redistribute in any way, granted that you release it under the same terms.
	* This script finds the sum of all even Fibonacci numbers less than 4 million (4 x 10^6), or any other number defined by the variable `max`;
	* It then outputs this to the standard output (stdout) using console.log().
*/

// Initialization of variables

// Max number
var max = 4 * Math.pow(10, 6);

// Contains numbers
var int = [];

// Current fibonacci number
int[0] = 0;

// Previous fibonacci number
int[1] = 1;

// Two prior number
int[2] = 1;

// Total value so far
var total = 0;

// Main while loop
while(int[1] + int[2] < max) {

	// Add previous two numbers
	int[0] = int[1] + int[2];

	// Check if current number is even
	if(int[0]%2 === 0) {

		// Add number to total
		total += int[0];

	}

	// Move to next set of numbers
	int[2] = int[1];
	int[1] = int[0];

}

// Output result
console.log(total);
