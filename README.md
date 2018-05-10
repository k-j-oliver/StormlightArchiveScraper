April 2018.

This project was built as part of the HuCo 617: Advanced Web Scripting course at University of Alberta. The project uses PHP, MySQL, JavaScript, and the D3 library. The purpose was to experiment with building a program that integrated PHP and JavaScript, and turned into an exploration of data collection and management. No research question is posed to be answered by this data, although that potential certainly exists. You can view it [here](http://hucodev.artsrn.ualberta.ca/oliver2/scraper/scraper.php), and the code by clicking "view on GitHub" above.    

Examples follow to demonstrate how data is scraped and the database is built.  

This scraper collects biographical data from each character entry in this fan-made wikia page: [Stormlight Archive Wikia](http://stormlightarchive.wikia.com/wiki/Category:Characters), the red squares indicate what data is collected: 

![CharacterPage](https://k-j-oliver.github.io/StormlightArchiveScraper/CharacterPage.png)  

### Data structure
Deciding how to structure the data was a task. In the first iteration the scraper built a single table to hold all of the data. This was not ideal, however, because some fields had multiple data. In the character page above, for instance, Kaladin is associated with multiple books. Trying to separate these books while maintaining a single table was difficult and impractical.  
I decided to create single tables for each piece of data being collected (the red squares), and to control the relationship tables with the character id attached to the character url. 

__`gender` table:__  
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
```
__`characters` table:__  
```
+--------------+-----------------------------------------------------------------------+
| character_id | character_url                                                         |
+--------------+-----------------------------------------------------------------------+
|            1 | http://stormlightarchive.wikia.com/wiki/Abrial                        |
|            2 | http://stormlightarchive.wikia.com/wiki/Abrobadar                     |
|            3 | http://stormlightarchive.wikia.com/wiki/Abronai                       |
|            4 | http://stormlightarchive.wikia.com/wiki/Adis                          |
|            5 | http://stormlightarchive.wikia.com/wiki/Adolin_Kholin                 |
|            6 | http://stormlightarchive.wikia.com/wiki/Adrotagia                     |
|            7 | http://stormlightarchive.wikia.com/wiki/Aesudan_Kholin                |
|            8 | http://stormlightarchive.wikia.com/wiki/Alabet                        |
|            9 | http://stormlightarchive.wikia.com/wiki/Aladar                        |
|           10 | http://stormlightarchive.wikia.com/wiki/Alakavish                     | 
...
```
This data is rather flat without relationship tables. Building these relationships requires a second scraper to iterate through the character pages again to match data fields to character id. An example of gender follows, which has a straight forward many-to-one relationship. I also include a snippet from the `books` table: a many-to-many relationship.  

__`characters_gender` table:__
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
...
```
__`characters_book` table:__  
```
+-------------------+--------------+---------------------------------+
| character_book_id | character_id | book                            |
+-------------------+--------------+---------------------------------+
|                 1 |            1 | Words of Radiance (mentioned)   |
|                 2 |            2 | NULL                            |
|                 3 |            3 | NULL                            |
|                 4 |            4 | NULL                            |
|                 5 |            5 | The Way of Kings                |
|                 6 |            5 | Words of Radiance               |
|                 7 |            5 | Oathbringer                     |
|                 8 |            6 | NULL                            |
|                 9 |            7 | The Way of Kings (mentioned)    |
|                10 |            7 | Words of Radiance (mentioned)   |
|                11 |            7 | Oathbringer                     |
|                12 |            8 | NULL                            |
|                13 |            9 | The Way of Kings                |
|                14 |            9 | Words of Radiance               |
|                15 |            9 | Oathbringer                     |
|                16 |           10 | NULL                            |
...
```
Looking at `character_id` 7, we see it has 3 books associated with it.  

With this data structure, we can query the tables to find how many characters are male, female, or unknown. Or we can find how many characters are in each book. Going further, we can combine tables to ask something like, "how many characters are female in _Words of Radiance_?" and perhaps compare that result to a later book.  

__Querying:__ 
```
SELECT COUNT(character_id) AS NumberOfCharacters, gender FROM characters_gender WHERE gender = 'Female';
+--------------------+--------+
| NumberOfCharacters | gender |
+--------------------+--------+
|                106 | Female |
+--------------------+--------+
```

__JSON encode:__  
`[{"NumberOfCharacters":"316","gender":"Male"},{"NumberOfCharacters":"106","gender":"Female"},{"NumberOfCharacters":"2","gender":"NULL"},{"NumberOfCharacters":"1","gender":"Male (assumed)"},{"NumberOfCharacters":"1","gender":"Unknown"}]`

### Areas for improvement
- Given the nature of user-generated content, some data is still not in an ideal format. Most notable are the bracketed qualifiers, i.e. "Male (assumed)" or "Words of Radiance (mentioned)". This can be improved by creating an additional field in the tables to hold this bracketed information. Early attempts at this proved more difficult than imagined, running into issues with my `regex`. 
- The "status" data is an imperfect system. The field does not capture _when_ the character dies or is alive. Although a character may be dead in the third book, they were still alive in the first or second. The fix would be to go into the wikia's history and capture when the status was changed, cross-referencing that with which book is also added (hopefully). 
- User-generated content is not precise or perfect, although the peer-reviewed nature of wiki's encourages a level of accuracy. 
- D3 visualizations could be made smarter by passing variables; currently each graph has its own repeated code. 
- JSON data could be passed more effectively; currently saving to a file to be read later by the D3 code.

### Files:
- Testdrive.php creates the single-entity table with object-oriented progamming. Methods found in Property.php.  
- Testdrive2.php creates the relationships tables and is procedurally based.  
- Scraper.php is the webpage.  
- getData.php is used with library.js to listen to user's click, do the query, and display the results.  
- library.js also contains the D3 library and builds visualizations.  
- JSON files included.  
- Classses included. 
