<?php

/**
 * Use this file to output reports required for the SQL Query Design test.
 * An example is provided below. You can use the `asTable` method to pass your query result to,
 * to output it as a styled HTML table.
 */

$database = 'nba2019';
require_once('vendor/autoload.php');
require_once('include/utils.php');

/*
 * Example Query
 * -------------
 * Retrieve all team codes & names
 */
echo '<h1>Example Query</h1>';
$teamSql = "SELECT * FROM team";
$teamResult = query($teamSql);
// dd($teamResult);


echo asTable($teamResult);

/*
 * Report 1
 * --------
 * Produce a query that reports on the best 3pt shooters in the database that are older than 30 years old. Only 
 * retrieve data for players who have shot 3-pointers at greater accuracy than 35%.
 * 
 * Retrieve
 *  - Player name
 *  - Full team name
 *  - Age
 *  - Player number
 *  - Position
 *  - 3-pointers made %
 *  - Number of 3-pointers made 
 *
 * Rank the data by the players with the best % accuracy first.
 */
echo '<h1>Report 1 - Best 3pt Shooters</h1>';
// write your query here

$teamSql_report1 = "SELECT `roster`.name as 'Player Name'
                            , `team`.`name` as 'Full team name'
                            , `player_totals`.`age` as Age
                            ,`roster`.number as 'Player Number'
                            ,`roster`.pos as 'Position' 
                            , CONCAT(ROUND((`player_totals`.`3pt`) / (`player_totals`.`3pt_attempted`) * 100,2),'%') as '3-pointers made %'
                            ,`player_totals`.`3pt` as 'Number of 3-pointers made' 
                    FROM `team` 
                    LEFT JOIN `roster` ON team.code = roster.team_code 
                    LEFT JOIN `player_totals` ON roster.id = player_totals.player_id
                    WHERE player_totals.age > 30 and (`player_totals`.`3pt`) / (`player_totals`.`3pt_attempted`) > 0.35"
                ;
$teamResult_report1 = query($teamSql_report1);
echo asTable($teamResult_report1);

/*
 * Report 2
 * --------
 * Produce a query that reports on the best 3pt shooting teams. Retrieve all teams in the database and list:
 *  - Team name
 *  - 3-pointer accuracy (as 2 decimal place percentage - e.g. 33.53%) for the team as a whole,
 *  - Total 3-pointers made by the team
 *  - # of contributing players - players that scored at least 1 x 3-pointer
 *  - of attempting player - players that attempted at least 1 x 3-point shot
 *  - total # of 3-point attempts made by players who failed to make a single 3-point shot.
 * 
 * You should be able to retrieve all data in a single query, without subqueries.
 * Put the most accurate 3pt teams first.
 */
echo '<h1>Report 2 - Best 3pt Shooting Teams</h1>';
// write your query here
$teamSql_report2 = "SELECT `team`.name as 'Team Name' 
                            ,CONCAT(ROUND((`player_totals`.`3pt`) / (`player_totals`.`3pt_attempted`)* 100, 2),'%') AS '3-Pointer accuracy'
                            ,SUM(`player_totals`.`3pt`) AS 'Total 3-pointers made' 
                            ,SUM(CASE WHEN `player_totals`.`3pt` > 0 THEN 1 ELSE 0 END) As '# of contributing players' 
                            ,SUM(CASE WHEN `player_totals`.`3pt_attempted` > 0 THEN 1 ELSE 0 END) As '# of attempting players' 
                            ,SUM(CASE WHEN `player_totals`.`3pt_attempted` > 0 AND `player_totals`.`3pt` <= 0 THEN 1 ELSE 0 END) As 'total # of 3-point attempts made by players who failed to make a single 3-point shot' 
                    FROM `team` LEFT JOIN `roster` ON team.code = roster.team_code 
                    LEFT JOIN `player_totals` ON roster.id = player_totals.player_id 
                    GROUP BY `team`.name;


";
$teamResult_report2 = query($teamSql_report2);
echo asTable($teamResult_report2);



?>