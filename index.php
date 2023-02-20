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
if ( 'post' === strtolower($_SERVER['REQUEST_METHOD'])) {
    $city = $_POST['city'];
    //create OpenWeatherMap instance - 3 options - API key, http client implementation, and http request factory
    $owm = new OpenWeatherMap($_ENV['API_KEY'], GuzzleAdapter::createWithConfig([]), new RequestFactory());
    try {
        //weather object - call to the owm object's getWeather method
        $weather = $owm->getWeather($city, 'metric', 'en');
        //print to the screen - the temperature key on the weather object
        ?><h2><?php echo $weather->temperature; ?></h2>
        <?php
    } catch(OWMException $e) {
        echo 'OpenWeatherMap exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
    } catch(\Exception $e) {
        echo 'General exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
    }
    //if method is not post, return the form to select our city, and post it on submit
    } else {
    ?>
        <form method="post">
            <label for="city">Select your city</label>
            <select name="city" id="city">
                <option value="London">London</option>
                <option value="Buenos Aires">Buenos Aires</option>
                <option value="New York">New York</option>
                <option value="Paris">Paris</option>
            </select>
            <input type="submit" value="Get your city's temperature">
        </form>
    <?php
    }
    ?>
</body>

</html>