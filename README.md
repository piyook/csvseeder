
<!-- PROJECT LOGO -->
<br />
<p align="center">

  <h3 align="center">CSV Database Seeder Utility Service</h3>

  <p align="center">
    A simple Laravel utility package to seed database tables with CSV data.
    <br />
    <a href="https://github.com/piyook/laravelcsvseed"><strong>Explore the docs »</strong></a>
    <br />
    <br />
  </p>
</p>



<!-- TABLE OF CONTENTS -->
<details open="open">
  <summary><h2 style="display: inline-block">Table of Contents</h2></summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#usage">Usage</a></li>
    <li><a href="#contact">Contact</a></li>
  </ol>
</details>

<br/>
<br/>

<!-- ABOUT THE PROJECT -->
## About The Project
<br/>
A simple utility for Laravel that allows a database to be quickly populated using data from a file in CSV format. <br/>  <br/>

A custom Artisan make: command builds the CSV seeder class which then imports data from a CSV file stored in database/data folder.
<br/>
<br/>
### Built With

* Laravel 9   
<br/>

## Getting Started
<br/>
The code can be added to a fresh Laravel install or an existing project.
<br/>
<br/>

### Prerequisites

Laravel 8+
<br/>
<br/>

### Installation
<br/>

The package is in Beta at the moment so install using Composer directly from this repo by updating your composer.json file as below (adding to the existing require-dev packages). 

```sh
    composer require --dev piyook/csvseeder
```



## Usage

<br/>
A custom Artisan make command was developed to make scaffolding a Seeder Class to import CSV files easier.
<br/><br/>

The CSV data file **must share the same name as the table and be stored in a database/data folder.**<br/><br/>

To use the Artisan command simply type :<br/><br/>

 ```sh
  php artisan make:csvseeder <name> <columns> <path> (optional)
  ``` 
<br/>


Where the table name to be seeded is passed to the make command along with an ARRAY of column names []. 
<br/>
Note that if the table name is plural then the singular form will be used for the class name<br/><br/>

If the seeder class is to be stored in a location OTHER than database/seeders then you can specify this new path as the final option.
<br/>

**E.g A new Seeder Class for a table called "examples" which will import from the "examples.csv" file held in database/data, will be saved to the database/seeders directory with the filename "ExampleCSV.php".** <br/>

<br/>

  ```sh
    php artisan make:csvseeder examples [col1,col2,col3,col4]
  ```
then 

  ```sh
  php artisan migrate:fresh

  php artisan db:seed --class=ExampleCSV
  ``` 
  <br/>

**DONT FORGET TO REGISTER THE NEW CSV SEEDER IN THE DatabaseSeeder CLASS IN THE SEEDERS FOLDER BEFORE RUNNING A GENERAL DB SEED AS PART OF A MIGRATION WITH THE --SEED OPTION**
<br/>
<br/>

## Testing
<br/>

Orchestra Testbench would normally used to run unit and feature tests in the package but the seeder function would not seem to work in orchestra (the seeder class was not being found).


Instead a full seperate Laravel test project was created and the tests, phpunit.xml and the database/data, database/migration folders and files copied into the relevant places in the framework to set up the test environment.

All Feature tests then work running with Artisan test command.

## Contact

<br/>
Email: piyook@piyook.com
<br/><br/>
Project Link: 
[laravelcsvseed] <https://github.com/piyook/laravelcsvseed>


