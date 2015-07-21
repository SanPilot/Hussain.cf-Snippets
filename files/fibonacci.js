/*
	* Copyleft (ↄ) 2015 Hussain Khalil
	* You are free to reuse, modify, and redistribute in any way, granted that you release it under the same terms.
	* This script finds the sum of all even Fibonacci numbers less than 4 million (4 x 10^6), or any other number defined by the variable `max`;
	* It then outputs this to the standard output (stdout) using console.log().
*/

// Begin timer
var start = new Date().getMilliseconds();

// For end time
var end = 1;

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

// Function to add commas
var addCommas = function(nStr)
{
	nStr += '';
	var x = nStr.split('.');
	var x1 = x[0];
	var x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}

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
console.log(addCommas(total));

// Output total execution time
end = new Date().getMilliseconds() - start;

console.log("Finished in " + end / 1000 + "s");
