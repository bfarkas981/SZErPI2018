import sys
import Adafruit_DHT
#import pip
#pip.main(['install','mysql-connector-python-rf'])
import mysql.connector as mariadb

print("Start app")
station='Balazs'
humidity=-1
temperature=-1

try:
    sensor = Adafruit_DHT.DHT22
    pin=22
    humidity, temperature = Adafruit_DHT.read_retry(sensor,pin)
    if humidity is not None and temperature is not None:
        print('Temp={0:0.1f}*C Humidity={1:0.1f}%'.format(temperature,humidity))
    else:
        print('Error')
except:
    print('Error2')


try:
    print("Save to database...")
    mariadb_connection = mariadb.connect(user='user1',
                                     database='db1')
    cursor = mariadb_connection.cursor()
    #insert information
    try:
        cursor.execute("INSERT INTO mensuration (sender_id,mensuration_TS,temperature,humidity) VALUES (%s,now(),%s,%s)", (station,temperature,humidity))
    except mariadb.Error as error:
        print("Error: {}".format(error))
    mariadb_connection.commit()
    mariadb_connection.close()
    print(">>> OK!")
except mariadb.Error as error:
    print("Error: {}".format(error))





