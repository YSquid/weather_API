<?php
//require vendor packages into file
require_once('vendor/autoload.php');

//create instance of immutable dotenv instance and load it into file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// use dependencies - see their namesapce at top of respective file to get the paths
use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\Exception as OWMException;
use Http\Factory\Guzzle\RequestFactory;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
?>
<html>

<body>
    <h1>Weather query</h1>
    <?php
    // check the php superglobal SERVER['REQUEST_METHOD'] for post - strtolower to normalize - if post has been done, get our weather data
    if ('post' === strtolower($_SERVER['REQUEST_METHOD'])) {
        $city = $_POST['city'];
        //create OpenWeatherMap instance - 3 options - API key, http client implementation, and http request factory
        $owm = new OpenWeatherMap($_ENV['API_KEY'], GuzzleAdapter::createWithConfig([]), new RequestFactory());
        try {
            //weather object - call to the owm object's getWeather method
            $weather = $owm->getWeather($city, 'metric', 'en');
            // getting values from weather object
            $temperature = $weather->temperature;
            $windspeed = $weather->wind->speed;
            $winddirection = $weather->wind->direction;
            $humidity =  $weather->humidity;

            //print to the screen - the temperature key on the weather object
    ?>
            <h1><?= $city ?></h1>
            <h2>Temperature: <?php echo  $temperature ?></h2>
            <h2>Wind: <?php echo $windspeed . " " . $winddirection ?></h2>
            <h2>Humidity: <?php echo $humidity ?></h2>
            <!-- simple return to homepage - since anything besides post returns homepage, any get request will return it -->
            <form method="get">
                <button type="submit">Return to home</button>
            </form>
        <?php
        //handling openweathermap specific exceptions
        } catch (OWMException $e) {
            echo 'OpenWeatherMap exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
        // handling general exceptions
        } catch (\Exception $e) {
            echo 'General exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
        }
        //if method is not post, return the form to select our city, and post it on submit
    } else {
        ?>
        <form method="post">
            <label for="city">Select your city</label>
            <select name="city" id="city">
                <option value="Calgary">Calgary</option>
                <option value="Edmonton">Edmonton</option>
                <option value="Regina">Regina</option>
                <option value="Saskatoon">Saskatoon</option>
                <option value="Vancouver">Vancouver</option>
                <option value="Winnipeg">Winnipeg</option>
            </select>
            <input type="submit" value="Get your city's temperature">
        </form>
    <?php
    }
    ?>
</body>

</html>