# PlymBB
This project started off as my final project for my foundation year at University.

* The only changes to the code since the assignment was handed in are making it compatible with PHP 8.1 (the demo site runs on PHP 8.1.11 currently).
* The admin panel will not be available on the demo site. If you wish to use it, please download a copy of the code from this repo and test it on your own local setup.
* The database structure can be found within plymbb.sql.
* Database connection settings can be set under config.php.

You can find the live site at: https://demo.dburridge.com/plymbb/

I am happy to support people who wish to use this code for education. I also accept feedback on improving the code and improving myself. Please note that apart from
the small changes to make the code work with PHP 8.1, I have not looked at this code since 2018. I may update this application occasionally with some additional features I did
not have time to create for the initial project.

I achieved 76% (a first) for this project and the module.

## About PlymBB
PlymBB is a basic Bulletin Board system made in PHP. It supports user registration, login, posting and replying to topics. There is an admin panel, but at this time it is limited to
only being able to add new categories.

User registration requires an email but does not require validation at this time.

Passwords are hashed using PHP's password_hash function.

## Credits
* TinyMCE: https://www.tiny.cloud/tinymce/
* Bootstrap (v4): https://getbootstrap.com/
