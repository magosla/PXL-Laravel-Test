# Interview	challenge
>>Write	a	process	that	imports	the	contents	of	a	JSON-file	cleanly	and	consistently	to	a	
database.

* Job class
```App\Jobs\DataFileProcessorTest```
* Entry Class: ```App\Services\DataFileProcessor\Processor```
* Running Test
```sail test```

The json file (challenge.json) for this challenge is stored in the data_file directory in the storage directory


## Solution to bonus 
>> <b>Question:</b> What	happens	when	the	source	file	grows	to,	say,	500	times	the	given	size?
This is an Android application that enable its users pen down their thoughts and feelings. It is a portable journal for everyday use.<br><br> <b>Answer:</b> To enable efficient use of system memory, I used a library called [Json Machine](https://github.com/halaxa/json-machine) to parse the Json file in place of PHP's own ```json_decode``` function. This would enable the parsing a larger files, fast and efficiently.

>> <b>Question:</b> Is	your	solution	easily	adjustable	to	different	source	data	formats	(CSV, XML, etc.)? <br><br> <b>Answer:</b> Yes it is. To be able to parse files in other format, a parser with class named in the file extension in Upper case (eg: to parse an xml files App\Services\DataFileProcessor\FileParsers\XML.php) that implements ```App\Services\DataFileProcessor\FileParsers\FileParserInterface``` is impemented.

>> <b>Question:</b> Say	that another data filter would be the requirement that the credit card number must have three identical	digits	in	sequence.	How	would	you	tackle	this? <br><br> <b>Answer:</b> I would Create a class that implements ```App\Services\DataFileProcessor\Filters\FilterInterface``` and define the filtering logic in that class whose instance would be provided when instantiating the ```App\Services\DataFileProcessor\Processor``` class.