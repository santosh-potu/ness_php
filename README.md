# Summary #

You will be parsing data out of files that contain items from a store. The items file can come in 2 different formats - CSV or a custom file format called NL. After parsing the data out of files, you should be able to retrieve specific pieces of the data, described later. Note that you are NOT being asked to store these in a database, it should just reside in the program's memory. 

# Business requirements #

This should be a command line application that performs many tasks based on the data in a file. The following is a list of things that can be passed to the application on the command line and what should be returned. See the format reference below for how to visually display the results.

## Commands ##

### Find item by ID ###

Command: `<file> find-by-id <id>`  
Example: `items.csv find-by-id 68-OX-YH94`  
Displays the item with the given id in the given file.

### Find all items in file ###

Command: `<file> find-all`  
Example: `items.nl find-all`  
Displays all items in the given file.

### Find items by category ###

Command: `<file> find-by-category <category>`  
Example: `my-items.csv find-by-category green`  
Displays all items that have the given category in the given file.

**In all the above examples, the term *items* refers to valid items only (described in the data format section). Invalid items may be skipped completely, and you may assume no application would ever need to retrieve invalid items.**

## Display format ##

Use the following format for displaying results from the command line application.

	<id> <name> (<quantity>)
	- <category 1>
	- <category 2>
	- <category n...>

Example:  

	68-OX-YH94 Carrot (5)
	- vegetable
	- green
	- orange
	- skinny

- If printing multiple items, separate each one by a new line.
- If there are no categories, just print the first line only (e.g.	`68-OX-YH94 Carrot (5)`)
- For ALL commands, if nothing meets the criteria, output `No results found.`.
- Each command should print a newline at the end to make the following console prompt more readable.

# Guarantees #

- You may assume the format of a file solely based on the extension. If `filename.nl` is passed in to the command line tool, it is a valid NL file. If `filename.csv` is passed in, it is a CSV file.
- Your parser may assume that the file format itself is valid. For CSVs, there will always be 4 fields per line, and each line will be a valid comma-delimited line. For NL files, each item will be represented on 4 lines, even if the fields are blank.
- You may assume that a file, including the items parsed out of it, will fit in memory. Feel free to keep all items in memory. 
- You may assume that the primary source of all items is a single file. You don't have to architect your application in a way that would expect to read from 2 different item data files in its execution lifetime.

# Code Design guidelines #

- Other applications will need to use your code. You may assume that we are just going to drop the source code directly in a project to use it.
- You are free to design this program however you want. As long as it achieves the above goals, it works. The only thing to remember is to design this to be as flexible as possible. Write your code with the following in mind:
    - It should be written as a library so other codebases may use it however they wish. Not everyone is going to want to print the results to screen. One day we may use this code to build a REST web service, generate reports from the data, or display the data on web pages.
    - It should be designed so multiple queries can be run against the same file efficiently. For example, someone may ask for two items by id, three items by category, and then all items grouped by category, one after another. It would not be a good idea to reparse the file for each request. 
    - It should be written in a way that anticipates other file formats down the line. You can assume that the same fields and data will come through, but imagine the data could come in as XML, JSON, or some other custom format. Adding a new file format should require as little refactoring of the codebase as possible.
	- It should be written in a way that anticipates the commands being fulfilled by a source other than a file. Maybe in the future the data comes from a database or a web service. It would be useful to be able to swap out the implementation with as little refactoring of the codebase as possible.
- Use comments as appropriate.
- Your code should of course be able to parse other files besides just the example files provided.

(To be clear, the concrete examples given in the above list are **not** to be implemented by you, but you should design your code in a way such that it would be easy for someone to come in and do that.)

# Extra tasks #

Do the following for extra brownie points. These are fully optional. Do as many or as few as you want.

- Add a way to automatically run the included examples in the folder. It should verify that your program's output matches the expected output.
- Unit test your code.
- Add the following command:

Command: `<file> group-by-category`  
Example: `my-items.nl group-by-category`  
Displays all items grouped by their category.

Display format:

	<category 1>
	- <id> <name> (<quantity>)
	- etc..
	
	<category 2>
	- <id> <name> (<quantity>)
	- etc..

Example:
	
	vegetable
	- 68-OX-YH94 Carrot (5)
	- 61-Op-NH61 Onion (2)
	- 62-IX-Yx08 Broccoli (4)

	hair care
	- 68-OX-YH11 Shampoo (2)
	- 61-Op-NH00 Conditioner (1)


# The data format #

As mentioned earlier, items may come in as either CSV or NL files. The item format will be described using a CSV file as an example, then a NL example will be provided.

Here is an example line from a csv file:

    68-OX-YH94,Carrots,5,vegetable;green;orange

Here is a list of fields in the csv, in order, and what data is expected of them:

### id ###

Format: `DD-LL-LLDD`, where `D` is a digit and `L` is a letter (a-z). Uppercase and lowercase letters are both accepted.  
Additional restrictions: Once you read in an id, that is the only item that may have that id. If you find another item later in the file with the same id, only the first item should be read in, and the other(s) discarded.  
Can be blank: No

Valid examples:

- `68-OX-YH94`
- `02-Mn-Oz31`
- `32-oi-xi19`

Invalid examples:

- `68OX-YH94` *(dashes need to be there)*
- `6N-OX-YHZ4` *(used a character where a number is expected in the first segment)*
- `68-OX-YH9` *(last segment is too short)*
- `68-OX-Y@94` *(used a symbol where a letter is expected in the third segment)*

### name ###

Format: A string that is at least 1 character long.  
Can be blank: No

Valid examples:

- carrot
- c
- my cool %% item &) *(symbols are valid)*

### quantity ###

Format: Positive, non-zero integer.    
Can be blank: No

Valid examples:

- 6
- 1
- 4654626

Invalid examples:

- 0 *(should be greater than 0)*
- -3 *(should be positive)*
- 1.5 *(should be an integer)*

### categories ###

Format: List of strings delimited by semicolons. May be 0 or more categories. An individual category may be blank, which means it's skipped.  
Can be blank: Yes, if this field is blank that means the item has no categories.

Valid examples:

- foo *(item has one category, foo)*
- foo;bar biz;baz *(item has three categories)*

Invalid examples:

- foo;;bar *(middle category is blank so it's skipped - the item is considered to have 2 categories. See note below.)*


### How to handle validity ###

If any of the fields you parse out for an item violate the rules, the entire item is considered invalid and should be skipped. The big exception to this is categories. If a category is blank, the *category* is skipped, but the item is still considered valid (see the "invalid examples" for categories above).

### NL file format ###

The nl file should have items parsed out of it by applying the exact same rules as above. It contains the same data. 

Here is an example of a 2-line CSV file and the equivalent NL file:

**CSV**

	68-OX-YH94,Carrots,5,vegetable;green;orange
	68-OX-ZH25,Yogurt,2,cold;yummy

**NL**

	68-OX-YH94
	Carrots
	5
	vegetable;green;orange
	68-OX-ZH25
	Yogurt
	2
	cold;yummy

Each item always spans 4 lines, with a field on each line. 

# Included files #

`items.nl` and `items.csv` are the files you may test with. They contain all of the exceptional scenarios described above, like invalid ids, duplicate items, empty categories, and so on. Both files contain the same items.

`items.csv-key` is a handy file that matches up line-by-line with the `items.csv` file and mentions whether or not each item is valid according to the rules above. If an item is invalid there is a sentence describing why.

There is an `examples` folder to show example input and output to your command line application. The name of the file minus the `txt` extension is the arguments to be passed to the app. The content of the file is the exact expected output. No matter which format of the test file is passed into your app, it should generate the same output.
