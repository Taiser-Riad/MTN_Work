Project Description
Oracle SQL Project

This project provides a comprehensive solution for managing and updating cellular network site information. It includes functionalities for searching, retrieving, and updating site details across multiple generations of cellular networks (2G, 3G, 4G).

Key Features:

Search and Retrieve Site Information: Users can search for site codes and retrieve detailed information about various cellular sites.

Multi-Generation Support: Handles data for 2G, 3G, and 4G networks, with specific PHP scripts for each generation (e.g., delete2G.php, update3G.php).

Dynamic Form Processing: Processes form inputs based on user selections for different cell configurations.

Error Handling: Includes scripts like handel_errors.js for managing errors gracefully.

Configuration Management: Utilizes configuration files such as config.php and listener.ora for setup and management.

File Structure:
index.php: Main script to handle form submission and update cell information.

thankyou.php: Page displayed after successful data update.

listener.ora: Oracle listener configuration file.

scripts.js: JavaScript functions for form handling and window control (if needed).

HTML, CSS, and JavaScript: Front-end components for user interaction.

PHP Scripts: Backend processing and database interaction (index.php, config.php, etc.).

Images: Visual assets (img1.jpg, MTN-Logo.png).


Dependencies:
Oracle Database

PHP

JavaScript

Usage:
Setup the Database: Ensure the Oracle database is configured and running.

Configure Environment Variables: Set the necessary environment variables, such as ORACLE_HOME.

Deploy the Application: Place the PHP scripts on a web server and access the application via a web browser.

Perform Updates: Use the form to search for and update cell information.

Contributing:
Contributions are welcome! Please fork the repository and submit a pull request.

License:
This project is licensed under the MIT License.
