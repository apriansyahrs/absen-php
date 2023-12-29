# Absensi

## Demo
[Visit on YT](https://www.youtube.com/watch?v=3Sk-jFOjJw0)

## Requirments
- PHP version 7.2
- MySQL

## Version
This is version 3.2

## How to Install
- Import database where the file is in the database folder.
- Change base url on database -> settings -> baseUrl.
- Change the base url in the baseurl.txt file in the root of the special project version 2 and above.

## How to set clock
- Change `date_default_timezone_set` in `config.php` file and `jam-sekarang.php`.
- For version 3.2 and above just change the `timezone.php` file.

### Notes
Especially for version 3 and above, run cronjob for leave. `cronjob/cuti.php` is recommended to run once a day, can be 2, 3 or more times a day (optional). The script is error-free.