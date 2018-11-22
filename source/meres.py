import sys
import Adafruit_DHT
#import pip
#pip.main(['install','mysql-connector-python-rf'])
import mysql.connector as mariadb
import Logic.TwitterLogic as tw
import Logic.DatabaseLogic as db
import Logic.DisplayLogic as di


print("Start app")
tw.SendMessage("Elindult az alkalmazás!")
station='station1'
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


db.SaveToDatabase(station,temperature,humidity)
di.ShowText('Homer.: {0:0.1f}*C'.format(temperature),'Parat.: {0:0.1f}%'.format(humidity))






