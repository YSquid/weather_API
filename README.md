# Get weather API

This simple web app uses the [OpenWeatherMap API](https://openweathermap.org/api) to fetch weather data and display it.

## Requirements

1. A local PHP development environment with XML support enabled such as a Linux environment, or Windows utilizing XAMPP. [Here is a helpful article on setting up a PHP development environment on Ubuntu](https://www.digitalocean.com/community/tutorials/how-to-install-php-7-4-and-set-up-a-local-development-environment-on-ubuntu-20-04)

2. Composer package manager installed. [How to install composer on Ubuntu](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-composer-on-ubuntu-20-04)

3. An API key from [OpenWeathrMap](https://openweathermap.org/api) - free option is available

## Installation

1. Clone or download the repository

2. Open a terminal to the project directory and run `composer install`

3. Create a .env file in the root directory and input your API key. See the example.env to see how it should look

3. In the terminal run `php -S localhost:8087` to start on a local browser on port 8087

4. View the app at http://localhost:8087/

## Features

Has the ability to select from 6 Western Canadian Citites

Displays the following information:
- temperature in celcius
- windspeed in m/s and degree direction
- humidity percentage