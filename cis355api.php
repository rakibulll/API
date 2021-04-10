<?php
/*
	filename 	: cis355api.php
	author   	: Rakibul Hassan
	course   	: CIS355 (Winter2021)
	description	: demonstrate JSON API functions
				  return number of new covid19 cases
	input    	: https://api.covid19api.com/summary
	functions   : main()
	                curl_get_contents()
*/

main();

#-----------------------------------------------------------------------------
# FUNCTIONS
#-----------------------------------------------------------------------------
function main()
{

    $apiCall = 'https://api.covid19api.com/summary';

    //Getting all death into an array
    $json_string = curl_get_contents($apiCall);
    $obj = json_decode($json_string);

    $data = Array();

    foreach ($obj->Countries as $i)
    {
        $data[$i->Country] = $i->TotalDeaths;
    }

    //Desecending order
    arsort($data);

    echo '<html>';
    echo '<head>';
    echo '<title>COVID-19 API</title>';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
    echo '<style>';
    echo "table {
        border: 1px solid black;
          border-collapse: collapse;
        }
        th, td {
			border: 1px solid black;
	  	}";
    echo '</style>';
    echo '</head>';

    echo '<body onload="loadDoc()">';

    //Top 10 list
    $data = array_slice($data, 0, 10);

    $JSONString = json_encode($data, JSON_PRETTY_PRINT);
    $JSONObject = json_decode($JSONString);

    echo '<h2>JSON Object</h2>';
    echo var_dump($JSONObject);
    echo '<br><br>';

    //HTML Table
    echo "<div><h2>Table</h2>";
    echo "<table>";
    echo "<tr>";
    echo "<th>Country Name</th>";
    echo "<th>Number of Deaths Cases</th>";
    echo "</tr>";
    foreach ($data as $country => $cases)
    {
        echo "<tr>";
        echo "<td>{$country}</td>";
        echo "<td>{$cases}</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo '</div>';

    echo ' <br><br> <a target="_blank" href="https://github.com/rakibulll/API/blob/master/cis355api.php">Github Source Code</a>';

    echo '</body>';
    echo '</html>';
}

#-----------------------------------------------------------------------------
// read data from a URL into a string
function curl_get_contents($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
?>
