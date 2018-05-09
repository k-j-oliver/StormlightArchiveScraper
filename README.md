### [Kathleen Oliver](https://k-j-oliver.github.io)
April 2018.

This project was built as part of the HuCo 617: Advanced Web Scripting course at University of Alberta. The project used PHP, MySQL, JavaScript, and the D3 library. The purpose was to experiment with building a program that integrated PHP and JavaScript, and turned into an exploration of data collection and management. No research question was posed to be answered by this data, although that potential certainly exists. You can view it [here](http://hucodev.artsrn.ualberta.ca/oliver2/scraper/scraper.php), and the code by clicking "view on GitHub" above.    

Examples follow to demonstrate how data was scraped and the database was built.  

This scraper collected biographical data from each character entry in this fan-made wikia page: [Stormlight Archive Wikia](http://stormlightarchive.wikia.com/wiki/Category:Characters), the red squares indicate what data was being collected: 

![CharacterPage](https://k-j-oliver.github.io/StormlightArchiveScraper/CharacterPage.png)  


###The `gender` and `name` tables hold all genders and names inputted by participants:  
```
+-----------+----------------+  
| gender_id | gender         |  
+-----------+----------------+  
|         1 | Male           |  
|         2 | Female         |  
|         3 | NULL           |  
|         4 | Male (assumed) |  
|         5 | Unknown        |  
+-----------+----------------+  

+---------+------------------------------+  
| name_id | name                         |  
+---------+------------------------------+  
|       1 | Abrial                       |  
|       2 | Abrobadar                    |  
|       3 | Abronai                      |  
|       4 | Adis                         |  
|       5 | Adolin Kholin                |  
|       6 | Adrotagia                    |  
|       7 | Aesudan Kholin               |  
|       8 | Alabet                       |  
|       9 | Aladar                       |  
|      10 | Alakavish                    |  
```


###The second script is run using the character ID from initial scrape to build the various relationship tables. Here is the `characters_gender` table:
```
+---------------------+--------------+----------------+
| character_gender_id | character_id | gender         |
+---------------------+--------------+----------------+
|                   1 |            1 | Male           |
|                   2 |            2 | Male           |
|                   3 |            3 | Male           |
|                   4 |            4 | Male           |
|                   5 |            5 | Male           |
|                   6 |            6 | Female         |
|                   7 |            7 | Female         |
|                   8 |            8 | Male           |
|                   9 |            9 | Male           |
|                  10 |           10 | Male           |
```


###From this, we can ask MySQL how many characters are female, giving us data to fill the bar chart visualization: 
```
SELECT COUNT(character_id) AS NumberOfCharacters, gender FROM characters_gender WHERE gender = 'Female';
+--------------------+--------+
| NumberOfCharacters | gender |
+--------------------+--------+
|                106 | Female |
+--------------------+--------+
```

###Here is the JSON encoded result, used for the bar chart visualizations:
`[{"NumberOfCharacters":"316","gender":"Male"},{"NumberOfCharacters":"106","gender":"Female"},{"NumberOfCharacters":"2","gender":"NULL"},{"NumberOfCharacters":"1","gender":"Male (assumed)"},{"NumberOfCharacters":"1","gender":"Unknown"}]`


Files:
- Testdrive.php creates the single-entity table with object-oriented progamming. Methods found in Property.php.  
- Testdrive2.php creates the relationships tables and is procedurally based.  
- Scraper.php is the webpage.  
- getData.php is used with library.js to listen to user's click, do the query, and display the results.  
- library.js also contains the D3 library and builds visualizations.  
- JSON files included.  
- Classses included. 
