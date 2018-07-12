core/Db.php - connection to the database.
statusChecker.php must be on crontab */5 * * * *.
smsGateway/smsc_api.php - 4-5 lines is a login and pass on sms gateway smsc.ru.
requestHandler/DispenserViking.php - 414 line is path to firmware.
With huge amount of data you need to create indexes in logs table or use partitioning.